<?
//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar políticas de pago   %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['botontextos'])){

		$arreglo=array('es','en','ja','ru','pt','it');
		foreach ($arreglo as $key) {
			// Obtenemos los valores enviados
			$campo='pagos'.$key;
			$variable='pagos4'.$key;
			$value=str_replace("'", "´", htmlentities($_POST[$variable], ENT_QUOTES));
			if($actualizar = $CONEXION->query("UPDATE configuracion SET $campo = '$value' WHERE id = 4")){
			}else{
				$fallo=1;
				$legendFail.='<br>'.$campo.'<br>'.$value;
			}

			$campo='pagos'.$key;
			$variable='pagos5'.$key;
			$value=str_replace("'", "´", htmlentities($_POST[$variable], ENT_QUOTES));
			if($actualizar = $CONEXION->query("UPDATE configuracion SET $campo = '$value' WHERE id = 5")){
			}else{
				$fallo=1;
				$legendFail.='<br>'.$campo.'<br>'.$value;
			}

			$campo='pagos'.$key;
			$variable='pagos6'.$key;
			$value=str_replace("'", "´", htmlentities($_POST[$variable], ENT_QUOTES));
			if($actualizar = $CONEXION->query("UPDATE configuracion SET $campo = '$value' WHERE id = 6")){
			}else{
				$fallo=1;
				$legendFail.='<br>'.$campo.'<br>'.$value;
			}
		}
		$exito=1;
		$legendSuccess.='<br>Información de pago editada';
	}

