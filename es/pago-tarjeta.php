<?php  
  if (isset($_SESSION['paypal_plus'])) {
    $data = json_decode($_SESSION['paypal_plus']);
    $userID = $data->userID;
    $approvalUrl = $data->approvalUrl;
    $paymentId = $data->paymentId;
    $payerEmail = $data->payerEmail;
    $payerFirstName = $data->payerFirstName;
    $payerLastName = $data->payerLastName;
    $paymentCourses = $data->paymentCourses;
    $paymentTranslations = $data->paymentTranslations;
    $currency = $data->currency;
    $languajeISOCode = null;
    switch ($languaje) {
      case 'es':
        $languajeISOCode = 'es_MX';
        break;
      case 'en':
        $languajeISOCode = 'en_US';
        break;
      case 'ja':
        $languajeISOCode = 'ja_JP';
        break;
      case 'ru':
        $languajeISOCode = 'ru_RU';
        break;
      case 'pt':
        $languajeISOCode = 'pt_PT';
        break;
      case 'it':
        $languajeISOCode = 'it_IT';
        break;
      default:
        $languajeISOCode = 'en_US';
    }
  } else {
    header('location: /' . $BASE_URL . '/' . $languaje);
  }
?>

<!DOCTYPE html>
<html lang="<?=$languaje?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <title><?=html_entity_decode($titleInscripcion)?></title>
  <meta name="description" content="<?=html_entity_decode($descriptionInscripcion)?>">

  <?=$headGNRL?>

</head>

<body>
<?=$header?>

<div class="uk-container">
  <div class="uk-card uk-card-default uk-margin-bottom uk-text-center">
    <div class="uk-card-header">
      <div class="uk-card-body">
        <div id="ppplus"></div>
        <button type="submit" id="continueButton"  onclick="confirm();" class="uk-button uk-button-personal uk-button-large"><?php echo $pagar; ?></button>
      </div>
    </div>
  </div>
</div>

<?=$footer?>

<?=$scriptGNRL?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://www.paypalobjects.com/webstatic/ppplusdcc/ppplusdcc.min.js" type="text/javascript"></script>
<script>
    var ppp = PAYPAL.apps.PPP({
      "approvalUrl": "<?php echo $approvalUrl; ?>",
      "placeholder": "ppplus",
      "payerEmail": "<?php echo $payerEmail; ?>",
      "payerFirstName": "<?php echo $payerFirstName; ?>",
      "payerLastName": "<?php echo $payerLastName; ?>",
      "payerTaxId": "",
      "mode": "<?php echo PP_SANDBOX_MODE ? 'sandbox' : 'live'; ?>",
      "language": "<?php echo $languajeISOCode; ?>",
    });
    window.clickPaypalPlusButton = false;
    // Register postMessage Listener for the iframe.
    if (window.addEventListener) {
      window.addEventListener("message", messageListener, false);
    } else if (window.attachEvent) {
      window.attachEvent("onmessage", messageListener);
    }

    function enable(val) {
      $('#continueButton').attr('disabled', !val);
    }

    function confirm() {
      enable(false);
      ppp.doContinue();
    }

    function messageListener(event) {
      if (event.data) {
        var data = JSON.parse(event.data);
        var result = data.result;
        var action = data.action;
        if (result && result.state) {
          if (result.state == 'APPROVED') {
            success(result);
          } else {
            location.href = '<?php echo $BASE_URL . '/' . $languaje . '/14_fallo-.html'; ?>';
          }
        }
        enable(action != "disableContinueButton");
      }
    }

    function success(res) {
      return $.post('../includes/acciones.php?execute_payment&is_ajax', {
        paymentID: '<?php echo $paymentId; ?>',
        payerID:  res.payer.payer_info.payer_id,
        userID: '<?php echo $userID; ?>',
        languaje: '<?php echo $languaje; ?>',
        paymentCourses: <?php echo json_encode($paymentCourses); ?>,
        paymentTranslations: <?php echo json_encode($paymentTranslations); ?>,
        currency: '<?php echo $currency; ?>',
      }).then(function(res) {
        if (res != 1)
          alert('Ocurrió un error inesperado, favor de intentar nuevamente.');
        else location = "<?php echo $BASE_URL . '/' . $languaje . '/exito'; ?>";
      }).catch(function (err) {
        console.log(err);
        alert('Ocurrió un error inesperado, favor de intentar nuevamente.');
      });
    }
</script>

</body>
</html>