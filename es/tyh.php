<?php
$CONSULTA = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 7");
$row_CONSULTA = $CONSULTA -> fetch_assoc();
?>
<!DOCTYPE html>
<html lang="<?=$languaje?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <title><?=html_entity_decode($titleTransporteyHospedaje)?></title>
  <meta name="description" content="<?=html_entity_decode($descriptionTransporteyHospedaje)?>">
  
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=html_entity_decode($titleTransporteyHospedaje)?>">
  <meta property="og:description" content="<?=html_entity_decode($descriptionTransporteyHospedaje)?>">
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
  <div class="uk-container uk-container-small">
    <div uk-grid>
      <div class="uk-width-1-2@s padding-v-20 uk-text-center uk-text-uppercase text-xxl uk-text-bold">
        <a href="'.$rutaHos.'" class="color-primary">'.$hospedaje.'</a> 
        <br><br>
        <a href="'.$rutaHos.'"><img src="../img/contenido/varios/button1.png"><br><span class="color-gris-claro text-xs">'.$clicAqui.'</span></a> 
      </div>
      <div class="uk-width-1-2@s padding-v-20 uk-text-center uk-text-uppercase text-xxl uk-text-bold">
        <a href="'.$rutaTra.'" class="color-primary">'.$transporte.'</a>
        <br><br>
        <a href="'.$rutaTra.'"><img src="../img/contenido/varios/button2.png"><br><span class="color-gris-claro text-xs">'.$clicAqui.'</span></a> 
      </div>
      <div class="uk-width-1-1 padding-top-50 uk-text-center text-xl uk-text-uppercase color-gris-claro">
        '.$vuelosdirectos.'
      </div>
      <div class="uk-width-1-1 padding-bottom-50 uk-text-center">
        <img src="../img/contenido/varios/'.$row_CONSULTA['pic'.$languaje].'">
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
    mysqli_free_result($CONSULTA);
?>