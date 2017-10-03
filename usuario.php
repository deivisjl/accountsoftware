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
              <h3 class="box-title">Usuarios</h3>
            </div>
          <div class="text-center text-center">
            <a href="/agregar-usuario.php" class="btn btn-success">Agregar nuevo registro</a>
          </div>

          <br/>

    <?php if(isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])) {?>
          <div class="<?= $_SESSION["usuario"]["class"] ?>">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?= $_SESSION["usuario"]["message"]  ?>
          </div>
    <?php  } unset($_SESSION["usuario"])?>

            
        <div class="box-body">
            <table id="usuarios" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Correo electrónico</th>
                      <th>Rol</th>
                      <th>Fecha</th>
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
    var table = $("#usuarios").DataTable({
      "processing": true,
            "serverSide": true,
            "destroy":true,
            "order": [[ 0, "desc" ]],
            "ajax":{
            'url': './controllers/usuario/getUsuario.php',
            'type': 'GET'
          },
          "columns":[
              {'data': 'Id'},
              {'data': 'Nombre'},
              {'data': 'Email'},
              {'data': 'Rol'},
              {'data': 'Fecha'},              
              {'defaultContent':'<a class="editar label label-success">Editar</a>'}
          ],
          "language": idioma_spanish,

          "order": [[ 0, "asc" ]]
    });
    obtener_data_editar("#usuarios tbody",table);
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
        
        var userId = data.Id;

        window.location.href = './editar-usuario.php?id=' + userId;

      });
    }
</script>