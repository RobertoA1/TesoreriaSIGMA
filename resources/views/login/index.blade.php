<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BML - Login</title>
    <link rel="stylesheet" href="{{ asset('css/login/styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    @vite(['resources/css/style.css', 'resources/js/index.js'])

</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="brand flex align-center">
                <img style="height: 2rem; display:inline" src="{{ asset('images/sigma_logo.png') }}" alt="Sigma LOGO">
                <h1 style="inline">SIGMA</h1>
            </div>
            <div class="welcome-text">
                <h2>Bienvenido,</h2>
                <p>por favor, introduce tus datos</p>
            </div>
            <form id="loginForm">
                <div class="form-group">
                    <label for="username">Nombre de usuario</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="forgot-password">
                    <a href="#">¿Olvidó su contraseña?</a>
                </div>
                <button type="submit" class="btn-login">Iniciar sesión</button>
            </form>
            <div class="footer">
                <p>&copy; 2025</p>
            </div>
        </div>
        <div class="image-container" style="background-image: url({{ asset('images/login/fondo.jpg') }});">
        </div>
    </div>
    <script src="{{ asset('js/login/script.js') }}"></script>
</body>
</html>