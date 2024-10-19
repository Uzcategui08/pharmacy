
@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
<h2>Agregar producto</h2>
<hr>
@stop

@section('content')



<form action="{{url('/admin/crud/index')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
<div class="container">
{{ csrf_field() }}

@include('admin/crud/formulario',['Modo' => 'crear'])
</div>
<link rel="stylesheet" href="{{ asset('/build/assets/admin/admin.css') }}">
@stop

@section('css')
    {{-- --}}

@stop

@section('js')

@stop
