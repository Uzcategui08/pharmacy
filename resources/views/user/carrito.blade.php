@extends('layouts1.user')

@section('title', 'Carrito - Sistema de Medicinas')

@section('content')
    <div class="container mt-4">
        <h1>Carrito</h1>
        <hr>

        @php
            $carrito = $carrito ?? collect([]);
        @endphp

        @if ($carrito->count() > 0)
            <div class="row">
                <div class="col-md-8">
                    <table class="table">
                        <thead>
                        <tr style="text-align: center; align-items: center">
                            <th width="20%"></th>
                            <th width="15%">MEDICAMENTO</th>
                            <th width="10%">CANTIDAD</th>
                            <th width="20%">PRECIO C/U</th>
                            <th width="20%">TOTAL</th>
                            <th width="25%"></th>
                        </tr>
                        </thead>
                        <tbody id="carrito-body" style="text-align: center">
                        @foreach ($carrito as $idMedicamento => $item)
                            <tr data-id="{{ $idMedicamento }}">
                                <td>
                                    @if (isset($item['image_path']) && $item['image_path'] !== 'placeholder')
                                        <img src="{{ asset($item['image_path']) }}" alt="{{ $item['nombre'] }}" class="img-thumbnail" style="width: 100px;">
                                    @else
                                        @php
                                            $nombre = urlencode($item['nombre']);
                                        @endphp
                                        <img src="https://via.placeholder.com/100x100.png?text={{ $nombre }}" alt="Imagen no disponible" class="img-thumbnail" style="width: 100px;">
                                    @endif
                                </td>
                                <td>{{ $item['nombre'] }}</td>
                                <td>
                                    <div class="quantity">
                                        <button class="qty-buttom minus decrement" type="buttom">
                                            <i class="fa fa-solid fa-minus"></i>
                                        </button>
                                        <input type="text" id="qtyInput" class="cantidad" value="{{ $item['cantidad'] }}" readonly>
                                        <button class="qty-buttom plus increment" type="buttom">
                                            <i class="fa fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>${{ number_format($item['precio'], 2) }}</td>
                                <td>${{ number_format($item['cantidad'] * $item['precio'], 2) }}</td>
                                <td class="bin-cell">
                                    <button class="bin-button">
                                        <svg
                                            class="bin-top"
                                            viewBox="0 0 39 7"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <line y1="5" x2="39" y2="5" stroke="white" stroke-width="4"></line>
                                            <line
                                                x1="12"
                                                y1="1.5"
                                                x2="26.0357"
                                                y2="1.5"
                                                stroke="white"
                                                stroke-width="3"
                                            ></line>
                                        </svg>
                                        <svg
                                            class="bin-bottom"
                                            viewBox="0 0 33 39"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <mask id="path-1-inside-1_8_19" fill="white">
                                                <path
                                                    d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"
                                                ></path>
                                            </mask>
                                            <path
                                                d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"
                                                fill="white"
                                                mask="url(#path-1-inside-1_8_19)"
                                            ></path>
                                            <path d="M12 6L12 29" stroke="white" stroke-width="4"></path>
                                            <path d="M21 6V29" stroke="white" stroke-width="4"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 no-padding">
                    <div class="card-apart">
                        @php
                            $total = $carrito->reduce(function ($carry, $item) {
                                return $carry + ($item['cantidad'] * $item['precio']);
                            }, 0);
                        @endphp
                        <div class="d-flex justify-content-between px-3 pt-4">
                            <span class="pay">Cantidad a Pagar</span>
                            <div class="amount">
                                <div class="inner">
                                    <span id="total-price">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="align-items-center justify-content-center px-3 py-4">
                            <div>
                                <a href="{{ url('user/apartado') }}">
                                    <form action="{{ route('realizar.apartado') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn payment">Realizar apartado</button>
                                    </form>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        @else
            <p>No hay productos en el carrito.</p>
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
@endsection
