<?php  
    include 'includes/redirect.php'; 
    include 'includes/baseurl.php'; 
    include 'config/config.php';

      $query = "SELECT id, nombre from rol";

      $result = $db->query($query);

        if (!$result || mysqli_num_rows($result) <=  0) {

            $baseurl = BaseUrl::getServer();

            header("Location: $baseurl");

        }
?>
<!--=========================================================================================-->
<?php 
	include 'views/header.php';
	include 'views/sidebar.php';
	include 'views/content.php';
?>

<!--=========================================================================================-->

 <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Usuario</h3>
            </div>

            <div class="box-body">
              <div class="row">
                  <div class="col-md-2">
                      <a href="/usuario.php"><span class="fa fa-arrow-circle-left fa-3x"></span></a>
                  </div>
              </div>  
            </div>
            
        <div class="box-body">
            <form role="form" method="post" action="/controllers/usuario/usuario.php">
              <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombres</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese su nombre">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Apellidos</label>
                        <input type="text" class="form-control" name="apellido" placeholder="Ingrese su apellido">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Rol</label>
                        <select name="rol" class="form-control">
                            <?php 
                                while($results = mysqli_fetch_array($result)){ ?>
                                <option value="<?php echo $results["id"] ?>" >
                                  <?php  echo $results["nombre"]?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Correo Electronico</label>
                        <input type="email" class="form-control" name="email" placeholder="Ingrese correo electronico">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Contraseña</label>
                        <input type="password" id="pass" class="form-control" name="pass" placeholder="Ingrese su contraseña">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Repita su Contraseña</label>
                        <input type="password" id="pass2" class="form-control" name="pass2" placeholder="Repita su contraseña">
                    </div>
                 </div> 
                
              </div>
              <!-- /.box-body -->

              <input type="hidden" name="guardar">

                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Guardar</button>
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
