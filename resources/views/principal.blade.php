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

        /* Additional styles specific to landing page */
        .hero-section {
            text-align: center;
            padding: 4rem 1rem;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            background-color: rgba(58, 39, 24, 0.4);
            margin-bottom: 3rem;
            border: 2px solid var(--wood-dark);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(255, 215, 0, 0.1) 0%, transparent 70%);
            z-index: -1;
        }

        .game-title {
            font-size: 5rem;
            margin-bottom: 2rem;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7), 0 0 20px rgba(255, 215, 0, 0.4);
            color: var(--highlight-color);
            letter-spacing: 3px;
            font-weight: bold;
            position: relative;
            display: inline-block;
        }

        .game-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--highlight-color), transparent);
        }

        .game-subtitle {
            font-size: 1.8rem;
            margin-bottom: 3rem;
            color: var(--dark-color);
        }

        .game-description {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 3rem auto;
            line-height: 1.8;
        }

        .join-button {
            font-size: 1.5rem;
            padding: 1.2rem 3.5rem;
            margin-top: 2rem;
            background-color: var(--primary-color);
            border-color: var(--highlight-color);
            border-width: 3px;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--light-color);
            font-weight: bold;
            z-index: 1;
        }

        .join-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.3), transparent);
            transition: all 0.5s ease;
            z-index: -1;
        }

        .join-button:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4), 0 0 30px rgba(255, 215, 0, 0.2);
            background-color: var(--secondary-color);
            border-color: var(--highlight-color);
            color: var(--light-color);
        }

        .join-button:hover::before {
            left: 100%;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(205, 133, 63, 0.7);
            }
            70% {
                box-shadow: 0 0 0 20px rgba(205, 133, 63, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(205, 133, 63, 0);
            }
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--highlight-color);
        }

        .feature-card {
            padding: 2rem;
            margin-bottom: 2rem;
            background-color: rgba(245, 222, 179, 0.5);
            border: 3px solid var(--wood-dark);
            backdrop-filter: blur(3px);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            background-color: rgba(245, 222, 179, 0.7);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .feature-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .footer {
            margin-top: 3rem;
            padding: 2rem 0;
            text-align: center;
            border-top: 3px solid var(--wood-dark);
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
    <div class="container py-4" style="background-color: rgba(245, 222, 179, 0.6); backdrop-filter: blur(5px);">
        <header class="pb-3 mb-4 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-5 fw-bold"><i class="fas fa-dungeon me-2"></i> Last Dungeon</h1>
                <div>
                    <a href="https://lastdungeon.com/lastdungeon.zip" class="btn btn-info btn-sm"><i class="fas fa-download me-1"></i> Manual Download (Windows)</a>
                    <a href="http://lastdungeon.com/launcher.zip" class="btn btn-warning btn-sm"><i class="fas fa-rocket me-1"></i> Download Launcher (Windows)</a>
                </div>
            </div>

        </header>

        <div class="hero-section">
            <h1 class="game-title">Last Dungeon</h1>
            <h2 class="game-subtitle" style="margin-bottom: 0.5rem;">High-Risk Extraction RPG with Blockchain Economy</h2>

            <div class="d-flex justify-content-center gap-3 mb-4">
                <a href="{{ url('/register') }}" class="btn btn-success join-button" style="font-size: 0.75rem; padding: 0.6rem 1.75rem;">
                    <i class="fas fa-user-plus me-2"></i> Register for Alpha
                </a>

                <a href="https://discord.gg/jrZDVRAbYS" class="btn btn-primary join-button" style="font-size: 0.75rem; padding: 0.6rem 1.75rem;" target="_blank">
                    <i class="fab fa-discord me-2"></i> Join Alpha
                </a>
            </div>

            <div class="game-description">
                <p>Last Dungeon is a challenging extraction RPG where players venture into dungeons filled with enemies and treasure, aiming to secure valuable loot and escape alive. However, death comes at a high cost: you lose everything you were carrying—and other players can loot it.</p>
                <ul class="text-start mt-3">
                    <li><strong>Extraction & Risk:</strong> Enter the dungeon, grab loot, and escape before being defeated. If you die, you lose it all.</li>
                    <li><strong>Blockchain Economy:</strong> All acquired items can be sold on a web-based marketplace using a token pegged 1:1 to the US dollar.</li>
                    <li><strong>Item Rarity:</strong> Swords, shields, and crafting materials come in various rarity levels.</li>
                    <li><strong>Crafting System:</strong> Use collected materials to craft powerful items you can use or sell in the marketplace.</li>
                    <li><strong>Idle Zones:</strong> Certain safe (non-PvP) zones allow players to auto-farm resources.</li>
                </ul>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-khanda"></i>
                    </div>
                    <h3 class="feature-title">High-Risk Combat</h3>
                    <p>Battle enemies and other players in high-stakes combat where death means losing all your carried items.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3 class="feature-title">Blockchain Economy</h3>
                    <p>Trade valuable items in our marketplace using tokens pegged to real currency, creating a thriving player-driven economy.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-hammer"></i>
                    </div>
                    <h3 class="feature-title">Crafting System</h3>
                    <p>Gather resources and craft powerful items with various rarity levels that you can use in battle or sell for profit.</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; 2023 Last Dungeon. All rights reserved.</p>
        </div>
    </div>

@endsection
