@extends('layouts1.user')

@section('title', 'Carrito - Sistema de Medicinas')

@section('content')
    <div class="container mt-4">
        <h1>Contenido del Carrito</h1>

        @php
            $carrito = $carrito ?? collect([]);
        @endphp

        @if ($carrito->count() > 0)
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nombre del Medicamento</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody id="carrito-body">
                @foreach ($carrito as $idMedicamento => $item)
                    <tr data-id="{{ $idMedicamento }}">
                        <td>{{ $item['nombre'] }}</td>
                        <td>
                            <div class="quantity-controls">
                                <button class="btn btn-secondary btn-sm decrement">-</button>
                                <input type="text" class="form-control cantidad" value="{{ $item['cantidad'] }}" readonly>
                                <button class="btn btn-secondary btn-sm increment">+</button>
                            </div>
                        </td>
                        <td>${{ $item['precio'] }}</td>
                        <td>${{ $item['cantidad'] * $item['precio'] }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm btn-delete">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-right">
                @php
                    $total = $carrito->reduce(function ($carry, $item) {
                        return $carry + ($item['cantidad'] * $item['precio']);
                    }, 0);
                @endphp
                <h4>Total: ${{ $total }}</h4>
            </div>
        @else
            <p>No hay productos en el carrito.</p>
        @endif
    </div>


@endsection
