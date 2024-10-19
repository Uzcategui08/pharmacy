<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión / Registro</title>
    <link rel="icon" href="{{ asset('build/assets/images/logo_app.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('build/assets/css/styles.css') }}" rel="stylesheet">
</head>
<body>
<div class="container" id="container">
    <!-- Sign Up Container -->
    <div class="form-container sign-up-container">
        <form class="formulario" method="POST" action="{{ route('register') }}">
            @csrf
            <h1>Crear Cuenta</h1>

            <!-- Hidden User Type -->
            <input type="hidden" name="usertype" value="admin">

            <!-- Nombre -->
            <input type="text" name="name" placeholder="Nombre" value="{{ old('name') }}" class="form-control-sm" required>
            @if ($errors->has('name'))
            <div class="invalid-feedback">
                @foreach ($errors->get('name') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Apellido -->
            <input type="text" name="apellido" placeholder="Apellido" value="{{ old('apellido') }}" class="form-control-sm" required>
            @if ($errors->has('apellido'))
            <div class="invalid-feedback">
                @foreach ($errors->get('apellido') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Cédula -->
            <input type="text" name="cedula" placeholder="Cédula" value="{{ old('cedula') }}" class="form-control-sm" required>
            @if ($errors->has('cedula'))
            <div class="invalid-feedback">
                @foreach ($errors->get('cedula') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Teléfono -->
            <input type="text" name="telefono" placeholder="Teléfono" value="{{ old('telefono') }}" class="form-control-sm" required>
            @if ($errors->has('telefono'))
            <div class="invalid-feedback">
                @foreach ($errors->get('telefono') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Correo -->
            <input type="email" name="email" placeholder="Correo" value="{{ old('email') }}" class="form-control-sm" required>
            @if ($errors->has('email'))
            <div class="invalid-feedback">
                @foreach ($errors->get('email') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Contraseña -->
            <input type="password" name="password" placeholder="Contraseña" class="form-control-sm" required>
            @if ($errors->has('password'))
            <div class="invalid-feedback">
                @foreach ($errors->get('password') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Confirmar Contraseña -->
            <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" class="form-control-sm" required>
            @if ($errors->has('password_confirmation'))
            <div class="invalid-feedback">
                @foreach ($errors->get('password_confirmation') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <button type="submit">Crear Cuenta</button>
        </form>
    </div>


    <!-- Sign In Container -->
    <div class="form-container sign-in-container">
        <form class="formulario" method="POST" action="{{ route('login') }}">
            @csrf
            <h1>Iniciar sesión</h1>
            <!--
            <div class="social-container">
                <a href="#" class="social"><i class="bi bi-facebook"></i></a>
                <a href="#" class="social"><i class="bi bi-google"></i></a>
                <a href="#" class="social"><i class="bi bi-linkedin"></i></a>
            </div>
            -->
            <input type="email" name="email" placeholder="Correo" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
                <div class="invalid-feedback">
                    @foreach ($errors->get('email') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            <input type="password" name="password" placeholder="Contraseña" required>
            @if ($errors->has('password'))
                <div class="invalid-feedback">
                    @foreach ($errors->get('password') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            <a href="#">Olvidaste la contraseña?</a>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>

    <!-- Overlay Container -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <img src="{{ asset('build/assets/images/logo_app.svg') }}" alt="Logo" class="logo" style="width: 200px; height: 150px;">
                <h1>Bienvenid@!</h1>
                <p>Introduce la información para crear la cuenta!</p>
                <button class="ghost" id="signIn">Iniciar Sesión</button>
            </div>
            <div class="overlay-panel overlay-right">
                <img src="{{ asset('build/assets/images/logo_app.svg') }}" alt="Logo" class="logo" style="width: 200px; height: 150px;">
                <h1>Hola, bienvenid@!</h1>
                <p>Introduce la información para acceder a la cuenta!</p>
                <button class="ghost" id="signUp">Crear Cuenta</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('build/assets/js/scripts.js') }}"></script> <!-- Custom scripts -->
</body>
</html>
