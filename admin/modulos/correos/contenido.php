<?php 
	$CONSULTA = $CONEXION -> query("SELECT pices FROM configuracion WHERE id = 11");
	$row_CONSULTA = $CONSULTA -> fetch_assoc();
	$correo=$row_CONSULTA['pices'];


	echo'
	<div class="uk-width-1-1 margen-top-20 uk-text-left">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?seccion=correos" class="color-red uk-text-capitalize">correos</a></li>
		</ul>
	</div>
	
	<div class="uk-width-1-2@m margen-top-20 uk-text-left">
		<p>Variables que se pueden usar:</p>
		<ul class="uk-list">
			<li><span class="uk-text-muted">Nombre del usuario:</span> %userName%</li>
			<li><span class="uk-text-muted">Asiento:</span> %asiento%</li>
			<li><span class="uk-text-muted">Curso:</span> %curso%</li>
			<li><span class="uk-text-muted">Número de estudiante:</span> %idEstudiante%</li>
			<li><span class="uk-text-muted">Botón de pago:</span> %botonPago%</li>
		</ul>
	</div>
	
	<div class="uk-width-1-2@m margen-top-20 uk-text-left">
		<form method="post" action="index.php">
			<input type="hidden" name="seccion" value="correos">
			<input type="hidden" name="identify" value="1">
			<label for="correo">Correo de envío</label>
			<input type="email" class="uk-input" name="correo" value="'.$correo.'" required>
			<label for="password">Contraseña</label>
			<input type="password" class="uk-input" name="password" required>
			<label for="password">Repetir contraseña</label>
			<input type="password" class="uk-input" name="password2" required>
			<br><br>
			<button class="uk-button uk-button-primary">Guardar</button>
		</form>
	</div>

	<form action="index.php" method="post" onsubmit="return checkForm(this);">
		<input type="hidden" name="guardar" value="1">
		<input type="hidden" name="seccion" value="'.$seccion.'">
		<div uk-grid class="uk-child-width-1-1">';


	$CONSULTA = $CONEXION -> query("SELECT * FROM correos");
	while ($row_CONSULTA = $CONSULTA -> fetch_assoc()) {

		echo '
			<hr class="uk-divider-icon">
			<div>
				<h3>'.$row_CONSULTA['titulo'].'</h3>
			</div>
			<div>
				<label for="asunto'.$row_CONSULTA['id'].'" class="uk-text-capitalize">Asunto</label>
				<input type="text" class="uk-input" name="asunto'.$row_CONSULTA['id'].'" value="'.$row_CONSULTA['asunto'].'">
			</div>
			<div>
				<label for="remitente'.$row_CONSULTA['id'].'" class="uk-text-capitalize">remitente</label>
				<input type="text" class="uk-input" name="remitente'.$row_CONSULTA['id'].'" value="'.$row_CONSULTA['remitente'].'">
			</div>
			<div>
				<label for="cuerpo'.$row_CONSULTA['id'].'" class="uk-text-capitalize">Cuerpo del correo</label>
				<textarea name="cuerpo'.$row_CONSULTA['id'].'" class="editor">'.$row_CONSULTA['cuerpo'].'</textarea>
			</div>';

			}

	echo '
			<div class="uk-width-1-1 uk-margin-top uk-text-center">
				<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
			</div>
		</div>
	</form>';

	$scripts='';

