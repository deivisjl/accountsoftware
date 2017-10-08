<?php 

session_start();

include '../../config/config.php';

include '../../includes/baseurl.php';


	$detalle = $_POST;

	$idCompra = 0;

	$fecha = date("Y-m-d");

	try {

		$db->autocommit(false); 

		/*======== insercion de tabla compra ==========*/

		$tabla_compra = "INSERT into compra 
				values(NULL,'{$detalle['voucher']}', '{$detalle['acreedor']}', 0.00,'{$detalle['total']}','{$detalle['forma_pago']}','{$fecha}')";

		$result_compra = $db->query($tabla_compra);

		if ($result_compra) {

			/*=======insercion del activo============*/

			$idCompra = $db->insert_id; //id de la insercion de la compra

			foreach($detalle['items'] as $d){

				/*======= tabla activofijo ==================*/

				$tabla_activo = "INSERT into activofijo
						values(NULL, '{$d['nombre']}', '{$d['cantidad']}', '{$d['precio']}', '{$d['categoria']}','{$d['metodo']}','{$fecha}')";

				$result_activo = $db->query($tabla_activo);

				if (!$result_activo) {
					
					throw new Exception('Ocurrió un error: '.$db->error);					

					exit();
				}

				/*======= tabla detallecompra ==================*/

				$activoId = $db->insert_id; //obtenemos el id del activo insertado

				$tabla_detalle = "INSERT into detallecompra
								values(NULL,'{$idCompra}','{$activoId}','{$d['cantidad']}','{$fecha}')";

				$result_detalle = $db->query($tabla_detalle);

				if (!$result_detalle) {
					
					throw new Exception('Ocurrió un error: '.$db->error);				

					exit();
				}

			}

			///******************************************************//////

			if (count($detalle['cheques']) > 0) {
				
				foreach($detalle['cheques'] as $c){

					/*======= tabla cheque ==================*/

					$tabla_cheque = "INSERT into cheque 
								values(NULL,'{$c['chequeno']}','{$c['tenedor']}','{$c['cantidad']}','{$fecha}' )";

					$result_cheque = $db->query($tabla_cheque);	

					if (!$result_cheque) {
						
						throw new Exception('Ocurrió un error: '.$db->error);					
						exit();
					}

					/*======= tabla chequecompra ==================*/

					$idCheque = $db->insert_id;

					$tabla_chequecompra = "INSERT into chequecompra
										values(NULL, '{$idCompra}', '{$idCheque}','{$fecha}')";

					$result_chequecompra = $db->query($tabla_chequecompra);

					if (!$result_chequecompra) {
						
						throw new Exception('Ocurrió un error: '.$db->error);
						exit();
					}

					/*======= tabla transaccion ==================*/
					$tabla_transaccion = "INSERT into transaccion
					values(NULL,0.00,'{$c['cantidad']}',0.00,'{$fecha}','{$idCheque}','{$c['cuenta']}')";								
					$result_transaccion = $db->query($tabla_transaccion);

					if (!$result_transaccion) {
						
						throw new Exception('Ocurrió un error: '.$db->error);
						exit();
					}

				}	
				
			}

			///******************************************************//////

			/*================ tabla cuenta por pagar =================*/

			if ($detalle['total'] > $detalle['totalcheque']) {

				$saldo = $detalle['total'] - $detalle['totalcheque'];
				
				$tabla_cuentas = "INSERT into cuentaporpagar
									values(NULL, '{$idCompra}','{$saldo}','{$fecha}','{$detalle['plazo']}')";

				$result_cuentas = $db->query($tabla_cuentas);

				if (!$result_cuentas) {
					
					throw new Exception('Ocurrió un error: '.$db->error);
				}


			}	
			
			/*=============FIN=================*/

			$db->commit();

			$response["message"] = "La compra se realizo con exito";

			$response["class"] = "alert alert-success alert-dismissible";
			
			$_SESSION['compratransaccion'] = $response;

			respuesta(null);



		}else{

			throw new Exception('Ocurrió un error: '.$db->error);

		}

		/*=============================================*/
		
	} catch (Exception $e) {

		$db->rollback();

		respuesta($e->getMessage());
		
	}

	function respuesta($error = null){
		
		if ($error != null) {

			$result["resp"] = "ERROR";
			$result["msj"] = $error;

		}else{

			$result["resp"] = "EXITO";

		}

		print_r(json_encode($result));
	}

	

 ?>