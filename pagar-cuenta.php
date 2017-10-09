<?php  
    include 'includes/baseurl.php'; 
    include 'config/config.php';

    if(isset($_GET["id"]) && !empty($_GET['id'])){

      $id = $_GET["id"];

      $query = "SELECT C.compraid, C.saldo, P.nombre as plazo, DATE_FORMAT(C.created_at,'%d/%m/%Y') as fecha
                      from cuentaporpagar as C 
                        inner join plazo as P
                          On C.plazoid = P.id
                      Where C.id = '{$id}'";

      $query2 = "SELECT C.id, CONCAT(B.nombre,' ',C.nocuenta) as banconombre from cuentabancaria as C inner join banco as B on C.bancoid = B.id";

      $result = $db->query($query);

      $result2 = $db->query($query2);

        if ($result && mysqli_num_rows($result) > 0) {

            $array = mysqli_fetch_array($result);

        }
        else{
            $baseurl = BaseUrl::getServer();

            header("Location: $baseurl");

        }

        if (!$result2 || mysqli_num_rows($result2) <= 0) {

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
            <div class="box-header with-border text-center">
              <h3 class="box-title">Abonar cuenta por pagar</h3>
            </div>

            <div class="box-body">
              <div class="row">
                  <div class="col-md-2">
                      <a href="/cuentas-por-pagar.php"><span class="fa fa-arrow-circle-left fa-3x"></span></a>
                  </div>
              </div>  
            </div>

            <div class="box-body">
                <div class="box box-success">

                <section class="content-header text-center">
                    <h4>Datos de la cuenta</h4>
                </section>
                  <form role="form" id="frm_pago" method="post" action="/controllers/cuentasporpagar/cuentasporpagar.php">
                    <input type="hidden" name="idcuenta" id="idcuenta" value="<?= $id ?>">

                    <input type="hidden" name="idcompra" id="idcompra" value="<?= $array["compraid"] ?>">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Saldo Q.</label>
                                <input type="text" name="saldo" id="saldo" class="form-control" disabled value="<?= $array["saldo"]?>">          
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Plazo</label>
                                <input type="text" name="plazo" id="plazo" class="form-control" disabled value="<?= $array["plazo"]?>">          
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha</label>
                                <input type="text" name="fecha" id="fecha" class="form-control" disabled value="<?= $array["fecha"]?>">          
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="box box-info">
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
                                                      while($array2 = mysqli_fetch_array($result2)){ ?>
                                                      <option value="<?php echo $array2["id"] ?>" >
                                                        <?php  echo $array2["banconombre"]?>
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

                        <div class="col-md-6">
                            <div class="box box-danger">
                                <section class="content-header text-center">
                                    <h4>Detalle del pago</h4>
                                </section>
                                <div id="cheque-detalle"></div>
                            </div>
                        </div>
                    </div>


                    <div class="box-body">
                        <button class="btn btn-primary btn-block btn-lg" type="submit" id="enviar">Abonar cuenta</button>
                  </div>

                  </form>
              </div>
            </div>
            
</div>




<!--=========================================================================================-->

<?php 

	include 'views/footer.php'; 	
?>

<script type="text/javascript" src="/views/js/js-render.js"></script>

<script type="text/javascript" src="/views/js/pago-detalle.js"></script>


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
            <td><a class="label label-danger" onclick="detalle_pago.retirar({{:id}});">Eliminar</a></td>
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
