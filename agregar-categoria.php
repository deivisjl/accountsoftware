<?php  
    include 'includes/redirect.php'; 
    include 'includes/baseurl.php'; 
    include 'config/config.php';

      $query = "SELECT id, porcentaje from porcdeprec";

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
              <h3 class="box-title">Agregar Categoria</h3>
            </div>

            <div class="box-body">
              <div class="row">
                  <div class="col-md-2">
                      <a href="/categoria.php"><span class="fa fa-arrow-circle-left fa-3x"></span></a>
                  </div>
              </div>  
            </div>
            
        <div class="box-body">
            <form role="form" method="post" action="/controllers/categoria/categoria.php">
              <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre de la categoria</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre de la categoria">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Porcentaje depreciacion</label>
                        <select name="percent" class="form-control">
                            <?php 
                                while($results = mysqli_fetch_array($result)){ ?>
                                <option value="<?php echo $results["id"] ?>" >
                                  <?php  echo $results["porcentaje"] . " %"?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Descripcion</label>
                        <input type="text" class="form-control" name="desc" placeholder="Ingrese una descripcion">
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
