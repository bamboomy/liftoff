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

if(!isset($_SESSION['login_user'])){
	
?>
	<script>
		alert("You're not logged in...");
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
  <script src="../js/verify_password.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid androidGreen">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#">Android Liftoff : welcome to the crib...</a>
    </div>
  </div>
 </nav>
  
	<div class="container-fluid androidGreen">
		<div class="jumbotron text-center">
			<h1>Welcome home, <? echo $_SESSION['login_user']; ?> :)</h1> 
		</div>
	</div>

	<div class="container-fluid androidGreen">
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
			
				<div class="well">
				
					<h3>Reviews<h3>
					
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<h4>Written:</h4>
						</div>
						<div class="col-sm-1"></div>
					</div>
					
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<h4>Recieved:</h4>
						</div>
						<div class="col-sm-1"></div>
					</div>
				
				</div>
				
			</div>
			<div class="col-sm-1"></div>
		</div>
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
			
				<div class="well">
				
					<h3>Apps<h3>
<?

$sql = "SELECT id, appUrl, sentence, maxDownloads, title, src, genre FROM reviewCandidate where ownerId='".$_SESSION['id']."'";
$result = $conn->query($sql);

if($result->num_rows > 0){

?>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<h4>On the to be reviewed list:</h4>
<?	

	while($row = $result->fetch_assoc()) {
?>		
							<div class="row">
								<div class="col-sm-2">
									<? echo "<img src='".$row["src"]."' width='100' height='100'/>"; ?>
								</div>
								<div class="col-sm-8">
									<div class="row">
										<div class="col-sm-12">
											<h4><? echo $row["title"]; ?></h4>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<h4><? echo "position: "; ?> </h4>
										</div>
									</div>
								</div>
								<div class="col-sm-2"></div>
							</div>
<?		
	}
?>
						</div>
						<div class="col-sm-1"></div>
					</div>
<?	
	
}else{

?>
<?	
	
}

?>					
					
					
				</div>
				
			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>
</body>
</html>
<?

$conn->close();

?>