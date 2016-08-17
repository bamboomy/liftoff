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

$sql = "SELECT appUrl, userName, mailAddress FROM mails where hash='".$_GET['hash']."'";
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

$sql = "UPDATE mails SET status='verified' WHERE hash='".$_GET['hash']."'";

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
      <a class="navbar-brand" href="#">Android Liftoff : just one more thing...</a>
    </div>
  </div>
  
	<div class="jumbotron text-center">
		<h1>Just one more thing...</h1> 
	</div>

	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		
			<div class="well">
				<p>
					Good news: Your app is now registered on our site :-D !!!<br/>
					<br/>
					And that's not all of the good news!!!<br/>
					<br/>
					Although it is perfectly possible to just submit your app and stop your commitment there, there are many other things you can do here as well!!!<br/>
					<br/>
					For the present moment your app is only visible to other (registered) app owners or reviewers <br/>
					(and not to causal surfers of the site).<br/>
					<br/>
					If you register you have access to the other apps of the other app owners of this site!!!<br/>
					<br/>
					You can review apps of other owners and let them promote their app to the main site!!!<br/>
					<br/>
					Maybe one of them returns you the favour and your app is ready for some real liftoffing!!!<br/>
					<br/>
					Registering has other benefits as well:<br/>
					<ul>
						<li>You can review (as many) other apps (as you like).</li>
						<li>For every review for an app that is approved by the app owner, you get one vote.</li>
						<ul>
							<li>You can use all of your votes every day to vote up other apps.</li>
						</ul>
						<li>You can submit multiple apps (if you're not registered the same e-mail address can only have one submitted app).</li>
					</ul>
				</p>
			</div>
			
		</div>
		<div class="col-sm-2"></div>
	</div>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		
			<div class="well">
				<form action="registerUser" method="post">
					<div class="well">
						<div class="row">
							<div class="col-sm-2"></div>
							<div class="col-sm-2"><p>Username:</p></div>
							<div class="col-sm-6">
								<?echo "<input type='text' value='".$row["userName"]."'/>";?>
							</div>
							<div class="col-sm-2"></div>
						</div>
						<div class="row">
							<div class="col-sm-2"></div>
							<div class="col-sm-2"><p>E-mail:</p></div>
							<div class="col-sm-6">
								<?echo "<p>".$row['mailAddress']."</p>\n";?>
								<?echo "<input type='hidden' value='".$row['mailAddress']."' />";?>
							</div>
							<div class="col-sm-2"></div>
						</div>
						<div class="row">
							<div class="col-sm-2"></div>
							<div class="col-sm-2"><p>Password:</p></div>
							<div class="col-sm-6">
								<?echo "<input type='password' id='pw1' class='password' onkeyup='validatePw(this)'/>";?>
							</div>
							<div class="col-sm-2"></div>
						</div>
						<div class="row">
							<div class="col-sm-2"></div>
							<div class="col-sm-2"></div>
							<div class="col-sm-6">
								<div id="" class="small">Password must contain at least 6 characters; 20 at most, Uppercase letters, lowercase letters, numbers and ideally special characters:<div id="pwoutput" class="red"></div></div>
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
								<button type='submit' id='submit' disabled='disabled' class="btn btn-primary">I want to review other apps or submit another one of my own.</button><br/><br/>
								<? echo "<a href='toBeReviewedList.php?token=".$_GET['hash']."'>No thanks</a>"; ?>
							</div>
							<div class="col-sm-2"></div>
						</div>
					</div>
				</form>
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

$conn->close();

?>