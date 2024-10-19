<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.meta')

    <!-- Website Title -->
    <title>Log In - Tivo - SaaS App HTML Landing Page Template</title>

    @include('layouts.styles')
</head>
<body data-spy="scroll" data-target=".fixed-top">

@include('layouts.preloader')


<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">

        <!-- Text Logo - Use this if you don't have a graphic logo -->
        <!-- <a class="navbar-brand logo-text page-scroll" href="index.html">Tivo</a> -->

        <!-- Image Logo -->
        <a class="navbar-brand logo-image" href="{{ route('welcome') }}"><img src="{{asset('build/assets/images/logo.svg')}}" alt="alternative"></a>


    </div> <!-- end of container -->
</nav> <!-- end of navbar -->
<!-- end of navigation -->

<!-- Session Status -->
<!-- Header -->
<header id="header" class="ex-2-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Inicia Sesión</h1>
                <p>No tienes una cuenta? Por favor <a class="white" href="{{ route('register') }}">Crea una</a></p>

                <!-- Sign Up Form -->
                <div class="form-container">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <input type="email" id="email" class="form-control-input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="username">
                            <label for="email" class="label-control">Correo electrónico</label>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    @foreach ($errors->get('email') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="password" id="password" class="form-control-input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required autocomplete="current-password">
                            <label for="password" class="label-control">Contraseña</label>
                            @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    @foreach ($errors->get('password') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="form-control-submit-button">{{ __('Iniciar Sesión') }}</button>
                        </div>

                    </form>
                </div> <!-- end of form container -->

                <!-- end of sign up form -->

            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</header> <!-- end of ex-header -->
<!-- end of header -->


@include('layouts.scripts')
</body>
</html>

