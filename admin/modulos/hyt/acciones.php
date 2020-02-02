<?php 
//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar titulo del menu     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['save'])){
		
		$variable=$_POST['variable'];
		$error='';

		include '../../../includes/connection.php';

		$arrayName = array(
							'es'=>htmlentities(str_replace("'", "`", $_POST['es'])),
							'en'=>htmlentities(str_replace("'", "`", $_POST['en'])),
							'ja'=>htmlentities(str_replace("'", "`", $_POST['ja'])),
							'ru'=>htmlentities(str_replace("'", "`", $_POST['ru'])),
							'pt'=>htmlentities(str_replace("'", "`", $_POST['pt'])),
							'it'=>htmlentities(str_replace("'", "`", $_POST['it']))
						);

		foreach ($arrayName as $key => $value) {
			if($actualizar = $CONEXION->query("UPDATE traduccion SET $key = '$value' WHERE variable = '$variable'")){
				$exito=1;
			}else{
				$fallo=1;
				$error.=' - '.$key;
			}
		}
		if (!isset($fallo)) {
			echo '
			<span class="uk-notification-message uk-notification-message-success">
				<a href="#" class="uk-notification-close" uk-close></a>
				<span uk-icon=\'icon: check;ratio:2;\'></span> &nbsp; Guardado
			</span>';
		}else{
			echo '
			<span class="uk-notification-message uk-notification-message-danger">
				<a href="#" class="uk-notification-close" uk-close></a>
				<span uk-icon=\'icon: close;ratio:2;\'></span> &nbsp; Error'.$error.'
			</span>';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['configura'])){

		$id=$_POST['id'];
		$error='';

		$arrayName = array(
							'cursotextoes'=>str_replace("'", "`", $_POST['es']),
							'cursotextoen'=>str_replace("'", "`", $_POST['en']),
							'cursotextoja'=>str_replace("'", "`", $_POST['ja']),
							'cursotextoru'=>str_replace("'", "`", $_POST['ru']),
							'cursotextopt'=>str_replace("'", "`", $_POST['pt']),
							'cursotextoit'=>str_replace("'", "`", $_POST['it'])
						);

		foreach ($arrayName as $key => $value) {
			if($actualizar = $CONEXION->query("UPDATE configuracion SET $key = '$value' WHERE id = '$id'")){
				$exito=1;
			}else{
				$fallo=1;
				$error.=' - '.$key;
			}
		}
		$legendSuccess.='<br>Editado';
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar datos del hotel de cabecera 1     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['hoteles1'])){
		$cursotextoes=htmlentities(str_replace("'", "`", $_POST['cursotextoes']));
		$cursotextoen=htmlentities(str_replace("'", "`", $_POST['cursotextoen']));
		$cursotextoja=htmlentities(str_replace("'", "`", $_POST['cursotextoja']));
		$cursotextoru=htmlentities(str_replace("'", "`", $_POST['cursotextoru']));
		$sql = "UPDATE configuracion SET cursotextoes = '$cursotextoes', cursotextoen = '$cursotextoen', cursotextoja = '$cursotextoja', cursotextoru = '$cursotextoru' WHERE id = 8";
		if($actualizar = $CONEXION->query($sql)){
			$exito=1;
			$legendSuccess .= "<br>Guardado";
		}else{
			$fallo=1;
			$legendFail='<br>No se pudo guardar.';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar datos del hotel de cabecera 1     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['hoteles2'])){
		$pagoses=htmlentities(str_replace("'", "`", $_POST['pagoses']));
		$pagosen=htmlentities(str_replace("'", "`", $_POST['pagosen']));
		$pagosja=htmlentities(str_replace("'", "`", $_POST['pagosja']));
		$pagosru=htmlentities(str_replace("'", "`", $_POST['pagosru']));
		$sql = "UPDATE configuracion SET pagoses = '$pagoses', pagosen = '$pagosen', pagosja = '$pagosja', pagosru = '$pagosru' WHERE id = 8";
		if($actualizar = $CONEXION->query($sql)){
			$exito=1;
			$legendSuccess .= "<br>Guardado";
		}else{
			$fallo=1;
			$legendFail='<br>No se pudo guardar.';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Nuevo botón de hotel     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['hotelesnew'])){
		$titulo=htmlentities(str_replace("'", "`", $_POST['titulo']));
		$url=$_POST['url'];
		$sql = "INSERT INTO hoteles (titulo,url) VALUES ('$titulo','$url')";
		if($insertar = $CONEXION->query($sql)){
			$exito=1;
			$legendSuccess .= "<br>Nuevo hotel";
		}else{
			$fallo=1;
			$legendFail='<br>No se pudo guardar.';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar botón de hotel     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['hoteles'])){
		$titulo=htmlentities(str_replace("'", "`", $_POST['titulo']));
		$url=$_POST['url'];
		$sql = "UPDATE hoteles SET titulo = '$titulo', url = '$url' WHERE id = $id";
		if($actualizar = $CONEXION->query($sql)){
			$exito=1;
			$legendSuccess .= "<br>Nuevo hotel";
		}else{
			$fallo=1;
			$legendFail='<br>No se pudo guardar.';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Ordenar Artículos    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['list1'])) {
		include '../../../includes/connection.php';

		$list = $_POST['list1'];
		$num=1;

		foreach ($list as $lista) {
			$actualizar = $CONEXION->query("UPDATE hoteles SET orden = $num WHERE id = '$lista'");

			$num++;
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Subir Imágen    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['imagen'])){
		$position=$_GET['position'];

		$xs=1;
		$sm=1;
		$lg=1;
		$rutaFinal=($position=='main' or $position=='auditorio')?'../img/contenido/'.$seccion.'main/':'../img/contenido/'.$seccion.'/';


		//Obtenemos la extensión de la imagen
		$rutaInicial="../library/upload-file/php/uploads/";
		$imagenName=$_REQUEST['imagen'];
		$i = strrpos($imagenName,'.');
		$l = strlen($imagenName) - $i;
		$ext = strtolower(substr($imagenName,$i+1,$l));

		// Si no es JPG cancelamos
		if ($ext!='jpg' and $ext!='jpeg') {
			$fallo=1;
			$legendFail='<br>El archivo debe ser JPG';
		}

		// Guardar en la base de datos
		if (!isset($fallo)) {
			if(file_exists($rutaInicial.$imagenName)){
				$pic=$id;
				$rutaFinal='../img/contenido/varios/';
				$imgFinal=rand(111111111,999999999).'.'.$ext;
				$CONSULTA = $CONEXION -> query("SELECT * FROM configuracion WHERE id = $position");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				$campo='pic'.$_GET['languaje'];
				if ($row_CONSULTA[$campo]!='') {
					unlink($rutaFinal.$row_CONSULTA[$campo]);
				}
				copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
				$actualizar = $CONEXION->query("UPDATE configuracion SET $campo = '$imgFinal' WHERE id = $position");
				$exito=1;
				$legendSuccess .= "<br>Imagen actualizada";
				unset($fallo);
			}else{
				$fallo=1;
				$legendFail='<br>No se permite refrescar la página.';
			}
		}


		// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		// Borramos las imágenes que estén remanentes en el directorio files
		// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		$filehandle = opendir($rutaInicial); // Abrir archivos
		while ($file = readdir($filehandle)) {
			if ($file != "." && $file != ".." && $file != ".gitignore" && $file != ".htaccess" && $file != "thumbnail") {
				if(file_exists($rutaInicial.$file)){
					//echo $ruta.$file.'<br>';
					unlink($rutaInicial.$file);
				}
			}
		} 
		closedir($filehandle); 
	}

