
<div class="uk-width-1-1 margen-top-20">
	<ul class="uk-breadcrumb">
		<?php
		echo '
		<li><a href="index.php?seccion='.$seccion.'&subseccion=contenido&cat='.$cat.'">Cursos</a></li>
		<li class="color-red">Nuevo</li>
';
		?>
	</ul>
</div>

<div class="uk-width-1-1">
	<h3>Título en sus diferentes idiomas</h3>
	<p class="uk-text-muted">En el siguiente paso se agregan imágenes e información</p>
</div>

<form action="index.php" class="uk-width-1-1" method="post" name="editar" onsubmit="return checkForm(this);">
	<input type="hidden" name="nuevo" value="1">
	<input type="hidden" name="seccion" value="<?=$seccion?>">

	<div uk-grid>
		<div class="uk-width-1-2">
			<div class="uk-margin-top">
				<label for="tituloes">Español</label>
				<input type="text" class="uk-input" name="tituloes" value="" autofocus required>
			</div>
			<div class="uk-margin-top">
				<label for="tituloja">Japones</label>
				<input type="text" class="uk-input" name="tituloja" value="" required>
			</div>
			<div class="uk-margin-top">
				<label for="titulopt">Portugues</label>
				<input type="text" class="uk-input" name="titulopt" value="" required>
			</div>
		</div>
		<div class="uk-width-1-2">
			<div class="uk-margin-top">
				<label for="tituloen">Inglés</label>
				<input type="text" class="uk-input" name="tituloen" value="" required>
			</div>
			<div class="uk-margin-top">
				<label for="tituloru">Ruso</label>
				<input type="text" class="uk-input" name="tituloru" value="" required>
			</div>
			<div class="uk-margin-top">
				<label for="tituloit">Húngaro</label>
				<input type="text" class="uk-input" name="tituloit" value="" required>
			</div>
		</div>
		<div class="uk-width-1-1">
			<div class="uk-margin-top uk-text-center">
				<a href="index.php?seccion=<?=$seccion?>&subseccion=contenido" class="uk-button uk-button-default uk-button-large" tabindex="10">Cancelar</a>					
				<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
			</div>
		</div>
	</div>
</form>


<?php $scripts='
$(function(){
	$("#datepicker").datepicker();
	$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
});
'; ?>