 <?php

include '../../config/config.php';
include '../../includes/TimeFormat.php';

$search = $_GET;

$limite = $search['start'].','.$search['length'];

$ordenadores = array("H.id","H.nocheque","B.nombre","C.nocuenta","H.tenedor","T.debe","T.haber","H.created_at");

$columna = $search['order'][0]["column"];

$criterio = $search['search']['value'];

$query = "SELECT B.nombre, C.nocuenta, H.id, H.nocheque, H.tenedor, H.created_at, T.debe, T.haber 
				from cheque as H 
					inner join transaccion as T 
						on H.id = T.chequeid 
							inner join cuentabancaria as C 
								on T.cuentaid = C.id 
									inner join banco as B 
										on C.bancoid = B.id
											Where {$ordenadores[$columna]} LIKE '%$criterio%'
												Order by {$ordenadores[$columna]} {$search['order'][0]["dir"]}
													LIMIT {$limite}";


$queryCount = "SELECT count(H.id) as Total
				from cheque as H 
					inner join transaccion as T 
						on H.id = T.chequeid 
							inner join cuentabancaria as C 
								on T.cuentaid = C.id 
									inner join banco as B 
										on C.bancoid = B.id
											Where {$ordenadores[$columna]} LIKE '%$criterio%'
													Order by {$ordenadores[$columna]} {$search['order'][0]['dir']}";

$datosResult = mysqli_query($db,$query);

$datosCount = mysqli_query($db,$queryCount);
$cantidad = mysqli_fetch_array($datosCount);

$valores = array();

 while($datos = mysqli_fetch_array($datosResult)){ 

 	$hace = TimeFormat::imprimirTiempo($datos["created_at"]);

 	$valores[] = array(
			'codigo' => $datos["id"],
			'nocheque' => $datos["nocheque"],
			'banco' => $datos["nombre"],
			'cuenta' => $datos["nocuenta"],
			'tenedor' => $datos["tenedor"],
			'deposito' => $datos["debe"],
			'retiro' => $datos["haber"],
			'fecha' => "<span class='fa fa-clock-o fa-1x' aria-hidden='true'></span> "." ". $hace
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
