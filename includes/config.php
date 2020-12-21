<?php 

/* %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% 
					CONFIGURACIÓN
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  */

	define('COURSE_TYPE_FACE_TO_FACE', 1);
	define('COURSE_TYPE_ONLINE', 2);

	define('IS_RUSSIAN_DOMAIN', $_SERVER["SERVER_NAME"] == 'viannainmexico.ru');

	if (IS_RUSSIAN_DOMAIN) {
		define('DOMAIN', "viannainmexico.ru");
		define('MAIL_HOST', "mx1.hosting24.com");
		define('RECIPIENT_ADMIN_MAIL', "contacto@viannainmexico.com");
		define('SENDER_ADMIN_MAIL', "contacto@viannainmexico.ru");
		define('SENDER_ADMIN_MAIL_PASS', "wozial2017.");
	} else {
		define('DOMAIN', "viannainmexico.com");
		define('MAIL_HOST', "mail.viannainmexico.com");
		define('RECIPIENT_ADMIN_MAIL', "contacto@viannainmexico.com");
		define('SENDER_ADMIN_MAIL', "contacto@viannainmexico.com");
		define('SENDER_ADMIN_MAIL_PASS', "wozial2017.");
	}

	global $RemitenteMail;
	global $RemitentePass;
	global $mailBGcolor;
	global $logoMail;
	global $Brand;
	global $efra;
	global $destinatario1;
	global $debug;

	$debug = 0;

	$Brand='ThetaHealing en Mexico';
	$dominioString=DOMAIN;
	$BASE_URL = "http://".DOMAIN;
	if ($debug)
		$BASE_URL = 'http://localhost:8888/'.DOMAIN;


	$REMITENTE = $CONEXION -> query("SELECT pices,picen FROM configuracion WHERE id = 11");
	$row_REMITENTE = $REMITENTE -> fetch_assoc();
	
	$RemitenteMail = SENDER_ADMIN_MAIL;
	$RemitentePass = SENDER_ADMIN_MAIL_PASS;

	mysqli_free_result($REMITENTE);


	$destinatario1 = 'contacto@'.$dominioString;

	$efra='info@efra.biz';
	$logoMail = 'http://'.$dominioString.'/img/design/logo-mail.png';
	$logo = $ruta.'../img/design/logo.png';
	$mailBGcolor = '#c9e8e9';

	$appID='208670859668814';
	$googleMaps='AIzaSyBW3PoCVI2xNDUCwhOgZ_g0xospd_F2Rag';

	$socialFacebook='https://www.facebook.com/MundoThetahealing/';
	$socialInstagram='https://www.instagram.com/mundo_th/';
	$socialTwitter='https://twitter.com/thguadalajara/';
	$socialTwitter='https://twitter.com/thethetahealing/';

	$telefono ='3319260529';
	$telefono1='3315896232';

	$debug=($dominio=='localhost')?1:0;
	$prodsPagina=10;

	$telefonoSeparado= '(+521) '.substr($telefono, 0,2).''.substr($telefono, 2,8);
	$telefonoSeparado1= '+52 ('.substr($telefono1, 0,2).') '.substr($telefono1, 2,8);

	$title=$Brand;
	$description='';

