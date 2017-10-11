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

              <h3 class="box-title">Graficas de Efectivo</h3>

            </div>
            <div class="box-body">

            <div class="row">
               <div class="col-md-6">
                    <div id="container2"></div>
               </div>
               <div class="col-md-6">
                    <div id="activo"></div>
               </div>
            </div>


            <div class="row">
               <div class="col-md-12">
                    <div id="gastado"></div>
               </div>
            </div>

            <div class="row">
               <div class="col-md-12">
                    <div id="pagos"></div>
               </div>
            </div>

            </div>
            <!-- /.box-body-->
          </div>



<!--=========================================================================================-->

<?php include 'views/footer.php'; ?>

<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.charts.load('current', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);
      
    function drawChart() {
      var jsonData = $.ajax({
          url: "./controllers/grafica/efectivo.php",
          dataType: "json",
          async: false
          }).responseText;
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);

      var options = {
          title: 'Cuentas bancarias usadas para pagar',
          is3D: true,
        };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('container2'));
      chart.draw(data, options);
    }

    </script>


    <script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.charts.load('current', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);
      
    function drawChart() {
      var jsonData = $.ajax({
          url: "./controllers/grafica/activos.php",
          dataType: "json",
          async: false
          }).responseText;
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);

      var options = {
          title: 'Composicion de activos segun categoria',
          is3D: true,
        };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('activo'));
      chart.draw(data, options);
    }

    </script>



    <script type="text/javascript">
   google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

    var jsonData = $.ajax({
          url: "./controllers/grafica/gastocuentas.php",
          dataType: "json",
          async: false
          }).responseText;

      var data = new google.visualization.DataTable(jsonData);
      

      var options = {
        title: 'Monto gastado por cuentas',
        
        vAxis: {
          title: 'Escala (en Quetzales)'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('gastado'));

      chart.draw(data, options);
    }
    </script>


    <!--script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var jsonData = $.ajax({
          url: "./controllers/grafica/pagos.php",
          dataType: "json",
          async: false
          }).responseText;

        var data = google.visualization.arrayToDataTable(jsonData);

        var options = {
          title: 'Composicion de cuentas por pagar'
        };

        var chart = new google.visualization.PieChart(document.getElementById('pagos'));

        chart.draw(data, options);
      }
    </script-->
  
