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

$mail->setFrom('bamboomy@gmail.com', 'Liftoff error reporting');

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

$sql = "INSERT INTO `app`(`reviewCandidateId`, `url`, `votes`, `status`)";
$sql .= "VALUES (".$_POST['reviewCandidateId'].",'".$_POST['appUrl']."','0','need_administration')";

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

$sql = "SELECT id FROM app where url='".$_POST['appUrl']."'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // output data of each row
    $row = $result->fetch_assoc();
	
	$sql = "INSERT INTO `review`(`ownerId`,`appId`, `status`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`)";
	$sql .= "VALUES ('".$_SESSION['id']."','".$row['id']."','need_administration','".$_POST['content']."','".$_POST['pro0']."','".$_POST['con0'];
	$sql .= "','".$_POST['pro1']."','".$_POST['con1']."','".$_POST['pro2']."','".$_POST['con2']."')";

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

}else{

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

$sql = "UPDATE reviewCandidate SET status='review_pending' WHERE id='".$_POST['reviewCandidateId']."'";

if ($conn->query($sql) !== TRUE) {

	$mail->Subject = "error encountered: couldn't update mail";

	$mail->Body = "couldn't update mail... -> ".$conn->error;
	
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
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#">Android Liftoff : review submitted...</a>
    </div>
  </div>
</nav>
  
	<div class="jumbotron text-center">
		<h1>Thanks for your review :)</h1> 
	</div>

	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		
			<div class="well">

				<p>
				We've succesfully gotten your review,<br/>
				<br/>
				Thanks a bunch!!!<br/>
				<br/>
				Your review is only 2 steps away to be shown on the main page:
				<ol>
					<li>Moderator review</li>
					<li>App owner review</li>
				</ol>
				<br/>
				<ol>
					<li>We first like to check whether the review complies with site policies, nothing fancy here.</li>
					<li>We also let the app owner agree with the review (or not), you wouldn't like to have a bad review about your app either, no?</li>
				</ol>
				<br/>
				By every step you get a confirmation e-mail,<br/>
				<br/>
				And you can watch the progress of your reviews on your <a href='crib.php'>'crib'</a> page...<br/>
				<br/>
				You can <a href="toBeReviewedList.php">review another app</a> or <a href="m.php">go back to main page...</a><br/>
				<br/>
				Thanks again!!!<br/>
				<br/>
				The liftoff team.<br/>
				</p>
			
			</div>
			
		</div>
		<div class="col-sm-2"></div>
	</div>
</body>
</html>
<?

$conn->close();

?>