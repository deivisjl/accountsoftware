<?php  
    include 'includes/redirect.php'; 
    include 'includes/baseurl.php'; 
    include 'config/config.php';

    if(isset($_GET["id"]) && !empty($_GET['id'])){


      $id = $_GET['id'];

      $query = "SELECT id, nombre from tipocuenta";

      $query2 = "SELECT id, nombre as banco from banco";

      $query3 = "SELECT nocuenta, titular, bancoid, tipoid
                              from cuentabancaria
                                  where id = '{$id}'";

      $result = $db->query($query);

      $result2 = $db->query($query2);

      $result3 = $db->query($query3);

        if (!$result || mysqli_num_rows($result) <=  0) {

            $baseurl = BaseUrl::getServer();

            header("Location: $baseurl");

        }

        if (!$result2 || mysqli_num_rows($result2) <=  0) {
              
              $baseurl = BaseUrl::getServer();

              header("Location: $baseurl");
              
        }

        if (!$result3 || mysqli_num_rows($result3) <=  0) {
              
              $baseurl = BaseUrl::getServer();

              header("Location: $baseurl");
              
        }

        $cuentas = mysqli_fetch_array($result3);

    }else{

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
              <h3 class="box-title">Editar Cuenta Bancaria</h3>
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

            <input type="hidden" name="id" value="<?= $id?>">
              <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Numero de cuenta</label>
                        <input type="text" class="form-control" name="cuenta" placeholder="Ingrese el numero de cuenta" value="<?= $cuentas['nocuenta'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre del titular</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre" value="<?= $cuentas['titular']  ?>">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Banco</label>
                        <select name="banco" class="form-control">
                             <?php 
                                while($results2 = mysqli_fetch_array($result2)){ ?>
                                <option value="<?php echo $results2["id"] ?>" 
                                <?php 
                                  if($cuentas["bancoid"] == $results2["id"]){ echo "selected='selected'";}
                                ?>  
                                    >
                                  <?php  echo $results2["banco"]?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Tipo de cuenta</label>
                        <select name="tipo" class="form-control">
                            <?php 
                                while($results = mysqli_fetch_array($result)){ ?>
                                <option value="<?php echo $results["id"] ?>" 
                                  <?php 
                                  if($cuentas["tipoid"] == $results["id"]){ echo "selected='selected'";}
                                  ?>  
                                >
                                  <?php  echo $results["nombre"]?>
                                </option>
                            <?php } ?>
                        </select>
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
