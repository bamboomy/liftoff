<?php

session_start();

require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

include_once("settings.php");

include_once("classes.php");

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
	<link rel="stylesheet" type="text/css" href="../css/apps.css">
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
	<script src="../js/m.js"></script>
	<script src="../js/apps.js"></script>
</head>
<body>
<?

include "nav.php";

?>
  
	<div class="container-fluid androidGreen">
		<div class="jumbotron text-center">
			<h1>The (soon to be famous) app list</h1> 
		</div>
	</div>

	<div class="container-fluid androidGreen">
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
			
				<div class="well">
				
					<h3>Apps</h3>
					
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
<?							

$sql = "SELECT review.`id`, review.`app_id`, count(appVote.appid) as votes";
$sql .= " FROM `review`";
$sql .= " left join appVote on review.app_id = appVote.appid";
$sql .= " WHERE status='approved'";
$sql .= " GROUP BY review.id";
$sql .= " order BY votes desc";

$result = $conn->query($sql);

?>
							<h4><? echo $result->num_rows; ?> apps (and counting)</h4>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
<?

$infix = "published";

$published = true;

$strategy = new ListStrategy();
$strategy->setSql3("SELECT `id`, `app_id`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`, ownerId FROM `review` WHERE app_id=", " and status='approved'");
$strategy->setShowVotes(true);
$strategy->setConn($conn);

include 'reviewList.php';
	
?>									
								</div>
								<div class="col-sm-1"></div>
							</div>
						</div>
						<div class="col-sm-1"></div>
					</div>
				
				</div>
				
			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>
	
<div id="voteCastModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Your vote has been cast; thanks :)</h4>
      </div>
      <div class="modal-body">
		<p>Remaining votes: 0</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
	
</body>
</html>
<?

$conn->close();

?>
