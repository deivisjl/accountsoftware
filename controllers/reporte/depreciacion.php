 <?php

include '../../config/config.php';

include '../../includes/TimeFormat.php';

$search = $_GET;

$limite = $search['start'].','.$search['length'];

$ordenadores = array("A.id","A.nombre","A.costo","C.nombre","A.created_at","P.porcentaje");

$columna = $search['order'][0]["column"];

$criterio = $search['search']['value'];

$query = "SELECT A.id, A.nombre as activo, A.costo, A.created_at, C.nombre as categoria, P.porcentaje 
			from activofijo as A 
					inner join categoriaactivo as C 
						on A.categoriaid = C.id 
							inner join porcdeprec as P 
								on C.porcid = P.id
					Where {$ordenadores[$columna]} LIKE '%$criterio%'
							Order by {$ordenadores[$columna]} {$search['order'][0]["dir"]}
								LIMIT {$limite} ";

$queryCount = "SELECT count(A.id) as Total
				from activofijo as A 
					inner join categoriaactivo as C 
						on A.categoriaid = C.id 
							inner join porcdeprec as P 
								on C.porcid = P.id
					Where {$ordenadores[$columna]} LIKE '%$criterio%'
							Order by {$ordenadores[$columna]} {$search['order'][0]['dir']}";

$datosResult = mysqli_query($db,$query);

$datosCount = mysqli_query($db,$queryCount);
$cantidad = mysqli_fetch_array($datosCount);

$valores = array();

 while($datos = mysqli_fetch_array($datosResult)){ 

 	$depreciacion = depreciar($datos["costo"], $datos["created_at"], $datos["porcentaje"]);

 	$valor = valorlibros($datos["costo"], $depreciacion);

 	$hace = TimeFormat::imprimirTiempo($datos["created_at"]);

 	$valores[] = array(
			'id' => $datos["id"],
			'nombre' => $datos["activo"],
			'costo' => "Q. " . $datos["costo"],
			'categoria' => $datos["categoria"],
			'fecha' => "<span class='fa fa-clock-o fa-1x' aria-hidden='true'></span> "." ". $hace,
			'porcentaje' => $datos["porcentaje"]."%",
			'depreciacion' => "Q. " . $depreciacion,
			'valor' => "Q. " . $valor
	);
	
 }

$respuesta = array(
		'draw' => $search["draw"],
		'recordsTotal' => $cantidad["Total"],
		'recordsFiltered' => $cantidad["Total"],
		'data' => $valores,
		);



	print_r(json_encode($respuesta));



function depreciar($costo, $fecha, $porc){

	$timestamp = strtotime($fecha);

    $diff = time() - (int)$timestamp;

    $dias = $diff/(60*60*24);

    $tiempo = (int)$dias;

    $preliminar = ($costo * $porc) / 100;

    $result = ($preliminar * $tiempo) / 365;

	return number_format($result, 2, '.', '');
}	

function valorlibros($costo, $deprec){

	return $costo - $deprec;
}

?>
