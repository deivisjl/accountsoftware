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
              <h3 class="box-title">Bancos</h3>
            </div>
          <div class="text-center text-center">
            <a href="/agregar-banco.php" class="btn btn-success">Agregar nuevo registro</a>
          </div>

    <?php if(isset($_SESSION["insertBanco"]) && $_SESSION["insertBanco"]==1) {?>
          <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Mensaje</h4>
                Registro exitoso!
          </div>
    <?php  } else if(isset($_SESSION["insertBanco"]) && $_SESSION["insertBanco"]==2){ ?>
          <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Mensaje</h4>
                Error en el registro
          </div>
    <?php } unset($_SESSION["insertBanco"]) ?>

            
        <div class="box-body">
            <table id="bancos" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Banco</th>
                      <th>Fecha de Ingreso</th>
                      <th>Accion</th>
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
    var table = $("#bancos").DataTable({
      "processing": true,
            "serverSide": true,
            "destroy":true,
            "order": [[ 0, "desc" ]],
            "ajax":{
            'url': './controllers/banco/getBanco.php',
            'type': 'GET'
          },
          "columns":[
              {'data': 'Id'},
              {'data': 'Nombre'},
              {'data': 'Fecha'},              
              {'defaultContent':'<button class="editar btn btn-success">Depositar</button>'}
          ],
          "language": idioma_spanish
    });
    //obtener_data_editar("#compra tbody",table);
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
      $(tbody).on("click","button.editar",function(){
        var data = table.row($(this).parents("tr")).data();
        
        var idcompra = data.Id;
        $.ajax({
          method:"POST",
          url: "./controllers/getReporteDetalleCompra.php",
          data: 'Id='+idcompra
        }).done(function(info){
          $('#agrega-registros').html(info);
          $('#myModalDetalle').modal('show');

        });
      });
    }
</script>