@extends('layout.general')
@section('header')

@endsection
@section('content')
    <style>
        .form-container {
            background-color: rgba(245, 222, 179, 0.7);
            border: 3px solid var(--wood-dark);
            border-radius: 10px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }

        .form-title {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 2rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.8);
            border: 2px solid var(--wood-dark);
            padding: 0.8rem;
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: var(--dark-color);
            font-weight: 600;
        }

        .submit-btn {
            background-color: var(--primary-color);
            border-color: var(--highlight-color);
            border-width: 2px;
            padding: 0.8rem 2rem;
            font-weight: bold;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .submit-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: var(--dark-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: var(--primary-color);
            transform: translateX(-5px);
        }

        .back-link i {
            margin-right: 0.5rem;
        }
    </style>


    <div class="container py-4">
        <header class="pb-3 mb-4 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-5 fw-bold"><i class="fas fa-dungeon me-2"></i> Last Dungeon</h1>
                <div>
                    <a href="index.php" class="btn btn-primary"><i class="fas fa-home me-1"></i> Home</a>
                </div>
            </div>

            <!-- Navigation tabs -->

        </header>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h2 class="form-title">Login for Alpha</h2>
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <?php if(isset($_GET['success'])): ?>
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Registration Complete!</h4>
                        <p>Your request has been successfully received. You will soon receive an email with your username and password to access the alpha.</p>
                        <hr>
                        <p class="mb-0">Thank you for your interest in Last Dungeon.</p>
                    </div>
                    <?php else: ?>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="name" placeholder="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="password" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary submit-btn">
                                <i class="fas fa-paper-plane me-2"></i> Submit Request
                            </button>
                        </div>
                    </form>

                    <?php endif; ?>
                    <a href="{{ route('register') }}" class="btn btn-primary submit-btn">
                        <i class="fas fa-paper-plane me-2"></i> Register
                    </a>
                    <a href="index.php" class="back-link">
                        <i class="fas fa-arrow-left"></i> Back to main page
                    </a>
                </div>
            </div>
        </div>

        <div class="footer mt-5">
            <p>&copy; 2023 Last Dungeon. All rights reserved.</p>
        </div>
    </div>
@endsection
