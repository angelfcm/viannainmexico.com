<?php  
  $registeredUser = null;
  $cursoasientos = [];
  $courses = $CONEXION->query("SELECT * FROM cursos ORDER BY orden")->fetch_all(MYSQLI_ASSOC);

  // Lamentablemente no es posible usar json_decode debido a al codificación de los idiomas en los titulos de los cursos, hay que hacerlo a mano.
  $json_courses = "[";
  foreach($courses as $course) {
    $json_courses .= $json_courses == "[" ? "{" : ",{";
    $j = 0;
    foreach($course as $key=>$value) {
      $json_courses .= $j == 0 ? '' : ',';
      $json_courses .= '"' . addslashes($key) . '":"' .  addslashes($value) . '"'; 
      $j++;
    }
    $json_courses .= "}";
  }
  $json_courses .= "]";

  $json_courses = preg_replace("/[\n\r\t]/", "", $json_courses); // los saltos de línea deben ser removidos para evitar error de sintáxis en javascript.

  if (isset($_SESSION['registration.email'])) {
    $checkEmail = $_SESSION['registration.email'];
    unset($_SESSION['registration.email']);
  
    $checkEmail = strtolower(trim(htmlentities($checkEmail, ENT_QUOTES)));
    $registeredUser = $CONEXION->query("SELECT * FROM usuarios WHERE email = '$checkEmail'")->fetch_assoc();
    $exists = $registeredUser != null;
    $cursoasientos = $CONEXION->query("SELECT * FROM cursoasientos WHERE usuario = " . $registeredUser['id'])->fetch_all(MYSQLI_ASSOC);
    $isTherePaidCourse = false;
    $isThereUnselectedSeatOnPaidCourses = false;

    foreach($cursoasientos as $ca) {
      if ($ca['estatus'] == 1) {
        $isTherePaidCourse = true;
        if (empty($ca['asiento']) && $ca['tipo'] != COURSE_TYPE_ONLINE)
          $isThereUnselectedSeatOnPaidCourses = true;
      }
    }

    if (!$exists)
      header('location: http://viannainmexico.com/' . $languaje);
  }

  $readonlyAttr = $registeredUser != null ? 'readonly' : '';
  $disabledAttr = $registeredUser != null ? 'disabled' : '';
?>

<!DOCTYPE html>
<html lang="<?=$languaje?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <title><?=html_entity_decode($titleInscripcion)?></title>
  <meta name="description" content="<?=html_entity_decode($descriptionInscripcion)?>">
  
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=html_entity_decode($titleInscripcion)?>">
  <meta property="og:description" content="<?=html_entity_decode($descriptionInscripcion)?>">
  <meta property="og:url" content="<?=$rutaEstaPagina?>">
  <meta property="og:image" content="<?=$rutaOG?>">
  <meta property="fb:app_id" content="<?=$appID?>">

  <?=$headGNRL?>

</head>

<body>
<?=$header?>


<?php if($registeredUser == null): ?>
  <div class="uk-container" id="email-section">
    <form onsubmit="checkEmail(); return false;">
      <h3 class="color-morado uk-text-uppercase uk-text-bold uk-text-center"><?php echo $registrationTitle; ?></h3>
      <div class="uk-child-width-expand@s uk-width-3-4@s" uk-grid style="margin: 0 auto">
        <div class="uk-width-3-4@s uk-margin">
          <label for="email-input"><?php echo $email; ?>:</label>
          <input type="email" id="email-input"class="uk-input">
        </div>
        <div class="uk-margin">
          <button type="submit" class="uk-button uk-button-personal uk-button-large"><?php echo $continueBtn; ?></button>
        </div>
      </div>
    </form>
  </div>
<?php else: ?>
<div class="uk-container" id="email-section">
  <h2><?php echo $registrationSuccessWithID; ?> <strong><?php echo $registeredUser['id']; ?></strong>.</h2>
  <?php if($isTherePaidCourse): ?>
    <?php if($isThereUnselectedSeatOnPaidCourses): ?>
      <h3><span style="color: green;"><?php echo $youHaveAPaymentTxt; ?></span><a href="<?php echo $ruta.'exito'; ?>"><strong><?php echo $asignarasiento; ?></strong></a><h3>
    <?php endif; ?>
      <h3 class="color-morado uk-text-uppercase uk-text-bold uk-text-center"><?php echo $canDoMorePaymentsTxt; ?></h3>
  <?php else: ?>
    <h3><?php echo $pleasMadeYourPaymentTxt; ?></h3>
  <?php endif; ?>
</div>
<hr class="uk-divider-icon uk-width-1-1">
<?php endif; ?>

  <!-- Formato de inscripción -->
  <form method="POST" id="form" action="../includes/acciones.php" <?php echo $registeredUser == null ? 'style="display: none"' : ''; ?>>
    <input type="hidden" name="registro" value="1">
    <input type="hidden" name="languaje" value="<?=$languaje?>">
    <div class="uk-container">
      <div uk-grid class="uk-child-width-1-2@m">

        <div>
          <label><?php echo $Nombre; ?></label>
          <input type="text" id="nombre" name="nombre" class="uk-input" <?php echo $registeredUser != null ? 'value="' . $registeredUser['nombre'] . '" readonly' : ''; ?>>
          <br><br>
          <label><?php echo $apellido; ?></label>
          <input type="text" id="apellido" name="apellido" class="uk-input" <?php echo $registeredUser != null ? 'value="' . $registeredUser['apellido'] . '" readonly' : ''; ?>>
          <br><br>
          <label><?php echo $email; ?></label>
          <input type="email" id="email" name="email" class="uk-input" <?php echo $registeredUser != null ? 'value="' . $registeredUser['email'] . '" readonly' : ''; ?>>
          <br><br>
          <label><?php echo $formGafet; ?></label>
          <input type="text" id="gafet" name="gafet" class="uk-input"<?php echo $registeredUser != null ? 'value="' . $registeredUser['gafet'] . '" readonly' : ''; ?>>
          <br><br>
          <label><?php echo $nacimiento; ?></label>
          <input autocomplete="off" type="text" id="nacimiento" name="nacimiento" class="uk-input" <?php echo $registeredUser != null ? 'value="' . $registeredUser['nacimiento'] . '" readonly' : ''; ?>>
          <br><br>
          <label><?php echo $telefono; ?></label>
          <input type="text" id="telefono" name="telefono" class="uk-input" <?php echo $registeredUser != null ? 'value="' . $registeredUser['telefono'] . '" readonly' : ''; ?>>
          <br><br>
          <label><?php echo $formEmergencia; ?></label>
          <input type="text" id="emergencia" name="emergencia" class="uk-input" <?php echo $registeredUser != null ? 'value="' . $registeredUser['emergencia'] . '" readonly' : ''; ?>>
          <br><br>
          <label><?php echo $direccion; ?></label>
          <textarea id="direccion" name="direccion" class="uk-textarea" <?php echo $readonlyAttr; ?>><?php echo $registeredUser != null ? $registeredUser['direccion'] : ''; ?></textarea>
          <br><br>
          <label><?php echo $pais; ?></label>
          <input type="text" id="pais" name="pais" class="uk-input" <?php echo $registeredUser != null ? 'value="' . $registeredUser['pais'] . '" readonly' : ''; ?>>
          <br><br>
        </div>
        <div ><!-- <?php echo $registeredUser != null ? 'style="display: none"' : ''; ?> -->
          <div>
              <?php echo $formCurso; ?>
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
        
        $checked = "";
        $disableCourse = "";
        $paidCourseLabel_ = "";
        $courseRegisteredLabel_ = "";
        $courseType = "";
        if ($registeredUser != null)
          foreach($cursoasientos as $selectedCourse)
            if ($selectedCourse['curso'] == $itemId)
            {
              $checked = "checked";
              $disableCourse = "disabled";
              $courseType = $selectedCourse['tipo'];
              
              if ($selectedCourse['estatus'] == 1)
                $paidCourseLabel_ = ' (<span style="color: green;">'.$paidLegendTxt.'</span>)';
              else
                $courseRegisteredLabel_ = ' (<span style="color: darkblue;">'.$registeredCourseLabel.'</span>)';

              break;
            }
        
        echo '  
        <div class="uk-margin course-container">
          <div uk-grid class="uk-grid-small">
            <div>
              <input '.$disableCourse.' type="checkbox" name="curso'.$itemId.'" id="curso'.$itemId.'" value="'.$itemId.'" class="uk-checkbox course-checkbox" '.$checked.'>
            </div>
            <div class="uk-width-expand">
              <label for="curso'.$itemId.'">
                '.$row_CONSULTA1['titulo'.$languaje].$paidCourseLabel_.$courseRegisteredLabel_.'
              </label>
              <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid course-type-radio" id="courseTypeControlContainer' . $itemId . '">
                <label><input class="uk-radio" ' .$disableCourse. ' type="radio" value="' . COURSE_TYPE_FACE_TO_FACE . '" name="courseType'.$itemId.'" ' . ($courseType == COURSE_TYPE_FACE_TO_FACE ? 'checked' : '') . '> ' . $courseFaceToFace . '</label>
                <label><input class="uk-radio" ' .$disableCourse. ' type="radio" value="' . COURSE_TYPE_ONLINE . '" name="courseType'.$itemId.'" ' . ($courseType == COURSE_TYPE_ONLINE ? 'checked' : '') . '> ' . $courseOnline . '</label>
              </div>
            </div>
          </div>
        </div>';
      }
      mysqli_free_result($CONSULTA1);

      $courseLang = "";
      $manualLang = "";
      
      $courseLangs = [
        'Español' => $espanol, 
        'Inglés' => $ingles, 
        'Japonés' => $japones, 
        'Ruso' => $ruso, 
        'Portugués' => $portugues, 
        'Húngaro' => $hungaro, 
        'Chino' => $chino, 
        'Turco' => $turco
      ];

      if ($registeredUser != null && count($cursoasientos) > 0) {
        $courseLang = html_entity_decode($cursoasientos[0]['traductor']);
        $manualLang = html_entity_decode($cursoasientos[0]['material']);

        if (!in_array($courseLang, array_keys($courseLangs)))
          $courseLang = "";

        if (!in_array($manualLang, array_keys($courseLangs)))
          $manualLang = "";
      }
?>
          <label><?php echo $formInvita; ?></label>
          <input <?php echo $readonlyAttr; ?> type="text" id="invita" name="invita" class="uk-input"  value = "<?php echo ($registeredUser != null ? $registeredUser['invita'] : ''); ?>">
          <br><br>
          <label>
            <?php echo $formTraductor; ?><br>
            <span class="text-sm">(<?php echo $traduccionsincosto; ?>)</span>
          </label>
          <div uk-grid>
            <div class="uk-width-1-1">
              <label><input <?php echo $courseLang ? $disabledAttr : ''; ?> class="uk-radio" type="radio" value="0" name="traduc" id="traduc0" name="traduc0" <?php echo (empty($courseLang) ? 'checked' : ''); ?>><?php echo $no; ?></label>
            </div>
            <div>
              <label><input <?php echo  $courseLang ? $disabledAttr : ''; ?> class="uk-radio" type="radio" value="1" name="traduc" id="traduc1" name="traduc1" <?php echo (!empty($courseLang) ? 'checked' : ''); ?>><?php echo $si; ?></label>
            </div>
            <div class="uk-width-expand">
              <select <?php echo  $courseLang ? $disabledAttr : ''; ?> name="traductor" id="traductor" class="uk-select">
              <option value=""></option>
              <?php foreach($courseLangs as $lang => $translation): ?>
                <option value="<?php echo $lang; ?>" <?php echo ($courseLang == $lang ? 'selected' : '');?>><?php echo $translation; ?></option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="uk-margin">
            <label><?php echo $materialLangLabelTxt; ?><br></label>
            <select <?php echo ($manualLang ? $disabledAttr : ''); ?> name="materialLang" id="materialLang" class="uk-select">
              <option value=""></option>
              <?php foreach($courseLangs as $lang => $translation): ?>
                <option value="<?php echo $lang; ?>" <?php echo ($manualLang == $lang ? 'selected' : '');?>><?php echo $translation; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="uk-margin">
            <label id="mayorlabel"><input <?php echo $disabledAttr; ?> class="uk-checkbox" type="checkbox" value="1" id="mayor" name="mayor"  <?php echo ($registeredUser != null ? 'checked' : ''); ?>><?php echo $formMayor; ?></label>
          </div>
          <div class="uk-margin">
            <input <?php echo $disabledAttr; ?> class="uk-checkbox" type="checkbox" value="1" id="politicas" name="politicas" <?php echo ($registeredUser != null ? 'checked' : ''); ?>><?php echo $formPoliticas; ?> <a href="#modal" uk-toggle class="uk-text-underline uk-text-bold"><?php echo $politicastitle;?></a>
          </div>
        </div>

        <hr class="uk-divider-icon uk-width-1-1 uk-grid-margin uk-first-column" />
        <!-- PRIMER PAGO -->
        <div class="uk-width-1-1">
        <div class="uk-width-3-4@s" style="margin: 0 auto" id="1st-payment-section">
          <fieldset class="uk-fieldset">
            <legend class="uk-legend color-morado uk-text-bold uk-text-uppercase  uk-text-center"><?php echo $firstPaymentLabel; ?></legend>
            <div class="uk-margin uk-width-1-1 color-morado uk-text-center"><?php echo $firstPaymentMethodTxt; ?></div>
            <div class="uk-margin" uk-grid style="margin-left: auto; margin-right: auto;">
              <div class="uk-form-controls uk-form-controls-text">
                <div class="uk-width-1-1 uk-margin" style="font-size: 18px !important;"><?php echo $typeOfPaymentLabel; ?></div>
                <label><input class="uk-radio" type="radio" name="payment_option" value="DESPUES"> <?php echo $payAfterLabel; ?></label><br>
                <label><input class="uk-radio" type="radio" name="payment_option" value="PAYPAL"> <?php echo $payWithPaypalLabel; ?></label><br>
                <div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin" id="payment-paypal-content" style="display: none">
                </div>
                <label><input class="uk-radio" type="radio" name="payment_option" value="DEPOSITO"> <?php echo $payWithDepositLabel; ?></label><br>
                <div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin" id="payment-bank-content" style="display: none">
                    MundoTH
                    <p>
                      <b class="uk-text-capitalize"><?=$correo?>:</b> contacto@mundoth.com<br>
                      <b class="uk-text-capitalize"><?=$oficina?>:</b> <?=$telefonoSeparado1?>
                      <b class=""><?=$whatsapp?> :</b> <?=$telefonoSeparado?><br>
                    </p>
                </div>
                <label><input class="uk-radio" type="radio" name="payment_option" value="EFECTIVO"> <?php echo $payWithCashLabel; ?></label><br>
                <div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin" id="payment-cash-content" style="display: none; max-width:600px;">
                <?php echo $payWithCashTxt; ?>
                </div>
              </div>
            </div>
          </fieldset>
        </div>
        </div>

        <!-- PAGO TRADUCCIONES -->
        <div class="uk-width-1-1" <?php echo $languaje == 'es' || $languaje == 'en' ? 'style="display:none"' : ''; ?>>
        <div class="uk-width-3-4@s" style="margin: 0 auto" id="trans-payment-section">
          <fieldset class="uk-fieldset">
            <legend class="uk-legend color-morado uk-text-bold uk-text-uppercase  uk-text-center">TRANSLATION PAYMENT</legend>
            <div class="uk-margin uk-width-1-1 color-morado uk-text-center">Choose one of the following options to PAY FOR TRANSLATION:</div>
            <div class="uk-margin uk-width-5-6@s" uk-grid style="margin-left: auto; margin-right: auto;">
              <div class="uk-form-label uk-width-1-5" style="font-size: 18px !important;">Type of payment:</div>
              <div class="uk-form-controls uk-form-controls-text">
                <label><input class="uk-radio" type="radio" name="trans_payment_option" value="DESPUES"> Pay after</label><br>
                <label><input class="uk-radio" type="radio" name="trans_payment_option" value="PAYPAL"> Pay with credit or debit card</label><br>
                <div class="uk-card uk-card-default uk-card-body" id="payment-paypal-content" style="display: none">
                </div>
                <label><input class="uk-radio" type="radio" name="trans_payment_option" value="DEPOSITO"> Bank transfer or deposit</label><br>
                <div class="uk-card uk-card-default uk-card-body" id="payment-bank-content" style="display: none">
                    MundoTH
                    <p>
                      <b class="uk-text-capitalize"><?=$correo?>:</b> contacto@mundoth.com<br>
                      <b class="uk-text-capitalize"><?=$oficina?>:</b> <?=$telefonoSeparado1?>
                      <b class=""><?=$whatsapp?> :</b> <?=$telefonoSeparado?><br>
                    </p>
                </div>
              </div>
            </div>
          </fieldset>
        </div>
        </div>

        <div class="uk-margin uk-width-1-1" id="captcha-container">
          <div class="g-recaptcha" data-sitekey="6LfemlQUAAAAAHUZ0-iNKN35hHJCCcukHimwMhVy"></div>
        </div>
        <style>
          .g-recaptcha > div {
            margin: 0 auto; /* centers de captcha */
          }
        </style>
        <div class="uk-width-1-1 uk-text-center uk-margin">
          <button class="uk-button uk-button-personal uk-button-large" id="send"><?php echo $enviar; ?></button>
<?php if($languaje == 'es'): ?>
          <div uk-grid class="uk-child-width-1-2@m" id="paypal-buttons-container">
            <div>
              <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                  <h3 class="uk-card-title" style="text-transform:uppercase;"><?php echo $pagoenpesos; ?></h3><p><?php echo $paypalPaymentIndication; ?></p>
<?php if ($languaje == 'es'): ?>
<span style="font-size: 70%;">(SI GRAN PARTE DEL TIEMPO VIVES Y/O HACES NEGOCIOS FUERA DE LATINOAMERICA NO APLICA PARA TI Y REQUIERES PAGAR EN DOLARES)</span>
<?php endif; ?>
                </div>
                <div class="uk-card-body">
                  <div id="paypal-button-1" class="pp-button-container"><div class="pp-button-overlay"></div></div>
                </div>
              </div>
            </div>
            <div>
              <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                  <h3 class="uk-card-title" style="text-transform:uppercase;"><?php echo $pagoendolares; ?></h3><p><?php echo $paypalPaymentIndication; ?></p>
                </div>
                <div class="uk-card-body">
                  <div id="paypal-button-2" class="pp-button-container"><div class="pp-button-overlay"></div></div>
                </div>
              </div>
            </div>
          </div>
<?php else: ?>
          <!--<div id="paypal-buttons-container">
            <div id="paypal-button-2"></div>
          </div>-->
          <div id="paypal-buttons-container" class="uk-margin">
            <div class="uk-card uk-card-default">
              <div class="uk-card-header">
                <h3 class="uk-card-title" style="text-transform:uppercase;"><?php echo $pagoendolares; ?></h3><p><?php echo $paypalPaymentIndication; ?></p>
              </div>
              <div class="uk-card-body">
                <div id="paypal-button-2" class="pp-button-container"><div class="pp-button-overlay"></div></div>
              </div>
            </div>
          </div>
<?php endif; ?>
        </div>
        <div id="mensajes" class="uk-width-1-1">
        </div>
        
      </div>
    </div>
  </form>

  <!-- SEGUNDO PAGO -->
  <hr class="uk-divider-icon uk-width-1-1">
  <div class="uk-width-1-1">
  <div class="uk-width-3-4@s" style="margin: 0 auto" id="2nd-payment-section">
    <fieldset class="uk-fieldset">
      <legend class="uk-legend color-morado uk-text-uppercase  uk-text-center uk-text-bold"><?php echo $secondPaymentLabel; ?></legend>
      <div class="uk-margin uk-width-1-1 color-morado  uk-text-center"><?php echo $secondPaymentTxt; ?></div>
      <div class="uk-width-1-1 margen-v-20 uk-text-center">
        <a href="https://www.thetahealing.com/mexico-final-payment.html" target="_blank" class="uk-button uk-button-paypal uk-button-large"><img src="../img/design/logo-paypal.png" alt="logo paypal"> &nbsp;&nbsp;&nbsp; <?=$segundopago?></a>
      </div>
      <?php if($languaje=='es'): ?>
        <div class="uk-width-1-1 margen-v-20 uk-text-center">
          <a href="https://www.thetahealing.com/mexico-payment-pesos.html" target="_blank" class="uk-button uk-button-paypal uk-button-large"><img src="../img/design/logo-paypal.png" alt="logo paypal"> &nbsp;&nbsp;&nbsp; REALIZAR SEGUNDO PAGO EN PESOS (Solamente si vives en América latina)</a>
        </div>
      <?php endif; ?>
    </fieldset>
    <style type="text/css">
      /* personal & white */
      .uk-button-paypal {
        background-color: #fec43a;
        color: #000!important;
        font-size: 1em!important;
        border: 1px solid #fec43a!important;
      }
      .uk-button-paypal:hover,
      .uk-button-paypal:focus {
        background-color: #fc3!important;
        border: 1px solid #fc3!important;;
        color: #000!important;
      }
      .uk-button-paypal:active,
      .uk-button-paypal.uk-active {
        background-color: #da1!important;
        color: #000!important;
      }
    </style>
  </div>
  </div>

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
      changeYear: true,
      yearRange: "1920:"
    });
    $("#nacimiento").datepicker( "option", "dateFormat", "dd-mm-yy" );
    $("#nacimiento").datepicker( "setDate", "1-1-1980" );
  } );
</script>

<script>
  $('#traduc0').click(function(){
    $('#traductor').val( "" );
    $('#traductor').prop( "readonly", true );
  })
  $('#traduc1').click(function(){
    $('#traductor').prop( "readonly", false );
    $('#traductor').focus();
  })
</script>

<script>
  //Envío de registro
  $('#send').click(function(event){
    event.preventDefault();
    if (validar()) {
      $(this).prop("readonly",true);
      $(this).html("<div uk-spinner></div>");
      $('#form').submit();
    };
  })

  function validar() {
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
    var materialLang = $('#materialLang').val();
    var curso=$('#curso').val();
    var courseType = $('#courseType').val();
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
    $('.course-checkbox').each(function (i, el) {
      if (el.checked) {
        var courseTypeCtId = '#courseTypeControlContainer' + el.value;
        var courseType = $('#courseTypeControlContainer' + el.value).find('input:checked').val();
        if (!courseType && fallo==0) {
          alert("<?=html_entity_decode($formVerifyTxt)?> <?=html_entity_decode($courseTypeLabel)?>");
          fallo=1;
          $(courseTypeCtId).addClass("uk-form-danger");
          $(courseTypeCtId).find('input').focus();
        } else{
          $(courseTypeCtId).removeClass("uk-form-danger");
        }
      }
    });
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
    // Checks if at least a product will be paid when paypal option is checked.
    if (fallo==0) {
      var firstOption = $('[name="payment_option"]:checked').val();
      var secondOption = $('[name="trans_payment_option"]:checked').val();
      if (firstOption == 'PAYPAL' || secondOption == 'PAYPAL') 
      {
        if (selectedPaymentCourses.length == 0 && selectedPaymentTrans.length == 0)
        {
          alert("Select at least a course or translation to be paid."); 
          fallo=1; 
        }
      }
    }

    return fallo == 0;
  }
</script>

<style>
.uk-form-danger,
.uk-form-danger:focus {
  color: #f0506e;
  border-color: #f0506e !important; /* ensures it will apply to controls */
}
</style>

<script>
  var courses = <?php echo $json_courses; ?>;
  var cursoasientos = <?php echo json_encode($cursoasientos); ?>;
</script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  var $emailSection = $('#email-section');
  var $formSection = $('#form');
  var $emailInput = $('#email-input');
  var selectedPaymentCourses = [];
  var selectedPaymentTrans = [];
  var $captchaCt = $('#captcha-container');

  // Checks if an email exists 
  function checkEmail() {
    var lastEmailRead = "";
    var email = $emailInput.val();
    if (lastEmailRead == email) 
      return;

    if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      .test(email) == 0) {
      alert('Introduce un email válido');
      return;  
    }

    $.get('../includes/acciones.php', {checkEmail: escape(email)}).done(function(exists){
      if (exists == 1) {
        var loc = location.href.replace(location.search, ''); // clear the query string
        location.href = loc // reloads considering that this call set the session chekcEmail key
      }
      else {
        $emailSection.fadeOut('slow');
        $formSection.slideDown('fast').find('[name="email"]').val(email).prop('readonly', true);
      }
    });

    lastEmailRead = email;
  }
  var $submitButton = $('#send');
  var $paypalButtonsContainer = $('#paypal-buttons-container');
  var $insCourseCheckboxes = $('.course-checkbox');
  var $insCourseTypeRadios = $('.course-type-radio');
 
  $(function() {
    initializeProductSection('#1st-payment-section');
    initializeProductSection('#trans-payment-section');
    updateSelectedPaymentMethod('#1st-payment-section');
    updateSelectedPaymentMethod('#trans-payment-section');
    updateSelectedCourses('#1st-payment-section');
    updateSelectedCourses('#trans-payment-section');
    <?php if ($languaje == 'es'): ?>
    updatePaypalButton('#paypal-button-1', 'MXN');
    <?php endif; ?>
    updatePaypalButton('#paypal-button-2', 'USD');

    $('.pp-button-overlay').on('mousedown', function() {
      if (validar())
        $('.pp-button-overlay').hide();
      else
        $('.pp-button-overlay').show();
    });
  });

  function initializeProductSection(ctx) {
    var $paymentOption = $(':radio', ctx);
    $paymentOption.on('change', function(){updateSelectedPaymentMethod.call(this, ctx)});
    $insCourseCheckboxes.on('change', function(){updateSelectedCourses.call(this, ctx)});
    $insCourseTypeRadios.on('change ', function(){
      var el = $(this).parents('.course-container').eq(0).find('[name^="curso"]')[0];
      updateSelectedCourses.call(el, ctx);
    });

    var secondOption = $('[name="trans_payment_option"]').val();
  }

  function updateSelectedPaymentMethod(ctx) {
    var $paymentPaypalContent = $('#payment-paypal-content', ctx);
    var $paymentBankContent = $('#payment-bank-content', ctx);
    var $paymentCashContent = $('#payment-cash-content', ctx);

    $paymentPaypalContent.hide();
    $paymentBankContent.hide();
    $paypalButtonsContainer.hide();
    $paymentCashContent.hide();
    $submitButton.show();
    $captchaCt.show();

    var opt = this.value;
    if (opt == 'PAYPAL')
      $paymentPaypalContent.slideDown('fast');
    else if (opt == 'DEPOSITO')
      $paymentBankContent.slideDown('fast');
    else if (opt == 'EFECTIVO')
      $paymentCashContent.slideDown('fast');

    var firstOption = $('[name="payment_option"]:checked').val();
    var secondOption = $('[name="trans_payment_option"]:checked').val();

    if (firstOption == 'PAYPAL' || secondOption == 'PAYPAL') 
    {
      $submitButton.hide();
      $paypalButtonsContainer.show();
      $captchaCt.hide(); // doesnt need a captcha if user will pay.
    }
  }

  function updateSelectedCourses(ctx) {
    var isTranslation = ctx == '#trans-payment-section';
    var $paymentPaypalContent = $('#payment-paypal-content', ctx);

    var $coursesToAdd = $.map($insCourseCheckboxes.get(), function(el) {
      $('#courseTypeControlContainer' + el.value)[el.checked ? 'show' : 'hide']();
      var courseType = $('#courseTypeControlContainer' + el.value).find('input:checked').val();
      var courseTypeTrans = {
        '<?php echo COURSE_TYPE_FACE_TO_FACE; ?>': '<?php echo $courseFaceToFace ?>',
        '<?php echo COURSE_TYPE_ONLINE; ?>': '<?php echo $courseOnline ?>',
      };

      if (!el.checked)
        return;
      var course = null;
      for (var i = 0; i < courses.length; i++)
        if (courses[i].id == el.value) {
          course = courses[i];
          break;
        }
      if (course == null)
        return;
 
      var isPaid = false;
      for(var i = 0; i < cursoasientos.length; i++) {
        if (cursoasientos[i].curso == course.id) {
          if (!isTranslation && cursoasientos[i].estatus == 1 || isTranslation && cursoasientos[i].translation_status == 1)
            isPaid = true;
          break;
        } 
      }

      var courseHtml = '<label ' + (isPaid ? 'style="text-decoration: line-through; line-height: 2;"' : 'style="line-height: 2;"') + '>'
        + '<input class="uk-checkbox product_checkbox" type="checkbox" name="courses[' + course.id + ']" value="'+ course.id +'" ' + (isPaid ? ' style="visibility: hidden"' : '') + '> ' 
        + course['titulo<?php echo $languaje; ?>']
        + ' <span style="font-size: 80%"><strong>[$'
<?php if ($languaje == 'es'): ?>
        + (isTranslation ? parseFloat(course.precio_traduccion_usd) + ' USD' : parseFloat(course.precio) + ' MXN') 
<?php else: ?>
        + (isTranslation ? parseFloat(course.precio_traduccion_usd) + ' USD' : parseFloat(course.preciousd) + 'USD')
<?php endif; ?>
        + (courseTypeTrans[courseType] ? ' - ' + courseTypeTrans[courseType] : '')
        + ']</strong></span></label>'
        + (isPaid ? ' <span style="color: green;"><?php echo $paidLegendTxt; ?></span>' : '')
        + '<br />';

      return courseHtml;
    });

    $paymentPaypalContent.html($coursesToAdd.join('') || '<?php echo $selectAtLeastOneCourseTxt; ?>');

    $('.product_checkbox', ctx).on('change', function() {
      if (ctx == '#1st-payment-section')
        selectedPaymentCourses = [];
      else if (ctx == '#trans-payment-section')
        selectedPaymentTrans = [];

      $('.product_checkbox', ctx).each(function() {
        for (var i = 0; i < courses.length; i++) {
          if (this.checked && courses[i].id == this.value) {
            if (ctx == '#1st-payment-section')
              selectedPaymentCourses.push(courses[i]);
            else if (ctx == '#trans-payment-section')
              selectedPaymentTrans.push(courses[i]);
            break;
          }
        }
      });
    });
  }

  function updatePaypalButton(buttonId, currency) {
    var locale = currency == 'MXN' ? 'es_MX' : 'en_US';
    var currency = currency == 'MXN' ? 'MXN' : 'USD';
    var userID = null;

    paypal.Button.render({
      // Configure environment
      env: 'production',
      // Customize button (optional)
      locale: locale,
      style: {
        size: 'medium',
        height: 54.8,
        color: 'blue',
        shape: 'pill',
        label: 'pay' // 'credit'
      },
      // Set up a payment
      payment: function(data, actions) {
        var paymentCourses = $.map(selectedPaymentCourses, function(c){ return c.id; });
        var paymentTranslations = $.map(selectedPaymentTrans, function(c){ return c.id; });
        var form = $('#form')[0];
        var disabledInputs = $('#form :disabled'); 
        disabledInputs.prop('disabled', false);  // Evita que se ignoren los valores de los controles deshabilitados.
        var formData = new FormData(form);
        var data = {
          paymentCourses,
          paymentTranslations,
          currency: buttonId == '#paypal-button-1' ? 'MXN' : 'USD'
        };
        formData.forEach(function(value, key){ data[key] = value; });
        disabledInputs.prop('disabled', true); 
        // 2. Make a request to your server
        return actions.request.post('../includes/acciones.php?create_payment&is_ajax', data)
        .then(function(res) {
          console.log(res);
          if (res.userID)
          {
            userID = res.userID;
            if (res.paymentId)
              return res.paymentId;
            else {
              alert("<?php echo $paymentErrorTxt; ?>");
              return null;
            }
          } else {
            throw "Error al realizar la inscripción de usuario.";
          }

        }).catch(function(err) {
          console.log(err);
          alert('Ocurrió un error inesperado, favor de intentar nuevamente.');
          logPaypalError(err, 'payment()->actions.request.post()');
        });
      },
      // Execute the payment
      // 1. Add an onAuthorize callback
      onAuthorize: function (data, actions) {
        var paymentCourses = $.map(selectedPaymentCourses, function(c){ return c.id; });
        var paymentTranslations = $.map(selectedPaymentTrans, function(c){ return c.id; });
        // 2. Make a request to your server
        return actions.request.post('../includes/acciones.php?execute_payment&is_ajax', {
          paymentID: data.paymentID,
          payerID:  data.payerID,
          userID: userID,
          languaje: '<?php echo $languaje; ?>',
          paymentCourses,
          paymentTranslations,
          currency: buttonId == '#paypal-button-1' ? 'MXN' : 'USD'
        }).then(function(res) {
          if (res !== 1)
            alert('Ocurrió un error inesperado, favor de intentar nuevamente.');
          else location = "<?php echo $BASE_URL . '/' . $languaje . '/exito'; ?>";
        }).catch(function (err) {
          console.log(err);
          alert('Ocurrió un error inesperado, favor de intentar nuevamente.');
          logPaypalError(err, 'onAuthorize()->actions.request.post()');
        });
      }
    }, buttonId);
  }

  function logPaypalError(error, detalles) {
    var formDataObject = {};
    var disabledInputs = $('#form :disabled'); 
    disabledInputs.prop('disabled', false);
    var formData = new FormData(form);
    formData.forEach(function(value, key){ formDataObject[key] = value; });
    disabledInputs.prop('disabled', true); 

    var data = {
      error: JSON.stringify(error),
      detalles: detalles,
      formData: JSON.stringify(formDataObject)
    };

    $.post('/includes/pp/ErrorLogger.php', data, function(r) {
      console.log('Error registrado con respuesta:'); 
      console.log(r);
    });
  }
</script>
<style type="text/css">
.pp-button-container {
  position: relative;
}
.pp-button-overlay {
  position: absolute;
  z-index: 1000;
  width: 100%;
  height: 100%;
}
[readonly] {
  opacity: 0.8;
}
</style>

</body>
</html>