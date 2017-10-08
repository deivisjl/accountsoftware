<?php  
    include 'includes/redirect.php'; 
    include 'includes/baseurl.php'; 
    include 'config/config.php';

      $query = "SELECT id, nombre as categoria from categoriaactivo";

      $query2 = "SELECT id, nombre as metodo from metododeprec";

      $query3 = "SELECT id, nombre as tipo from tipocompra";

      $query4 = "SELECT C.id, CONCAT(B.nombre,' ',C.nocuenta) as banconombre from cuentabancaria as C inner join banco as B on C.bancoid = B.id";

      $query5 = "SELECT id, nombre as plazo from plazo";

      $result = $db->query($query);

      $result2 = $db->query($query2);

      $result3 = $db->query($query3);

      $result4 = $db->query($query4);

      $result5 = $db->query($query5);

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

        if (!$result4 || mysqli_num_rows($result4) <=  0) {

            $baseurl = BaseUrl::getServer();

            header("Location: $baseurl");

        }

        if (!$result5 || mysqli_num_rows($result5) <=  0) {

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

<style type="text/css">
  .block-loading{
    position:absolute;
    width:100%;
    height:100%;
    top:0;
    left:0;
    background:#fff url(/views/img/loader.gif) no-repeat center;
    opacity:0.7;
  }
  
</style>

<div class="row">
    <div id="load col-md-12"></div>
</div>

<?php if(isset($_SESSION["compratransaccion"]) && !empty($_SESSION["compratransaccion"])) {?>
          <div class="<?= $_SESSION["compratransaccion"]["class"] ?>">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?= $_SESSION["compratransaccion"]["message"]  ?>
          </div>
<?php  } unset($_SESSION["compratransaccion"])?>

          <div class="row">
              <div class="col-md-12">
                  <div class="box box-success">
                      <section class="content-header text-center">
                          <h4>Descripcion del activo a registrar</h4>
                      </section>
                      <form role="form" id="frm_compra" method="post" action="/controllers/compra/compra.php">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del activo">
                                    </div>

                                    <div class="col-md-3">
                                        <input type="text" name="cantidad" id="cantidad" placeholder="Cantidad" class="form-control">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="precio" id="precio" placeholder="Precio unitario">
                                    </div>

                                  </div>

                                  <div class="row">
                                      <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Categoria</label>
                                              <select class="form-control" id="categoria" name="categoria">
                                              <option value="0">--Seleccione una opcion--</option>
                                                  <?php 
                                                      while($results = mysqli_fetch_array($result)){ ?>
                                                      <option value="<?php echo $results["id"] ?>" >
                                                        <?php  echo $results["categoria"]?>
                                                      </option>
                                                  <?php } ?>
                                              </select>  
                                          </div>
                                          
                                      </div>

                                      <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Metodo de depreciacion</label>
                                            <select class="form-control" id="metodo" name="metodo">
                                                <option value="0">--Seleccione una opcion--</option>
                                                <?php 
                                                    while($results2 = mysqli_fetch_array($result2)){ ?>
                                                    <option value="<?php echo $results2["id"] ?>" >
                                                      <?php  echo $results2["metodo"]?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                            <br />
                                            <button type="button" id="agregar-activo" class="btn btn-primary">Agregar</button>
                                        </div>
                                      </div>
                                  </div>

                            </div>
                      <!--End Form-->
                  </div>
              </div>  
          </div>

          <div class="row">
                      <div class="col-md-6">
                          <div class="box box-primary">
                                <section class="content-header text-center">
                                    <h4>Detalle de la compra</h4>
                                    <div id="compra-detalle" class="table">
                                      
                                    </div>
                                </section>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="box box-success">
                                <section class="content-header text-center">
                                    <h4>Forma de pago</h4>
                                </section>
                                <div class="box-body">
                                    <select class="form-control" id="forma" name="metodo">
                                        <option value="0" selected="true">--Seleccione una opcion--</option>
                                        <?php 
                                            while($results3 = mysqli_fetch_array($result3)){ ?>
                                            <option value="<?php echo $results3["id"] ?>" >
                                              <?php  echo $results3["tipo"]?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                          </div>
                      </div>

                   </div>

                   <div class="row">
                                            <div class="col-md-6">
                          <div class="box box-info">
                                <section class="content-header text-center">
                                    <h4>Datos complementarios</h4>
                                      <div class="box-body">
                                          <div class="row">
                                              <div class="col-md-8">
                                                  <div class="form-group text-left">
                                                        <label>No. Voucher</label>
                                                        <input type="text" name="voucher" id="voucher" placeholder="Ingrese el numero de comprobante" class="form-control">
                                                  </div>
                                              </div>
                                          </div>

                                           <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group text-left">
                                                          <label>Nombre del acreedor</label>
                                                          <input type="text" name="acreedor" id="acreedor" placeholder="Ingrese el nombre del acreedor" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                              
<div class="row text-left">
      <div class="col-md-12">
          <label>Plazo de pago</label>
        <?php  
          $band = 0;
        while($results5 = mysqli_fetch_array($result5)){ ?>
              <div class="radio">
                <label>
                  <input type="radio" name="optionsRadios" id="optionsRadios1" value="<?= $results5['id']  ?>" <?php if($band == 0){ echo 'checked'; } ?> >
                  <?= $results5['plazo'] ?>
                </label>
              </div>
        <?php $band++; } ?>
    
    </div>
</div>
                                                

                                      </div>
                                </section>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="box box-primary text-center">
                                <section class="content-header text-center">
                                    <h4>Datos del cheque</h4>
                                </section>

                                <div class="box-body text-left">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Cheque No.</label>
                                                  <input type="text" name="cheque" id="nocheque" placeholder="Ingrese el numero de cheque" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Cuenta Bancaria</label>
                                                  <select class="form-control" name="cuenta" id="cuenta">
                                                    <option value="0">--Seleccione una opcion--</option>
                                                  <?php 
                                                      while($results4 = mysqli_fetch_array($result4)){ ?>
                                                      <option value="<?php echo $results4["id"] ?>" >
                                                        <?php  echo $results4["banconombre"]?>
                                                      </option>
                                                  <?php } ?>
                                                  </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Tenedor</label>
                                                  <input type="text" name="tenedor" id="tenedor" placeholder="Ingrese el nombre del portador" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cantidad en Quetzales</label>
                                                  <input type="text" name="cantidadq" id="cantidadq" placeholder="Ingrese el monto del cheque" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                        <br>
                                              <button type="button" id="agregar-cheque" class="btn btn-primary">Agregar Cheque</button>
                                        </div>
                                    </div>
                                </div>  
                          </div>
                      </div>
                   </div>

            <div class="row">
                <div class="col-md-12">
                      <div class="box box-danger">
                            <section class="content-header text-center">
                                  <h4>Detalle de forma de pago</h4>
                                  <div id="cheque-detalle"></div>
                            </section>
                      </div>
                </div>
                
                <div class="box-body">
                  <button class="btn btn-primary btn-block btn-lg" type="submit" id="enviar">Generar registro</button>
                </div>
                </form><!--End form-->
            </div> 

        
<!--=========================================================================================-->

<?php 

	include 'views/footer.php'; 	
?>

<script type="text/javascript" src="/views/js/js-render.js"></script>

<script type="text/javascript" src="/views/js/compra-detalle.js"></script>

<script type="text/javascript" id="compra-detalle-template" type="text/x-jsrender">

<table class="table table-bordered  no-footer">
  <tr>
    <th>Nombre</th>
    <th>Cantidad</th>
    <th>Precio</th>
    <th>Accion</th>
  </tr>

    {{for items}}
          <tr>
            <td class="text-left">{{:nombre}}</td>
            <td class="text-left">{{:cantidad}}</td>
            <td class="text-left">{{:precio}}</td>
            <td><a class="label label-danger" onclick="detalle_compra.retirar({{:id}});">Eliminar</a></td>
          </tr>
    {{else}}
        <tr>
            <td class="text-center">No se han agregado items al detalle</td>
        </tr>
    {{/for}}
</table>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h2>Total Q.</h2>
    </div>
    <div class="col-md-4 text-right">
        <h2>{{:total}}</h2>
    </div>
</div>

</script>


<script type="text/javascript" id="cheque-detalle-template" type="text/x-jsrender">

<table class="table table-bordered  no-footer">
  <tr>
    <th>No Cheque</th>
    <th>Cuenta</th>
    <th>Tenedor</th>
    <th>Cantidad</th>
    <th>Accion</th>
  </tr>

    {{for cheques}}
          <tr>
            <td>{{:chequeno}}</td>
            <td>{{:cuenta}}</td>
            <td>{{:tenedor}}</td>
            <td>{{:cantidad}}</td>
            <td><a class="label label-danger" onclick="detalle_compra.retirarcheque({{:id}});">Eliminar</a></td>
          </tr>
    {{else}}
        <tr>
            <td class="text-center">No se han agregado cheques al detalle</td>
        </tr>
    {{/for}}
</table>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h2>Total Q.</h2>
    </div>
    <div class="col-md-4 text-right">
        <h2>{{:totalcheque}}</h2>
    </div>
</div>

</script>

