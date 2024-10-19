<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Usuario</title>
    <!-- Incluir CSS de Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <!-- Incluir CSS de Leaflet GeoSearch -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
    <link href="{{ asset('build/assets/css/styles.css') }}" rel="stylesheet">
    <style>
        #map {
            height: 400px; /* Ajusta la altura según lo necesario */
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="custom-container" id="container">
        <div class="logo-container text-center" style="text-align: center;">
            <img src="{{ asset('build/assets/images/logo_app.svg') }}" alt="Logo de la aplicación" class="img-fluid" style="max-width: 125px; display: block; margin: 0 auto;">
        </div>
        <div class="custom-form-container">
        <h1>Configura la Dirección</h1>
        <hr>
        <form class="custom-form" method="POST" action="{{ route('guardarDireccion') }}">
            @csrf
            <!-- Campo para la dirección escrita -->
            <input type="text" id="address" name="name" placeholder="Introduce tu dirección" required>
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

            <div class="button-container text-center">
                <button type="submit" class="btn btn-primary">Guardar Dirección</button>
            </div>
        </form>
    </div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<!-- Leaflet GeoSearch -->
<script src="https://unpkg.com/leaflet-geosearch@latest/dist/bundle.min.js"></script>
<script>
// Función para obtener la ubicación del dispositivo y ajustar el mapa
function setDefaultLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            // Inicializar el mapa con la ubicación del dispositivo
            var map = L.map('map').setView([lat, lon], 13);

            // Añadir capa de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Crear un marcador en la ubicación del dispositivo
            var marker = L.marker([lat, lon]).addTo(map);

            // Guardar las coordenadas en el campo oculto
            document.getElementById('location').value = `${lat},${lon}`;

            // Buscar sugerencias mientras el usuario escribe
            document.getElementById('addressInput').addEventListener('input', function(event) {
                var query = event.target.value;

                if (query.length > 2) {
                    getSuggestions(query);
                } else {
                    document.getElementById('suggestions').innerHTML = ''; // Limpiar sugerencias
                }
            });

            // Limpiar la barra de búsqueda y restaurar el mapa
            document.getElementById('clearButton').addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('addressInput').value = '';
                document.getElementById('suggestions').innerHTML = '';
                map.setView([lat, lon], 13);
                marker.setLatLng([lat, lon]);
                document.getElementById('location').value = `${lat},${lon}`;
            });

        }, function(error) {
            console.error("Error al obtener la geolocalización:", error);
            alert("No se pudo obtener la ubicación del dispositivo. Se usará una ubicación predeterminada.");
            setFallbackLocation();
        });
    } else {
        alert("La geolocalización no está soportada en este navegador.");
        setFallbackLocation();
    }
}

// Fallback si la geolocalización falla
function setFallbackLocation() {
    var lat = 10.487; // Latitud predeterminada
    var lon = -66.879; // Longitud predeterminada

    var map = L.map('map').setView([lat, lon], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker([lat, lon]).addTo(map);

    document.getElementById('location').value = `${lat},${lon}`;
}

// Obtener sugerencias de direcciones
function getSuggestions(query) {
    var url = `https://nominatim.openstreetmap.org/search?format=json&limit=5&q=${encodeURIComponent(query)}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            var suggestionsContainer = document.getElementById('suggestions');
            suggestionsContainer.innerHTML = ''; // Limpiar sugerencias previas

            if (data.length > 0) {
                data.forEach(function(item) {
                    var suggestion = document.createElement('div');
                    suggestion.textContent = item.display_name;
                    suggestion.classList.add('suggestion-item');
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
            console.error('Error al obtener sugerencias:', error);
        });
}

// Función para seleccionar una dirección de las sugerencias
function selectAddress(item) {
    var addressInput = document.getElementById('addressInput');
    addressInput.value = item.display_name;

    var lat = item.lat;
    var lon = item.lon;

    var marker = L.marker([lat, lon]).addTo(map);
    map.setView([lat, lon], 13);

    // Guardar las coordenadas en el campo oculto
    document.getElementById('location').value = `${lat},${lon}`;

    // Limpiar las sugerencias
    document.getElementById('suggestions').innerHTML = '';
}

// Ejecutar la función de geolocalización al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    setDefaultLocation();
});
</script>
</body>
</html>
