@extends('layouts1.user')

@section('title', 'Home - Sistema de Medicinas')

@section('content')
<div class="container-custom mt-4">
    <div class="row flex-fill">
        <!-- Sidebar -->
        <div class="col-md-3 no-padding margindiv">
            <div class="d-flex align-items-center mb-3">
                <button class="btn btn-primary btn-full-width rounded-pill align-items-center" data-bs-toggle="collapse" data-bs-target="#categorySidebar" aria-expanded="false" aria-controls="categorySidebar">
                    <i class="bi bi-caret-down arrow-icon"></i> Farmacias
                </button>
            </div>

            <!-- Sección del Sidebar con las farmacias -->
            <div id="categorySidebar" class="collapse sidebar">
                <ul class="list-group">
                    @foreach($farmacias as $farmacia)
                    <li class="list-group-item" style="cursor: pointer;" data-bs-toggle="modal"
                        data-bs-target="#farmaciaModal"
                        data-id="{{ $farmacia->id_farmacia }}"
                        data-nombre="{{ $farmacia->nombre_razon_social }}"
                        data-rif="{{ $farmacia->rif }}"
                        data-latitud="{{ $farmacia->latitud }}"
                        data-longitud="{{ $farmacia->longitud }}">
                        {{ $farmacia->nombre_razon_social }}
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Modal para mostrar detalles de la farmacia -->
            <div class="modal fade" id="farmaciaModal" tabindex="-1" aria-labelledby="farmaciaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="farmaciaModalLabel">Detalles de la Farmacia</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modal-loader" style="display: none; text-align: center">
                                <div class="small-loader"></div>
                            </div>
                            <div id="modal-content" style="display: none">
                                <p><strong>Nombre:</strong> <span id="farmaciaNombre"></span></p>
                                <p><strong>RIF:</strong> <span id="farmaciaRif"></span></p>
                                <p><strong>Ubicación:</strong> <span id="farmaciaUbicacion"></span></p>
                                <div id="map-container" style="height: 300px;"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Main Content -->
        <div class="col-md-9 no-padding">
            <!-- Search Bar -->
            <form id="searchForm" action="{{ route('user.busqueda') }}" method="GET">
                <div class="input__container input__container--variant">
                    <div class="shadow__input shadow__input--variant"></div>
                    <input type="text" name="text" class="input__search input__search--variant" placeholder="Buscar..." value="{{ request('text') }}">
                    @foreach(session('filters', []) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <button type="submit" class="input__button__shadow input__button__shadow--variant">
                        <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" height="1.5em" width="1.5em">
                            <path d="M4 9a5 5 0 1110 0A5 5 0 014 9zm5-7a7 7 0 104.2 12.6.999.999 0 00.093.107l3 3a1 1 0 001.414-1.414l-3-3a.999.999 0 00-.107-.093A7 7 0 009 2z" fill-rule="evenodd" fill="#FFF"></path>
                        </svg>
                    </button>
                    <button type="button" class="input__button__shadow input__button__shadow--variant" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" height="1.5em" width="1.5em">
                            <path d="M3 4h14v2H3V4zm2 4h10v2H5V8zm4 4h2v2H9v-2z" fill-rule="evenodd" fill="#FFF"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Modal de Filtros -->
            <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="filterModalLabel">Filtrar Medicamentos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="filterForm">
                                <div class="mb-3">
                                    <label for="filterFarmacia" class="form-label">Farmacia</label>
                                    <select class="form-select" id="filterFarmacia" name="farmacia">
                                        <option value="">Seleccione una farmacia</option>
                                        @foreach($farmacias as $farmacia)
                                        <option value="{{ $farmacia->id_farmacia }}" {{ request('farmacia') == $farmacia->id_farmacia ? 'selected' : '' }}>{{ $farmacia->nombre_razon_social }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filtro por Categoría -->


                                <div class="mb-3">
                                    <label for="filterPrice" class="form-label">Rango de Precio</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="filterPriceMin" name="price_min" placeholder="Mínimo" value="{{ request('price_min') }}">
                                        <input type="number" class="form-control" id="filterPriceMax" name="price_max" placeholder="Máximo" value="{{ request('price_max') }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="filterUbicacion" class="form-label">Ubicación</label>
                                </div>
                                <select name="address_id" id="addressSelect" class="form-select">
                                    @forelse(auth()->user()->addresses as $address)
                                    <option value="{{ $address->id }}">{{ $address->name }}</option>
                                    @empty
                                    <option value="" disabled>No tienes direcciones guardadas.</option>
                                    @endforelse
                                </select>
                                <div class="form-group">
                                    <label for="distance">Rango de distancia (km):</label>
                                    <input type="number" id="distance" name="distance" class="form-control" min="0" step="0.1" placeholder="Ingrese el rango en kilómetros" value="5">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary" id="applyFilters">Aplicar Filtros</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Image -->
            <img src="{{asset ('build/assets/client/images/header2.jpg')}}" alt="Imagen" class="img-fluid mb-4 rounded-image">
            <!-- Carrusel de Productos -->
            <div class="owl-carousel owl-theme">
                @foreach ($nuevosMedicamentos as $medicamento)
                <div class="item">
                    <div class="product-card">
                        <div class="product-img-container">
                            @if($medicamento->image_path)
                            <img src="{{ asset($medicamento->image_path) }}" alt="{{ $medicamento->nombre }}" class="product-img card-img-top">
                            @else
                            <img src="https://via.placeholder.com/300x300?text={{ $medicamento->nombre }}" alt="Sin Imagen" class="product-img card-img-top">
                            @endif
                            <!--<span class="badge badge-new">Nuevo</span> -->
                            <div class="product-overlay">
                                <button class="btn-common btn-circle btn-heart add-to-wishlist" data-id="{{ $medicamento->id_medicamento }}"><i class="bi bi-heart"></i></button>
                                <button class="add-to-cart-btn btn-common btn-cart" data-id-medicamento="{{ $medicamento->id_medicamento }}" data-cantidad="1"><i class="bi bi-cart"></i></button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h4>{{ $medicamento->nombre }}</h4>
                            <h4>({{ $medicamento->farmacia->nombre_razon_social}})</h4>
                            <p>${{ number_format($medicamento->precio, 2) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Available Products -->
            <h2 class="category-text" style="text-align: center">Productos Disponibles</h2>
            <!-- Categories Bar -->
            <div class="category-bar">
                <ul class="nav nav-underline mb-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-category="all">Todos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-category="cat1">Categoría 1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-category="cat2">Categoría 2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-category="cat3">Categoría 3</a>
                    </li>
                </ul>
            </div>

            <!-- Product List -->
            <div class="medicamento-data">
                <div id="productList" class="row product-list">
                    @foreach($medicamentos as $medicamento)
                    <div class="col-md-3 mb-4 product-item">
                        <div class="card position-relative">
                            @if($medicamento->image_path)
                            <img src="{{ asset($medicamento->image_path) }}" alt="{{ $medicamento->nombre }}" class="product-img card-img-top">
                            @else
                            <img src="https://via.placeholder.com/300x300?text={{ $medicamento->nombre }}" alt="Sin Imagen" class="product-img card-img-top">
                            @endif
                            <div class="product-actions">
                                <button class="btn-common btn-circle btn-heart add-to-wishlist" data-id="{{ $medicamento->id_medicamento }}">
                                    <i class="bi bi-heart"></i>
                                </button>
                                <button class="btn-common btn-circle btn-cart">
                                    <i class="add-to-cart-btn bi bi-cart"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Información del producto fuera del card -->
                        <div class="product__item__text">
                            <h6>
                                <a href="#" class="product-link" data-bs-toggle="modal" data-bs-target="#medicamentoModal"
                                    data-id="{{ $medicamento->id_medicamento }}"
                                    data-nombre="{{ $medicamento->nombre }}"
                                    data-precio="{{ $medicamento->precio }}"
                                    data-descripcion="{{ $medicamento->descripcion }}"
                                    data-image-path="{{asset($medicamento->image_path)}}"
                                    data-pais="{{ $medicamento->pais_fabricacion }}"
                                    data-categoria="{{ $medicamento->categoria }}"
                                    data-farmacia="{{ $medicamento->farmacia->nombre_razon_social }}">
                                    {{ $medicamento->nombre }}
                                </a>
                            </h6>
                            <h6>({{ $medicamento->farmacia->nombre_razon_social}})</h6>
                            <h5>${{ number_format($medicamento->precio, 2) }}</h5>
                        </div>
                        <input type="hidden" class="id_medicamento" value="{{ $medicamento->id_medicamento }}">
                        <input type="hidden" class="cantidad" value="1" min="1">
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Modal para mostrar detalles del medicamento -->
            <div class="modal fade" id="medicamentoModal" tabindex="-1" aria-labelledby="medicamentoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="medicamentoModalLabel" style="text-align: center; width: 100%;">
                                Detalles del Medicamento
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="medicamentoImage" src="" alt="Imagen del Medicamento" class="img-fluid mb-3" style="max-height: 300px;">
                            <h5 id="medicamentoNombre"></h5>
                            <hr>
                            <p><strong>Precio:</strong> $<span id="medicamentoPrecio"></span></p>
                            <p><strong>Descripción:</strong> <span id="medicamentoDescripcion"></span></p>
                            <p><strong>País de Fabricación:</strong> <span id="medicamentoPais"></span></p>
                            <p><strong>Categoría:</strong> <span id="medicamentoCategoria"></span></p>
                            <hr>
                            <p><strong>Se encuentra en:</strong> <span id="medicamentoFarmacia"></span></p>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-around mt-4">
                                <button id="favButton"
                                    class="btn btn-outline-danger"
                                    style="background: #ffffff; color: black; border: 1px solid #dc3545;"
                                    onmouseover="this.style.background='rgba(255, 0, 0, 0.6)'; this.style.color='white';"
                                    onmouseout="this.style.background='#ffffff'; this.style.color='black';"
                                    data-id="">
                                    <i class="bi bi-heart"></i> Añadir a Favoritos
                                </button>
                                <button id="cartButton"
                                    class="add-to-cart-btn btn btn-outline-primary"
                                    style="background: #ffffff; color: black; border: 1px solid #28a745;"
                                    onmouseover="this.style.background='rgba(0, 255, 0, 0.6)'; this.style.color='white';"
                                    onmouseout="this.style.background='#ffffff'; this.style.color='black';"
                                    data-id="">
                                    <i class="bi bi-cart"></i> Añadir al Carrito
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection

@section('show_footer')
@include('user.partials.footer')
@endsection