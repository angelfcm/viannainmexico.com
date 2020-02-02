<?
$CONSULTA = $CONEXION -> query("SELECT * FROM $seccion WHERE id = $id");
$row_CONSULTA = $CONSULTA -> fetch_assoc();

echo '
<div class="uk-width-1-1 margen-v-20">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'">Cursos</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'">'.$row_CONSULTA['tituloes'].'</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=auditorio&id='.$id.'" class="color-red">Auditorio</a></li>
	</ul>
</div>



<div class="uk-width-1-1 margen-top-20 uk-text-center">
	<table class="uk-flex uk-flex-center">
		<tr>
			<td colspan="'.$row_CONSULTA['asientoscol'].'"><div class="bg-grey uk-text-muted" style="border-radius:0 0 50% 50%;font-size:12px;">ESCENARIO</div></td>
		</tr>
		<tr>';
	$i=0;
	$k=64;
	while ($i<$row_CONSULTA['asientosrow']) {
		$i++;
		$j=0;
		$k++;
		echo '
		<tr>';
		while ($j<=$row_CONSULTA['asientoscol']) {
			if ($j==0) {
				echo'';
			}else{
				$thisAsiento=(chr($k).$j);
				$CONSULTA2 = $CONEXION -> query("SELECT * FROM cursoasientos WHERE asiento = '$thisAsiento' AND curso = $id");
				$numCONSULTA2 = $CONSULTA2 ->num_rows;
				if ($numCONSULTA2==0) {
					$clase='bg-test3 libre';
					$tooltip='';
					$link='';
					$linkClose='';
				}else{
					$row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
					$uid=$row_CONSULTA2['usuario'];
					$CONSULTA3 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $uid");
					$row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();
					$clase=($uid==0)?'bg-grey bloqueado':'bg-black';
					$tooltip=($uid==0)?'':'title="'.$row_CONSULTA3['nombre'].' '.$row_CONSULTA3['apellido'].'" uk-tooltip';
					$link=($uid==0)?'':'<a href="index.php?seccion=clientes&subseccion=detalle&id='.$uid.'&curso='.$id.'">';
					$linkClose='</a>';
				}
				echo'
				<td>'.$link.'<div id="'.chr($k).$j.'" data-asiento="'.chr($k).$j.'" class="'.$clase.' pointer uk-badge" '.$tooltip.'>'.chr($k).$j.'</div>'.$linkClose.'</td>';
			}
			$j++;
		}
		echo '
		</tr>
		';
	}
	echo '
	</table>
</div>

<div class="uk-width-1-1 padding-v-50 uk-text-center">
	<button id="vaciar" class="uk-button uk-button-danger"><i uk-icon="icon:trash"></i> &nbsp; Borrar asistentes</button>
	<a href="gafet.php?id='.$id.'" target="_blank" class="uk-button uk-button-white"><i uk-icon="icon:users"></i> &nbsp; Gafets</a>
	<a href="auditorio.php?id='.$id.'" target="_blank" class="uk-button uk-button-primary" download="auditorio.csv"><i uk-icon="icon:download"></i> &nbsp; CSV separado por ;</a>
	<a href="auditorio1.php?id='.$id.'" target="_blank" class="uk-button uk-button-primary" download="auditorio.csv"><i uk-icon="icon:download"></i> &nbsp; CSV separado por ,</a>
</div>


<div class="uk-width-1-1 padding-v-50">
	<table class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-middle uk-table-responsive text-sm">
		<thead>
			<tr class="uk-text-center">
				<td>ID Estudiante</td>
				<td>Asiento</td>
				<td>Gafet</td>
				<td>Nombre</td>
				<td>Apellido</td>
				<td>Telefono</td>
				<td>Email</td>
				<td>Pais</td>
				<td>Traduccion</td>
				<td>Pago Traducción</td>
				<td>Metodo Traducción</td>
				<td>PP Traduccion</td>
				<td>Pago 1</td>
				<td>Metodo Pago 1</td>
				<td>PP Pago 1</td>
				<td>Pago 2</td>
				<td>Metodo</td>
				<td>Observaciones</td>
			</tr>
		</thead>
		<tbody>';
	$CONSULTA2 = $CONEXION -> query("SELECT * FROM cursoasientos WHERE curso = $id");
	while ($row_CONSULTA2 = $CONSULTA2 -> fetch_assoc()) {
		$uid=$row_CONSULTA2['usuario'];
		$rowid=$row_CONSULTA2['id'];

		$CONSULTA3 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $uid");
		$row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();
		if ($uid!=0) {

			$coursePayment = $CONEXION->query('SELECT * FROM pp_payments WHERE id = "' . $row_CONSULTA2['payment_id'] . '"')->fetch_assoc();
			$translationPayment = $CONEXION->query('SELECT * FROM pp_payments WHERE id = "' . $row_CONSULTA2['translation_payment_id']. '"')->fetch_assoc();
	
			$coursePaymentEmail = $coursePayment ? $coursePayment['payer_email'] : '';
			$translationPaymentEmail = $translationPayment ? $translationPayment['payer_email'] : '';
			
			$pago1=($row_CONSULTA2['estatus']==1)?$row_CONSULTA['precio']:0;
			echo '
			<tr>
				<td class="uk-text-center@m">'.$uid.'</td>
				<td class="uk-text-center@m">'.$row_CONSULTA2['asiento'].'</td>
				<td>'.$row_CONSULTA3['gafet'].'</td>
				<td>'.$row_CONSULTA3['nombre'].'</td>
				<td>'.$row_CONSULTA3['apellido'].'</td>
				<td>'.$row_CONSULTA3['telefono'].'</td>
				<td>'.$row_CONSULTA3['email'].'</td>
				<td>'.$row_CONSULTA3['pais'].'</td>
				<td>'.$row_CONSULTA2['traductor'].'</td>
				<td><input type="text" data-id="'.$rowid.'" value="'.$row_CONSULTA2['pagot'].'" data-col="pagot" class="excel uk-input uk-form-small uk-form-width-small"></td>
				<td><input type="text" data-id="'.$rowid.'" value="'.$row_CONSULTA2['translation_payment_option'].'" data-col="translation_payment_option" class="excel uk-input uk-form-small uk-form-width-small"></td>
				<td>'.$coursePaymentEmail.'</td>
				<td><input type="text" data-id="'.$rowid.'" value="'.$row_CONSULTA2['pago1'].'" data-col="pago1" class="excel uk-input uk-form-small uk-form-width-small"></td>
				<td><input type="text" data-id="'.$rowid.'" value="'.$row_CONSULTA2['metodo1'].'" data-col="metodo1" class="excel uk-input uk-form-small uk-form-width-small"></td>
				<td>'.$translationPaymentEmail.'</td>
				<td><input type="text" data-id="'.$rowid.'" value="'.$row_CONSULTA2['pago2'].'" data-col="pago2" class="excel uk-input uk-form-small uk-form-width-small"></td>
				<td><input type="text" data-id="'.$rowid.'" value="'.$row_CONSULTA2['metodo2'].'" data-col="metodo2" class="excel uk-input uk-form-small uk-form-width-small"></td>
				<td><input type="text" data-id="'.$rowid.'" value="'.$row_CONSULTA2['observaciones'].'" data-col="observaciones" class="excel uk-input uk-form-small uk-form-width-small"></td>
			</tr>';
		}
	}

	echo '
		</tbody>
	</table>
</div>


<div>
	<div id="buttons">
		<a href="#asientos" uk-toggle class="uk-icon-button uk-button-primary uk-box-shadow-large" uk-icon="icon:pencil;ratio:1.4"></a>
	</div>
</div>

<div id="asientos" uk-modal class="modal">
	<div class="uk-modal-dialog uk-modal-body">
		<a href="" class="uk-modal-close uk-close"></a>
		<form action="index.php" method="post" onsubmit="return checkForm(this);">
			<input type="hidden" name="auditorionew" value="1">
			<input type="hidden" name="seccion" value="'.$seccion.'">
			<input type="hidden" name="subseccion" value="auditorio">
			<input type="hidden" name="id" value="'.$id.'">
			<div class="uk-child-width-1-2" uk-grid>
				<div>
					<label for="filas">Filas</label>
					<input type="number" class="uk-input" name="filas" value="'.$row_CONSULTA['asientosrow'].'">
				</div>
				<div>
					<label for="columnas">Columnas</label>
					<input type="number" class="uk-input" name="columnas" value="'.$row_CONSULTA['asientoscol'].'">
				</div>
			</div>
			<br><br>
			<div class="uk-text-center">
				<a href="" class="uk-button uk-button-default uk-modal-close uk-button-large" tabindex="10">Cancelar</a>
				<input type="submit" name="send" value="Guardar" class="uk-button uk-button-primary uk-button-large">
			</div>
		</form>
	</div>
</div>


';

$scripts='

	$(document).ready(function() {
		var imagenesArray = [];
		$("#fileuploadermain").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			allowedTypes: "jpeg,jpg",
			maxFileSize: 6291456,
			showFileCounter: true,
			showPreview:true,
			returnType:\'json\',
			onSuccess:function(files,data,xhr){ 
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&position=auditorio&imagen=\'+data);
			}
		});
	});

	$("#vaciar").click(function(){
		var statusConfirm = confirm("Realmente desea reiniciar este curso?"); 
		if (statusConfirm == true) { 
			window.location = ("index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&vaciar=1&id='.$id.'");
		} 
	})

 
	$(".libre").click(function(){
		var asiento = $(this).data("asiento");
		UIkit.modal.confirm("Bloquear asiento "+asiento).then(function() {
			console.log("Confirmado")
			window.location = ("index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&bloquear=1&id='.$id.'&asiento="+asiento);
		}, function () {
			console.log("Rechazado")
		});
	});

	$(".bloqueado").click(function(){
		var asiento = $(this).data("asiento");
		UIkit.modal.confirm("Habilitar asiento "+asiento).then(function() {
			console.log("Confirmado")
			window.location = ("index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&habilitar=1&id='.$id.'&asiento="+asiento);
		}, function () {
			console.log("Rechazado")
		});
	});

	$(".excel").focusout(function() {
		var id = $(this).data("id");
		var col = $(this).data("col");
		var valor = $(this).val();
		$.ajax({
			method: "POST",
			url: "modulos/'.$seccion.'/acciones.php",
			data: { 
				editavalor:1,
				valor: valor,
				col: col,
				id: id
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});
	});
	';
