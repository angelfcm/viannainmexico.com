<?php
$CONSULTA1 = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 9");
$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
?>
<!DOCTYPE html>
<html lang="<?=$languaje?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <title><?=html_entity_decode($titleTransporte)?></title>
  <meta name="description" content="<?=html_entity_decode($descriptionTransporte)?>">
  
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=html_entity_decode($titleTransporte)?>">
  <meta property="og:description" content="<?=html_entity_decode($descriptionTransporte)?>">
  <meta property="og:url" content="<?=$rutaEstaPagina?>">
  <meta property="og:image" content="<?=$rutaOG?>">
  <meta property="fb:app_id" content="<?=$appID?>">

  <?=$headGNRL?>

</head>

<body>
<?=$header?>

<!-- Cabecera -->
  <?php
  echo '
  <div class="uk-container">
    <div uk-grid>
      <div class="uk-width-1-1">
        <img src="../img/contenido/varios/'.$row_CONSULTA1['pic'.$languaje].'" class="uk-width-1-1" alt="taxi">
      </div>
      <div class="uk-width-1-1 uk-text-center">
        <img src="../img/contenido/varios/button2.png" alt="icono carritos">
      </div>
      <div class="uk-width-1-1">
        '.$row_CONSULTA1['cursotexto'.$languaje].'
      </div>
    </div>
  </div>
  ';
  ?>

  <div class="margen-v-20">
    &nbsp;
  </div>

<?=$footer?>

<?=$scriptGNRL?>

</body>
</html>
<?php
    mysqli_free_result($CONSULTA1);
?>