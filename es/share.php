<?php
$CONSULTA1 = $CONEXION -> query("SELECT * FROM cursoasientos WHERE id = $id");
$numRows = $CONSULTA1 ->num_rows;
$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();

if ($numRows!=0) {
	$asiento=strtoupper($row_CONSULTA1['asiento']);
	$curso=$row_CONSULTA1['curso'];

	$CONSULTA2 = $CONEXION -> query("SELECT * FROM cursos WHERE id = $curso");
	$row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();

	$logoOG=$ruta.'../img/contenido/cursosmain/'.$row_CONSULTA2['imagen'];
}else{
	$asiento='';
	$curso='';
	$logoOG=$ruta.'../img/design/logo-og.jpg';
}
?>
<!DOCTYPE html>
<html lang="<?=$languaje?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <title>Me inscribí al curso <?=html_entity_decode($row_CONSULTA2['tituloes'])?></title>
  <meta name="description" content="Los días <?=html_entity_decode($row_CONSULTA2['fechaes'])?> asistiré al curso <?=html_entity_decode($row_CONSULTA2['tituloes'])?>. Mi número de asiento es el <?=$asiento?>.">
  
  <meta property="og:type" content="website">
  <meta property="og:title" content="Amigos Healers, ya estoy inscrito al curso <?=$row_CONSULTA2['tituloes']?>">
  <meta property="og:description" content="Los días <?=$row_CONSULTA2['fechaes']?> asistiré al curso <?=$row_CONSULTA2['tituloes']?>. Mi número de asiento es el <?=$asiento?>. Inscríbete y selecciona tu asiento para estar juntos :D">
  <meta property="og:url" content="<?=$rutaEstaPagina?>">
  <meta property="og:image" content="<?=$logoOG?>">
  <meta property="fb:app_id" content="<?=$appID?>">

  <?=$headGNRL?>

</head>

<body>
<?=$header?>

<?php
$claseAccordion='class="uk-open"';
$CONSULTA1 = $CONEXION -> query("SELECT curso FROM cursoasientos WHERE id = $id");
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


	echo '
	<div class="uk-width-1-1 uk-text-center padding-v-20">
		<ul uk-accordion>
			<li '.$claseAccordion.'>
				<h3 class="uk-accordion-title">'.$row_CONSULTA['titulo'.$languaje].' XD</h3>
				<div class="uk-accordion-content">
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