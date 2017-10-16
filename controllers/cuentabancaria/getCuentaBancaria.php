 <?php

include '../../config/config.php';

$search = $_GET;

$limite = $search['start'].','.$search['length'];

$ordenadores = array("C.id","C.nocuenta","C.titular","B.bancoid","T.tipoid","C.created_at");

$columna = $search['order'][0]["column"];

$criterio = $search['search']['value'];

$query = "SELECT C.id, C.nocuenta, C.titular, B.nombre as banco,T.nombre as tipo,C.created_at as fecha 
				from cuentabancaria as C 
					inner join banco as B
						On C.bancoid = B.id
							inner join tipocuenta as T
								On C.tipoid = T.id
					Where {$ordenadores[$columna]} LIKE '%$criterio%'
							Order by {$ordenadores[$columna]} {$search['order'][0]["dir"]}
								LIMIT {$limite} ";

$queryCount = "SELECT count(C.id) as Total
				from cuentabancaria as C 
					inner join banco as B
						On C.bancoid = B.id
							inner join tipocuenta as T
								On C.tipoid = T.id
									Where {$ordenadores[$columna]} LIKE '%$criterio%'
											Order by {$ordenadores[$columna]} {$search['order'][0]['dir']}";

$datosResult = mysqli_query($db,$query);

$datosCount = mysqli_query($db,$queryCount);

if ($datosCount) {
	
	$cantidad = mysqli_fetch_array($datosCount);
	
}else{

	$cantidad["Total"] = 0;
}

$valores = array();

 while($datos = mysqli_fetch_array($datosResult)){ 
 	$valores[] = array(
			'Id' => $datos["id"],
			'Nocuenta' => $datos["nocuenta"],
			'Titular' => $datos["titular"],
			'Banco' => $datos["banco"],
			'Tipo' => $datos["tipo"],
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
