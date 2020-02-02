<?php 
$fecha=date('Y-m-d');
// %%%%%%%%%	Nuevo Usuario %%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_POST['new-user'])){
		if(isset($_POST['nombre']) and $_POST['nombre']!='' ){ $nombre=htmlentities($_POST['nombre'],ENT_QUOTES); }else{ $nombre=false; $fallo=1; $legendFail.='<br>Falta nombre'; }
		$apellido=(isset($_POST['apellido']))?htmlentities($_POST['apellido'],ENT_QUOTES):'';
		$email=(isset($_POST['email']))?htmlentities($_POST['email'],ENT_QUOTES):'';
		$gafet=(isset($_POST['gafet']))?htmlentities($_POST['gafet'],ENT_QUOTES):'';
		$nacimiento=(isset($_POST['nacimiento']))?htmlentities($_POST['nacimiento'],ENT_QUOTES):'';
		$telefono=(isset($_POST['telefono']))?htmlentities($_POST['telefono'],ENT_QUOTES):'';
		$emergencia=(isset($_POST['emergencia']))?htmlentities($_POST['emergencia'],ENT_QUOTES):'';
		$direccion=(isset($_POST['direccion']))?htmlentities($_POST['direccion'],ENT_QUOTES):'';
		$pais=(isset($_POST['pais']))?htmlentities($_POST['pais'],ENT_QUOTES):'';
		$invita=(isset($_POST['invita']))?htmlentities($_POST['invita'],ENT_QUOTES):'';
		$traductor=(isset($_POST['traductor']))?htmlentities($_POST['traductor'],ENT_QUOTES):'';
		$alta=date('Y-m-d');

		$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE email = '$email'");
		$numRows = $USER ->num_rows;
		if ($numRows==0) {
			$sql = "INSERT INTO usuarios (alta,nombre,apellido,email,gafet,nacimiento,telefono,emergencia,direccion,pais,invita,traductor)".
				"VALUES ('$alta','$nombre','$apellido','$email','$gafet','$nacimiento','$telefono','$emergencia','$direccion','$pais','$invita','$traductor')";
			if($insertar = $CONEXION->query($sql))
			{
				$exito='success';
				$legendSuccess.="<br>Usuario agregado";
			}else{
				$fallo='danger';  
				$legendFail.="<br>No se pudo agregar el usuario ";
			}
		}else{
			$fallo='danger';  
			$legendFail.="<br>El email ya existe";
			$row_USER = $USER -> fetch_assoc();
			$id=$row_USER['id'];
		}
	}

// %%%%%%%%%	Editar Usuario %%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['edit-user'])){
		if(isset($_POST['nombre']) and $_POST['nombre']!='' ){ $nombre=htmlentities($_POST['nombre'],ENT_QUOTES); }else{ $nombre=false; $fallo=1; $legendFail.='<br>Falta nombre'; }
		$apellido=(isset($_POST['apellido']))?htmlentities($_POST['apellido'],ENT_QUOTES):'';
		$email=(isset($_POST['email']))?htmlentities($_POST['email'],ENT_QUOTES):'';
		$gafet=(isset($_POST['gafet']))?htmlentities($_POST['gafet'],ENT_QUOTES):'';
		$nacimiento=(isset($_POST['nacimiento']))?htmlentities($_POST['nacimiento'],ENT_QUOTES):'';
		$telefono=(isset($_POST['telefono']))?htmlentities($_POST['telefono'],ENT_QUOTES):'';
		$emergencia=(isset($_POST['emergencia']))?htmlentities($_POST['emergencia'],ENT_QUOTES):'';
		$direccion=(isset($_POST['direccion']))?htmlentities($_POST['direccion'],ENT_QUOTES):'';
		$pais=(isset($_POST['pais']))?htmlentities($_POST['pais'],ENT_QUOTES):'';
		$invita=(isset($_POST['invita']))?htmlentities($_POST['invita'],ENT_QUOTES):'';
		$traductor=(isset($_POST['traductor']))?htmlentities($_POST['traductor'],ENT_QUOTES):'';
		if(!isset($fallo)){
			if(
				$actualizar = $CONEXION->query("UPDATE usuarios SET nombre = '$nombre' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET apellido = '$apellido' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET email = '$email' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET gafet = '$gafet' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET nacimiento = '$nacimiento' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET telefono = '$telefono' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET emergencia = '$emergencia' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET direccion = '$direccion' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET pais = '$pais' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE usuarios SET invita = '$invita' WHERE id = $id")
				)
			{
				$exito='success';
				$legendSuccess.="<br>Usuario editado";
			}else{
				$fallo='danger';  
				$legendFail.="<br>No se pudo modificar el Usuario";
			}
		}else{
			$fallo='danger';  
			$legendFail.="<br>Contraseñas no coinciden";
		}
	}

// %%%%%%%%%	Eliminar Usuario %%%%%%%%%%%%%%%%%%%%%%
	if(isset($_REQUEST['borrarUser'])){
		if($borrar = $CONEXION->query("DELETE FROM usuarios WHERE id = $id")){
			$borrar = $CONEXION->query("DELETE FROM cursoasientos WHERE usuario = $id");
			$exito='success';
			$legendSuccess.="<br>Usuario eliminado";
			$subseccion='contenido';
		}else{
			$fallo='danger';  
			$legendFail.="<br>No se pudo eliminar el Usuario";
		}
	} 

// %%%%%%%%%	Actualizar estatus %%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['estatusupdate'])) {
		include '../../../includes/connection.php';

		$id = $_POST['id'];
		$estatus = $_POST['estatus'];
		$uid = $_COOKIE['uid'];
		$user = $CONEXION->query("SELECT * FROM user WHERE id = $uid")->fetch_assoc();
		$userName = $user['user'];
		$estatus_details = addslashes("Marcado por $userName (" . date("d-M-y h:i a") . ')');
		if (!$estatus)
			$estatus_details = addslashes("Desmarcado por $userName (" . date("d-M-y h:ia") . ')');

		if($actualizar = $CONEXION->query("UPDATE cursoasientos SET estatus = $estatus, estatus_details = '$estatus_details' WHERE id = $id")){
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

// %%%%%%%%%	Asignar asiento %%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_GET['asignar'])) {
		$curso = $_GET['curso'];
		$asiento = strtoupper($_GET['asiento']);

		$CONSULTA = $CONEXION -> query("SELECT * FROM cursoasientos WHERE usuario = $id AND curso = $curso");
		$numRows = $CONSULTA ->num_rows;
		if ($numRows!=0) {
			while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
				$thisId=$row_CONSULTA['id'];
				$actualizar = $CONEXION->query("UPDATE cursoasientos SET asiento = '$asiento' WHERE id = $thisId");
			}
		}
	}

// %%%%%%%%%	Retirar asiento %%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_GET['retirarasiento'])) {
		$asiento=$_GET['retirarasiento'];
		$actualizar = $CONEXION->query("UPDATE cursoasientos SET asiento = '' WHERE id = $asiento");
	}

// %%%%%%%%%	Dar de baja del curso %%%%%%%%%%%%%%%%%
	if (isset($_GET['dardebaja'])) {
		$asiento=$_GET['dardebaja'];
		$borrar = $CONEXION->query("DELETE FROM cursoasientos WHERE id = $asiento");
	}

// %%%%%%%%%	Enviar notificación %%%%%%%%%%%%%%%%%%%
	if (isset($_GET['notify'])) {
		include '../includes/config.php';
		$Brand='ThetaHealing Mexico';
		$fallo=0;
		$mensaje="<b>Ocurrió un error:</b>";
		$cursoID=$_GET['curso'];
		$asiento=$_GET['asiento'];

		// Datos de la inscripción
		$CONSULTA0 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $id");
		$row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();

		// Información del curso
		$CONSULTA1 = $CONEXION -> query("SELECT * FROM cursoasientos WHERE id = $id");
		$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();

		$CONSULTA2 = $CONEXION -> query("SELECT * FROM cursos WHERE id = $cursoID");
		$row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
		$cursoTxt=$row_CONSULTA2['tituloes'];

		$ConsultaDatos = $CONEXION -> query("SELECT * FROM correos WHERE id = 3");
		$row_ConsultaDatos = $ConsultaDatos -> fetch_assoc();

		$Brand = $row_ConsultaDatos['remitente'];
		$asunto1 = $row_ConsultaDatos['asunto'];
		$asunto2 = 'Asiento seleccionado';

		$cuerpoSQL=str_replace('%userName%', ($row_CONSULTA0['nombre'].' '.$row_CONSULTA0['apellido']), $row_ConsultaDatos['cuerpo']);
		$cuerpoSQL=str_replace('%idEstudiante%', ($row_CONSULTA0['id']), $cuerpoSQL);
		$cuerpoSQL=str_replace('%botonPago%', '<p><span class="uk-button"><a href="'.$ruta.'../es/inscripcion">Realizar pago</a></span></p>', $cuerpoSQL);
		$cuerpoSQL=str_replace('%asiento%', $asiento, $cuerpoSQL);
		$cuerpoSQL=str_replace('%curso%', $cursoTxt, $cuerpoSQL);
		$cuerpoSQL=str_replace('../img/design/logo-mundo.png', 'http://' . DOMINIO . '/img/design/logo-mundo.png', $cuerpoSQL);


		$traductor=($row_CONSULTA1['traductor']=='')?'No':'S&iacute;, '.$row_CONSULTA1['traductor'];


		if(file_exists('library/phpmailer/PHPMailerAutoload.php')){
			require 'library/phpmailer/PHPMailerAutoload.php';
		}elseif(file_exists('../library/phpmailer/PHPMailerAutoload.php')){
			require '../library/phpmailer/PHPMailerAutoload.php';
		}else{
			$fallo=1;
			$mensaje.="<br>Code 00 - No se encontro PHPmailer";
		}

		$mailAsunto1 = 'Pago confirmado y asiento asignado';

		$mailHead='
			<html>
			<head>
				<meta content="text/html;charset=UTF-8" http-equiv="Content-Type">
				<title>'.$mailAsunto1.'</title>
				<style type="text/css">
					h1 { color: #333; font-size: 1.1em; }
					.fondo { background-color: '.$mailBGcolor.'; height: auto; padding: 20px 1%; width: 100%; }
					.wrapper { background-color: #FFF; color: #444; font-size:1em; height: auto; padding: 20px 3% 20px 3% ; margin: .5em auto .5em auto; width: 80%; }
					.text-center{ text-align: center; }
					.text-muted{ color: #888; }
					.text-lg{ font-size:1.1em; }
					.text-sm{ font-size:.9em; }
					.uk-button{ -webkit-appearance:none;margin:0;border:none;border-radius:5px;overflow:visible;font:inherit;text-transform:none;display:inline-block;-moz-box-sizing:border-box;box-sizing:border-box;padding:0 12px;background:#f7f7f7;vertical-align:middle;line-height:28px;min-height:30px;font-size:1rem;text-decoration:none;text-align:center;border:1px solid rgba(0,0,0,.2);border-bottom-color:rgba(0,0,0,.3);background-origin:border-box;color:#fff;background-color:#a8a;background-image:-webkit-linear-gradient(top,#a8a,#a79);background-image:linear-gradient(to bottom,#a8a,#a79);border-color:rgba(0,0,0,.2);border-bottom-color:rgba(0,0,0,.4);text-shadow:0 -1px 0 rgba(0,0,0,.2) }
					.uk-button a{ color:#FFF; text-decoration:none; }
				</style>
			</head>
			<body>
			<div class="fondo">
				<div class="wrapper">';
		
		$mailFooter='
				</div>
			</div>
			</body>
			</html>';
			
		$cuerpoDelCorreo1 = $mailHead.$cuerpoSQL.$mailFooter;

		// Envío
		if($fallo==0){
			//Create a new PHPMailer instance
			$mail1 = new PHPMailer;
			//Tell PHPMailer to use SMTP
			$mail1->isSMTP();
			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail1->SMTPDebug = 0;
			//Ask for HTML-friendly debug output
			$mail1->Debugoutput = 'html';
			//Set the hostname of the mail server
			$mail1->Host = MAIL_HOST;
			// Seguridad
			$mail1->SMTPSecure = 'SSL';
			//Set the SMTP port number - likely to be 25, 465 or 587
			$mail1->Port = 587;
			//Whether to use SMTP authentication
			$mail1->SMTPAuth = true;
			//Username to use for SMTP authentication
			$mail1->Username = SENDER_ADMIN_MAIL;
			//Password to use for SMTP authentication
			$mail1->Password = SENDER_ADMIN_MAIL_PASS;
			//Set who the message is to be sent from
			$mail1->setFrom(SENDER_ADMIN_MAIL, $Brand);
			//Set an alternative reply-to address
			if (IS_RUSSIAN_DOMAIN) {
				$mail1->addBCC(SENDER_ADMIN_MAIL, $Brand);
				$mail1->addBCC(RECIPIENT_ADMIN_MAIL, $Brand);
			} else {
				$mail1->addReplyTo(RECIPIENT_ADMIN_MAIL, $Brand);
			}
			//Set who the message is to be sent to
			$mail1->addAddress($row_CONSULTA0['email'], html_entity_decode($row_CONSULTA0['nombre'].' '.$row_CONSULTA0['apellido']));
			//Set the subject line
			$mail1->Subject = $mailAsunto1;
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			$mail1->msgHTML($cuerpoDelCorreo1);
			//Replace the plain text body with one created manually
			$mail1->AltBody = 'Se le ha asignado un asiento';
			// Enviar
			if($mail1->Send()){
				$exito='success';
				$legendSuccess.="<br>Correo enviado con éxito";
				unset($fallo);
			}else{
				$fallo='danger';  
				$legendFail.='<br>No se pudo enviar el correo - Code 15<br>Email: '.SENDER_ADMIN_MAIL;
			}
		}else{
			$fallo='danger';  
			$legendFail.='<br>No se pudo enviar el correo - Code 16<br>Email: '.SENDER_ADMIN_MAIL;
		}
	}
	// Como se hizo una redirección para impedir dobles envíos al recargar
	// Obtenemos la variable que nos indica que debemos mostrar el mensaje de éxito
	if (isset($_GET['notifysent'])) {
		$exito='success';
		$legendSuccess.="<br>Correo enviado con éxito";
	}

// %%%%%%%%%	Inscribir en curso %%%%%%%%%%%%%%%%%%%%
	if (isset($_GET['inscribir'])) {
		$curso=$_GET['inscribir'];

		$CONSULTA = $CONEXION -> query("SELECT * FROM cursos WHERE id = $curso");
		$row_CONSULTA = $CONSULTA -> fetch_assoc();
		$pago1=$row_CONSULTA['precio'];

		$sql = "INSERT INTO cursoasientos (curso,usuario,pago1)".
			"VALUES ('$curso','$id','$pago1')";
		if ($insertar = $CONEXION->query($sql)) {
			$exito='success';
			$legendSuccess.="<br>Usuario agregado";
		}else{
			$fallo='danger';  
			$legendFail.="<br>No se pudo agregar el usuario ";
		}
	}

// %%%%%%%%%	Editar traductor %%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['editatraduc'])) {

		include '../../../includes/connection.php';
		include '../../../includes/config.php';

		$id    = $_POST['id'];
		$valor = htmlentities($_POST['editatraduc'], ENT_QUOTES);

		if ($actualizar = $CONEXION->query("UPDATE cursoasientos SET traductor = '$valor' WHERE id = $id")) {
			echo '<span class="uk-text-success"><span uk-icon="icon: check"></span> Guardado</span>';
		}else{
			echo '<span class="uk-text-danger"><span uk-icon="icon: close"></span> No se pudo guardar</span>';
		}
	}

// %%%%%%%%%	Editar material %%%%%%%%%%%%%%%%%%%%%%
if (isset($_POST['editamat'])) {

	include '../../../includes/connection.php';
	include '../../../includes/config.php';

	$id    = $_POST['id'];
	$valor = htmlentities($_POST['editamat'], ENT_QUOTES);

	if ($actualizar = $CONEXION->query("UPDATE cursoasientos SET material = '$valor' WHERE id = $id")) {
		echo '<span class="uk-text-success"><span uk-icon="icon: check"></span> Guardado</span>';
	}else{
		echo '<span class="uk-text-danger"><span uk-icon="icon: close"></span> No se pudo guardar</span>';
	}
}
