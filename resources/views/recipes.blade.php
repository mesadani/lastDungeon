@extends('layout.general')

@section('content')
    <style>
        /* Estilos para el menú de navegación */
        .nav-tabs-container {
            margin-top: 1.5rem;
        }

        .nav-tabs {
            border-bottom: 2px solid var(--wood-dark);
        }

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

        .nav-tabs .nav-link:hover {
            background-color: rgba(245, 222, 179, 0.8);
            border-color: var(--wood-dark) var(--wood-dark) transparent;
            transform: translateY(-3px);
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: rgba(245, 222, 179, 0.9);
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
            background-color: rgba(245, 222, 179, 0.9);
        }

        .nav-tabs .nav-link i {
            margin-right: 0.5rem;
            color: #000; /* Cambiado de var(--highlight-color) a negro */
        }

        /* Estilos específicos para recetas */
        .recipe-card {
            transition: transform 0.3s ease;
            min-width: 350px; /* Ancho mínimo para que entren bien los textos */
        }

        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .recipe-image-container {
            width: 100%;
            padding-bottom: 100%; /* Relación de aspecto 1:1 */
            position: relative;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .recipe-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain; /* Mantiene la proporción de la imagen */
            transition: opacity 0.3s ease;
            padding: 10px; /* Espacio interno para que la imagen no toque los bordes */
        }

        .ingredients-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .ingredient {
            position: relative;
            width: 60px;
            height: 60px;
            border: 2px solid var(--wood-dark);
            border-radius: 5px;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.05);
        }

        .ingredient img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .ingredient-quantity {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            font-size: 0.8rem;
            padding: 1px 4px;
            border-top-left-radius: 5px;
        }

        .crafting-arrow {
            font-size: 2rem;
            color: var(--accent-color);
            margin: 10px 0;
        }

        .variant-ingredients {
            background-color: rgba(255, 248, 220, 0.3);
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #e0d8b0;
        }

        .variant-details {
            margin-top: 15px;
            border-top: 1px dashed #ccc;
            padding-top: 15px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .item-stats .card-header {
            font-size: 0.9rem;
        }

        .item-stats .card-body {
            font-size: 0.9rem;
            padding: 0.75rem;
        }

        .stat-name {
            color: #555;
            font-size: 1rem;
        }

        .stat-value {
            font-weight: bold;
            font-size: 1rem;
            min-width: 60px;
            text-align: right;
        }

        /* Estilos para las bonificaciones */
        .text-success {
            color: #28a745 !important;
            font-weight: bold;
        }
    </style>
    <div class="container">
        <div id="inventory" class="account-section">

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
                    @if($recipes->isEmpty())
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-book-dead fa-4x mb-3" style="color: var(--wood-dark);"></i>
                            <h3>The Grimoire is empty in this section!</h3>
                            <p>No magical items match your search. Try with other filters or consult the Archmage.</p>
                        </div>
                    @else
                        @foreach ($recipes as $recipe)
                            <div class="col">
                                <div class="card recipe-card h-100 rarity-<?php echo strtolower($recipe['rarity'] ?? 'common'); ?>" data-category="<?php echo htmlspecialchars($recipe['category']); ?>" data-rarity="<?php echo htmlspecialchars($recipe['rarity'] ?? 'Common'); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($recipe->itemcraft->item_name); ?></h5>
                                        <p class="card-text">
                                            <span class="badge bg-primary"><?php echo htmlspecialchars($recipe['category']); ?></span>
                                            <span class="badge bg-secondary"><?php echo htmlspecialchars($recipe['subcategory']); ?></span>
                                                <?php
                                                $rarityClass = 'bg-secondary';
                                                switch($recipe['rarity']) {
                                                    case 'Common': $rarityClass = 'bg-secondary'; break;
                                                    case 'Uncommon': $rarityClass = 'bg-success'; break;
                                                    case 'Rare': $rarityClass = 'bg-primary'; break;
                                                    case 'Epic': $rarityClass = 'bg-purple'; break;
                                                    case 'Legendary': $rarityClass = 'bg-warning text-dark'; break;
                                                    case 'Mythic': $rarityClass = 'bg-danger'; break;
                                                }
                                                ?>
                                            <span class="badge <?php echo $rarityClass; ?>"><?php echo htmlspecialchars($recipe['rarity'] ?? 'Common'); ?></span>
                                        </p>

                                            <?php if (!empty($recipe['description'])): ?>
                                        <div class="recipe-description mb-3">
                                                <?php
                                                $shortDesc = strlen($recipe['description']) > 100 ?
                                                    substr($recipe['description'], 0, 100) . '...' :
                                                    $recipe['description'];
                                                ?>
                                            <p class="small fst-italic description-text"><?php echo htmlspecialchars($shortDesc); ?></p>
                                                <?php if (strlen($recipe['description']) > 100): ?>
                                            <button type="button" class="btn btn-sm btn-link p-0 show-full-description"
                                                    data-bs-toggle="modal" data-bs-target="#descriptionModal<?php echo $recipe['id']; ?>">
                                                <i class="fas fa-book-open me-1"></i> Leer más
                                            </button>

                                            <!-- Modal for full description -->
                                            <div class="modal fade" id="descriptionModal<?php echo $recipe['id']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo htmlspecialchars($recipe['itemcraft']); ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><?php echo nl2br(htmlspecialchars($recipe['description'])); ?></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php endif; ?>

                                            <!-- Resultado de la receta -->
                                        <div class="recipe-image-container">
                                            <img src="{{ 'https://expanseuniverse.com/grimoire/images/'.$recipe->itemCraft->image }}" class="recipe-image" alt="{{ $recipe->itemCraft->image }}">


                                        </div>









                                        <div class="card">
                                            <div class="card-header bg-secondary text-white py-1">
                                                <h6 class="mb-0"><i class="fas fa-chart-bar me-1"></i> Estadísticas</h6>
                                            </div>
                                            <div class="card-body py-2">
                                                <div class="row g-2">

                                                    <div class="col-12">
                                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-1">
                                                            <span class="stat-name fw-bold">
                                                                Daño
                                                            </span>
                                                            <span class="stat-value fw-bold" data-stat="" data-base-value="">
                                                               {{$recipe->itemCraft->damage_bonus}}
                                                            </span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-1">
                                                            <span class="stat-name fw-bold">
                                                                Prob. crítico
                                                            </span>
                                                            <span class="stat-value fw-bold" data-stat="" data-base-value="">
                                                               {{$recipe->itemCraft->critical_chance_bonus}} %
                                                            </span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-1">
                                                            <span class="stat-name fw-bold">
                                                                Defensa
                                                            </span>
                                                            <span class="stat-value fw-bold" data-stat="" data-base-value="">
                                                              {{$recipe->itemCraft->defense_bonus}}
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>



                                        <div class="mt-3 mb-3">
                                            <label for="variant-select-<?php echo $recipe['id']; ?>" class="form-label"><i class="fas fa-code-branch me-1"></i> Variantes disponibles:</label>
                                            <select id="variant-select" class="form-select">
                                                <option value="">-- Select Variant --</option>
                                                @foreach($recipe->variants as $variant)
                                                    <option value="{{ $variant->id }}">{{ $variant->variant_name }}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted mt-1 d-block">
                                                <i class="fas fa-info-circle me-1"></i> Selecciona una variante para ver sus ingredientes adicionales y bonificaciones.
                                            </small>
                                        </div>

                                        <div id="variant-details-container"></div>


                                        <div class="ingredients-container" id="original-ingredients-<?php echo $recipe['id']; ?>">
                                            <!-- Los ingredientes serán insertados aquí dinámicamente con JavaScript -->
                                        </div>


                                 </div>

                                </div>

                            </div>
                        @endforeach
                    @endif
                </div>

        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const selector = document.querySelector('#variant-select'); // Ajusta el selector
            const container = document.querySelector('#variant-details-container'); // contenedor donde pondrás el HTML

            selector.addEventListener('change', function () {
                const variantId = this.value;

                if (!variantId) return;

                fetch(`variant-info/${variantId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) {
                            console.error('Error al obtener variante');
                            return;
                        }

                        const variant = data.variant;

                        // Borra contenido anterior
                        container.innerHTML = '';

                        // Renderiza el HTML como string
                        const html = `
                    <div class="variant-details" data-variant-id="${variant.id}">
                        ${variant.variant_description ? `
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-1"></i> ${variant.variant_description}
                            </div>` : ''
                        }

                        <div class="alert alert-success">
                            <i class="fas fa-chart-line me-1"></i> <strong>Bonificaciones:</strong>
                            <ul class="mb-0 mt-1">
                                ${variant.stat_bonus_type && variant.stat_bonus_value > 0 ? `
                                    <li>${bonusLabel(variant.stat_bonus_type)}: <strong>+${variant.stat_bonus_value}</strong></li>` : ''
                        }

                                ${variant.critical_bonus > 0 ? `
                                    <li>Probabilidad de Crítico: <strong>+${variant.critical_bonus}%</strong></li>` : ''
                        }

                                ${variant.defense_bonus > 0 ? `
                                    <li>Bonificación de Defensa: <strong>+${variant.defense_bonus}</strong></li>` : ''
                        }

                                ${variant.success_chance != null ? `
                                    <li>Probabilidad de Éxito: <strong>${variant.success_chance}%</strong></li>` : ''
                        }
                            </ul>
                        </div>

                        ${renderAdditionalItems(variant)}
                        ${renderIngredients(variant)} <!-- Aquí añadimos los ingredientes -->
                    </div>
                `;

                        container.innerHTML = html;
                    });
            });

            function bonusLabel(type) {
                const map = {
                    'damage_bonus': 'Bonificación de Daño',
                    'defense_bonus': 'Bonificación de Defensa',
                    'health_bonus': 'Bonificación de Salud',
                    'mana_bonus': 'Bonificación de Maná',
                    'speed_bonus': 'Bonificación de Velocidad',
                    'critical_chance': 'Probabilidad de Crítico',
                    'durability_bonus': 'Bonificación de Durabilidad'
                };
                return map[type] || type;
            }

            function renderAdditionalItems(variant) {
                let html = '';
                let hasAny = false;

                for (let i = 1; i <= 4; i++) {
                    if (variant[`additional_item${i}`]) {
                        hasAny = true;
                        break;
                    }
                }

                if (!hasAny) return '';

                html += `<h6 class="mt-2 mb-2"><i class="fas fa-plus-circle me-1"></i> Ingredientes adicionales para esta variante:</h6>`;
                html += `<div class="ingredients-container variant-ingredients mb-3">`;

                for (let i = 1; i <= 4; i++) {
                    const name = variant[`additional_item${i}`];
                    if (!name) continue;

                    const qty = variant[`additional_item${i}_quantity`] || 1;
                    const img = variant[`additional_item${i}_image`] || 'default.png';
                    const imagePath = img.startsWith('images/') ? img : `images/${img}`;

                    html += `
                <div class="ingredient variant-ingredient" title="${name}">
                    <img src="'https://expanseuniverse.com/grimoire/images/${imagePath}" class="recipe-image" alt="${name}">
                    ${qty > 1 ? `<span class="ingredient-quantity">x${qty}</span>` : ''}
                </div>
            `;
                }

                html += `</div>`;
                return html;
            }

            function renderIngredients(variant) {
                let html = '';
                if (variant.ingredients && variant.ingredients.length > 0) {
                    html += `<h6 class="mt-3 mb-2"><i class="fas fa-mortar-pestle me-1"></i> Ingredientes:</h6>`;
                    html += `<div class="ingredients-container" id="original-ingredients-${variant.id}">`;

                    variant.ingredients.forEach(ingredient => {
                        if (ingredient.item_image) {
                            const imagePath = ingredient.item_image.startsWith('images/') ? ingredient.item_image : `images/${ingredient.item_image}`;
                            html += `
                        <div class="ingredient original-ingredient" title="${ingredient.item_name}">
                            <img src="'https://expanseuniverse.com/grimoire/images/${ingredient.item_image}" class="recipe-image" alt="${ingredient.item_name}">

                            ${ingredient.quantity > 0 ? `<span class="ingredient-quantity">x${ingredient.quantity}</span>` : ''}
                        </div>
                    `;
                        }
                    });

                    html += `</div>`;
                }

                return html;
            }
        });

    </script>

@endsection




