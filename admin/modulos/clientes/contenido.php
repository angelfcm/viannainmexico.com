<?php 
echo '
<div class="uk-width-1-1 margen-v-20">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'" class="color-red">Clientes</a></li>
	</ul>
</div>

<div class="uk-width-1-1 margen-bottom-20">
	<table class="uk-table uk-table-hover uk-table-striped">
		<thead>
			<tr>
				<td>ID/Nombre/Email/Tel</td>
				<td class="uk-text-center">Curso</td>
				<td class="uk-text-center">Alta</td>
				<td class="uk-text-center">Acciones</td>
			</tr>
		</thead>
		<tbody>';

		$USER = $CONEXION -> query("SELECT * FROM usuarios");
		$numRows = $USER ->num_rows;
		while($row_USER = $USER -> fetch_assoc()){
			$uid=$row_USER['id'];

			echo '
			<tr>
				<td>
					<a href="index.php?seccion=clientes&subseccion=detalle&id='.$row_USER['id'].'">
						'.$row_USER['id'].' - '.$row_USER['nombre'].' '.$row_USER['apellido'].'<br>'.$row_USER['email'].'<br>'.$row_USER['telefono'].'
					</a>
				</td>
				<td class="uk-text-center">';

			$CONSULTA = $CONEXION->query("SELECT 
				tipo, payment_id, translation_payment_id, curso, estatus, translation_status, estatus_details, tituloes, ca.id as cursoAsientoId  
				FROM cursoasientos ca 
				INNER JOIN cursos c ON ca.curso = c.id 
				WHERE usuario = $uid ORDER BY c.orden ASC");

			while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
				$cursoId = $row_CONSULTA['curso'];
				$estatus = $row_CONSULTA['estatus'];
				$translationStatus = $row_CONSULTA['translation_status'];
				$textoEstatus = $estatus == 0 ? 'Registrado' : 'Pagado';
				$buttonClass = $estatus == 0 ? 'white' : 'success';
				$cursoAsientoId = $row_CONSULTA['cursoAsientoId'];
				$titulo = $row_CONSULTA['tituloes'];
				$payment_id = $row_CONSULTA['payment_id'];
				$translation_payment_id = $row_CONSULTA['translation_payment_id'];
				$estatus_details = "";
				$tipo = isset($courseTypeLangs[$row_CONSULTA['tipo']]) ? $courseTypeLangs[$row_CONSULTA['tipo']] : 'N/A';

				if ($estatus) {
					$estatus_details .= "Curso pagado";
					if ($payment_id)
						$estatus_details .= " con PayPal";
				}

				if ($translationStatus) {
					if (!empty($estatus_details))
						$estatus_details .= "<br/>";
					$estatus_details .= "Traducción pagada";
					if ($translation_payment_id)
						$estatus_details .= " con PayPal";
				}

				if (!empty($estatus_details))
					$estatus_details = '<div style="font-size: 12px;">' . $estatus_details . '</div>';

				echo '
					<div class="padding-v-20">
						'.nl2br($titulo).'<br>
						<small>Tipo: '.$tipo.'</small><br>
						<button data-id="'.$cursoAsientoId.'" data-estatus="'.$estatus.'" class="estatus uk-button uk-button-'.$buttonClass.'">'.$textoEstatus.'</button>' . $estatus_details . '
					</div>';
			}
			echo '
				</td>
				<td class="uk-text-center">
					<a href="index.php?seccion=clientes&subseccion=detalle&id='.$row_USER['id'].'">
						'.$row_USER['alta'].'
					</a>
				</td>
				<td class="uk-text-center">
					<a href="index.php?seccion=clientes&subseccion=editar&id='.$row_USER['id'].'" class="uk-icon-button uk-button-primary" uk-icon="icon:pencil"></a>
					<button data-id="'.$row_USER['id'].'" class="eliminauser uk-icon-button uk-button-danger" uk-icon="icon:trash"></button>
				</td>
			</tr>';
		}

echo'
		</tbody>
	</table>
</div>

<div>
	<div id="buttons">
		<a href="index.php?seccion='.$seccion.'&subseccion=nuevo" id="add-button" class="uk-icon-button uk-button-primary uk-box-shadow-large" uk-icon="icon:plus;ratio:1.4"></a>
	</div>
</div>
';




$scripts='
<script>
	$(".estatus").click(function(){
		var id = $(this).data("id");
		var estatus = $(this).attr("data-estatus");
		if(estatus==0){
			estatus=1;
			$(this).attr("data-estatus",estatus)
			$(this).html("Pagado");
			$(this).removeClass("uk-button-white");
			$(this).addClass("uk-button-success");
		}else{
			estatus=0;
			$(this).attr("data-estatus",estatus)
			$(this).html("Registrado");
			$(this).removeClass("uk-button-success");
			$(this).addClass("uk-button-white");
		}
		$.ajax({
			method: "POST",
			url: "modulos/'.$seccion.'/acciones.php",
			data: { 
				estatusupdate: 1,
				id: id,
				estatus: estatus
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});
	})
</script>
';

?>
