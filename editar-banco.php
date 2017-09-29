<?php  
    include 'includes/baseurl.php'; 
    include 'config/config.php';

    if(isset($_GET["id"]) && !empty($_GET['id'])){

      $id = $_GET["id"];

      $query = "SELECT nombre from banco Where id = '{$id}'";

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
              <h3 class="box-title">Editar Entidad Bancaria</h3>
            </div>

            <div class="box-body">
              <div class="row">
                  <div class="col-md-2">
                      <a href="/banco.php"><span class="fa fa-arrow-circle-left fa-3x"></span></a>
                  </div>
              </div>  
            </div>

        <div class="box-body">
            

            <form role="form" method="post" action="/controllers/banco/banco.php">

            <input type="hidden" name="id" value="<?= $id ?>">
              <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre del banco</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre" value="<?= $array["nombre"]?>">
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
