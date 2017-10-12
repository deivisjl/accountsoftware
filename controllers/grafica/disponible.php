<?php  
	session_start();

include '../../config/config.php';

include '../../includes/baseurl.php';

$cols = [];

$rows = [];

$resp = [];

$query = "SELECT sum(T.debe - T.haber) as saldo, B.nombre as banco 
				from transaccion as T 
					inner join cuentabancaria as C 
						on T.cuentaid = C.id
							inner join banco as B
								on C.bancoid = B.id
									group by B.nombre";


$result = $db->query($query);

$cols = array(	
				array('id' => '', 'label' => 'Topping','pattern'=>'','type'=>'string'), 
				array('id' => '', 'label' => 'Slices','pattern'=>'','type'=>'number')
				);


if ($result) {	
	
	while ($datos = mysqli_fetch_array($result)) {
		$rows[] = array(
				"c" => array(array('v' => $datos['banco'],'f' => null), array('v' => (int)$datos['saldo'],'f' => null))
		);
	}

	$resp = array('cols' => $cols, 'rows' => $rows);

	 print_r(json_encode($resp));	
}


?>