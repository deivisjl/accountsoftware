<?php  
	session_start();

include '../../config/config.php';

include '../../includes/baseurl.php';

if (isset($_POST['guardar'])) {

	$baseurl = BaseUrl::getServer();
	
	$nombre = $_POST['nombre'];

	guardar($nombre, $db, $baseurl);

}

function guardar($nombre, $db){

	$fecha = date("Y-m-d");

	$query = "INSERT into banco values(NULL,'{$nombre}','{$fecha}')";

	//$result = mysqli_query($db, $query);
	$result = $db->query($query);

	if ($result) {
		
		$_SESSION['insertBanco'] = 1;

		header("Location: $baseurl/banco.php");
	}else{

		$_SESSION['insertBanco'] = 2;

		header("Location: $baseurl/banco.php");
	}
}


?>