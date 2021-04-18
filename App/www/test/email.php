<?php

$alertemail = getenv('alerts_email'); 

$to      = $alertemail;
$subject = 'the subject';
$message = 'hellofromzesparky';
$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>