<!DOCTYPE html>
<html lang="<?=$languaje?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <title><?=html_entity_decode($titleInicio)?></title>
  <meta name="description" content="<?=html_entity_decode($descriptionInicio)?>">
  
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=html_entity_decode($titleInicio)?>">
  <meta property="og:description" content="<?=html_entity_decode($descriptionInicio)?>">
  <meta property="og:url" content="<?=$rutaEstaPagina?>">
  <meta property="og:image" content="<?=$rutaOG?>">
  <meta property="fb:app_id" content="<?=$appID?>">

  <?=$headGNRL?>

  <link rel="stylesheet" href="../library/amazingslider/amazingslider-1.css?123" type="text/css">

</head>

<body>
<?=$header?>

<!-- CARRUSEL -->
  <?php
  $tabla='carousel'.$languaje;
  // Configuracion
  $ANIM = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
  $rowANIM = $ANIM -> fetch_assoc();
  $carouselSize=($rowANIM['num2']==0)?'width-1-1':'container';
  //$es_movil=TRUE;
  $tabla=($es_movil===TRUE)?'carouselmovil'.$languaje:'carousel'.$languaje;
  // Carousel data
  $CAROUSEL = $CONEXION -> query("SELECT * FROM $tabla ORDER BY orden,id");
  $numPics=$CAROUSEL->num_rows;

  if($numPics>1){
  echo '
  <div class="uk-'.$carouselSize.'">
    <div id="carousel" style="display:block;position:relative;margin:0 auto;">
      <ul class="amazingslider-slides" style="display:none;">';
        $num=0;
        $dots='';
        $activo=' active';
        while ($row_CAROUSEL = $CAROUSEL -> fetch_assoc()) {
          if (IS_RUSSIAN_DOMAIN) {
            $dots.='
                <li><img src="https://viannainmexico.com/img/contenido/'.$tabla.'/'.$row_CAROUSEL['id'].'-xs.jpg" alt="'.$row_CAROUSEL['titulo'].'" title="'.$row_CAROUSEL['titulo'].'"></li>';
            if ($row_CAROUSEL['url']=='') {
              echo '
                <li><img src="https://viannainmexico.com/img/contenido/'.$tabla.'/'.$row_CAROUSEL['id'].'-orig.jpg" alt="'.$row_CAROUSEL['titulo'].'"  title="'.$row_CAROUSEL['titulo'].'" data-description="'.$row_CAROUSEL['txt'].'" data-texteffect="Red box"></li>';
            }else{
              if (strpos($row_CAROUSEL['url'], $dominio)) {
                echo '
                <li><a href="'.$row_CAROUSEL['url'].'"><img src="https://viannainmexico.com/img/contenido/'.$tabla.'/'.$row_CAROUSEL['id'].'-orig.jpg" alt="'.$row_CAROUSEL['titulo'].'"  title="'.$row_CAROUSEL['titulo'].'" data-description="'.$row_CAROUSEL['txt'].'" data-texteffect="Red box"></a></li>';
              }else{
                echo '
                <li><a href="'.$row_CAROUSEL['url'].'" target="_blank"><img src="https://viannainmexico.com/img/contenido/'.$tabla.'/'.$row_CAROUSEL['id'].'-orig.jpg" alt="'.$row_CAROUSEL['titulo'].'"  title="'.$row_CAROUSEL['titulo'].'" data-description="'.$row_CAROUSEL['txt'].'" data-texteffect="Red box"></a></li>';
              }
            }
          } else {
            $dots.='
                <li><img src="../img/contenido/'.$tabla.'/'.$row_CAROUSEL['id'].'-xs.jpg" alt="'.$row_CAROUSEL['titulo'].'" title="'.$row_CAROUSEL['titulo'].'"></li>';
            if ($row_CAROUSEL['url']=='') {
              echo '
                <li><img src="../img/contenido/'.$tabla.'/'.$row_CAROUSEL['id'].'-orig.jpg" alt="'.$row_CAROUSEL['titulo'].'"  title="'.$row_CAROUSEL['titulo'].'" data-description="'.$row_CAROUSEL['txt'].'" data-texteffect="Red box"></li>';
            }else{
              if (strpos($row_CAROUSEL['url'], $dominio)) {
                echo '
                <li><a href="'.$row_CAROUSEL['url'].'"><img src="../img/contenido/'.$tabla.'/'.$row_CAROUSEL['id'].'-orig.jpg" alt="'.$row_CAROUSEL['titulo'].'"  title="'.$row_CAROUSEL['titulo'].'" data-description="'.$row_CAROUSEL['txt'].'" data-texteffect="Red box"></a></li>';
              }else{
                echo '
                <li><a href="'.$row_CAROUSEL['url'].'" target="_blank"><img src="../img/contenido/'.$tabla.'/'.$row_CAROUSEL['id'].'-orig.jpg" alt="'.$row_CAROUSEL['titulo'].'"  title="'.$row_CAROUSEL['titulo'].'" data-description="'.$row_CAROUSEL['txt'].'" data-texteffect="Red box"></a></li>';
              }
            }
          }
        }

        echo '
      </ul>
      <ul class="amazingslider-thumbnails" style="display:none;">
        '.$dots.'

      </ul>
    </div>
  </div>
  ';
  }else{
    $row_CAROUSEL = $CAROUSEL -> fetch_assoc();

    if (IS_RUSSIAN_DOMAIN) {
      if (strpos($row_CAROUSEL['url'], $dominio)) {
        echo '
          <div class="uk-'.$carouselSize.'">
            <a href="'.$row_CAROUSEL['url'].'"><img src="http://viannainmexico.com/img/contenido/'.$tabla.'/'.$row_CAROUSEL['id'].'-orig.jpg" class="uk-width-1-1" alt="'.$row_CAROUSEL['titulo'].'"  title="'.$row_CAROUSEL['titulo'].'" data-description="'.$row_CAROUSEL['txt'].'" data-texteffect="Red box"></a>
          </div>';
      }else{
        echo '
          <div class="uk-'.$carouselSize.'">
            <img src="http://viannainmexico.com/img/contenido/'.$tabla.'/'.$row_CAROUSEL['id'].'-orig.jpg" class="uk-width-1-1" alt="'.$row_CAROUSEL['titulo'].'"  title="'.$row_CAROUSEL['titulo'].'">
          </div>';
      }
    } else {
      if (strpos($row_CAROUSEL['url'], $dominio)) {
        echo '
          <div class="uk-'.$carouselSize.'">
            <a href="'.$row_CAROUSEL['url'].'"><img src="../img/contenido/'.$tabla.'/'.$row_CAROUSEL['id'].'-orig.jpg" class="uk-width-1-1" alt="'.$row_CAROUSEL['titulo'].'"  title="'.$row_CAROUSEL['titulo'].'" data-description="'.$row_CAROUSEL['txt'].'" data-texteffect="Red box"></a>
          </div>';
      }else{
        echo '
          <div class="uk-'.$carouselSize.'">
            <img src="../img/contenido/'.$tabla.'/'.$row_CAROUSEL['id'].'-orig.jpg" class="uk-width-1-1" alt="'.$row_CAROUSEL['titulo'].'"  title="'.$row_CAROUSEL['titulo'].'">
          </div>';
      }
    }
  }
  mysqli_free_result($CAROUSEL);
  ?>

  <div class="padding-v-20">
    &nbsp;
  </div>

  <?=$footer?>


<?=$scriptGNRL?>

<script src="../library/amazingslider/amazingslider.js"></script>

<?php

if ($es_movil===FALSE) {
  switch ($rowANIM['num1']) {
    case 0:
      echo '<script src="../library/amazingslider/fade.js"></script>';
      break;
    case 1:
      echo '<script src="../library/amazingslider/slide.js"></script>';
      break;
    case 2:
      echo '<script src="../library/amazingslider/elastic.js"></script>';
      break;
    case 3:
      echo '<script src="../library/amazingslider/blinds.js"></script>';
      break;
    case 4:
      echo '<script src="../library/amazingslider/slice.js"></script>';
      break;
    case 5:
      echo '<script src="../library/amazingslider/blocks.js"></script>';
      break;
    case 6:
      echo '<script src="../library/amazingslider/tiles.js"></script>';
      break;
    case 7:
      echo '<script src="../library/amazingslider/none.js"></script>';
      break;
  }
}else{
  echo '<script src="../library/amazingslider/movil.js"></script>';
}
mysqli_free_result($ANIM);

?>

</body>
</html>