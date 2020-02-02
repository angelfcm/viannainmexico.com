<form action="index.php" class="uk-width-1-1" method="post" name="editar" onsubmit="return checkForm(this);">

	<ul class="uk-breadcrumb">
		<?php 
		echo '
		<li><a href="index.php?seccion='.$seccion.'">Ciudad sede</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=nuevo" class="color-red">Nuevo</a></li>
		';
		?>
	</ul>
	<div class="uk-text-center">
		<h2>Nuevo</h2>
	</div>
	<div uk-grid>

		<input type="hidden" name="nuevo" value="1">
		<input type="hidden" name="seccion" value="<?=$seccion?>">
		<input type="hidden" name="subseccion" value="detalle">
		
		<div class="uk-width-1-2@m uk-width-1-1 uk-container-center">
			<h4><br>Español</h4>
			<div>
				<label for="tituloes">Título</label>
				<input type="text" class="uk-input" name="tituloes" required autofocus>
			</div>
			<div>
				<label for="txtes">Descripción</label>
				<textarea class="editor" name="txtes"></textarea>
			</div>
		</div>
		<div class="uk-width-1-2@m uk-width-1-1 uk-container-center">
			<h4><br>Inglés</h4>
			<div>
				<label for="tituloen">Título</label>
				<input type="text" class="uk-input" name="tituloen" required>
			</div>
			<div>
				<label for="txten">Descripción</label>
				<textarea class="editor" name="txten"></textarea>
			</div>
		</div>
		<div class="uk-width-1-2@m uk-width-1-1 uk-container-center">
			<h4><br>Japonés</h4>
			<div>
				<label for="tituloja">Título</label>
				<input type="text" class="uk-input" name="tituloja" required>
			</div>
			<div>
				<label for="txtja">Descripción</label>
				<textarea class="editor" name="txtja"></textarea>
			</div>
		</div>
		<div class="uk-width-1-2@m uk-width-1-1 uk-container-center">
			<h4><br>Ruso</h4>
			<div>
				<label for="tituloru">Título</label>
				<input type="text" class="uk-input" name="tituloru" required>
			</div>
			<div>
				<label for="txtru">Descripción</label>
				<textarea class="editor" name="txtru"></textarea>
			</div>
		</div>
		<div class="uk-width-1-2@m uk-width-1-1 uk-container-center">
			<h4><br>Portugués</h4>
			<div>
				<label for="titulopt">Título</label>
				<input type="text" class="uk-input" name="titulopt" required>
			</div>
			<div>
				<label for="txtpt">Descripción</label>
				<textarea class="editor" name="txtpt"></textarea>
			</div>
		</div>
		<div class="uk-width-1-2@m uk-width-1-1 uk-container-center">
			<h4><br>Húngaro</h4>
			<div>
				<label for="tituloit">Título</label>
				<input type="text" class="uk-input" name="tituloit" required>
			</div>
			<div>
				<label for="txtit">Descripción</label>
				<textarea class="editor" name="txtit"></textarea>
			</div>
		</div>
		<div class="uk-width-1-1 uk-text-center margen-top-20">
			<a href="index.php?seccion=<?=$seccion?>" class="uk-button uk-button-white" tabindex="10">Cancelar</a>
			<input type="submit" name="send" value="Agregar" class="uk-button uk-button-primary">
		</div>
	</div>
</form>

<?php 
$scripts='';
?>