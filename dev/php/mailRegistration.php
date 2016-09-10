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

//retrieve hash from db

$sql = "SELECT appUrl, userName, mailAddress FROM mails where hash='".addslashes($_GET['hash'])."'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {

    $row = $result->fetch_assoc();
        
		//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    
} else if($result->num_rows > 1){
	
	echo "this shouldn't be...";
	die;
	
}else{

    //add ip to block list

?>

	<script>
		alert("an error has occured, you will be redirected to the main page...");
		window.location.assign("m.php");
	</script>
	
<?
	die;
}

$sql = "UPDATE mails SET status='verified' WHERE hash='".addslashes($_GET['hash'])."'";

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
	
} else {

	$sql = "UPDATE reviewCandidate SET status='verified' WHERE appUrl='".$row["appUrl"]."' and status='new'";

	if ($conn->query($sql) !== TRUE) {

		$mail->Subject = "error encountered: couldn't update reviewCandidate";

		$mail->Body = "couldn't update reviewCandidate... -> ".$conn->error;
		
		$mail->addAddress('sander.theetaert@gmail.com', 'asignee'); 
		
		$mail->send();//fire and forget

	?>

		<script>
			alert("an error has occured, you will be redirected to the main page...");
			window.location.assign("m.php");
		</script>
		
	<?
		die;
		
	} else {

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
      <a class="navbar-brand" href="#">Android Liftoff : just one more thing...</a>
    </div>
  </div>
 </nav>
  
	<div class="container-fluid androidGreen">
		<div class="jumbotron text-center">
			<h1>3, 2, 1...</h1> 
		</div>
	</div>

	<div class="container-fluid androidGreen">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
			
				<div class="well">
					<p>
						Good news: Your app is now registered on our site :-D !!!<br/>
						<br/>
						It's not yet visible on the main site but that won't take long...<br/>
						<br/>
						It's waiting for a peer to review:<br/>
						<ul>
							<li>Your app is added to the to be reviewed list</li>
							<ul>
								<li>This list is sorted by:</li>
								<ul>
									<li>least number of downloads first</li>
									<li>then, oldest apps first</li>
								</ul>
							</ul>
							<li>Once some other app developer from this site has reviewed your app you will be notified.</li>
							<li>If you approve a review the app and that review will be promoted to the main site.</li>
							<li>Additional reviews also need to be approved by you to be added to the app on the main app list.</li>
						</ul>
						You can also review apps from others...<br/>
						<br/>
						<ul>
							<li>You can review as many apps as you like</li>
							<li>For every app you review you get a daily vote,</li>
							<ul>
								<li>Because you are amongst one of the first users of this site you get 1 vote for free.</li>
								<li>Every day you can cast all of your daily votes on the main app page.</li>
								<li>On this page apps are sorted on votes (popular apps are shown higher)</li>
								<li>You can only upvote a certain app once (and can't upvote your own apps)</li>
							</ul>
						</ul>
						And then the liftoff can commence...<br/>
						<br/>
						The review process already generates some downloads.<br/>
						<br/>
						And we'll do our best to attract as many people to the site<br/>
						where they'll get a nice list of promising apps with a short review and 3 +'s and -'s for every app.<br/>
						<br/>
						We don't have the intention to get as big as the play store itself... ;)<br/>
						<br/>
						..but 500 downloads for good apps seems like a decent promise towards our users...<br/>
						<br/>
						Thank you for choosing Android Liftoff :D<br/>
						<br/>
						If you want to review apps of others you can set a password below:<br/>
					</p>
				</div>
				
			</div>
			<div class="col-sm-2"></div>
		</div>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
			
				<div class="well">
					<form action="registerUser.php" method="post">
						<div class="well">
							<div class="row">
								<div class="col-sm-2"></div>
								<div class="col-sm-2"><p>Username:</p></div>
								<div class="col-sm-6">
									<?echo "<p>".$row['userName']."</p>\n";?>
									<?echo "<input type='hidden' value='".$row['userName']."' name='username'/>";?>
									<?echo "<input type='hidden' value='".$_GET['id']."' name='id'/>";?>
								</div>
								<div class="col-sm-2"></div>
							</div>
							<div class="row">
								<div class="col-sm-2"></div>
								<div class="col-sm-2"><p>E-mail:</p></div>
								<div class="col-sm-6">
									<?echo "<p>".$row['mailAddress']."</p>\n";?>
									<?echo "<input type='hidden' value='".$row['mailAddress']."' name='email'/>";?>
								</div>
								<div class="col-sm-2"></div>
							</div>
							<div class="row">
								<div class="col-sm-2"></div>
								<div class="col-sm-2"><p>Password:</p></div>
								<div class="col-sm-6">
									<?echo "<input type='password' id='pw1' class='password' onkeyup='validatePw(this)' name='pw'/>";?>
								</div>
								<div class="col-sm-2"></div>
							</div>
							<div class="row">
								<div class="col-sm-2"></div>
								<div class="col-sm-2"></div>
								<div class="col-sm-6">
									<div class="small">Password must contain at least 6 characters; 20 at most, UPPERCASE letters, lowercase letters, numbers and ideally special characters...<div id="pwoutput" class="red"></div></div>
								</div>
								<div class="col-sm-2"></div>
							</div>
							<div class="row">
								<div class="col-sm-2"></div>
								<div class="col-sm-2"><p>Once more:</p></div>
								<div class="col-sm-6">
									<?echo "<input type='password' id='pw2' onkeyup='verifyEquality();'/>";?>
								</div>
								<div class="col-sm-2"></div>
							</div>
							<div class="row">
								<div class="col-sm-2"></div>
								<div class="col-sm-2"></div>
								<div class="col-sm-6">
									<div id="pwoutput2" class="small red"></div>
								</div>
								<div class="col-sm-2"></div>
							</div>
							<div class="row">
								<div class="col-sm-4"></div>
								<div class="col-sm-3"></div>
								<div class="col-sm-3">
									<button type='submit' id='submit' disabled='disabled' class="btn btn-primary">I would love to review other apps!!!</button><br/><br/>
									<span class="center"><? echo "<a href='toBeReviewedList.php?token=".$_GET['hash']."'>No thanks</a>"; ?></span>
								</div>
								<div class="col-sm-2"></div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-sm-2"></div>
		</div>
	</div>
</body>
</html>
<?

	}

}

$conn->close();

?>