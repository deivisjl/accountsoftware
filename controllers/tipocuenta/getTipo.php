 <?php

include '../../config/config.php';

$search = $_GET;

$limite = $search['start'].','.$search['length'];

$ordenadores = array("id","nombre","created_at");

$columna = $search['order'][0]["column"];

$criterio = $search['search']['value'];

$query = "SELECT id, nombre, descripcion, created_at as fecha 
				from tipocuenta
					Where {$ordenadores[$columna]} LIKE '%$criterio%'
							Order by {$ordenadores[$columna]} {$search['order'][0]["dir"]}
								LIMIT {$limite} ";

$queryCount = "SELECT count(id) as Total
				from tipocuenta
					Where {$ordenadores[$columna]} LIKE '%$criterio%'
							Order by {$ordenadores[$columna]} {$search['order'][0]['dir']}";

$datosResult = mysqli_query($db,$query);

$datosCount = mysqli_query($db,$queryCount);
$cantidad = mysqli_fetch_array($datosCount);

$valores = array();

 while($datos = mysqli_fetch_array($datosResult)){ 
 	$valores[] = array(
			'Id' => $datos["id"],
			'Nombre' => $datos["nombre"],
			'Descripcion' => $datos["descripcion"],
			'Fecha' => $datos["fecha"],
	);
	
 }

$respuesta = array(
		'draw' => $search["draw"],
		'recordsTotal' => $cantidad["Total"],
		'recordsFiltered' => $cantidad["Total"],
		'data' => $valores,
		);



	print_r(json_encode($respuesta));

?>
