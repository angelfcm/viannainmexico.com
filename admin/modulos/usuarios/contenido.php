
<div class="uk-width-1-2 margen-top-20 uk-text-left">
	<ul class="uk-breadcrumb">
		<?php 
		echo '
		<li><a href="index.php?seccion='.$seccion.'" class="color-red">'.$seccion.'</a></li>
		';
		?>
	</ul>
</div>

<div class="uk-width-1-1 uk-margin-top">
	<table class="uk-table uk-table-striped uk-table-hover ">
		<thead>
			<tr>
				<td>Nombre de usuario</td>
				<td class="uk-text-center">Acciones</td>
			</tr>
		</thead>
		<tbody>


<?php 
$USER = $CONEXION -> query("SELECT * FROM user ORDER BY user");
$numRows = $USER ->num_rows;
while($row_USER = $USER -> fetch_assoc()){

	$nivel=$row_USER['nivel'];
	switch ($nivel) {
		case 2:
			$clase='primary';
			$txt='Administración';
			break;
		
		default:
			$clase='';
			$txt='Ventas';
			break;
	}

	$deleteUser='';
	if($numRows!=1)
	{
		$deleteUser= '
					<span 
						data-id="'.$row_USER['id'].'"
						class="eliminar uk-icon-button uk-button-danger"
						uk-icon="icon:trash;">
					</span>';
	}
	$nivel='
				<td>Nivel</td>
				<td>
					<span 
						data-nivel="'.$nivel.'" 
						data-id="'.$row_USER['id'].'" 
						class="nivel uk-button uk-button-small uk-button-'.$clase.'">
						'.$txt.'
					</span>
				</td>';
	echo '
			<tr>
				<td>'.$row_USER['user'].'</td>
				<td class="uk-text-center">
					'.$deleteUser.'
					<a 
						href="#editar"
						data-id="'.$row_USER['id'].'" 
						data-user="'.$row_USER['user'].'" 
						class="password uk-icon-button uk-button-white" 
						uk-toggle
						uk-icon="icon:lock;">
					</a>
				</td>
			</tr>';

}
?>

		</tbody>
	</table>
</div>

<div>
	<div id="buttons">
		<a uk-toggle href="#add" id="add-button" class="uk-icon-button uk-button-primary uk-box-shadow-large" uk-toggle uk-icon="icon: plus;ratio:1.4"></a>
	</div>
</div>

<div id="add" class="modal" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<a class="uk-modal-close uk-close"></a>
		<form action="index.php" class="uk-form" method="post">
			<input type="hidden" name="seccion" value="usuarios">
			<input type="hidden" name="new-user" value="1">
			
			<div class="uk-width-1-1 margen-bottom-20">
				<label class="uk-width-1-1">Usuario</label>
				<input type="text" class="uk-width-1-1 uk-input" id="user" name="user">
			</div>

			<div class="uk-width-1-1 margen-bottom-20">
				<label class="uk-width-1-1">Contraseña</label>
				<input type="password" id="pass" name="pass" class="pass uk-width-1-1 uk-input" placeholder="Contraseña">
				<div id="mensaje" class="display-none">
					<div class="uk-alert uk-alert-danger" data-uk-alert>
						Debe tener al menos 6 caracteres
					</div>
				</div>
			</div>

			<div class="uk-width-1-1 margen-bottom-20">
				<label class="uk-width-1-1">Contraseña</label>
				<input type="password" id="passc" name="pass1" class="pass uk-width-1-1 uk-input" placeholder="Contraseña">
				<div id="mensajec" class="display-none">
					<div class="uk-alert uk-alert-danger" data-uk-alert>
						Las contraseñas no coinciden
					</div>
				</div>
			</div>

			<div class="uk-width-1-1 margen-bottom-20">
				<span class="password-revelar uk-margin uk-text-muted">Revelar contraseña</span>
				<span class="password-ocultar uk-hidden uk-margin uk-text-muted">Ocultar contraseña</span>
			</div>

			<div class="uk-width-1-1 uk-text-center">
				<a class="uk-button uk-button-default uk-button-large uk-modal-close">Cerrar</a>
				<button id="save" class="save uk-button uk-button-large uk-button-primary" disabled="true">Guardar</button>
			</div>
		</form>
	</div>
</div>


<div id="editar" class="modal" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<a class="uk-modal-close uk-close"></a>
		<form action="index.php" class="uk-form" method="post" onsubmit="return checkForm(this);">
			<input type="hidden" name="guardar" value="1">
			<input type="hidden" name="seccion" value="usuarios">
			<input type="hidden" name="edit-user" value="1">
			<input type="hidden" name="id" id="password" value="0">

			<label class="uk-width-1-1">Usuario</label>
			<input type="text" class="uk-input uk-width-1-1 margen-bottom-20" name="user" id="user1" value="" placeholder="Usuario">
			
			<label class="uk-width-1-1">Contraseña</label>
			<input type="password" id="pass1" class="uk-input uk-width-1-1 margen-bottom-20" name="pass">
			<div id="mensaje1" class="display-none">
				<div class="uk-alert uk-alert-danger" data-uk-alert>
					Debe tener al menos 6 caracteres
				</div>
			</div>
			
			<label class="uk-width-1-1">Confirmar contraseña</label>
			<input type="password" id="passc1" class="uk-input uk-width-1-1 margen-bottom-20" name="pass1">
			<div id="mensajec1" class="display-none">
				<div class="uk-alert uk-alert-danger" data-uk-alert>
					Las contraseñas no coinciden
				</div>
			</div>
			
			<div class="uk-width-1-1 uk-text-center uk-margin-top">
				<a class="uk-button uk-button-default uk-button-large uk-modal-close">Cerrar</a>
				<button id="save1" class="save uk-button uk-button-primary uk-button-small uk-button-large" disabled="true">Guardar</button>
			</div>
		
		</form>
	</div>
</div>