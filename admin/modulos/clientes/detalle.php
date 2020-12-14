<?php 
$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $id");
$row_USER = $USER -> fetch_assoc();

echo '
<div class="uk-width-1-1 margen-v-20">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'">Clientes</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'" class="color-red">Detalle de cliente</a></li>
	</ul>
</div>
<div class="uk-width-1-2">
	<h2>Datos del cliente</h2>
	<p><span class="uk-text-muted">Nombre:</span> '.$row_USER['nombre'].'</p>
	<p><span class="uk-text-muted">Apellido:</span> '.$row_USER['apellido'].'</p>
	<p><span class="uk-text-muted">Número de estudiante:</span> '.$row_USER['id'].'</p>
	<p><span class="uk-text-muted">Nombre para el gafet:</span> '.$row_USER['gafet'].'</p>
	<p><span class="uk-text-muted">Fecha de nacimiento:</span> '.$row_USER['nacimiento'].'</p>
	<p><span class="uk-text-muted">Invitado por:</span> '.$row_USER['invita'].'</p>
	<p><span class="uk-text-muted">Email:</span> '.$row_USER['email'].'</p>
	<p><span class="uk-text-muted">Teléfono:</span> '.$row_USER['telefono'].'</p>
	<p><span class="uk-text-muted">Contacto de emergencia:</span> '.$row_USER['emergencia'].'</p>
	<p><span class="uk-text-muted">Dirección:</span>'.$row_USER['direccion'].'</p>
	<p><span class="uk-text-muted">País:</span> '.$row_USER['pais'].'</p>
	<p><span class="uk-text-muted">Fecha de registro:</span> '.$row_USER['alta'].'</p>
	<p><a href="#inscribir" uk-toggle class="uk-button uk-button-white">Inscribir en un curso</a></p>
</div>
<div class="uk-width-1-2">
	<h2>Datos del curso</h2>
';


	
	$CONSULTA1 = $CONEXION -> query("SELECT * FROM cursoasientos WHERE usuario = $id");
	$numRows = $CONSULTA1 ->num_rows;
	while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
		$cursoId=$row_CONSULTA1['curso'];

		$CONSULTA = $CONEXION -> query("SELECT * FROM cursos WHERE id = $cursoId");
		$row_CONSULTA = $CONSULTA -> fetch_assoc();

		$asiento=($numRows!=0)?$row_CONSULTA1['asiento']:'';
		$notify=($numRows!=0)?'<a class="uk-button uk-button-white" href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&notify=1&id='.$id.'&curso='.$cursoId.'&asiento='.$row_CONSULTA1['asiento'].'"><i uk-icon="icon:mail"></i> &nbsp; Notificar</a>':'';

		$coursePayment = $CONEXION->query('SELECT * FROM pp_payments WHERE id = "' . $row_CONSULTA1['payment_id'].'"')->fetch_assoc();
		$translationPayment = $CONEXION->query('SELECT * FROM pp_payments WHERE id = "' . $row_CONSULTA1['translation_payment_id'].'"')->fetch_assoc();
		$paymentLabel = '';
		$translationPaymentLabel = '';

		if ($coursePayment != null)
			$paymentLabel = '<p><span style="color: green"><strong>Curso</strong> pagado con PayPal: </span><br>' . $coursePayment['payer_email'] . '<br><small>Monto de <strong>$' . $coursePayment['total'] . ' ' . $coursePayment['currency'] . '</strong> el ' . $coursePayment['created_at'] . '</small></p>';
		if ($translationPayment != null)
			$translationPaymentLabel = '<p><span style="color: green"><strong>Traducci&oacute;n</strong> pagada con PayPal: </span><br>' . $translationPayment['payer_email'] . '<br><small>Monto de <strong>$' . $translationPayment['total'] . ' ' . $translationPayment['currency'] . '</strong> el ' . $translationPayment['created_at'] . '</small></p>';

		$tipo = isset($courseTypeLangs[$row_CONSULTA1['tipo']]) ? $courseTypeLangs[$row_CONSULTA1['tipo']] : 'N/A';

		echo '
		<p></p>
		<p>
			<span class="uk-text-muted">Nombre:</span> <strong>'.$row_CONSULTA['tituloes'].'</strong>
			<br /><span class="uk-text-muted">Tipo de curso:</span> '.$tipo.'
		</p>
		'.$paymentLabel.$translationPaymentLabel.'
		<a href="#" class="dardebaja uk-button uk-button-danger uk-button-small" data-id="'.$row_CONSULTA1['id'].'">Dar de baja del curso</a></p>
		<p>
			<span class="uk-text-muted">Fechas:</span> '.$row_CONSULTA['fechaes'].'
			<br><span class="uk-text-muted">Traducción:</span> <input class="input-traductor uk-input uk-form-blank uk-form-width-medium" type="text" placeholder="No" value="'.$row_CONSULTA1['traductor'].'" data-id="'.$row_CONSULTA1['id'].'">
			<br><span class="uk-text-muted">Manual:</span> <input class="input-material uk-input uk-form-blank uk-form-width-medium" type="text" placeholder="Indefinido" value="'.$row_CONSULTA1['material'].'" data-id="'.$row_CONSULTA1['id'].'">
			<br><span class="uk-text-muted">Asiento:</span> <span class="uk-text-uppercase">'.$asiento.'</span>
		</p>
		<p><a href="index.php?seccion=cursos&subseccion=detalle&id='.$cursoId.'" class="uk-button uk-button-white">Ver curso</a><br></p>
		<p>'.$notify.'</p>
		<p>
			<a href="#" class="retirar uk-button uk-button-danger uk-button-small" data-id="'.$row_CONSULTA1['id'].'">Retirar asiento</a>
			<a href="index.php?seccion='.$seccion.'&subseccion=auditorio&id='.$id.'&curso='.$cursoId.'" class="uk-button uk-button-primary uk-button-small">Asignar asiento</a>
		</p>
		<hr class="uk-divider-icon">
		';
	}

echo'
</div>


<!-- This is the modal -->
<div id="inscribir" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<h2 class="uk-modal-title">Inscribir en un curso</h2>
		<ul class="uk-list uk-list-striped">';


$CONSULTA2 = $CONEXION -> query("SELECT * FROM cursos");
while($row_CONSULTA2 = $CONSULTA2 -> fetch_assoc()){
	$cursoId=$row_CONSULTA2['id'];
	$CONSULTA3 = $CONEXION -> query("SELECT * FROM cursoasientos WHERE curso = $cursoId AND usuario = $id");
	$numRows = $CONSULTA3 ->num_rows;
	if ($numRows==0) {
		echo '
			<li class="inscribir" data-id="'.$cursoId.'">'.$row_CONSULTA2['tituloes'].'</li>';
	}
}		
echo '	</ul>
		<p class="uk-text-right">
			<button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
		</p>
	</div>
</div>


<div>
	<div id="buttons">
		<a href="#" data-id="'.$row_USER['id'].'" class="eliminauser uk-icon-button uk-button-danger uk-box-shadow-large" uk-icon="icon:trash;ratio:1.4"></a>
		<a href="index.php?seccion='.$seccion.'&subseccion=editar&id='.$id.'" id="add-button" class="uk-icon-button uk-button-primary uk-box-shadow-large" uk-icon="icon:pencil;ratio:1.4"></a>
	</div>
</div>

';


$scripts='
<script>
	$(".dardebaja").click(function(){
		var id = $(this).data("id");
		var statusConfirm = confirm("Realmente desea darlo de baja del curso?");
		if (statusConfirm == true) { 
			window.location = ("index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'&dardebaja="+id);
		} 
	});
</script>

<script>
	$(".retirar").click(function(){
		var id = $(this).data("id");
		var statusConfirm = confirm("Realmente desea retira el asiento?");
		if (statusConfirm == true) { 
			window.location = ("index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'&retirarasiento="+id);
		} 
	});
</script>

<script>
	$(".inscribir").click(function(){
		var curso=$(this).data("id");
		console.log(curso);
		window.location = ("index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'&inscribir="+curso);
	});
</script>

<script>
	$(".input-traductor").focusout(function() {
		var id = $(this).data("id");
		var valor = $(this).val();
		$.ajax({
			method: "POST",
			url: "modulos/'.$seccion.'/acciones.php",
			data: { 
				editatraduc:valor,
				id: id
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});
	});
	$(".input-material").focusout(function() {
		var id = $(this).data("id");
		var valor = $(this).val();
		$.ajax({
			method: "POST",
			url: "modulos/'.$seccion.'/acciones.php",
			data: { 
				editamat:valor,
				id: id
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});
	});
</script>


';