<?php  
    include 'includes/redirect.php'; 
    include 'includes/baseurl.php'; 
    include 'config/config.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {

  $id = $_GET['id'];

    $query = "SELECT id, nombre from rol";

    $query2 = "SELECT nombres, apellidos, email, rolid
          from users where id = '{$id}'";


    $result = $db->query($query);

    $result2 = $db->query($query2);

        if (!$result || mysqli_num_rows($result) <=  0) {

            $baseurl = BaseUrl::getServer();

            header("Location: $baseurl");

        }

        if (!$result2 || mysqli_num_rows($result2) <= 0) {
          
            $baseurl = BaseUrl::getServer();

            header("Location: $baseurl");          

        }

        $dataUsuario = mysqli_fetch_array($result2);
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
              <h3 class="box-title">Usuario Usuario</h3>
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

                <input type="hidden" value="<?= $id ?>" name="id">
              <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombres</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese su nombre" value="<?= $dataUsuario['nombres']  ?>">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Apellidos</label>
                        <input type="text" class="form-control" name="apellido" placeholder="Ingrese su apellido" value="<?= $dataUsuario['apellidos'] ?>">
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
                        <input type="email" class="form-control" name="email" placeholder="Ingrese correo electronico" value="<?= $dataUsuario['email'] ?>">
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


