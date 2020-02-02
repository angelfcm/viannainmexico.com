<?php 
	$CONSULTA3 = $CONEXION -> query("SELECT picen FROM configuracion WHERE id = 10");
	$row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();

	echo'
	<div class="uk-width-1-1 margen-top-20 uk-text-left">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?seccion=metadatos" class="color-red uk-text-capitalize">Metadatos</a></li>
		</ul>
	</div>

	<div class="uk-width-medium-1-1 margen-v-50">
		<table class="uk-table uk-table-small uk-table-striped uk-table-hover">
			<thead>
				<tr class="uk-text-muted">
					<td>Español</td>
					<td>Inglés</td>
					<td>Japonés</td>
					<td>Ruso</td>
					<td>Portugués</td>
					<td>Húngaro</td>
				</tr>
			</thead>
			<tbody>';

			$CONSULTA = $CONEXION -> query("SELECT * FROM traduccion WHERE id > 79 AND id < 97");
			while ($row_CONSULTA = $CONSULTA -> fetch_assoc()) {
				$thisId=$row_CONSULTA['id'];

				echo '
				<tr>
					<td colspan="6">'.$row_CONSULTA['variable'].'</td>
				</tr>
				<tr>
					<td>
						<input type="text" class="uk-input uk-form-width-small uk-form-small" data-lang="es" data-id="'.$row_CONSULTA['id'].'" value="'.$row_CONSULTA['es'].'">
					</td>
					<td>
						<input type="text" class="uk-input uk-form-width-small uk-form-small" data-lang="en" data-id="'.$row_CONSULTA['id'].'" value="'.$row_CONSULTA['en'].'">
					</td>
					<td>
						<input type="text" class="uk-input uk-form-width-small uk-form-small" data-lang="ja" data-id="'.$row_CONSULTA['id'].'" value="'.$row_CONSULTA['ja'].'">
					</td>
					<td>
						<input type="text" class="uk-input uk-form-width-small uk-form-small" data-lang="ru" data-id="'.$row_CONSULTA['id'].'" value="'.$row_CONSULTA['ru'].'">
					</td>
					<td>
						<input type="text" class="uk-input uk-form-width-small uk-form-small" data-lang="pt" data-id="'.$row_CONSULTA['id'].'" value="'.$row_CONSULTA['pt'].'">
					</td>
					<td>
						<input type="text" class="uk-input uk-form-width-small uk-form-small" data-lang="it" data-id="'.$row_CONSULTA['id'].'" value="'.$row_CONSULTA['it'].'">
					</td>
				</tr>';
			}

	echo '
			</tbody>
		</table>
	</div>

	<div class="uk-width-1-1">
		<hr class="uk-divider-icon">
		<h3 class="uk-text-center">Imagen para compartir en redes sociales</h3>
	</div>
	<div class="uk-width-1-2">
		<p>Dimensiones recomendadas 1000px ancho * 550px alto</p>
		<p>Formato JPG</p>
		<div id="fileuploader">
			Cargar
		</div>
	</div>
	<div class="uk-width-1-2">
		<a href="../img/design/'.$row_CONSULTA3['picen'].'"><img src="../img/design/'.$row_CONSULTA3['picen'].'"></a>
	</div>
	';

	if ($debug==1) {
		echo '
			<div>
				<div id="buttons">
					<a uk-toggle href="#add" id="add-button" class="uk-icon-button uk-button-primary uk-box-shadow-large" uk-toggle uk-icon="icon: plus;ratio:1.4"></a>
				</div>
			</div>';
	}

	$scripts='

		$(".uk-input").focusout(function() {
			var id = $(this).data("id");
			var lang = $(this).data("lang");
			var valor = $(this).val();
			$.ajax({
				method: "POST",
				url: "modulos/traduccion/acciones.php",
				data: { 
					editavalor:1,
					valor: valor,
					lang: lang,
					id: id
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg);
			});
		});

		$(document).ready(function() {
			var imagenesArray = [];
			$("#fileuploader").uploadFile({
				url:"../library/upload-file/php/upload.php",
				fileName:"myfile",
				maxFileCount:1,
				allowedTypes: "jpg,jpeg",
				maxFileSize: 2000000,
				showFileCounter: true,
				showPreview:true,
				returnType:"json",
				onSuccess:function(files,data,xhr){ 
					window.location = ("index.php?seccion='.$seccion.'&ogimage="+data);
				}
			});
		});
		';

