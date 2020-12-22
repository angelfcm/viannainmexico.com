<?php
	include '../includes/connection.php';
	include '../includes/config.php';
	include '../includes/languaje.php';

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Login    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['login'])) {
		$email=$_POST['email'];
		$USER = $CONEXION -> query("SELECT id FROM usuarios WHERE email = '$email'");
		$numRows = $USER ->num_rows;
		if ($numRows!=0) {
			$row_USER = $USER -> fetch_assoc();
			$uid=$row_USER['id'];
			echo $uid.'_seleccionar-asiento.html';
		}else{
			echo 'fallo';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Asignar asiento    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['asignarasiento'])) {
		$asiento=$_POST['asiento'];
		$curso=$_POST['curso'];
		$uid=$_POST['uid'];

		// Verificar que no haya sido seleccionado el mismo asiento por otro usuario.
		$isTaken = $CONEXION->query("SELECT * FROM cursoasientos WHERE curso = $curso AND asiento = '$asiento'")->fetch_assoc() != null;
		
		if ($isTaken) {
			echo 'is_taken';
			exit;
		}

		$CONSULTA = $CONEXION -> query("SELECT * FROM cursoasientos WHERE usuario = $uid AND curso = $curso");
		$numRows = $CONSULTA ->num_rows;
		if ($numRows!=0) {
			while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
				$thisId=$row_CONSULTA['id'];
				$actualizar = $CONEXION->query("UPDATE cursoasientos SET asiento = '$asiento' WHERE usuario = $uid AND curso = $curso");
				sendSit($thisId);
			}
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Inscripción    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['registro'])) {

		$isAjax = isset($_POST['is_ajax']) && $_POST['is_ajax'];

		$captcha=(isset($_POST['g-recaptcha-response']))?$_POST['g-recaptcha-response']:'';
		$nombre=(isset($_POST['nombre']))?htmlentities($_POST['nombre'],ENT_QUOTES):'';
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
		$material=(isset($_POST['materialLang']))?htmlentities($_POST['materialLang'],ENT_QUOTES):'';
		$languaje=$_POST['languaje'];
		$paymentOption = (isset($_POST['payment_option']))?htmlentities($_POST['payment_option'],ENT_QUOTES):'';
		$translationPaymentOption = (isset($_POST['translation_payment_option']))?htmlentities($_POST['translation_payment_option'],ENT_QUOTES):'';
		$alta=date('Y-m-d');
		
		$secret='6LfemlQUAAAAAKf-Ji15brjulODTS7kw1_sYDlF0';
		$ip=$_SERVER['REMOTE_ADDR'];
		$ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $result = curl_exec($ch); 
		curl_close($ch);  
		$result=json_decode($result,true);

		$captchaPassed = 1 || $result["success"] ? true : false;
		if($captchaPassed || $isAjax){ 
			$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE email = '$email'");
			$numRows = $USER ->num_rows;
			if ($numRows==0) {
				$sql = "INSERT INTO usuarios (alta,nombre,apellido,email,gafet,nacimiento,telefono,emergencia,direccion,pais,invita)".
					"VALUES ('$alta','$nombre','$apellido','$email','$gafet','$nacimiento','$telefono','$emergencia','$direccion','$pais','$invita')";
				if ($insertar = $CONEXION->query($sql)) {
					$id=$CONEXION->insert_id;

					// Agregar cursos seleccionados
					$CONSULTA1 = $CONEXION -> query("SELECT id,precio FROM cursos");
					while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
						$curso=$row_CONSULTA1['id'];
						$pago1=$row_CONSULTA1['precio'];
						if(isset($_POST['curso'.$curso])){
							$courseType = isset($_POST['courseType'.$curso]) ? $_POST['courseType'.$curso] : 'NULL';
							$sql = "INSERT INTO cursoasientos (curso,tipo,usuario,traductor,material,metodo1,translation_payment_option)".
								"VALUES ('$curso', $courseType, '$id','$traductor','$material', '$paymentOption', '$translationPaymentOption')";
							$insertar = $CONEXION->query($sql);
						}
					}
				}
				
				sendInscription($id, $languaje);
			} else { 
				$row_USER = $USER -> fetch_assoc();
				$id=$row_USER['id'];

				// $sql = "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', email = '$email', gafet = '$gafet', nacimiento = '$nacimiento', telefono = '$telefono', emergencia = '$emergencia', direccion = '$direccion', pais = '$pais', invita = '$invita') WHERE id = '$id'";
				// 	"VALUES ('$alta','$nombre','$apellido','$email','$gafet','$nacimiento','$telefono','$emergencia','$direccion','$pais','$invita')";
				// $CONEXION->query($sql);
				if ($nacimiento) {
					$sql = "UPDATE usuarios SET nacimiento = '$nacimiento' WHERE id = '$id'";
				}
				$CONEXION->query($sql);
				// Agregar cursos seleccionados
				$CONSULTA1 = $CONEXION -> query("SELECT id FROM cursos");
				while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
					$curso=$row_CONSULTA1['id'];
					if(isset($_POST['curso'.$curso])){
						$courseType = isset($_POST['courseType'.$curso]) ? $_POST['courseType'.$curso] : 'NULL';
						$CONSULTA2 = $CONEXION -> query("SELECT id FROM cursoasientos WHERE curso = $curso and usuario = $id");
						$numRowsCursos = $CONSULTA2 ->num_rows;
						if ($numRowsCursos==0) {
							$sql = "INSERT INTO cursoasientos (curso,tipo,usuario,traductor,material,metodo1,translation_payment_option)".
								"VALUES ('$curso', $courseType, '$id','$traductor','$material', '$paymentOption', '$translationPaymentOption')";
							$insertar = $CONEXION->query($sql);
						}
						else {
							$setSql = '';
							if ($courseType) {
								$setSql .= "tipo = '$courseType'";
							}
							if ($traductor) {
								$setSql .= ", traductor = '$traductor'";
							}
							if ($material) {
								$setSql .= ", material = '$material'";
							}
							if ($paymentOption) {
								$setSql .= ", metodo1 = '$paymentOption'";
							}
							if ($translationPaymentOption) {
								$setSql .= ", translation_payment_option = '$translationPaymentOption'";
							}
							$CONEXION -> query("UPDATE cursoasientos SET $setSql WHERE curso = $curso and usuario = $id");
						}
					}
				}
			}

			$res = null;
			if (isset($_POST['create_payment']) && $_POST['create_payment']) {
				$currency = isset($_POST['currency']) && $_POST['currency'] == 'MXN' ? 'MXN' : 'USD';
				$paymentCourses = isset($_POST['paymentCourses']) ? $_POST['paymentCourses'] : [];
				$paymentTranslations = isset($_POST['paymentTranslations']) ? $_POST['paymentTranslations'] : [];

				require_once 'pp/PPPayment.php';

				$ppPayment = new PPPayment($languaje, $currency);
				$res = $ppPayment->createCoursesPayment($id, $paymentCourses, $paymentTranslations, $paymentOption == 'CARD');
			}

			if ($isAjax) {
				$d = ['userID' => $id];
				if (!empty($res)) {
					$d['paymentId'] = $res['id'];
					$d['approvalUrl'] = $res['approval_url'];
				}
				echo json_encode($d);
			}
			else {
				checkRegistrationEmailAndRemember($email);
				if ($paymentOption == 'CARD' && $res) {
					$_SESSION['paypal_plus'] = json_encode([
						'userID' => $id,
						'paymentId' => $res['id'],
						'approvalUrl' => $res['approval_url'],
						'payerEmail' => $email,
						'payerFirstName' => $nombre ?: 'Cliente convencional',
						'payerLastName' => $apellido ?: 'Cliente convencional',
						'paymentCourses' => $paymentCourses,
						'paymentTranslations' => $paymentTranslations,
						'currency' => $currency,
					]);
					header('location: '.$BASE_URL.'/'.$languaje.'/pago-tarjeta');
				} else {
					header('location: '.$BASE_URL.'/'.$languaje.'/inscripcion');
				}
			}
		}else{
			if ($isAjax) {
				http_response_code (401);
				echo json_encode(['error' => 'No pasó la verificación del captcha']);
			}
			else header('location: '.$BASE_URL.'/'.$languaje.'/14_fallo-.html?captcha_failed=1');
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    POST Inscripción    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_POST['registro2'])) {
		$captcha=(isset($_POST['g-recaptcha-response']))?$_POST['g-recaptcha-response']:'';
		$nombre=(isset($_POST['nombre']))?htmlentities($_POST['nombre'],ENT_QUOTES):'';
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
		$material=(isset($_POST['materialLang']))?htmlentities($_POST['materialLang'],ENT_QUOTES):'';
		$languaje=$_POST['languaje'];
		$alta=date('Y-m-d');
		$secret='6LfemlQUAAAAAKf-Ji15brjulODTS7kw1_sYDlF0';
		$ip=$_SERVER['REMOTE_ADDR'];
		$result=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
		$array=json_decode($result,true);

		if($array["success"]){
			$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE email = '$email'");
			$numRows = $USER ->num_rows;
			if ($numRows==0) {
				$sql = "INSERT INTO usuarios (alta,nombre,apellido,email,gafet,nacimiento,telefono,emergencia,direccion,pais,invita)".
					"VALUES ('$alta','$nombre','$apellido','$email','$gafet','$nacimiento','$telefono','$emergencia','$direccion','$pais','$invita')";
				if ($insertar = $CONEXION->query($sql)) {
					$id=$CONEXION->insert_id;
					// Agregar cursos seleccionados
					$CONSULTA1 = $CONEXION -> query("SELECT id FROM cursos");
					while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
						$curso=$row_CONSULTA1['id'];
						if(isset($_POST['curso'.$curso])){
							$sql = "INSERT INTO cursoasientos (curso,usuario,traductor,material)".
								"VALUES ('$curso','$id','$traductor','$material')";
							$insertar = $CONEXION->query($sql);
						}
					}
				}
			}else{
				$row_USER = $USER -> fetch_assoc();
				$id=$row_USER['id'];
				// Agregar cursos seleccionados
				$CONSULTA1 = $CONEXION -> query("SELECT id FROM cursos");
				while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
					$curso=$row_CONSULTA1['id'];
					if(isset($_POST['curso'.$curso])){
						$CONSULTA2 = $CONEXION -> query("SELECT id FROM cursoasientos WHERE curso = $curso and usuario = $id");
						$numRowsCursos = $CONSULTA2 ->num_rows;
						if ($numRowsCursos==0) {
							$sql = "INSERT INTO cursoasientos (curso,usuario,traductor,material)".
								"VALUES ('$curso','$id','$traductor','$material')";
							$insertar = $CONEXION->query($sql);
						}
					}
				}
			}
			header('location: '.$BASE_URL.'/'.$languaje.'/inscripcion');
		}else{
			header('location: '.$BASE_URL.'/'.$languaje.'/14_fallo-.html');
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Envío de correo Registro  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	function sendInscription($id, $languaje = "es") {
		global $CONEXION;
		global $efra;
		global $RemitenteMail;
		global $RemitentePass;
		global $destinatario1;
		global $mailBGcolor;
		global $ruta;
		global $courseTypeLabel;
		global $courseTypeLangs;

		$fallo=0;
		$mensaje="<b>Ocurrió un error:</b>";

		// Datos de la inscripción
		$CONSULTA0 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $id");
		$row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();

		// Información del curso
		$cursoTxt='';
		$num=0;
		$CONSULTA1 = $CONEXION -> query("SELECT * FROM cursoasientos WHERE usuario = $id");
		while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
			$num++;
			$curso=$row_CONSULTA1['curso'];
			$CONSULTA2 = $CONEXION -> query("SELECT * FROM cursos WHERE id = $curso");
			$row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
			$tipo = isset($courseTypeLangs[$row_CONSULTA1['tipo']]) ? $courseTypeLangs[$row_CONSULTA1['tipo']] : 'N/A';
			$cursoTxt.=$num.' - '.$row_CONSULTA2['tituloes'] . "<br>$courseTypeLabel: " . $tipo .'<br>'; //.' - $'.number_format($row_CONSULTA2['precio'],2).' MXN<br>';
			$traductor=$row_CONSULTA1['traductor'];
		}
		if($traductor!='No'){ $cursoTxt.='<br>* &nbsp; Traducci&oacute;n: $25 USD por d&iacute;a'; }

		$ConsultaDatos = $CONEXION -> query("SELECT * FROM correos WHERE id = 1");
		$row_ConsultaDatos = $ConsultaDatos -> fetch_assoc();

		$Brand = $row_ConsultaDatos['remitente'];
		$asunto1 = $row_ConsultaDatos['asunto'];
		$asunto2 = 'Un nuevo registro en el sitio web';

		$cuerpoSQL=str_replace('%userName%', ($row_CONSULTA0['nombre'].' '.$row_CONSULTA0['apellido']), $row_ConsultaDatos['cuerpo']);
		$cuerpoSQL=str_replace('%idEstudiante%', ($row_CONSULTA0['id']), $cuerpoSQL);
		$cuerpoSQL=str_replace('%botonPago%', ('<p><span class="uk-button"><a href="'.$ruta.'../'. $languaje .'/inscripcion">Realizar pago</a></span></p>'), $cuerpoSQL);
		$cuerpoSQL=str_replace('%curso%', ($cursoTxt), $cuerpoSQL);
		$cuerpoSQL=str_replace('../img/design/logo-mundo.png', ('http://' . DOMAIN . '/img/design/logo-mundo.png'), $cuerpoSQL);



		$datos='
			<ul class="text-sm">
				<li><span class="text-muted">N&uacute;mero de estudiante:</span> '.$row_CONSULTA0['id'].'</li>
				<li><span class="text-muted">Nombre:</span> '.$row_CONSULTA0['nombre'].' '.$row_CONSULTA0['apellido'].'</li>
				<li><span class="text-muted">Email:</span> '.$row_CONSULTA0['email'].'</li>
				<li><span class="text-muted">Gafete:</span> '.$row_CONSULTA0['gafet'].'</li>
				<li><span class="text-muted">Fecha de nacimiento:</span> '.$row_CONSULTA0['nacimiento'].'</li>
				<li><span class="text-muted">Tel&eacute;fono:</span> '.$row_CONSULTA0['telefono'].'</li>
				<li><span class="text-muted">Contacto de emergencia:</span> '.$row_CONSULTA0['emergencia'].'</li>
				<li><span class="text-muted">Direcci&oacute;n:</span> '.$row_CONSULTA0['direccion'].'</li>
				<li><span class="text-muted">Pa&iacute;s:</span> '.$row_CONSULTA0['pais'].'</li>
				<li><span class="text-muted">Invitado por:</span> '.$row_CONSULTA0['invita'].'</li>
				<li><span class="text-muted">Traductor:</span> '.$traductor.'</li>
			</ul>';

		$head='
			<html>
			<head>
				<meta content="text/html;charset=UTF-8" http-equiv="Content-Type">
				<title>'.$asunto1.'</title>
				<style type="text/css">
					h1 { color: #333; font-size: 1.1em; }
					.fondo { background-color: '.$mailBGcolor.'; height: auto; padding: 20px 1%; width: 100%; }
					.wrapper { background-color: #FFF; color: #444; font-size:1em; height: auto; padding: 20px 3% 20px 3% ; margin: .5em auto .5em auto; width: 80%; }
					.text-center{ text-align: center; }
					.text-muted{ color: #888; }
					.text-sm{ font-size:.9em; }
					.uk-button{ -webkit-appearance:none;margin:0;border:none;border-radius:5px;overflow:visible;font:inherit;text-transform:none;display:inline-block;-moz-box-sizing:border-box;box-sizing:border-box;padding:0 12px;background:#f7f7f7;vertical-align:middle;line-height:28px;min-height:30px;font-size:1rem;text-decoration:none;text-align:center;border:1px solid rgba(0,0,0,.2);border-bottom-color:rgba(0,0,0,.3);background-origin:border-box;color:#fff;background-color:#a8a;background-image:-webkit-linear-gradient(top,#a8a,#a79);background-image:linear-gradient(to bottom,#a8a,#a79);border-color:rgba(0,0,0,.2);border-bottom-color:rgba(0,0,0,.4);text-shadow:0 -1px 0 rgba(0,0,0,.2) }
					.uk-button a{ color:#FFF; text-decoration:none; }
				</style>
			</head>
			<body>
			<div class="fondo">
				<div class="wrapper">';
		
		$footer='
				</div>
			</div>
			</body>
			</html>';

		$cuerpoDelCorreo1 = $head.$cuerpoSQL.$footer;

		$cuerpoDelCorreo2 = $head.'
					<p>Una persona se ha registrado en el sitio web.</p>
					<p><span class="uk-button"><a href="'.$ruta.'../admin/">Administraci&oacute;n</a></span></p>
					<p class="text-sm">Los datos son los siguientes:</p>
					<p><b>'.$cursoTxt.'</b></p>
					'.$datos.'
					'.$footer;

		//echo $cuerpoDelCorreo2;

		if(file_exists('library/phpmailer/PHPMailerAutoload.php')){
			require 'library/phpmailer/PHPMailerAutoload.php';
		}elseif(file_exists('../library/phpmailer/PHPMailerAutoload.php')){
			require '../library/phpmailer/PHPMailerAutoload.php';
		}else{
			$fallo=1;
			$mensaje.="<br>Code 00 - No se encontro PHPmailer";
		}

		if($fallo==0){
			//Create a new PHPMailer instance
			$mail1 = new PHPMailer;
			$mail2 = new PHPMailer;
			//Tell PHPMailer to use SMTP
			// $mail1->isSMTP();
			// $mail2->isSMTP();
			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail1->SMTPDebug = 0;
			$mail2->SMTPDebug = 0;
			//Ask for HTML-friendly debug output
			$mail1->Debugoutput = 'html';
			$mail2->Debugoutput = 'html';
			//Set the hostname of the mail server
			$mail1->Host = MAIL_HOST;
			$mail2->Host = MAIL_HOST;
			// Seguridad
			$mail1->SMTPSecure = 'SSL';
			$mail2->SMTPSecure = 'SSL';
			//Set the SMTP port number - likely to be 25, 465 or 587
			$mail1->Port = 587;
			$mail2->Port = 587;
			//Whether to use SMTP authentication
			$mail1->SMTPAuth = true;
			$mail2->SMTPAuth = true;
			//Username to use for SMTP authentication
			$mail1->Username = SENDER_ADMIN_MAIL;
			$mail2->Username = SENDER_ADMIN_MAIL;
			//Password to use for SMTP authentication
			$mail1->Password = SENDER_ADMIN_MAIL_PASS;
			$mail2->Password = SENDER_ADMIN_MAIL_PASS;
			//Set who the message is to be sent from
			$mail1->setFrom(SENDER_ADMIN_MAIL, $Brand);
			$mail2->setFrom(SENDER_ADMIN_MAIL, $Brand);
			//Set an alternative reply-to address
			if (IS_RUSSIAN_DOMAIN) {
				$mail1->addBCC(SENDER_ADMIN_MAIL, $Brand);
				$mail1->addBCC(RECIPIENT_ADMIN_MAIL, $Brand);
				$mail2->addBCC(SENDER_ADMIN_MAIL, $Brand);
				$mail2->addBCC(RECIPIENT_ADMIN_MAIL, $Brand);
			} else {
				$mail1->addReplyTo(RECIPIENT_ADMIN_MAIL, $Brand);
				$mail2->addReplyTo(RECIPIENT_ADMIN_MAIL, $Brand);
			}
			//Set who the message is to be sent to
			$mail1->addAddress($row_CONSULTA0['email'], html_entity_decode($row_CONSULTA0['nombre'].' '.$row_CONSULTA0['apellido']));
			$mail2->addAddress(RECIPIENT_ADMIN_MAIL, $Brand);
			//Set the subject line
			$mail1->Subject = $asunto1;
			$mail2->Subject = $asunto2;
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			$mail1->msgHTML($cuerpoDelCorreo1);
			$mail2->msgHTML($cuerpoDelCorreo2);
			//Replace the plain text body with one created manually
			$mail1->AltBody = 'Inscripción exitosa';
			$mail2->AltBody = $row_CONSULTA0['email'].' - Nueva inscripción';
			// Enviar
			if($mail1->Send()){
				$mail2->Send();
				$mensaje='Enviado con exito';
				$classe='success';
				$icon='check';
			}else{
				$mensaje.="Error 12<br>Email: ".SENDER_ADMIN_MAIL;
				$classe='danger';
				$icon='close';
			}
		}else{
			$mensaje.='<br>No se pudo enviar el correo - Code 16<br>Email: '.SENDER_ADMIN_MAIL;
			$classe='danger';
		}
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Envío de correo Asiento   %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	function sendSit($id) {
		global $CONEXION;
		global $efra;
		global $RemitenteMail;
		global $RemitentePass;
		global $destinatario1;
		global $mailBGcolor;
		global $logoMail;
		global $ruta;
		global $courseTypeLangs;
		global $courseTypeLabel;

		$fallo=0;
		$mensaje="<b>Ocurrió un error:</b>";

		$CONSULTA = $CONEXION -> query("SELECT * FROM cursoasientos WHERE id = $id");
		$row_CONSULTA = $CONSULTA -> fetch_assoc();
		$uid=$row_CONSULTA['usuario'];
		$asiento=$row_CONSULTA['asiento'];
		$curso=$row_CONSULTA['curso'];

		// Datos de la inscripción
		$CONSULTA1 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $uid");
		$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();

		// Información del curso
		$cursoTxt='';
		$CONSULTA2 = $CONEXION -> query("SELECT tituloes FROM cursos WHERE id = $curso");
		$row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
		$tipo = isset($courseTypeLangs[$row_CONSULTA['tipo']]) ? $courseTypeLangs[$row_CONSULTA['tipo']] : 'N/A';
		$cursoTxt.=$row_CONSULTA2['tituloes'].'<br>' . "<br>$courseTypeLabel: " . $tipo .'<br>';


		$ConsultaDatos = $CONEXION -> query("SELECT * FROM correos WHERE id = 2");
		$row_ConsultaDatos = $ConsultaDatos -> fetch_assoc();

		$Brand = $row_ConsultaDatos['remitente'];
		$asunto1 = $row_ConsultaDatos['asunto'];
		$asunto2 = 'Asiento seleccionado';

		$cuerpoSQL=str_replace('%userName%', ($row_CONSULTA1['nombre'].' '.$row_CONSULTA1['apellido']), $row_ConsultaDatos['cuerpo']);
		$cuerpoSQL=str_replace('%idEstudiante%', ($row_CONSULTA1['id']), $cuerpoSQL);
		$cuerpoSQL=str_replace('%botonPago%', '<p><span class="uk-button"><a href="'.$ruta.'../es/inscripcion">Realizar pago</a></span></p>', $cuerpoSQL);
		$cuerpoSQL=str_replace('%asiento%', $asiento, $cuerpoSQL);
		$cuerpoSQL=str_replace('%curso%', $cursoTxt, $cuerpoSQL);
		$cuerpoSQL=str_replace('../img/design/logo-mundo.png', 'http://' . DOMAIN . '/img/design/logo-mundo.png', $cuerpoSQL);


		$head='
			<html>
			<head>
				<meta content="text/html;charset=UTF-8" http-equiv="Content-Type">
				<title>'.$asunto1.'</title>
				<style type="text/css">
					h1 { color: #333; font-size: 1.1em; }
					.fondo { background-color: '.$mailBGcolor.'; height: auto; padding: 20px 1%; width: 100%; }
					.wrapper { background-color: #FFF; color: #444; font-size:1em; height: auto; padding: 20px 3% 20px 3% ; margin: .5em auto .5em auto; width: 80%; }
					.text-center{ text-align: center; }
					.text-muted{ color: #888; }
					.text-sm{ font-size:.9em; }
					.uk-button{ -webkit-appearance:none;margin:0;border:none;border-radius:5px;overflow:visible;font:inherit;text-transform:none;display:inline-block;-moz-box-sizing:border-box;box-sizing:border-box;padding:0 12px;background:#f7f7f7;vertical-align:middle;line-height:28px;min-height:30px;font-size:1rem;text-decoration:none;text-align:center;border:1px solid rgba(0,0,0,.2);border-bottom-color:rgba(0,0,0,.3);background-origin:border-box;color:#fff;background-color:#a8a;background-image:-webkit-linear-gradient(top,#a8a,#a79);background-image:linear-gradient(to bottom,#a8a,#a79);border-color:rgba(0,0,0,.2);border-bottom-color:rgba(0,0,0,.4);text-shadow:0 -1px 0 rgba(0,0,0,.2) }
					.uk-button a{ color:#FFF; text-decoration:none; }
				</style>
			</head>
			<body>
			<div class="fondo">
				<div class="wrapper">';
		
		$footer='
				</div>
			</div>
		</div>
		</body>
		</html>';

		$cuerpoDelCorreo1 = $head.$cuerpoSQL.$footer;

		$cuerpoDelCorreo2 = $head.'
					<h1>'.$row_CONSULTA1['nombre'].' '.$row_CONSULTA1['apellido'].' ha seleccionado un asiento</h1>
					<p><b>'.$cursoTxt.'</b></p>
					<p>N&uacute;mero de estudiante:</span> '.$uid.'</p>
					<p><b>Asiento: '.$asiento.'</b></p>
					'.$footer;

		if(file_exists('library/phpmailer/PHPMailerAutoload.php')){
			require 'library/phpmailer/PHPMailerAutoload.php';
		}elseif(file_exists('../library/phpmailer/PHPMailerAutoload.php')){
			require '../library/phpmailer/PHPMailerAutoload.php';
		}else{
			$fallo=1;
			$mensaje.="<br>Code 00 - No se encontro PHPmailer";
		}

		// Envío
		if($fallo==0){
			//Create a new PHPMailer instance
			$mail1 = new PHPMailer;
			$mail2 = new PHPMailer;
			//Tell PHPMailer to use SMTP
			// $mail1->isSMTP();
			// $mail2->isSMTP();
			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail1->SMTPDebug = 0;
			$mail2->SMTPDebug = 0;
			//Ask for HTML-friendly debug output
			$mail1->Debugoutput = 'html';
			$mail2->Debugoutput = 'html';
			//Set the hostname of the mail server
			$mail1->Host = MAIL_HOST;
			$mail2->Host = MAIL_HOST;
			// Seguridad
			$mail1->SMTPSecure = 'SSL';
			$mail2->SMTPSecure = 'SSL';
			//Set the SMTP port number - likely to be 25, 465 or 587
			$mail1->Port = 587;
			$mail2->Port = 587;
			//Whether to use SMTP authentication
			$mail1->SMTPAuth = true;
			$mail2->SMTPAuth = true;
			//Username to use for SMTP authentication
			$mail1->Username = SENDER_ADMIN_MAIL;
			$mail2->Username = SENDER_ADMIN_MAIL;
			//Password to use for SMTP authentication
			$mail1->Password = SENDER_ADMIN_MAIL_PASS;
			$mail2->Password = SENDER_ADMIN_MAIL_PASS;
			//Set who the message is to be sent from
			$mail1->setFrom(SENDER_ADMIN_MAIL, $Brand);
			$mail2->setFrom(SENDER_ADMIN_MAIL, $Brand);
			//Set an alternative reply-to address
			if (IS_RUSSIAN_DOMAIN) {
				$mail1->addBCC(SENDER_ADMIN_MAIL, $Brand);
				$mail1->addBCC(RECIPIENT_ADMIN_MAIL, $Brand);
				$mail2->addBCC(SENDER_ADMIN_MAIL, $Brand);
				$mail2->addBCC(RECIPIENT_ADMIN_MAIL, $Brand);
			} else {
				$mail1->addReplyTo(RECIPIENT_ADMIN_MAIL, $Brand);
				$mail2->addReplyTo(RECIPIENT_ADMIN_MAIL, $Brand);
			}
			//Set who the message is to be sent to
			$mail1->addAddress($row_CONSULTA1['email'], html_entity_decode($row_CONSULTA1['nombre'].' '.$row_CONSULTA1['apellido']));
			$mail2->addAddress(RECIPIENT_ADMIN_MAIL, $Brand);
			//Set the subject line
			$mail1->Subject = $asunto1;
			$mail2->Subject = $asunto2;
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			$mail1->msgHTML($cuerpoDelCorreo1);
			$mail2->msgHTML($cuerpoDelCorreo2);
			//Replace the plain text body with one created manually
			$mail1->AltBody = 'Asiento asignado';
			$mail2->AltBody = $row_CONSULTA1['email'].' - Asiento asignado';
			// Enviar
			if($mail1->Send()){
				$mail2->Send();
				$mensaje='Enviado con exito';
				$classe='success';
				$icon='check';
			}else{
				$mensaje.="Error 12<br>Email: ".SENDER_ADMIN_MAIL;
				$classe='danger';
				$icon='close';
			}
		}else{
			$mensaje.='<br>No se pudo enviar el correo - Code 16<br>Email: '.SENDER_ADMIN_MAIL;
			$classe='danger';
		}
		//echo $mensaje;
		//echo 'Efra: '.$efra.' / Headers: '.$headers.' / Asunto: '.$asunto1.' / Brand:'.$Brand.' / Cuerpo:'.$cuerpoDelCorreo1;
	}

if (isset($_GET['checkEmail'])) {
	echo checkRegistrationEmailAndRemember(strtolower(trim(htmlentities($_GET['checkEmail'], ENT_QUOTES))));
}

function checkRegistrationEmailAndRemember($email) {
	global $CONEXION;

	$email = $email;// 
	$q = $CONEXION->query("SELECT * FROM usuarios WHERE email = '$email'");
	$exists = $q->num_rows > 0;
	session_start();

	unset($_SESSION['registration.email']);

	if ($exists)
		$_SESSION['registration.email'] = $email;

	return $exists ? 1 : 0;
}

if (isset($_GET['execute_payment'])) {

	$currency = isset($_POST['currency']) && $_POST['currency'] == 'MXN' ? 'MXN' : 'USD';
	$paymentCourses = isset($_POST['paymentCourses']) ? $_POST['paymentCourses'] : [];
	$paymentTranslations = isset($_POST['paymentTranslations']) ? $_POST['paymentTranslations'] : [];
	$paymentID = isset($_POST['paymentID']) ? $_POST['paymentID'] : null;
	$payerID = isset($_POST['payerID']) ? $_POST['payerID'] : null;
	$userID = isset($_POST['userID']) ? $_POST['userID'] : null;
	$languaje=  isset($_POST['languaje']) ? $_POST['languaje'] : null;

	if (empty($paymentID) || empty($payerID) || empty($userID) || empty($languaje)) {
		http_response_code(500);
		echo 0;
		exit;
	}

	require_once 'pp/PPPayment.php';
	$ppPayment = new PPPayment($languaje, $currency);
	
	$localPaymentID = $ppPayment->executeCoursesPayment($userID, $paymentCourses, $paymentTranslations, $paymentID, $payerID);
	
	if (!$localPaymentID)
		http_response_code(500);
	else {
		sendPPPaymentNotification($userID, $localPaymentID);
	}

	echo $localPaymentID ? 1 : 0;
}

function sendPPPaymentNotification($userID, $localPaymentID) {
	global $CONEXION;
	global $RemitenteMail;
	global $RemitentePass;
	global $destinatario1;
	global $mailBGcolor;
	global $ruta;
	global $courseTypeLangs;
	global $courseTypeLabel;
	
	$asunto = 'PAGO realizado desde el sitio web';
	$q = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $userID");
	$user = $q -> fetch_assoc();

	$paymentCourses = $CONEXION->query("SELECT * FROM cursoasientos cu RIGHT JOIN cursos c ON c.id = cu.curso WHERE payment_id = '$localPaymentID' OR translation_payment_id ='$localPaymentID'")->fetch_all(MYSQLI_ASSOC);
	$paymentCoursesHTML = '<p class="text-sm">Detalle de cursos pagados en esta transacci&oacute;n:</p><ol class="text-sm" style="list-style-type: decimal;">';
	$paymentLabel = '<span style="color: red">Pago Pendiente</span>';
	$traductor = 'No';

	foreach($paymentCourses as $pCourse) {

		if ($pCourse['payment_id'] == $localPaymentID) {
			if ($pCourse['translation_payment_id'] == $localPaymentID)
				$paymentLabel = '<span style="color: green">Pago de Curso y Traducci&oacute;n</span>';
			else
				$paymentLabel = '<span style="color: green">Pago de Curso</span>';
		} else
			$paymentLabel = '<span style="color: green">Pago de Traducci&oacute;n</span>';

		$tipo = isset($courseTypeLangs[$pCourse['tipo']]) ? $courseTypeLangs[$pCourse['tipo']] : 'N/A';
		$paymentCoursesHTML .= '<li>' . $pCourse['tituloes'] . ' (' . $paymentLabel . ")<br>$courseTypeLabel: $tipo</li>";
		if ($traductor == 'No')
			$traductor = $pCourse['traductor'];
	}

	$paymentCoursesHTML .= '</ol>';

	$payment = $CONEXION->query("SELECT * FROM pp_payments WHERE id = '$localPaymentID'")->fetch_assoc();
	$paymentInfoHTML = '<p class="text-sm">Detalle de la transacci&oacute;n:</p>';
	$paymentInfoHTML .= '
		<ul class="text-sm">
			<li><span class="text-muted">M&eacute;todo de pago:</span> PayPal</li>
			<li><span class="text-muted">Nombre del Remitente:</span> '.$payment['payer_fullname'] .'</li>
			<li><span class="text-muted">Correo del remitente:</span> '.$payment['payer_email'].'</li>
			<li><span class="text-muted">Total pagado:</span> $'.$payment['total'].' '.$payment['currency'].'</li>
			<li><span class="text-muted">ID Transacci&oacute;n:</span> '.$payment['payment_id'].'</li>
		</ul>';


	$datos='
		<ul class="text-sm">
			<li><span class="text-muted">N&uacute;mero de estudiante:</span> '.$user['id'].'</li>
			<li><span class="text-muted">Nombre:</span> '.$user['nombre'].' '.$user['apellido'].'</li>
			<li><span class="text-muted">Email:</span> '.$user['email'].'</li>
			<li><span class="text-muted">Gafete:</span> '.$user['gafet'].'</li>
			<li><span class="text-muted">Fecha de nacimiento:</span> '.$user['nacimiento'].'</li>
			<li><span class="text-muted">Tel&eacute;fono:</span> '.$user['telefono'].'</li>
			<li><span class="text-muted">Contacto de emergencia:</span> '.$user['emergencia'].'</li>
			<li><span class="text-muted">Direcci&oacute;n:</span> '.$user['direccion'].'</li>
			<li><span class="text-muted">Pa&iacute;s:</span> '.$user['pais'].'</li>
			<li><span class="text-muted">Invitado por:</span> '.$user['invita'].'</li>
			<li><span class="text-muted">Traductor:</span> '.$traductor.'</li>
		</ul>';

	$head='
		<html>
		<head>
			<meta content="text/html;charset=UTF-8" http-equiv="Content-Type">
			<title>Pago realizado</title>
			<style type="text/css">
				h1 { color: #333; font-size: 1.1em; }
				.fondo { background-color: '.$mailBGcolor.'; height: auto; padding: 20px 1%; width: 100%; }
				.wrapper { background-color: #FFF; color: #444; font-size:1em; height: auto; padding: 20px 3% 20px 3% ; margin: .5em auto .5em auto; width: 80%; }
				.text-center{ text-align: center; }
				.text-muted{ color: #888; }
				.text-sm{ font-size:.9em; }
				.uk-button{ -webkit-appearance:none;margin:0;border:none;border-radius:5px;overflow:visible;font:inherit;text-transform:none;display:inline-block;-moz-box-sizing:border-box;box-sizing:border-box;padding:0 12px;background:#f7f7f7;vertical-align:middle;line-height:28px;min-height:30px;font-size:1rem;text-decoration:none;text-align:center;border:1px solid rgba(0,0,0,.2);border-bottom-color:rgba(0,0,0,.3);background-origin:border-box;color:#fff;background-color:#a8a;background-image:-webkit-linear-gradient(top,#a8a,#a79);background-image:linear-gradient(to bottom,#a8a,#a79);border-color:rgba(0,0,0,.2);border-bottom-color:rgba(0,0,0,.4);text-shadow:0 -1px 0 rgba(0,0,0,.2) }
				.uk-button a{ color:#FFF; text-decoration:none; }
			</style>
		</head>
		<body>
		<div class="fondo">
			<div class="wrapper">';
	$footer='
			</div>
		</div>
		</body>
		</html>';

	$cuerpoDelCorreo = $head.'
				<p>Una persona ha realizado un pago con PayPal desde el sitio web.</p>
				<p><span class="uk-button"><a href="'.$ruta.'../admin/">Administraci&oacute;n</a></span></p>
				'.$paymentCoursesHTML.'
				'.$paymentInfoHTML.'
				<p class="text-sm">Datos del usuario:</p>
				'.$datos.'
				'.$footer;

	require '../library/phpmailer/PHPMailerAutoload.php';

	$Brand = 'MundoTH';
	
	$mail = new PHPMailer;
	// $mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = MAIL_HOST;
	$mail->SMTPSecure = 'SSL';
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->Username = SENDER_ADMIN_MAIL;
	$mail->Password = SENDER_ADMIN_MAIL_PASS;
	$mail->setFrom(SENDER_ADMIN_MAIL, $Brand);
	//$mail->addReplyTo($RemitenteMail, $Brand);
	if (IS_RUSSIAN_DOMAIN) {
		$mail->addBCC(SENDER_ADMIN_MAIL, $Brand);
	}
	$mail->addAddress(RECIPIENT_ADMIN_MAIL, $Brand);
	$mail->Subject = $asunto;;
	$mail->msgHTML($cuerpoDelCorreo);
	$mail->AltBody = $user['email'].' - Nuevo pago de PayPal';

	$mail->Send();
}