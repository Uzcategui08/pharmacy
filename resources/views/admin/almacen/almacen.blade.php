@extends('adminlte::page')

@section('title', 'Almacen')

@section('content_header')
<h2>Almacen</h2>
<hr>
<a href="{{url('admin/almacen/almacen/create')}}" class="btn btn-primary">Agregar Lote</a>
@stop

@section('content')


<table class="table table-light">
    <thead class="thead-light w-100">
        <tr>
        <th>Foto</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Lote</th>
            <th>Vencimiento</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($Almacen as $almacen)
        <tr>
<!-- Mostrar solo el nombre y foto del medicamento relacionado -->
@if($almacen->medicamento) <!-- Asegúrate de tener una relación definida -->
    <td data-label="Foto">
        <img src="{{ asset('storage/' . $almacen->medicamento->Foto) }}" width="100px" class="rounded">
    </td>
    <td data-label="Nombre">{{ $almacen->medicamento->nombre }}</td>
@else
    <td data-label="Foto">No disponible</td>
    <td data-label="Nombre">No disponible</td>
@endif
            <td data-label="Cantidad">{{$almacen->cantidad_disponible}}</td>
            <td data-label="Lote">{{$almacen->numero_lote}}</td>
            <td data-label="Vencimiento">{{$almacen->fecha_vencimiento}}</td>

            <td data-label="Acciones">
                <a class="btn btn-success" href="{{url('admin/almacen'.$almacen->id.'/formulario')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                    </svg>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop

@section('css')
{{-- --}}
<link rel="stylesheet" href="{{ asset('/build/assets/admin/admin.css') }}">
<link rel="stylesheet" href="{{ asset('/build/assets/admin/index.css') }}">
@stop

@section('js')
<script rel="stylesheet" href="{{ asset('/build/assets/admin/index.js') }}"></script>
@stop