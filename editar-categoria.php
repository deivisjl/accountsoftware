<?php  
    include 'includes/baseurl.php'; 
    include 'config/config.php';

    if(isset($_GET["id"]) && !empty($_GET['id'])){

      $id = $_GET["id"];

      $query = "SELECT id, nombre, descripcion, porcid 
                    from categoriaactivo Where id = '{$id}'";

      $query2 = "SELECT id, porcentaje from porcdeprec";

      $result = $db->query($query);

      $result2 = $db->query($query2);

        if ($result && mysqli_num_rows($result) > 0 && $result2 && mysqli_num_rows($result2) > 0) {

            $array = mysqli_fetch_array($result);

        }
        else{
            $baseurl = BaseUrl::getServer();

            header("Location: $baseurl");

        }
    }else{

      $baseurl = BaseUrl::getServer();

      header("Location: $baseurl");

    }
?>
<!--=========================================================================================-->
<?php 
 	include 'includes/redirect.php'; 
	include 'views/header.php';
	include 'views/sidebar.php';
	include 'views/content.php';
?>
<!--=========================================================================================-->

 <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Categoria</h3>
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

            <input type="hidden" name="id" value="<?= $id ?>">
              <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                          <label for="exampleInputEmail1">Nombre de la categoria</label>
                          <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre de la categoria" value="<?= $array["nombre"]  ?>">
                      </div>

                      <div class="form-group">
                          <label for="exampleInputEmail1">Porcentaje depreciacion</label>
                          <select name="percent" class="form-control">
                              <?php 
                                  while($results = mysqli_fetch_array($result2)){ ?>
                                  <option value="<?php echo $results["id"] ?>" 
                                  <?php 
                                      if($array["porcid"] == $results["id"]){ echo "selected='selected'";}
                                  ?>  
                                    >
                                    <?php  echo $results["porcentaje"] . " %"?>
                                  </option>
                              <?php } ?>
                          </select>
                      </div>

                      <div class="form-group">
                          <label for="exampleInputEmail1">Descripcion</label>
                          <input type="text" class="form-control" name="desc" placeholder="Ingrese una descripcion" value="<?= $array["descripcion"]  ?>">
                      </div>
                 </div> 
                
              </div>
              <!-- /.box-body -->

              <input type="hidden" name="editar">

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
