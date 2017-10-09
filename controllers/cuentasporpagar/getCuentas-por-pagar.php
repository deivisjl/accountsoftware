 <?php

include '../../config/config.php';
include '../../includes/TimeFormat.php';



$search = $_GET;

$limite = $search['start'].','.$search['length'];

$ordenadores = array("C.id","C.compraid","C.saldo","C.created_at","P.nombre");

$columna = $search['order'][0]["column"];

$criterio = $search['search']['value'];

//DATE_FORMAT(C.created_at,'%d/%m/% Y H:i:s')

$query = "SELECT C.id, C.compraid, C.saldo, C.created_at as hace, P.nombre as plazo 
				from cuentaporpagar as C
					inner join plazo as P
						on C.plazoid = P.id
					Where {$ordenadores[$columna]} LIKE '%$criterio%'
							Order by {$ordenadores[$columna]} {$search['order'][0]["dir"]}
								LIMIT {$limite} ";

$queryCount = "SELECT count(C.id) as Total
				from cuentaporpagar as C
					inner join plazo as P
						on C.plazoid = P.id
					Where {$ordenadores[$columna]} LIKE '%$criterio%'
							Order by {$ordenadores[$columna]} {$search['order'][0]['dir']}";

$datosResult = mysqli_query($db,$query);

$datosCount = mysqli_query($db,$queryCount);
$cantidad = mysqli_fetch_array($datosCount);

$valores = array();

 while($datos = mysqli_fetch_array($datosResult)){ 
 	$hace = TimeFormat::imprimirTiempo($datos["hace"]);
 	$valores[] = array(
			'Id' => $datos["id"],
			'Compra' => $datos["compraid"],
			'Saldo' => "Q. ".$datos["saldo"],
			'Fecha' => "<span class='fa fa-clock-o fa-1x' aria-hidden='true'></span> "." ". $hace,
			'Plazo' => $datos["plazo"],
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
