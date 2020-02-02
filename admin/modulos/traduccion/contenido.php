<?php 
	$CONSULTA1 = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 2");
	$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
	$CONSULTA2 = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 3");
	$row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
	$CONSULTA3 = $CONEXION -> query("SELECT pices FROM configuracion WHERE id = 10");
	$row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();

	echo'
	<div class="uk-width-1-1 margen-top-20 uk-text-left">
		<ul class="uk-breadcrumb">
			<li><a href="index.php?seccion='.$seccion.'" class="color-red uk-text-capitalize">Traducción</a></li>
		</ul>
	</div>

	<div class="uk-width-medium-1-1 margen-v-50">
		<table class="uk-table uk-table-small uk-table-striped uk-table-hover">
			<thead>
				<tr class="uk-text-muted">';
				if ($debug==1) {
					echo '
					<td></td>';
				}
				echo '
					<td>Español</td>
					<td>Inglés</td>
					<td>Japonés</td>
					<td>Ruso</td>
					<td>Portugués</td>
					<td>Húngaro</td>
				</tr>
			</thead>
			<tbody>';

			$CONSULTA = $CONEXION -> query("SELECT * FROM $seccion ORDER BY es");
			while ($row_CONSULTA = $CONSULTA -> fetch_assoc()) {
				$thisId=$row_CONSULTA['id'];

				echo '
				<tr>';
				if ($debug==1) {
					echo '
					<td>
						<input type="text" class="uk-input uk-form-width-small uk-form-small" data-lang=";)" value="'.$row_CONSULTA['variable'].'">
					</td>';
				}
				echo '
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
		<p id="mensaje"></p>
	</div>

	<div id="add" class="modal" uk-modal>
		<div class="uk-modal-dialog uk-modal-body">
			<a class="uk-modal-close uk-close"></a>
			<form action="index.php" class="uk-form" method="post">
				<input type="hidden" name="seccion" value="'.$seccion.'">
				<input type="hidden" name="new" value="1">
				
				<div class="uk-width-1-1 margen-bottom-20">
					<label for="variable" class="uk-width-1-1">Variable</label>
					<input type="text" class="uk-input" name="variable">
				</div>

				<div class="uk-width-1-1 uk-text-center">
					<a class="uk-button uk-button-default uk-button-large uk-modal-close">Cerrar</a>
					<button id="save" class="save uk-button uk-button-large uk-button-primary">Guardar</button>
				</div>
			</form>
		</div>
	</div>
	<div class="uk-width-1-1">
		<hr class="uk-divider-icon">
		<h3 class="uk-text-center">Texto de la sección PAGOS</h3>
	</div>
	<div class="uk-width-4-5">
		<form action="index.php" method="post" onsubmit="return checkForm(this);">
			<input type="hidden" name="pagostextos" value="1">
			<input type="hidden" name="seccion" value="'.$seccion.'">


			<ul class="uk-subnav uk-subnav-pill" uk-switcher>
				<li class="uk-active"><a href="index.php?languaje=es">Español</a></li>
				<li><a href="index.php?languaje=en">Inglés</a></li>
				<li><a href="index.php?languaje=ja">Japonés</a></li>
				<li><a href="index.php?languaje=ru">Ruso</a></li>
				<li><a href="index.php?languaje=pt">Portugués</a></li>
				<li><a href="index.php?languaje=it">Úngaro</a></li>
			</ul>

			<ul class="uk-switcher uk-margin">
				<li>
					<label for="pagoses">Español</label>
					<textarea name="pagoses" id="pagoses" class="editor">'.$row_CONSULTA1['pagoses'].'</textarea>
				</li>
				<li>
					<label for="pagosen">Inglés</label>
					<textarea name="pagosen" id="pagosen" class="editor">'.$row_CONSULTA1['pagosen'].'</textarea>
				</li>
				<li>
					<label for="pagosja">Japonés</label>
					<textarea name="pagosja" id="pagosja" class="editor">'.$row_CONSULTA1['pagosja'].'</textarea>
				</li>
				<li>
					<label for="pagosru">Ruso</label>
					<textarea name="pagosru" id="pagosru" class="editor">'.$row_CONSULTA1['pagosru'].'</textarea>
				</li>
				<li>
					<label for="pagospt">Portugués</label>
					<textarea name="pagospt" id="pagospt" class="editor">'.$row_CONSULTA1['pagospt'].'</textarea>
				</li>
				<li>
					<label for="pagosit">Húngaro</label>
					<textarea name="pagosit" id="pagosit" class="editor">'.$row_CONSULTA1['pagosit'].'</textarea>
				</li>
			</ul>
			<div class="uk-width-1-1 uk-margin-top uk-text-center">
				<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
			</div>
		</form>
	</div>

	<div class="uk-width-1-1">
		<hr class="uk-divider-icon">
		<h3 class="uk-text-center">POLÍTICAS DE CANCELACIÓN O REEMBOLSO</h3>
	</div>
	<div class="uk-width-4-5">
		<form action="index.php" method="post" onsubmit="return checkForm(this);">
			<input type="hidden" name="cursostextos" value="1">
			<input type="hidden" name="seccion" value="'.$seccion.'">


			<ul class="uk-subnav uk-subnav-pill" uk-switcher>
				<li class="uk-active"><a href="index.php?languaje=es">Español</a></li>
				<li><a href="index.php?languaje=en">Inglés</a></li>
				<li><a href="index.php?languaje=ja">Japonés</a></li>
				<li><a href="index.php?languaje=ru">Ruso</a></li>
				<li><a href="index.php?languaje=pt">Portugués</a></li>
				<li><a href="index.php?languaje=it">Úngaro</a></li>
			</ul>

			<ul class="uk-switcher uk-margin">
				<li>
					<label for="cursotextoes">Español</label>
					<textarea name="cursotextoes" id="cursotextoes" class="editor">'.$row_CONSULTA2['cursotextoes'].'</textarea>
				</li>
				<li>
					<label for="cursotextoen">Inglés</label>
					<textarea name="cursotextoen" id="cursotextoen" class="editor">'.$row_CONSULTA2['cursotextoen'].'</textarea>
				</li>
				<li>
					<label for="cursotextoja">Japonés</label>
					<textarea name="cursotextoja" id="cursotextoja" class="editor">'.$row_CONSULTA2['cursotextoja'].'</textarea>
				</li>
				<li>
					<label for="cursotextoru">Ruso</label>
					<textarea name="cursotextoru" id="cursotextoru" class="editor">'.$row_CONSULTA2['cursotextoru'].'</textarea>
				</li>
				<li>
					<label for="cursotextopt">Portugués</label>
					<textarea name="cursotextopt" id="cursotextopt" class="editor">'.$row_CONSULTA2['cursotextopt'].'</textarea>
				</li>
				<li>
					<label for="cursotextoit">Húngaro</label>
					<textarea name="cursotextoit" id="cursotextoit" class="editor">'.$row_CONSULTA2['cursotextoit'].'</textarea>
				</li>
			</ul>
			<div class="uk-width-1-1 uk-margin-top uk-text-center">
				<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
			</div>
		</form>
	</div>
	<div class="uk-width-1-1">
		<hr class="uk-divider-icon">
		<h3 class="uk-text-center">IDIOMA CHINO</h3>
	</div>
	<div class="uk-width-1-2">
		<div id="fileuploader">
			Cargar
		</div>
	</div>
	<div class="uk-width-1-2">
		<a href="../files/'.$row_CONSULTA3['pices'].'" class="uk-button uk-button-white" download="chino.pdf"><i uk-icon="icon:cloud-download"></i></a>
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
				url: "modulos/'.$seccion.'/acciones.php",
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
				allowedTypes: "pdf",
				maxFileSize: 6291456,
				showFileCounter: true,
				showPreview:true,
				returnType:"json",
				onSuccess:function(files,data,xhr){ 
					window.location = ("index.php?seccion='.$seccion.'&chinochange="+data);
				}
			});
		});
		';

