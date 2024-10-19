@extends('layouts1.user')

@section('title', 'Home - Sistema de Medicinas')

@section('content')
    <div class="container-custom mt-4">
        <!-- Banner -->
        <div class="banner mb-4">
            <img src="https://via.placeholder.com/1275x300" alt="Banner" class="img-fluid">
        </div>

        <div class="row">
            <!-- Filtros -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="accordion" id="accordionFilters">
                            <!-- Related Items Filter -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingRelatedItems">
                                    <button class="accordion-button text-dark bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRelatedItems" aria-expanded="false" aria-controls="collapseRelatedItems">
                                        Related Items
                                    </button>
                                </h2>
                                <div id="collapseRelatedItems" class="accordion-collapse collapse" aria-labelledby="headingRelatedItems">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled">
                                            <li><a href="#" class="text-dark">Electronics</a></li>
                                            <li><a href="#" class="text-dark">Home Items</a></li>
                                            <li><a href="#" class="text-dark">Books, Magazines</a></li>
                                            <li><a href="#" class="text-dark">Men's Clothing</a></li>
                                            <li><a href="#" class="text-dark">Interiors Items</a></li>
                                            <li><a href="#" class="text-dark">Underwear</a></li>
                                            <li><a href="#" class="text-dark">Shoes for Men</a></li>
                                            <li><a href="#" class="text-dark">Accessories</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Brands Filter -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingBrands">
                                    <button class="accordion-button text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBrands" aria-expanded="true" aria-controls="collapseBrands">
                                        Brands
                                    </button>
                                </h2>
                                <div id="collapseBrands" class="accordion-collapse collapse show" aria-labelledby="headingBrands">
                                    <div class="accordion-body">
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="brandMercedes" checked>
                                                <label class="form-check-label" for="brandMercedes">Mercedes</label>
                                                <span class="badge bg-secondary float-end">120</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="brandToyota" checked>
                                                <label class="form-check-label" for="brandToyota">Toyota</label>
                                                <span class="badge bg-secondary float-end">15</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="brandMitsubishi" checked>
                                                <label class="form-check-label" for="brandMitsubishi">Mitsubishi</label>
                                                <span class="badge bg-secondary float-end">35</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="brandNissan" checked>
                                                <label class="form-check-label" for="brandNissan">Nissan</label>
                                                <span class="badge bg-secondary float-end">89</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="brandHonda">
                                                <label class="form-check-label" for="brandHonda">Honda</label>
                                                <span class="badge bg-secondary float-end">30</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="brandSuzuki">
                                                <label class="form-check-label" for="brandSuzuki">Suzuki</label>
                                                <span class="badge bg-secondary float-end">30</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Price Filter -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingPrice">
                                    <button class="accordion-button text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrice" aria-expanded="true" aria-controls="collapsePrice">
                                        Price
                                    </button>
                                </h2>
                                <div id="collapsePrice" class="accordion-collapse collapse show" aria-labelledby="headingPrice">
                                    <div class="accordion-body">
                                        <div class="range">
                                            <input type="range" class="form-range" id="priceRange">
                                            <span class="thumb" style="left: calc(50% + 0.5px);"><span class="thumb-value">50</span></span>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <p class="mb-0">Min</p>
                                                <div class="form-outline">
                                                    <input type="number" id="minPrice" class="form-control">
                                                    <label class="form-label" for="minPrice">$0</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-0">Max</p>
                                                <div class="form-outline">
                                                    <input type="number" id="maxPrice" class="form-control">
                                                    <label class="form-label" for="maxPrice">$10,000</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-white w-100 border border-secondary">Apply</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Size Filter -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSize">
                                    <button class="accordion-button text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSize" aria-expanded="true" aria-controls="collapseSize">
                                        Size
                                    </button>
                                </h2>
                                <div id="collapseSize" class="accordion-collapse collapse show" aria-labelledby="headingSize">
                                    <div class="accordion-body">
                                        <div>
                                            <input type="checkbox" class="btn-check" id="sizeXS" checked>
                                            <label class="btn btn-white mb-1 px-1" style="width: 60px;" for="sizeXS">XS</label>
                                            <input type="checkbox" class="btn-check" id="sizeSM" checked>
                                            <label class="btn btn-white mb-1 px-1" style="width: 60px;" for="sizeSM">SM</label>
                                            <input type="checkbox" class="btn-check" id="sizeLG" checked>
                                            <label class="btn btn-white mb-1 px-1" style="width: 60px;" for="sizeLG">LG</label>
                                            <input type="checkbox" class="btn-check" id="sizeXXL" checked>
                                            <label class="btn btn-white mb-1 px-1" style="width: 60px;" for="sizeXXL">XXL</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Ratings Filter -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingRatings">
                                    <button class="accordion-button text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRatings" aria-expanded="true" aria-controls="collapseRatings">
                                        Ratings
                                    </button>
                                </h2>
                                <div id="collapseRatings" class="accordion-collapse collapse show" aria-labelledby="headingRatings">
                                    <div class="accordion-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="rating5" checked>
                                            <label class="form-check-label" for="rating5">
                                                <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="rating4" checked>
                                            <label class="form-check-label" for="rating4">
                                                <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-muted"></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="rating3" checked>
                                            <label class="form-check-label" for="rating3">
                                                <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="rating2" checked>
                                            <label class="form-check-label" for="rating2">
                                                <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="rating1" checked>
                                            <label class="form-check-label" for="rating1">
                                                <i class="fas fa-star text-warning"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tags Filter -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTags">
                                    <button class="accordion-button text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTags" aria-expanded="true" aria-controls="collapseTags">
                                        Tags
                                    </button>
                                </h2>
                                <div id="collapseTags" class="accordion-collapse collapse show" aria-labelledby="headingTags">
                                    <div class="accordion-body">
                                        <div>
                                            <a href="#" class="btn btn-light mb-1">Winter</a>
                                            <a href="#" class="btn btn-light mb-1">Summer</a>
                                            <a href="#" class="btn btn-light mb-1">Autumn</a>
                                            <a href="#" class="btn btn-light mb-1">Spring</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenedor de productos filtrados -->
            <!-- Productos -->
            <div class="product-container">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card product-card shadow-sm">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">${{ number_format($product->price, 2) }}</p>
                                    <a href="#" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
