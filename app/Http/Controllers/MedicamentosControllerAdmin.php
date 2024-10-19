<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicamentosControllerAdmin extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Medicamentos = $this->mostrarMedicamentos();

        // Verifica si se encontraron farmacias
        if (is_null($Medicamentos)) {
            return redirect()->back()->withErrors('Este administrador no tiene una farmacia asociada.');
        }

        return view('admin/crud/index', compact('Medicamentos'));
    }

    public function mostrarMedicamentos()
    {
        $usuario = auth()->user();
        $Medicamentos = $usuario->farmacias()->first();

        if (!$Medicamentos) {
            // Retorna null o lanza una excepción si no hay farmacia
            return null;
        }

        // Obtiene las farmacias asociadas
        return Medicamento::where('id_farmacia', $Medicamentos->id_farmacia)->get();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/crud/create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        //
        $validatedData = $request->validate(
            [
                'nombre' => 'required|string|max:100',
                'fabricante' => 'required|string|max:100',
                'descripcion' => 'required|string',
                'pais_fabricacion' => 'required|string',
                'categoria' => 'required|string',
                'id_farmacia' => 'required|integer',
                'precio' => 'required|numeric|min:0',
                'Foto' => 'required|max:10000|mimes:jpeg,png,jpg',
            ],
            $mensaje = [
                "required" => 'Rellenar el campo :attribute es obligatorio.'
            ]
        );

        $datosMedicamentos = request()->except('_token');

        if ($request->hasFile('Foto')) {
            $datosMedicamentos['Foto'] = $request->file('Foto')->store('medicamentos', 'public');
        };

        Medicamento::insert($datosMedicamentos);

        return redirect('admin/crud/index')->with('Mensaje', 'Producto agregado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicamento $medicamentos)
    {
        //$datos['Medicamentos']=medicamentos::paginate(5);
        //return view('admin/crud/index', $datos);

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $medicamentos = Medicamento::where('id_medicamento', $id)->firstOrFail();

        return view('/admin/crud/edit', compact('medicamentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'fabricante' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'pais_fabricacion' => 'required|string',
            'categoria' => 'required|string',
            'id_farmacia' => 'required|integer',
            'precio' => 'required|numeric|min:0',
            'Foto' => 'nullable|max:10000|mimes:jpeg,png,jpg',
        ]);

        if ($request->hasFile('Foto')) {

            $validatedData += ['Foto' => 'required|max:10000|mimes:jpeg,png,jpg'];
        }
        $mensaje = [
            "required" => 'Rellenar el campo :attribute es obligatorio.'
        ];
        $datosMedicamentos = request()->except(['_token', '_method']);

        if ($request->hasFile('Foto')) {
            $medicamentos = Medicamento::where('id_medicamento', $id)->firstOrFail();
            Storage::delete('public/' . $medicamentos->Foto);
            $datosMedicamentos['Foto'] = $request->file('Foto')->store('medicamentos', 'public');
        };
        $medicamentos = Medicamento::where('id_medicamento', $id)->update($datosMedicamentos);


        return redirect('admin/crud/index')->with('Mensaje', 'Producto modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $medicamentos = Medicamento::where('id_medicamento', $id)->firstOrFail();

        if (Storage::delete('public/' . $medicamentos->Foto)) {
            Medicamento::destroy($id);
        }


        return redirect('/admin/crud/index')->with('Mensaje', 'Producto eliminado con exito');
    }

}
