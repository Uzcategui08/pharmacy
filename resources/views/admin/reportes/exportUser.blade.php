@extends('adminlte::page')

@section('title', 'Medicamentos Reportes')

@section('content_header')
<h2>Usuarios </h2>
<hr>
<a class="btn btn-success" href="{{ route('exportUser.pdfUser', ['busqueda' => $busqueda]) }}" target="_blank">Descargar reporte</a>

<form action="{{url('admin/reportes/exportUser')}}" style="display:inline" method="get">
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
            <th>Email</th>
            <th>Edad</th>
            <th>Numero</th>

        </tr>
    </thead>
    <tbody>
        @foreach($users as $usuario)
        <tr>
            <td>{{$usuario->name}}</td>
            <td>{{$usuario->email}}</td>
            <td>{{$usuario->edad}}</td>
            <td>{{$usuario->numero}}</td>

        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="display: none;">{{$users->appends(['busqueda'=>$busqueda])}}</td>
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