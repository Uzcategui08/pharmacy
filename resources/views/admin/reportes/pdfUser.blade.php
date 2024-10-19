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

<h1>Usuarios</h1>
<table class="table table-light">
    <thead class="thead-light w-100">
        <tr>
 
            <th>Nombre</th>
            <th>Email</th>
            <th>Edad</th>
            <th>Numero</th>

        </tr>
    </thead>
    <tbody>
    @foreach($users as $Usuario)
        <tr>
            <td>{{$Usuario->name}}</td>
            <td>{{$Usuario->email}}</td>
            <td>{{$Usuario->edad}}</td>
            <td>{{$Usuario->numero}}</td>

        </tr>
        @endforeach
    </tbody>
    </table>
