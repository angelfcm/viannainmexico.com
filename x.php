<?php

include 'includes/connection.php';
include 'includes/config.php';
    
require 'library/phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
// $mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';
$mail->Host = MAIL_HOST;
$mail->SMTPSecure = 'SSL';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = SENDER_ADMIN_MAIL;
$mail->Password = SENDER_ADMIN_MAIL_PASS;
$mail->setFrom(SENDER_ADMIN_MAIL, $Brand);
//$mail->addReplyTo($RemitenteMail, $Brand);
if (IS_RUSSIAN_DOMAIN) {
    $mail->addBCC(SENDER_ADMIN_MAIL, $Brand);
}
$mail->addAddress('angel@pixan.io', $Brand);
$mail->Subject = 'HOLA SUBJECT';;
$mail->msgHTML('HOLA HTML');
$mail->AltBody = 'HELLO ALT';

echo $mail->send();
var_dump($mail->ErrorInfo);