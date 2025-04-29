@extends('layout.general')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/ethers/dist/ethers.umd.min.js"></script>

    <div class="container">
        <header class="pb-3 mb-4 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-5 fw-bold"><i class="fas fa-scroll me-2"></i> Exchange</h1>
            </div>
            <!-- Navegación de pestañas -->
            <div class="nav-tabs-container mt-3">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php"><i class="fas fa-scroll me-1"></i> Exchange BSC</a>
                    </li>
                </ul>
            </div>
        </header>


        <div class="filter-section">
            <h1 style="margin-top: 20px;">Exchange</h1>
            <div class="input-group">
                <div style="position: relative;">
                    <img src="./styles/resource/images/usdt.png" alt="Moneda 1" class="currency-icon">
                    <input type="number" id="inputNumber" placeholder="Usdt">
                </div>
                <span class="icon">⇌</span>
                <div style="position: relative;">
                    <img src="./styles/theme/nsc/img/resources/921f.png" alt="Moneda 2" class="currency-icon">
                    <input type="number" id="outputNumber" placeholder="Aurium" readonly>
                </div>
            </div>
            <button onclick="swap()">Swap</button>
            <div class="commission" id="commission"></div>
        </div>

        <div id="walletContainer" style="margin-bottom: 20px;">
            <button id="connectMetaMask" style="padding: 10px 20px; font-size: 16px; cursor: pointer;"> <img src="./styles/resource/images/metamask-icon.png" alt="MetaMask Icon" style="width: 24px; height: 24px;">Connect MetaMask</button>


        </div>

        <!-- Tu código HTML para los filtros y los items aquí -->

        <script>
            const inputNumber = document.getElementById("inputNumber");
            const outputNumber = document.getElementById("outputNumber");
            const commissionText = document.getElementById("commission");
            const modal = document.getElementById('confirmationModals');
            const confirmButton = document.getElementById('confirmButton');
            const cancelButton = document.getElementById('cancelButton');

            var modo = 0;


            // Función para calcular el swap
            function calcularSwap() {
                const value = parseFloat(inputNumber.value);

                if (isNaN(value) || value <= 0) {
                    outputNumber.value = '';
                    commissionText.textContent = '';
                    return;
                }

                const commission = value * 0.05; // 5% de comisión
                const result = value - commission; // Resultado después de aplicar el 5%

                outputNumber.value = result.toFixed(2);
                commissionText.textContent = 'Se cobra una comisión del 5%: '+commission.toFixed(2);
            }

            // Agrega un listener para el evento "input"
            inputNumber.addEventListener("input", calcularSwap);

            async function swap(id) {
                const value = parseFloat(inputNumber.value);

                if (isNaN(value) || value <= 0) {
                    outputNumber.value = '';
                    commissionText.textContent = '';
                    return;
                }

                const commission = value * 0.05; // 5% de comisión
                const result = value - commission; // Resultado después de aplicar el 5%

                if (typeof window.ethereum === "undefined" || !window.ethereum.isMetaMask) {
                    alert("MetaMask no está instalado o no es el proveedor activo. Por favor, asegúrate de que MetaMask esté configurado correctamente.");
                    return;
                }

                $.post("game.php?page=store&mode=getSwap&amount=" + value, function(data) {
                    if (data.error) {
                        alert("Error: " + data.message);
                    } else {

                        setExchange(data.message,data.keyRand)
                    }
                }, "json"); // E

            }




            // Update the countdown every second
            //   setInterval(updateCountdown, 1000);

            // Initialize the countdown
            //   updateCountdown();

            if (typeof ethers === "undefined") {
                alert("ethers.js no está cargado correctamente.");
            } else {
                console.log("ethers.js cargado correctamente.");
            }

            const walletContainer = document.getElementById("walletContainer");
            const connectMetaMaskButton = document.getElementById("connectMetaMask");
            const popup = document.getElementById("popup");

            // Función para mostrar el popup
            function mostrarPopup() {
                $("#popup").css('display','block');
            }

            // Función para ocultar el popup
            function ocultarPopup() {
                $("#popup").css('display','none');
                //  popup.style.display = "none";
            }
            function mostrarModal() {
                $("#confirmationModal").css('display','block');
            }

            // Función para ocultar el popup
            function ocultarModal() {
                $("#confirmationModal").css('display','none');
                //  popup.style.display = "none";
            }
            // Detectar si MetaMask ya está conectada
            async function checkMetaMaskConnection() {
                if (typeof window.ethereum !== "undefined" && window.ethereum.isMetaMask) {
                    try {
                        const chainId = "0x38"; // ID de la red BSC en hexadecimal (56 en decimal)

                        // Verificar si el usuario ya está en la red BSC
                        const currentChainId = await ethereum.request({ method: "eth_chainId" });
                        if (currentChainId !== chainId) {
                            try {
                                // Solicitar al usuario que cambie a la red BSC
                                await ethereum.request({
                                    method: "wallet_addEthereumChain",
                                    params: [
                                        {
                                            chainId: chainId,
                                            chainName: "Binance Smart Chain",
                                            nativeCurrency: {
                                                name: "Binance Coin",
                                                symbol: "BNB",
                                                decimals: 18,
                                            },
                                            rpcUrls: ["https://bsc-dataseed.binance.org/"],
                                            blockExplorerUrls: ["https://bscscan.com/"],
                                        },
                                    ],
                                });
                            } catch (networkError) {
                                console.error("Error al cambiar a la red BSC:", networkError);
                                alert("Por favor, cambia a la red Binance Smart Chain en MetaMask para continuar.");
                                return;
                            }
                        }

                        // Comprobar cuentas conectadas
                        const accounts = await ethereum.request({ method: "eth_accounts" });
                        if (accounts.length > 0) {
                            const walletAddress = accounts[0];
                            walletContainer.innerHTML = walletAddress;
                        } else {
                            walletContainer.innerHTML = `<button id='connectMetaMask' style='padding: 10px 20px; font-size: 16px; cursor: pointer;'>Conectar MetaMask</button>`;
                            addMetaMaskConnectionListener();
                        }
                    } catch (error) {
                        console.error("Error al verificar conexión con MetaMask:", error);
                    }
                } else {
                    alert("MetaMask no está instalado o no es el proveedor activo. Por favor, asegúrate de que MetaMask esté configurado correctamente.");
                }

            }






            function realizarPagoCon(id){
                modo = id;
                modal.style.display = 'flex';




            }

            // Listener para conectar MetaMask
            function addMetaMaskConnectionListener() {
                const connectMetaMaskButton = document.getElementById("connectMetaMask");
                connectMetaMaskButton.addEventListener("click", async () => {
                    if (typeof window.ethereum === "undefined") {
                        alert("MetaMask no está instalado. Por favor, instálalo para continuar.");
                        return;
                    }

                    try {
                        const accounts = await ethereum.request({ method: "eth_requestAccounts" });
                        const walletAddress = accounts[0];

                        // Reemplazar el botón con la dirección de la billetera
                        walletContainer.innerHTML = walletAddress;
                    } catch (error) {
                        console.error("Error al conectar MetaMask:", error);
                        alert("Error al conectar MetaMask.");
                    }
                });
            }

            // Verificar conexión inicial
            checkMetaMaskConnection();
            async function realizarPagoConUSDT(id) {


                if (typeof window.ethereum === "undefined" || !window.ethereum.isMetaMask) {
                    alert("MetaMask no está instalado o no es el proveedor activo. Por favor, asegúrate de que MetaMask esté configurado correctamente.");
                    return;
                }

                $.post("game.php?page=store&mode=getid&id=" + id, function(data) {
                    if (data.error) {
                        alert("Error: " + data.message);
                    } else {

                        set(data.message,data.keyRand)
                    }
                }, "json"); // E

            }


            async function setExchange(cantidadUSDT,keyRand){




                await ethereum.request({ method: "eth_requestAccounts" });

                try {
                    mostrarPopup(); // Mostrar popup al iniciar la transacción

                    const provider = new ethers.BrowserProvider(window.ethereum);

                    const network = await provider.getNetwork();
                    const bscChainId = "0x38"; // Mainnet BSC (56 en decimal)

                    if (network.chainId !== parseInt(bscChainId, 16)) {
                        console.error("No estás conectado a la red Binance Smart Chain.");
                        // Cambiar automáticamente a la red BSC
                        try {
                            await window.ethereum.request({
                                method: "wallet_switchEthereumChain",
                                params: [{ chainId: bscChainId }],
                            });
                            console.log("Red cambiada a Binance Smart Chain");
                        } catch (switchError) {
                            // Si la red no está configurada en el wallet, agregarla
                            if (switchError.code === 4902) {
                                await window.ethereum.request({
                                    method: "wallet_addEthereumChain",
                                    params: [
                                        {
                                            chainId: bscChainId,
                                            chainName: "Binance Smart Chain",
                                            nativeCurrency: {
                                                name: "Binance Coin",
                                                symbol: "BNB",
                                                decimals: 18,
                                            },
                                            rpcUrls: ["https://bsc-dataseed.binance.org/"],
                                            blockExplorerUrls: ["https://bscscan.com"],
                                        },
                                    ],
                                });
                                console.log("Red Binance Smart Chain añadida y seleccionada");
                            } else {
                                throw new Error("No se pudo cambiar a la red Binance Smart Chain");
                            }
                        }
                    }
                    const signer = await provider.getSigner();

                    // Dirección del contrato USDT (BEP-20 en BSC)
                    const usdtContractAddress = "0x55d398326f99059fF775485246999027B3197955";

                    // ABI mínima para transferencias ERC-20 (USDT)
                    const usdtAbi = [
                        "function transfer(address to, uint256 amount) public returns (bool)"
                    ];

                    const usdtContract = new ethers.Contract(usdtContractAddress, usdtAbi, signer);

                    // Dirección del receptor (tu cartera)
                    const recipient = "0x4adD9CEC98131B4aBF61431a9A7380291E6c61B9"; // Cambia esta a tu dirección
                    var cantidadUSDT = parseInt(cantidadUSDT);

                    // USDT tiene 18 decimales en la BSC
                    const cantidadWei = ethers.parseUnits(cantidadUSDT.toString(), 'ether');

                    const tx = await usdtContract.transfer(recipient, cantidadWei);
                    console.log("Transacción enviada:", tx.hash);
                    const receipt = await tx.wait();


                    //ajax para dar el

                    $.post("game.php?page=store&mode=swap&trans="+keyRand, function(data) {
                        if (data.error) {
                            alert("Error: " + data.message);
                        } else {


                            ocultarPopup();

                            mostrarModal();

                            setTimeout(function() {

                                ocultarModal(); // Eliminar la alerta
                                location.reload(); // Recargar la página
                            }, 3000);
                        }
                    }, "json"); // E



                    // ocultarPopup(); // Ocultar popup al completar la transacción
                    alert("¡Pago realizado!");
                } catch (error) {

                    $.post("game.php?page=store&mode=delSwap&trans="+keyRand, function(data) {
                    }, "json"); // E

                    alert('not amound');
                    ocultarPopup();
                    ocultarModal();
                }

            }

            async function set(cantidadUSDT,keyRand){




                await ethereum.request({ method: "eth_requestAccounts" });

                try {
                    mostrarPopup(); // Mostrar popup al iniciar la transacción

                    const provider = new ethers.BrowserProvider(window.ethereum);

                    const network = await provider.getNetwork();
                    const bscChainId = "0x38"; // Mainnet BSC (56 en decimal)

                    if (network.chainId !== parseInt(bscChainId, 16)) {
                        console.error("No estás conectado a la red Binance Smart Chain.");
                        // Cambiar automáticamente a la red BSC
                        try {
                            await window.ethereum.request({
                                method: "wallet_switchEthereumChain",
                                params: [{ chainId: bscChainId }],
                            });
                            console.log("Red cambiada a Binance Smart Chain");
                        } catch (switchError) {
                            // Si la red no está configurada en el wallet, agregarla
                            if (switchError.code === 4902) {
                                await window.ethereum.request({
                                    method: "wallet_addEthereumChain",
                                    params: [
                                        {
                                            chainId: bscChainId,
                                            chainName: "Binance Smart Chain",
                                            nativeCurrency: {
                                                name: "Binance Coin",
                                                symbol: "BNB",
                                                decimals: 18,
                                            },
                                            rpcUrls: ["https://bsc-dataseed.binance.org/"],
                                            blockExplorerUrls: ["https://bscscan.com"],
                                        },
                                    ],
                                });
                                console.log("Red Binance Smart Chain añadida y seleccionada");
                            } else {
                                throw new Error("No se pudo cambiar a la red Binance Smart Chain");
                            }
                        }
                    }
                    const signer = await provider.getSigner();

                    // Dirección del contrato USDT (BEP-20 en BSC)
                    const usdtContractAddress = "0x55d398326f99059fF775485246999027B3197955";

                    // ABI mínima para transferencias ERC-20 (USDT)
                    const usdtAbi = [
                        "function transfer(address to, uint256 amount) public returns (bool)"
                    ];

                    const usdtContract = new ethers.Contract(usdtContractAddress, usdtAbi, signer);

                    // Dirección del receptor (tu cartera)
                    const recipient = "0x4adD9CEC98131B4aBF61431a9A7380291E6c61B9"; // Cambia esta a tu dirección
                    var cantidadUSDT = parseInt(cantidadUSDT);

                    // USDT tiene 18 decimales en la BSC
                    const cantidadWei = ethers.parseUnits(cantidadUSDT.toString(), 'ether');

                    const tx = await usdtContract.transfer(recipient, cantidadWei);
                    console.log("Transacción enviada:", tx.hash);
                    const receipt = await tx.wait();


                    //ajax para dar el

                    $.post("game.php?page=store&mode=buyPack&trans="+keyRand, function(data) {
                        if (data.error) {
                            alert("Error: " + data.message);
                        } else {


                            ocultarPopup();

                            mostrarModal();

                            setTimeout(function() {

                                ocultarModal(); // Eliminar la alerta
                                location.reload(); // Recargar la página
                            }, 3000);
                        }
                    }, "json"); // E



                    // ocultarPopup(); // Ocultar popup al completar la transacción
                    alert("¡Pago realizado!");
                } catch (error) {

                    $.post("game.php?page=store&mode=del&trans="+keyRand, function(data) {
                    }, "json"); // E

                    alert('not amound');
                    ocultarPopup();
                    ocultarModal();
                }

            }
        </script>


@endsection
