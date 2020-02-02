<?php 
$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $id");
$numRows = $USER ->num_rows;
$row_USER = $USER -> fetch_assoc();

echo '
<div class="uk-width-1-1 margen-v-20">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'">Clientes</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'">Detalle de cliente</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=editar&id='.$id.'" class="color-red">Editar</a></li>
	</ul>
</div>
<form action="index.php" class="uk-form uk-width-1-1" method="post" enctype="multipart/form-data" name="datos" onsubmit="return checkForm(this);">
	<input type="hidden" name="edit-user" value="1">
	<input type="hidden" name="seccion" value="'.$seccion.'">
	<input type="hidden" name="subseccion" value="'.$subseccion.'">
	<input type="hidden" name="id" value="'.$row_USER['id'].'">
	<div uk-grid>
		<div class="uk-width-1-1 uk-text-center">
			<h2>Editar datos de cliente</h2>
		</div>
		<div class="uk-width-1-1">
			<p class="uk-text-muted">Fecha de registro: '.$row_USER['alta'].'</p>
		</div>
		<div class="uk-width-1-2">
			<label for="nombre">Nombre</label>
			<input type="text" class="uk-input margen-bottom-20" name="nombre" value="'.$row_USER['nombre'].'" required>
			<label for="apellido">Apellido</label>
			<input type="text" class="uk-input margen-bottom-20" name="apellido" value="'.$row_USER['apellido'].'">
			<label for="gafet">Nombre para el gafet</label>
			<input type="text" class="uk-input margen-bottom-20" name="gafet" value="'.$row_USER['gafet'].'">
			<label for="nacimiento">Fecha de nacimiento</label>
			<input type="text" class="uk-input margen-bottom-20" name="nacimiento" value="'.$row_USER['nacimiento'].'">
			<label for="invita">Invitado por:</label>
			<input type="text" class="uk-input margen-bottom-20" name="invita" value="'.$row_USER['invita'].'">
		</div>
		<div class="uk-width-1-2">
			<label for="email">Email</label>
			<input type="email" class="uk-input margen-bottom-20" name="email" value="'.$row_USER['email'].'">
			<label for="telefono">Teléfono</label>
			<input type="text" class="uk-input margen-bottom-20" name="telefono" value="'.$row_USER['telefono'].'">
			<label for="emergencia">Contacto de emergencia</label>
			<input type="text" class="uk-input margen-bottom-20" name="emergencia" value="'.$row_USER['emergencia'].'">
			<label for="direccion">Dirección</label>
			<textarea id="direccion" name="direccion" class="uk-textarea margen-bottom-20 min-height-125">'.$row_USER['direccion'].'</textarea>
			<label for="pais">País</label>
			<input type="text" class="uk-input margen-bottom-20" name="pais" value="'.$row_USER['pais'].'">
		</div>
		<div class="uk-width-1-1 uk-text-center">
			<a href="index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'"" class="uk-button uk-button-white uk-button-large" tabindex="10">Cancelar</a>
			<input type="submit" value="Guardar" name="enviar" class="uk-button uk-button-primary uk-button-large">
		</div>
	</div>
</form>
';


