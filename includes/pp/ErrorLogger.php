<?php

$formData = json_encode($_POST['formData']);
$detalles = json_encode($_POST['detalles']);
$error = json_encode($_POST['error']);
$date = date('d/m/Y h:i:s a');

$content = "
\n==================
\nFecha:\t$date
\nDetalles:\t$detalles
\nError: 
\n$error
\nDatos: 
\n$formData
";

file_put_contents('errores_paypal.txt', $content, FILE_APPEND);

echo "OK";