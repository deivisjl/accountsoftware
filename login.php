<?php 
session_start();
  if(isset($_SESSION["login"])){ 

    header("Location: index.php");
  }else{
  include 'includes/baseurl.php'; 
  include 'views/header-login.php';
?>

        <div class="row text-center ">
            <div class="col-md-12" style="background: #ffffff;">
                <br><br>
                <h2> Iniciar sesión</h2>
                 <br>
            </div>
        </div>

          <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <strong>Ingreso de Credenciales</strong>  
                  </div>
                  <div class="panel-body">
                      <form role="form" action="/controllers/auth/auth.php" method="post">
                           <br />
                         <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                <input type="text" class="form-control" placeholder="Correo Electrónico " name="email" />
                            </div>
                                                                  <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                <input type="password" class="form-control"  placeholder="Contraseña" name="password" />
                                <input type="hidden" name="login" value="">
                            </div>
                         <input type="submit" class="btn btn-primary " value="Entrar"></input>

                        </form>
                  </div>
                 
              </div>
          </div>
 
 <?php 
  include 'views/footer.php';   
?>


<?php } ?>








