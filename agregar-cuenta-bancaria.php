<?php  
    include 'includes/redirect.php'; 
    include 'includes/baseurl.php'; 
    include 'config/config.php';

      $query = "SELECT id, nombre from tipocuenta";

      $query2 = "SELECT id, nombre from banco";

      $result = $db->query($query);

      $result2 = $db->query($query2);

        if (!$result || mysqli_num_rows($result) <=  0) {

            $baseurl = BaseUrl::getServer();

            header("Location: $baseurl");

        }

        if (!$result2 || mysqli_num_rows($result2) <=  0) {
              
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
              <h3 class="box-title">Agregar Cuenta Bancaria</h3>
            </div>

            <div class="box-body">
              <div class="row">
                  <div class="col-md-2">
                      <a href="/cuentabancaria.php"><span class="fa fa-arrow-circle-left fa-3x"></span></a>
                  </div>
              </div>  
            </div>
            
        <div class="box-body">
            <form role="form" method="post" action="/controllers/cuentabancaria/cuentabancaria.php">
              <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Numero de cuenta</label>
                        <input type="text" class="form-control" name="cuenta" placeholder="Ingrese el numero de cuenta">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre del titular</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Banco</label>
                        <select name="banco" class="form-control">
                             <?php 
                                while($results2 = mysqli_fetch_array($result2)){ ?>
                                <option value="<?php echo $results2["id"] ?>" >
                                  <?php  echo $results2["nombre"]?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Tipo de cuenta</label>
                        <select name="tipo" class="form-control">
                            <?php 
                                while($results = mysqli_fetch_array($result)){ ?>
                                <option value="<?php echo $results["id"] ?>" >
                                  <?php  echo $results["nombre"]?>
                                </option>
                            <?php } ?>
                        </select>
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
