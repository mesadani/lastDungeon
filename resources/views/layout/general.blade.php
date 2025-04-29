<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Last Dungeon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/medieval-theme.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Medieval Game Theme CSS */
        @import url('https://fonts.googleapis.com/css2?family=MedievalSharp&family=Cinzel:wght@400;700&family=Fondamento&display=swap');

        :root {
            --primary-color: #8B4513;
            --secondary-color: #A0522D;
            --accent-color: #CD853F;
            --light-color: #F5DEB3;
            --dark-color: #3A2718;
            --text-color: #2E1A0F;
            --border-color: #704214;
            --highlight-color: #FFD700;
            --health-color: #B22222;
            --mana-color: #4169E1;
            --damage-color: #FF8C00;
            --magic-color: #9370DB;
            --defense-color: #2E8B57;
            --block-color: #708090;
            --critical-color: #DC143C;
            --parchment: #F5F5DC;
            --wood-dark: #5D4037;
            --wood-light: #8D6E63;
        }

        /* General Styles */
        body {
            font-family: 'Fondamento', cursive;
            background-color: #000;
            color: var(--text-color);
            position: relative;
            overflow-x: hidden;
            padding-top: 80px; /* Ajusta este valor según la altura de tu barra de navegación */


        }

        /* Video Background */
        #bg-video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            overflow: hidden;
        }

        #bg-video {
            position: absolute;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }

        /* Overlay for better readability */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: -1;
        }

        .container {
            background-color: rgba(245, 222, 179, 0.9);
            border-radius: 0;
            border: 8px solid var(--wood-dark);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.8), inset 0 0 15px rgba(0, 0, 0, 0.4);
            position: relative;
            margin-top: 2rem;
            margin-bottom: 2rem;
            padding: 2rem;
            background-color: var(--parchment);
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(rgba(245, 222, 179, 0.9), rgba(245, 222, 179, 0.8)),
                url('data:image/png;base64,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');
            z-index: -1;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'MedievalSharp', cursive;
            color: var(--dark-color);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .display-5 {
            font-size: 2.5rem;
            letter-spacing: 1px;
        }

        /* Header */
        header {
            border-bottom: 3px solid var(--wood-dark) !important;
            position: relative;
            padding-bottom: 1.5rem !important;
            margin-bottom: 2rem !important;
        }

        header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 3px;
            background-color: var(--wood-light);
        }

        /* Buttons */
        .btn {
            font-family: 'Cinzel', serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 0;
            border: 2px solid var(--border-color);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--border-color);
            color: var(--light-color);
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--secondary-color);
            border-color: var(--border-color);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--border-color);
        }

        .btn-danger {
            background-color: var(--health-color);
            border-color: #8B0000;
        }

        /* Forms */
        .form-control, .form-select {
            background-color: var(--parchment);
            border: 2px solid var(--border-color);
            border-radius: 0;
            color: var(--text-color);
            font-family: 'Fondamento', cursive;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--highlight-color);
            box-shadow: 0 0 0 0.25rem rgba(205, 133, 63, 0.25);
            background-color: var(--light-color);
        }

        .input-group-text {
            background-color: var(--wood-light);
            border: 2px solid var(--border-color);
            border-radius: 0;
            color: var(--light-color);
        }

        /* Filter Section */
        .filter-section {
            background-color: rgba(58, 39, 24, 0.7) !important;
            border: 3px solid var(--wood-dark) !important;
            border-radius: 0 !important;
            padding: 1.5rem !important;
            margin-bottom: 2rem !important;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .filter-section::before {
            content: '';
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border: 1px solid rgba(245, 222, 179, 0.3);
            pointer-events: none;
        }

        .filter-section label {
            color: var(--light-color);
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        /* Cards */
        .card {
            background-color: var(--parchment);
            border: 3px solid var(--wood-dark);
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            padding: 0; /* Eliminar padding */
            margin: 0; /* Eliminar margin */
        }

        .item-card {
            position: relative;
            padding: 0; /* Eliminar padding */
        }

        .item-card::before {
            content: '';
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border: 1px solid rgba(112, 66, 20, 0.3);
            pointer-events: none;
            z-index: 1;
        }

        .item-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }

        .card-header {
            background-color: var(--wood-dark);
            color: var(--light-color);
            font-family: 'Cinzel', serif;
            font-weight: bold;
            border-bottom: 2px solid var(--border-color);
            padding: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-family: 'MedievalSharp', cursive;
            color: var(--dark-color);
            font-size: 1.4rem;
            margin-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }

        /* Item Images */
        .item-image-container {
            position: relative;
            width: 100%;
            padding-top: 100%; /* 1:1 Aspect Ratio */
            background-color: rgba(58, 39, 24, 0.2);
            border-bottom: 3px solid var(--wood-dark);
            overflow: hidden;
            margin: 0; /* Eliminar margin */
            display: block; /* Asegurar que sea un bloque */
        }

        .item-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100% !important;
            object-fit: contain;
            padding: 0.4rem;
            transition: all 0.3s ease;
            margin: 0;
            display: block;
        }

        /* Eliminar cualquier margen o padding de la clase card-img-top */
        .card-img-top {
            margin: 0;
            padding: 0;
            display: block;
        }

        .item-card:hover .item-image {
            transform: scale(1.05);
        }

        /* Badges */
        .badge {
            font-family: 'Cinzel', serif;
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0;
            margin-right: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .bg-secondary {
            background-color: var(--secondary-color) !important;
        }

        /* Item Stats */
        .stat-icon {
            width: 25px;
            text-align: center;
            margin-right: 8px;
            color: var(--dark-color);
        }

        .stat-value {
            font-weight: bold;
            color: var(--dark-color);
        }

        /* Item Description */
        .item-description {
            border-left: 3px solid var(--border-color);
            padding-left: 10px;
            margin-top: 10px;
            background-color: rgba(245, 222, 179, 0.3);
            padding: 8px;
            border-radius: 0 4px 4px 0;
        }

        .item-description p {
            margin-bottom: 0;
            font-family: 'Fondamento', cursive;
            line-height: 1.4;
            color: var(--text-color) !important;
            text-shadow: none;
        }

        .show-full-description {
            font-size: 0.8rem;
            color: var(--primary-color);
            text-decoration: none;
            font-family: 'Cinzel', serif;
            transition: all 0.3s ease;
        }

        .show-full-description:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }

        /* Modal for description */
        .modal-content {
            background-color: var(--parchment);
            border: 5px solid var(--wood-dark);
            border-radius: 0;
        }

        .modal-header {
            border-bottom: 2px solid var(--border-color);
            background-color: var(--wood-dark);
            color: var(--light-color);
        }

        .modal-footer {
            border-top: 2px solid var(--border-color);
            background-color: rgba(245, 222, 179, 0.5);
        }

        /* Stat Colors */
        .fa-heart {
            color: var(--health-color) !important;
        }

        .fa-hat-wizard {
            color: var(--mana-color) !important;
        }

        .fa-fist-raised {
            color: var(--damage-color) !important;
        }

        .fa-magic {
            color: var(--magic-color) !important;
        }

        .fa-shield-alt {
            color: var(--defense-color) !important;
        }

        .fa-hand-paper {
            color: var(--block-color) !important;
        }

        .fa-bolt {
            color: var(--critical-color) !important;
        }

        .fa-bullseye {
            color: #d63384 !important; /* Rosa/púrpura para daño a distancia */
        }

        /* Tables */
        .table {
            background-color: var(--parchment);
            border: 2px solid var(--wood-dark);
        }

        .table thead {
            background-color: var(--wood-dark);
            color: var(--light-color);
            font-family: 'Cinzel', serif;
        }

        .table thead th {
            border-bottom: 2px solid var(--border-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        .table tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(205, 133, 63, 0.1);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(245, 222, 179, 0.5);
        }

        /* Alerts */
        .alert {
            border-radius: 0;
            border: 2px solid var(--border-color);
            font-family: 'Fondamento', cursive;
        }

        .alert-success {
            background-color: rgba(46, 139, 87, 0.2);
            border-color: var(--defense-color);
            color: var(--defense-color);
        }

        .alert-danger {
            background-color: rgba(178, 34, 34, 0.2);
            border-color: var(--health-color);
            color: var(--health-color);
        }

        .alert-info {
            background-color: rgba(65, 105, 225, 0.2);
            border-color: var(--mana-color);
            color: var(--mana-color);
        }

        /* Login Page */
        .login-card {
            max-width: 450px;
            border: 8px solid var(--wood-dark);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8), 0 0 100px rgba(205, 133, 63, 0.4);
            position: relative;
            background-color: var(--parchment);
            animation: card-glow 3s infinite alternate;
        }

        @keyframes card-glow {
            0% {
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8), 0 0 50px rgba(205, 133, 63, 0.2);
            }
            100% {
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8), 0 0 100px rgba(205, 133, 63, 0.6);
            }
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(rgba(245, 222, 179, 0.9), rgba(245, 222, 179, 0.8)),
                url('data:image/png;base64,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');
            z-index: -1;
        }

        .login-card .card-header {
            background-color: var(--wood-dark);
            border-bottom: 3px solid var(--border-color);
            padding: 1.25rem;
        }

        .login-card .card-header h4 {
            margin: 0;
            font-size: 1.75rem;
            color: var(--light-color);
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: var(--parchment);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--wood-light);
            border: 2px solid var(--parchment);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--wood-dark);
        }

        /* Animations */
        @keyframes glow {
            0% { box-shadow: 0 0 5px rgba(255, 215, 0, 0.5); }
            50% { box-shadow: 0 0 20px rgba(255, 215, 0, 0.8); }
            100% { box-shadow: 0 0 5px rgba(255, 215, 0, 0.5); }
        }

        /* Decorative Elements */
        .container::after {
            content: '';
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 100px;
            height: 100px;
            background-size: contain;
            background-repeat: no-repeat;
            opacity: 0.2;
            pointer-events: none;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .display-5 {
                font-size: 1.8rem;
            }

            .item-image {
                height: 150px !important;
            }
        }

        /* Rarity Badges */
        .bg-purple {
            background-color: #6f42c1;
            color: white;
        }

        /* Rarity Glow Effects */
        .rarity-common {
            box-shadow: 0 0 5px rgba(108, 117, 125, 0.5);
        }
        .rarity-uncommon {
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }
        .rarity-rare {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .rarity-epic {
            box-shadow: 0 0 5px rgba(111, 66, 193, 0.5);
        }
        .rarity-legendary {
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.7);
        }
        .rarity-mythic {
            box-shadow: 0 0 15px rgba(220, 53, 69, 0.7);
            animation: mythic-pulse 2s infinite alternate;
        }

        @keyframes mythic-pulse {
            0% {
                box-shadow: 0 0 10px rgba(220, 53, 69, 0.7);
            }
            100% {
                box-shadow: 0 0 20px rgba(220, 53, 69, 0.9);
            }
        }

        /* Special Effects for Item Cards */
        .item-card[data-category="Weapons"] .card-title {
            color: var(--damage-color);
        }

        .item-card[data-category="Equipment"] .card-title {
            color: var(--defense-color);
        }

        .item-card[data-category="Protection"] .card-title {
            color: var(--block-color);
        }

        .item-card[data-category="Mounts"] .card-title {
            color: var(--secondary-color);
        }

        .item-card[data-category="Skills"] .card-title {
            color: var(--magic-color);
        }

        /* Legendary Item Effect */
        .item-card.legendary {
            border-color: var(--highlight-color);
            animation: glow 2s infinite;
        }

        .item-card.legendary .card-title {
            color: var(--highlight-color);
            text-shadow: 0 0 5px rgba(255, 215, 0, 0.5);
        }

        /* Tooltip custom styling */
        .tooltip .tooltip-inner {
            background-color: var(--dark-color);
            border: 1px solid var(--border-color);
            font-family: 'Fondamento', cursive;
        }

        .tooltip .arrow::before {
            border-top-color: var(--dark-color);
        }

        /* Custom Checkbox */
        .form-check-input {
            background-color: var(--parchment);
            border: 1px solid var(--border-color);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--border-color);
        }

        /* Custom Radio */
        .form-check-input[type="radio"] {
            border-radius: 50%;
        }

        /* Custom Range */
        .form-range::-webkit-slider-thumb {
            background: var(--primary-color);
        }

        .form-range::-moz-range-thumb {
            background: var(--primary-color);
        }

        /* Custom File Input */
        .form-control[type="file"] {
            padding: 0.375rem 0.75rem;
        }

        /* Pagination */
        .pagination {
            font-family: 'Cinzel', serif;
        }

        .page-link {
            background-color: var(--parchment);
            border: 1px solid var(--border-color);
            color: var(--dark-color);
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--border-color);
        }

        /* Dropdown */
        .dropdown-menu {
            background-color: var(--parchment);
            border: 2px solid var(--border-color);
            border-radius: 0;
        }

        .dropdown-item {
            font-family: 'Fondamento', cursive;
            color: var(--text-color);
        }

        .dropdown-item:hover, .dropdown-item:focus {
            background-color: rgba(205, 133, 63, 0.2);
        }

        /* Progress Bar */
        .progress {
            background-color: rgba(58, 39, 24, 0.2);
            border-radius: 0;
            height: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .progress-bar {
            background-color: var(--primary-color);
            font-family: 'Cinzel', serif;
            font-size: 0.8rem;
        }

        /* Spinner */
        .spinner-border {
            border-color: var(--light-color);
            border-right-color: transparent;
        }

        /* Toast */
        .toast {
            background-color: var(--parchment);
            border: 2px solid var(--border-color);
            border-radius: 0;
        }

        .toast-header {
            background-color: var(--wood-dark);
            color: var(--light-color);
            border-bottom: 1px solid var(--border-color);
        }

        /* Modal */
        .modal-content {
            background-color: var(--parchment);
            border: 5px solid var(--wood-dark);
            border-radius: 0;
            background-image: url('https://i.imgur.com/pT0kDFt.jpg');
            background-size: cover;
            position: relative;
        }

        .modal-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(245, 222, 179, 0.8);
            z-index: -1;
        }

        .modal-header {
            border-bottom: 2px solid var(--wood-dark);
            background-color: var(--wood-dark);
            color: var(--light-color);
        }

        .modal-footer {
            border-top: 2px solid var(--wood-dark);
        }

        /* Accordion */
        .accordion {
            border: 2px solid var(--wood-dark);
        }

        .accordion-item {
            background-color: var(--parchment);
            border: 1px solid var(--border-color);
        }

        .accordion-button {
            background-color: var(--wood-light);
            color: var(--light-color);
            font-family: 'Cinzel', serif;
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--wood-dark);
            color: var(--light-color);
        }

        /* List Group */
        .list-group-item {
            background-color: var(--parchment);
            border: 1px solid var(--border-color);
            font-family: 'Fondamento', cursive;
        }

        .list-group-item.active {
            background-color: var(--primary-color);
            border-color: var(--border-color);
        }

        /* Nav Tabs */
        .nav-tabs {
            border-bottom: 2px solid var(--wood-dark);
        }

        .nav-tabs .nav-link {
            background-color: rgba(245, 222, 179, 0.5);
            border: 1px solid var(--border-color);
            border-bottom: none;
            color: var(--text-color);
            font-family: 'Cinzel', serif;
        }

        .nav-tabs .nav-link.active {
            background-color:  #6E5A44;
            border-color: var(--wood-dark);
            border-bottom-color: transparent;
            color: var(--dark-color);
            font-weight: bold;
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: rgba(58, 39, 24, 0.2);
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
        }

        .breadcrumb-item {
            font-family: 'Fondamento', cursive;
        }

        .breadcrumb-item.active {
            color: var(--dark-color);
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "→";
        }

        /* Tooltip */
        .tooltip {
            font-family: 'Fondamento', cursive;
        }

        /* Popover */
        .popover {
            background-color: var(--parchment);
            border: 2px solid var(--wood-dark);
            border-radius: 0;
        }

        .popover-header {
            background-color: var(--wood-dark);
            color: var(--light-color);
            border-bottom: 1px solid var(--border-color);
            font-family: 'Cinzel', serif;
        }

        .popover-body {
            font-family: 'Fondamento', cursive;
            color: var(--text-color);
        }

        /* Custom Scrollbar for Webkit Browsers */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: var(--parchment);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--wood-light);
            border: 2px solid var(--parchment);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--wood-dark);
        }s


             /* Estilos para el menú lateral */
        .navbar-nav {
            justify-content: center;
            width: 100%;
        }

        .nav-tabs {
            border-bottom: 2px solid var(--wood-dark);
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

        .navbar-brand img {
            width: 40px; /* Ajusta el tamaño del logo */
            height: auto;
            border-radius: 50%;
            margin-right: 10px;
        }
        .nav-link.active {
            background-color: var(--highlight-color);
            color: var(--dark-color) !important;
            font-weight: bold;
            border: 2px solid var(--border-color);
            border-radius: 5px;
        }

    </style>
</head>
<body>
<!-- Video Background -->
<div id="bg-video-container">
    <video id="bg-video" autoplay loop muted playsinline>
        <source src="{{ asset('/video/bg.mp4') }}" type="video/mp4">
        <!-- Fallback message if video doesn't load -->
        Your browser does not support HTML5 videos.
    </video>
</div>

<!-- Menú de navegación superior -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark  fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <a class=" {{ Request::is('*') ? 'active' : '' }}" href="{{ url('/') }}"><img src="{{ asset('public/images/logo.png') }}" alt="Logo" width="40" height="40" class="d-inline-block align-text-top"></a>

        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-tabs-container mt-3 nav nav-tabs justify-content-center" id="navbarNav">
            <ul class="navbar-nav mx-auto">

                 <li class="nav-item">
                    <a class="nav-link {{ Request::is('grimorio*') ? 'active' : '' }}" href="{{ url('/grimorio') }}"><i class="fas fa-scroll me-1"></i>Grimorio</a>


                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('recipes*') ? 'active' : '' }}" href="{{ url('/recipes') }}"><i class="fas fa-scroll me-1"></i>Recipes</a>


                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('ranking*') ? 'active' : '' }}" href="{{ url('/ranking') }}"><i class="fas fa-trophy"></i>Ranking</a>


                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('market*') ? 'active' : '' }}" href="{{ url('/market') }}"><i class="fas fa-store"></i>Market</a>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('inventory*') ? 'active' : '' }}" href="{{ url('/inventory') }}"><i class="fas fa-user"></i>Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('exchange*') ? 'active' : '' }}" href="{{ url('/exchange') }}"><i class="fas fa-exchange-alt"></i>Exchange</a>
                        </li>


            </ul>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline-light">
                            <i class="fas fa-sign-in-alt me-1"></i> Logout
                        </button>
                    </form>

                @else
                    </ul>

                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="login"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                        </li>

                @endauth


        </div>
    </div>
</nav>
    @yield('content')
</div>
<script>
    function loadPage(page) {
        window.location.href = page;

    }
</script>
</body>
</html>
