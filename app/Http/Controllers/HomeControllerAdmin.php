<?php

namespace App\Http\Controllers;

use App\Models\Apartado;
use App\Models\Medicamento;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class HomeControllerAdmin extends Controller
{
    public function index()
    {
        ///////////////////////////////////////////////////Datos
        // Contar la cantidad de usuarios en la tabla 'users'
        $userCount = User::count();
        $medCount = Medicamento::count();
        $apaCount = Apartado::Where('estado','aprobado')->count();


        ////////////////////////////////////////////////Graficos
        $resultados = Medicamento::select('pais_fabricacion', DB::raw('count(*) as total'), DB::raw('(pais_fabricacion) as pais1'))
           ->groupby('pais_fabricacion')
           ->orderby('pais1')
           ->get();
           $resultados1 = Medicamento::select('categoria', DB::raw('count(*) as total'), DB::raw('(categoria) as cat'))
           ->groupby('categoria')
           ->orderby('cat')
           ->get();

        // Pasar la cantidad a la vista
        return view('admin.dashboard', ['userCount' => $userCount, 'medCount' => $medCount, 'resultados' => $resultados, 
        'resultados1'=>$resultados1, 'resultadosApa' =>$apaCount]);
    }
}
