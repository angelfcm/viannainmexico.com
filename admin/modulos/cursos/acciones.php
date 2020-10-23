<?php
	$seccion='cursos';
	$seccionpic=$seccion.'pic';
	$seccionmain=$seccion.'main';

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Nuevo Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['nuevo']) AND isset($_POST['tituloes'])){ 
		// Obtenemos los valores enviados
		if (isset($_POST['tituloes'])){ $tituloes=htmlentities($_POST['tituloes'], ENT_QUOTES); }else{ $tituloes=''; $fallo=1; }
		if (isset($_POST['tituloen'])){ $tituloen=htmlentities($_POST['tituloen'], ENT_QUOTES); }else{ $tituloen=''; $fallo=1; }
		if (isset($_POST['tituloja'])){ $tituloja=htmlentities($_POST['tituloja'], ENT_QUOTES); }else{ $tituloja=''; $fallo=1; }
		if (isset($_POST['tituloru'])){ $tituloru=htmlentities($_POST['tituloru'], ENT_QUOTES); }else{ $tituloru=''; $fallo=1; }
		if (isset($_POST['tituloit'])){ $tituloit=htmlentities($_POST['tituloit'], ENT_QUOTES); }else{ $tituloit=''; $fallo=1; }
		if (isset($_POST['titulopt'])){ $titulopt=htmlentities($_POST['titulopt'], ENT_QUOTES); }else{ $titulopt=''; $fallo=1; }
		// Actualizamos la base de datos
		$sql = "INSERT INTO $seccion (tituloes,tituloen,tituloru,tituloja,titulopt,tituloit,orden)".
				"VALUES ('$tituloes','$tituloen','$tituloru','$tituloja','$titulopt','$tituloit',100)";
		if($insertar = $CONEXION->query($sql)){
			$exito=1;
			$legendSuccess .= "<br>Curso nuevo";
			$subseccion = 'detalle';
			$id=$CONEXION->insert_id;
		}else{
			$fallo=1;  
			$legendFail .= "<br>No se pudo agregar a la base de datos";
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['editar']) && isset($_POST['languaje'])){

	    // Obtenemos los valores enviados
		if (isset($_POST['languaje'])){ $languaje=htmlentities($_POST['languaje'], ENT_QUOTES); }else{ $languaje=''; $fallo=1; $legendFail='languaje'; }
		if (isset($_POST['titulo'])){ $titulo=htmlentities($_POST['titulo'], ENT_QUOTES); }else{ $titulo=''; $fallo=1; $legendFail='titulo'; }
		if (isset($_POST['fecha'])){ $fecha=htmlentities($_POST['fecha'], ENT_QUOTES); }else{ $fecha=''; $fallo=1; $legendFail='fecha'; }
		if (isset($_POST['horario'])){ $horario=htmlentities($_POST['horario'], ENT_QUOTES); }else{ $horario=''; $fallo=1; $legendFail='horario'; }
		if (isset($_POST['lugar'])){ $lugar=htmlentities($_POST['lugar'], ENT_QUOTES); }else{ $lugar=''; $fallo=1; $legendFail='lugar'; }
		if (isset($_POST['prerequisito'])){ $prerequisito=htmlentities($_POST['prerequisito'], ENT_QUOTES); }else{ $prerequisito=''; $fallo=1; $legendFail='prerequisito'; }
		if (isset($_POST['pagostexto'])){ $pagostexto=htmlentities($_POST['pagostexto'], ENT_QUOTES); }else{ $pagostexto=''; $fallo=1; $legendFail='pagostexto'; }
		if (isset($_POST['precio'])){ $precio=$_POST['precio']; }else{ $precio=''; $fallo=1; $legendFail='precio'; }
		if (isset($_POST['preciousd'])){ $preciousd=$_POST['preciousd']; }else{ $preciousd=''; $fallo=1; $legendFail='preciousd'; }
		if (isset($_POST['precio_traduccion'])){ $precio_traduccion=$_POST['precio_traduccion']; }else{ $precio_traduccion=''; $fallo=1; $legendFail='precio_traduccion'; }
		if (isset($_POST['precio_traduccion_usd'])){ $precio_traduccion_usd=$_POST['precio_traduccion_usd']; }else{ $precio_traduccion_usd=''; $fallo=1; $legendFail='precio_traduccion_usd'; }
		if (isset($_POST['titulo_gafet'])){ $titulo_gafet=htmlentities($_POST['titulo_gafet'], ENT_QUOTES); }else{ $titulo_gafet=''; $fallo=1; $legendFail='titulo_gafet'; }

		$campos=array(
			'titulo'.$languaje=>$titulo,
			'fecha'.$languaje=>$fecha,
			'horario'.$languaje=>$horario,
			'lugar'.$languaje=>$lugar,
			'prerequisito'.$languaje=>$prerequisito,
			'pagostexto'.$languaje=>$pagostexto
			);
		foreach ($campos as $key => $value) {
			$actualizar = $CONEXION->query("UPDATE $seccion SET $key = '$value' WHERE id = $id");
		}
		$actualizar = $CONEXION->query("UPDATE $seccion SET 
				precio = '$precio',
				preciousd = '$preciousd',
				precio_traduccion = '$precio_traduccion',
				precio_traduccion_usd = '$precio_traduccion_usd',
				titulo_gafet = '$titulo_gafet'
			WHERE id = $id");
		$exito=1;
		$legendSuccess.='<br>Curso editado';
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['borrarPod'])){
		$consulta= $CONEXION -> query("SELECT * FROM $seccionpic WHERE producto = $id");
		while ($rowConsulta = $consulta-> fetch_assoc()) {
			$picID=$rowConsulta['id'];
			// Borramos el archivo de imagen
			$rutaIMG="../img/contenido/".$seccion."/";
			$filehandle = opendir($rutaIMG); // Abrir archivos
			while ($file = readdir($filehandle)) {
				if ($file != "." && $file != "..") {
					// Id de la imagen
					if (strpos($file,'-')===false) {
						$imagenID = strstr($file,'.',TRUE);
					}else{
						$imagenID = strstr($file,'-',TRUE);
					}
					// Comprobamos que sean iguales
					if($imagenID==$picID){
						$pic=$rutaIMG.$file;
						$exito=1;
						unlink($pic);
					}
				}
			}
	    }

		if($borrar = $CONEXION->query("DELETE FROM $seccion WHERE id = $id")){
			$borrar = $CONEXION->query("DELETE FROM $seccionpic WHERE producto = $id");
			$borrar = $CONEXION->query("DELETE FROM cursoasientos WHERE curso = $id");
			$exito=1;
			$legendSuccess .= "<br>Curso eliminado";
		}else{
			$legendFail .= "<br>No se pudo borrar de la base de datos";
			$fallo=1;  
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_GET['vaciar'])){
		if($borrar = $CONEXION->query("DELETE FROM cursoasientos WHERE curso = $id")){
			$exito=1;
			$legendSuccess .= "<br>Curso reiniciado";
		}else{
			$legendFail .= "<br>No se pudo borrar de la base de datos";
			$fallo=1;  
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar Foto     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['editarpic'])){

	    // Obtenemos los valores enviados
		if (isset($_POST['titulo'])){ 	$titulo=$_POST['titulo'];	}else{	$titulo=''; }
		if (isset($_POST['title'])){ 	$title=$_POST['title'];	}else{	$title=''; }
		if (isset($_POST['picid'])){ 	$picid=$_POST['picid'];		}else{	$picid=''; }

	    // Sustituimos los caracteres inválidos
		$titulo=htmlentities($titulo, ENT_QUOTES);

	    $subseccion='detalle';

		if(
				$actualizar = $CONEXION->query("UPDATE $seccionpic SET titulo = '$titulo' WHERE id = $picid")
			and	$actualizar = $CONEXION->query("UPDATE $seccionpic SET title = '$title' WHERE id = $picid")
			)
		{
			$exito=1;
			$legendSuccess.='<br>Editar título de foto';
		}else{
			$fallo=1;  
			$legendFail .= "<br>No se pudo modificar la base de datos";
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Foto     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['borrarPic'])){
		$picID=$_GET['picID'];
		if($borrar = $CONEXION->query("DELETE FROM $seccionpic WHERE id = $picID")){
			// Borramos el archivo de imagen
			$rutaIMG="../img/contenido/".$seccion."/";
			$filehandle = opendir($rutaIMG); // Abrir archivos
			while ($file = readdir($filehandle)) {
				if ($file != "." && $file != "..") {
					// Id de la imagen
					if (strpos($file,'-')===false) {
						$imagenID = strstr($file,'.',TRUE);
					}else{
						$imagenID = strstr($file,'-',TRUE);
					}
					// Comprobamos que sean iguales
					if($imagenID==$picID){
						$pic=$rutaIMG.$file;
						$exito=1;
						unlink($pic);
					}
				}
			}
		}
	}

// %%%%%%%%%	Bloquear asiento %%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_GET['bloquear'])) {
		$curso = $_GET['id'];
		$asiento = strtoupper($_GET['asiento']);

		$CONSULTA= $CONEXION -> query("SELECT * FROM cursoasientos WHERE asiento = '$asiento' AND curso = $curso");
		$numCONSULTA = $CONSULTA ->num_rows;
		if ($numCONSULTA==0) {
			$sql = "INSERT INTO cursoasientos (curso,usuario,asiento)".
				"VALUES ($curso,0,'$asiento')";
			if ($insertar = $CONEXION->query($sql)) {
				$exito='success';
				$legendSuccess.="<br>Asiento bloqueado";
			}else{
				$fallo='danger';  
				$legendFail.="<br>No se pudo bloquear el asiento ";
			}
		}else{
			$fallo='danger';  
			$legendFail.="<br>No se permite recargar la página";
		}
	}

// %%%%%%%%%	DES Bloquear asiento %%%%%%%%%%%%%%%%%%%
	if (isset($_GET['habilitar'])) {
		$curso = $_GET['id'];
		$asiento = strtoupper($_GET['asiento']);

		$CONSULTA= $CONEXION -> query("SELECT * FROM cursoasientos WHERE asiento = '$asiento' AND curso = $curso");
		$numCONSULTA = $CONSULTA ->num_rows;
		if ($numCONSULTA==1) {
			if ($borrar = $CONEXION->query("DELETE FROM cursoasientos WHERE asiento = '$asiento' AND curso = $curso")) {
				$exito='success';
				$legendSuccess.="<br>Asiento habilitado";
			}else{
				$fallo='danger';  
				$legendFail.="<br>No se pudo habilitar el asiento ";
			}
		}else{
			$fallo='danger';  
			$legendFail.="<br>No se permite recargar la página";
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Nuevo Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['auditorionew'])){ 
		// Obtenemos los valores enviados
		if (isset($_POST['filas'])){ $filas=htmlentities($_POST['filas'], ENT_QUOTES); }else{ $filas=''; $fallo=1; $legendFail.='<br>falta filas'; }
		if (isset($_POST['columnas'])){ $columnas=htmlentities($_POST['columnas'], ENT_QUOTES); }else{ $columnas=''; $fallo=1; $legendFail.='<br>falta columnas'; }

		if (!isset($fallo)) {
			// Actualizamos la base de datos
			if(
					$actualizar = $CONEXION->query("UPDATE $seccion SET asientoscol = '$columnas' WHERE id = $id")
				AND	$actualizar = $CONEXION->query("UPDATE $seccion SET asientosrow = '$filas' WHERE id = $id")
				){
				$exito=1;
				$legendSuccess .= "<br>Auditorio definido";
				$subseccion = 'auditorio';
			}else{
				$fallo=1;  
				$legendFail .= "<br>No se pudo agregar a la base de datos";
			}
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Publicar en destacado     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['endestacado'])) {
		include '../../../includes/connection.php';

		$id = $_POST['id'];
		$seccion = $_POST['seccion'];
		$estado = $_POST['estado'];

		if(
			$actualizar = $CONEXION->query("UPDATE $seccion SET destacado = $estado WHERE id = $id")
			){
			echo '
					<span class="uk-notification-message uk-notification-message-success">
						<a href="#" class="uk-notification-close" uk-close></a>
						<span uk-icon=\'icon: check;ratio:2;\'></span> &nbsp; Guardado
					</span>';
		}else{
			echo '
					<span class="uk-notification-message uk-notification-message-danger">
						<a href="#" class="uk-notification-close" uk-close></a>
						<span uk-icon=\'icon: close;ratio:2;\'></span> &nbsp; Ocurrió un error
					</span>';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Ordenar Artículos    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['list1'])) {
		include '../../../includes/connection.php';

		$list = $_POST['list1'];
		$num=1;

		foreach ($list as $lista) {
			$actualizar = $CONEXION->query("UPDATE $seccion SET orden = $num WHERE id = '$lista'");

			$num++;
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Ordenar Fotos     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['list2'])) {
		include '../../../includes/connection.php';

		$list = $_POST['list2'];
		$num=1;

		foreach ($list as $lista) {
			$actualizar = $CONEXION->query("UPDATE $seccionpic SET orden = $num WHERE id = '$lista'");

			$num++;
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Guardar valor de idioma    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['editavalor'])) {

		include '../../../includes/connection.php';
		include '../../../includes/config.php';

		$id    = $_POST['id'];
		$col  = $_POST['col'];
		$valor = htmlentities($_POST['valor'], ENT_QUOTES);

		if ($actualizar = $CONEXION->query("UPDATE cursoasientos SET $col = '$valor' WHERE id = $id")) {
			echo '<span class="uk-text-success"><span uk-icon="icon: check"></span> Guardado</span>';
		}else{
			echo '<span class="uk-text-danger"><span uk-icon="icon: close"></span> No se pudo guardar</span>';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Subir Imágen     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
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
				if ($position=='gallery') {
					$sql = "INSERT INTO $seccionpic (orden) VALUES (99)";
					$insertar = $CONEXION->query($sql);
					$pic=$CONEXION->insert_id;
					$crear=1;
				}elseif($position=='categoria'){
					$rutaFinal='../img/contenido/'.$seccion.'cat/';
					$imgFinal=rand(111111111,999999999).'.'.$ext;
					$CONSULTA = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
					$row_CONSULTA = $CONSULTA -> fetch_assoc();
					$campo='pic'.$_GET['languaje'];
					if ($row_CONSULTA[$campo]!='' AND file_exists($rutaFinal.$row_CONSULTA[$campo])) {
						unlink($rutaFinal.$row_CONSULTA[$campo]);
					}
					copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
					$actualizar = $CONEXION->query("UPDATE configuracion SET $campo = '$imgFinal' WHERE id = 1");
					$crear=0;
				}elseif($position=='main'){
					if(file_exists($rutaFinal.$imagenName)){
						$CONSULTA = $CONEXION -> query("SELECT * FROM $seccion WHERE imagen = '$imagenName' AND id != $id");
						$numPics=$CONSULTA->num_rows;
						$imgFinal=rand(111111111,999999999).'.'.$ext;
						if ($numPics==0) {
							unlink($rutaFinal.$imagenName);
						}
					}else{
						$imgFinal=$imagenName;
					}
					$CONSULTA = $CONEXION -> query("SELECT * FROM $seccion WHERE id = $id");
					$row_CONSULTA = $CONSULTA -> fetch_assoc();
					if ($row_CONSULTA['imagen']!='' AND file_exists($rutaFinal.$row_CONSULTA['imagen'])) {
						unlink($rutaFinal.$row_CONSULTA['imagen']);
					}
					copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
					$actualizar = $CONEXION->query("UPDATE $seccion SET imagen = '$imgFinal' WHERE id = $id");
					$crear=0;
				}elseif($position=='auditorio'){
					if(file_exists($rutaFinal.$imagenName)){
						$CONSULTA = $CONEXION -> query("SELECT * FROM $seccion WHERE imagen1 = '$imagenName' AND id != $id");
						$numPics=$CONSULTA->num_rows;
						$imgFinal=rand(111111111,999999999).'.'.$ext;
						if ($numPics==0) {
							unlink($rutaFinal.$imagenName);
						}
					}else{
						$imgFinal=$imagenName;
					}
					$CONSULTA = $CONEXION -> query("SELECT * FROM $seccion WHERE id = $id");
					$row_CONSULTA = $CONSULTA -> fetch_assoc();
					if ($row_CONSULTA['imagen1']!='' AND file_exists($rutaFinal.$row_CONSULTA['imagen1'])) {
						unlink($rutaFinal.$row_CONSULTA['imagen1']);
					}
					copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
					$actualizar = $CONEXION->query("UPDATE $seccion SET imagen1 = '$imgFinal' WHERE id = $id");
					$crear=0;
				}
			}else{
				$fallo=1;
				$legendFail='<br>No se permite refrescar la página.';
			}
		}

		// crear las diferentes versiones de la imagen 
		if (!isset($fallo) and $position=='gallery') {

			$imagenName=$_REQUEST['imagen'];

			$imgAux=$rutaFinal.$pic."-aux.jpg";

			//check extension of the file
			$i = strrpos($imagenName,'.');
			$l = strlen($imagenName) - $i;
			$ext = strtolower(substr($imagenName,$i+1,$l));

			// Comprobamos que el archivo realmente se haya subido
			if(file_exists($rutaInicial.$imagenName)){

				// Lo movemos al directorio final
				copy($rutaInicial.$imagenName, $imgAux);    

				// Leer el archivo para hacer la nueva imagen
				$original = imagecreatefromjpeg($imgAux);

				// Tomamos las dimensiones de la imagen original
				$ancho  = imagesx($original);
				$alto   = imagesy($original);


				if ($xs==1) {
					//  Imagen xs
					$newName=$pic."-xs.jpg";
					$anchoNuevo = 80;
					$altoNuevo  = $anchoNuevo*$alto/$ancho;

					// Creamos la imagen
					$imagenAux = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
					// Copiamos el contenido de la original para pegarlo en el archivo nuevo
					imagecopyresampled($imagenAux,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
					// Pegamos el contenido de la imagen
					if(imagejpeg($imagenAux,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
					}
				}

				if ($sm==1) {
					//  Imagen sm
					$newName=$pic."-sm.jpg";
					$anchoNuevo = 300;
					$altoNuevo  = $anchoNuevo*$alto/$ancho;

					// Creamos la imagen
					$imagenAux = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
					// Copiamos el contenido de la original para pegarlo en el archivo nuevo
					imagecopyresampled($imagenAux,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
					// Pegamos el contenido de la imagen
					if(imagejpeg($imagenAux,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
					}
				}

				if ($lg==1) {
					//  Imagen lg
					$newName=$pic."-lg.jpg";
					if ($ancho>$alto) {
						$anchoNuevo = 1200;
						$altoNuevo  = $anchoNuevo*$alto/$ancho;
					}else{
						$altoNuevo  = 1200;
						$anchoNuevo = $altoNuevo*$ancho/$alto;
					}

					// Creamos la imagen
					$imagenAux = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
					// Copiamos el contenido de la original para pegarlo en el archivo nuevo
					imagecopyresampled($imagenAux,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
					// Pegamos el contenido de la imagen
					if(imagejpeg($imagenAux,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
					}
				}

				if ($originalPic==0) {
					unlink($imgAux);
				}else{
					rename ($imgAux, $rutaFinal.$pic."-orig.jpg");
				}

				if($exito=1){
					$legendSuccess .= "<br>Imagen actualizada";
				}
			}
		}else{
			$fallo=1;
			$legendFail.= '<br>No pudo subirse la imagen';
		}

		if($position=='main' or $position=='categoria' or $position=='auditorio'){
			$exito=1;
			$legendSuccess .= "<br>Imagen actualizada";
			unset($fallo);
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

