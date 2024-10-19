@extends('layouts1.user')

@section('title', 'Carrito - Sistema de Medicinas')

@section('content')
    <div class="container mt-4">
        <h1>Apartados</h1>
        <hr>

        @php
            $carrito = $carrito ?? collect([]);
        @endphp

        @if ($apartados->isEmpty())
            <p>No tienes ningún apartado.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Farmacia</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Acciones</th>
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
                        <td>
                            <button class="btn btn-primary btn-sm open-modal" data-id="{{ $apartado->id }}" data-toggle="modal" data-target="#detallesModal">
                                Ver Detalles
                            </button>
                            @if ($apartado->estado === 'cancelado')
                                <button class="btn btn-secondary btn-sm" disabled>Cancelado</button>
                            @else
                                <form action="{{ route('apartados.cancelar', $apartado->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm">Cancelar Apartado</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{url ('user/home')}}">
            <button class="btn-regresar">
                <div class="sign"><svg viewBox="0 0 512 512">
                        <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4
                                    6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32
                                    32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32
                                    32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0
                                    128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
                <div class="text">Regresar</div>
            </button>
        </a>
    </div>

    <!-- Modal para mostrar los detalles del apartado -->
    <div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detallesModalLabel">Detalles del Apartado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Medicamento</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody id="modal-body">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
