<?php 
function formulario($variable){
	global $CONEXION;
	$CONSULTA = $CONEXION -> query("SELECT * FROM traduccion WHERE variable = '$variable'");
	$row_CONSULTA = $CONSULTA -> fetch_assoc();
	return '
	<div class="uk-width-1-1 margen-top-20">
		<div class="uk-card uk-card-default uk-card-body">
			<div uk-grid class="uk-grid-small uk-child-width-expand">
				<div class="uk-width-1-1">
					'.$row_CONSULTA['es'].'
				</div>
				<div>
					<label>Español</label>
					<input type="text" class="uk-input uk-form-width-medium" id="'.$variable.'es" value="'.$row_CONSULTA['es'].'">
				</div>
				<div>
					<label>Inglés</label>
					<input type="text" class="uk-input uk-form-width-medium" id="'.$variable.'en" value="'.$row_CONSULTA['en'].'">
				</div>
				<div>
					<label>Japonés</label>
					<input type="text" class="uk-input uk-form-width-medium" id="'.$variable.'ja" value="'.$row_CONSULTA['ja'].'">
				</div>
				<div>
					<label>Ruso</label>
					<input type="text" class="uk-input uk-form-width-medium" id="'.$variable.'ru" value="'.$row_CONSULTA['ru'].'">
				</div>
				<div>
					<label>Portugés</label>
					<input type="text" class="uk-input uk-form-width-medium" id="'.$variable.'pt" value="'.$row_CONSULTA['pt'].'">
				</div>
				<div>
					<label>Húngaro</label>
					<input type="text" class="uk-input uk-form-width-medium" id="'.$variable.'it" value="'.$row_CONSULTA['it'].'">
				</div>
				<div>
					<br>
					<button id="'.$variable.'save" class="uk-button uk-button-white">Guardar</button>
				</div>
			</div>
		</div>
	</div>';
    mysqli_free_result($CONSULTA);
}
function ajaxQuery($variable){
	return '
	<script>
		$("#'.$variable.'save").click(function(){
			var es=$("#'.$variable.'es").val();
			var en=$("#'.$variable.'en").val();
			var ja=$("#'.$variable.'ja").val();
			var ru=$("#'.$variable.'ru").val();
			var pt=$("#'.$variable.'pt").val();
			var it=$("#'.$variable.'it").val();
			$.ajax({
				method: "POST",
				url: "modulos/hyt/acciones.php",
				data: { 
					save: 1,
					variable: "'.$variable.'",
					es: es,
					en: en,
					ja: ja,
					ru: ru,
					pt: pt,
					it: it
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg);
			});
		})
	</script>
	';
}
function pics($position,$size,$titulo){
	global $CONEXION;
	$CONSULTA = $CONEXION -> query("SELECT * FROM configuracion WHERE id = $position");
	$row_CONSULTA = $CONSULTA -> fetch_assoc();
	return '
		<div class="uk-width-1-1 uk-text-center">
			<div class="uk-card uk-card-default uk-card-body">
				<h4>'.$titulo.'</h4>
				<div class="uk-width-1-1 uk-text-center">
					<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-position="'.$position.'" data-languaje="es" data-size="'.$size.'" uk-tooltip title="<img src=\'../img/contenido/varios/'.$row_CONSULTA['pices'].'\'>">Español</a>
					<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-position="'.$position.'" data-languaje="en" data-size="'.$size.'" uk-tooltip title="<img src=\'../img/contenido/varios/'.$row_CONSULTA['picen'].'\'>">Inglés</a>
					<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-position="'.$position.'" data-languaje="ja" data-size="'.$size.'" uk-tooltip title="<img src=\'../img/contenido/varios/'.$row_CONSULTA['picja'].'\'>">Japonés</a>
					<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-position="'.$position.'" data-languaje="ru" data-size="'.$size.'" uk-tooltip title="<img src=\'../img/contenido/varios/'.$row_CONSULTA['picru'].'\'>">Ruso</a>
					<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-position="'.$position.'" data-languaje="pt" data-size="'.$size.'" uk-tooltip title="<img src=\'../img/contenido/varios/'.$row_CONSULTA['picpt'].'\'>">Portugues</a>
					<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-position="'.$position.'" data-languaje="it" data-size="'.$size.'" uk-tooltip title="<img src=\'../img/contenido/varios/'.$row_CONSULTA['picit'].'\'>">Húngaro</a>
				</div>
				<img src="../img/contenido/varios/'.$row_CONSULTA['pices'].'" class="uk-hidden">
				<img src="../img/contenido/varios/'.$row_CONSULTA['picen'].'" class="uk-hidden">
				<img src="../img/contenido/varios/'.$row_CONSULTA['picja'].'" class="uk-hidden">
				<img src="../img/contenido/varios/'.$row_CONSULTA['picru'].'" class="uk-hidden">
				<img src="../img/contenido/varios/'.$row_CONSULTA['picpt'].'" class="uk-hidden">
				<img src="../img/contenido/varios/'.$row_CONSULTA['picit'].'" class="uk-hidden">
			</div>
		</div>';
    mysqli_free_result($CONSULTA);
}



echo '
	<div class="uk-width-1-1">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?seccion='.$seccion.'" class="color-red">Hospedaje y Transporte</a></li>
		</ul>
	</div>';

$activo[0]='';
$activo[1]='';
$activo[2]='';
if (isset($_POST['activo'])) {
	$activo[$_POST['activo']]='uk-active';
}
echo '
<div class="uk-width-1-1">
	<ul class="uk-subnav uk-subnav-pill" uk-switcher>
		<li class="'.$activo[0].'"><a href="#">Selección</a></li>
		<li class="'.$activo[1].'"><a href="#">Hospedaje</a></li>
		<li class="'.$activo[2].'"><a href="#">Transporte</a></li>
	</ul>
	<ul class="uk-switcher uk-margin">
		<li>';
			echo formulario('menuTransporte');
			echo formulario('hospedaje');
			echo formulario('transporte');
			echo formulario('vuelosdirectos');
			echo pics(7,'500px x 500px','Mapa de vuelos');

			echo '
		</li>
		<li>';
			echo formulario('hospedajetitle');
			// HOTELES DE CABECERA
			$position=8;
			$size='800px x 500px';
			$sizeLogo='260px x 70px';
			$CONSULTA = $CONEXION -> query("SELECT * FROM configuracion WHERE id = $position");
			$row_CONSULTA = $CONSULTA -> fetch_assoc();
			echo '
			<div class="uk-width-1-1 uk-text-center">
				<div class="uk-card uk-card-default uk-card-body">
					<h4>Cabecera de hospedaje</h4>
					<div class="uk-width-1-1 uk-text-center">
						<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-position="'.$position.'" data-languaje="es" data-size="'.$size.'" uk-tooltip title="<img src=\'../img/contenido/varios/'.$row_CONSULTA['pices'].'\'>">Foto hotel 1</a>
						<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-position="'.$position.'" data-languaje="en" data-size="'.$sizeLogo.'" uk-tooltip title="<img src=\'../img/contenido/varios/'.$row_CONSULTA['picen'].'\'>">Logo hotel 1</a>
						<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-position="'.$position.'" data-languaje="ja" data-size="'.$size.'" uk-tooltip title="<img src=\'../img/contenido/varios/'.$row_CONSULTA['picja'].'\'>">Foto hotel 2</a>
						<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-position="'.$position.'" data-languaje="ru" data-size="'.$sizeLogo.'" uk-tooltip title="<img src=\'../img/contenido/varios/'.$row_CONSULTA['picru'].'\'>">Logo hotel 2</a>
					</div>
					<img src="../img/contenido/varios/'.$row_CONSULTA['pices'].'" class="uk-hidden">
					<img src="../img/contenido/varios/'.$row_CONSULTA['picen'].'" class="uk-hidden">
					<img src="../img/contenido/varios/'.$row_CONSULTA['picja'].'" class="uk-hidden">
					<img src="../img/contenido/varios/'.$row_CONSULTA['picru'].'" class="uk-hidden">
				</div>
			</div>';
	    	mysqli_free_result($CONSULTA);

			echo '
			<div class="uk-width-1-1 margen-top-20">
				<div class="uk-card uk-card-default uk-card-body">
					<form class="uk-widht-1-1" action="index.php" method="post">
						<input type="hidden" name="hoteles1" value="1">
						<input type="hidden" name="seccion" value="hyt">
						<input type="hidden" name="activo" value="1">
						<input type="hidden" name="id" value="'.$row_CONSULTA['id'].'">
						<div class="uk-width-1-1">
							<h5>Datos del hotel 1</h5>
						</div>
						<div uk-grid class="uk-grid-small uk-child-width-expand">
							<div>
								<label>Dirección</label>
								<input type="text" class="uk-input" name="cursotextoes" value="'.$row_CONSULTA['cursotextoes'].'">
							</div>
							<div>
								<label>Teléfono</label>
								<input type="text" class="uk-input" name="cursotextoen" value="'.$row_CONSULTA['cursotextoen'].'">
							</div>
							<div>
								<label>Website</label>
								<input type="text" class="uk-input" name="cursotextoja" value="'.$row_CONSULTA['cursotextoja'].'">
							</div>
							<div>
								<label>Mapa</label>
								<input type="text" class="uk-input" name="cursotextoru" value="'.$row_CONSULTA['cursotextoru'].'">
							</div>
							<div>
								<br>
								<button class="uk-button uk-button-white">Guardar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="uk-width-1-1 margen-top-20">
				<div class="uk-card uk-card-default uk-card-body">
					<form class="uk-widht-1-1" action="index.php" method="post">
						<input type="hidden" name="hoteles2" value="1">
						<input type="hidden" name="seccion" value="hyt">
						<input type="hidden" name="activo" value="1">
						<input type="hidden" name="id" value="'.$row_CONSULTA['id'].'">
						<div class="uk-width-1-1">
							<h5>Datos del hotel 2</h5>
						</div>
						<div uk-grid class="uk-grid-small uk-child-width-expand">
							<div>
								<label>Dirección</label>
								<input type="text" class="uk-input" name="pagoses" value="'.$row_CONSULTA['pagoses'].'">
							</div>
							<div>
								<label>Teléfono</label>
								<input type="text" class="uk-input" name="pagosen" value="'.$row_CONSULTA['pagosen'].'">
							</div>
							<div>
								<label>Website</label>
								<input type="text" class="uk-input" name="pagosja" value="'.$row_CONSULTA['pagosja'].'">
							</div>
							<div>
								<label>Mapa</label>
								<input type="text" class="uk-input" name="pagosru" value="'.$row_CONSULTA['pagosru'].'">
							</div>
							<div>
								<br>
								<button class="uk-button uk-button-white">Guardar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="uk-width-1-1 padding-v-50" id="sortable">
			';

			echo formulario('hotel2');
			echo formulario('moreOptions');

			$CONSULTA = $CONEXION -> query("SELECT * FROM hoteles ORDER BY orden");
			while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
				echo '
				<div id="'.$row_CONSULTA['id'].'" class="uk-width-1-1 margen-top-20">
					<div class="uk-card uk-card-default uk-card-body">
						<form class="uk-widht-1-1" action="index.php" method="post">
							<input type="hidden" name="hoteles" value="1">
							<input type="hidden" name="seccion" value="hyt">
							<input type="hidden" name="activo" value="1">
							<input type="hidden" name="id" value="'.$row_CONSULTA['id'].'">
							<div class="uk-width-1-1">
								<h5>'.$row_CONSULTA['titulo'].'</h5>
							</div>
							<div uk-grid class="uk-grid-large uk-child-width-expand">
								<div>
									<label>titulo</label>
									<input type="text" class="uk-input" name="titulo" value="'.$row_CONSULTA['titulo'].'">
								</div>
								<div>
									<label>Website</label>
									<input type="text" class="uk-input" name="url" value="'.$row_CONSULTA['url'].'">
								</div>
								<div>
									<br>
									<button class="uk-button uk-button-white">Guardar</button>
									<a href="#" class="borrar uk-button uk-button-danger" data-id="'.$row_CONSULTA['id'].'">Borrar</a>
								</div>
							</div>
						</form>
					</div>
				</div>';
			}
			echo'
			</div>
			<div class="uk-width-1-1 margen-top-20">
				<div class="uk-card uk-card-default uk-card-body">
					<form class="uk-widht-1-1" action="index.php" method="post">
						<input type="hidden" name="hotelesnew" value="1">
						<input type="hidden" name="seccion" value="hyt">
						<input type="hidden" name="activo" value="1">
						<div class="uk-width-1-1">
							<h5>Nuevo hotel</h5>
						</div>
						<div uk-grid class="uk-grid-large uk-child-width-expand">
							<div>
								<label>titulo</label>
								<input type="text" name="titulo" class="uk-input">
							</div>
							<div>
								<label>Website</label>
								<input type="text" name="url" class="uk-input">
							</div>
							<div>
								<br>
								<button class="uk-button uk-button-white">Agregar</button>
							</div>
						</div>
					</form>
				</div>
			</div>';



			echo '
		</li>
		<li>';
			echo pics(9,'1200px x 390px','Transporte head');

			$CONSULTA = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 9");
			$row_CONSULTA = $CONSULTA -> fetch_assoc();
			echo '
			<div class="uk-width-1-1 margen-top-20">
				<div class="uk-card uk-card-default uk-card-body">
					<form class="uk-widht-1-1" action="index.php" method="post">
						<input type="hidden" name="configura" value="1">
						<input type="hidden" name="seccion" value="hyt">
						<input type="hidden" name="activo" value="2">
						<input type="hidden" name="id" value="9">
						<h3 class="uk-accordion-title">Español</h3>
						<div class="uk-accordion-content">
							<textarea class="editor" name="es">'.$row_CONSULTA['cursotextoes'].'</textarea>
						</div>
						<br><br>
						<h3 class="uk-accordion-title">Inglés</h3>
						<div class="uk-accordion-content">
							<textarea class="editor" name="en">'.$row_CONSULTA['cursotextoen'].'</textarea>
						</div>
						<br><br>
						<h3 class="uk-accordion-title">Japonés</h3>
						<div class="uk-accordion-content">
							<textarea class="editor" name="ja">'.$row_CONSULTA['cursotextoja'].'</textarea>
						</div>
						<br><br>
						<h3 class="uk-accordion-title">Ruso</h3>
						<div class="uk-accordion-content">
							<textarea class="editor" name="ru">'.$row_CONSULTA['cursotextoru'].'</textarea>
						</div>
						<br><br>
						<h3 class="uk-accordion-title">Portugés</h3>
						<div class="uk-accordion-content">
							<textarea class="editor" name="pt">'.$row_CONSULTA['cursotextopt'].'</textarea>
						</div>
						<br><br>
						<h3 class="uk-accordion-title">Húngaro</h3>
						<div class="uk-accordion-content">
							<textarea class="editor" name="it">'.$row_CONSULTA['cursotextoit'].'</textarea>
						</div>
						<br><br>
						<div>
							<br>
							<button class="uk-button uk-button-white">Guardar</button>
						</div>
					</div>
				</div>
			</div>';


			echo'
		</li>
	</ul>

	<div uk-modal id="pic">
		<div class="uk-modal-dialog">
			<div class="uk-modal-header">
				<h3>Cambiar imagen</h3>
				<input type="hidden" id="languaje">
				<input type="hidden" id="position">
			</div>
			<div class="uk-modal-body">
				<p>Tamaño recomendado <span id="size"></span></p>
				<div id="fileuploader">
					Cargar
				</div>
			</div>
			<div class="uk-modal-footer uk-text-center">
				<a class="uk-button uk-button-white uk-button-large uk-modal-close">Cerrar</a>
			</div>
		</div>
	</div>';

$scripts='';
	$scripts.=ajaxQuery('menuTransporte');
	$scripts.=ajaxQuery('hospedaje');
	$scripts.=ajaxQuery('transporte');
	$scripts.=ajaxQuery('vuelosdirectos');
	$scripts.=ajaxQuery('hospedajetitle');
	$scripts.=ajaxQuery('hotel2');
	$scripts.=ajaxQuery('moreOptions');
	for ($i=1; $i < 11; $i++) { 
		$scripts.=ajaxQuery('hotel'.$i.'link');
	}
	$scripts.='
		<script>
		// Definir lenguaje de la foto
		$(".pic").click(function() {
			$("#languaje").val($(this).attr("data-languaje"));
			$("#position").val($(this).attr("data-position"));
			$("#size").html($(this).attr("data-size"));
		});
		$(document).ready(function() {
			var imagenesArray = [];
			$("#fileuploader").uploadFile({
				url:"../library/upload-file/php/upload.php",
				fileName:"myfile",
				maxFileCount:1,
				allowedTypes: "jpeg,jpg",
				maxFileSize: 6291456,
				showFileCounter: true,
				showPreview:true,
				returnType:"json",
				onSuccess:function(files,data,xhr){ 
					var languaje=$("#languaje").val();
					var position=$("#position").val();
					window.location = ("index.php?seccion='.$seccion.'&position="+position+"&languaje="+languaje+"&imagen="+data);
				}
			});
		});
		</script>

		<script>
		$(".borrar").click(function(e){
			e.preventDefault();
			console.log("hi");
		});
		</script>';

