<?php 
 	include 'includes/redirect.php'; 
	include 'includes/baseurl.php'; 
	include 'views/header.php';
	include 'views/sidebar.php';
	include 'views/content.php';
?>

<!--=========================================================================================-->

 <div class="box box-primary">
            <div class="box-header with-border text-center">
              <h3 class="box-title">Valor en libros de los activos</h3>
            </div>

          <br/>
            
        <div class="box-body">
            <table id="activos" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Costo</th>
                      <th>Categoria</th>
                      <th>Fecha de ingreso</th>
                      <th>Porcentaje</th>
                      <th>Depreciacion</th>
                      <th>Valor en libros</th>
                    </tr>
                  </thead>
                    
            </table>
        </div>
            
</div>




<!--=========================================================================================-->

<?php 

	include 'views/footer.php'; 	
?>

<script type="text/javascript">
  $(document).on("ready",function(){
    listar();
  });

  var listar = function(){
    var table = $("#activos").DataTable({
      "processing": true,
            "serverSide": true,
            "destroy":true,
            "order": [[ 0, "desc" ]],
            "ajax":{
            'url': './controllers/reporte/depreciacion.php',
            'type': 'GET'
          },
          "columns":[
          
              {'data': 'id'},
              {'data': 'nombre'},
              {'data': 'costo'},
              {'data': 'categoria'},
              {'data': 'fecha'},
              {'data': 'porcentaje'},
              {'data': 'depreciacion'},
              {'data': 'valor'}              
              
          ],
          "language": idioma_spanish,

          "order": [[ 0, "asc" ]]
    });
    obtener_data_editar("#activos tbody",table);
  }

  var idioma_spanish = {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
      },
      "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
  }

  

  var obtener_data_editar = function(tbody,table){
      $(tbody).on("click","a.editar",function(){
        var data = table.row($(this).parents("tr")).data();
        
        var bancoId = data.Id;

      });
    }
</script>