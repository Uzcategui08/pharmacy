<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up / Log In</title>
    <!-- Incluir CSS de Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <!-- Incluir CSS de Leaflet GeoSearch -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('build/assets/css/styles.css') }}" rel="stylesheet">
</head>
<body>
    <style>
        #map {
            height: 200px; /* Ajusta la altura del mapa */
            width: 100%;
        }
    </style>
    <div class="custom-container" id="container">
        <!-- Formulario Configura tu Farmacia -->
        <div class="custom-form-container">
            <h1>Configura tu Farmacia</h1>
            <hr>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form class="custom-form" method="POST" action="{{ route('guardarFarmacia') }}">
                @csrf

                <!-- Nombre o Razón Social -->
                <div class="form-group">
                    <label for="nombre_razon_social">Nombre o Razón Social</label>
                    <input type="text" id="nombre_razon_social" name="nombre_razon_social" class="custom-input" required>
                </div>

                <!-- RIF -->
                <div class="form-group">
                    <label for="rif">RIF</label>
                    <input type="text" id="rif" name="rif" class="custom-input" required>
                </div>

                <!-- Barra de búsqueda -->
                <input type="text" id="addressInput" class="custom-input" placeholder="Ingresa una dirección" />
                <button id="clearButton" class="custom-button">Limpiar</button>

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

                <button type="submit" class="custom-button mt-3">Guardar Farmacia</button>
            </form>
        </div>
    </div>


                <!-- Contenedor del mapa -->
                <div id="map-container" class="map-container">
                    <div id="map"></div>
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
        map.setView([10.487, -66.879], 50);
        marker.setLatLng([10.487, -66.879]);
        // Limpiar el campo oculto
        document.getElementById('location').value = '';
    });
// Función para obtener la ubicación del dispositivo y ajustar el mapa
function setDefaultLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            // Inicializar el mapa con la ubicación del dispositivo
            var map = L.map('map').setView([lat, lon], 50); // Ubicación del dispositivo

            // Añadir capa de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Crear un marcador en la ubicación del dispositivo
            var marker = L.marker([lat, lon]).addTo(map);

            // Guardar las coordenadas en el campo oculto
            document.getElementById('location').value = `${lat} ${lon}`;

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

        }, function(error) {
            console.error("Error al obtener la geolocalización:", error);
            alert("No se pudo obtener la ubicación del dispositivo. Se usará una ubicación predeterminada.");
            // Si no se puede obtener la ubicación, usa una ubicación predeterminada
            setDefaultLocationFallback();
        });
    } else {
        alert("La geolocalización no está soportada en este navegador.");
        // Si la geolocalización no está disponible, usa una ubicación predeterminada
        setDefaultLocationFallback();
    }
}

// Fallback en caso de que no se obtenga la ubicación del dispositivo
function setDefaultLocationFallback() {
    var lat = 10.487; // Latitud predeterminada
    var lon = -66.879; // Longitud predeterminada

    var map = L.map('map').setView([lat, lon], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker([lat, lon]).addTo(map);

    document.getElementById('location').value = `${lat} ${lon}`;
}

// Llamar a la función para establecer la ubicación al cargar la página
setDefaultLocation();
</script>

</body>
</html>
