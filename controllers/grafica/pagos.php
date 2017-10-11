<?php  
	session_start();

include '../../config/config.php';

include '../../includes/baseurl.php';

$cols = [];

$rows = [];

$resp = [];

$query = "SELECT sum(C.saldo) as pagar, sum(P.monto) as pagado";


$result = $db->query($query);



$cols = array(	
				array('id' => '', 'label' => 'Topping','pattern'=>'','type'=>'string'), 
				array('id' => '', 'label' => 'Q.','pattern'=>'','type'=>'number')
				);
/*$cols = array(	
				array('id' => '', 'label' => 'Topping','pattern'=>'','type'=>'string'), 
				array('id' => '', 'label' => 'Slices','pattern'=>'','type'=>'number')
				);

$rows = array(
				array('c' => array(array('v'=>'Banco Azteca','f' => null),array('v'=> 6 ,'f' => null))),
				array('c' => array(array('v'=>'Banrural','f' => null),array('v'=> 3 ,'f' => null)))
			);

$resp = array('cols' => $cols, 'rows' => $rows);
print_r(json_encode($resp));
die();*/

if ($result) {	
	
	while ($datos = mysqli_fetch_array($result)) {
		$rows[] = array(
				"c" => array(array('v' => $datos['nombre'],'f' => null), array('v' => (int)$datos['gasto'],'f' => null))
		);
	}

	$resp = array('cols' => $cols, 'rows' => $rows);

	 print_r(json_encode($resp));	
}


?>