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
              <h3 class="box-title">Cambiar contraseña</h3>
            </div>

            <div class="box-body">
              <div class="row">
                  <div class="col-md-2">
                      <a href="/index.php"><span class="fa fa-arrow-circle-left fa-3x"></span></a>
                  </div>
              </div>  
            </div>
            
        <div class="box-body">
            <form role="form" method="post" action="/controllers/usuario/usuario.php">
              <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ingrese nueva contraseña</label>
                        <input type="password" id="pass" class="form-control" name="pass" placeholder="Ingrese nueva contraseña">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Repita nueva contraseña</label>
                        <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Repita nueva contraseña">
                    </div>
                 </div> 
                
              </div>
              <!-- /.box-body -->

              <input type="hidden" name="editarpass">

                <div class="box-footer">
                  <button type="submit" class="btn btn-success">Editar</button>
                </div>


            </form>
          
        </div>
            
</div>




<!--=========================================================================================-->

<?php 

	include 'views/footer.php'; 	
?>

<script>
    $(document).ready(function(){

    $("#pass2").on('keyup', function(){

        var pass1 = $("#pass").val();
        var pass2 = $("#pass2").val();

        var obj = $(this);
            var small = $('<small />');

            /* El contenedor del control */
            var form_group = obj.closest('.form-group');
              form_group.removeClass('has-error'); /* Limpiamos el estado de error */
              form_group.removeClass('has-success'); /* Limpiamos el estado de error */
              var label = form_group.find('label');/* Capturamos el label donde queremos mostrar el mensaje */
              label.find('small').remove(); /* Eliminamos el mensaje anterior */
            

            if (pass1 === pass2) {

              label.append(small);
              form_group.addClass('has-success');
          small.text(obj.data('validacion-mensaje'));
          small.text(" ");
          
        }else{

          
          label.append(small);
          form_group.addClass('has-error');
          small.text(obj.data('validacion-mensaje'));
          small.text(" No coinciden las contraseñas");  

        }
        
       }).keyup();
    })


</script>
