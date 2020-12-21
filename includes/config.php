<?php 

/* %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% 
					CONFIGURACIÓN
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  */

	/** COURSES CONFIGURATION */
	define('COURSE_TYPE_FACE_TO_FACE', 1);
	define('COURSE_TYPE_ONLINE', 2);

	/** PAYPAL CONFIGURATION */ 
	define('PP_SANDBOX_MODE', false); // Be careful when putting it as FALSE (LIVE/REAL MODE)

	define('PP_CLIENT_LIVE', 'AStloIVNvDZ_n30kBiHycjf4pK7hSk0dT6S3-3ihb-ZpWB2pPjYb7RGQv9QE2NtHPS3pKBfK5J8KYJfc');
	define('PP_SECRET_LIVE', 'EIz8o1Jgd-NYKFXc_54DoU14WTYqtDBPXqGT8vcOYeW8jlHF7O1fwx2xdeRUlsE_K9r94tYzmFXxUncH');
	define('PAYPAL_API_LIVE', 'https://api.paypal.com/v1');
	
	define('PP_CLIENT_SANDBOX', 'AaQV1ugAFd1HooSimvoJfhI1ofD-thcNAGaHukdRMtGmPKVVGDAaKdTTQtUqEgGSes0ld3QraEpxYo2i');
	define('PP_SECRET_SANDBOX', 'EJYzT_qWLIvoQgQToFcY1kaEdkuIaxFra6rQ3AaCnM9JmWTryyk9FyJs11jL0Knk6WsBWpxg2VWNS_fP');
	define('PAYPAL_API_SANDBOX', 'https://api.sandbox.paypal.com/v1');
	
	define('PP_CLIENT', !PP_SANDBOX_MODE ? PP_CLIENT_LIVE : PP_CLIENT_SANDBOX);
	define('PP_SECRET', !PP_SANDBOX_MODE ? PP_SECRET_LIVE : PP_SECRET_SANDBOX);
	define('PAYPAL_API', !PP_SANDBOX_MODE ? PAYPAL_API_LIVE : PAYPAL_API_SANDBOX);

	/** DOMAIN CONFIGURATION */ 
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

	$port = $_SERVER['SERVER_PORT'];
	$dominio=$_SERVER["SERVER_NAME"] . ($port && $port != 80 && $port != 443 ? ':' . $port : '');
	$dominio=str_replace('www.', '', $dominio);
	$debug = strpos($dominio, 'localhost') === 0;

	$Brand='ThetaHealing en Mexico';
	$dominioString=DOMAIN;
	$BASE_URL = ($port == 443 ? 'https://' :  'http://') . DOMAIN;
	if ($debug) {
		$BASE_URL = 'http://localhost:8888/'.DOMAIN;
	}


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

	$prodsPagina=10;

	$telefonoSeparado= '(+521) '.substr($telefono, 0,2).''.substr($telefono, 2,8);
	$telefonoSeparado1= '+52 ('.substr($telefono1, 0,2).') '.substr($telefono1, 2,8);

	$title=$Brand;
	$description='';

