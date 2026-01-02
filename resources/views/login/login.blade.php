<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Zapotek</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <div class="login-container">
        <div class="login-card">
            <div class="brand-logo">
                <img src="{{ asset('img/logo-zapotek.jpg') }}" alt="Zapotek Logo"
                    style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
            </div>

            <div class="login-header">
                <h2>Selamat Datang</h2>
                <p>Silakan masuk ke akun Anda</p>
            </div>

            <form action="{{ route('login.perform') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email') }}" placeholder="Masukkan email anda" required>
                    <i class="fas fa-user input-icon"></i>
                    @error('email')
                        <div class="invalid-feedback"
                            style="display: block; background-color: rgba(220, 53, 69, 0.1); color: var(--danger); font-size: 0.875em; margin-top: 0.5rem; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--danger);">
                            <i class="fas fa-exclamation-circle" style="margin-right: 4px;"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Masukkan password anda" required>
                    <i class="fas fa-lock input-icon"></i>
                    <i class="fas fa-eye toggle-password"></i>
                </div>

                <div class="form-actions">
                    <label class="remember-me">
                        <input type="checkbox" name="remember"> Ingat Saya
                    </label>
                    <a href="{{ route('lupa-password') }}" class="forgot-password">Lupa Password?</a>
                </div>

                <button type="submit" class="btn-login">
                    Masuk <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Custom JS -->
    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>