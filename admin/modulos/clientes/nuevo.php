<?php 
echo '
<div class="uk-width-1-1 margen-v-20">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'">Clientes</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=nuevo" class="color-red">Nuevo</a></li>
	</ul>
</div>
<form action="index.php" class="uk-width-1-1" method="post" name="datos" onsubmit="return checkForm(this);">
	<input type="hidden" name="new-user" value="1">
	<input type="hidden" name="seccion" value="'.$seccion.'">
	<div uk-grid>
		<div class="uk-width-1-2">
			<label for="nombre">Nombre</label>
			<input type="text" class="uk-input margen-bottom-20" name="nombre" value="" required>
			<label for="apellido">Apellido</label>
			<input type="text" class="uk-input margen-bottom-20" name="apellido" value="">
			<label for="gafet">Nombre para el gafet</label>
			<input type="text" class="uk-input margen-bottom-20" name="gafet" value="">
			<label for="nacimiento">Fecha de nacimiento</label>
			<input type="text" class="uk-input margen-bottom-20" name="nacimiento" value="">
			<label for="invita">Invitado por:</label>
			<input type="text" class="uk-input margen-bottom-20" name="invita" value="">
		</div>
		<div class="uk-width-1-2">
			<label for="email">Email</label>
			<input type="email" class="uk-input margen-bottom-20" name="email" value="">
			<label for="telefono">Teléfono</label>
			<input type="text" class="uk-input margen-bottom-20" name="telefono" value="">
			<label for="emergencia">Contacto de emergencia</label>
			<input type="text" class="uk-input margen-bottom-20" name="emergencia" value="">
			<label for="direccion">Dirección</label>
			<textarea id="direccion" name="direccion" class="uk-textarea margen-bottom-20 min-height-125"></textarea>
			<label for="pais">País</label>
			<input type="text" class="uk-input margen-bottom-20" name="pais" value="">
		</div>
		<div class="uk-width-1-1 uk-text-center">
			<a href="index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'"" class="uk-button uk-button-white uk-button-large" tabindex="10">Cancelar</a>
			<input type="submit" value="Guardar" name="enviar" class="uk-button uk-button-primary uk-button-large">
		</div>
	</div>
</form>
';

$scripts='';

