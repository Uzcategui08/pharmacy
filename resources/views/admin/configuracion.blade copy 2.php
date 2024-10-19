<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Farmacia</title>
    <!-- Incluir CSS de Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <!-- Incluir CSS de Leaflet GeoSearch -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
    <style>
        #map {
            height: 400px; /* Ajusta la altura del mapa */
            width: 100%;
        }

        /* Estilo para la barra de búsqueda */
        #addressInput {
            margin-top: 10px;
            padding: 10px;
            width: 60%;
            font-size: 16px;
        }

        /* Estilo para las sugerencias */
        #suggestions {
            position: absolute;
            top: 200px;
            left: 20%;
            width: 60%;
            max-height: 200px;
            overflow-y: auto;
            background-color: white;
            border: transparent;
            z-index: 1000;
        }

        #suggestions div {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #ddd;
        }

        #suggestions div:hover {
            background-color: #f0f0f0;
        }

                /* Estilo para el botón de limpiar */
                #clearButton {
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
        }

        #clearButton:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Configura tu Farmacia</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('guardarFarmacia') }}">
        @csrf

        <!-- Nombre o Razón Social -->
        <div class="form-group">
            <label for="nombre_razon_social">Nombre o Razón Social</label>
            <input type="text" id="nombre_razon_social" name="nombre_razon_social" class="form-control" required>
        </div>

        <!-- RIF -->
        <div class="form-group">
            <label for="rif">RIF</label>
            <input type="text" id="rif" name="rif" class="form-control" required>
        </div>

        <!-- Barra de búsqueda -->
        <input type="text" id="addressInput" placeholder="Ingresa una dirección" />
    <!-- Botón para limpiar el campo de búsqueda -->
    <button id="clearButton">Limpiar</button>

        <div id="suggestions"></div>

        <!-- Campo oculto para la ubicación -->
        <input type="hidden" id="location" name="location">

        <!-- Contenedor del mapa -->
        <div id="map-container" class="map-container">
            <div id="map"></div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit" class="btn btn-primary mt-3">Guardar Farmacia</button>
    </form>
</div>

<!-- Incluir JS de Leaflet -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<!-- Incluir JS de Leaflet GeoSearch -->
<script src="https://unpkg.com/leaflet-geosearch@latest/dist/bundle.min.js"></script>

<script>
            // Evento para el botón de limpiar
            document.getElementById('clearButton').addEventListener('click', function(event) {
                // Prevenir el comportamiento por defecto del botón
                event.preventDefault();
                // Limpiar el campo de búsqueda
                document.getElementById('addressInput').value = '';
                // Limpiar las sugerencias
                document.getElementById('suggestions').innerHTML = '';
                // Restaurar el mapa a la vista inicial
                map.setView([10.487, -66.879], 13);
                marker.setLatLng([10.487, -66.879]);
                // Limpiar el campo oculto
                document.getElementById('location').value = '';
            });
    // Inicializar el mapa centrado en una ubicación por defecto
    var map = L.map('map').setView([10.487, -66.879], 13); // Cambia por tu ubicación inicial

    // Añadir capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Crear un marcador inicial
    var marker = L.marker([10.487, -66.879]).addTo(map); // Mismo punto inicial

    // Función para obtener las sugerencias de dirección
    function getSuggestions(query) {
        var url = `https://nominatim.openstreetmap.org/search?format=json&limit=5&q=${encodeURIComponent(query)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                var suggestionsContainer = document.getElementById('suggestions');
                suggestionsContainer.innerHTML = ''; // Limpiar las sugerencias previas

                if (data.length > 0) {
                    data.forEach(function(item) {
                        var suggestion = document.createElement('div');
                        suggestion.textContent = item.display_name;
                        suggestion.addEventListener('click', function() {
                            selectAddress(item); // Seleccionar la dirección
                        });
                        suggestionsContainer.appendChild(suggestion);
                    });
                } else {
                    suggestionsContainer.innerHTML = '<div>No se encontraron resultados.</div>';
                }
            })
            .catch(error => {
                console.error('Error en la obtención de sugerencias:', error);
            });
    }

    // Función para seleccionar una dirección de las sugerencias
    function selectAddress(item) {
        var addressInput = document.getElementById('addressInput');
        addressInput.value = item.display_name;

        // Mover el marcador a la ubicación seleccionada
        var lat = item.lat;
        var lon = item.lon;
        marker.setLatLng([lat, lon]);

        // Centrar el mapa en la ubicación seleccionada
        map.setView([lat, lon], 50);

        // Guardar las coordenadas en el campo oculto
        document.getElementById('location').value = `${lat} ${lon}`;

        // Limpiar las sugerencias
        document.getElementById('suggestions').innerHTML = '';
    }

    // Evento para mostrar sugerencias mientras el usuario escribe
    document.getElementById('addressInput').addEventListener('input', function(event) {
        var query = event.target.value;

        if (query.length > 2) { // Solo buscar si el texto tiene más de 2 caracteres
            getSuggestions(query);
        } else {
            document.getElementById('suggestions').innerHTML = ''; // Limpiar sugerencias
        }
    });

    // Función para mover el marcador cuando el usuario hace clic en el mapa
    map.on('click', function(e) {
        var latlng = e.latlng;
        marker.setLatLng(latlng);

        // Guardar la latitud y longitud en el campo oculto en formato adecuado (separado por un espacio)
        document.getElementById('location').value = `${latlng.lat} ${latlng.lng}`;
    });


</script>

</body>
</html>
