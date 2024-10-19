<!DOCTYPE html>
<html lang="en">
<head>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">

        <!-- Text Logo - Use this if you don't have a graphic logo -->
        <!-- <a class="navbar-brand logo-text page-scroll" href="index.html">Tivo</a> -->

        <!-- Image Logo -->


    </div> <!-- end of container -->
</nav> <!-- end of navbar -->
<!-- end of navigation -->



<!-- Header -->
<header id="header" class="ex-2-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Registrar Cuenta</h1>
                <p>Rellene la información para crear la cuenta.<br>Ya posee una? Por favor, <a class="white" href="{{ route('login') }}">Inicie Sesión</a></p>
                <!-- Sign Up Form -->
                <div class="form-container">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <input type="text" id="name" class="form-control-input{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required autofocus autocomplete="name">
                            <label for="name" class="label-control">Name</label>
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    @foreach ($errors->get('name') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Email Address -->
                        <div class="form-group">
                            <input type="email" id="email" class="form-control-input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required autocomplete="email">
                            <label for="email" class="label-control">Email</label>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    @foreach ($errors->get('email') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <input type="password" id="password" class="form-control-input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="new-password">
                            <label for="password" class="label-control">Password</label>
                            @if ($errors->has('password'))
                                <div class="help-block with-errors">
                                    @foreach ($errors->get('password') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <input type="password" id="password_confirmation" class="form-control-input{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required autocomplete="new-password">
                            <label for="password_confirmation" class="label-control">Confirm Password</label>
                            @if ($errors->has('password_confirmation'))
                                <div class="help-block with-errors">
                                    @foreach ($errors->get('password_confirmation') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>


                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="form-control-submit-button">{{ __('Register') }}</button>
                        </div>

                    </form>
                </div> <!-- end of form container -->
                <!-- end of sign up form -->

            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</header> <!-- end of ex-header -->
<!-- end of header -->

</body>
</html>

