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

<h1 class="text-center">Apartados</h1>
<hr>
<table class="table table-light">
  <thead class="thead-light w-100">
    <tr>
      <th>ID</th>
      <th>Farmacia</th>
      <th>Fecha</th>
      <th>Estado</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($apartados as $apartado)
    <tr>
      <td>{{ $apartado->id }}</td>
      <td>{{ $apartado->farmacia->nombre_razon_social }}</td>
      <td>{{ $apartado->fecha }}</td>
      <td>{{ $apartado->estado }}</td>
      <td>{{ $apartado->detalles->sum('precio') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>


