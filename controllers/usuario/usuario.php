<?php  
  session_start();

include '../../config/config.php';

include '../../includes/baseurl.php';

$baseurl = BaseUrl::getServer();

if (isset($_POST['guardar'])) {

  $parametros = array();
  
  $parametros = parseIncomingParameters();

  guardar($parametros, $db);

}else if(isset($_POST['editar'])){

  $parametros = array();

  $parametros = parseIncomingParameters();

  editar($parametros,$db);

}else{

  header("Location: index.php");
}

function guardar($parametros = array(), $db){

  $response = array();

  $fecha = date("Y-m-d");

  $password = sha1($parametros['pass']);

  $query = "INSERT into users 
      values(NULL,'{$parametros['nombre']}','{$parametros['apellido']}',
                      '{$parametros['email']}','{$password}','{$parametros['rol']}','{$fecha}')";

  $result = $db->query($query);

  if ($result) {

    $response["message"] = "Registro exitoso";

    $response["class"] = "alert alert-success alert-dismissible";
    
    $_SESSION['usuario'] = $response;

    header("Location: $baseurl/usuario.php");

  }else{

    $response["message"] = "Error en el registro";

    $response["class"] = "alert alert-danger alert-dismissible";

    $_SESSION['usuario'] = $response;

    header("Location: $baseurl/usuario.php");
    
  }
}

function editar($parametros = array(), $db){

  $id = $parametros['id'];

  $query = "UPDATE users 
        set nombres = '{$parametros['nombre']}', apellidos = '{$parametros['apellido']}', email = '{$parametros['email']}', rolid = '{$parametros['rol']}'
          Where id = '{$id}'"; 

  $result = $db->query($query);

  if ($result) {
    
    $response["message"] = "Actualizacion exitosa";

    $response["class"] = "alert alert-success alert-dismissible";
    
    $_SESSION['usuario'] = $response;

    header("Location: $baseurl/usuario.php");

  }else{

    $response["message"] = "Error al actualizar";

    $response["class"] = "alert alert-danger alert-dismissible";

    $_SESSION['usuario'] = $response;

    header("Location: $baseurl/usuario.php");

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