
@extends('adminlte::page')

@section('title', 'Edit')

@section('content_header')
<h2>Editar Producto</h2>
<hr>
@stop

@section('content')
<form action="{{url('/admin/crud/index/'.$medicamentos->id_medicamento)}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
{{method_field('PATCH')}}

@include('admin/crud/formulario',['Modo' => 'editar'])

<link rel="stylesheet" href="{{ asset('/build/assets/admin/admin.css') }}">
@stop

@section('css')
    {{-- --}}

@stop

@section('js')

@stop
