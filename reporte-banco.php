<?php 
 	include 'includes/redirect.php'; 
	include 'includes/baseurl.php'; 
	include 'views/header.php';
	include 'views/sidebar.php';
	include 'views/content.php';
?>

<!--=========================================================================================-->

 <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Graficas de Bancos</h3>

            </div>
            <div class="box-body">

            <div class="row">
               <div class="col-md-6">
                    <div id="container2"></div>
               </div>
               <div class="col-md-6">
                    <div id="banco"></div>
               </div>
            </div>

            </div>
            <!-- /.box-body-->
          </div>



<!--=========================================================================================-->

<?php include 'views/footer.php'; ?>



<script type="text/javascript" src="/views/js/charts.js"></script>

    <script type="text/javascript">

        $.ajax({
        type: "json",
        method: "POST",
        url: "./controllers/grafica/bancos.php"
        }).done(function(info){

          var json_info = JSON.parse(info);
          
           Highcharts.chart('container2', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Grafica de uso de cuentas para pagos'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'uso',
        colorByPoint: true,
        data: json_info
    }]
});

          

        });

    </script>
