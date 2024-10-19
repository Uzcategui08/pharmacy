<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Usuario</title>
<!-- Agregar CSS de Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<!-- Agregar CSS de leaflet-search -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.0/dist/leaflet-search.min.css" />

<!-- Agregar JS de Leaflet -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<!-- Agregar JS de leaflet-search -->
<script src="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.0/dist/leaflet-search.min.js"></script>


    <style>
        #map {
            height: 400px;
            width: 100%;
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
    // Inicializar el mapa centrado en una ubicación por defecto
    var map = L.map('map').setView([10.487, -66.879], 13); // Cambia por tu ubicación inicial

    // Añadir capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Añadir marcador para la ubicación del usuario
    var marker = L.marker([10.487, -66.879]).addTo(map);

    // Actualizar la posición del marcador cuando el usuario haga clic en el mapa
    map.on('click', function(e) {
        var latlng = e.latlng;
        marker.setLatLng(latlng);

        // Guardar la latitud y longitud en el campo oculto
        document.getElementById('location').value = `${latlng.lat} ${latlng.lng}`;
    });

    // Inicializar el proveedor de geosearch
    const provider = new GeoSearch.OpenStreetMapProvider();

    // Crear el control de búsqueda
    const searchControl = new GeoSearch.GeoSearchControl({
        provider: provider,
        style: 'bar',  // estilo del buscador
        autoComplete: true,  // habilitar sugerencias mientras se escribe
        autoCompleteDelay: 250,  // retraso en la búsqueda
        showMarker: true,  // mostrar el marcador en la ubicación
        retainZoomLevel: false,  // cambiar el nivel de zoom al encontrar una ubicación
        updateMap: true  // actualizar la vista del mapa al seleccionar un resultado
    });

    // Añadir el control de búsqueda al mapa
    map.addControl(searchControl);

    // Función para mover el marcador cuando se selecciona una ubicación del searchbox
    map.on('geosearch/showlocation', function(result) {
        // Actualizar la posición del marcador en la ubicación encontrada
        marker.setLatLng([result.location.y, result.location.x]);

        // Guardar la latitud y longitud en el campo oculto
        document.getElementById('location').value = `${result.location.y} ${result.location.x}`;
    });
</script>
</body>
</html>
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

    <style>
        #map {
            height: 400px; /* Ajusta la altura según lo necesario */
            width: 100%;
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
// Inicializar el mapa centrado en una ubicación por defecto
var map = L.map('map').setView([10.487, -66.879], 13); // Cambia por tu ubicación inicial

// Añadir capa de OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Crear un marcador para mover cuando seleccionas la ubicación
var marker = L.marker([10.487, -66.879]).addTo(map);

// Crear un control de búsqueda que utilice OpenStreetMap como proveedor
var searchControl = new L.Control.Search({
    layer: marker, // Enlace al marcador
    initial: false, // No mostrar el marcador al inicio
    zoom: 12, // Nivel de zoom al seleccionar una ubicación
    text: 'Buscar una dirección...', // Texto en el campo de búsqueda
    provider: new L.GeoSearch.Provider.OpenStreetMap() // Proveedor de OpenStreetMap
});

// Añadir el control de búsqueda al mapa
map.addControl(searchControl);

// Agregar un evento para manejar la selección de ubicación
searchControl.on('search:locationfound', function(event) {
    // Obtener la ubicación seleccionada
    var latlng = event.latlng;

    // Mover el marcador a la nueva ubicación
    marker.setLatLng(latlng);

    // Centrar el mapa en la ubicación seleccionada
    map.setView(latlng, 13);

    // Guardar las coordenadas en el campo oculto
    document.getElementById('location').value = `${latlng.lat}, ${latlng.lng}`;
});


</script>
</body>
</html>
