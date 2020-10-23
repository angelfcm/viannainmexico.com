<?php
// %%%%%%%%%%%%%%%%%%%%%%%%% CONSTANTES	%%%%%%%%%%%%%%%%%%%%%%%%%%%  
	global $caracteres_si_validos;
	global $caracteres_no_validos;
	global $linkToShare;

	$caracteres_si_validos  = array('','','','','','','a','A','e','E','i','I','o','O','u','U','n','N');
	$caracteres_no_validos  = array('|','/','®','¿','"',':','á','Á','é','É','í','Í','ó','Ó','ú','Ú','ñ','Ñ');
	$linkToShare=str_replace('+', '%2B', $rutaEstaPagina);
	$linkToShare=str_replace(':', '%3A', $linkToShare);
	
	$hoy = date('Y-m-d');
	$manana = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
	$mensajeClase=(isset($mensajeClase))?$mensajeClase:'';
	$mensajes=(isset($mensajes))?$mensajes:'';
	$mensaje=(isset($mensaje))?$mensaje:'';

// %%%%%%%%%%%%%%%%%%%%%%%%% MÓVIL O ESCRITORIO	%%%%%%%%%%%%%%%%%%%  
	// Detectamos si es móvil o escritorio
	$navegadorUser = $_SERVER['HTTP_USER_AGENT'];		// Info del navegador
	// Lista de navegadores móviles
	$navegadores_moviles = "Android, AvantGo, Blackberry, Blazer, Cellphone, Danger, DoCoMo, EPOC, EudoraWeb, Handspring, HTC, Kyocera, LG, MMEF20, MMP, MOT-V, Mot, Motorola, NetFront, Newt, Nokia, Opera Mini, Palm, Palm, PalmOS, PlayStation Portable, ProxiNet, Proxinet, SHARP-TQ-GX10, Samsung, Small, Smartphone, SonyEricsson, SonyEricsson, Symbian, SymbianOS, TS21i-10, UP.Browser, UP.Link, WAP, webOS, Windows CE, hiptop, iPhone, iPod, portalmmm, Elaine, OPWV";
	// Almacenar como array
	$navegadores_moviles_array = explode(',',$navegadores_moviles);
	// Ciclo comparativo
	$es_movil=FALSE;
	foreach($navegadores_moviles_array AS $navegadorList){
		if ($es_movil===FALSE) {
			$es_movil=(preg_match("/".trim($navegadorList)."/i",$navegadorUser))?TRUE:FALSE;
		}
	}

// %%%%%%%%%%%%%%%%%%%%%%%%% Explorer < 8	%%%%%%%%%%%%%%%%%%%%%%%  
	if(preg_match('/(?i)msie [1-8]/',$navegadorUser)){
		$mensaje='Este sitio está diseñado para navegadores modernos.<br>Vuelva a visitarnos desde Google Chrome, Firefox o su Dispositivo Movil.';
		$mensajeClase='danger';
	}

// %%%%%%%%%%%%%%%%%%%%%%%%% MENSAJES	%%%%%%%%%%%%%%%%%%%%%%%%%%%  
	if($mensaje!=''){
		$mensajes='
			<div class="uk-container">
				<div uk-grid>
					<div class="uk-width-1-1 uk-margin-top">
						'.$mensaje.'
						<br><br>
					</div>
				</div>
			</div>';
	}

// %%%%%%%%%%%%%%%%%%%%%%%%% MENU	%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  

	$rutaCertifica	=	$ruta.'seminarios';
	$rutaInsc		=	$ruta.'inscripcion';
	$rutaPagos		=	$ruta.'pagos';
	$rutaSede		=	$ruta.'sede';
	$rutaTYH		=	$ruta.'hyt';
	$rutaHos		=	$ruta.'hospedaje';
	$rutaTra		=	$ruta.'transporte';


	$CONSULTA3 		= 	$CONEXION -> query("SELECT pices,picen FROM configuracion WHERE id = 10");
	$row_CONSULTA3 	= 	$CONSULTA3 -> fetch_assoc();
	$rutaChina		=	$ruta.'../files/'.$row_CONSULTA3['pices'];
	$rutaOG			=	$rutaSinTraduccion.'img/design/'.$row_CONSULTA3['picen'];
	mysqli_free_result($CONSULTA3);


	$menu='
            <div class="uk-width-auto uk-width-expand@m menu-item uk-flex-middle"><a href="'.$ruta.'" class="uk-flex uk-flex-middle uk-flex-center bg-secondary color-blanco '.$nav1.'">'.$menuInicio.'</a></div>
            <div class="uk-width-auto uk-width-expand@m menu-item uk-flex-middle"><a href="'.$rutaCertifica.'" class="uk-flex uk-flex-middle uk-flex-center bg-secondary color-blanco '.$nav2.'">'.$menuCert.'</a></div>
            <div class="uk-width-auto uk-width-expand@m menu-item uk-flex-middle"><a href="'.$rutaInsc.'" class="uk-flex uk-flex-middle uk-flex-center bg-secondary color-blanco '.$nav3.'">'.$menuInsc.'</a></div>
            <!-- <div class="uk-width-auto uk-width-expand@m menu-item uk-flex-middle"><a href="'.$rutaPagos.'" class="uk-flex uk-flex-middle uk-flex-center bg-secondary color-blanco '.$nav4.'">'.$menuPagos.'</a></div> -->
            <div class="uk-width-auto uk-width-expand@m menu-item uk-flex-middle"><a href="'.$rutaSede.'" class="uk-flex uk-flex-middle uk-flex-center bg-secondary color-blanco '.$nav5.'">'.$menuCiudad.'</a></div>
            <div class="uk-width-auto uk-width-expand@m menu-item uk-flex-middle"><a href="'.$rutaTYH.'" class="uk-flex uk-flex-middle uk-flex-center bg-secondary color-blanco '.$nav5.'">'.$menuTransporte.'</a></div>';


	$menuMovil='
            <li><a href="'.$ruta.'" class="'.$nav1.'">'.$menuInicio.'</a></li>
            <li><a href="'.$rutaCertifica.'" class="'.$nav2.'">'.$menuCert.'</a></li>
            <li><a href="'.$rutaInsc.'" class="'.$nav3.'">'.$menuInsc.'</a></li>
            <li><a href="'.$rutaPagos.'" class="'.$nav4.'">'.$menuPagos.'</a></li>
            <li><a href="'.$rutaSede.'" class="'.$nav5.'">'.$menuCiudad.'</a></li>
            <li><a href="'.$rutaTYH.'" class="'.$nav5.'">'.$menuTransporte.'</a></li>';

// %%%%%%%%%%%%%%%%%%%%%%%%% HEADER	%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  
	$header='
	<div class="uk-offcanvas-content">
		<header>
			<div class="uk-width-1-1 padding-bottom-20 bg-primary">
				<div class="uk-width-1-1 color-blanco bg-secondary uk-text-light uk-text-center">
					'.$headtxt.'
				</div>

				<!-- Movil -->
				<div class="uk-hidden@m padding-v-20">
					<div class="uk-container uk-container-expand">
						<div uk-grid class="uk-grid-collapse uk-grid-match">
							<div>
								<div class="padding-v-10">
									<a href="#menu-movil" uk-toggle class="color-primary">
										&nbsp;&nbsp; <span uk-icon="icon:menu;ratio:2.8"></span>
									</a>
								</div>
							</div>
							<div class="uk-width-expand uk-text-center">
								<div class="padding-top-10">
									<a href="'.$ruta.'">
										<img src="'.$logo.'" width="407px" height="79px" alt="'.$Brand.'">
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Escritorio -->
				<div class="uk-container">
					<div uk-grid class="uk-child-width-expand@m">
						<div class="uk-text-center uk-text-left@m uk-visible@m padding-v-20">
							<img src="'.$logo.'" id="logo" width="407px" height="79px" alt="'.$Brand.'"></a>
						</div>
						<div class="uk-width-1-2@m uk-text-right@m uk-text-center padding-v-20">
							<div uk-grid class="uk-grid-small">
								<div class="uk-width-2-5@m uk-width-1-1 uk-visible@m">
									&nbsp;
								</div>
								<div class="uk-width-expand uk-text-center uk-text-uppercase uk-text-bold color-gris">
									&nbsp;&nbsp; '.$selectLang.'
								</div>
								<div class="uk-width-1-1" id="flags">
' . (IS_RUSSIAN_DOMAIN && false /* Nota el "&& false". Petición del cliente (quizás temporal) para mejor usar el mismo dominio de dónde se está accediendo... */ ? 
'									<a href="http://viannainmexico.com/en/"><img src="../img/design/idioma/en.png" width="40px" height="40px" alt="bandera USA"></a> &nbsp;
									<a href="http://viannainmexico.com/ja/"><img src="../img/design/idioma/ja.png" width="40px" height="40px" alt="bandera Japon"></a> &nbsp;
									<a href="'.str_replace('/'.$languaje.'/', '/ru/', $_SERVER["REQUEST_URI"]).'"><img src="../img/design/idioma/ru.png" width="40px" height="40px" alt="bandera Rusia"></a> &nbsp;
									<a href="http://viannainmexico.com/pt/"><img src="../img/design/idioma/pt.png" width="40px" height="40px" alt="bandera Brasil"></a> &nbsp;
									<a href="http://viannainmexico.com/it/"><img src="../img/design/idioma/tr.png" width="40px" height="40px" alt="bandera Italia"></a> &nbsp;
									<a href="http://viannainmexico.com/es/"><img src="../img/design/idioma/es.png" width="40px" height="40px" alt="bandera Mexico"></a> &nbsp;
									<a href="'.$rutaChina.'" target="_blank"><img src="../img/design/idioma/ch.png" width="40px" height="40px" alt="bandera taiwan"></a>	
' : '
									<a href="'.str_replace('/'.$languaje.'/', '/en/', $_SERVER["REQUEST_URI"]).'"><img src="../img/design/idioma/en.png" width="40px" height="40px" alt="bandera USA"></a> &nbsp;
									<a href="'.str_replace('/'.$languaje.'/', '/ja/', $_SERVER["REQUEST_URI"]).'"><img src="../img/design/idioma/ja.png" width="40px" height="40px" alt="bandera Japon"></a> &nbsp;
									<a href="http://viannainmexico.ru"><img src="../img/design/idioma/ru.png" width="40px" height="40px" alt="bandera Rusia"></a> &nbsp;
									<a href="'.str_replace('/'.$languaje.'/', '/pt/', $_SERVER["REQUEST_URI"]).'"><img src="../img/design/idioma/pt.png" width="40px" height="40px" alt="bandera Brasil"></a> &nbsp;
									<a href="'.str_replace('/'.$languaje.'/', '/it/', $_SERVER["REQUEST_URI"]).'"><img src="../img/design/idioma/tr.png" width="40px" height="40px" alt="bandera Italia"></a> &nbsp;
									<a href="'.str_replace('/'.$languaje.'/', '/es/', $_SERVER["REQUEST_URI"]).'"><img src="../img/design/idioma/es.png" width="40px" height="40px" alt="bandera Mexico"></a> &nbsp;
									<a href="'.$rutaChina.'" target="_blank"><img src="../img/design/idioma/ch.png" width="40px" height="40px" alt="bandera taiwan"></a>
') . '
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-1 padding-v-20">
				<div class="uk-container">
					<nav id="main-nav">
						<div uk-grid class="uk-child-width-expand uk-grid-small uk-grid-match uk-text-uppercase uk-text-center condensed uk-flex-center">
							'.$menu.'
						</div>
					</nav>
				</div>
			</div>
		</header>

		<!-- Off-canvas -->
		<div id="menu-movil" uk-offcanvas="mode: push;overlay: true">
			<div class="uk-offcanvas-bar uk-flex uk-flex-column">
				<button class="uk-offcanvas-close" type="button" uk-close></button>
				<ul class="uk-nav uk-nav-primary uk-nav-parent-icon uk-nav-center uk-margin-auto-vertical uk-text-uppercase nfl" uk-nav>
					'.$menuMovil.'
				</ul>
			</div>
		</div>
		<section>
		'.$mensajes;

// %%%%%%%%%%%%%%%%%%%%%%%%% FOOTER	%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  
	$footer = '
			</section>
			<footer class="padding-v-50">
				<div class="uk-container">
					<div class="uk-grid-small uk-grid-divider uk-child-width-expand@s uk-text-center" uk-grid>
						<div class="uk-text-right@s">
							<a href="http://mundoth.com/" target="_blank"><img src="../img/design/logo-mundo.png" class="" alt="logo mundo theta healing"></a><br>
							<a href="http://mundoth.com/" target="_blank">www.mundoth.com</a><br>
							contacto@mundoth.com<br>
							<span class="uk-text-capitalize">'.$oficina.'</span>: <a href="tel:'.$telefono1.'" >'.$telefonoSeparado1.'</a><br>
							<span>'.$whatsapp.'</span>: <a href="tel:'.$telefono.'" >'.$telefonoSeparado.'</a>
						</div>
						<div class="uk-width-1-2@s">
							<div class="uk-grid-small uk-text-center" uk-grid>
								<div class="uk-width-1-3">
									<img src="../img/design/logo-think.png" class="" alt="logo think theta healing" width="100px" height="117px">
								</div>
								<div class="uk-width-2-3">
									<br><br>
									<img src="../img/design/logo-inverse.png" class="" alt="logo theta healing" width="280px" height="54px">
								</div>
							</div>
						</div>
						<div id="social" class="padding-v-20 uk-text-center">
							<a href="'.$socialFacebook.'" target="_blank"><i uk-icon="icon:facebook;ratio:2;"></i></a> &nbsp;
							<a href="'.$socialTwitter.'" target="_blank"><i uk-icon="icon:twitter;ratio:2;"></i></a> &nbsp;
							<a href="'.$socialInstagram.'" target="_blank"><i uk-icon="icon:instagram;ratio:2;"></i></a>
						</div>
					</div>
				</div>
			</footer>
		</div>
		';
	
	$obsoleto='<img src="../img/design/logo-white.png" alt="'.$Brand.'">';

// %%%%%%%%%%%%%%%%%%%%%%%%% SCRIPTS	%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$hrefLangen=($languaje!='en')?'<link rel="alternate" hreflang="en" href="'.$dominio.str_replace('/'.$languaje.'/', '/en/', $_SERVER["REQUEST_URI"]).'">':'';
	$hrefLangja=($languaje!='ja')?'<link rel="alternate" hreflang="ja" href="'.$dominio.str_replace('/'.$languaje.'/', '/ja/', $_SERVER["REQUEST_URI"]).'">':'';
	$hrefLangru=($languaje!='ru')?'<link rel="alternate" hreflang="ru" href="'.$dominio.str_replace('/'.$languaje.'/', '/ru/', $_SERVER["REQUEST_URI"]).'">':'';
	$hrefLangpt=($languaje!='pt')?'<link rel="alternate" hreflang="pt" href="'.$dominio.str_replace('/'.$languaje.'/', '/pt/', $_SERVER["REQUEST_URI"]).'">':'';
	$hrefLangit=($languaje!='it')?'<link rel="alternate" hreflang="it" href="'.$dominio.str_replace('/'.$languaje.'/', '/it/', $_SERVER["REQUEST_URI"]).'">':'';
	$hrefLanges=($languaje!='es')?'<link rel="alternate" hreflang="es" href="'.$dominio.str_replace('/'.$languaje.'/', '/es/', $_SERVER["REQUEST_URI"]).'">':'';


	$headGNRL='
		<meta name="viewport" content="width=device-width, initial-scale=1">
		'.$hrefLangen.'
		'.$hrefLangja.'
		'.$hrefLangru.'
		'.$hrefLangpt.'
		'.$hrefLangit.'
		'.$hrefLanges.'

		<link rel="icon" 			href="../img/design/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" 	href="../img/design/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" 		href="../css/general.css?'.rand(1,999).'">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.28/css/uikit.css">

		';

	$scriptGNRL='

		<!-- jQuery is required -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- UIkit JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.28/js/uikit.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.28/js/uikit-icons.min.js"></script>

		<script type="application/ld+json">
			{
				"@context": "http://schema.org/",
				"@type": "Organization",
				"legalName": "'.$Brand.'",
				"url": "'.$ruta.'",
				"logo": "'.$logo.'",
				"telephone": "'.$telefonoSeparado.'",
				"sameAs" : [
					"'.$socialFacebook.'"
				]
			}
		</script>
		';

	$obsoleto='
		<script>
			$("#search").keyup(function(e){
				if(e.which==13){
					var consulta=$("#search").val();
					if(consulta!=""){
						console.log(consulta);
						window.location = ("'.$ruta.'"+consulta+"-BUSCAR.php");
					}
				}
			})
			$( "#search" ).click(function() {
				var consulta=$("#search").val();
				if(consulta!=""){
					console.log(consulta);
					window.location = ("'.$ruta.'"+consulta+"-BUSCAR.php");
				}
			});
		</script>
		';

		$facebookLogin='
			<script>
			  window.fbAsyncInit = function() {
			    FB.init({
			      appId      : \'{your-app-id}\',
			      cookie     : true,
			      xfbml      : true,
			      version    : \'{latest-api-version}\'
			    });
			    FB.AppEvents.logPageView();   
			  };

			  (function(d, s, id){
			     var js, fjs = d.getElementsByTagName(s)[0];
			     if (d.getElementById(id)) {return;}
			     js = d.createElement(s); js.id = id;
			     js.src = "//connect.facebook.net/en_US/sdk.js";
			     fjs.parentNode.insertBefore(js, fjs);
			   }(document, \'script\', \'facebook-jssdk\'));
			</script>


			<-- Comprobar el estado del inicio de sesión -->
			FB.getLoginStatus(function(response) {
			    statusChangeCallback(response);
			});

			<-- El objeto response -->
			{
			    status: \'connected\',
			    authResponse: {
			        accessToken: \'...\',
			        expiresIn:\'...\',
			        signedRequest:\'...\',
			        userID:\'...\'
			    }
			}

			<-- Agregar el botón -->
			<fb:login-button 
			  scope="public_profile,email"
			  onlogin="checkLoginState();">
			</fb:login-button>

			';

