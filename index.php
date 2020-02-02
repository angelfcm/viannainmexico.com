<?php 
	session_start();
	require_once 'includes/connection.php'; 
	require_once 'includes/config.php';

	// Redirecciona si se accede a la raíz. Lo mismo que index.html, pero no funcionaba en versiones recientes de php.
	if (!isset($_GET['languaje']))
		header('Location: ' . $ruta . (IS_RUSSIAN_DOMAIN ? 'ru/' : 'es'));

	require_once 'includes/languaje.php';
	require_once 'includes/widgets.php';


	// Obtener el identificador
	if(isset($_GET['identificador'])){ $identificador=$_GET['identificador']; }else{ $identificador=0; }
	// echo $identificador;

	$nav1='';
	$nav2='';
	$nav3='';
	$nav4='';
	$nav5='';
	$nav6='';
	$nav7='';
	$nav8='';
	$nav9='';

switch ($identificador) {
	// Inicio
	case 1:
		$nav1='uk-active';
		include 'includes/includes.php';
		include 'es/inicio.php';
		break;

	case 2:
		$nav2='uk-active';
		include 'includes/includes.php';
		include 'es/cursos.php';
		break;

	case 3:
		$nav3='uk-active';
		include 'includes/includes.php';
		include 'es/inscripcion.php';
		break;

	case 4:
		$nav4='uk-active';
		include 'includes/includes.php';
		include 'es/pagos.php';
		break;

	case 5:
		$nav5='uk-active';
		include 'includes/includes.php';
		include 'es/sede.php';
		break;

	case 6:
		$nav6='uk-active';
		include 'includes/includes.php';
		include 'es/tyh.php';
		break;

	case 7:
		$nav6='uk-active';
		include 'includes/includes.php';
		include 'es/tyh-hospedaje.php';
		break;

	case 8:
		$nav6='uk-active';
		include 'includes/includes.php';
		include 'es/tyh-transporte.php';
		break;

	case 10:
		// Iscripción exitosa
		$nav3='uk-active';
		$id=$_GET['id'];
		$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $id");
		$row_USER = $USER -> fetch_assoc();
		$mensajeClase='success';
		$mensaje='<h1>Se ha registrado con éxito, favor de realizar su pago.<h1><h2>Nombre: '.$row_USER['nombre'].' '.$row_USER['apellido'].'<br>Número de estudiante: '.$id.'</h2>';
		include 'includes/includes.php';
		include 'es/pagos.php';
		break;

	case 11:
		$nav3='uk-active';
		include 'includes/includes.php';
		include 'es/inscripcion-danger.php';
		break;

	case 12:
		$nav3='uk-active';
		include 'includes/includes.php';
		include 'es/inscripcion-posterior.php';
		break;

	case 13:
		$nav3='uk-active';
		$id=$_GET['id'];
		include 'includes/includes.php';
		include 'es/inscripcion-asiento.php';
		break;

	case 14:
		$nav3='uk-active';
		$mensajeClase='success';
		$mensaje='<h1>No se pudo registrar.<br>Favor de intentar de nuevo</h2>';
		include 'includes/includes.php';
		include 'es/inscripcion-posterior.php';
		break;

	case 15:
		$nav3='uk-active';
		$id=$_GET['id'];
		include 'includes/includes.php';
		include 'es/inscripcion-asiento2.php';
		break;

	case 16:
		$nav3='uk-active';
		$id=$_GET['id'];
		include 'includes/includes.php';
		include 'es/share.php';
		break;



	case 993:
		$id=$_GET['id'];
		include "includes/includes.php";
		include 'includes/verify-comment.php';
		break;

	case 994:
		session_destroy();
		include "includes/includes.php";
		header('location: '.$ruta);
		break;

	case 995:
		if(isset($_GET['consulta'])){ $consulta=$_GET['consulta']; }else{ header( 'Location: '.$ruta); }
		include "includes/includes.php";
		include 'es/search.php';
		break;

	case 996:
		include "includes/includes.php";
		include 'includes/google-verify.php';
		break;

	case 997:
		include "includes/includes.php";
		include 'includes/robots.php';
		break;

	case 998:
		include "includes/includes.php";
		include 'includes/sitemap.php';
		break;

	case 999:
		include 'includes/enviar-contacto.php';
		break;

	default:
		$nav1='uk-active';
		include "includes/includes.php";
		include 'es/inicio.php';
		break;
}

// Borrar Error_log si existe
if (file_exists('error_log')) {
	unlink('error_log');
}

