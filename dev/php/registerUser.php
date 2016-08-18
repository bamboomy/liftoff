<?php

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

$salt = md5(md5(md5(time()) . md5(md5($_POST['username']) . $_POST['email'])));

$pwHash = md5(md5(md5($salt)) . md5($_POST['pw']));

$sql = "INSERT INTO user (name, email, salt, pwhash) ";
$sql .= "VALUES ('".$_POST['username']."', '".$_POST['email']."', '".$salt."', '".$pwHash."')";

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

}else{

	$mail->Subject = 'Password set.';

	$mailContent = "Hey ".$_POST['username'].", <br/><br/>someone, ideally you, set a password on ".$liftoffUrl."...<br/><br/>";

	$mailContent .= "If it was you, you can go to <a href='".$liftoffBaseUrl."toBeReviewedList.php'>the to be reviewed list</a> from now on to review apps from other users.<br/><br/>";

	$mailContent .= "Remember: for every review you write you get a daily vote to vote up apps that you like from the <a href='".$liftoffBaseUrl."appList.php'>main site app list</a>.<br/><br/>";

	$mailContent .= "You can also now <a href='".$liftoffBaseUrl."submitOtherApp.php'>submit</a> as many other apps as you like...<br/><br/>";

	$mailContent .= "Thanks for choosing Android Liftoff,<br/><br/>thanks for registering, we wish you a nice day and a lot of fun on the site :).<br/><br/>";

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
      <a class="navbar-brand" href="#">Android Liftoff : you are registered...</a>
    </div>
  </div>
 </nav>
  
	<div class="container-fluid androidGreen">
		<div class="jumbotron text-center">
			<h1>Welcome once more, <? echo $_POST['username']; ?>!!!</h1> 
		</div>

		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
			
				<div class="well">

					<h2>Congratulations, <? echo $_POST['username']; ?></h2>
				
					<p>
						... and welcome of course :)<br/>
						<br/>
						From now on until the end of time you will be able to:<br/>
						<ul>
							<li><a href="toBeReviewedList.php">Write as many reviews as you like.</a></li>
							<ul>
								<li>For every review you write you get an extra daily vote on the <a href="appList.php">main app list</a> (see above)</li>
								<ul>
									<li>And just because you are so special you get a first vote for free (this will be discontinued quite shortly).</a></li>
								</ul>
							</ul>
							<li>Vote on the <a hre="appList.php">app page</a>.</li>
							<li>Submit:</li>
							<ul>
								<li><a href="submitOtherApp.php">A second</a></li>
								<li><a href="submitOtherApp.php">A third</a></li>
								<li><a href="submitOtherApp.php">A fourth</a></li>
								<li>...</li> 
								(to be short) <a href="submitOtherApp.php">as many apps as you like</a> on the <a href="submitOtherApp.php">app submition page</a>.
							</ul>
						</ul><br/>
						<br/>
						Don't worry, all of this info is also mailed to you for easy reference...<br/>
						<br/>
					</p>
				</div>
			</div>
			<div class="col-sm-2"></div>
		</div>
	</div>
	</body>
</html>
<?

}

$conn->close();

?>