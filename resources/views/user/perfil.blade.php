@extends('layouts1.user')

@section('title', 'Perfil - Sistema de Medicinas')

@section('content')
    <div class="container-custom profile-container-custom mt-4">
        <div class="profile-header">
            <h2>Perfil</h2>
            <p class="text-center mt-2">Actualiza tu información de perfil</p>
            <hr>
        </div>
        <div class="profile-content">
            <form class="profile-form" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="mb-3 position-relative">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control profile-input" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control profile-input" id="apellido" name="apellido" value="{{ old('apellido', $user->apellido) }}" required>
                    @error('apellido')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <label for="cedula" class="form-label">Cédula</label>
                    <input type="text" class="form-control profile-input" id="cedula" name="cedula" value="{{ old('cedula', $user->cedula) }}" required>
                    @error('cedula')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control profile-input" id="telefono" name="telefono" value="{{ old('telefono', $user->telefono) }}" required>
                    @error('telefono')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <?php /*
                <div class="mb-3 position-relative">
                    <label for="direccion" class="form-label">Dirección</label>
                    <textarea class="form-control profile-input" id="direccion" name="direccion" rows="3" required>{{ old('direccion', $user->direccion) }}</textarea>
                    @error('direccion')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                */ ?>


                <div class="mb-3 position-relative">
                    <label for="direccion" class="form-label">Direccion</label>
                    <select name="address_id" id="addressSelect" class="form-select">
                        @forelse(auth()->user()->addresses as $address)
                            <option value="{{ $address->id }}">{{ $address->name }}</option>
                        @empty
                            <option value="" disabled>No tienes direcciones guardadas.</option>
                        @endforelse
                    </select>
                </div>
                <a href="{{ route('user.configuracion') }}">Agregar direcciones</a>
                <hr>

                <div class="mb-3 position-relative">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control profile-input" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="mt-2 text-gray-800">
                            {{ __('Tu dirección de correo electrónico no está verificada.') }}
                            <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Haz clic aquí para reenviar el correo de verificación.') }}</button>
                            </form>
                            @if (session('status') === 'verification-link-sent')
                                <div class="alert alert-success mt-2">
                                    {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-custom">Guardar Cambios</button>
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success mt-2">
                        {{ __('Guardado.') }}
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="container-custom profile-container-custom password-container-custom mt-4">
        <div class="profile-header">
            <h2>Actualizar Contraseña</h2>
            <p class="text-center mt-2">Asegúrate de usar una contraseña segura</p>
            <hr>
        </div>
        <div class="profile-content">
            <form class="password-form" method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                <div class="mb-3 position-relative">
                    <label for="current_password" class="form-label">Contraseña Actual</label>
                    <input type="password" class="form-control password-input" id="current_password" name="current_password" required>
                    @error('current_password', 'updatePassword')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 position-relative">
                    <label for="new_password" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control password-input" id="new_password" name="password" required>
                    @error('password', 'updatePassword')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 position-relative">
                    <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-control password-input" id="password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation', 'updatePassword')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-custom">Actualizar Contraseña</button>
                @if (session('status') === 'password-updated')
                    <div class="alert alert-success mt-2">
                        {{ __('Guardado.') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
    <a href="{{url ('user/home')}}">
        <button class="btn-regresar">
            <div class="sign"><svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4
                                6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32
                                32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32
                                32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0
                                128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
            <div class="text">Regresar</div>
        </button>
    </a>
    <br>
@endsection
