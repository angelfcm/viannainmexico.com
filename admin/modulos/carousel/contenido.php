<?php 
// Animación
	$anim0='';
	$anim1='';
	$anim2='';
	$anim3='';
	$anim4='';
	$anim5='';
	$anim6='';
	$anim7='';
	$ANIM = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
	$rowANIM = $ANIM -> fetch_assoc();
	switch ($rowANIM['num1']) {
		case 0:
			$anim0=' selected';
			break;
		case 1:
			$anim1=' selected';
			break;
		case 2:
			$anim2=' selected';
			break;
		case 3:
			$anim3=' selected';
			break;
		case 4:
			$anim4=' selected';
			break;
		case 5:
			$anim5=' selected';
			break;
		case 6:
			$anim6=' selected';
			break;
		case 7:
			$anim7=' selected';
			break;
	}

// anchocarousel del carrusel
	$anchocarousel0='';
	$anchocarousel1='';
	switch ($rowANIM['num2']) {
		case 0:
			$anchocarousel0=' selected';
			break;
		case 1:
			$anchocarousel1=' selected';
			break;
	}

	echo '
	<div class="uk-width-1-1 margen-top-20 uk-text-left">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?seccion='.$seccion.'" class="color-red uk-text-capitalize">'.$seccion.'</a></li>
		</ul>
	</div>
	<div class="uk-width-1-2 margen-top-20 uk-text-left">
		<div>
			<a href="index.php?seccion=carouselmovil" class="uk-button uk-button-large uk-button-primary">Carrusel movil</a>
		</div>
		<div class="margen-top-20">
			<label for="animacion" class="uk-form-label">Animación</label>
		</div>
		<div>
			<select name="animacion" id="animacion" class="uk-select uk-width-1-1">
				<option value="0" '.$anim0.'>Desvanecer</option>
				<option value="1" '.$anim1.'>Desplazar</option>
				<option value="2" '.$anim2.'>Rebote</option>
				<option value="3" '.$anim3.'>Persiana</option>
				<option value="4" '.$anim4.'>Rebanada</option>
				<option value="5" '.$anim5.'>Bloques</option>
				<option value="6" '.$anim6.'>Mosaico</option>
				<option value="7" '.$anim7.'>Ninguno</option>
			</select>
		</div>
		<div class="uk-margin-top">
			<label for="anchocarousel" class="uk-form-label">Ancho del carrusel</label>
		</div>
		<div>
			<select name="anchocarousel" id="anchocarousel" class="uk-select uk-width-1-1">
				<option value="0" '.$anchocarousel0.'>Ancho completo</option>
				<option value="1" '.$anchocarousel1.'>Con margen</option>
			</select>
		</div>
	</div>
	';
?>

<div class="uk-width-1-2 margen-top-50 uk-text-left">
	<p class="uk-text-muted">Dimensiones aconsejadas:<br> 1900 x 735 px si usará ancho completo<br> 1100 x 420 px si llevará margen</p>
	<div id="fileuploader">
		Cargar
	</div>
</div>

<?php 
$languajeButton[$languaje]='uk-button-secondary';
$tabla='carousel'.$languaje;

echo '
<!-- Selección de idioma -->
<div class="uk-width-1-1 uk-text-center">
    <a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&languaje=es" class="margen-top-20 uk-button '.$languajeButton['es'].'">Español</a>
    <a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&languaje=en" class="margen-top-20 uk-button '.$languajeButton['en'].'">Inglés</a>
    <a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&languaje=ja" class="margen-top-20 uk-button '.$languajeButton['ja'].'">Japonés</a>
    <a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&languaje=ru" class="margen-top-20 uk-button '.$languajeButton['ru'].'">Ruso</a>
    <a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&languaje=pt" class="margen-top-20 uk-button '.$languajeButton['pt'].'">Portugues</a>
    <a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&languaje=it" class="margen-top-20 uk-button '.$languajeButton['it'].'">Húngaro</a>
</div>
';
?>

<div class="uk-width-1-1 margen-top-20">
	<div id="sort" uk-grid class="uk-grid-match uk-grid-small">

	<?php 
	$ruta="../img/contenido/".$tabla."/";

	$images = $CONEXION -> query("SELECT * FROM $tabla ORDER BY orden");
	while ($row_images = $images -> fetch_assoc()) {
	echo '
		<div id="'.$row_images['id'].'" class="uk-width-1-5@l uk-width-1-4@m uk-width-1-3@s">
			<div id="'.$row_images['id'].'" class="uk-card uk-card-default uk-card-body uk-text-center">
				<a 
					href="#config"
					uk-toggle
					class="cfg uk-icon-button uk-button-primary" 
					data-cfgid="'.$row_images['id'].'" 
					data-titulo="'.$row_images['titulo'].'"
					data-txt="'.$row_images['txt'].'"
					data-url="'.$row_images['url'].'"
					uk-icon="icon:cog">
				</a>
				&nbsp;
				<a href="javascript:eliminaPic(id='.$row_images['id'].')" class="uk-icon-button uk-button-danger" uk-icon="icon:trash;"></a> <br><br>
				<a href="'.$ruta.$row_images['id'].'-orig.jpg" target="_blank">
					<img src="'.$ruta.$row_images['id'].'-orig.jpg" class="img-responsive uk-border-rounded margen-bottom-20">
				</a>
			</div>
		</div>
	';
	}
	?>

	</div>
</div>


<div id="config" class="modal" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<a href="" class="uk-modal-close uk-close"></a>
		<div class="uk-modal-header">
			Configurar imagen
		</div>
		<form action="index.php" method="post" class="uk-width-1-1" name="datos" onsubmit="return checkForm(this);">
			<input type="hidden" name="editar" value="1">
			<input type="hidden" name="seccion" value="<?=$seccion?>">
			<input type="hidden" name="id" id="cfgid" value="">
			<div uk-grid>
				<div class="uk-width-1-2 uk-margin-top">
					<label for="titulo">Titulo </label>
					<input type="text" id="titulo" name="titulo" class="uk-input">
				</div>
				<div class="uk-width-1-2 uk-margin-top">
					<label for="url">Link</label>
					<input type="text" id="url" name="url" class="uk-input">
				</div>
				<div class="uk-width-1-1 uk-margin-top">
					<label for="txt">Descripción</label>
					<textarea id="txt" name="txt" class="uk-textarea"></textarea>
				</div>
				<div class="uk-width-1-1 uk-margin-top uk-text-center">
					<a href="" class="uk-button uk-button-default uk-modal-close uk-button-large" tabindex="10">Cancelar</a>
					<button class="uk-button uk-button-primary uk-button-large">Guardar</button>
				</div>
			</div>
		</form>
	</div>
</div>


