// filtro para la categoría de productos en el home
document.querySelectorAll('.category-bar a').forEach(link => {
    link.addEventListener('click', function (event) {
        event.preventDefault();
        const category = this.getAttribute('data-category');
        filterProducts(category);

        // remueve la clase 'active' de todos los enlaces y añade la clase 'active' al enlace clicado
        document.querySelectorAll('.category-bar a').forEach(link => link.classList.remove('active'));
        this.classList.add('active');
    });
});

//modal para las especificaciones de los medicamentos (agregar que se pueda mostrar el mapa de los medicamentos,
// o que se pueda redireccionar al perfil d la farmacia en la que se encuentra ubicado el medicamento)
document.addEventListener('DOMContentLoaded', function () {
    const medicamentoModal = document.getElementById('medicamentoModal');

    medicamentoModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');
        const precio = button.getAttribute('data-precio');
        const descripcion = button.getAttribute('data-descripcion');
        const imagePath = button.getAttribute('data-image-path');
        const pais = button.getAttribute('data-pais');
        const categoria = button.getAttribute('data-categoria');
        const farmacia = button.getAttribute('data-farmacia');

        document.getElementById('medicamentoNombre').textContent = nombre;
        document.getElementById('medicamentoPrecio').textContent = precio;
        document.getElementById('medicamentoDescripcion').textContent = descripcion;
        document.getElementById('medicamentoPais').textContent = pais;
        document.getElementById('medicamentoCategoria').textContent = categoria;
        document.getElementById('medicamentoFarmacia').textContent = farmacia;

        const imageElem = document.getElementById('medicamentoImage');
        if (imagePath) {
            imageElem.src = imagePath;
            imageElem.alt = nombre;
        } else {
            imageElem.src = 'https://via.placeholder.com/300x300?text=' + nombre;
            imageElem.alt = 'Sin Imagen';
        }

        const favButton = document.getElementById('favButton');
        const cartButton = document.getElementById('cartButton');

        favButton.setAttribute('data-id', id);
        cartButton.setAttribute('data-id', id);

        cartButton.setAttribute('data-id-medicamento', id);
        cartButton.setAttribute('data-cantidad', 1);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    $('.open-modal').on('click', function() {
        const apartadoId = $(this).data('id');

        $.ajax({
            url: '/apartados/' + apartadoId + '/detalles',
            type: 'GET',
            success: function(data) {
                $('#modal-body').empty();

                data.forEach(function(detalle) {
                    $('#modal-body').append(`
                        <tr>
                            <td>${detalle.medicamento.nombre}</td>
                            <td>${detalle.cantidad}</td>
                            <td>${detalle.precio}</td>
                            <td>${(detalle.cantidad * detalle.precio).toFixed(2)}</td>
                        </tr>
                    `);
                });

                $('#detallesModal').modal('show'); // Asegúrate de que este código esté aquí
            },
            error: function() {
                alert('Ocurrió un error al cargar los detalles del apartado.');
            }
        });
    });

    $('#detallesModal').on('hidden.bs.modal', function () {
        $('#modal-body').empty(); // Limpia el contenido del modal al cerrarlo
    });
});

//agregar al wishlist
$(document).ready(function () {
    toastr.options = {
        "positionClass": "toast-bottom-center", // Posiciona las notificaciones en la parte inferior central
        "timeOut": "3000", // Tiempo que la notificación estará visible
        "closeButton": true // Muestra un botón de cierre en la notificación
    };

    $('.add-to-wishlist').on('click', function () {
        const productId = $(this).data('id');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `/wishlist/add/${productId}`,
            type: 'POST',
            data: JSON.stringify({}),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (data) {
                if (data.success) {
                    toastr.success(data.message);
                } else {
                    toastr.warning(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('Ocurrió un error. Por favor, inténtelo de nuevo.');
            }
        });
    });
});

$(document).ready(function () {
    toastr.options = {
        "positionClass": "toast-bottom-center",
        "timeOut": "3000",
        "closeButton": true
    };

    $('.remove-from-wishlist').on('click', function () {
        const wishlistId = $(this).data('id');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `/wishlist/remove/${wishlistId}`,
            type: 'DELETE',
            data: JSON.stringify({}),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (data) {
                if (data.success) {
                    toastr.success(data.message);
                    // Eliminar el elemento de la lista de deseos en la interfaz
                    $(`#wishlist-item-${wishlistId}`).fadeOut(300, function() {
                        $(this).remove(); // Eliminar el elemento del DOM
                    });
                } else {
                    toastr.error(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                toastr.error('Ocurrió un error. Por favor, inténtelo de nuevo.');
            }
        });
    });
});

// filtra los productos por categoría

function filterProducts(category) {
    const products = document.querySelectorAll('.product-item');
    const productList = document.getElementById('productList');
    productList.classList.add('hidden');
    setTimeout(() => {
        products.forEach(product => {
            if (category === 'all' || product.classList.contains(category)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
        productList.classList.remove('hidden');
    }, 500);
}

// preloader
(function ($) {
    "use strict";

    $(window).on('load', function () {
        var preloaderFadeOutTime = 500;

        function hidePreloader() {
            var preloader = $('.banter-loader, .banter-wrapper');
            setTimeout(function () {
                preloader.fadeOut(preloaderFadeOutTime);
            }, 500);
        }

        hidePreloader();
    });
})(jQuery);

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    var mapa = L.map('mapa-js').setView([10.491016, -66.902061], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(mapa);

    L.marker([10.491016, -66.902061]).addTo(mapa)
        .bindPopup('Aquí está el marcador.')
        .openPopup();
});

$(document).ready(function () {
    // Función para actualizar el badge del carrito
    function updateCartCount(count) {
        const cartCountElement = $('#cart-count');
        cartCountElement.text(count);
        if (count > 0) {
            cartCountElement.show();
        } else {
            cartCountElement.hide();
        }
    }

    // configuración global de Toast
    toastr.options = {
        "positionClass": "toast-bottom-center", // Posiciona las notificaciones en la parte inferior central
        "timeOut": "3000", // Tiempo que la notificación estará visible
        "closeButton": true // Muestra un botón de cierre en la notificación
    };
    // para agregar al carrito
    $('.add-to-cart-btn').click(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Variables para almacenar los valores de id_medicamento y cantidad
        var id_medicamento, cantidad;

        // Detectar si el botón clicado está dentro de un producto o en el modal
        if ($(this).closest('.product-item').length > 0) {
            // Caso: Botón fuera del modal (en la lista de productos)
            id_medicamento = $(this).closest('.product-item').find('.id_medicamento').val();
            cantidad = $(this).closest('.product-item').find('.cantidad').val();
        } else if ($(this).closest('.product-actions').length > 0) {
            // Caso: Botón dentro de las acciones del producto
            id_medicamento = $(this).closest('.product-actions').find('.id_medicamento').val();
            cantidad = $(this).closest('.product-actions').find('.cantidad').val();
        } else {
            // Caso: Botón dentro del modal
            id_medicamento = $(this).data('id-medicamento');
            cantidad = $(this).data('cantidad'); // Cantidad que se configuró en el modal
        }

        $.ajax({
            type: "POST",
            url: "/user/agregar-carrito",
            data: {
                id_medicamento: id_medicamento,
                cantidad: cantidad
            },
            success: function (response) {
                toastr.success(response.status, {timeOut: 3000});

                // actualiza el contador del carrito en el badge
                if (response.totalItems !== undefined) {
                    updateCartCount(response.totalItems);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error al agregar al carrito:", error);
                toastr.error("Error al agregar al carrito", 'Error', {timeOut: 3000});
            }
        });

        console.log('id_medicamento:', id_medicamento);
        console.log('cantidad:', cantidad);
    });

    // inicializar el contador del carrito al cargar la página
    var initialCount = parseInt($('#cart-count').text());
    updateCartCount(initialCount);
});

$(document).ready(function () {
    function updateCartCount(count) {
        const cartCountElement = $('#cart-count');
        cartCountElement.text(count);
        if (count > 0) {
            cartCountElement.show();
        } else {
            cartCountElement.hide();
        }
    }

    function fetchCartCount() {
        $.ajax({
            url: '/carrito/count', // URL de la ruta que devuelve el conteo del carrito
            method: 'GET',
            success: function (response) {
                updateCartCount(response.totalItems);
            },
            error: function (xhr) {
                console.error('Error al obtener el conteo del carrito:', xhr.responseText);
            }
        });
    }

    fetchCartCount();
});


$(document).ready(function () {
    function updateCartCount(count) {
        const cartCountElement = $('#cart-count');
        cartCountElement.text(count);
        if (count > 0) {
            cartCountElement.show();
        } else {
            cartCountElement.hide();
        }
    }

    $('.increment, .decrement').on('click', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const input = row.find('.cantidad');
        let quantity = parseInt(input.val());

        if ($(this).hasClass('increment')) {
            quantity += 1;
        } else if ($(this).hasClass('decrement')) {
            quantity = Math.max(1, quantity - 1);
        }

        input.val(quantity);

        $.ajax({
            url: `/carrito/update/${id}`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                cantidad: quantity
            },
            success: function (data) {
                if (data.success) {
                    // Actualiza el total de la fila
                    const price = parseFloat(row.find('td:nth-child(4)').text().replace('$', ''));
                    row.find('td:nth-child(5)').text(`$${(quantity * price).toFixed(2)}`);

                    // Actualiza el total general
                    let total = 0;
                    $('#carrito-body tr').each(function () {
                        const quantity = parseFloat($(this).find('.cantidad').val());
                        const price = parseFloat($(this).find('td:nth-child(4)').text().replace('$', ''));
                        total += quantity * price;
                    });
                    $('span#total-price').text(`$${total.toFixed(2)}`);

                    // Actualiza el badge del carrito
                    updateCartCount(data.totalItems);
                } else {
                    alert('Error al actualizar la cantidad.');
                }
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
                alert('Error al actualizar la cantidad: ' + xhr.responseText);
            }
        });
    });

    // inicializa el contador del carrito al cargar la página
    const initialCount = parseInt($('#cart-count').text()) || 0;
    updateCartCount(initialCount);

    // eliminar producto
    $('.bin-button').on('click', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');

        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: `/carrito/delete/${id}`,
            method: 'DELETE',
            data: {
                _token: csrfToken
            },
            success: function (data) {
                if (data.success) {
                    row.remove(); // Eliminar la fila de la tabla

                    // Actualiza el total general
                    let total = 0;
                    $('#carrito-body tr').each(function () {
                        const quantity = parseFloat($(this).find('.cantidad').val());
                        const price = parseFloat($(this).find('td:nth-child(4)').text().replace('$', ''));
                        total += quantity * price;
                    });
                    $('div.text-right h4').text(`Total: $${total.toFixed(2)}`);
                } else {
                    alert('Error al eliminar el producto.');
                }
            }
        });
    });
});


// owl carousel
$(document).ready(function () {
    $(".owl-carousel").owlCarousel({
        items: 3,
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
});

// funcionalidad de google maps para la categoría de farmacias
document.addEventListener('DOMContentLoaded', function () {
    let map;
    let marker;

    $('#farmaciaModal').on('shown.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const nombre = button.data('nombre');
        const rif = button.data('rif');
        const lat = parseFloat(button.data('latitud'));
        const lng = parseFloat(button.data('longitud'));

        $('#farmaciaNombre').text('');
        $('#farmaciaRif').text('');
        $('#farmaciaUbicacion').text('');
        $('#map-container').empty();

        $('#modal-loader').show();
        $('#modal-content').hide();

        if (map) {
            map.remove();
            map = null;
        }
        if (marker) {
            marker.remove();
            marker = null;
        }

        setTimeout(() => {
            $('#farmaciaNombre').text(nombre);
            $('#farmaciaRif').text(rif);
            $('#farmaciaUbicacion').text(`Lat: ${lat}, Lng: ${lng}`);

            if (!isNaN(lat) && !isNaN(lng)) {
                // Crear el mapa
                map = L.map('map-container').setView([lat, lng], 15);

                // Agregar la capa de mosaico
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                // Forzar la actualización del tamaño del mapa con un retraso adicional
                setTimeout(() => {
                    map.invalidateSize();
                }, 100); // Ajusta el retraso si es necesario

                // Agregar un marcador
                marker = L.marker([lat, lng]).addTo(map)
                    .bindPopup(nombre)
                    .openPopup();

                $('#modal-loader').hide();
                $('#modal-content').show();
            } else {
                console.error('Coordenadas no válidas:', lat, lng);

                $('#modal-loader').hide();
                $('#modal-content').show();
                $('#farmaciaUbicacion').text('Coordenadas no válidas');
            }
        }, 500);
    });

    $('#farmaciaModal').on('hidden.bs.modal', function () {
        $('#modal-content').hide();
        $('#modal-loader').show();
        $('#map-container').empty();

        if (map) {
            map.remove();
            map = null;
        }
        if (marker) {
            marker.remove();
            marker = null;
        }
    });
});


// guarda los filtros aplicados
function saveFilters() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const filters = {};

    formData.forEach((value, key) => {
        filters[key] = value;
    });

    localStorage.setItem('filters', JSON.stringify(filters));
}

// carga los filtros
function loadFilters() {
    const filters = JSON.parse(localStorage.getItem('filters')) || {};

    Object.keys(filters).forEach(key => {
        const element = document.querySelector(`[name=${key}]`);
        if (element) {
            if (element.tagName === 'SELECT') {
                element.value = filters[key];
            } else if (element.tagName === 'INPUT') {
                element.value = filters[key];
            }
        }
    });
}


document.getElementById('applyFilters').addEventListener('click', function () {
    saveFilters();
    $('#filterModal').modal('hide'); // Oculta el modal
});

// carga los filtros al cargar la página
window.addEventListener('load', loadFilters);

// agrega los filtros a la busqueda
document.getElementById('searchForm').addEventListener('submit', function (e) {
    const filters = JSON.parse(localStorage.getItem('filters')) || {};
    const form = e.target;

    Object.keys(filters).forEach(key => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = filters[key];
        form.appendChild(input);
    });
});

// aplica la localización
document.getElementById('applyLocation').addEventListener('click', function () {
    const addressSelect = document.getElementById('addressSelect');
    const selectedAddressId = addressSelect.value;

    if (selectedAddressId) {

        localStorage.setItem('selected_address_id', selectedAddressId);


        $('#locationModal').modal('hide');

        // Realizar una búsqueda o actualizar el formulario
        document.getElementById('searchForm').submit();
    } else {
        alert('Por favor, selecciona una dirección.');
    }
});

// carga la dirección seleccionada cuando se carga la página
window.addEventListener('load', function () {
    const selectedAddressId = localStorage.getItem('selected_address_id');

    if (selectedAddressId) {
        const addressSelect = document.getElementById('addressSelect');
        addressSelect.value = selectedAddressId;
    }
});

