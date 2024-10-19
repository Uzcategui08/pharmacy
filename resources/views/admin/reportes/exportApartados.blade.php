@extends('adminlte::page')

@section('title', 'Apartados Reportes')

@section('content_header')
<h2>Medicamentos </h2>
<hr>
<a class="btn btn-success" href="{{ route('exportApartados.pdfApartados', ['busqueda' => $busqueda]) }}" target="_blank">Descargar reporte</a>

<form action="{{url('admin/reportes/exportApartados')}}" style="display:inline" method="get">
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
      <th>ID</th>
      <th>Farmacia</th>
      <th>Fecha</th>
      <th>Estado</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($apartados as $apartado)
    <tr>
      <td>{{ $apartado->id }}</td>
      <td>{{ $apartado->farmacia->nombre_razon_social }}</td>
      <td>{{ $apartado->fecha }}</td>
      <td>{{ $apartado->estado }}</td>
      <td>{{ $apartado->detalles->sum('precio') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<tfoot>
  <tr>
    <td colspan="4" style="display: none;">{{$apartados->appends(['busqueda'=>$busqueda])}}</td>
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