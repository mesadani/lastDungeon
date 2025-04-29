@extends('layout.general')
<style>
    .character-image {
        position: relative;
        width: 100%;
        height: auto;
        border: 3px solid var(--wood-dark);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .item-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .item-icon {
        position: absolute;
        width: 50px;
        height: 50px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .item-icon:hover {
        transform: scale(1.2);
    }

    .list-group-item {
        background-color: var(--parchment);
        border: 1px solid var(--border-color);
        font-family: 'Fondamento', cursive;
    }

    .stat-value {
        font-weight: bold;
        color: var(--dark-color);
    }

</style>
@section('content')
    <div class="container  py-4">
        <header class="pb-3 mb-4 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-5 fw-bold"><i class="fas fa-scroll me-2"></i> User Account</h1>
            </div>
            <!-- Navegación de pestañas -->
            <div class="nav-tabs-container mt-3">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="inventory"><i class="fas fa-scroll me-1"></i>Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-trophy me-1"></i>Character</a>
                    </li>
                </ul>
            </div>
        </header>






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
                        <li class="list-group-item">Name: <span class="stat-value">John Doe</span></li>
                        <li class="list-group-item">Class: <span class="stat-value">Warrior</span></li>
                        <li class="list-group-item">Level: <span class="stat-value">10</span></li>
                        <li class="list-group-item">Health: <span class="stat-value">100</span></li>
                        <li class="list-group-item">Mana: <span class="stat-value">50</span></li>
                        <li class="list-group-item">Stamina: <span class="stat-value">75</span></li>
                        <li class="list-group-item">Strength: <span class="stat-value">20</span></li>
                        <li class="list-group-item">Intelligence: <span class="stat-value">15</span></li>
                        <li class="list-group-item">Experience: <span class="stat-value">2000</span></li>
                        <li class="list-group-item">Skill Experience: <span class="stat-value">1500</span></li>
                        <li class="list-group-item">Gold: <span class="stat-value">500</span></li>
                        <li class="list-group-item">Coins: <span class="stat-value">100</span></li>
                    </ul>
                </div>
            </div>
        <!-- Tu código HTML para los filtros y los items aquí -->
    </div>
@endsection

