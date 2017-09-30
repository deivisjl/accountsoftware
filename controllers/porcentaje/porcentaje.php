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

	$query = "INSERT into porcdeprec 
			values(NULL,'{$parametros['porcentaje']}','{$parametros['desc']}','{$fecha}')";

	$result = $db->query($query);

	if ($result) {

		$response["message"] = "Registro exitoso";

		$response["class"] = "alert alert-success alert-dismissible";
		
		$_SESSION['perc'] = $response;

		header("Location: $baseurl/porcentaje.php");

	}else{

		$response["message"] = "Error en el registro";

		$response["class"] = "alert alert-danger alert-dismissible";

		$_SESSION['perc'] = $response;

		header("Location: $baseurl/porcentaje.php");
		
	}
}

function editar($parametros = array(), $db){

	$id = $parametros['id'];

	$query = "UPDATE porcdeprec 
				set porcentaje = '{$parametros['porcentaje']}', descripcion = '{$parametros['desc']}' 
					Where id = '{$id}'";

	$result = $db->query($query);

	if ($result) {
		
		$response["message"] = "Actualizacion exitosa";

		$response["class"] = "alert alert-success alert-dismissible";
		
		$_SESSION['perc'] = $response;

		header("Location: $baseurl/porcentaje.php");

	}else{

		$response["message"] = "Error al actualizar";

		$response["class"] = "alert alert-danger alert-dismissible";

		$_SESSION['perc'] = $response;

		header("Location: $baseurl/porcentaje.php");

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