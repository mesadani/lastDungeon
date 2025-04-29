@extends('layout.general')

@section('content')

    <div class="container">
        <header class="pb-3 mb-4 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-5 fw-bold"><i class="fas fa-scroll me-2"></i> User Account</h1>
            </div>
            <!-- Navegación de pestañas -->
            <div class="nav-tabs-container mt-3">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link navi active" href="#" data-tab="bank"><i class="fas fa-scroll me-1"></i>Bank</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navi" href="#" data-tab="inventory"><i class="fas fa-scroll me-1"></i>Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navi" href="#" data-tab="character"><i class="fas fa-trophy me-1"></i>Character</a>
                    </li>
                </ul>

            </div>
        </header>

        <div id="bank" class="account-section">
            @if($can == 0)
                <span>you need create character ingame</span>
            @else
            <div class="filter-section">
                <form method="GET" action="" class="row g-3">
                    <div class="col-md-6">
                        <label for="searchInput" class="form-label"><i class="fas fa-search me-1"></i> Search</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Magical item name..." name="search" value="">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label for="categorySelect" class="form-label"><i class="fas fa-book-open me-1"></i> Category</label>
                        <select name="category" class="form-select" id="categorySelect">
                            <option value="">All categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ htmlspecialchars($cat) }}">
                                    {{ htmlspecialchars($cat) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="raritySelect" class="form-label"><i class="fas fa-gem me-1"></i> Rarity</label>
                        <select name="rarity" class="form-select" id="raritySelect">
                            <option value="">All rarities</option>
                            @foreach($rarityLevels as $rarityLevel)
                                <option value="{{ htmlspecialchars($rarityLevel) }}">
                                    {{ htmlspecialchars($rarityLevel) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                @if($items->isEmpty())
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-book-dead fa-4x mb-3" style="color: var(--wood-dark);"></i>
                        <h3>The Grimoire is empty in this section!</h3>
                        <p>No magical items match your search. Try with other filters or consult the Archmage.</p>
                    </div>
                @else
                    @foreach ($items as $item)
                        <div class="col ii-card" data-category="{{ $item->category }}"
                             data-rarity="{{ $item->rarity ?? 'Common' }}">
                            <div class="card item-card h-100 rarity-{{ strtolower($item->rarity ?? 'common') }}"
                            >
                                <div class="item-image-container">
                                    <img src="{{ 'https://expanseuniverse.com/grimoire/images/'.$item->image }}" class="item-image" alt="{{ $item->image }}">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->name }}  <span>( {{ $item->amount }} )</span></h5>

                                 <!--   <input type="text" placeholder="amount" size="10" max="{{$item->amount}}" id="amount-{{ $item->id }}">
                                    <input type="text" placeholder="price" size="10" class="input_light_blue" type="number" min="0" id="price-{{ $item->id }}">

                                    <button onclick="showConfirmationPopups('{{ addslashes($item['name']) }}', {{ $item['id'] }})">Put in Market</button>-->

                                    <p class="card-text">
                                        <span class="badge bg-primary">{{ $item->category }}</span>
                                        <span class="badge bg-secondary">{{ $item->subcategory }}</span>
                                        <span class="badge {{ $rarityClasses[$item->rarity] ?? 'bg-secondary' }}">{{ $item->rarity ?? 'Common' }}</span>
                                        @php
                                            $rarityClasses = [
                                                'Common' => 'bg-secondary',
                                                'Uncommon' => 'bg-success',
                                                'Rare' => 'bg-primary',
                                                'Epic' => 'bg-purple',
                                                'Legendary' => 'bg-warning text-dark',
                                                'Mythic' => 'bg-danger',
                                            ];
                                            $rarityClass = $rarityClasses[$item->rarity] ?? 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $rarityClass }}">{{ $item->rarity ?? 'Common' }}</span>
                                    </p>

                                    @if (!empty($item->description))
                                        <div class="item-description mb-3">
                                            @php
                                                $shortDesc = Str::limit($item->description, 100, '...');
                                            @endphp
                                            <p class="small fst-italic description-text">{{ $shortDesc }}</p>

                                            @if (strlen($item->description) > 100)
                                                <button type="button" class="btn btn-sm btn-link p-0 show-full-description"
                                                        data-bs-toggle="modal" data-bs-target="#descriptionModal{{ $item->id }}">
                                                    <i class="fas fa-book-open me-1"></i> Read more
                                                </button>

                                                <!-- Modal for full description -->
                                                <div class="modal fade" id="descriptionModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ $item->name }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{!! nl2br(e($item->description)) !!}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="mt-3">
                                        @if ($item->health_bonus > 0)
                                            <div><i class="fas fa-heart stat-icon"></i> <span class="stat-value">+{{ $item->health_bonus }}</span> Health</div>
                                        @endif

                                        @if ($item->mana_bonus > 0)
                                            <div><i class="fas fa-hat-wizard stat-icon"></i> <span class="stat-value">+{{ $item->mana_bonus }}</span> Mana</div>
                                        @endif

                                        @if ($item->damage_bonus > 0)
                                            <div><i class="fas fa-fist-raised stat-icon"></i> <span class="stat-value">+{{ $item->damage_bonus }}</span> Damage</div>
                                        @endif

                                        @if ($item->magic_damage_bonus > 0)
                                            <div><i class="fas fa-magic stat-icon"></i> <span class="stat-value">+{{ $item->magic_damage_bonus }}</span> Magic Damage</div>
                                        @endif

                                        @if ($item->range_damage_bonus > 0)
                                            <div><i class="fas fa-bullseye stat-icon"></i> <span class="stat-value">+{{ $item->range_damage_bonus }}</span> Range Damage</div>
                                        @endif

                                        @if ($item->defense_bonus > 0)
                                            <div><i class="fas fa-shield-alt stat-icon"></i> <span class="stat-value">+{{ $item->defense_bonus }}</span> Defense</div>
                                        @endif

                                        @if ($item->block_chance_bonus > 0)
                                            <div><i class="fas fa-hand-paper stat-icon"></i> <span class="stat-value">+{{ $item->block_chance_bonus }}%</span> Block</div>
                                        @endif

                                        @if ($item->critical_chance_bonus > 0)
                                            <div><i class="fas fa-bolt stat-icon"></i> <span class="stat-value">+{{ $item->critical_chance_bonus }}%</span> Critical</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            @endif
        </div>

        <div id="inventory" class="account-section">
            @if($can == 0)
                <span>you need create character ingame</span>
            @else
            <div class="filter-section">
                    <form method="GET" action="" class="row g-3">
                        <div class="col-md-6">
                            <label for="searchInput" class="form-label"><i class="fas fa-search me-1"></i> Search the Grimoire</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Magical item name..." name="search" value="">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="categorySelect" class="form-label"><i class="fas fa-book-open me-1"></i> Category</label>
                            <select name="category" class="form-select" id="categorySelect">
                                <option value="">All categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ htmlspecialchars($cat) }}">
                                        {{ htmlspecialchars($cat) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="raritySelect" class="form-label"><i class="fas fa-gem me-1"></i> Rarity</label>
                            <select name="rarity" class="form-select" id="raritySelect">
                                <option value="">All rarities</option>
                                @foreach($rarityLevels as $rarityLevel)
                                    <option value="{{ htmlspecialchars($rarityLevel) }}">
                                        {{ htmlspecialchars($rarityLevel) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @if($itemsInventory->isEmpty())
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-book-dead fa-4x mb-3" style="color: var(--wood-dark);"></i>
                            <h3>The Grimoire is empty in this section!</h3>
                            <p>No magical items match your search. Try with other filters or consult the Archmage.</p>
                        </div>
                    @else
                        @foreach ($itemsInventory as $item)
                            <div class="col ii-card" data-category="{{ $item->category }}"
                                 data-rarity="{{ $item->rarity ?? 'Common' }}">
                                <div class="card item-card h-100 rarity-{{ strtolower($item->rarity ?? 'common') }}"
                                >
                                    <div class="item-image-container">
                                        <img src="{{ 'https://expanseuniverse.com/grimoire/images/'.$item->image }}" class="item-image" alt="{{ $item->image }}">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->name }}  <span>( {{ $item->amount }} )</span></h5>


                                        <p class="card-text">
                                            <span class="badge bg-primary">{{ $item->category }}</span>
                                            <span class="badge bg-secondary">{{ $item->subcategory }}</span>
                                            <span class="badge {{ $rarityClasses[$item->rarity] ?? 'bg-secondary' }}">{{ $item->rarity ?? 'Common' }}</span>
                                            @php
                                                $rarityClasses = [
                                                    'Common' => 'bg-secondary',
                                                    'Uncommon' => 'bg-success',
                                                    'Rare' => 'bg-primary',
                                                    'Epic' => 'bg-purple',
                                                    'Legendary' => 'bg-warning text-dark',
                                                    'Mythic' => 'bg-danger',
                                                ];
                                                $rarityClass = $rarityClasses[$item->rarity] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $rarityClass }}">{{ $item->rarity ?? 'Common' }}</span>
                                        </p>

                                        @if (!empty($item->description))
                                            <div class="item-description mb-3">
                                                @php
                                                    $shortDesc = Str::limit($item->description, 100, '...');
                                                @endphp
                                                <p class="small fst-italic description-text">{{ $shortDesc }}</p>

                                                @if (strlen($item->description) > 100)
                                                    <button type="button" class="btn btn-sm btn-link p-0 show-full-description"
                                                            data-bs-toggle="modal" data-bs-target="#descriptionModal{{ $item->id }}">
                                                        <i class="fas fa-book-open me-1"></i> Read more
                                                    </button>

                                                    <!-- Modal for full description -->
                                                    <div class="modal fade" id="descriptionModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">{{ $item->name }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{!! nl2br(e($item->description)) !!}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="mt-3">
                                            @if ($item->health_bonus > 0)
                                                <div><i class="fas fa-heart stat-icon"></i> <span class="stat-value">+{{ $item->health_bonus }}</span> Health</div>
                                            @endif

                                            @if ($item->mana_bonus > 0)
                                                <div><i class="fas fa-hat-wizard stat-icon"></i> <span class="stat-value">+{{ $item->mana_bonus }}</span> Mana</div>
                                            @endif

                                            @if ($item->damage_bonus > 0)
                                                <div><i class="fas fa-fist-raised stat-icon"></i> <span class="stat-value">+{{ $item->damage_bonus }}</span> Damage</div>
                                            @endif

                                            @if ($item->magic_damage_bonus > 0)
                                                <div><i class="fas fa-magic stat-icon"></i> <span class="stat-value">+{{ $item->magic_damage_bonus }}</span> Magic Damage</div>
                                            @endif

                                            @if ($item->range_damage_bonus > 0)
                                                <div><i class="fas fa-bullseye stat-icon"></i> <span class="stat-value">+{{ $item->range_damage_bonus }}</span> Range Damage</div>
                                            @endif

                                            @if ($item->defense_bonus > 0)
                                                <div><i class="fas fa-shield-alt stat-icon"></i> <span class="stat-value">+{{ $item->defense_bonus }}</span> Defense</div>
                                            @endif

                                            @if ($item->block_chance_bonus > 0)
                                                <div><i class="fas fa-hand-paper stat-icon"></i> <span class="stat-value">+{{ $item->block_chance_bonus }}%</span> Block</div>
                                            @endif

                                            @if ($item->critical_chance_bonus > 0)
                                                <div><i class="fas fa-bolt stat-icon"></i> <span class="stat-value">+{{ $item->critical_chance_bonus }}%</span> Critical</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>

        <div id="character" style="display: none;"  class="account-section">
            @if($can == 0)
                <span>you need create character ingame</span>
            @else
            <div class="row">
                <!-- Character Image and Items -->
                <div class="col-md-6">
                    <div class="character-image">
                        <img src="path/to/character-image.png" alt="Character" class="img-fluid">
                        <div class="item-overlay">
                            <img src="path/to/shield.png" alt="Shield" class="item-icon" style="top: 20%; left: 10%;">
                            <img src="path/to/helmet.png" alt="Helmet" class="item-icon" style="top: 5%; left: 40%;">
                            <img src="path/to/sword.png" alt="Sword" class="item-icon" style="top: 50%; left: 70%;">
                            <img src="path/to/pants.png" alt="Pants" class="item-icon" style="top: 80%; left: 40%;">
                        </div>
                    </div>
                </div>
                <!-- Character Stats -->
                <div class="col-md-6">
                    <h2 class="display-5">Character Stats</h2>
                    <ul class="list-group">
                        <li class="list-group-item">Name: <span class="stat-value">{{ $character['name'] }}</span></li>
                        <li class="list-group-item">Class: <span class="stat-value">{{ $character['class'] }}</span></li>
                        <li class="list-group-item">Level: <span class="stat-value">{{ $character['level'] }}</span></li>
                        <li class="list-group-item">Health: <span class="stat-value">{{ $character['health'] }}</span></li>
                        <li class="list-group-item">Mana: <span class="stat-value">{{ $character['mana'] }}</span></li>
                        <li class="list-group-item">Stamina: <span class="stat-value">{{ $character['stamina'] }}</span></li>
                        <li class="list-group-item">Strength: <span class="stat-value">{{ $character['strength'] }}</span></li>
                        <li class="list-group-item">Intelligence: <span class="stat-value">{{ $character['intelligence'] }}</span></li>
                        <li class="list-group-item">Experience: <span class="stat-value">{{ $character['experience'] }}</span></li>
                        <li class="list-group-item">Skill Experience: <span class="stat-value">{{ $character['skillExperience'] }}</span></li>
                        <li class="list-group-item">Gold: <span class="stat-value">{{ $character['gold'] }}</span></li>
                        <li class="list-group-item">Coins: <span class="stat-value">{{ $character['coins'] }}</span></li>
                    </ul>
                </div>
            </div>
            @endif

        </div>
        <!-- Tu código HTML para los filtros y los items aquí -->
    </div>
        <script>
            var idItem = 0;
            var nameItem = '';
            var amount = '';
            var price = '';
            function showConfirmationPopups(itemName, idd) {

                const popup = document.createElement('div');
                const precio = $("#price-"+idd).val();
                const cantidad = $("#amount-"+idd).val();

                idItem = idd;
                price = precio;
                amount = cantidad;
                popup.classList.add('popup-overlay');
                popup.innerHTML = `
                        <div class="popup-content">
                            <h3>Confirm put item</h3>
                            <p>¿Are you sure put ${amount} ${itemName} for ${price}?</p>
                            <button onclick="confirmPurchase()">Confirm</button>
                            <button onclick="closePopup()">Cancel</button>
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
                    url: 'market/putInMarket',
                    data: { idItem: idItem, price:price,amount:amount},
                    type: 'post',
                    success: function (response) {

                        const popupew = document.querySelector('.popup-overlay');
                        if (popupew) {
                            popupew.remove();
                        }

                        const popup = document.createElement('div');
                        popup.classList.add('popup-overlay');
                        popup.innerHTML = `
                        <div class="popup-content">
                            <h3>Congratulations</h3>
                            <p>You put ${nameItem} in Market</p>
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
                const sections = document.querySelectorAll('.account-section');

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
    .nav-tabs .nav-link.active {
    background-color: var(--parchment);
    border-color: var(--wood-dark);
    color: var(--dark-color);
    font-weight: bold;
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
