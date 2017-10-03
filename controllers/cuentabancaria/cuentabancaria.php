<?php  
  session_start();

include '../../config/config.php';

include '../../includes/baseurl.php';

$baseurl = BaseUrl::getServer();

if (isset($_POST['guardar'])) {
  
  $parametros = parseIncomingParameters();

  guardar($parametros, $db);

}else if(isset($_POST['editar'])){

  $parametros = array();

  $parametros = parseIncomingParameters();

  editar($parametros,$db);

}else{

  header("Location: index.php");
}

function guardar($parametros, $db){

  $response = array();

  $fecha = date("Y-m-d");

  $query = "INSERT into cuentabancaria 
      values(NULL,'{$parametros['cuenta']}','{$parametros['nombre']}',
                '{$parametros['banco']}','{$parametros['tipo']}','{$fecha}')";

  $result = $db->query($query);

  if ($result) {

    $response["message"] = "Registro exitoso";

    $response["class"] = "alert alert-success alert-dismissible";
    
    $_SESSION['cuentaban'] = $response;

    header("Location: $baseurl/cuentabancaria.php");

  }else{

    $response["message"] = "Error en el registro";

    $response["class"] = "alert alert-danger alert-dismissible";

    $_SESSION['cuentaban'] = $response;

    header("Location: $baseurl/cuentabancaria.php");
    
  }
}

function editar($parametros = array(), $db){

  $id = $parametros['id'];

  $query = "UPDATE cuentabancaria 
                set nocuenta = '{$parametros['cuenta']}', titular = '{$parametros['nombre']}',
                      bancoid = '{$parametros['banco']}', tipoid = '{$parametros['tipo']}' 
                                Where id = '{$id}'";

  $result = $db->query($query);

  if ($result) {
    
    $response["message"] = "Actualizacion exitosa";

    $response["class"] = "alert alert-success alert-dismissible";
    
    $_SESSION['cuentaban'] = $response;

    header("Location: $baseurl/cuentabancaria.php");

  }else{

    $response["message"] = "Error en al actualizar";

    $response["class"] = "alert alert-danger alert-dismissible";

    $_SESSION['cuentaban'] = $response;

    header("Location: $baseurl/cuentabancaria.php");

  }


}

function parseIncomingParameters(){

  $parameter = array();

  $body = json_encode($_POST);

  $body_params = json_decode($body);

  if ($body_params) {
            foreach ($body_params as $param_name => $param_value) {
                $parameter[$param_name] = $param_value;
            }
    }

    return $parameter;

}


?>