@extends('layout.general')

@section('content')
    <style>
        /* Estilos para la página de ranking */

        /* Estilos para las pestañas de navegación */
        .nav-tabs {
        border-bottom: 2px solid var(--wood-dark);
        margin-bottom: 1rem;
        }

        .nav-tabs .nav-link {
        font-family: 'Cinzel', serif;
        color: var(--dark-color);
        background-color: var(--parchment);
        border: 2px solid var(--wood-dark);
        border-bottom: none;
        border-radius: 8px 8px 0 0;
        margin-right: 5px;
        padding: 0.75rem 1.5rem;
        font-weight: bold;
        transition: all 0.3s ease;
        position: relative;
        top: 2px;
        }

        .nav-tabs .nav-link:hover {
        background-color: var(--light-color);
        border-color: var(--wood-dark);
        }

        .nav-tabs .nav-link.active {
        color: var(--light-color);
        background-color:  #6E5A44;
        border-color: var(--wood-dark);
        border-bottom: none;
        }

        /* Estilos para las píldoras de navegación */
        .nav-pills {
        margin-bottom: 1.5rem;
        border: 2px solid var(--wood-dark);
        border-radius: 5px;
        padding: 0.5rem;
        background-color: rgba(58, 39, 24, 0.1);
        }

        .nav-pills .nav-link {
        font-family: 'Cinzel', serif;
        color: var(--dark-color);
        background-color: var(--parchment);
        border: 1px solid var(--wood-dark);
        border-radius: 5px;
        margin-right: 5px;
        padding: 0.5rem 1rem;
        font-weight: bold;
        transition: all 0.3s ease;
        }

        .nav-pills .nav-link:hover {
        background-color: var(--light-color);
        }

        .nav-pills .nav-link.active {
        color: var(--light-color);
        background-color: var(--wood-dark);
        border-color: var(--wood-dark);
        }

        /* Estilos para las tablas de ranking */
        .ranking-table {
        border: 3px solid var(--wood-dark);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .ranking-table th {
        background-color: var(--wood-dark);
        color: var(--light-color);
        font-family: 'MedievalSharp', cursive;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 12px 15px;
        }

        .ranking-table tbody tr {
        border-bottom: 1px solid rgba(58, 39, 24, 0.2);
        }

        .ranking-table tbody tr:nth-of-type(odd) {
        background-color: rgba(245, 222, 179, 0.5);
        }

        .ranking-table tbody tr:hover {
        background-color: rgba(205, 133, 63, 0.3);
        }

        /* Mejorar contraste de las celdas */
        .ranking-table td {
        padding: 10px 15px;
        vertical-align: middle;
        }

        /* Destacar las filas de los primeros puestos */
        .ranking-table tr:nth-child(1) {
        background-color: rgba(184, 134, 11, 0.15) !important;
        border-bottom: 1px solid rgba(184, 134, 11, 0.3);
        }

        .ranking-table tr:nth-child(2) {
        background-color: rgba(169, 169, 169, 0.15) !important;
        border-bottom: 1px solid rgba(169, 169, 169, 0.3);
        }

        .ranking-table tr:nth-child(3) {
        background-color: rgba(139, 69, 19, 0.15) !important;
        border-bottom: 1px solid rgba(139, 69, 19, 0.3);
        }

        /* Estilos para posiciones en el ranking */
        .rank-position {
        font-weight: bold;
        font-family: 'MedievalSharp', cursive;
        font-size: 1.2rem;
        }

        .rank-1 {
        color: #B8860B; /* Oro oscuro (Dark Goldenrod) para mejor contraste */
        text-shadow: 0 0 3px rgba(0, 0, 0, 0.5); /* Sombra para mejorar legibilidad */
        }

        .rank-2 {
        color: #A9A9A9; /* Plata más oscura */
        }

        .rank-3 {
        color: #8B4513; /* Bronce más oscuro (Saddle Brown) */
        }

        /* Animación para los primeros lugares */
        @keyframes glow {
        0% {
        text-shadow: 0 0 5px rgba(184, 134, 11, 0.5);
        }
        50% {
        text-shadow: 0 0 15px rgba(184, 134, 11, 0.8), 0 0 5px rgba(0, 0, 0, 0.5);
        }
        100% {
        text-shadow: 0 0 5px rgba(184, 134, 11, 0.5);
        }
        }

        .rank-1 {
        animation: glow 2s infinite;
        }

        /* Mejorar el contraste del icono de corona */
        .rank-1 .fa-crown {
        color: #DAA520; /* Golden Rod */
        filter: drop-shadow(0 0 2px rgba(0, 0, 0, 0.7));
        margin-left: 5px;
        font-size: 1.1em;
        background-color: rgba(0, 0, 0, 0.1);
        padding: 3px;
        border-radius: 50%;
        border: 1px solid rgba(0, 0, 0, 0.2);
        }

        /* Mejorar el contraste de las insignias */
        .ranking-table .badge {
        font-size: 0.9rem;
        padding: 6px 10px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .ranking-table .badge.bg-primary {
        background-color: #6b4226 !important; /* Marrón más oscuro para mejor contraste */
        }

        .ranking-table .badge.bg-secondary {
        background-color: #5a4a42 !important; /* Gris más oscuro para mejor contraste */
        }

        /* Iconos dentro de las insignias */
        .ranking-table .badge i {
        margin-right: 5px;
        filter: drop-shadow(0 0 1px rgba(255, 255, 255, 0.5));
        }

        /* Estilos para la vista de miembros del gremio */
        .guild-name {
        color: var(--accent-color);
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        font-weight: bold;
        }

        .card-header .badge {
        font-size: 1rem;
        padding: 8px 12px;
        }

        /* Botón para ver miembros del gremio */
        .btn-sm.btn-primary {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
        background-color: var(--wood-dark);
        border-color: var(--wood-dark);
        transition: all 0.3s ease;
        }

        .btn-sm.btn-primary:hover {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        transform: translateY(-2px);
        }

        /* Animación para el botón de volver */
        .nav-link .fa-arrow-left {
        transition: transform 0.3s ease;
        }

        .nav-link:hover .fa-arrow-left {
        transform: translateX(-3px);
        }
    </style>
    <div class="container py-4 text-white">
        <header class="pb-3 mb-4 border-bottom border-light">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-5 fw-bold"><i class="fas fa-trophy me-2"></i> Ranking de Aventureros</h1>
            </div>

            <div class="nav-tabs-container mt-3">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('ranking') }}"><i class="fas fa-trophy me-1"></i> Ranking</a>
                    </li>
                </ul>
            </div>
        </header>

        @if(isset($error))
            <div class="alert alert-danger">
                <strong>Error:</strong> {{ $error }}
            </div>
        @else
            <ul class="nav nav-pills mb-4">
                @if ($selectedGuild)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ranking') }}">
                            <i class="fas fa-arrow-left me-1"></i> Volver al Ranking
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-users me-1"></i> Miembros de {{ $selectedGuild }}
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="pill" href="#players-ranking">
                            <i class="fas fa-user-shield me-1"></i> Ranking de Jugadores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="pill" href="#guilds-ranking">
                            <i class="fas fa-users me-1"></i> Ranking de Gremios
                        </a>
                    </li>
                @endif
            </ul>

            @if ($selectedGuild)
                <div class="card bg-dark text-white border-light">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3><i class="fas fa-users me-2"></i> Miembros del Gremio: {{ $selectedGuild }}</h3>
                        @if ($selectedGuildData)
                            <div>
                            <span class="badge bg-primary me-2">
                                <i class="fas fa-star-of-life me-1"></i> Nivel Total: {{ $selectedGuildData->total_level }}
                            </span>
                                <span class="badge bg-secondary">
                                <i class="fas fa-users me-1"></i> Miembros: {{ $selectedGuildData->member_count }}
                            </span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($guildMembers->isEmpty())
                            <div class="alert alert-info">Este gremio no tiene miembros registrados.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-dark table-hover ranking-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Nivel</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($guildMembers as $index => $member)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $member->name }}</td>
                                            <td>{{ $member->level }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="players-ranking">
                        <div class="card bg-dark text-white border-light mb-4">
                            <div class="card-header"><h3><i class="fas fa-user-shield me-2"></i> Ranking de Jugadores</h3></div>
                            <div class="card-body table-responsive">
                                <table class="table table-striped table-dark table-hover ranking-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Nivel</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($playerRanking as $index => $player)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $player->name }}</td>
                                            <td>{{ $player->level }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="guilds-ranking">
                        <div class="card bg-dark text-white border-light mb-4">
                            <div class="card-header"><h3><i class="fas fa-users me-2"></i> Ranking de Gremios</h3></div>
                            <div class="card-body table-responsive">
                                <table class="table table-striped table-dark table-hover ranking-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre del Gremio</th>
                                        <th>Nivel Total</th>
                                        <th>Miembros</th>
                                        <th>Ver</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($guildRanking as $index => $guild)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $guild->guild_name }}</td>
                                            <td>{{ $guild->total_level }}</td>
                                            <td>{{ $guild->member_count }}</td>
                                            <td>
                                                <a href="{{ route('ranking', ['guild' => $guild->guild_name]) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Ver Miembros
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection
