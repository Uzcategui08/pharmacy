<h1>hello there</h1>
<div class="container">
    <h1>Medicamentos de la farmacia {{ $farmacia->nombre_razon_social }}</h1>

    @if($medicamentos->isEmpty())
        <p>No hay medicamentos registrados para esta farmacia.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Fabricante</th>
                    <th>Descripción</th>
                    <th>País de fabricación</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicamentos as $medicamento)
                    <tr>
                        <td>{{ $medicamento->nombre }}</td>
                        <td>{{ $medicamento->precio }}</td>
                        <td>{{ $medicamento->fabricante }}</td>
                        <td>{{ $medicamento->descripcion }}</td>
                        <td>{{ $medicamento->pais_fabricacion }}</td>
                        <td>{{ $medicamento->categoria }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
