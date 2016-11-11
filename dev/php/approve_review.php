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

$sql = "SELECT * FROM `review` WHERE appid in (";
	$sql .= "select id from app where reviewCandidate_id in (";
		$sql .= "select id from reviewCandidate where ownerId = '".$_SESSION['id']."'";
		$sql .= ")) and id='".addslashes($_GET['id'])."' and status='need_owner'";
		
$result = $conn->query($sql);		

if($result->num_rows != 1){
	
	$mail->Subject = 'attempt to approve review without authorization: '.$_GET['id']."!!!";

	$mail->Body = 'attempt to approve review without authorization: '.$_GET['id']."!!!<br/><br/>".$sql;
	
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

	$sql4 = "SELECT `name`, email FROM `user` WHERE id='".$row['ownerId']."'";
	
	$result4 = $conn->query($sql4);

	if($result4->num_rows != 1){
		//2DO: ERROR HANDLING
		echo "no username";
		die;
	}
	
	$row4 = $result4->fetch_assoc();

	$reviewOwnerName = $row4['name'];

	$reviewOwnerEmail = $row4['email'];

$appId = $row['appid'];

$sql = "UPDATE review SET status='approved' WHERE id='".addslashes($_GET['id'])."'";

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

?>
	<script>
		alert("review approved...");
	</script>
<?

$sql = "SELECT id FROM `app` WHERE id = ".$appId." and status='2breviewed'";

$result = $conn->query($sql);		

if($result->num_rows == 1){

	$sql = "UPDATE app SET status='approved' WHERE id='".$appId."'";

	if ($conn->query($sql) !== TRUE) {

		$mail->Subject = "error encountered: couldn't update app";

		$mail->Body = "couldn't update app... -> ".$conn->error;
		
		$mail->addAddress('sander.theetaert@gmail.com', 'asignee'); 
		
		$mail->send();//fire and forget

	?>
		<script>
			alert("an error has occured, you will be redirected to your home...");
			window.location.assign("crib.php");
		</script>
	<?
		die;
	}

	$sql = "UPDATE reviewCandidate SET status='reviewed' WHERE id=(";
		$sql .= "select reviewCandidateId from app where id=".$appId.")";

	if ($conn->query($sql) !== TRUE) {

		$mail->Subject = "error encountered: couldn't update reviewCandidate";

		$mail->Body = "couldn't update reviewCandidate... -> ".$conn->error;
		
		$mail->addAddress('sander.theetaert@gmail.com', 'asignee'); 
		
		$mail->send();//fire and forget

	?>
		<script>
			alert("an error has occured, you will be redirected to your home...");
			window.location.assign("crib.php");
		</script>
	<?
		die;
	}
?>
	<script>
		alert("This was the first review for this app, the app is now visible on the main site...");
	</script>
<?
	
}

include("mails/review_approved.php");

	$mail->Subject = $subject;
	$mail->Body = $mailContent;

	$mail->AltBody = 'Unfortunately non-html clients are not supported.';

	$mail->clearAddresses();
	$mail->addAddress($reviewOwnerEmail, $reviewOwnerName);//TODO: once tested, remove again until alpha
	
	//$mail->addAddress('sander.theetaert@gmail.com', $reviewOwnerName."(".$reviewOwnerEmail.")");  //needs to be replaced with owner e-mail (from session or from registration) -> $email

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

?>
	<script>
		window.location.assign("crib.php");
	</script>
<?




$conn->close();

?>