<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Inventario;
use App\Http\Controllers\Controller;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class AlmacenControllerAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // En el modelo Almacen
     //

        public function index()
        {
            $Almacen = $this->mostrarApartados();

            // Verifica si se encontraron farmacias
            if (is_null($Almacen)) {
                return redirect()->back()->withErrors('Este administrador no tiene una farmacia asociada.');
            }
            return view('admin/almacen/almacen',compact('Almacen'));
        }

        public function mostrarApartados()
        {
            $usuario = auth()->user();
            $Almacen = $usuario->farmacias()->first();
    
            if (!$Almacen) {
                // Retorna null o lanza una excepción si no hay farmacia
                return null;
            }
    
            // Obtiene las farmacias asociadas
            return Inventario::where('id_farmacia', $Almacen->id_farmacia)->get();
        }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $datos['Medicamentos'] = Medicamento::all();
        return view('admin/almacen.create', $datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //
        $validatedData = $request->validate(
            [
                'id_medicamento' => 'required|integer',
                'id_farmacia' => 'required|integer',
                'numero_lote' => 'required|integer',
                'fecha_vencimiento' => 'required|date',
                'cantidad_disponible' => 'required|integer',
            ],
            $mensaje = [
                "required" => 'Rellenar el campo :attribute es obligatorio.'
            ]
        );

        $datosAlmacen = request()->except('_token');


        Inventario::insert($datosAlmacen);

        return redirect('admin/almacen/almacen')->with('Mensaje', 'Producto agregado con exito');
    }


    /**
     * Display the specified resource.
     */
    public function show(Inventario $almacen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventario $almacen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventario $id)
    {
        //
        $validatedData = $request->validate( [
            'id_medicamento' => 'required|integer',
            'id_farmacia' => 'required|integer',
            'numero_lote' => 'required|integer',
            'fecha_vencimiento' => 'required|date',
            'cantidad_disponible' => 'required|integer',
        ]);



        return redirect('admin/almacen/almacen')->with('Mensaje', 'Producto modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventario $almacen, $id) {}
}
