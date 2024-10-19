<?php

namespace App\Http\Controllers;

use App\Models\Farmacia;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    // página de inicio principal del usuario cliente
    // página de inicio principal del usuario cliente
    public function index()
    {
        $medicamentos = Medicamento::all();
        $farmacias = DB::select("
        SELECT id_farmacia, nombre_razon_social, rif,
            ST_X(ubicacion) AS latitud,
            ST_Y(ubicacion) AS longitud
        FROM farmacias
    ");

        $carrito = session('carrito', []);
        $totalItems = array_sum($carrito);

        $nuevosMedicamentos = Medicamento::orderBy('created_at', 'desc')
            ->take(9)
            ->get();

        return view('user.home', compact('medicamentos', 'farmacias', 'totalItems', 'nuevosMedicamentos'));
    }

    //contador de items para el carrito actual
    public function getCartCount()
    {
        $carrito = session('carrito', []);

        $totalItems = array_sum($carrito);

        return response()->json(['totalItems' => $totalItems]);
    }


}
