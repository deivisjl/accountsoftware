<?php 

session_start();

include '../../config/config.php';

include '../../includes/baseurl.php';


	$detalle = $_POST;

	$idCompra = 0;

	$fecha = date("Y-m-d");

	try {

		$db->autocommit(false); 

		/*======== insercion de tabla pagocompra ==========*/

		$tabla_pagocompra = "INSERT into pagocompra 
				values(NULL,'{$detalle['cuentaid']}', '{$detalle['totalcheque']}','{$fecha}')";

		$result_pagocompra = $db->query($tabla_pagocompra);

		if ($result_pagocompra) {			

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
										values(NULL, '{$detalle['compraid']}', '{$idCheque}','{$fecha}')";

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

			$db->commit();

			$response["message"] = "El pago se realizo con exito";

			$response["class"] = "alert alert-success alert-dismissible";
			
			$_SESSION['pagocuenta'] = $response;

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