<?php
$seccion='traduccion';
//%%%%%%%%%%%%%%%%%%%%%%%%%%    Nueva Variable     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['new'])){ 
		// Obtenemos los valores enviados
		if (isset($_POST['variable'])){ $variable=htmlentities($_POST['variable'], ENT_QUOTES); }else{ $variable=''; $fallo=1; }

		$consulta= $CONEXION -> query("SELECT * FROM $seccion WHERE variable = '$variable'");
		$numRows=$consulta->num_rows;

		// Actualizamos la base de datos
		if ($numRows==0) {
			if(!isset($fallo)){
				$sql = "INSERT INTO $seccion (variable)".
					"VALUES ('$variable')";
				if($insertar = $CONEXION->query($sql)){
					$exito=1;
					$legendSuccess .= "<br>Variable agregada";
				}else{
					$fallo=1;  
					$legendFail .= "<br>No se pudo agregar a la base de datos";
				}
			}else{
				$fallo=1;  
				$legendFail .= "<br>No se recibieron datos";
			}
		}else{
			$fallo=1;
			$legendFail.='<br>Ya existe la variable';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Guardar valor de idioma    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['editavalor'])) {

		include '../../../includes/connection.php';
		include '../../../includes/config.php';

		$id    = $_POST['id'];
		$lang  = $_POST['lang'];
		$valor = htmlentities($_POST['valor'], ENT_QUOTES);

		if ($actualizar = $CONEXION->query("UPDATE $seccion SET $lang = '$valor' WHERE id = $id")) {
			echo '<span class="uk-text-success"><span uk-icon="icon: check"></span> Guardado</span>';
		}else{
			echo '<span class="uk-text-danger"><span uk-icon="icon: close"></span> No se pudo guardar</span>';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['borrarPod'])){
		if($borrar = $CONEXION->query("DELETE FROM $seccion WHERE id = $id")){
			$exito=1;
			$legendSuccess .= "<br>Variable eliminada";
		}else{
			$legendFail .= "<br>No se pudo borrar de la base de datos";
			$fallo=1;  
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar políticas de pago   %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['pagostextos'])){

		$arreglo=array('es','en','ja','ru','pt','it');
		foreach ($arreglo as $key) {
			// Obtenemos los valores enviados
			if (isset($_POST['pagos'.$key])){ 
				$campo='pagos'.$key;
				$value=str_replace("'", "´", $_POST[$campo]); 
				if($actualizar = $CONEXION->query("UPDATE configuracion SET $campo = '$value' WHERE id = 2")){
				}else{
					$legendSuccess.='<br>'.$key;
				}
			}
		}
		$exito=1;
		$legendSuccess.='<br>Políticas de pago editada';
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar políticas de cursos    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['cursostextos'])){

		$arreglo=array('es','en','ja','ru','pt','it');
		foreach ($arreglo as $key) {
			// Obtenemos los valores enviados
			if (isset($_POST['cursotexto'.$key])){ 
				$campo='cursotexto'.$key;
				$value=str_replace("'", "´", $_POST[$campo]); 
				if($actualizar = $CONEXION->query("UPDATE configuracion SET $campo = '$value' WHERE id = 3")){
				}else{
					$legendSuccess.='<br>'.$key;
				}
			}
		}
		$exito=1;
		$legendSuccess.='<br>Editado';
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Chino    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_GET['chinochange'])){
		$file=$_GET['chinochange'];
		$rutaInicial="../library/upload-file/php/uploads/";
		$rutaFinal='../files/';

		$CONSULTA3 = $CONEXION -> query("SELECT pices FROM configuracion WHERE id = 10");
		$row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();
		unlink($rutaFinal.$row_CONSULTA3['pices']);
		$newName=rand(111111111,999999999).'.pdf';
		$actualizar = $CONEXION->query("UPDATE configuracion SET pices = '$newName' WHERE id = 10");
		copy($rutaInicial.$file, $rutaFinal.$newName);
		$exito=1;
		$legendSuccess.='<br>Guardado';
	}

