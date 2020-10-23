<?php
	include 'includes/connection.php';
	include 'includes/config.php';

	$nombre=(isset($_GET['nombre']))?$_GET['nombre']:'';
	$email=(isset($_GET['email']))?$_GET['email']:'';
	$comentario=(isset($_GET['comentario']))?$_GET['comentario']:'';
	$enviar=(isset($_GET['comentario']))?1:0;

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Envío de correo Asiento   %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	function sendMail($nombre,$email,$comentario) {
		global $CONEXION;
		global $efra;
		global $RemitenteMail;
		global $RemitentePass;
		global $destinatario1;
		global $mailBGcolor;
		global $logoMail;
		global $ruta;
		global $debug;
		global $Brand;

		$fallo=0;
		$asunto=$comentario;

		$cuerpo='
			<html>
			<head>
				<meta content="text/html;charset=UTF-8" http-equiv="Content-Type">
				<title>'.$comentario.'</title>
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
				<div class="wrapper">
				'.$comentario.'
				<br><br><br>
				<img src="http://viannainmexico.com/img/design/logo-mundo.png">
				</div>
			</div>
		</div>
		</body>
		</html>';


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
			$mail = new PHPMailer;
			//Tell PHPMailer to use SMTP
			// $mail->isSMTP();
			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug = 1;
			//Ask for HTML-friendly debug output
			$mail->Debugoutput = 'html';
			//Set the hostname of the mail server
			$mail->Host = "mail.viannainmexico.com";
			// Seguridad
			$mail->SMTPSecure = 'SSL';
			//Set the SMTP port number - likely to be 25, 465 or 587
			$mail->Port = 587;
			//Whether to use SMTP authentication
			$mail->SMTPAuth = true;
			//Username to use for SMTP authentication
			$mail->Username = $RemitenteMail;
			//Password to use for SMTP authentication
			$mail->Password = $RemitentePass;
			//Set who the message is to be sent from
			$mail->setFrom($RemitenteMail, $Brand);
			//Set an alternative reply-to address
			$mail->addReplyTo($RemitenteMail, $Brand);
			//Set who the message is to be sent to
			$mail->addAddress($email, $nombre);
			//Set the subject line
			$mail->Subject = $asunto;
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			$mail->msgHTML($cuerpo);
			//Replace the plain text body with one created manually
			$mail->AltBody = $email.' - '.$comentario;
			// Enviar
			if($mail->Send()){
				$mensaje='Enviado con exito';
				$classe='success';
				$icon='check';
			}else{
				$mensaje.="Error 12<br>Dominio: ".$dominio."<br>Email: ".$RemitenteMail;
				$classe='danger';
				$icon='close';
			}
		}else{
			$classe='danger';

		}

		$resultado = '
		<span class="uk-text-'.$classe.'">
			<span uk-icon="icon:'.$icon.'"></span>
			'.$mensaje.'
		</span>
		'; 
	}




	echo '
	<!DOCTYPE html>
	<html lang="es">
		<head>
			<meta charset="utf-8">

			<title>Pruebas de correo</title>

			<meta name="viewport" content="width=device-width, initial-scale=1.0">

			<link rel="shortcut icon" href="../img/design/favicon.ico">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.24/css/uikit.css">
			<link rel="stylesheet" type="text/css"  href="../css/admin.css">

		</head>
		<body>
			<div class="uk-container">
				<div uk-grid>
					<div class="uk-width-1-1">
						<br><br><br><br>
					</div>
					<div class="uk-width-1-1">
						Prueba de phpMailer
						<br><br>
					</div>
					<div class="uk-width-1-1">
						<form action="test.php" method="get">
							<input type="text" name="nombre" class="uk-input uk-form-width-medium" placeholder="Nombre" required>
							<input type="text" name="email" class="uk-input uk-form-width-medium" placeholder="Email" required>
							<input type="text" name="comentario" class="uk-input uk-form-width-medium" placeholder="Comentario" required>
							<button type="submit" class="uk-button uk-button-primary">Enviar</button>
						</form>
					</div>
					<div class="uk-width-1-1">
					<br><br>
					</div>
					<div class="uk-width-1-1">
					';

					if($enviar==1){
						sendMail($nombre,$email,$comentario);
					}

					echo'
					</div>
				</div>
			</div>
		</body>
	</html>
	';
