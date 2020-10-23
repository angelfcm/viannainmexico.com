<?php
$seccionSQL='metadatos';
//%%%%%%%%%%%%%%%%%%%%%%%%%%    Guardar valor de idioma    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['editavalor'])) {

		include '../../../includes/connection.php';
		include '../../../includes/config.php';

		$id    = $_POST['id'];
		$lang  = $_POST['lang'];
		$valor = htmlentities($_POST['valor'], ENT_QUOTES);

		if ($actualizar = $CONEXION->query("UPDATE $seccionSQL SET $lang = '$valor' WHERE id = $id")) {
			echo '<span class="uk-text-success"><span uk-icon="icon: check"></span> Guardado</span>';
		}else{
			echo '<span class="uk-text-danger"><span uk-icon="icon: close"></span> No se pudo guardar</span>';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    OG image    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_GET['ogimage'])){
		$file=$_GET['ogimage'];
		$rutaInicial="../library/upload-file/php/uploads/";
		$rutaFinal='../img/design/';

		if (file_exists($rutaInicial.$file)) {
			$CONSULTA3 = $CONEXION -> query("SELECT picen FROM configuracion WHERE id = 10");
			$row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();
			unlink($rutaFinal.$row_CONSULTA3['picen']);
			$newName=rand(111111111,999999999).'.jpg';
			$actualizar = $CONEXION->query("UPDATE configuracion SET picen = '$newName' WHERE id = 10");
			copy($rutaInicial.$file, $rutaFinal.$newName);
			$exito=1;
			$legendSuccess.='<br>Guardado';
			unlink($rutaInicial.$file);
		}
	}


