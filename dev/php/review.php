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

$sql = "SELECT id, appUrl, sentence, ownerName FROM reviewCandidate where id='".$_POST["id"]."'";
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
      <a class="navbar-brand" href="#">Android Liftoff : review app</a>
    </div>
  </div>
</nav>  
<div class="container-fluid androidGreen">
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-12">
					<div class="jumbotron">
						<h2>This is how the app will look in the app list:</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="well">
						<div class="row">
							<div class="col-sm-2">
<?php

	$html = file_get_html($row['appUrl']);

	foreach($html->find('div.content') as $potentialNumber){
		
		if($potentialNumber->itemprop=='numDownloads'){
			$number = $potentialNumber->innertext;
			
			break;
		}
	}

	$maxDownloads = str_replace ( ",", "", explode ( " - " , $number)[1]);

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
					</div>
				</div>
				<div class="col-sm-2"></div>
			</div>
		</div>
	</div>
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
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">

			<div class="well">
				<div class="row">
					<div class="col-sm-2">Review by <?echo $_SESSION['login_user']; ?></div>
					<div class="col-sm-8"><textarea rows="15" cols="80" name="content"></textarea></div>
					<div class="col-sm-2"></div>
				</div>
			</div>
		</div>
		<div class="col-sm-2"></div>
	</div>
</div>
</body>
</html>

<?
}

$conn->close(); //we don't want the connection be hanging around with the heavy processing comming ahead...

?>