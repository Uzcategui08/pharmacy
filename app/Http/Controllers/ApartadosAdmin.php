<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Apartado;
use Illuminate\Http\Request;

class ApartadosAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $apartados = $this->mostrarApartados();

        // Verifica si se encontraron farmacias
        if (is_null($apartados)) {
            return redirect()->back()->withErrors('Este administrador no tiene una farmacia asociada.');
        }
        return view('admin/apartados/apartadosA', compact('apartados'));
    }
    public function mostrarApartados()
    {
        $usuario = auth()->user();
        $apartados = $usuario->farmacias()->first();

        if (!$apartados) {
            // Retorna null o lanza una excepción si no hay farmacia
            return null;
        }
        // Obtiene las farmacias asociadas
        return Apartado::where('id_farmacia', $apartados->id_farmacia)
            ->where('estado', 'pendiente') // Filtra por estado "pendiente"
            ->get();
    }

    public function aprobar($id)
    {
        $apartado = Apartado::findOrFail($id);
        $apartado->estado = 'aprobado';
        $apartado->save();

        return redirect()->back()->with('success', 'Estado actualizado a aprobado.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
