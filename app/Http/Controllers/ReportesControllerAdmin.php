<?php

namespace App\Http\Controllers;

use App\Models\Apartado;
use App\Models\Medicamento;
use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportesControllerAdmin extends Controller
{
    public function index(Request $request)
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();

        // Obtener la primera farmacia asociada al usuario
        $farmacia = $usuario->farmacias()->first();

        if (!$farmacia) {
            // Retornar un mensaje o redirigir si no hay farmacias
            return redirect()->back()->with('error', 'No tienes farmacias asociadas.');
        }

        // Obtener la búsqueda del request
        $busqueda = $request->busqueda;

        // Buscar medicamentos en la farmacia del usuario según la búsqueda
        $datos = Medicamento::where('Nombre', 'LIKE', '%' . $busqueda . '%')
            ->where('id_farmacia', $farmacia->id_farmacia) // Filtrar por la farmacia del usuario
            ->simplePaginate(20);

        // Preparar los datos para la vista
        $datosArray = [
            'Medicamentos' => $datos,
            'busqueda' => $busqueda,
        ];

        return view('admin/reportes/export', $datosArray);
    }
    public function exportPdf(Request $request)
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();

        // Obtener la primera farmacia asociada al usuario
        $farmacia = $usuario->farmacias()->first();

        if (!$farmacia) {
            // Retornar un mensaje o redirigir si no hay farmacias
            return redirect()->back()->with('error', 'No tienes farmacias asociadas.');
        }

        // Obtener el término de búsqueda del request
        $busqueda = $request->query('busqueda');

        // Buscar medicamentos en la misma farmacia según la búsqueda
        $medicamentos = Medicamento::where('Nombre', 'LIKE', '%' . $busqueda . '%')
            ->where('id_farmacia', $farmacia->id_farmacia) // Filtrar por la farmacia del usuario
            ->get();

        // Crear el PDF usando los datos filtrados
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin/reportes/pdf', compact('medicamentos'));

        return $pdf->stream('reportes.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function indexUser(Request $request)
    {
        $busqueda = $request->busqueda;
        $datos = User::where('name', 'LIKE', '%' . $busqueda . '%')
            ->simplePaginate(20);

        // Calcular la edad para cada usuario
        foreach ($datos as $user) {
            if ($user->edad) { // Asegúrate de que la fecha de nacimiento no sea nula
                $user->edad = Carbon::parse($user->edad)->age;
            } else {
                $user->edad = null; // O establece un valor predeterminado si no hay fecha
            }
        }

        $datosArray = [
            'users' => $datos,
            'busqueda' => $busqueda,
        ];

        return view('admin/reportes/exportUser', $datosArray);
    }

    public function exportPdf2(Request $request)
    {
        // Get the search term from the request
        $busqueda = $request->query('busqueda');

        // Fetch the filtered data based on the search term
        $users = User::where('name', 'LIKE', '%' . $busqueda . '%')->get();

        // Calcular la edad para cada usuario
        foreach ($users as $user) {
            if ($user->edad) { // Asegúrate de que la fecha de nacimiento no sea nula
                $user->edad = Carbon::parse($user->edad)->age;
            } else {
                $user->edad = null; // O establece un valor predeterminado si no hay fecha
            }
        }

        // Create the PDF using the filtered data
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin/reportes/pdfUser', compact('users'));

        return $pdf->stream('reportes.pdfUser');
    }
    public function indexApartados(Request $request)
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();

        // Obtener la primera farmacia asociada al usuario
        $farmacia = $usuario->farmacias()->first();

        if (!$farmacia) {
            // Retornar un mensaje o redirigir si no hay farmacias
            return redirect()->back()->with('error', 'No tienes farmacias asociadas.');
        }

        // Obtener la búsqueda del request
        $busqueda = $request->busqueda;

        // Buscar medicamentos en la farmacia del usuario según la búsqueda
        $datos = Apartado::where('id', 'LIKE', '%' . $busqueda . '%')
            ->where('id_farmacia', $farmacia->id_farmacia)
            ->where('estado', 'aprobado') // Filtrar por la farmacia del usuario
            ->simplePaginate(20);

        // Preparar los datos para la vista
        $datosArray = [
            'apartados' => $datos,
            'busqueda' => $busqueda,
        ];

        return view('admin/reportes/exportApartados', $datosArray);
    }
    public function exportPdf3(Request $request)
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();

        // Obtener la primera farmacia asociada al usuario
        $farmacia = $usuario->farmacias()->first();

        if (!$farmacia) {
            // Retornar un mensaje o redirigir si no hay farmacias
            return redirect()->back()->with('error', 'No tienes farmacias asociadas.');
        }

        // Obtener el término de búsqueda del request
        $busqueda = $request->query('busqueda');

        // Buscar medicamentos en la misma farmacia según la búsqueda
        $apartados = Apartado::where('id', 'LIKE', '%' . $busqueda . '%')
            ->where('id_farmacia', $farmacia->id_farmacia)
            ->where('estado', 'aprobado')
            ->get();

        // Crear el PDF usando los datos filtrados
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin/reportes/pdfApartados', compact('apartados'));

        return $pdf->stream('reportes.pdfApartados');
    }
}
