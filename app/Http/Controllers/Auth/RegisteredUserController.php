<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Farmacia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('welcome'); // Vista del formulario de registro
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Log para depuración
        Log::info('Formulario enviado', $request->all());

        // Validación de los datos de la solicitud
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'cedula' => ['required', 'string', 'max:20', 'unique:users'],
            'telefono' => ['required', 'string', 'max:15'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'usertype' => ['required', 'string', 'in:user,admin'], // Validar el usertype
        ]);

        Log::info('Datos validados', $validated);

        // Creación del nuevo usuario
        $user = User::create([
            'name' => $validated['name'],
            'apellido' => $validated['apellido'],
            'cedula' => $validated['cedula'],
            'telefono' => $validated['telefono'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'usertype' => $validated['usertype'], // Tipo de usuario por defecto
        ]);

        // Autenticar al usuario recién registrado
        Auth::login($user);

        // Redirigir al usuario a la página correspondiente según su tipo
        if ($user->usertype === 'admin') {
            return redirect()->route('admin.configuracion'); // Redirigir al panel de administración
        } else {
            return redirect()->route('user.configuracion'); // Redirigir a la página del usuario
        }
    }

    public function guardarDireccion(Request $request)
    {
        // Validar que el nombre y la ubicación sean correctos
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',  // Validar que la ubicación está presente
        ]);

        // Comprobar si location contiene latitud y longitud separadas por espacio
        $coordinates = explode(' ', $request->location);
        if (count($coordinates) !== 2) {
            return back()->withErrors(['location' => 'La ubicación debe contener latitud y longitud válidas.']);
        }

        $latitude = $coordinates[0];
        $longitude = $coordinates[1];

        // Verificar que los valores de latitud y longitud sean válidos (números)
        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            return back()->withErrors(['location' => 'La latitud y longitud deben ser valores numéricos.']);
        }

        // Guardar las coordenadas en la base de datos usando ST_GeomFromText para almacenar como POINT
        DB::table('user_addresses')->insert([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'location' => DB::raw("ST_GeomFromText('POINT({$latitude} {$longitude})')"),
        ]);

        return redirect()->route('user.home')->with('success', 'Dirección guardada correctamente.');
    }

    public function guardarFarmacia(Request $request)
    {
        // Validamos los campos
        $request->validate([
            'nombre_razon_social' => 'required|string|max:255',
            'rif' => 'required|string|max:20',
            'location' => 'required|string',  // Validamos que haya una ubicación seleccionada
        ]);

        // Separar las coordenadas
        $coordinates = explode(' ', $request->location);
        if (count($coordinates) !== 2) {
            return back()->withErrors(['location' => 'La ubicación debe contener latitud y longitud válidas.']);
        }

        $latitude = $coordinates[0];
        $longitude = $coordinates[1];

        // Verificar si el usuario ya está asociado a una farmacia
        $usuario = auth()->user();

        if ($usuario->farmacias()->exists()) {
            return redirect()->back()->withErrors(['usuario' => 'Este administrador ya está asociado a una farmacia.']);
        }

        // Guardar la farmacia en la base de datos
        $farmacia = Farmacia::create([
            'nombre_razon_social' => $request->nombre_razon_social,
            'rif' => $request->rif,
            'ubicacion' => DB::raw("ST_GeomFromText('POINT({$latitude} {$longitude})')"),  // Guardar como POINT
        ]);

        // Asociar el administrador a la farmacia en la tabla intermedia
        $farmacia->administradores()->attach($usuario->id);

        return redirect()->route('admin.dashboard')->with('success', 'Farmacia registrada y administrador asociado correctamente.');
    }



}

