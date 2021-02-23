<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";
$con = getConexion();
//en este apartado ponemos en práctica de como trabajar con php y JS al mismo tiempo:
$datos = json_encode(informeVentasNombreCantidadCoste($con));
$altas = json_encode(dameAltas($con));
$bajas = json_encode(dameBajas($con));

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Informes Adm</title>
    <style>

    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        var datos = <?= $datos ?>;
        var altas = <?= $altas ?>;
        var bajas = <?= $bajas ?>;
        var datosOriginales = datos.concat();
        var maximo = Math.max.apply(Math, datos.map(function(o) {
            return o['Unidades vendidas'];
        }));
        datos.sort(ordenaPorUnidadesVendidas);

        function ordenaPorUnidadesVendidas(a, b) {
            if (parseInt(a['Unidades vendidas']) < parseInt(b['Unidades vendidas']))
                return 1;
            else if (parseInt(a['Unidades vendidas']) > parseInt(b['Unidades vendidas']))
                return -1;
            return 0;
        }

        function ordenaPorIngreso(a, b) {
            if (parseFloat(a['Ingreso acumulado']) < parseFloat(b['Ingreso acumulado']))
                return 1;
            else if (parseFloat(a['Ingreso acumulado']) > parseFloat(b['Ingreso acumulado']))
                return -1;
            return 0;
        }
        var top5Ventas = datos.sort(ordenaPorUnidadesVendidas).splice(0, 5);
        var nombresVentas = top5Ventas.map((a) => a['Producto']);
        var unidadesVendidas = top5Ventas.map((a) => a['Unidades vendidas']);
        var top5Ingresos = datosOriginales.sort(ordenaPorIngreso).splice(0, 5);
        var nombresIngresos = top5Ingresos.map((a) => a['Producto']);
        var ingresosOrdenados = top5Ingresos.map((a) => a['Ingreso acumulado']);

        onload = function() {

            $botonAltas=$("#altas");
            $botonBajas=$("#Bajas");
            $capaAB=$("#altasybajas");

            $("#altas").click(function(){           
                $capaAB.empty();
                $table=$("<table></table>").appendTo($capaAB).addClass("table").addClass("table-striped");
                $tr=$("<tr></tr>").appendTo($table);
                for (const key in altas[0]) {
                    $("<th></th>").text(key).appendTo($tr);
                    
                }
                for (const key in altas) {
                    $tr=$("<tr></tr>").appendTo($table);
                    for (const campo in altas[key]){
                        $("<td></td>").text(altas[key][campo]).appendTo($tr);
                    }
                    
                }
            });   
            
            $("#bajas").click(function(){
                
                $capaAB.empty();
                $table=$("<table></table>").appendTo($capaAB).addClass("table table-striped");
                $tr=$("<tr></tr>").appendTo($table);
                for (const key in bajas[0]) {
                    $("<th></th>").text(key).appendTo($tr);
                    
                }
                for (const key in bajas) {
                    $tr=$("<tr></tr>").appendTo($table);
                    for (const campo in bajas[key]){
                        $("<td></td>").text(bajas[key][campo]).appendTo($tr);
                    }
                    
                }
            }); 
            
                ////esto es de charts.js


            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: nombresVentas,
                    datasets: [{
                        label: 'Ventas del top 5',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: unidadesVendidas
                    }]
                },

                // Configuration options go here
                options: {
                    scales: {
                        xAxes: [{
                            stacked: true
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });

            var ctx2 = document.getElementById('myChart2').getContext('2d');
            var chart2 = new Chart(ctx2, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: nombresIngresos,
                    datasets: [{
                        label: 'Ingresos del top 5',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: ingresosOrdenados
                    }]
                },

                // Configuration options go here
                options: {
                    scales: {
                        xAxes: [{
                            stacked: true
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
        }
    </script>
</head>

<body>


    <?php include "./includes/menu.php" ?>
    <br><br>
    <div class="container">
        <h1>Área de informes</h1>
        <h2 class="display-4 mt-5">Top 5 Ventas:</h2>
        <div style="width:500px;height:300px">
            <canvas id="myChart"></canvas>
        </div>

        <h2 class="display-4 mt-5">Top 5 Ingresos:</h2>
        <div style="width:600px;height:300px">
            <canvas id="myChart2"></canvas>
        </div>
    </div>
    <div class="container"> 
         <h2 class="btn btn-secondary mt-5" id="altas">Ver altas de usuarios:</h2>


<h2 class="btn btn-secondary mt-5" id="bajas">Ver Bajas de Usuarios:</h2>

<div id="altasybajas">
    Haz click en algún botón.

</div>

    </div>

  

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

   
</body>

</html>