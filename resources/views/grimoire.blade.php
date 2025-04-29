@extends('layout.general')

@section('content')
    <div class="container">
        <header class="pb-3 mb-4 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-5 fw-bold"><i class="fas fa-scroll me-2"></i> Grimoire of Magical Items</h1>
            </div>
            <!-- Navegación de pestañas -->
            <div class="nav-tabs-container mt-3">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php"><i class="fas fa-scroll me-1"></i> Grimorio</a>
                    </li>
                </ul>
            </div>
        </header>


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
                                <h5 class="card-title">{{ $item->item_name }}</h5>
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
                                                            <h5 class="modal-title">{{ $item->item_name }}</h5>
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
        <!-- Tu código HTML para los filtros y los items aquí -->

        <script>
            document.addEventListener('DOMContentLoaded', function () {
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
