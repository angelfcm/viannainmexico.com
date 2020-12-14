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
$rutaInsc =	$ruta.'inscripcion';
echo '

  <div class="uk-container uk-text-center">
    <div>
      <h1 style="text-transform: uppercase">'.$mensaje.'</h1>
    </div>
    <div>
      <!-- <p>'.$paracompletarregistro.'</p> -->
      <p>'.$proporcioneemail.'</p>
      <input type="email" id="loginemail" class="uk-input uk-form-width-large" autofocus><button id="loginsend" class="uk-button uk-button-personal">'.$enviar.'</button>
    </div>
    <div>
      <br><br><br>
        '.$goToRegistrationTxt.'
          <a href="'.$rutaInsc.'"><strong>'.$menuInsc.'</strong></a>
      './*$formulario2*/''.'<br><br>
    </div>
  </div>


  <!-- Formato de inscripción -->
  <form style="display:none" method="POST" id="form" action="../includes/acciones.php">
    <input type="hidden" name="registro2" value="1">
    <input type="hidden" name="languaje" value="'.$languaje.'">
    <div class="uk-container">
      <div uk-grid class="uk-child-width-1-2@m">

        <div>
          <label>'.$Nombre.'</label>
          <input type="text" id="nombre" name="nombre" class="uk-input" >
          <br><br>
          <label>'.$apellido.'</label>
          <input type="text" id="apellido" name="apellido" class="uk-input">
          <br><br>
          <label>'.$email.'</label>
          <input type="email" id="email" name="email" class="uk-input">
          <br><br>
          <label>'.$formGafet.'</label>
          <input type="text" id="gafet" name="gafet" class="uk-input">
          <br><br>
          <label>'.$nacimiento.'</label>
          <input type="text" id="nacimiento" name="nacimiento" class="uk-input">
          <br><br>
          <label>'.$telefono.'</label>
          <input type="text" id="telefono" name="telefono" class="uk-input">
          <br><br>
          <label>'.$formEmergencia.'</label>
          <input type="text" id="emergencia" name="emergencia" class="uk-input">
          <br><br>
          <label>'.$direccion.'</label>
          <textarea id="direccion" name="direccion" class="uk-textarea"></textarea>
          <br><br>
          <label>'.$pais.'</label>
          <input type="text" id="pais" name="pais" class="uk-input">
          <br><br>
        </div>
        <div>
          <div>
          '.$formCurso.'
          </div>';

      $CONSULTA1 = $CONEXION -> query("SELECT * FROM cursos ORDER BY orden");
      while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
        $itemId=$row_CONSULTA1['id'];

        $pic='../img/contenido/cursosmain/'.$row_CONSULTA1['imagen1'];
        $picAuditorio=($row_CONSULTA1['imagen1']!='')?$pic:'#item'.$itemId;
        $picAuditorioLightbox=($row_CONSULTA1['imagen1']!='')?'uk-lightbox':'';

        $classHead=($row_CONSULTA1['destacado']==1)?'bg-pink':'bg-gris-medio';
        $circleNew=($row_CONSULTA1['destacado']==1)?'<div class="uk-position-absolute" style="right:10px;bottom:10px;"><img src="../img/design/nuevopink.png" alt="Círculo rosa con letras blancas que dicen nuevo" height="63px" width="63px"></div>':'';
        echo '  
        <div class="uk-margin">
          <label>
            <div uk-grid>
              <div>
                <input type="checkbox" name="curso'.$itemId.'" id="curso'.$itemId.'" value="'.$itemId.'" class="uk-checkbox">
              </div>
              <div class="uk-width-expand">
                <label for="curso'.$itemId.'">
                  '.$row_CONSULTA1['titulo'.$languaje].'
                </label>
              </div>
            </div>
          </label>
        </div>';
      }
      mysqli_free_result($CONSULTA1);
      echo'
          <label>'.$formInvita.'</label>
          <input type="text" id="invita" name="invita" class="uk-input">
          <br><br>
          <label>
            '.$formTraductor.'<br>
            <span class="text-sm">('.$traduccionsincosto.')</span>
          </label>
          <div uk-grid>
            <div class="uk-width-1-1">
              <label><input class="uk-radio" type="radio" value="0" name="traduc" id="traduc0" name="traduc0" checked> '.$no.'</label>
            </div>
            <div>
              <label><input class="uk-radio" type="radio" value="1" name="traduc" id="traduc1" name="traduc1"> '.$si.'</label>
            </div>
            <div class="uk-width-expand">
              <select name="traductor" id="traductor" class="uk-select" disabled">
                <option value="No"></option>
                <option value="Español">'.$espanol.'</option>
                <option value="Japonés">'.$japones.'</option>
                <option value="Ruso">'.$ruso.'</option>
                <option value="Portugués">'.$portugues.'</option>
                <option value="Húngaro">'.$hungaro.'</option>
                <option value="Chino">'.$chino.'</option>
                <option value="Turco">'.$turco.'</option>
              </select>
            </div>
          </div>

          <div class="uk-margin">
            <label>
              '.$materialLangLabelTxt.'<br>
            </label>
            <select name="materialLang" id="materialLang" class="uk-select" disabled">
              <option value="No"></option>
              <option value="Español">'.$espanol.'</option>
              <option value="Japonés">'.$japones.'</option>
              <option value="Ruso">'.$ruso.'</option>
              <option value="Portugués">'.$portugues.'</option>
              <option value="Húngaro">'.$hungaro.'</option>
              <option value="Chino">'.$chino.'</option>
              <option value="Turco">'.$turco.'</option>
            </select>
          </div>
          <div>
            <br><br>
            <label id="mayorlabel"><input class="uk-checkbox" type="checkbox" value="1" id="mayor" name="mayor"> '.$formMayor.'</label>
          </div>
          <div>
            <br><br>
            <input class="uk-checkbox" type="checkbox" value="1" id="politicas" name="politicas"> '.$formPoliticas.' <a href="#modal" uk-toggle class="uk-text-underline uk-text-bold">'.$politicastitle.'</a>
            <br><br>
          </div>
          <div>
            <div class="g-recaptcha" data-sitekey="6LfemlQUAAAAAHUZ0-iNKN35hHJCCcukHimwMhVy"></div>
          </div>
        </div>
        <div class="uk-width-1-1 uk-text-center">
          <button class="uk-button uk-button-personal uk-button-large" id="send">'.$enviar.'</button>
        </div>
        <div id="mensajes" class="uk-width-1-1">
        </div>
          ';
      ?>

      </div>
    </div>
  </form>

  <div class="margen-v-20">
    &nbsp;
  </div>

  <div id="modal" uk-modal class="uk-modal-container">
    <div class="uk-modal-dialog text-sm">
      <a href="" class="uk-modal-close uk-close"></a>
      <div class="uk-modal-header uk-text-uppercase">
        <?=$politicastitle?>
      </div>
      <div class="uk-modal-body">
        <?php
        $CONSULTA0 = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 3");
        $row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();
        echo $row_CONSULTA0['cursotexto'.$languaje];
        mysqli_free_result($CONSULTA0);
        ?>
      </div>
      <div class="uk-modal-footer uk-text-right">
        <button class="uk-button uk-button-default uk-modal-close" type="button"><?=$cerrar?></button>
      </div>
    </div>
  </div>


<?=$footer?>

<?=$scriptGNRL?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src='https://www.google.com/recaptcha/api.js'></script>

<script>
  $( function() {
    $( "#nacimiento" ).datepicker({
      minDate: "-90Y",
      maxDate: "-18Y",
      changeMonth: true,
      changeYear: true
    });
    $("#nacimiento").datepicker( "option", "dateFormat", "dd-mm-yy" );
    $("#nacimiento").datepicker( "setDate", "1-1-1980" );
  } );
</script>

<script>
  $('#traduc0').click(function(){
    $('#traductor').val( "" );
    $('#traductor').prop( "disabled", true );
  })
  $('#traduc1').click(function(){
    $('#traductor').prop( "disabled", false );
    $('#traductor').focus();
  })
</script>

<script>
  //Envío de registro
  $('#send').click(function(event){
    event.preventDefault();
    var mayor=$('#mayor').prop('checked');
    var politicas=$('#politicas').prop('checked');
    var nombre=$('#nombre').val();
    var apellido=$('#apellido').val();
    var email=$('#email').val();
    var l=email.length;
    var a=email.indexOf("@");
    var gafet=$('#gafet').val();
    var nacimiento=$('#nacimiento').val();
    var telefono=$('#telefono').val();
    var emergencia=$('#emergencia').val();
    var direccion=$('#direccion').val();
    var pais=$('#pais').val();
    var invita=$('#invita').val();
    var traductor=$('#traductor').val();
    var curso=$('#curso').val();
    var materialLang = $('#materialLang').val();
    var fallo=0;
    if (mayor==false) { alert("<?=html_entity_decode($formMayorVerify)?>"); fallo=1; $('#mayorlabel').css("color","red"); }else{ $('#mayorlabel').css("color","#333"); }
    if (politicas==false && fallo==0) { alert("Debe aceptar las políticas de cancelación"); fallo=1; $('#politicaslabel').css("color","red"); }else{ $('#politicaslabel').css("color","#333"); }
    if (nombre==false && fallo==0) { alert("<?=html_entity_decode($formVerifyTxt)?> <?=html_entity_decode($Nombre)?>"); fallo=1; $('#nombre').addClass("uk-form-danger"); $('#nombre').focus(); }else{ $('#nombre').removeClass("uk-form-danger"); }
    if (apellido==false && fallo==0) { alert("<?=html_entity_decode($formVerifyTxt)?> <?=html_entity_decode($apellido)?>"); fallo=1; $('#apellido').addClass("uk-form-danger"); $('#apellido').focus(); }else{ $('#apellido').removeClass("uk-form-danger"); }
    if (email==false && fallo==0) { alert("<?=html_entity_decode($formVerifyTxt)?> <?=html_entity_decode($email)?>"); fallo=1; $('#email').addClass("uk-form-danger"); $('#email').focus(); }else{ $('#email').removeClass("uk-form-danger"); }
    if (l<5 && fallo==0) { alert("Debe escribir un email valido"); fallo=1; $('#email').addClass("uk-form-danger"); $('#email').focus(); }
    if (a<2 && fallo==0) { alert("Debe escribir un email valido"); fallo=1; $('#email').addClass("uk-form-danger"); $('#email').focus(); }
    if (gafet==false && fallo==0) { alert("<?=html_entity_decode($formVerifyTxt)?> <?=html_entity_decode($formGafet)?>"); fallo=1; $('#gafet').addClass("uk-form-danger"); $('#gafet').focus(); }else{ $('#gafet').removeClass("uk-form-danger"); }
    if (nacimiento==false && fallo==0) { alert("<?=html_entity_decode($formVerifyTxt)?> <?=html_entity_decode($nacimiento)?>"); fallo=1; $('#nacimiento').addClass("uk-form-danger"); $('#nacimiento').focus(); }else{ $('#nacimiento').removeClass("uk-form-danger"); }
    if (telefono==false && fallo==0) { alert("<?=html_entity_decode($formVerifyTxt)?> <?=html_entity_decode($telefono)?>"); fallo=1; $('#telefono').addClass("uk-form-danger"); $('#telefono').focus(); }else{ $('#telefono').removeClass("uk-form-danger"); }
    if (emergencia==false && fallo==0) { alert("<?=html_entity_decode($formVerifyTxt)?> <?=html_entity_decode($formEmergencia)?>"); fallo=1; $('#emergencia').addClass("uk-form-danger"); $('#emergencia').focus(); }else{ $('#emergencia').removeClass("uk-form-danger"); }
    if (direccion==false && fallo==0) { alert("<?=html_entity_decode($formVerifyTxt)?> <?=html_entity_decode($direccion)?>"); fallo=1; $('#direccion').addClass("uk-form-danger"); $('#direccion').focus(); }else{ $('#direccion').removeClass("uk-form-danger"); }
    if (pais==false && fallo==0) { alert("<?=html_entity_decode($formVerifyTxt)?> <?=html_entity_decode($pais)?>"); fallo=1; $('#pais').addClass("uk-form-danger"); $('#pais').focus(); }else{ $('#pais').removeClass("uk-form-danger"); }
    if (invita==false && fallo==0) { alert("<?=html_entity_decode($formVerifyTxt)?> <?=html_entity_decode($formInvita)?>"); fallo=1; $('#invita').addClass("uk-form-danger"); $('#invita').focus(); }else{ $('#invita').removeClass("uk-form-danger"); }

    // Verifies that translation of the course is selected when it is checked as yes.
    if ($("#form")[0].traduc.value == "1" && fallo==0) {
      if ($.isEmptyObject(traductor) || traductor == 'No') {
        alert("<?=html_entity_decode($requireFormTranslationLangTxt)?>"); 
        fallo=1; 
        $('#traductor').addClass("uk-form-danger"); 
        $('#traductor').focus(); 
      }
      else 
        $('#traductor').removeClass("uk-form-danger");
    }
    // Verifies that material language is selected.
    if (fallo==0) {
      if ($.isEmptyObject(materialLang) || materialLang == 'No') {
        alert("<?=html_entity_decode($requireFormMaterialLangTxt)?>"); 
        fallo=1; 
        $('#materialLang').addClass("uk-form-danger"); 
        $('#materialLang').focus(); 
      }
      else 
        $('#materialLang').removeClass("uk-form-danger");
    }    
    
    if (fallo==0) {
      $(this).prop("disabled",true);
      $(this).html("<div uk-spinner></div>");
      $('#form').submit();
    };
  })
</script>

<script>
$('#loginsend').click(function(){
  var fallo=0;
  var email=$('#loginemail').val();
  var l=email.length;
  var a=email.indexOf("@");
  if (email==false && fallo==0) { alert("<?=$formVerifyTxt?> <?=html_entity_decode($email)?>"); fallo=1; $('#loginemail').addClass("uk-form-danger"); $('#loginemail').focus(); }else{ $('#loginemail').removeClass("uk-form-danger"); }
  if (l<5 && fallo==0) { alert("Debe escribir un email valido"); fallo=1; $('#loginemail').focus(); }
  if (a<2 && fallo==0) { alert("Debe escribir un email valido"); fallo=1; $('#loginemail').focus(); }
  if (fallo==0) {
    $.ajax({
      method: "POST",
      url: "../includes/acciones.php",
      data: { 
        login: 1,
        email: email
      }
    })
    .done(function( msg ) {
      if(msg!='fallo'){
        window.location = (msg);
      }else{
        UIkit.notification.closeAll();
        UIkit.notification("<span class='uk-notification-message uk-notification-message-danger'><span uk-icon='icon: close;ratio:2;'></span> &nbsp; No se encuentra el email</span>");
      }
    });
  }
});
</script>
</body>
</html>