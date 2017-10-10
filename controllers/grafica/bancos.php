<?php  
	session_start();

include '../../config/config.php';

include '../../includes/baseurl.php';

$array_data = [];

$query = "SELECT count(T.id) as conteo, B.nombre 
			from transaccion as T 
					inner join cuentabancaria as C 
							On T.cuentaid = C.id 
								inner join banco as B 
									On C.bancoid = B.id 
											group by B.nombre";

$result = $db->query($query);

if ($result) {	
	
	while ($datos = mysqli_fetch_array($result)) {
		$array_data[] = array(
				"name" => $datos["nombre"], "y" => (int)$datos['conteo']
		);
	}

	 print_r(json_encode($array_data));	
}


?>