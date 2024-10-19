@extends('layouts1.user')

@section('title', 'Home - Lista de Favoritos')

@section('content')
<div class="container mt-4">
    <h1>Lista de Favoritos</h1>
    <hr>

    @if($wishlistItems->isEmpty())
    <p>No tienes productos en tu lista de deseos.</p>
@else
    <div class="row">
        @foreach($wishlistItems as $item)
            <div id="wishlist-item-{{ $item->id }}" class="col-md-3 mb-4">
                <div class="card">
                    @if($item->medicamento->image_path)
                        <img src="{{ asset($item->medicamento->image_path) }}" alt="{{ $item->medicamento->nombre }}" class="card-img-top">
                    @else
                        <img src="https://via.placeholder.com/300x300?text={{ $item->medicamento->nombre }}" alt="Sin Imagen" class="card-img-top">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title text-center">{{ $item->medicamento->nombre }}</h5>
                        <p class="card-text text-center">${{ number_format($item->medicamento->precio, 2) }}</p>
                        <div class="d-flex justify-content-around mt-2">
                            <button class="btn btn-danger btn-sm remove-from-wishlist"
                                    style="background: #ffffff; color: black; border: 1px solid #dc3545;"
                                    onmouseover="this.style.background='rgba(255, 0, 0, 0.6)'; this.style.color='white';"
                                    onmouseout="this.style.background='#ffffff'; this.style.color='black';"
                                    data-id="{{ $item->id }}">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                            <button
                                    id="cartButton"
                                    class="add-to-cart-btn btn-sm btn btn-outline-primary"
                                    style="background: #ffffff; color: black; border: 1px solid #28a745;"
                                    onmouseover="this.style.background='rgba(0, 255, 0, 0.6)'; this.style.color='white';"
                                    onmouseout="this.style.background='#ffffff'; this.style.color='black';"
                                    data-id-medicamento="{{ $item->medicamento->id_medicamento }}"
                                    data-cantidad="1">
                                <i class="bi bi-cart"></i> Añadir al Carrito
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
@endif

@endsection
