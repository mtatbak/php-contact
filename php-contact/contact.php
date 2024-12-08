<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$from = '';
$to = '';
$subject = '';
$okMessage = '';
$errorMessage = '';

$fields = array(
    'name' => '',
    'email' => '',
    'message' => '',
    'product' => ''
);

try {
    $emailText = ":\n=============================\n";

    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8'; 
    $mail->isSMTP();
    $mail->Host = ''; // SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = ''; // SMTP username 
    $mail->Password = ""; // SMTP Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS 
    $mail->Port = 587; // 

    $mail->setFrom($from, '');
    $mail->addAddress($to); // 

    $mail->isHTML(false); // 
    $mail->Subject = $subject;
    $mail->Body = $emailText;

    $mail->send();

    $responseArray = array('type' => 'success', 'message' => $okMessage);
} catch (Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage . ' Error: ' . $mail->ErrorInfo);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    echo json_encode($responseArray);
} else {
    echo $responseArray['message'];
}

?>
