<?php 
//%%%%%%%%%%%%%%%%%%%%%%%%%%    Nuevo Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['nuevo']) && isset($_POST['tituloes'])){ 
		// Obtenemos los valores enviados
		if (isset($_POST['tituloes']))	{ $tituloes=htmlentities($_POST['tituloes'],ENT_QUOTES);	}else{	$tituloes=''; }
		if (isset($_POST['txtes']))	{ $txtes=str_replace("'", "`", $_POST['txtes']); }else{ $txtes=''; }
		if (isset($_POST['tituloen']))	{ $tituloen=htmlentities($_POST['tituloen'],ENT_QUOTES);	}else{	$tituloen=''; }
		if (isset($_POST['txten']))	{ $txten=str_replace("'", "`", $_POST['txten']); }else{ $txten=''; }
		if (isset($_POST['tituloja']))	{ $tituloja=htmlentities($_POST['tituloja'],ENT_QUOTES);	}else{	$tituloja=''; }
		if (isset($_POST['txtja']))	{ $txtja=str_replace("'", "`", $_POST['txtja']); }else{ $txtja=''; }
		if (isset($_POST['tituloru']))	{ $tituloru=htmlentities($_POST['tituloru'],ENT_QUOTES);	}else{	$tituloru=''; }
		if (isset($_POST['txtru']))	{ $txtru=str_replace("'", "`", $_POST['txtru']); }else{ $txtru=''; }
		if (isset($_POST['titulopt']))	{ $titulopt=htmlentities($_POST['titulopt'],ENT_QUOTES);	}else{	$titulopt=''; }
		if (isset($_POST['txtpt']))	{ $txtpt=str_replace("'", "`", $_POST['txtpt']); }else{ $txtpt=''; }
		if (isset($_POST['tituloit']))	{ $tituloit=htmlentities($_POST['tituloit'],ENT_QUOTES);	}else{	$tituloit=''; }
		if (isset($_POST['txtit']))	{ $txtit=str_replace("'", "`", $_POST['txtit']); }else{ $txtit=''; }

		// Actualizamos la base de datos

		$legendFail.='<br>'.$tituloes;

		$sql = "INSERT INTO gallery (tituloes,txtes,tituloen,txten,tituloja,txtja,tituloru,txtru,titulopt,txtpt,tituloit,txtit,orden)".
			"VALUES ('$tituloes','$txtes','$tituloen','$txten','$tituloja','$txtja','$tituloru','$txtru','$titulopt','$txtpt','$tituloit','$txtit','99')";
		if($insertar = $CONEXION->query($sql)){
			$exito=1;
			$id=$CONEXION->insert_id;
			$legendSuccess .= '<br>Objeto nuevo';
		}else{
			$seccion='contenido';
			$fallo=1;  
			$legendFail .= "<br>No se pudo agregar a la base de datos";
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['editar']) && isset($_REQUEST['tituloes'])){

	    // Obtenemos los valores enviados
		if (isset($_POST['tituloes']))	{ $tituloes=htmlentities(str_replace("'", "`", $_POST['tituloes']),ENT_QUOTES);	}else{	$tituloes=''; }
		if (isset($_POST['txtes']))		{ $txtes=str_replace("'", "`", $_POST['txtes']); }else{ $txtes=''; }
		if (isset($_POST['tituloen']))	{ $tituloen=htmlentities(str_replace("'", "`", $_POST['tituloen']),ENT_QUOTES);	}else{	$tituloen=''; }
		if (isset($_POST['txten']))		{ $txten=str_replace("'", "`", $_POST['txten']); }else{ $txten=''; }
		if (isset($_POST['tituloja']))	{ $tituloja=htmlentities(str_replace("'", "`", $_POST['tituloja']),ENT_QUOTES);	}else{	$tituloja=''; }
		if (isset($_POST['txtja']))		{ $txtja=str_replace("'", "`", $_POST['txtja']); }else{ $txtja=''; }
		if (isset($_POST['tituloru']))	{ $tituloru=htmlentities(str_replace("'", "`", $_POST['tituloru']),ENT_QUOTES);	}else{	$tituloru=''; }
		if (isset($_POST['txtru']))		{ $txtru=str_replace("'", "`", $_POST['txtru']); }else{ $txtru=''; }
		if (isset($_POST['titulopt']))	{ $titulopt=htmlentities(str_replace("'", "`", $_POST['titulopt']),ENT_QUOTES);	}else{	$titulopt=''; }
		if (isset($_POST['txtpt']))		{ $txtpt=str_replace("'", "`", $_POST['txtpt']); }else{ $txtpt=''; }
		if (isset($_POST['tituloit']))	{ $tituloit=htmlentities(str_replace("'", "`", $_POST['tituloit']),ENT_QUOTES);	}else{	$tituloit=''; }
		if (isset($_POST['txtit']))		{ $txtit=str_replace("'", "`", $_POST['txtit']); }else{ $txtit=''; }

		if($actualizar = $CONEXION->query("UPDATE gallery SET tituloes = '$tituloes' WHERE id = $id")){ $exito=1; }else{ $fallo=1; $legendFail .= '<br>tituloes'; }
		if($actualizar = $CONEXION->query("UPDATE gallery SET tituloen = '$tituloen' WHERE id = $id")){ $exito=1; }else{ $fallo=1; $legendFail .= '<br>tituloen'; }
		if($actualizar = $CONEXION->query("UPDATE gallery SET tituloja = '$tituloja' WHERE id = $id")){ $exito=1; }else{ $fallo=1; $legendFail .= '<br>tituloja'; }
		if($actualizar = $CONEXION->query("UPDATE gallery SET tituloru = '$tituloru' WHERE id = $id")){ $exito=1; }else{ $fallo=1; $legendFail .= '<br>tituloru'; }
		if($actualizar = $CONEXION->query("UPDATE gallery SET titulopt = '$titulopt' WHERE id = $id")){ $exito=1; }else{ $fallo=1; $legendFail .= '<br>titulopt'; }
		if($actualizar = $CONEXION->query("UPDATE gallery SET tituloit = '$tituloit' WHERE id = $id")){ $exito=1; }else{ $fallo=1; $legendFail .= '<br>tituloit'; }
		if($actualizar = $CONEXION->query("UPDATE gallery SET txtes = '$txtes' WHERE id = $id")){ $exito=1; }else{ $fallo=1; $legendFail .= '<br>txtes'; }
		if($actualizar = $CONEXION->query("UPDATE gallery SET txten = '$txten' WHERE id = $id")){ $exito=1; }else{ $fallo=1; $legendFail .= '<br>txten'; }
		if($actualizar = $CONEXION->query("UPDATE gallery SET txtja = '$txtja' WHERE id = $id")){ $exito=1; }else{ $fallo=1; $legendFail .= '<br>txtja'; }
		if($actualizar = $CONEXION->query("UPDATE gallery SET txtru = '$txtru' WHERE id = $id")){ $exito=1; }else{ $fallo=1; $legendFail .= '<br>txtru'; }
		if($actualizar = $CONEXION->query("UPDATE gallery SET txtpt = '$txtpt' WHERE id = $id")){ $exito=1; }else{ $fallo=1; $legendFail .= '<br>txtpt'; }
		if($actualizar = $CONEXION->query("UPDATE gallery SET txtit = '$txtit' WHERE id = $id")){ $exito=1; }else{ $fallo=1; $legendFail .= '<br>txtit'; }
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['borrarPod'])){
		$gallery = $CONEXION -> query("SELECT * FROM gallerypic WHERE item = $id");
		while ($row_gallery = $gallery -> fetch_assoc()) {
			$picID=$row_gallery['id'];
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

		if($borrar = $CONEXION->query("DELETE FROM gallery WHERE id = $id")){
			$borrar = $CONEXION->query("DELETE FROM gallerypic WHERE item = $id");
			$exito=1;
			$legendSuccess .= "<br>Producto eliminado";
		}else{
			$legendFail .= "<br>No se pudo borrar de la base de datos";
			$fallo=1;  
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Foto     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['borrarPic'])){
		$picID=$_GET['picID'];
		$subseccion='detalle';
		if($borrar = $CONEXION->query("DELETE FROM gallerypic WHERE id = $picID")){
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

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar Foto     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['editarpic'])){

	    // Obtenemos los valores enviados
		if (isset($_POST['txt1'])){ 	$titulo=$_POST['titulo'];	}else{	$titulo=''; }
		if (isset($_POST['txt'])){ 		$txt=$_POST['txt'];			}else{	$txt=''; }
		if (isset($_POST['url'])){ 		$url=$_POST['url'];			}else{	$url=''; }
		if (isset($_POST['picid'])){ 	$picid=$_POST['picid'];		}else{	$picid=''; }

	    // Sustituimos los caracteres inválidos
		$titulo=htmlentities($titulo, ENT_QUOTES);
		$url=htmlentities($url, ENT_QUOTES);

	    $subseccion='detalle';

		if(
				$actualizar = $CONEXION->query("UPDATE gallerypic SET titulo = '$titulo' WHERE id = $picid")
			and $actualizar = $CONEXION->query("UPDATE gallerypic SET txt  = '$txt'  WHERE id = $picid")
			and $actualizar = $CONEXION->query("UPDATE gallerypic SET url  = '$url'  WHERE id = $picid")
			)
		{
			$exito=1;
		}else{
			$fallo=1;  
			$legendFail .= "<br>No se pudo modificar la base de datos 1";
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Publicar en inicio     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%			
	if (isset($_POST['eninicio'])) {
		include '../../../includes/connection.php';

		$id = $_POST['id'];
		$seccion = $_POST['seccion'];
		$estado = $_POST['estado'];

		if(
			$actualizar = $CONEXION->query("UPDATE $seccion SET inicio = $estado WHERE id = $id")
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

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['eliminarCat'])){

		if($borrar = $CONEXION->query("DELETE FROM gallerycat WHERE id = $cat")){
			$exito=1;
			$legendSuccess .= "<br>Categoria eliminada";

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
						if($imagenID==$cat){
							$pic=$rutaIMG.$file;
							$exito=1;
							unlink($pic);
						}
					}
				}

		}else{
			$fallo=1;
			$legendFail .= "<br>No se pudo borrar de la base de datos";
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar titulo del menu     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['catnamesave'])){
		include '../../../includes/connection.php';

	    // Obtenemos los valores enviados
		if (isset($_POST['es'])){ $es=htmlentities($_POST['es'],ENT_QUOTES);	}else{	$es=''; }
		if (isset($_POST['en'])){ $en=htmlentities($_POST['en'],ENT_QUOTES);	}else{	$en=''; }
		if (isset($_POST['ja'])){ $ja=htmlentities($_POST['ja'],ENT_QUOTES);	}else{	$ja=''; }
		if (isset($_POST['ru'])){ $ru=htmlentities($_POST['ru'],ENT_QUOTES);	}else{	$ru=''; }
		if (isset($_POST['pt'])){ $pt=htmlentities($_POST['pt'],ENT_QUOTES);	}else{	$pt=''; }
		if (isset($_POST['it'])){ $it=htmlentities($_POST['it'],ENT_QUOTES);	}else{	$it=''; }

		if(
				$actualizar = $CONEXION->query("UPDATE traduccion SET es = '$es' WHERE variable = 'menuCiudad'")
			and $actualizar = $CONEXION->query("UPDATE traduccion SET en = '$en' WHERE variable = 'menuCiudad'")
			and $actualizar = $CONEXION->query("UPDATE traduccion SET ja = '$ja' WHERE variable = 'menuCiudad'")
			and $actualizar = $CONEXION->query("UPDATE traduccion SET ru = '$ru' WHERE variable = 'menuCiudad'")
			and $actualizar = $CONEXION->query("UPDATE traduccion SET pt = '$pt' WHERE variable = 'menuCiudad'")
			and $actualizar = $CONEXION->query("UPDATE traduccion SET it = '$it' WHERE variable = 'menuCiudad'")
			)
		{
			echo '
					<span class="uk-notification-message uk-notification-message-success">
						<a href="#" class="uk-notification-close" uk-close></a>
						<span uk-icon=\'icon: check;ratio:2;\'></span> &nbsp; Guardado
					</span>';
		}else{
			echo '
					<span class="uk-notification-message uk-notification-message-danger">
						<a href="#" class="uk-notification-close" uk-close></a>
						<span uk-icon=\'icon: close;ratio:2;\'></span> &nbsp; Ocurrió un error<br>'.$seccion.'
					</span>';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar titulo del menu     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['titnamesave'])){
		include '../../../includes/connection.php';

	    // Obtenemos los valores enviados
		if (isset($_POST['es'])){ $es=htmlentities($_POST['es'],ENT_QUOTES);	}else{	$es=''; }
		if (isset($_POST['en'])){ $en=htmlentities($_POST['en'],ENT_QUOTES);	}else{	$en=''; }
		if (isset($_POST['ja'])){ $ja=htmlentities($_POST['ja'],ENT_QUOTES);	}else{	$ja=''; }
		if (isset($_POST['ru'])){ $ru=htmlentities($_POST['ru'],ENT_QUOTES);	}else{	$ru=''; }
		if (isset($_POST['pt'])){ $pt=htmlentities($_POST['pt'],ENT_QUOTES);	}else{	$pt=''; }
		if (isset($_POST['it'])){ $it=htmlentities($_POST['it'],ENT_QUOTES);	}else{	$it=''; }

		if(
				$actualizar = $CONEXION->query("UPDATE traduccion SET es = '$es' WHERE variable = 'tituloCiudad'")
			and $actualizar = $CONEXION->query("UPDATE traduccion SET en = '$en' WHERE variable = 'tituloCiudad'")
			and $actualizar = $CONEXION->query("UPDATE traduccion SET ja = '$ja' WHERE variable = 'tituloCiudad'")
			and $actualizar = $CONEXION->query("UPDATE traduccion SET ru = '$ru' WHERE variable = 'tituloCiudad'")
			and $actualizar = $CONEXION->query("UPDATE traduccion SET pt = '$pt' WHERE variable = 'tituloCiudad'")
			and $actualizar = $CONEXION->query("UPDATE traduccion SET it = '$it' WHERE variable = 'tituloCiudad'")
			)
		{
			echo '
					<span class="uk-notification-message uk-notification-message-success">
						<a href="#" class="uk-notification-close" uk-close></a>
						<span uk-icon=\'icon: check;ratio:2;\'></span> &nbsp; Guardado
					</span>';
		}else{
			echo '
					<span class="uk-notification-message uk-notification-message-danger">
						<a href="#" class="uk-notification-close" uk-close></a>
						<span uk-icon=\'icon: close;ratio:2;\'></span> &nbsp; Ocurrió un error<br>'.$seccion.'
					</span>';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Ordenar Galería     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%			
	if (isset($_POST['list1'])) {
		include '../../../includes/connection.php';

		$list = $_POST['list1'];
		$num=1;

		foreach ($list as $lista) {
			$actualizar = $CONEXION->query("UPDATE gallery SET orden = $num WHERE id = '$lista'");

			$num++;
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Ordenar Fotos     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%			
	if (isset($_POST['list2'])) {
		include '../../../includes/connection.php';

		$list = $_POST['list2'];
		$num=1;

		foreach ($list as $lista) {
			$actualizar = $CONEXION->query("UPDATE gallerypic SET orden = $num WHERE id = '$lista'");

			$num++;
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Subir Imágen     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['imagen'])){

		$xs=0;
		$sm=0;
		$med=0;
		$og=0;
		$nat300=0;
		$nat1000=0;
		$nat2000=0;
		$Otra=0;
		$size500x600=0;
		$rutaFinal="../img/contenido/gallery/";
		$nat300=1;
		$nat1000=1;

		// Extra Small
		$anchoXS=100;
		$altoXS =100;
		// Small
		$anchoSM=250;
		$altoSM =250;
		// Mediana
		$anchoMED=400;
		$altoMED =400;
		// OG
		$anchoOG=1000;
		$altoOG =1000;
		// Otra
		$anchoOtra=994;
		$altoOtra =540;
		// 
		$anchosize500x600=500;
		$altosize500x600 =600;

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
				$sql = "INSERT INTO gallerypic (item,orden,url) VALUES ($id,99,'')";
				$insertar = $CONEXION->query($sql);
				$pic = $CONEXION->insert_id;
			}else{
				$fallo=1;
				$legendFail='<br>No se permite refrescar la página.';
			}
		}

		if (!isset($fallo)) {

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
				if ($ext=='jpg' or $ext=='jpeg') $original = imagecreatefromjpeg($imgAux);
				if ($ext=='png') $new_pic = imagecreatefrompng($imgAux);
				if ($ext=='gif') $new_pic = imagecreatefromgif($imgAux);

				// Tomamos las dimensiones de la imagen original
				$ancho  = imagesx($original);
				$alto   = imagesy($original);


				if ($originalPic==1) {
					//  Imagen nat300
					$newName=$pic."-orig.jpg";
					$anchoNuevo = $ancho;
					$altoNuevo  = $alto;

					// Creamos la imagen
					$imagenAux = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
					// Copiamos el contenido de la original para pegarlo en el archivo nuevo
					imagecopyresampled($imagenAux,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
					// Pegamos el contenido de la imagen
					if(imagejpeg($imagenAux,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
					}
				}

				if ($xs==1) {
					// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					//  Imagen Pequeña
					// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					$newName=$pic."-xs.jpg";

					$anchoNew=$anchoXS;
					$altoNew =$altoXS;

					// Proporcionalmente, la imagen es más ancha que la de destino
					if($ancho/$alto>$anchoNew/$altoNew){
						// Ancho proporcional
						$anchoProporcional=$ancho/$alto*$altoNew;
						// Excedente 
						$excedente=$anchoProporcional-$anchoNew;
						// Posición inicial de la coordenada x
						$xinicial= -$excedente/2;
					}else{
						// Alto proporcional
						$altoProporcional=$alto/$ancho*$anchoNew;
						// Excedente
						$excedente=$altoProporcional-$altoNew;
						// Posición inicial de la coordenada y
						$yinicial= -$excedente/2;
					}

					// Copiamos el contenido de la original para pegarlo en el archivo New
					$New = imagecreatetruecolor($anchoNew,$altoNew); 

					if(isset($xinicial)){
						imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
					}else{
						imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
					}

					// Pegamos el contenido de la imagen
					if(imagejpeg($New,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
						//$legendSuccess .= "<br>Imagen pequeña agregada";
					}
				}

				if ($sm==1) {
					// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					//  Imagen Pequeña
					// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					$newName=$pic."-sm.jpg";

					$anchoNew=$anchoSM;
					$altoNew =$altoSM;

					// Proporcionalmente, la imagen es más ancha que la de destino
					if($ancho/$alto>$anchoNew/$altoNew){
						// Ancho proporcional
						$anchoProporcional=$ancho/$alto*$altoNew;
						// Excedente 
						$excedente=$anchoProporcional-$anchoNew;
						// Posición inicial de la coordenada x
						$xinicial= -$excedente/2;
					}else{
						// Alto proporcional
						$altoProporcional=$alto/$ancho*$anchoNew;
						// Excedente
						$excedente=$altoProporcional-$altoNew;
						// Posición inicial de la coordenada y
						$yinicial= -$excedente/2;
					}

					// Copiamos el contenido de la original para pegarlo en el archivo New
					$New = imagecreatetruecolor($anchoNew,$altoNew); 

					if(isset($xinicial)){
						imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
					}else{
						imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
					}

					// Pegamos el contenido de la imagen
					if(imagejpeg($New,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
						//$legendSuccess .= "<br>Imagen pequeña agregada";
					}
				}

				if ($med==1) {
					// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					//  Imagen Mediana
					// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					$newName=$pic."-med.jpg";

					$anchoNew=$anchoMED;
					$altoNew =$altoMED;

					// Proporcionalmente, la imagen es más ancha que la de destino
					if($ancho/$alto>$anchoNew/$altoNew){
						// Ancho proporcional
						$anchoProporcional=$ancho/$alto*$altoNew;
						// Excedente 
						$excedente=$anchoProporcional-$anchoNew;
						// Posición inicial de la coordenada x
						$xinicial= -$excedente/2;
					}else{
						// Alto proporcional
						$altoProporcional=$alto/$ancho*$anchoNew;
						// Excedente
						$excedente=$altoProporcional-$altoNew;
						// Posición inicial de la coordenada y
						$yinicial= -$excedente/2;
					}

					// Copiamos el contenido de la original para pegarlo en el archivo New
					$New = imagecreatetruecolor($anchoNew,$altoNew); 

					if(isset($xinicial)){
						imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
					}else{
						imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
					}

					// Pegamos el contenido de la imagen
					if(imagejpeg($New,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
						//$legendSuccess .= "<br>Imagen pequeña agregada";
					}
				}

				if ($og==1) {
					// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					//  Imagen OG
					// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					$newName=$pic."-og.jpg";

					$anchoNew=$anchoOG;
					$altoNew =$altoOG;

					// Proporcionalmente, la imagen es más ancha que la de destino
					if($ancho/$alto>$anchoNew/$altoNew){
						// Ancho proporcional
						$anchoProporcional=$ancho/$alto*$altoNew;
						// Excedente 
						$excedente=$anchoProporcional-$anchoNew;
						// Posición inicial de la coordenada x
						$xinicial= -$excedente/2;
					}else{
						// Alto proporcional
						$altoProporcional=$alto/$ancho*$anchoNew;
						// Excedente
						$excedente=$altoProporcional-$altoNew;
						// Posición inicial de la coordenada y
						$yinicial= -$excedente/2;
					}

					// Copiamos el contenido de la original para pegarlo en el archivo New
					$New = imagecreatetruecolor($anchoNew,$altoNew); 

					if(isset($xinicial)){
						imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
					}else{
						imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
					}

					// Pegamos el contenido de la imagen
					if(imagejpeg($New,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
						//$legendSuccess .= "<br>Imagen OG agregada";
					}
				}

				if ($nat300==1) {
					//  Imagen nat300
					$newName=$pic."-nat300.jpg";
					$anchoNuevo = 500;
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

				if ($nat1000==1) {
					//  Imagen nat1000
					$newName=$pic."-nat1000.jpg";
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

				if ($nat2000==1) {
					//  Imagen nat2000
					$newName=$pic."-nat2000.jpg";
					if ($ancho>$alto) {
						$anchoNuevo = 2000;
						$altoNuevo  = $anchoNuevo*$alto/$ancho;
					}else{
						$altoNuevo  = 2000;
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

				if ($Otra==1) {
					//  Imagen Otra
					$newName=$pic."-otra.jpg";
					$anchoNew=$anchoOtra;
					$altoNew =$altoOtra;
					$dst_x=0;
					$dst_y=0;
					$src_x=0;
					$src_y=0;
					$dst_w=$ancho;
					$dst_h=$alto;
					$src_w=$ancho;
					$src_h=$alto;

					// Proporcionalmente, la imagen es más ancha que la de destino
					if($ancho/$alto>$anchoNew/$altoNew){
						// Ancho proporcional
						$anchoProporcional=$ancho/$alto*$altoNew;
						// Corregimos el ancho
						$dst_w=$anchoProporcional;
						// Corregimos el ancho
						$dst_h=$altoNew;
						// Excedente 
						$excedente=$anchoProporcional-$anchoNew;
						// Posición inicial de la coordenada x
						$src_x= $excedente/2;
						//$legendSuccess.='<br>Opt 2';
					}else{
						// Ancho proporcional
						$altoProporcional=$alto/$ancho*$anchoNew;
						// Corregimos el alto
						$dst_h=$altoProporcional;
						// Corregimos el ancho
						$dst_w=$anchoNew;
						// Excedente
						$excedente=$altoProporcional-$altoNew;
						// Posición inicial de la coordenada y
						$src_y= $excedente/2;
						//$legendSuccess.='<br>Opt 2';
						//$legendSuccess.='<br>Alto Original: '.$alto;
						//$legendSuccess.='<br>Alto Nuevo: '.$altoNew;
						//$legendSuccess.='<br>Alto Proporcional: '.$altoProporcional;
						//$legendSuccess.='<br>Excedente: '.$excedente;
						//$legendSuccess.='<br>Src Y: '.$src_y;
					}

					// Copiamos el contenido de la original para pegarlo en el archivo New
					$New = imagecreatetruecolor($anchoNew,$altoNew); 

					imagecopyresampled($New,$original,$dst_x,$dst_y,$src_x,$src_y,$dst_w,$dst_h,$src_w,$src_h);

					// Pegamos el contenido de la imagen
					if(imagejpeg($New,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
						$exito=1;
						//$legendSuccess .= "<br>Imagen Otra agregada";
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



