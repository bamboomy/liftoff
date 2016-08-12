<?php

include_once("simple_html_dom.php");

require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

function startsWith($haystack, $needle){
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

$html = file_get_html($_GET['appUrl']);

foreach($html->find('a') as $element) {
	
	$link = $element->href;
	
	if(startsWith($link, "mailto:")){
		echo explode(":",$link)[1] . '<br>';
	}
}

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'email-smtp.eu-west-1.amazonaws.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'AKIAIMKPUBJMO74AKAPQ';                 // SMTP username
$mail->Password = 'AmxqPmX2st17Ace/QDU2uffcBMfZ4w2kiAx1yIQZ5JVD';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;    

$mail->setFrom('bamboomy@gmail.com', 'Mailer');
$mail->addAddress('sander.theetaert@gmail.com', 'Joe User'); 

$mail->isHTML(true); 

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

?>