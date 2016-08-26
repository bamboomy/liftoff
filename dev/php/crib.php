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
	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
	<script src="../js/m.js"></script>
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
				
					<h3>Reviews</h3>
					
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
<?							

$sql = "SELECT  `appid` FROM  `review` WHERE  `ownerId` ='".$_SESSION['id']."'";
$result = $conn->query($sql);

?>
							<h4>Written: <? echo $result->num_rows; ?></h4>
<?
if($result->num_rows == 0){
?>
							
							<p>
							We encourage you to <a href="toBeReviewedList.php">write reviews</a>, for every review approved by at least a moderator;<br/>
							<b>your apps</b> get ranked higher in the to be reviewed list;<br/>
							(and are more likely to be chosen to be reviewed as well...)<br/>
							</p>
<?
}else{

	$sql = "SELECT `id`, `appid`";
	$sql .= " FROM `review` WHERE  `ownerId` ='".$_SESSION['id']."' and status='need_admin' order by appid";
	$result = $conn->query($sql);

?>	
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<h4>Yet to be approved: <? echo $result->num_rows; ?></h4>
									<br/>
<?
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
			$sql2 .= "SELECT `reviewCandidateId` FROM `app` WHERE `id`=".$app[0]['id'].")";
			
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

			$sql3 = "SELECT `id`, `appid`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`";
			$sql3 .= " FROM `review` WHERE appid=".$app[0]['id']." and `ownerId`=".$_SESSION['id'];
			
			$result3 = $conn->query($sql3);
		
			if($result3->num_rows == 0){
				//2DO: ERROR HANDLING
				echo "no reviews";
				die;
			}

			$reviewCounter = 0;
			
			while($row3 = $result3->fetch_assoc()){
?>			
									<br/>
									<div class="row">
										<div class="col-sm-1"></div>
										<div class="col-sm-11">
											<div class="row">
												<div class="col-sm-2">
													<? echo "<a class='btn btn-primary' data-toggle='collapse' href='#review_need_admin_".$app[0]['id']."_".$reviewCounter."'>Review by ".$_SESSION['login_user']."</a>"; ?>
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
													Review by <?echo $_SESSION['login_user']; ?><br/>
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
													}
													if($row3['con1'] !== ""){
												?>
												<div class="col-sm-4"><p><? echo $row3['con1']; ?></p></div>
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
													}
													if($row3['con2'] !== ""){
												?>
												<div class="col-sm-4"><p><? echo $row3['con2']; ?></p></div>
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
												<div class="col-sm-8">
												</div>
												<div class="col-sm-2">
													<button type="submit" class="btn btn-primary" id="submitReview" disabled="disabled">Edit</button>
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
								<div class="col-sm-1"></div>
							</div>
							<br/>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<h4>Approved by moderator: 0</h4>
									<p>This number is accounted for in the order of the to be reviewed list.</p>
								</div>
								<div class="col-sm-1"></div>
							</div>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<h4>Published: 0</h4>
								</div>
								<div class="col-sm-1"></div>
							</div>
<?							

	$sql = "SELECT  `appid` FROM  `review` WHERE  `ownerId` ='".$_SESSION['id']."' and status='rejected'";
	$result = $conn->query($sql);

	if($result->num_rows > 0){
?>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<h4>Rejected: <? echo $result->num_rows; ?></h4>
									<div class="row">
										<div class="col-sm-1"></div>
										<div class="col-sm-10">
											<h4>By moderator:</h4>
										</div>
										<div class="col-sm-1"></div>
									</div>
									<div class="row">
										<div class="col-sm-1"></div>
										<div class="col-sm-10">
											<h4>By app owner:</h4>
										</div>
										<div class="col-sm-1"></div>
									</div>
								</div>
								<div class="col-sm-1"></div>
							</div>
<?	
	}
}
?>
						</div>
						<div class="col-sm-1"></div>
					</div>
					
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<h4>Recieved: 0</h4>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<h4>To be approved: 0</h4>
								</div>
								<div class="col-sm-1"></div>
							</div>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<h4>Published: 0</h4>
								</div>
								<div class="col-sm-1"></div>
							</div>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<h4>Rejected: 0</h4>
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
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
			
				<div class="well">
				
					<h3>Apps</h3>
<?

$sql = "SELECT id, title, src, status FROM reviewCandidate where ownerId='".$_SESSION['id']."'";
$result = $conn->query($sql);

if($result->num_rows > 0){

?>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<h4>To be reviewed (yet): <? echo $result->num_rows; ?></h4>
							<br/>
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
<?
		if($row['status'] === 'new'){
?>
											<h4 style="color: red;">not yet verified</h4>
<?
		}else{
?>
											<h4><? echo "position: "; ?> </h4>
<?		
		}
?>
										
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
					<br/>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<h4>Submit a fresh app:</h4>
							<br/>
							<form class="form-inline" id="subscribeAppForm" action="register_app.php" method="post">
								<input type="app" class="form-control subscribe" size="80" 
									placeholder="https://play.google.com/store/apps/details?id=" 
									id="appurl" name="appurl" />
								<button type="submit" class="btn btn-primary" id="register_app" disabled="disabled">Register app</button><br/>
							</form>
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