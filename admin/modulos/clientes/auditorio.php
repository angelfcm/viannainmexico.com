<?php
$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $id");
$row_USER = $USER -> fetch_assoc();

$curso=$_REQUEST['curso'];
$CONSULTA = $CONEXION -> query("SELECT * FROM cursos WHERE id = $curso");
$row_CONSULTA = $CONSULTA -> fetch_assoc();

$CONSULTA1 = $CONEXION -> query("SELECT * FROM cursoasientos WHERE usuario = $id AND curso = $curso");
$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
$numRows = $CONSULTA1 ->num_rows;
$asiento=($numRows==1)? strtoupper($row_CONSULTA1['asiento']):'';
$notify=($numRows==1)? '<a class="uk-button uk-button-white" href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&notify=1&id='.$id.'&curso='.$curso.'&asiento='.$row_CONSULTA1['asiento'].'"><i uk-icon="icon:mail"></i> &nbsp; Notificar por correo</a>':'';


echo '
<div class="uk-width-1-1 margen-v-20">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'">Clientes</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'">Detalle de cliente</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=auditorio&id='.$id.'&curso='.$curso.'" class="color-red">Auditorio</a></li>
	</ul>
</div>


<div class="uk-width-1-1 uk-text-right">
	'.$notify.'
</div>


<div class="uk-width-1-1 uk-text-center">
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
			$thisAsiento=(chr($k).$j);
			if ($j==0) {
				echo'';
			}else{
				if ($asiento==$thisAsiento) {
					$clase='bg-black';
				}else{
					$CONSULTA2 = $CONEXION -> query("SELECT * FROM cursoasientos WHERE asiento = '$thisAsiento' AND curso = $curso");
					$numCONSULTA2 = $CONSULTA2 ->num_rows;
					if ($numCONSULTA2==0) {
						$clase='bg-test3 libre pointer';
					}else{
						$clase='bg-grey';
					}
				}
				echo'
				<td><div id="'.chr($k).$j.'" data-asiento="'.chr($k).$j.'" class="'.$clase.' uk-badge">'.chr($k).$j.'</div></td>';
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

';

$scripts='
	<script>
		$(".libre").click(function(){
			var asiento = $(this).data("asiento");
			UIkit.modal.confirm("Asignar asiento "+asiento).then(function() {
				console.log("Confirmado")
				window.location = ("index.php?seccion='.$seccion.'&subseccion=auditorio&asignar=1&id='.$id.'&curso='.$curso.'&asiento="+asiento);
			}, function () {
				console.log("Rechazado")
			});
		});
	</script>
	';
