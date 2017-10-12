<?php 

session_start();

include '../../config/config.php';

include '../../includes/baseurl.php';


	$detalle = $_POST;	

	$fecha = date("Y-m-d");

	try {

		$db->autocommit(false); 

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

					$idCheque = $db->insert_id;

					/*======= tabla transaccion ==================*/
					$tabla_transaccion = "INSERT into transaccion
					values(NULL,'{$c['cantidad']}', 0.00, 0.00,'{$fecha}','{$idCheque}','{$detalle['cuentaid']}')";								
					$result_transaccion = $db->query($tabla_transaccion);

					if (!$result_transaccion) {
						
						throw new Exception('Ocurrió un error: '.$db->error);
						exit();
					}

				}	
				
			}else {

				throw new Exception("No existen cheques a registrar");
				
			} 	
			
			/*=============FIN=================*/

			$db->commit();

			$response["message"] = "El deposito se realizo con exito";

			$response["class"] = "alert alert-success alert-dismissible";
			
			$_SESSION['cuentaban'] = $response;

			respuesta(null);

		
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