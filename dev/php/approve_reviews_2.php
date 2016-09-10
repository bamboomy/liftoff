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
if ($conn->connect_error || $_SESSION['login_user'] !== 'Matdoya') {

	$mail->Subject = 'error encountered: no database';

	$mail->Body = "couldn't connect to database or hackattempt... -> ".$conn->connect_error;
	
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
      <a class="navbar-brand" href="#">Android Liftoff : admin: review approvement administration</a>
    </div>
  </div>
 </nav>
  
	<div class="container-fluid androidGreen">
		<div class="jumbotron text-center">
			<h1>Ready to approve?</h1> 
		</div>
	</div>

	<div class="container-fluid androidGreen">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
			
				<div class="well">
<?

$sql = "SELECT `id`, `appid` FROM `review` WHERE status='need_admin' order by appid";
$result = $conn->query($sql);

					echo "<h1>".$result->num_rows." to do</h1>";

	if($result->num_rows > 0){
		
		$appCounter = 0;
		
		$reviewCounter = 0;
		
		$oldAppId = -1;
		
		while($row = $result->fetch_assoc()){
			
			$app[$reviewCounter]['id'] 		= $row['id'];
			$app[$reviewCounter]['appid'] 	= $row['appid'];
			
			$reviewCounter++;
			
			if($oldAppId !== $row['appid']){

				$reviewCounter = 0;
				
				$oldAppId = $row['appid'];
				
				$appz[$appCounter++] = $app;
			}
		}

		foreach($appz as $app){
			
		
			$sql2 = "SELECT `id`, `appUrl`, `sentence`, `title`, `src`, `genre`, ownerName FROM `reviewCandidate` WHERE id = (";
			$sql2 .= "SELECT `reviewCandidateId` FROM `app` WHERE `id`='".$app[0]['appid']."')";

			$result2 = $conn->query($sql2);
			
			if($result2->num_rows == 0){
				//2DO: ERROR HANDLING
				echo "no reviewCandidates";
				die;
			}
			
			$row2 = $result2->fetch_assoc()
?>
									<div class="row">
										<div class="col-sm-1"></div>
										<div class="col-sm-11">
											<div class="row">
												<div class="col-sm-2"><? echo "<img src='".$row2['src']."' width='100' height='100' />";?></div>
												<div class="col-sm-8">
													<div class="row">
														<div class="col-sm-12">
															<h4><?php echo $row2['title']." by ".$row2['ownerName']; ?></h4>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<p><? echo $row2['genre']; ?></p>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<p><? echo $row2['sentence']; ?></p>
														</div>
													</div>
												</div>
												<div class="col-sm-2"></div>
											</div>
										</div>
									</div>
<?			

			$sql3 = "SELECT `id`, `appid`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`, ownerId";
			$sql3 .= " FROM `review` WHERE appid=".$app[0]['appid'];
			
			$result3 = $conn->query($sql3);
		
			if($result3->num_rows == 0){
				//2DO: ERROR HANDLING
				echo "no reviews";
				die;
			}

			$reviewCounter = 0;
			
			while($row3 = $result3->fetch_assoc()){

				$sql4 = "SELECT `name` FROM `user` WHERE id=".$row3['ownerId'];
				
				$result4 = $conn->query($sql4);
			
				if($result4->num_rows != 1){
					//2DO: ERROR HANDLING
					echo "no username";
					die;
				}
				
				$row4 = $result4->fetch_assoc()

?>			
									<br/>
									<div class="row">
										<div class="col-sm-1"></div>
										<div class="col-sm-11">
											<div class="row">
												<div class="col-sm-2">
													<? echo "<a class='btn btn-primary' data-toggle='collapse' href='#review_need_admin_".$app[0]['id']."_".$reviewCounter."'>Review by ".$row4['name']."</a>"; ?>
												</div>
												<div class="col-sm-10"></div>
											</div>
										</div>
									</div>
									<br/>
									<div class="row">
										<div class="col-sm-1"></div>
										<div class="col-sm-11">
										<? echo "<div class='collapse well' id='review_need_admin_".$app[0]['id']."_".$reviewCounter."'>"; ?>
											<div class="row">
												<div class="col-sm-2">
													Review by <?echo $row4['name']; ?><br/>
													<br/>
												</div>
												<div class="col-sm-8">
													<p><? echo nl2br($row3['text']); ?></p>
												</div>
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
												<div class="col-sm-4"><p><? echo $row3['pro0']; ?></p></div>
												<div class="col-sm-4"><p><? echo $row3['con0']; ?></p></div>
												<div class="col-sm-2"></div>
											</div>
											<br/>
											<?
												if($row3['pro1'] !== "" || $row3['con1'] !== ""){
											?>
											<div class="row">
												<div class="col-sm-2"></div>
												<?
													if($row3['pro1'] !== ""){
												?>
												<div class="col-sm-4"><p><? echo $row3['pro1']; ?></p></div>
												<?
													}else{
												?>
												<div class="col-sm-4"></div>
												<?
													}
													if($row3['con1'] !== ""){
												?>
												<div class="col-sm-4"><p><? echo $row3['con1']; ?></p></div>
												<?
													}else{
												?>
												<div class="col-sm-4"></div>
												<?
													}
												?>
												<div class="col-sm-2"></div>
											</div>
											<br/>
											<?
												}
											?>
											<?
												if($row3['pro2'] !== "" || $row3['con2'] !== ""){
											?>
											<div class="row">
												<div class="col-sm-2"></div>
												<?
													if($row3['pro2'] !== ""){
												?>
												<div class="col-sm-4"><p><? echo $row3['pro2']; ?></p></div>
												<?
													}else{
												?>
												<div class="col-sm-4"></div>
												<?
													}
													if($row3['con2'] !== ""){
												?>
												<div class="col-sm-4"><p><? echo $row3['con2']; ?></p></div>
												<?
													}else{
												?>
												<div class="col-sm-4"></div>
												<?
													}
												?>
												<div class="col-sm-2"></div>
											</div>
											<br/>
											<?
												}
											?>
											<div class="row">
												<div class="col-sm-2"></div>
												<div class="col-sm-6">
												</div>
												<div class="col-sm-2">
													<? echo "<input type='hidden' name='id' value='".$row3['id']."' />"; ?>
													<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rejectModal">Reject</button>
												</div>
												<div class="col-sm-2">
													<form action="approve.php" method="post">
														<? echo "<input type='hidden' name='id' value='".$row3['id']."' />"; ?>
														<button type="submit" class="btn btn-primary" id="submitReview">Approve</button>
													</form>
												</div>
											</div>	
										</div>	
									</div>	
								</div>	
<?		
				$reviewCounter++;
			}
		}
	}
?>									
				</div>
			</div>
			<div class="col-sm-2"></div>
		</div>
	</div>

<div id="rejectModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Reject</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-1"></div>
					<div class="col-sm-2">Reason:</div>
					<div class="col-sm-7">
						<input type="text" id="reason" />
					</div>
					<div class="col-sm-2">
						<button class="btn btn-default pull-right" onclick="login();">Submit</button>
					</div>
				</div>
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