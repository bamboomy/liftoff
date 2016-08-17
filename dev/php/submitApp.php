<?php

require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

include_once("settings.php");

// this is the hash which identifies a mail sent

$hash = md5(md5(md5(time()) . $_POST['username']) . $_POST['username']);

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

//ownerId == 0 because we don't neccesarily know the owner yet (we let him register after app submission...).

$sql = "INSERT INTO reviewCandidate (appUrl, sentence, ownerId, ownerEmail) VALUES ('".$_POST['url']."', '".$_POST['sentence']."', '0', '".$_POST['mailAddress']."');";

if ($conn->query($sql) !== TRUE) {
	
	//TODO: error module
	
	$mail->Subject = 'error encountered: reviewCandidate';

	$mail->Body = "couldn't insert reviewCandidate... -> ".$conn->error;
	
	$mail->addAddress('sander.theetaert@gmail.com', 'asignee'); 
	
	$mail->send();//fire and forget

?>

	<script>
		alert("an error has occured, you will be redirected to the main page...");
		window.location.assign("m.php");
	</script>
	
<?
	die;

}else{

	$mail->Subject = 'App registered';

	$mailContent = "Hey ".$_POST['username'].", <br/><br/>someone, ideally you, has registerd the app '".$_POST['appName']."' on ".$liftoffUrl."...<br/><br/>";

	$mailContent .= "If it was you, you can click <a href='".$liftoffBaseUrl."mailRegistration.php?hash=".$hash."'>this link</a> to register your app.<br/><br/>";

	$mailContent .= "If you weren't expecting this e-mail you can safely ignore it.<br/><br/>";

	$mailContent .= "If you have recieved more mails like this and you don't want to receive any anymore you can click <a href=''>this link to unsubscribe</a>.<br/><br/>";

	$mailContent .= "Thanks for choosing Android Liftoff,<br/><br/>we wish you a nice day and all the best with your app :).<br/><br/>";

	$mailContent .= "Sincerely,<br/>The Android Liftoff team.";

	$mail->Body = $mailContent;

	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
	$mail->addAddress('sander.theetaert@gmail.com', $_POST['name']);  //needs to be replaced with owner e-mail

	if(!$mail->send()) {
		
		//TODO: error module (db)
		
		//echo 'Message could not be sent.';
		//echo 'Mailer Error: ' . $mail->ErrorInfo; -> usefull info
		
		?>

			<script>
				alert("an error has occured, you will be redirected to the main page...");
				window.location.assign("m.php");
			</script>
			
		<?
		
		die;
	
	} else {

		$sql = "INSERT INTO mails (appUrl, userName, mailAddress, hash) VALUES ('".$_POST['url']."', '".$_POST['username']."', '".$_POST['mailAddress']."', '".$hash."');";

		if ($conn->query($sql) !== TRUE) {
			
			//TODO: error module
			
			$mail->Subject = 'error encountered';

			$mail->Body = $conn->error;

			$mail->addAddress('sander.theetaert@gmail.com', 'asignee'); 

			$mail->send();//fire and forget

		?>

			<script>
				alert("an error has occured, you will be redirected to the main page...");
				window.location.assign("m.php");
			</script>
			
		<?
			die;

		}else{
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Android Liftoff</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <style>
		.navbar {
			margin-bottom: 0;
			background-color: #a4ca39;
			z-index: 9999;
			border: 0;
			font-size: 12px !important;
			line-height: 1.42857143 !important;
			letter-spacing: 4px;
			border-radius: 0;
		}
		
		p, li, .small{
			letter-spacing: 2px;
		}
		
		.red {
			color: red;
		}
	</style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#">Android Liftoff : mail sent...</a>
    </div>
  </div>
  
	<div class="jumbotron text-center">
		<h1>Mail sent...</h1> 
	</div>

	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		
			<div class="well">

				<p>A mail has been sent to '<?echo $_POST['mailAddress'];?>' with a link to register the app.<br/>
				<br/>
				Once you verify the app it is registered and will be put on the to be reviewed list.<br/>
				<br/>
				<a href="m.php">Back to main page.</a><br/>
				</p>
			
			</div>
			
		</div>
		<div class="col-sm-2"></div>
	</div>
</nav>
</body>
</html>
<?
		
		}
	}
}

$conn->close();

?>