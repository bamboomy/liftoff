<?php

session_start();

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

$sql = "select count(*) as count from reviewCandidate where ip='".$_SERVER['REMOTE_ADDR']."';";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // output data of each row
    $row = $result->fetch_assoc();
	
	if($row["count"] > 0 && !isset($_SESSION['login_user'])){
		
?>
	<script>
		alert("you can't submit multiple apps if you're not registered (and logged in)...");
		window.location.assign("m.php");
	</script>
<?
		die;
	}

} else {

	$mail->Subject = "error encountered: 0 results";

	$mail->Body = "0 results... -> ".$conn->error;
	
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

$email = $_POST['mailAddress'];

if(isset($_SESSION['login_user'])){

	$sql = "INSERT INTO reviewCandidate (appUrl, sentence, ownerId, ownerEmail, ownerName, maxDownloads, title, src, genre, ip) ";
	$sql .= "VALUES ('".addslashes($_POST['url'])."', '".addslashes($_POST['sentence'])."', '".$_SESSION['id']."', '".addslashes($_POST['mailAddress'])."', '".addslashes($_POST['username'])."', ";
	$sql .= "'".addslashes($_POST['maxDownloads'])."', '".addslashes($_POST['title'])."', '".addslashes($_POST['src'])."', '".addslashes($_POST['genre'])."', '".$_SERVER['REMOTE_ADDR']."')";

}else{
	
	$sql = "INSERT INTO user (name, email) ";
	$sql .= "VALUES ('".addslashes($_POST['username'])."', '".addslashes($_POST['mailAddress'])."')";

	if ($conn->query($sql) !== TRUE) {

		//TODO: error module
		
		$mail->Subject = "error encountered: couldn't insert user";

		$mail->Body = "couldn't insert user... -> ".$conn->error;
		
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

	$sql = "SELECT id FROM user where name='".addslashes($_POST['username'])."' and email='".addslashes($_POST['mailAddress'])."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$ownerId = $row["id"];//we need the last one
		}
	} else {

		$mail->Subject = "error encountered: 0 results";

		$mail->Body = "0 results... -> ".$conn->error;
		
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

	$sql = "INSERT INTO reviewCandidate (appUrl, sentence, ownerId, ownerEmail, ownerName, maxDownloads, title, src, genre, ip) ";
	$sql .= "VALUES ('".addslashes($_POST['url'])."', '".addslashes($_POST['sentence'])."', '".$ownerId."', '".addslashes($_POST['mailAddress'])."', '".addslashes($_POST['username'])."', ";
	$sql .= "'".addslashes($_POST['maxDownloads'])."', '".addslashes($_POST['title'])."', '".addslashes($_POST['src'])."', '".addslashes($_POST['genre'])."', '".$_SERVER['REMOTE_ADDR']."')";

}

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

	include("mails/initial_registration.php");

	$mail->Subject = $subject;
	$mail->Body = $mailContent;

	$mail->AltBody = 'Unfortunately non-html clients are not supported.';
	
	$mail->addAddress('sander.theetaert@gmail.com', $_POST['username']);  //needs to be replaced with owner e-mail (from session or from registration) -> $email

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

		$sql = "INSERT INTO mails (appUrl, userName, mailAddress, hash) VALUES ('".addslashes($_POST['url'])."', '".addslashes($_POST['username'])."', '".$email."', '".$hash."');";

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
  <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
<?

include "nav.php";

?>
  
	<div class="jumbotron text-center">
		<h1>Mail sent...</h1> 
	</div>

	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		
			<div class="well">

				<p>A mail has been sent to '<?echo $email;?>' with a link to register the app.<br/>
				<br/>
				Once you verify the app it is registered and will be put on the to be reviewed list.<br/>
				<br/>
<?
if(!isset($_SESSION['login_user'])){
?>

				Additionally, the name of the owner of the app is registered as well,<br/>
				<br/>
				If you wish, you can register on this site when verifying the app with the link in the mail.<br/>
				<br/>
<?
}else{
?>
				<a href="crib.php">Back to crib.</a><br/>
				<br/>
<?
}
?>
				<a href="m.php">Back to main page.</a><br/>
				</p>
			
			</div>
			
		</div>
		<div class="col-sm-2"></div>
	</div>
</body>
</html>
<?
		
		}
	}
}

$conn->close();

?>