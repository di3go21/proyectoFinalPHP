<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";
$con = getConexion();
$datos = json_encode(informeVentasNombreCantidadCoste($con));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        var loco = <?= $datos ?>;
        var locoOriginal = loco.concat();
        var maximo = Math.max.apply(Math, loco.map(function(o) {
            return o['Unidades vendidas'];
        }));
        loco.sort(loco2);

        function loco2(a, b) {
            if (a['Unidades vendidas'] < b['Unidades vendidas'])
                return 1;
            else if (a['Unidades vendidas'] > b['Unidades vendidas'])
                return -1;
            return 0;
        }

        function loco3(a, b) {
            if (parseFloat(a['Ingreso acumulado']) < parseFloat(b['Ingreso acumulado']))
                return 1;
            else if (parseFloat(a['Ingreso acumulado']) > parseFloat(b['Ingreso acumulado']))
                return -1;
            return 0;
        }
        var top5 = loco.splice(0, 5);
        var nombres = locoOriginal.sort(loco2).map((a) => a['Producto']);
        var unidadesVendidas = locoOriginal.sort(loco2).map((a) => a['Unidades vendidas']);


        var nombres2 = locoOriginal.sort(loco3).map((a) => a['Producto']);
        var ingresosVendidas2 = locoOriginal.sort(loco3).map((a) => a['Ingreso acumulado']);

        onload = function() {
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: nombres,
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
                    labels: nombres2,
                    datasets: [{
                        label: 'Ingresos del top 5',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: ingresosVendidas2
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


    <div style="width:1000px;height:440px">
        <canvas id="myChart"></canvas>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div style="width:1000px;height:2440px">
        <canvas id="myChart2"></canvas>
    </div>

</body>

</html>