@extends('adminlte::page')

@section('title', 'Medicamentos')

@section('content_header')
<h2>Productos</h2>
<hr>
<input type="text" id="search" placeholder="Buscar medicamentos..." style="margin-bottom: 20px; width: 100%; padding: 10px;">
@if(Session::has('Mensaje'))

<div class="alert alert-success" role="alert">{{ Session::get('Mensaje') }}</div>

@endif
<a href="{{url('admin/crud/index/create')}}" class="btn btn-primary">Agregar Producto</a>
@stop

@section('content')


<table class="table table-light">
    <thead class="thead-light w-100">
        <tr>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Fabricante</th>
            <th>Descripcion</th>
            <th>País de Fabricación</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($Medicamentos as $medicamento)
        <tr>
            <td data-label="Foto">
                <img src="{{asset('storage').'/'.$medicamento->Foto}}" width="100px" class="rounded">
            </td>
            <td data-label="Nombre">{{$medicamento->nombre}}</td>
            <td data-label="Fabricante">{{$medicamento->fabricante}}</td>
            <td data-label="Descripción">{{$medicamento->descripcion}}</td>
            <td data-label="País de Fabricación">{{$medicamento->pais_fabricacion}}</td>
            <td data-label="Categoría">{{$medicamento->categoria}}</td>
            <td data-label="Precio">{{$medicamento->precio}} Bs</td>

            <td data-label="Acciones">
                <a class="btn btn-success" href="{{url('admin/crud/index/'.$medicamento->id_medicamento.'/edit')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                    </svg>
                </a>
                |
                <form method="post" action="{{ url('admin/crud/index/' .$medicamento->id_medicamento) }}" style="display:inline">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button class="btn btn-danger" type="submit" onclick="return confirm('Borrar?');">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                        </svg>
                    </button>
                </form>
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