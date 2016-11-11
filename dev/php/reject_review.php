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

$sql = "SELECT * FROM `review` WHERE app_id in (";
	$sql .= "select id from app where reviewCandidate_id in (";
		$sql .= "select id from reviewCandidate where ownerId = '".$_SESSION['id']."'";
		$sql .= ")) and id='".addslashes($_POST['id'])."' and status='need_owner'";
		
$result = $conn->query($sql);		

if($result->num_rows != 1){
	
	$mail->Subject = 'attempt to reject review without authorization: '.$_POST['id']."!!!";

	$mail->Body = 'attempt to reject review without authorization: '.$_POST['id']."!!!<br/><br/>".$sql;
	
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

$sql = "UPDATE review SET status='reject_own', rejectReason='".addslashes($_POST['reason'])."' WHERE id='".addslashes($_POST['id'])."'";

if ($conn->query($sql) !== TRUE) {

	$mail->Subject = "error encountered: couldn't update review";

	$mail->Body = "couldn't update review... -> ".$conn->error;
	
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
		alert("review rejected...");
		window.location.assign("crib.php");
	</script>
<?

include("mails/review_rejected_owner.php");

	$mail->Subject = $subject;
	$mail->Body = $mailContent;

	$mail->AltBody = 'Unfortunately non-html clients are not supported.';

	$mail->clearAddresses();
	$mail->addAddress($_POST['reviewOwnerEmail'], $_POST['reviewOwnerName']);//TODO: once tested, remove again until alpha
	
	//$mail->addAddress('sander.theetaert@gmail.com', $_POST['username']);  //needs to be replaced with owner e-mail (from session or from registration) -> $email

	if(!$mail->send()) {
		
		//TODO: error module (db)
		
		//echo 'Message could not be sent.';
		//echo 'Mailer Error: ' . $mail->ErrorInfo; -> usefull info
		
		?>

			<script>
				alert("something went wrong whilst sending the mail...");
			</script>
			
		<?
	}


$conn->close();

?>