<?
	if (isset($_POST['guardar'])) {

		for ($i=1; $i < 4; $i++) { 
			$asunto = $_POST['asunto'.$i];
			$remitente = $_POST['remitente'.$i];
			$cuerpo = $_POST['cuerpo'.$i];

			$actualizar = $CONEXION->query("UPDATE correos SET 
				asunto = '$asunto',
				remitente = '$remitente',
				cuerpo = '$cuerpo'
				WHERE id = $i");
		}
		
		$exito=1;
		$legendSuccess .= '<br><span class="uk-text-success"><span uk-icon="icon: check"></span> Guardado</span>';
	}



	if (isset($_POST['identify'])) {

		$correo=$_POST['correo'];
		$password=$_POST['password'];
		$password2=$_POST['password2'];

		if ($password==$password2) {

			$actualizar = $CONEXION->query("UPDATE configuracion SET 
				pices = '$correo',
				picen = '$password'
				WHERE id = 11");

			$exito=1;
			$legendSuccess .= '<br><span class="uk-text-success"><span uk-icon="icon: check"></span> Guardado</span>';
		}else{
			$fallo=1;
			$legendFail.='<br>Las contraseñas no coinciden';
		}
	}



