<?php  
    include 'includes/baseurl.php'; 
    include 'config/config.php';

    if(isset($_GET["id"]) && !empty($_GET['id'])){

      $id = $_GET["id"];

      $query = "SELECT nombre, descripcion from metododeprec Where id = '{$id}'";

      $result = $db->query($query);

        if ($result && mysqli_num_rows($result) > 0) {

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
              <h3 class="box-title">Editar Metodo de depreciacion</h3>
            </div>

            <div class="box-body">
              <div class="row">
                  <div class="col-md-2">
                      <a href="/metodo.php"><span class="fa fa-arrow-circle-left fa-3x"></span></a>
                  </div>
              </div>  
            </div>

        <div class="box-body">
            

            <form role="form" method="post" action="/controllers/metodo/metodo.php">

            <input type="hidden" name="id" value="<?= $id ?>">
              <div class="box-body">
                <div class="col-md-6">
                     <div class="form-group">
                        <label for="exampleInputEmail1">Nombre del metodo</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre del metodo" value="<?= $array['nombre'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Descripcion</label>
                        <input type="text" class="form-control" name="desc" placeholder="Ingrese una descripcion" value="<?= $array['descripcion'] ?>">
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
