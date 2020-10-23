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
$claseAccordion='class="uk-open"';
$CONSULTA1 = $CONEXION -> query("SELECT curso FROM cursoasientos WHERE usuario = $id GROUP BY curso ORDER BY curso");
while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
	$curso=$row_CONSULTA1['curso'];
	$numRows = $CONSULTA1 ->num_rows;

	$asiento='';
	if ($numRows!=0) {
		$CONSULTA2 = $CONEXION -> query("SELECT * FROM cursoasientos WHERE usuario = $id AND curso = $curso");
		$row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
		$asiento=strtoupper($row_CONSULTA2['asiento']);
	}

	$CONSULTA = $CONEXION -> query("SELECT * FROM cursos WHERE id = $curso");
	$row_CONSULTA = $CONSULTA -> fetch_assoc();

	$linkToShare=$ruta.$row_CONSULTA2['id'].'_Miasientoen-mundoTH.html';
	$linkToShare=str_replace(':', '%3A', $linkToShare);


	echo '
	<div class="uk-width-1-1 uk-text-center padding-v-20">
		<ul uk-accordion>
			<li '.$claseAccordion.'>
				<h3 class="uk-accordion-title">'.$row_CONSULTA['titulo'.$languaje].'</h3>
				<div class="uk-accordion-content">
					<div class="uk-width-1-1 uk-text-center">
						<p>'.$sehaguardado.'</p>
					</div>
					<div class="uk-width-1-1 padding-v-50 uk-text-center">
						<a class="uk-button uk-button-large uk-button-personal uk-margin-top" href="https://twitter.com/intent/tweet?text='.$linkToShare.'&ref=plugin&src=share_button&button_hashtag=mundoTH&screen_name=thethetahealing" target="_blank"><span uk-icon="icon:twitter"></span> &nbsp; Compartir en Twitter</a>
						<a class="uk-button uk-button-large uk-button-personal uk-margin-top" href="https://www.facebook.com/sharer/sharer.php?u='.$linkToShare.'" target="_blank"><span uk-icon="icon:facebook"></span> &nbsp; Compartir en facebook</a>
					</div>
					<div class="uk-width-1-1 uk-text-center">
						<table class="uk-flex uk-flex-center">
							<tr>
								<td colspan="'.$row_CONSULTA['asientoscol'].'"><div class="bg-grey uk-text-muted uk-text-uppercase" style="border-radius:0 0 50% 50%;font-size:12px;">'.$escenario.'</div></td>
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
									<td><div id="'.chr($k).$j.'" data-curso="'.$row_CONSULTA['id'].'" data-asiento="'.chr($k).$j.'" class="'.$clase.' uk-badge">'.chr($k).$j.'</div></td>';
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
			</li>
		</ul>
	</div>


	';
	$claseAccordion='';
}
?>

	<div class="padding-v-50">
		&nbsp;
	</div>


<?=$footer?>

<?=$scriptGNRL?>

</body>
</html>