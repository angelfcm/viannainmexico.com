<?php
$jquery='
	<!-- jQuery is required -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- UIkit JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.28/js/uikit.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.28/js/uikit-icons.min.js"></script>

	<!-- JQUERY UI -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


	<!-- Upload Image -->
	<link href="../library/upload-file/css/uploadfile.css" rel="stylesheet">
	<script src="../library/upload-file/js/jquery.uploadfile.js"></script>

	<!-- Botones fijos -->
	<script src="../js/buttons.js"></script>

	<!-- Editor de texto -->
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script src="../js/editor.js"></script>

	';

$menu = '
	<li><a href="index.php?seccion=botones">BOTONES PAYPAL</a></li>
	<li><a href="index.php?seccion=carousel">CARRUSEL</a></li>
	<li><a href="index.php?seccion=sede">CIUDAD SEDE</a></li>
	<li><a href="index.php?seccion=clientes">CLIENTES</a></li>
	<li><a href="index.php?seccion=correos">CORREOS</a></li>
	<li><a href="index.php?seccion=cursos">CURSOS</a></li>
	<li><a href="index.php?seccion=hyt">HOSPEDAJE Y TRANSPORTE</a></li>
	<li><a href="index.php?seccion=metadatos">METADATOS</a></li>
	<li><a href="index.php?seccion=traduccion">TRADUCCIÓN</a></li>
	<li><a href="index.php?seccion=usuarios">USUARIOS</a></li>';


$menuBig='
	<div class="uk-visible@l" uk-grid>
		<div>
			<span><img src="../img/design/logo-login.png"></span>
		</div>
		<div>
			<nav>
				<div class="uk-width-3-4">
					<ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
						'.$menu.'

					</ul>
				</div>
			</nav>
		</div>
		<div>
			<a href="index.php?logout=1" class="uk-icon-button uk-button-danger" uk-icon="icon:unlock;"></a>
		</div>
	</div>
		';

$menuSmall='
	<div id="menu-movil" uk-offcanvas="mode: push; overlay: true">
		<div class="uk-offcanvas-bar uk-flex uk-flex-column">
			<button class="uk-offcanvas-close" type="button" uk-close></button>
			<div class="uk-text-center oscuro">
				<img src="../img/design/logo-white.png">
			</div>
			<ul class="uk-nav uk-nav-primary uk-nav-parent-icon uk-nav-center uk-margin-auto-vertical menu-movil" uk-nav>
				'.$menu.'
			</ul>
			<div class="uk-text-center">
				<a href="index.php?logout=1" class="uk-icon-button uk-button-danger" uk-icon="icon:unlock;"></a>
			</div>
		</div>
	</div>';

$head='
	<!DOCTYPE html>
	<html lang="es">
		<head>
			<meta charset="utf-8">

			<title>Administración</title>

			<meta name="viewport" content="width=device-width, initial-scale=1.0">

			<link rel="shortcut icon" href="../img/design/favicon.ico">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.24/css/uikit.css">
			<link rel="stylesheet" type="text/css"  href="../css/admin.css">

		</head>';
$header='
		<body>
			<div id="admin" class="uk-offcanvas-content">
				<div id="adminmenu">
					<div id="menudisplay" class="uk-height-viewport" uk-sticky>
						<div class="uk-padding">
							'.$menuBig.'
						</div>
					</div>
					'.$menuSmall.'
				</div>
				<div id="admincuerpo">
					<div class="uk-container">
						<div uk-grid>
							<div class="uk-width-auto uk-margin-top uk-hidden@l">
								<button uk-toggle="target: #menu-movil" class="uk-button uk-button-primary"><span uk-icon="icon:menu;ratio:2;"></span></button>
							</div>
						<!-- ///////////////////////////////////////////////// -->
						<!-- /////////////  COMIENZA  CONTENIDO   //////////// -->
						<!-- ///////////////////////////////////////////////// -->
						';

$footer='

						<!-- ///////////////////////////////////////////////// -->
						<!-- /////////////   TERMINA  CONTENIDO   //////////// -->
						<!-- ///////////////////////////////////////////////// -->
						</div>
					</div>
				</div>
			</div>
		</body>
	</html>';

