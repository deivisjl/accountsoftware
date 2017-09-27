<?php
	// Inicio sesiones

session_start();
//Logout
if(isset($_SESSION["account"])){
	include '/controllers/baseurl.php';
	unset($_SESSION["account"]);
	
	$baseUrl = BaseUrl::getServer();

	header("Location:" . $baseUrl);
}
?>