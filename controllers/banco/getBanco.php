 <?php

include '../../config/config.php';

$search = $_GET;

$limite = $search['start'].','.$search['length'];

$ordenadores = array("id","nombre","created_at");

$columna = $search['order'][0]["column"];

$criterio = $search['search']['value'];

$query = "SELECT id, nombre, created_at as fecha 
				from banco
					Where {$ordenadores[$columna]} LIKE '%$criterio%'
							Order by {$ordenadores[$columna]} {$search['order'][0]["dir"]}
								LIMIT {$limite} ";

$datosResult = mysqli_query($db,$query);

$valores = array();

$cantidad = 0;

 while($datos = mysqli_fetch_array($datosResult)){ 
 	$valores[] = array(
			'Id' => $datos["id"],
			'Nombre' => $datos["nombre"],
			'Fecha' => $datos["fecha"],
	);

	$cantidad++;		
 }

$respuesta = array(
		'draw' => $search["draw"],
		'recordsTotal' => $cantidad,
		'recordsFiltered' => $cantidad,
		'data' => $valores,
		);



	print_r(json_encode($respuesta));

?>
