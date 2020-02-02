<!DOCTYPE html>
<html lang="<?=$languaje?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <title><?=$title?></title>
  <meta name="description" content="<?=$description?>">
  
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=$title?>">
  <meta property="og:description" content="<?=$description?>">
  <meta property="og:url" content="<?=$rutaEstaPagina?>">
  <meta property="og:image" content="<?=$rutaOG?>">
  <meta property="fb:app_id" content="<?=$appID?>">

  <?=$headGNRL?>

</head>

<body>
<?=$header?>

<?php
require_once 'includes/languaje.php';
$rutaInsc =	$ruta.'inscripcion';
$paidCourses = $CONEXION -> query("SELECT curso FROM cursoasientos WHERE usuario = $id AND estatus = 1 GROUP BY curso ORDER BY curso")->fetch_all(MYSQLI_ASSOC);
?>

<?php if(count($paidCourses) == 0): ?>
<div class="uk-container"><h2 class="uk-text-center"><?php echo $noBeAbleToSelectSeatTxt; ?> <a href="<?php echo $rutaInsc; ?>"><strong><?php echo $menuInsc; ?></strong></a></h2></div>
<?php endif; ?>

<?php
foreach($paidCourses as $course){

	$curso = $course['curso'];
	$CONSULTA2 = $CONEXION -> query("SELECT id,asiento FROM cursoasientos WHERE usuario = $id AND curso = $curso");
	$row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
	$asiento=strtoupper($row_CONSULTA2['asiento']);
	$idAsiento=$row_CONSULTA2['id'];
	$libre='libre';	
	$estatus=0;
	$shareClass='uk-hidden';
	$selectClass='';

	if ($asiento!='') {
		$libre='';
		$estatus=1;
		$shareClass='';
		$selectClass='uk-hidden';
	}

	$CONSULTA = $CONEXION -> query("SELECT * FROM cursos WHERE id = $curso");
	$existe=$CONSULTA->num_rows;
	$row_CONSULTA = $CONSULTA -> fetch_assoc();

	$linkToShare=$ruta.$idAsiento.'_Miasientoen-mundoTH.html';
	$linkToShare=str_replace(':', '%3A', $linkToShare);

			

	if($existe!=0){
	echo '
	<div class="uk-width-1-1 uk-text-center padding-v-20">
		<div>
			<b>'.$row_CONSULTA['titulo'.$languaje].'</b>
		</div>
		<div id="share'.$curso.'" class="uk-width-1-1 uk-text-center '.$shareClass.'">
			<a class="uk-button uk-button-large uk-button-personal uk-margin-top" href="https://twitter.com/intent/tweet?text='.$linkToShare.'&ref=plugin&src=share_button&button_hashtag=mundoTH&screen_name=thethetahealing" target="_blank"><span uk-icon="icon:twitter"></span> &nbsp; '.$compartir.' Twitter</a>
			<a class="uk-button uk-button-large uk-button-personal uk-margin-top" href="https://www.facebook.com/sharer/sharer.php?u='.$linkToShare.'" target="_blank"><span uk-icon="icon:facebook"></span> &nbsp; '.$compartir.' facebook</a>
			<h2>'.$asientoAsignado.'</h2>
		</div>
		<div id="select'.$curso.'" class="uk-width-1-1 uk-text-center '.$selectClass.'">
			'.$seleccionaasiento.'
		</div>
		<div class="uk-width-1-1 uk-text-center">
			<table class="uk-flex uk-flex-center" id="curso'.$row_CONSULTA['id'].'">
				<tr>
					<td colspan="'.$row_CONSULTA['asientoscol'].'"><div class="bg-grey uk-text-muted uk-text-uppercase" style="border-radius:0 0 50% 50%;font-size:12px;">'.$escenario.'</div></td>
				</tr>';
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
								$clase='bg-test3 '.$libre.' pointer';
							}else{
								$clase='bg-grey';
							}
						}
						echo'
						<td><div id="'.chr($k).$j.'-'.$row_CONSULTA['id'].'" data-curso="'.$row_CONSULTA['id'].'" data-estatus="'.$estatus.'" data-asiento="'.chr($k).$j.'" class="'.$clase.' uk-badge">'.chr($k).$j.'</div></td>';
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
	</div>
	';
	}
}
?>

	<div class="padding-v-50">
		&nbsp;
	</div>


<?=$footer?>

<?=$scriptGNRL?>

<?php
	echo '
	<script>
		$(".libre").click(function(){
			console.log("entra");
			var asiento = $(this).data("asiento");
			var curso = $(this).data("curso");
			var estatus = $(this).attr("data-estatus");

			if(estatus==0){
				UIkit.modal.confirm("'.$asignarasiento.' "+asiento).then(function() {
					$("#curso"+curso+" .libre").removeClass("bg-test3");
					$("#curso"+curso+" .libre").removeClass("pointer");
					$("#curso"+curso+" div").addClass("bg-grey");
					$("#curso"+curso+" div").attr("data-estatus",1);
					$("#"+asiento+"-"+curso).removeClass("bg-grey");
					$("#"+asiento+"-"+curso).addClass("bg-black");

					$.ajax({
						method: "POST",
						url: "../includes/acciones.php",
						data: { 
							asignarasiento: 1,
							asiento: asiento,
							curso: curso,
							uid: '.$id.'
						}
					})
					.done(function( msg ) {
						if (msg == "is_taken") {
							UIkit.modal.alert("El asiento ya ha sido tomado por alguien más, vuelve a seleccionar.").then(function () {
								location.reload();
							});
						}
						else if(msg!=\'fallo\'){
							console.log(msg);
						}else{
							UIkit.notification.closeAll();
							UIkit.notification("<span class=\'uk-notification-message uk-notification-message-danger\'><span uk-icon=\'icon: close;ratio:2;\'></span> &nbsp; No se encuentra el email</span>");
						}
					});
			
					$("#share"+curso).removeClass("uk-hidden");
					$("#select"+curso).addClass("uk-hidden");
					console.log(curso);

				}, function () {
					console.log("Rechazado")
				});
			}
		});
	</script>';
?>

</body>
</html>