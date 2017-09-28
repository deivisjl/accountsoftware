<?php

include 'includes/baseurl.php';

session_start();
//Logout
if(isset($_SESSION["login"])){

	session_unset($_SESSION["login"]);

	$baseUrl = BaseUrl::getServer();

	header("Location:" . $baseUrl);
}
?>