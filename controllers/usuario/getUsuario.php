 <?php

include '../../config/config.php';

$search = $_GET;

$limite = $search['start'].','.$search['length'];

$ordenadores = array("U.id","U.nombres","U.email","R.rolid","U.created_at");

$columna = $search['order'][0]["column"];

$criterio = $search['search']['value'];

$query = "SELECT U.id, CONCAT(U.nombres,' ',U.apellidos) as nombre, U.email, U.created_at as fecha,R.nombre as rol
				from users as U
					inner join rol as R
						on U.rolid = R.id
					Where {$ordenadores[$columna]} LIKE '%$criterio%'
							Order by {$ordenadores[$columna]} {$search['order'][0]["dir"]}
								LIMIT {$limite} ";

$queryCount = "SELECT count(U.id) as Total
				from users as U
					inner join rol as R
						on U.rolid = R.id
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
			'Email' => $datos["email"],
			'Rol' => $datos["rol"], 
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
