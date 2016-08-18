<?php

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

if(isset($_GET['token'])){
	
	$sql = "SELECT appUrl FROM mails where hash='".$_GET['token']."'";
	$result = $conn->query($sql);

	if ($result->num_rows == 1) {

		$row = $result->fetch_assoc();
			
		$sql = "SELECT id, appUrl, sentence, ownerName FROM reviewCandidate where appUrl='".$row["appUrl"]."'";
		$result = $conn->query($sql);

		if ($result->num_rows == 1) {

			$row = $result->fetch_assoc();
			
			$launchId = $row["id"];
			
			$launchUrl = $row["appUrl"];
			
			$launchSentence = $row["sentence"];
			
			$launchName = $row["ownerName"];

		} else if($result->num_rows > 1){
			
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
			
		} // if we don't find a matching reviewCandidate we simply show the list
		
	} else if($result->num_rows > 1){
		
		$mail->Subject = 'error encountered: illegal appUrl from hash';

		$mail->Body = "illegal appUrl from hash... -> ".$conn->error;
		
		$mail->addAddress('sander.theetaert@gmail.com', 'asignee'); 
		
		$mail->send();//fire and forget

	?>

		<script>
			alert("an error has occured, you will be redirected to the main page...");
			window.location.assign("m.php");
		</script>
		
	<?
		die;
		
	} // same for the token
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
      <a class="navbar-brand" href="#">Android Liftoff : to be reviewed list...</a>
    </div>
  </div>
  
	<div class="jumbotron text-center">
		<h1>The infamous to be reviewed list...</h1> 
	</div>
<?

if(isset($launchId)){
		
?>
	
	
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		
			<h2>This is your app, are you ready to launch?</h2>
		
			<div class="well">
<?

	$html = file_get_html($launchUrl);
	
	foreach($html->find('div.content') as $potentialNumber){
	
		if($potentialNumber->itemprop=='numDownloads'){
			$number = $potentialNumber->innertext;
			
			break;
		}
	}

	$maxDownloads = explode ( " - " , $number)[1]; //needed later on

	$title = $html->find('div.id-app-title',0)->innertext;
	
	$src = $html->find('img.cover-image',0)->src;
	
	$counter = 0;
	
	foreach($html->find('span') as $element) {
		
		if($element->itemprop == "genre"){
			
			$genre[$counter++] = $element->innertext;
		}
	}

?>

			
				<div class="row">
					<div class="col-sm-2">
						<? echo "<img src='".$src."' width='100' height='100'/>"; ?>
					</div>
					<div class="col-sm-8">
						<div class="row">
							<div class="col-sm-12">
								<h4><? echo $title." by ".$launchName; ?></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p>
<?
									foreach($genre as $genreElement) {
										
										echo $genreElement . "&nbsp;";
										
									}
?>
								</p>
							</div>
						</div>
						<form action="submitApp.php" method="post">
						<div class="row">
							<div class="col-sm-12">
								<p><? echo $launchSentence; ?></p>
							</div>
						</div>
					</div>
					<div class="col-sm-2"><button type="button" class="btn btn-primary" id="launch">Launch!!!</button></div>
				</div>
			</div>
			
<?
}

$sql = "SELECT appUrl, sentence, ownerName FROM reviewCandidate where status='verified' order by timeStamp desc";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	
	$counter = 0;
	
    while($row = $result->fetch_assoc()) {
		
		if(isset($launchId)){
			//exclude to be launched app
		}
		
		$appList[$counter++] = array(
			"appUrl" => $row["appUrl"],
			"sentence" => $row["sentence"],
			"ownerName" => $row["ownerName"],
		);
    }
	
	foreach($appList as $app){
		
		$html = file_get_html($app["appUrl"]);
		
		foreach($html->find('div.content') as $potentialNumber){
		
			if($potentialNumber->itemprop=='numDownloads'){
				$app["number"] = $potentialNumber->innertext;
				
				break;
			}
		}

		$app["maxDownloads"] = explode ( " - " , $number)[1]; //needed later on

		$app["title"] = $html->find('div.id-app-title',0)->innertext;
		
		$app["src"] = $html->find('img.cover-image',0)->src;
		
		$counter = 0;
		
		foreach($html->find('span') as $element) {
			
			if($element->itemprop == "genre"){
				
				$app["genre"][$counter++] = $element->innertext;
			}
		}
	}

	
	//for each reviewCandidate
	{

		$html = file_get_html($launchUrl);
		
		foreach($html->find('div.content') as $potentialNumber){
		
			if($potentialNumber->itemprop=='numDownloads'){
				$number = $potentialNumber->innertext;
				
				break;
			}
		}

		$maxDownloads = explode ( " - " , $number)[1]; //needed later on

		$title = $html->find('div.id-app-title',0)->innertext;
		
		$src = $html->find('img.cover-image',0)->src;
		
		$counter = 0;
		
		foreach($html->find('span') as $element) {
			
			if($element->itemprop == "genre"){
				
				$genre[$counter++] = $element->innertext;
			}
		}

	?>
				<div class="well">
					<div class="row">
						<div class="col-sm-2">
							<? echo "<img src='".$src."' width='100' height='100'/>"; ?>
						</div>
						<div class="col-sm-8">
							<div class="row">
								<div class="col-sm-12">
									<h4><? echo $title." by ".$launchName; ?></h4>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<p>
	<?
										foreach($genre as $genreElement) {
											
											echo $genreElement . "&nbsp;";
											
										}
	?>
									</p>
								</div>
							</div>
							<form action="submitApp.php" method="post">
							<div class="row">
								<div class="col-sm-12">
									<p><? echo $launchSentence; ?></p>
								</div>
							</div>
						</div>
						<div class="col-sm-2"><button type="button" class="btn btn-primary" id="launch">Launch!!!</button></div>
					</div>
				</div>	
	<?

	}
}
?>
		</div>
		<div class="col-sm-2"></div>
	</div>
</nav>
</body>
</html>
<?

$conn->close();

?>