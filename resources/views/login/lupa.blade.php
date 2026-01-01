<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lupa Password - Zapotek</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS (Reusing existing login styles) -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <div class="login-container">
        <div class="login-card">
            <div class="brand-logo">
                <i class="fas fa-key"></i>
            </div>

            <div class="login-header">
                <h2>Reset Password</h2>
                <p>Masukkan email Anda untuk reset password</p>
            </div>

            <form action="#" method="POST"> <!-- TODO: Update action with actual reset route -->
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com"
                        required>
                    <i class="fas fa-envelope input-icon"></i>
                </div>

                <button type="submit" class="btn-login">
                    Kirim Link Reset <i class="fas fa-paper-plane" style="margin-left: 8px;"></i>
                </button>
            </form>

            <div style="margin-top: 1.5rem;">
                <a href="{{ route('login') }}" class="forgot-password" style="font-size: 0.9rem;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </div>
    </div>

    <!-- Custom JS -->
    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>