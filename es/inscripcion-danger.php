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

<!-- Mensaje success -->
  <div class="uk-container uk-text-center">
    <div class="uk-alert-danger" uk-alert>
      <p>Ocurrió un error al procesar su inscripción.</p>
      <p>No pasó la verificación del captcha.</p>
    </div>
  </div>

  <div class="margen-v-20">
    &nbsp;
  </div>

<?=$footer?>

<?=$scriptGNRL?>

</body>
</html>