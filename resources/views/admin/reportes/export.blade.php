@extends('adminlte::page')

@section('title', 'Medicamentos Reportes')

@section('content_header')
<h2>Medicamentos </h2>
<hr>
<a class="btn btn-success" href="{{ route('export.pdf', ['busqueda' => $busqueda]) }}" target="_blank">Descargar reporte</a>

<form action="{{url('admin/reportes/export')}}" style="display:inline" method="get">
    <div class="btn-group">
        <input type="text" name="busqueda" class="form-control">
        <input type="submit" value="Buscar" class="btn btn-primary">
    </div>
</form>
@stop

@section('content')


<table class="table table-light">
    <thead class="thead-light w-100">
        <tr>

            <th>Nombre</th>
            <th>Fabricante</th>
            <th>Descripcion</th>
            <th>País de Fabricación</th>
            <th>Categoría</th>
            <th>Precio</th>

        </tr>
    </thead>
    <tbody>
        @foreach($Medicamentos as $medicamento)
        <tr>
            <td>{{$medicamento->nombre}}</td>
            <td>{{$medicamento->fabricante}}</td>
            <td>{{$medicamento->descripcion}}</td>
            <td>{{$medicamento->pais_fabricacion}}</td>
            <td>{{$medicamento->categoria}}</td>
            <td>{{$medicamento->precio}} Bs</td>

        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="display: none;">{{$Medicamentos->appends(['busqueda'=>$busqueda])}}</td>
        </tr>
    </tfoot>
</table>



@stop

@section('css')
{{-- --}}
<link rel="stylesheet" href="{{ asset('/build/assets/admin/admin.css') }}">
<link rel="stylesheet" href="{{ asset('/build/assets/admin/index.css') }}">
@stop

@section('js')

@stop