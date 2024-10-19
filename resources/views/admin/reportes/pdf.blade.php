<style>
table {
   width: 100%;
   border: 1px solid #000;
}
th, td {
   width: 25%;
   text-align: left;
   vertical-align: top;
   border: 1px solid #000;
   border-collapse: collapse;
   padding: 0.3em;
   caption-side: bottom;
}
caption {
   padding: 0.3em;
   color: #fff;
    background: #000;
}
th {
   background: #eee;
}
</style>

<h1>Medicamentos</h1>
<table class="table table-light">
    <thead class="thead-light w-100">
        <tr>

            <th>Nombre</th>
            <th>Fabricante</th>
            <th>Descripcion</th>
            <th>País de Fabricación</th>
            <th>Categoría</th>
            <th>Precio</th>

        </tr>
    </thead>
    <tbody>
        @foreach($medicamentos as $medicamento)
        <tr>
            <td>{{$medicamento->nombre}}</td>
            <td>{{$medicamento->fabricante}}</td>
            <td>{{$medicamento->descripcion}}</td>
            <td>{{$medicamento->pais_fabricacion}}</td>
            <td>{{$medicamento->categoria}}</td>
            <td>{{$medicamento->precio}} Bs</td>

        </tr>
        @endforeach
    </tbody>
</table>


<a href="admin/reportes/pdf"></a>
