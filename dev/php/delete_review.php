<?php

session_start();

require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

include_once("settings.php");

//first set mail parameters for possible errors

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'email-smtp.eu-west-1.amazonaws.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'AKIAIMKPUBJMO74AKAPQ';                 // SMTP username
$mail->Password = 'AmxqPmX2st17Ace/QDU2uffcBMfZ4w2kiAx1yIQZ5JVD';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;    

$mail->setFrom('bamboomy@gmail.com', 'Liftoff staff');

$mail->isHTML(true); 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {

	$mail->Subject = 'error encountered: no database';

	$mail->Body = "couldn't connect to database... -> ".$conn->connect_error;
	
	$mail->addAddress('sander.theetaert@gmail.com', 'asignee'); 
	
	$mail->send();//fire and forget

?>
	<script>
		alert("an error has occured, you will be redirected to the main page...");
		window.location.assign("m.php");
	</script>
<?
	die;
} 

$sql = "SELECT * FROM `review` WHERE ownerId = '".$_SESSION['id']."' and id='".addslashes($_GET['id']).
	"' and (status='need_owner' or status='need_admin' or status='reject_own' or status='reject_mod')";
		
$result = $conn->query($sql);		

if($result->num_rows != 1){
	
	$mail->Subject = 'attempt to approve review without authorization: '.$_GET['id']."!!!";

	$mail->Body = 'attempt to approve review without authorization: '.$_GET['id']."!!!";
	
	$mail->addAddress('sander.theetaert@gmail.com', 'asignee'); 
	
	$mail->send();//fire and forget

?>
	<script>
		alert("an error has occured, you will be redirected to the main page...");
		window.location.assign("m.php");
	</script>
<?
	die;
}

$row = $result->fetch_assoc();

$appId = $row['appid'];

$sql = "UPDATE review SET status='deleted' WHERE id='".addslashes($_GET['id'])."'";

if ($conn->query($sql) !== TRUE) {

	$mail->Subject = "error encountered: couldn't delete review";

	$mail->Body = "couldn't delete review... -> ".$conn->error;
	
	$mail->addAddress('sander.theetaert@gmail.com', 'asignee'); 
	
	$mail->send();//fire and forget

?>
	<script>
		alert("an error has occured, you will be redirected to the main page...");
		window.location.assign("m.php");
	</script>
<?
	die;
}

//TODO: when 10 rejections remove reviewcandidate from to be reviewed list

?>
	<script>
		alert("review deleted...");
		window.location.assign("crib.php");
	</script>
<?

$conn->close();

?>