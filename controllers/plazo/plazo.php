<?php  
	session_start();

include '../../config/config.php';

include '../../includes/baseurl.php';

$baseurl = BaseUrl::getServer();

if (isset($_POST['guardar'])) {
	
	$nombre = $_POST['nombre'];

	guardar($nombre, $db);

}else if(isset($_POST['editar'])){

	$parametros = array();

	$parametros = parseIncomingParameters();

	editar($parametros,$db);

}else{

	header("Location: index.php");
}

function guardar($nombre, $db){

	$response = array();

	$fecha = date("Y-m-d");

	$query = "INSERT into plazo values(NULL,'{$nombre}','{$fecha}')";

	$result = $db->query($query);

	if ($result) {

		$response["message"] = "Registro exitoso";

		$response["class"] = "alert alert-success alert-dismissible";
		
		$_SESSION['plazo'] = $response;

		header("Location: $baseurl/plazo.php");

	}else{

		$response["message"] = "Error en el registro";

		$response["class"] = "alert alert-danger alert-dismissible";

		$_SESSION['plazo'] = $response;

		header("Location: $baseurl/plazo.php");
		
	}
}

function editar($parametros = array(), $db){

	$nombre = $parametros['nombre'];

	$id = $parametros['id'];

	$query = "UPDATE plazo set nombre = '{$nombre}' Where id = '{$id}'";

	$result = $db->query($query);

	if ($result) {
		
		$response["message"] = "Actualizacion exitosa";

		$response["class"] = "alert alert-success alert-dismissible";
		
		$_SESSION['plazo'] = $response;

		header("Location: $baseurl/plazo.php");

	}else{

		$response["message"] = "Error en al actualizar";

		$response["class"] = "alert alert-danger alert-dismissible";

		$_SESSION['plazo'] = $response;

		header("Location: $baseurl/plazo.php");

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