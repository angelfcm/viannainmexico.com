<?php
echo '
<div class="uk-width-1-1 margen-top-20 uk-text-left">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion=carousel">Carrusel</a></li>
		<li><a href="index.php?seccion=carouselmovil" class="color-red">Carrusel para dispositivos móviles</a></li>
	</ul>
</div>';
?>
<div class="uk-width-1-2 margen-top-50 uk-text-left">
	<p class="uk-text-muted">(Dimensiones aconsejadas: 500 x 800 px)</p>
	<div id="fileuploader">
		Cargar
	</div>
</div>

<?php 
$languajeButton[$languaje]='uk-button-secondary';
$tabla='carouselmovil'.$languaje;

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


