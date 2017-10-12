<?php  
    include 'includes/baseurl.php'; 
    include 'config/config.php';

    if(isset($_GET["id"]) && !empty($_GET['id'])){

      $id = $_GET["id"];

      $query = "SELECT C.id, C.nocuenta, B.nombre from cuentabancaria as C
                    inner join banco as B 
                        on C.bancoid = B.id 
                            Where C.id = '{$id}'";

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
            <div class="box-header with-border text-center">
              <h3 class="box-title">Realizar deposito bancario</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <a href="/cuentabancaria.php"><span class="fa fa-arrow-circle-left fa-3x"></span></a>
                    </div>
                </div>  
              
            
              <div class="row">

              <form role="form" id="frm_deposito" method="post" action="/controllers/banco/transBanco.php">

                <input type="hidden" id="idcuenta" value="<?= $array['id'] ?>">

                  <div class="col-md-6">
                      <div class="box-body">
                          <div class="box box-success">
                                <section class="content-header text-center">
                                    <h4>Datos de la cuenta bancaria</h4>
                                </section>

                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Banco</label>
                                        <input type="text" class="form-control" name="banco" id="banco" value="<?= $array['nombre']  ?>" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label>No Cuenta</label>
                                        <input type="text" class="form-control" name="cuenta" id="cuenta" value="<?= $array['nocuenta']  ?>" disabled>
                                    </div>
                                </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-md-6">
                      <div class="box-body">
                          <div class="box box-info">
                                <section class="content-header text-center">
                                    <h4>Datos del cheque depositado</h4>
                                </section>

                                <div class="box-body">
                                    <div class="form-group">
                                        <label>No Cheque</label>
                                        <input type="text" class="form-control"  id="nocheque" >
                                    </div>

                                    <div class="form-group">
                                        <label>Tenedor</label>
                                        <input type="text" class="form-control" id="tenedor">
                                    </div>

                                    <div class="form-group">
                                        <label>Monto</label>
                                        <input type="text" class="form-control" id="monto">
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary"  type="button" id="agregar">Agregar</button>
                                    </div>
                                </div>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-12">
                      <div class="box-body">
                          <div class="box box-warning">
                              <section class="content-header text-center">
                                    <h4>Detalle de cheques depositados</h4>
                              </section>

                                <div id="cheque-detalle"></div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>


      <div class="box-body">
          <button class="btn btn-primary btn-block btn-lg" type="submit" id="generar-deposito">Realizar deposito</button>
      </div>
    </form>

            
</div>




<!--=========================================================================================-->

<?php 

  include 'views/footer.php';   
?>

<script type="text/javascript" src="/views/js/js-render.js"></script>

<script type="text/javascript" src="/views/js/cheque-deposito.js"></script>

<script type="text/javascript" id="cheque-detalle-template" type="text/x-jsrender">

<table class="table table-bordered  no-footer">
  <tr>
    <th>No Cheque</th>    
    <th>Tenedor</th>
    <th>Monto</th>
    <th>Accion</th>
  </tr>

    {{for cheques}}
          <tr>
            <td>{{:chequeno}}</td>
            <td>{{:tenedor}}</td>
            <td>{{:cantidad}}</td>
            <td><a class="label label-danger" onclick="detalle_cheque.retirar({{:id}});">Eliminar</a></td>
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
