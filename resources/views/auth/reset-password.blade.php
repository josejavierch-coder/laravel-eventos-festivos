<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - EventosFestivos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="login-body">
    <section class="login-form-side" style="width: 100%; max-width: 500px; margin: 0 auto; min-height: 100vh; display: flex; flex-direction: column; justify-content: center;">
        <div class="login-logo" style="justify-content: center; margin-bottom: 2rem;">
            <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                <span class="logo-icon">E</span>
                <span class="logo-text">EventosFestivos</span>
            </a>
        </div>

        <div class="login-card">
            <h2>Restablecer Contraseña</h2>
            <p style="color: #ccc; margin-bottom: 1.5rem; text-align: center;">Crea una nueva contraseña segura para tu cuenta.</p>
            
            @if($errors->any())
                <div style="background: rgba(255, 138, 101, 0.1); color: #ff8a65; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 0.9rem;">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-group">
                    <i data-lucide="mail"></i>
                    <input type="email" name="email" placeholder="Tu correo electrónico" value="{{ old('email', $email) }}" required readonly>
                </div>

                <div class="form-group">
                    <i data-lucide="lock"></i>
                    <input type="password" name="password" placeholder="Nueva Contraseña" required autofocus>
                </div>

                <div class="form-group">
                    <i data-lucide="lock"></i>
                    <input type="password" name="password_confirmation" placeholder="Confirmar Nueva Contraseña" required>
                </div>
                
                <button type="submit" class="btn btn-login">Restablecer Contraseña</button>
            </form>
        </div>
    </section>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>lucide.createIcons();</script>
</body>
</html>
