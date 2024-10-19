@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
<h2>Panel administrativo</h2>
<hr>
@stop

@section('content')

<head>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
</head>



<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $resultadosApa }}</h3>
                        <p>Ordenes completadas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>
                        <p>porcentaje de compra</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $userCount }}</h3>
                        <p>Usuarios registrados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $medCount }}</h3>
                        <p>Medicamentos registrados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>


        <div class="row">

            <section class="col-lg-7 connectedSortable">


                <x-adminlte-card title="Grafico de ventas diarias" icon="fas fa-lg fa-fan" removable collapsible>
                    <canvas id="ventas"></canvas>
                </x-adminlte-card>


            </section>
            <section class="col-lg-5 connectedSortable">
                <div class="card bg-gradient">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="fas fa-th mr-1"></i>
                            Gráfico de ventas totales
                        </h3>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-center align-items-center" style="height: 450px;"> <!-- Ajusta la altura según sea necesario -->
                            <canvas id="Donut" width="485" height="485"></canvas>
                        </div>
                    </div>
                </div>
            </section>

        </div>

    </div>
</section>
<style>
    .card-footer {
        display: flex;
        justify-content: center;
        /* Centra horizontalmente */
        align-items: center;
        /* Centra verticalmente */
        height: 485px;
        /* Ajusta esta altura según tus necesidades */
    }

    canvas {
        max-width: 100%;
        /* Asegura que el canvas no exceda el ancho del contenedor */
        height: 485;
        /* Mantiene la proporción del canvas */
    }
</style>




@stop

@section('css')
{{-- --}}
<link rel="stylesheet" href="{{ asset('/build/assets/admin/admin.css') }}">

@stop

@section('js')
<script>
    const ctx = document.querySelector('#ventas');
    const labels = <?php echo json_encode($resultados->pluck('pais1')); ?>;
    console.log(labels);
    const stackedBar = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad',
                data: <?php echo json_encode($resultados->pluck('total')); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1,

            }]
        },
        options: {
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true
                }
            }
        }
    });

    const ctx1 = document.querySelector('#Donut');
    const labels1 = <?php echo json_encode($resultados1->pluck('cat')); ?>;

    const donutChart = new Chart(ctx1, {
        type: 'doughnut', // Cambia a 'doughnut' para el gráfico de dona
        data: {
            labels: labels1,
            datasets: [{
                label: 'Cantidad',
                data: <?php echo json_encode($resultados->pluck('total')); ?>, 
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(201, 203, 207, 1)',
                    'rgba(76, 255, 51, 1)'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Permite que el gráfico se ajuste al tamaño del canvas
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Gráfico De ventas'
                }
            }
        }
    });
</script>
@stop