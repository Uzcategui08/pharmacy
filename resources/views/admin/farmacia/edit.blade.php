
@extends('adminlte::page')

@section('title', 'Edit')

@section('content_header')

@stop

@section('content')
<form action="{{url('/admin/farmacia/farmacias/'.$farmacias->id_farmacia)}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
{{method_field('PATCH')}}
<div class="form-group">
    <label for="nombre_razon_social" class="control-label">{{'nombre'}}</label>
    <input type="text" class="form-control {{$errors->has('nombre_razon_social')?'is-invalid':''}}" name="nombre_razon_social" id="nombre_razon_social" value="{{isset($farmacias->nombre_razon_social)?$farmacias->nombre_razon_social:old('nombre_razon_social')}}">
    {!!$errors->first('nombre','<div class="invalid-feedback">:message</div>')!!}
<div class="invalid-feedback"></div>

</div>

<div class="form-group">
    <label for="descripcion" class="control-label">{{'descripcion'}}</label>
    <input type="text" class="form-control {{$errors->has('descripcion')?'is-invalid':''}}" name="descripcion" id="descripcion" value="{{isset($farmacias->descripcion)?$farmacias->descripcion:old('descripcion')}}">
    {!!$errors->first('descripcion','<div class="invalid-feedback">:message</div>')!!}
</div>

<div class="form-group">
<label class="control-label" for="imagen">{{'imagen'}}</label>
@if(isset($farmacias->imagen))
<br>
<img src="{{asset('storage').'/'.$farmacias->imagen}}" width="200px" class="img-thumbnail img-fluid">
<br>
@endif
<input class="form-control {{$errors->has('imagen')?'is-invalid':''}}" type="file" nombre="imagen" id="imagen">
{!!$errors->first('imagen','<div class="invalid-feedback">:message</div>')!!}
</div>

<input type="submit" class="btn btn-success" value="Modificar">
<a class="btn btn-secondary" href="{{url('admin/farmacia/farmacias')}}">Regresar</a>

</form>

<link rel="stylesheet" href="{{ asset('/build/assets/admin/admin.css') }}">
@stop

@section('css')
    {{-- --}}

@stop

@section('js')

@stop
