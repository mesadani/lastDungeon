@extends('layout.general')

@section('content')
    <style>
        /* Estilos para el menú de navegación */


        .nav-tabs .nav-link {
            color: var(--dark-color);
            border: 2px solid transparent;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-right: 5px;
            position: relative;
            background-color: rgba(245, 222, 179, 0.5);
        }


        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background-color:  #6E5A44;
            border-color: var(--wood-dark) var(--wood-dark) transparent;
            border-bottom: 2px solid rgba(245, 222, 179, 0.9);
            font-weight: 700;
        }

        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color:  #6E5A44;
        }

        .nav-tabs .nav-link i {
            margin-right: 0.5rem;
            color: #000; /* Negro para mejor visibilidad */
        }

        /* Estilos para la página de Coming Soon */
        .coming-soon-container {
            text-align: center;
            padding: 5rem 1rem;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            background-color: rgba(58, 39, 24, 0.4);
            margin: 3rem auto;
            border: 2px solid var(--wood-dark);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            max-width: 800px;
        }

        .coming-soon-title {
            font-size: 4rem;
            margin-bottom: 2rem;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7), 0 0 20px rgba(255, 215, 0, 0.4);
            color: var(--highlight-color);
            letter-spacing: 3px;
            font-weight: bold;
        }

        .coming-soon-subtitle {
            font-size: 1.8rem;
            margin-bottom: 2rem;
            color: var(--light-color);
        }

        .coming-soon-description {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: var(--light-color);
        }

        .market-icon {
            font-size: 5rem;
            margin-bottom: 2rem;
            color: var(--highlight-color);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        /* Background styling with animated gradient */
        #bg-video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            overflow: hidden;
        }

        #bg-video-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(135deg, rgba(26, 15, 7, 0.9) 0%, rgba(58, 39, 24, 0.9) 100%),
                url('data:image/png;base64,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');
            animation: gradientAnimation 15s ease infinite;
        }

        #bg-video-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(255, 215, 0, 0.1) 0%, transparent 70%);
            z-index: -1;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
    <div class="container">




        <div class="container py-4" style="background-color: rgba(245, 222, 179, 0.6); backdrop-filter: blur(5px);">
            <header class="pb-3 mb-4 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="display-5 fw-bold"><i class="fas fa-scroll me-2"></i>Market</h1>
                </div>
                <!-- Navegación de pestañas -->
                <div class="nav-tabs-container mt-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link navi active" href="#" data-tab="market"><i class="fas fa-scroll me-1"></i> Market</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navi" href="#" data-tab="yourMarket"><i class="fas fa-trophy me-1"></i> Your Market</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navi" href="#" data-tab="history"><i class="fas fa-trophy me-1"></i> History</a>
                        </li>
                    </ul>
                </div>
            </header>

            <div class="coming-soon-container">
                <div class="market-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h1 class="coming-soon-title">Coming Soon...</h1>
                <h2 class="coming-soon-subtitle">The Last Dungeon Market is under construction</h2>
                <p class="coming-soon-description">
                    Our merchants are gathering the finest magical items, weapons, and artifacts from across the realm.
                    Soon you'll be able to browse, trade, and acquire legendary equipment for your adventures.
                </p>
                <p class="coming-soon-description">
                    Check back soon for the grand opening!
                </p>
            </div>

            <div class="footer">
                <p>&copy; 2023 Last Dungeon. All rights reserved.</p>
            </div>
        </div>
        <!-- Tu código HTML para los filtros y los items aquí -->
    </div>
    <script>

        var idItem = 0;
        var nameItem = '';
        function showConfirmationPopup(itemName, itemPrice, idd) {
            const popup = document.createElement('div');
            idItem = idd;
            popup.classList.add('popup-overlay');
            popup.innerHTML = `
                        <div class="popup-content">
                            <h3>Confirmación de Compra</h3>
                            <p>¿Estás seguro que quieres comprar ${itemName} por ${itemPrice}?</p>
                            <button onclick="confirmPurchase()">Confirmar</button>
                            <button onclick="closePopup()">Cancelar</button>
                        </div>
                    `;
            document.body.appendChild(popup);
        }

        function closePopup() {
            const popup = document.querySelector('.popup-overlay');
            if (popup) {
                popup.remove();
            }
        }

        function confirmPurchase() {
            // Aquí puedes agregar la lógica para confirmar la compra

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'market/buy',
                data: { idItem: idItem},
                type: 'post',
                success: function (response) {

                    const popup = document.createElement('div');
                    popup.classList.add('popup-overlay');
                    popup.innerHTML = `
                        <div class="popup-content">
                            <h3>Congratulations</h3>
                            <p>You buy ${nameItem}</p>
                            <button onclick="closePopup()">Done</button>
                        </div>
                    `;
                    document.body.appendChild(popup);

                }
            })

          //  closePopup();
        }


        function showCancelPopup(itemName, itemPrice, idd) {
            const popup = document.createElement('div');
            idItem = idd;
            popup.classList.add('popup-overlay');
            popup.innerHTML = `
                        <div class="popup-content">
                            <h3>Confirmación de Cancelacion</h3>
                            <p>¿Estás seguro que quieres cancelar ${itemName}?</p>
                            <button onclick="confirmCancel()">Confirmar</button>
                            <button onclick="closePopup()">Cancelar</button>
                        </div>
                    `;
            document.body.appendChild(popup);
        }



        function confirmCancel() {
            // Aquí puedes agregar la lógica para confirmar la compra

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'market/cancel',
                data: { idItem: idItem},
                type: 'post',
                success: function (response) {

                    const popup = document.createElement('div');
                    popup.classList.add('popup-overlay');
                    popup.innerHTML = `
                        <div class="popup-content">
                            <h3>Donde</h3>
                            <p>Cancel ${nameItem}</p>
                            <button onclick="closePopup()">Done</button>
                        </div>
                    `;
                    document.body.appendChild(popup);

                }
            })

            //  closePopup();
        }
        document.addEventListener('DOMContentLoaded', function () {

            const tabs = document.querySelectorAll('.navi');
            const sections = document.querySelectorAll('.market-section');

            tabs.forEach(tab => {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetTab = this.getAttribute('data-tab');

                    // Remove active class from all tabs and sections
                    tabs.forEach(t => t.classList.remove('active'));
                    sections.forEach(s => s.style.display = 'none');

                    // Add active class to the clicked tab and show the corresponding section
                    this.classList.add('active');
                    document.getElementById(targetTab).style.display = 'block';
                });
            });


            const searchInput = document.getElementById('searchInput');
            const categorySelect = document.getElementById('categorySelect');
            const raritySelect = document.getElementById('raritySelect');
            const itemCards = document.querySelectorAll('.ii-card');

            function filterItems() {
                const searchValue = searchInput.value.toLowerCase();
                const selectedCategory = categorySelect.value;
                const selectedRarity = raritySelect.value;

                itemCards.forEach(card => {
                    const itemName = card.querySelector('.card-title').textContent.toLowerCase();
                    const itemCategory = card.getAttribute('data-category');
                    const itemRarity = card.getAttribute('data-rarity');

                    const matchesSearch = itemName.includes(searchValue);
                    const matchesCategory = selectedCategory === '' || itemCategory === selectedCategory;
                    const matchesRarity = selectedRarity === '' || itemRarity === selectedRarity;

                    if (matchesSearch && matchesCategory && matchesRarity) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', filterItems);
            categorySelect.addEventListener('change', filterItems);
            raritySelect.addEventListener('change', filterItems);
        });
    </script>
@endsection

<style>

    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .popup-content {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
    }

    .popup-content button {
        margin: 5px;
    }
    .container {
        width: 100%;
    }
    .filter-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .market-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .nft-card {
        background-color: #2c2c2c;
        padding: 15px;
        text-align: center;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }
    .nft-card:hover {
        transform: scale(1.05);
    }
    .nft-card img {
        width: 100%;
        max-width: 200px;
        border-radius: 10px;
    }
    .nft-card h3 {
        margin: 10px 0;
        font-size: 18px;
    }
    .medieval-button {
        padding: 8px 15px;
        background-color: #795649;
        border: none;
        color: #fff;
        font-size: 14px;
        cursor: pointer;
        margin: 5px;
        border-radius: 5px;
    }
    .medieval-button:hover {
        background-color: #8a6e2f;
    }
</style>
