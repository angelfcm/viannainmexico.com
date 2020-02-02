<?php
$CONSULTA1 = $CONEXION -> query("SELECT * FROM gallery ORDER BY orden");
$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
$thisId=$row_CONSULTA1['id'];
?>
<!DOCTYPE html>
<html lang="<?=$languaje?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <title><?=html_entity_decode($titleCiudadSede)?></title>
  <meta name="description" content="<?=html_entity_decode($descriptionCiudadSede)?>">
  
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=html_entity_decode($titleCiudadSede)?>">
  <meta property="og:description" content="<?=html_entity_decode($descriptionCiudadSede)?>">
  <meta property="og:url" content="<?=$rutaEstaPagina?>">
  <meta property="og:image" content="<?=$rutaOG?>">
  <meta property="fb:app_id" content="<?=$appID?>">

  <?=$headGNRL?>

</head>

<body>
<?=$header?>

<!-- Cabecera -->
  <div class="uk-container">
    <div uk-grid>
      <div class="uk-width-1-1 margen-bottom-50">
        <?php
        $CONSULTA2 = $CONEXION -> query("SELECT * FROM gallerypic WHERE item = $thisId ORDER BY orden");
        $row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
        echo '<img src="../img/contenido/gallery/'.$row_CONSULTA2['id'].'-orig.jpg" class="uk-width-1-1" alt="'.$row_CONSULTA2['txt'].'">';
        ?>

      </div>
      <div class="uk-width-1-1">
        <?php
        $CONSULTA2 = $CONEXION -> query("SELECT * FROM gallerypic WHERE item = $thisId ORDER BY orden");
        $row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
        echo '
        <h2 class="uk-text-center uk-text-bold">'.$row_CONSULTA1['titulo'.$languaje].'</h2>
        <div class="uk-text-justify">
          '.$row_CONSULTA1['txt'.$languaje].'
        </div>
        ';
        ?>

      </div>

      <div class="uk-width-1-1 uk-text-center">
        <h3 class="uk-text-uppercase uk-text-bold"><?=$tituloCiudad?></h3>
      </div>

      <div class="uk-width-1-1">
         <div class="uk-column-1-2@s">
          <?php
          while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
          $thisId=$row_CONSULTA1['id'];
          $CONSULTA2 = $CONEXION -> query("SELECT * FROM gallerypic WHERE item = $thisId ORDER BY orden");
          while($row_CONSULTA2 = $CONSULTA2 -> fetch_assoc()){
          echo '
          <img src="../img/contenido/gallery/'.$row_CONSULTA2['id'].'-nat300.jpg" class="uk-width-1-1" alt="'.$row_CONSULTA2['txt'].'">';
          }

          echo '
          <h3 class="uk-text-center uk-text-bold">'.$row_CONSULTA1['titulo'.$languaje].'</h3>
          <div class="uk-text-justify">
            '.$row_CONSULTA1['txt'.$languaje].'
          </div>';
          }
          ?>

        </div>
      </div>

    </div>
  </div>

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