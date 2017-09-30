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

  $query = "INSERT into categoriaactivo 
      values(NULL,'{$parametros['nombre']}','{$parametros['desc']}','{$parametros['percent']}','{$fecha}')";

  $result = $db->query($query);

  if ($result) {

    $response["message"] = "Registro exitoso";

    $response["class"] = "alert alert-success alert-dismissible";
    
    $_SESSION['categoria'] = $response;

    header("Location: $baseurl/categoria.php");

  }else{

    $response["message"] = "Error en el registro";

    $response["class"] = "alert alert-danger alert-dismissible";

    $_SESSION['categoria'] = $response;

    header("Location: $baseurl/categoria.php");
    
  }
}

function editar($parametros = array(), $db){

  $id = $parametros['id'];

  $query = "UPDATE categoriaactivo 
        set nombre = '{$parametros['nombre']}', descripcion = '{$parametros['desc']}', porcid = '{$parametros['percent']}'
          Where id = '{$id}'";          

  $result = $db->query($query);

  if ($result) {
    
    $response["message"] = "Actualizacion exitosa";

    $response["class"] = "alert alert-success alert-dismissible";
    
    $_SESSION['categoria'] = $response;

    header("Location: $baseurl/categoria.php");

  }else{

    $response["message"] = "Error al actualizar";

    $response["class"] = "alert alert-danger alert-dismissible";

    $_SESSION['categoria'] = $response;

    header("Location: $baseurl/categoria.php");

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