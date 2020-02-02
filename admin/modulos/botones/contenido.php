<?php 
	$CONSULTA4 = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 4");
	$row_CONSULTA4 = $CONSULTA4 -> fetch_assoc();
	$CONSULTA5 = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 5");
	$row_CONSULTA5 = $CONSULTA5 -> fetch_assoc();
	$CONSULTA6 = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 6");
	$row_CONSULTA6 = $CONSULTA6 -> fetch_assoc();
	echo'
	<div class="uk-width-1-1">
		<h3 class="uk-text-center">BOTONES DE PAGO DE PAYPAL</h3>
	</div>
	<div class="uk-width-4-5">
		<form action="index.php" method="post" onsubmit="return checkForm(this);">
			<input type="hidden" name="botontextos" value="1">
			<input type="hidden" name="seccion" value="'.$seccion.'">


			<ul class="uk-subnav uk-subnav-pill" uk-switcher>
				<li class="uk-active"><a href="index.php?languaje=es">Español</a></li>
				<li><a href="index.php?languaje=en">Inglés</a></li>
				<li><a href="index.php?languaje=ja">Japonés</a></li>
				<li><a href="index.php?languaje=ru">Ruso</a></li>
				<li><a href="index.php?languaje=pt">Portugués</a></li>
				<li><a href="index.php?languaje=it">Húngaro</a></li>
			</ul>

			<ul class="uk-switcher uk-margin">
				<li>
					<label>Curso MXN</label>
					<textarea name="pagos4es" class="uk-textarea min-height-250">'.$row_CONSULTA4['pagoses'].'</textarea>
					<br><br>
					<label>Curso USD</label>
					<textarea name="pagos5es" class="uk-textarea min-height-250">'.$row_CONSULTA5['pagoses'].'</textarea>
					<br><br>
					<label>Traducción USD</label>
					<textarea name="pagos6es" class="uk-textarea min-height-250">'.$row_CONSULTA6['pagoses'].'</textarea>
				</li>
				<li>
					<label>Curso MXN</label>
					<textarea name="pagos4en" class="uk-textarea min-height-250">'.$row_CONSULTA4['pagosen'].'</textarea>
					<br><br>
					<label>Curso USD</label>
					<textarea name="pagos5en" class="uk-textarea min-height-250">'.$row_CONSULTA5['pagosen'].'</textarea>
					<br><br>
					<label>Traducción USD</label>
					<textarea name="pagos6en" class="uk-textarea min-height-250">'.$row_CONSULTA6['pagosen'].'</textarea>
				</li>
				<li>
					<label>Curso MXN</label>
					<textarea name="pagos4ja" class="uk-textarea min-height-250">'.$row_CONSULTA4['pagosja'].'</textarea>
					<br><br>
					<label>Curso USD</label>
					<textarea name="pagos5ja" class="uk-textarea min-height-250">'.$row_CONSULTA5['pagosja'].'</textarea>
					<br><br>
					<label>Traducción USD</label>
					<textarea name="pagos6ja" class="uk-textarea min-height-250">'.$row_CONSULTA6['pagosja'].'</textarea>
				</li>
				<li>
					<label>Curso MXN</label>
					<textarea name="pagos4ru" class="uk-textarea min-height-250">'.$row_CONSULTA4['pagosru'].'</textarea>
					<br><br>
					<label>Curso USD</label>
					<textarea name="pagos5ru" class="uk-textarea min-height-250">'.$row_CONSULTA5['pagosru'].'</textarea>
					<br><br>
					<label>Traducción USD</label>
					<textarea name="pagos6ru" class="uk-textarea min-height-250">'.$row_CONSULTA6['pagosru'].'</textarea>
				</li>
				<li>
					<label>Curso MXN</label>
					<textarea name="pagos4pt" class="uk-textarea min-height-250">'.$row_CONSULTA4['pagospt'].'</textarea>
					<br><br>
					<label>Curso USD</label>
					<textarea name="pagos5pt" class="uk-textarea min-height-250">'.$row_CONSULTA5['pagospt'].'</textarea>
					<br><br>
					<label>Traducción USD</label>
					<textarea name="pagos6pt" class="uk-textarea min-height-250">'.$row_CONSULTA6['pagospt'].'</textarea>
				</li>
				<li>
					<label>Curso MXN</label>
					<textarea name="pagos4it" class="uk-textarea min-height-250">'.$row_CONSULTA4['pagosit'].'</textarea>
					<br><br>
					<label>Curso USD</label>
					<textarea name="pagos5it" class="uk-textarea min-height-250">'.$row_CONSULTA5['pagosit'].'</textarea>
					<br><br>
					<label>Traducción USD</label>
					<textarea name="pagos6it" class="uk-textarea min-height-250">'.$row_CONSULTA6['pagosit'].'</textarea>
				</li>
			</ul>
			<div class="uk-width-1-1 uk-margin-top uk-text-center">
				<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
			</div>
		</form>
	</div>
	';


	$scripts='

		// Eliminar producto
		$(".eliminaprod").click(function() {
			var id = $(this).attr(\'data-id\');
			//console.log(id);
			var statusConfirm = confirm("Realmente desea eliminar este Producto?"); 
			if (statusConfirm == true) { 
				window.location = ("index.php?seccion='.$seccion.'&subseccion=contenido&borrarPod&cat='.$cat.'&id="+id);
			} 
		});



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

		';

