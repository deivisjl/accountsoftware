<?php  
include '../../includes/baseurl.php';
$baseUrl = BaseUrl::getServer();

	if (isset($_POST["login"])) {
		
		session_start();
		 
		include '../../config/config.php'; 

		$email = $_POST["email"];
		$password = sha1($_POST["password"]);

		$auth = "SELECT * from users 
			where email = '$email' and password = '$password' ";


		$login = mysqli_query($db, $auth);

		
		if($login && mysqli_num_rows($login) > 0){

		    $_SESSION["account"] = mysqli_fetch_assoc($login);
		    
		    if(isset($_SESSION["error_login"])){
		      unset($_SESSION["error_login"]);
		    }		    

		    
			header("Location:" . $baseUrl);
			

		  }
		  else{

		    header("Location:" . $baseUrl);		
		  }


	}else{

		header("Location:" . $baseUrl);
	}
?>