<!DOCTYPE html>
<html lang="<?=$languaje?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <title><?=html_entity_decode($titleSeminarios)?></title>
  <meta name="description" content="<?=html_entity_decode($descriptionSeminarios)?>">
  
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=html_entity_decode($titleSeminarios)?>">
  <meta property="og:description" content="<?=html_entity_decode($descriptionSeminarios)?>">
  <meta property="og:url" content="<?=$rutaEstaPagina?>">
  <meta property="og:image" content="<?=$rutaOG?>">
  <meta property="fb:app_id" content="<?=$appID?>">

  <?=$headGNRL?>

</head>

<body>
<?=$header?>

<!-- Encabezado -->
  <?php
  $CONSULTA0 = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
  $row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();
  $pic='../img/contenido/cursoscat/'.$row_CONSULTA0['pic'.$languaje];
  $picHtml=(!file_exists($pic))?$pic:'';
  echo '
  <div class="uk-width-1-1 margen-bottom-50">
    <img src="'.$picHtml.'" class="uk-width-1-1">
  </div>';
  $CONSULTA0 = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 3");
  $row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();
  ?>

<!-- Cursos -->
  <div class="uk-container">
    <div uk-grid class="uk-grid-match uk-child-width-1-3@m">
      <div class="uk-width-1-1">
        <div class="uk-card bg-pink color-blanco padding-top-10 uk-border-rounded">
          <h3 class="uk-text-center"><b><?=$textosemanarios?></b></h3>
        </div>
      </div>
      <div class="uk-width-1-1">
        <h3 class="uk-text-center"><b><?=$traduccionsincosto?></b></h3>
      </div>
    <?php
    $CONSULTA1 = $CONEXION -> query("SELECT * FROM cursos ORDER BY orden");
    while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
      $itemId=$row_CONSULTA1['id'];

      $pic='../img/contenido/cursosmain/'.$row_CONSULTA1['imagen1'];
      $picAuditorio=($row_CONSULTA1['imagen1']!='')?$pic:'#item'.$itemId;
      $picAuditorioLightbox=($row_CONSULTA1['imagen1']!='')?'uk-lightbox':'';

      $classHead=($row_CONSULTA1['destacado']==1)?'bg-pink':'bg-gris-medio';
      $circleNew=($row_CONSULTA1['destacado']==1)?'<div class="uk-position-absolute" style="right:10px;bottom:10px;"><img src="../img/design/nuevopink.png" alt="Círculo rosa con letras blancas que dicen nuevo" height="63px" width="63px"></div>':'';
      echo '  
        <div id="item'.$itemId.'">
          <div class="uk-card uk-card-default uk-border-rounded uk-position-relative">
            <div class="equal1 padding-10 color-blanco uk-border-rounded uk-text-center uk-text-uppercase '.$classHead.'">
              <span style="font-size:18px;"><b>'.nl2br($row_CONSULTA1['titulo'.$languaje]).'</b></span>
            </div>
            <div class="padding-10 equal2">
              <div class="min-height-40px">
                <p><img src="../img/design/ico-calendar.jpg" class="uk-float-left margen-right-10" alt="icono de calendario"><b class="uk-text-capitalize">'.$fechaTraduc.':</b> '.$row_CONSULTA1['fecha'.$languaje].'</p>
              </div>
              <div class="min-height-40px">
                <p><img src="../img/design/ico-time.jpg" class="uk-float-left margen-right-10" alt="icono de reloj"><b class="uk-text-capitalize">'.$horarioTraduc.':</b> '.$row_CONSULTA1['horario'.$languaje].'</p>
              </div>
              <div class="min-height-40px">
                <p><img src="../img/design/ico-money.jpg" class="uk-float-left margen-right-10 margen-v-10" alt="icono de dinero"><b>'.$dosPagos.':</b><br>'.nl2br($row_CONSULTA1['pagostexto'.$languaje]).'</p>
              </div>
              <div class="min-height-40px">
                <p><img src="../img/design/ico-checked.jpg" class="uk-float-left margen-right-10" alt="icono de selección"><b class="uk-text-capitalize">'.$prereqTraduc.':</b> '.$row_CONSULTA1['prerequisito'.$languaje].'</p>
              </div>
              <div class="min-height-40px">
                <p><img src="../img/design/ico-map.jpg" class="uk-float-left margen-right-10" alt="icono de mapa"><b class="uk-text-capitalize">'.$lugarTraduc.':</b> '.$row_CONSULTA1['lugar'.$languaje].'</p>
                <br><br>
              </div>
            </div>
            '.$circleNew.'
          </div>
        </div>
      ';
    }
    mysqli_free_result($CONSULTA1);
    ?>

    </div>
  </div>

  <div class="margen-v-20">
    &nbsp;
  </div>

  <div class="margen-v-20">
    <div class="uk-container">
      <div uk-grid class="">
        <div class="uk-width-1-3@s" uk-lightbox>
          <div class="bg-gris color-blanco uk-text-center uk-border-rounded">
            <h2 class="padding-v-20 uk-text-uppercase"><?=$sitMap?></h2>
          </div>
          <?php
          $CONSULTA1 = $CONEXION -> query("SELECT * FROM cursospic ORDER BY orden");
          while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
            echo '
          <div class="margen-v-20">
            <div class="uk-card uk-card-default uk-card-body uk-text-center uk-border-rounded">
              <a href="../img/contenido/cursos/'.$row_CONSULTA1['id'].'-orig.jpg">
                <img src="../img/contenido/cursos/'.$row_CONSULTA1['id'].'-sm.jpg">
              </a>
            </div>
          </div>';
          }
          ?>

        </div>
        <div class="uk-width-2-3@s text-sm uk-text-justify">
          <?=$row_CONSULTA0['cursotexto'.$languaje]?>
        </div>
      </div>
    </div>
  </div>

  <div class="margen-v-20">
    &nbsp;
  </div>

<?=$footer?>

<?=$scriptGNRL?>

<script>
  equalheight = function(container){
    var altoMax = 0,
        alto;
    $(container).each(function() {
      alto=$(this).height();
      if (alto>altoMax) { altoMax=alto; };
    });
    $(container).height(altoMax);
  }

    setTimeout(function(){
      equalheight('.equal1');
      equalheight('.equal2');
    },1000);
  $(window).resize(function(){
    $('.equal1').height('auto');
    $('.equal2').height('auto');
    equalheight('.equal1');
    equalheight('.equal2');
  });
</script>

</body>
</html>
<?php
    mysqli_free_result($CONSULTA0);
?>