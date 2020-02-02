<?php
$CONSULTA8 = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 8");
$row_CONSULTA8 = $CONSULTA8 -> fetch_assoc();
?>
<!DOCTYPE html>
<html lang="<?=$languaje?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <title><?=html_entity_decode($titleHospedaje)?></title>
  <meta name="description" content="<?=html_entity_decode($descriptionHospedaje)?>">
  
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=html_entity_decode($titleHospedaje)?>">
  <meta property="og:description" content="<?=html_entity_decode($descriptionHospedaje)?>">
  <meta property="og:url" content="<?=$rutaEstaPagina?>">
  <meta property="og:image" content="<?=$rutaOG?>">
  <meta property="fb:app_id" content="<?=$appID?>">

  <?=$headGNRL?>

</head>

<body>
<?=$header?>

<!-- Cabecera -->
  <?php
  $variable='hotel1';
  $CONSULTA1 = $CONEXION -> query("SELECT * FROM traduccion WHERE variable = '$variable'");
  $row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
  echo '
  <div class="uk-container">
    <div uk-grid>
      <div class="uk-width-1-1 padding-v-20">
        <h1 class=" uk-text-center uk-text-uppercase uk-text-bold color-gris-claro">'.$hospedajetitle.'</h1> 
      </div>
    </div>
    <div class="uk-width-1-1 text-sm">
      <div uk-grid class="uk-grid-collapse">
        <div class="uk-width-1-2@s padding-top-100 uk-text-center">
          <div class="uk-position-relative uk-text-center">
            <a href="'.$row_CONSULTA8['cursotextoja'].'" target="_blank"><img src="../img/contenido/varios/'.$row_CONSULTA8['pices'].'" class="uk-width-1-1"></a>
            <br>
            '.$row_CONSULTA8['cursotextoes'].'<br>
            '.$telefono.': '.$row_CONSULTA8['cursotextoen'].'<br>
            <a href="'.$row_CONSULTA8['cursotextoru'].'" target="_blank"><i uk-icon="icon:location"></i></a>
            <div class="uk-position-absolute" style="top:-30px;left:50%;margin-left:-130px;">
              <img src="../img/contenido/varios/'.$row_CONSULTA8['picen'].'" class="uk-box-shadow-large uk-border-rounded">
            </div>
          </div>
        </div>
        <div class="uk-width-1-2@s padding-top-100 uk-text-center">
          <div class="uk-position-relative uk-text-center">
            <a href="'.$row_CONSULTA8['pagosja'].'" target="_blank"><img src="../img/contenido/varios/'.$row_CONSULTA8['picja'].'" class="uk-width-1-1"></a>
            <br>
            '.$row_CONSULTA8['pagoses'].'<br>
            '.$telefono.': '.$row_CONSULTA8['pagosen'].'<br>
            <a href="'.$row_CONSULTA8['pagosru'].'" target="_blank"><i uk-icon="icon:location"></i></a>
            <div class="uk-position-absolute" style="top:-30px;left:50%;margin-left:-130px;">
              <img src="../img/contenido/varios/'.$row_CONSULTA8['picru'].'" class="uk-box-shadow-large uk-border-rounded">
            </div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-1 padding-top-50 uk-text-center text-xl uk-text-uppercase color-gris-claro">
        '.$hotel2.'
      </div>
      <div class="uk-width-1-1 padding-v-20 uk-text-center">
        <div class="uk-column-1-2@s">';

    $CONSULTA = $CONEXION -> query("SELECT * FROM hoteles ORDER BY orden");
    while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
      echo '
          <div class="padding-v-20">
            <a href="'.$row_CONSULTA['url'].'" class="uk-button uk-button-personal uk-width-1-1" target="_blank">'.$row_CONSULTA['titulo'].'</a>
          </div>';
}
echo '
        </div>
      </div>
      <div class="uk-width-1-1 padding-v-20 uk-text-center text-xl uk-text-uppercase color-gris-claro">
        '.$moreOptions.'
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
    mysqli_free_result($CONSULTA8);
?>