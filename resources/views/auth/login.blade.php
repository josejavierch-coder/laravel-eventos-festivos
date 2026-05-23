<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso a la Administración - EventosFestivos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ time() }}">
</head>
<body class="login-page">
    <!-- Left Hero Side -->
    <section class="login-hero">
        <div class="login-hero-content">
            <h1>Administra <br><span>con Calidez</span></h1>
            <p class="subtitle">Automatización, Invitados y Logística Sin Estrés</p>
            
            <div class="login-features">
                <div class="login-feature-item">
                    <i data-lucide="brain"></i>
                    <div>
                        <h4>IA Planning</h4>
                        <p>Fiestas temáticas,<br>Invitans y Logistice.</p>
                    </div>
                </div>
                <div class="login-feature-item">
                    <i data-lucide="layout-grid"></i>
                    <div>
                        <h4>Gestión Integrada</h4>
                        <p>Complete evento<br>flow y downloadss.</p>
                    </div>
                </div>
                <div class="login-feature-item">
                    <i data-lucide="calendar-check"></i>
                    <div>
                        <h4>RSVP Inteligente</h4>
                        <p>Confirmaciones con<br>datos e ano.</p>
                    </div>
                </div>
                <div class="login-feature-item">
                    <i data-lucide="bar-chart-3"></i>
                    <div>
                        <h4>Análisis de Datos</h4>
                        <p>Confirros en eooonon<br>análisis de datos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Right Form Side -->
    <section class="login-form-side">
        <div style="margin-bottom: 40px; text-align: center;">
            <a href="{{ route('home') }}" class="logo-group" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none;">
                <span class="logo-icon-img" style="font-family: 'Playfair Display', serif; font-weight: 900; font-size: 2.5rem; color: #1e293b;">E</span>
                <span style="font-size: 1.8rem; font-weight: 800; color: #0f172a; letter-spacing: -0.5px;">EventosFestivos</span>
            </a>
        </div>

        <div class="login-card">
            <h2 style="text-align: center; margin-bottom: 30px;">Acceso a la Administración</h2>
            
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="login-form-group">
                    <i data-lucide="mail" size="18"></i>
                    <input type="email" name="email" placeholder="Correo electrónico" required autofocus>
                </div>
                <div class="login-form-group">
                    <i data-lucide="lock" size="18"></i>
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>
                
                <button type="submit" class="btn-login">
                    Iniciar Sesión
                </button>
                
                <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                
                <button type="button" class="btn-request-access">
                    Solicitar Acceso
                </button>
            </form>
        </div>

        <footer class="login-footer">
            <div style="display: flex; gap: 15px; opacity: 0.7;">
                <span>Legal</span>
                <span>Leç</span>
                <span>Lega</span>
                <span>Ligas</span>
            </div>
            <div class="login-social">
                <i data-lucide="twitter" size="18"></i>
                <i data-lucide="facebook" size="18"></i>
                <i data-lucide="linkedin" size="18"></i>
            </div>
        </footer>
    </section>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
