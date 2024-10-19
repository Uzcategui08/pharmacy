<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up / Log In</title>
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
            @if ($errors->any())
            <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
        @endif

            <!-- Hidden User Type -->
            <input type="hidden" name="usertype" value="user">

            <!-- Nombre -->
            <input type="text" name="name" placeholder="Nombre" value="{{ old('name') }}" required>
            @if ($errors->has('name'))
            <div class="invalid-feedback">
                @foreach ($errors->get('name') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Apellido -->
            <input type="text" name="apellido" placeholder="Apellido" value="{{ old('apellido') }}" required>
            @if ($errors->has('apellido'))
            <div class="invalid-feedback">
                @foreach ($errors->get('apellido') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Cédula -->
            <input type="text" name="cedula" placeholder="Cédula" value="{{ old('cedula') }}" required>
            @if ($errors->has('cedula'))
            <div class="invalid-feedback">
                @foreach ($errors->get('cedula') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Teléfono -->
            <input type="text" name="telefono" placeholder="Teléfono" value="{{ old('telefono') }}" required>
            @if ($errors->has('telefono'))
            <div class="invalid-feedback">
                @foreach ($errors->get('telefono') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Correo -->
            <input type="email" name="email" placeholder="Correo" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
            <div class="invalid-feedback">
                @foreach ($errors->get('email') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Contraseña -->
            <input type="password" name="password" placeholder="Contraseña" required>
            @if ($errors->has('password'))
            <div class="invalid-feedback">
                @foreach ($errors->get('password') as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Confirmar Contraseña -->
            <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required>
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
            <div class="social-container">
                <a href="#" class="social"><i class="bi bi-facebook"></i></a>
                <a href="#" class="social"><i class="bi bi-google"></i></a>
                <a href="#" class="social"><i class="bi bi-linkedin"></i></a>
            </div>
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
                <h1>Bienvenid@!</h1>
                <p>Introduce la información para crear la cuenta!</p>
                <button class="ghost" id="signIn">Iniciar Sesión</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hola, bienvendid@!</h1>
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
