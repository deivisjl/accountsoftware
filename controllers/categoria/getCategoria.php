 <?php

include '../../config/config.php';

$search = $_GET;

$limite = $search['start'].','.$search['length'];

$ordenadores = array("C.id","C.nombre","P.porcid","C.descripcion","C.created_at");

$columna = $search['order'][0]["column"];

$criterio = $search['search']['value'];

$query = "SELECT C.id, C.nombre, C.descripcion, C.created_at as fecha, P.porcentaje 
				from categoriaactivo as C
					inner join porcdeprec as P
						on C.porcid = P.id
					Where {$ordenadores[$columna]} LIKE '%$criterio%'
							Order by {$ordenadores[$columna]} {$search['order'][0]["dir"]}
								LIMIT {$limite} ";

$queryCount = "SELECT count(C.id) as Total
				from categoriaactivo as C
					inner join porcdeprec as P
						on C.porcid = P.id
					Where {$ordenadores[$columna]} LIKE '%$criterio%'
							Order by {$ordenadores[$columna]} {$search['order'][0]['dir']}";

$datosResult = mysqli_query($db,$query);

$datosCount = mysqli_query($db,$queryCount);
$cantidad = mysqli_fetch_array($datosCount);

$valores = array();

 while($datos = mysqli_fetch_array($datosResult)){ 
 	$valores[] = array(
			'Id' => $datos["id"],
			'Categoria' => $datos["nombre"],
			'Porcentaje' => $datos["porcentaje"] . " %",
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
