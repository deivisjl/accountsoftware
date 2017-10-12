<?php  
	session_start();

include '../../config/config.php';

include '../../includes/baseurl.php';

$cols = [];

$rows = [];

$resp = [];


$query = "SELECT count(A.id) as conteo, C.nombre
				from activofijo as A 
						inner join categoriaactivo as C
							on A.categoriaid = C.id
								group by C.nombre";

$result = $db->query($query);


$cols = array(	
				array('id' => '', 'label' => 'Topping','pattern'=>'','type'=>'string'), 
				array('id' => '', 'label' => 'Slices','pattern'=>'','type'=>'number')
				);

/*$rows = array(
				array('c' => array(array('v'=>'Banco Azteca','f' => null),array('v'=> 6 ,'f' => null))),
				array('c' => array(array('v'=>'Banrural','f' => null),array('v'=> 3 ,'f' => null)))
			);

$resp = array('cols' => $cols, 'rows' => $rows);
print_r(json_encode($resp));
die();*/

if ($result) {	
	
	while ($datos = mysqli_fetch_array($result)) {
		$rows[] = array(
				"c" => array(array('v' => $datos['nombre'],'f' => null), array('v' => (int)$datos['conteo'],'f' => null))
		);
	}

	$resp = array('cols' => $cols, 'rows' => $rows);

	 print_r(json_encode($resp));	
}


?>