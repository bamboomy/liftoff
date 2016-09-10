<?php

session_start();

require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

include_once("settings.php");

include_once("simple_html_dom.php");

//first set mail parameters for possible errors

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'email-smtp.eu-west-1.amazonaws.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'AKIAIMKPUBJMO74AKAPQ';                 // SMTP username
$mail->Password = 'AmxqPmX2st17Ace/QDU2uffcBMfZ4w2kiAx1yIQZ5JVD';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;    

$mail->setFrom('bamboomy@gmail.com', 'Liftoff error reporter');

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

$sql = "SELECT id, appUrl, sentence, ownerName FROM reviewCandidate where id='".$_POST["id"]."' and (status='verified' or status='review_pending')";
$result = $conn->query($sql);

if ($result->num_rows != 1) {

			$mail->Subject = 'error encountered: illegal id reviewCandidate';

			$mail->Body = "illegal id reviewCandidate... -> ".$conn->error;
			
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
	
	$row = $result->fetch_assoc();
	
	$html = file_get_html($row['appUrl']);

	foreach($html->find('div.content') as $potentialNumber){
		
		if($potentialNumber->itemprop=='numDownloads'){
			$number = $potentialNumber->innertext;
			
			break;
		}
	}

	$maxDownloads = str_replace ( ",", "", explode ( " - " , $number)[1]);
	
	$launched = ($maxDownloads > 500);
	
	$launched = false;
	
	if($launched){
		
		$sql = "UPDATE reviewCandidate SET status='airborn' WHERE id='".$row['id']."'";

		if ($conn->query($sql) !== TRUE) {

			$mail->Subject = 'error encountered: illegal id reviewCandidate while setting airborn';

			$mail->Body = "illegal id reviewCandidate(airborn)... -> ".$conn->error;
			
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
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/main.css">
  <script src="../js/review.js"></script>
  </head>
<body>
<?

include "nav.php";

?>
<div class="container-fluid androidGreen">
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-12">
					<div class="jumbotron">
<?
	if($launched){
?>
						<h2>You're the last one who saw this app on this site...</h2>
<?	
	}else{
?>
						<h2>This is how the app will look in the app list:</h2>
<?	
	}					
?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="well">
						<div class="row">
							<div class="col-sm-2">
<?php

	$title = $html->find('div.id-app-title',0)->innertext;

	function startsWith($haystack, $needle){
		 $length = strlen($needle);
		 return (substr($haystack, 0, $length) === $needle);
	}

	$src = $html->find('img.cover-image',0)->src;
	
	echo "<img src='".$src."' width='100' height='100' />";
	
	$counter = 0;
	
	$genre = "unclassified";
	
	foreach($html->find('span') as $element) {
		
		if($element->itemprop == "genre"){
			
			$genre = $element->innertext;
			
			break;
		}
	}
?>					
							</div>
							<div class="col-sm-8">
								<div class="row">
									<div class="col-sm-12">
										<h4><?php echo $title." by ".$row['ownerName']; ?></h4>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<p><? echo $genre; ?></p>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<p><? echo $row['sentence']; ?></p>
									</div>
								</div>
							</div>
							<div class="col-sm-2"></div>
						</div>
						<br/>
<?
	if(!$launched){
?>
						<div class="row">
							<div class="col-sm-2">
								<a class="btn btn-primary" data-toggle="collapse" href="#review">Review by <?echo $_SESSION['login_user']; ?></a>
							</div>
							<div class="col-sm-10"></div>
						</div>
<?
	}
?>
					</div>
				</div>
				<div class="col-sm-2"></div>
			</div>
		</div>
	</div>
<?
	if(!$launched){
?>
	<div class="row collapse" id="review">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<form action="submitReview.php" method="post">
			<? 
			echo "<input type='hidden' name='reviewCandidateId' value='".$_POST["id"]."'/>"; 
			echo "<input type='hidden' name='appUrl' value='".$row["appUrl"]."'/>"; 
			?>
			<div class="well">
				<div class="row">
					<div class="col-sm-2">
						Review by <?echo $_SESSION['login_user']; ?><br/>
						<br/>
						<div id="feedback"></div>
					</div>
					<div class="col-sm-8"><textarea rows="15" cols="80" name="content" id="reviewText" onkeyup="verifyLength();"></textarea></div>
					<div class="col-sm-2"></div>
				</div>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-4">Pro</div>
					<div class="col-sm-4">Con</div>
					<div class="col-sm-2"></div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-4"><input name="pro0" type="text" id="pro0" onblur="checkWhetherToMove();" onkeyup="updateSubmitMessage();"/></div>
					<div class="col-sm-4"><input name="con0" type="text" id="con0" onblur="checkWhetherToMove();" onkeyup="updateSubmitMessage();"/></div>
					<div class="col-sm-2"></div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-4"><input id="pro1" name="pro1" type="text" onblur="checkWhetherToMove();" placeholder="(optional)"/></div>
					<div class="col-sm-4"><input id="con1" name="con1" type="text" onblur="checkWhetherToMove();" placeholder="(optional)"/></div>
					<div class="col-sm-2"></div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-4"><input id="pro2" name="pro2" type="text" onblur="checkWhetherToMove();" placeholder="(optional)"/></div>
					<div class="col-sm-4"><input id="con2" name="con2" type="text" onblur="checkWhetherToMove();" placeholder="(optional)"/></div>
					<div class="col-sm-2"></div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-7">
						<div id="submitMessage"></div>
					</div>
					<div class="col-sm-3">
						<button type="submit" class="btn btn-primary" id="submitReview" disabled="disabled">Submit for approval</button>
					</div>
				</div>	
			</div>
			</form>
		</div>
		<div class="col-sm-2"></div>
	</div>
<?
	}
?>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		<p>Notice: this can look different from the app you just clicked upon;<br/>
		This is because when submitting an app the image/appname is recorded and never updated until just now.<br/>
		Now the app will be recorded as well and can only be updated by the app owner once reviews are shown on the app review page.<br/>
		</p>
		</div>
		<div class="col-sm-2"></div>
	</div>
<?
	if($launched){
?>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">

			<div class="well">
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-8"><p>
						Between the app registration and just now this app has surpasssed 500 downloads...<br/>
						<br/>
						This site is only intended for an app to get it's first 500 downloads 
						so this app will not appear anymore on this site...<br/>
						<br/>
						You can <a href="toBeReviewedList.php">review another app</a> if you want...<br/>
					</p></div>
					<div class="col-sm-2"></div>
				</div>
			</div>
		</div>
		<div class="col-sm-2"></div>
	</div>

<?		
	}
?>	
</div>
</body>
</html>

<?
}

$conn->close(); //we don't want the connection be hanging around with the heavy processing comming ahead...

?>