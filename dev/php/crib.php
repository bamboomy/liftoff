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

$strategy = new ListStrategy();

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
<?

include "nav.php";

?>
  
	<div class="container-fluid androidGreen">
		<div class="jumbotron text-center">
			<h1>Welcome home, <? echo $_SESSION['login_user']; ?> :)</h1> 
			
			<img src="../imgz/crib.jpg" class="img-circle" alt="Logo" width="400" height="300">
		</div>
	</div>

	<div class="container-fluid androidGreen">
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
			
<?							

$sql = "SELECT  `totalVotes`, votes, tbrlp FROM  `user` WHERE  `id` ='".$_SESSION['id']."'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>
				<div class="well">
					<h3>Loot</h3>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<h4>To be reviewed list points: <? echo $row['tbrlp']; ?></h4>
						</div>
						<div class="col-sm-1"></div>
					</div>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
						<p>
							These points are added to all of your apps on the to be reviewed list.<br/>
							The more points, the higher (all of) your apps are shown.<br/>
						</p>
						</div>
						<div class="col-sm-1"></div>
					</div>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<h4>Votes: <? echo $row['totalVotes'] ?></h4>
							<p>
								Your first vote is free;<br/>
								after that you earn a vote for <u>every</u> <u><b>published</b></u> review.<br/>
								You can cast votes on the <a href="apps.php">app page</a>.<br/>
								You can't vote for your own apps.<br/>
							</p>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<h4>Cast: <? echo intval($row['totalVotes'])-intval($row['votes']) ?></h4>
								</div>
								<div class="col-sm-1"></div>
							</div>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<h4>Remaining: <? echo $row['votes'] ?></h4>
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
				
					<h3>Reviews</h3>
					
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
<?							

$sql = "SELECT  `app_id` FROM  `review` WHERE  `ownerId` ='".$_SESSION['id']."' and status!='deleted'";
$result = $conn->query($sql);

?>
							<h4>Written: <? echo $result->num_rows; ?></h4>
<?
if($result->num_rows == 0){
?>
							
							<p>
							We encourage you to <a href="toBeReviewedList.php">write reviews</a>, for every review you wrote, approved by at least a moderator;<br/>
							<b>all of your apps</b> get ranked higher in the to be reviewed list;<br/>
							(and are more likely to be chosen to be reviewed as well...)<br/>
							</p>
<?
}else{

	$sql = "SELECT `id`, `app_id`";
	$sql .= " FROM `review` WHERE  `ownerId` ='".$_SESSION['id']."' and status='need_admin' order by app_id";
	$result = $conn->query($sql);

?>	
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<h4>Yet to be approved: <? echo $result->num_rows; ?></h4>
<?

$infix = "need_admin";

$strategy->setSql3("SELECT `id`, `app_id`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`, ownerId, rejectReason FROM `review` WHERE app_id=", 
	" and `ownerId`=".$_SESSION['id']." and status='need_admin'");
$strategy->setShowButtons(true);
$strategy->setShowEditButton(true);
$strategy->setShowDeleteButton(true);
$strategy->setShowAlterButtons(true);

include 'reviewList.php';

$strategy->setSql3("","");
$strategy->setShowButtons(false);
$strategy->setShowEditButton(false);
$strategy->setShowDeleteButton(false);
$strategy->setShowAlterButtons(false);
	
	$sql = "SELECT `id`, `app_id`";
	$sql .= " FROM `review` WHERE  `ownerId` ='".$_SESSION['id']."' and status='need_owner' order by app_id";
	$result = $conn->query($sql);

?>									
								</div>
								<div class="col-sm-1"></div>
							</div>
							<br/>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<h4>Approved by moderator: <? echo $result->num_rows; ?></h4>
									<p>
										This number is accounted for in the order of the to be reviewed list.<br/>
										<br/>
<?
	if($result->num_rows > 0){
?>										
										<a class='btn btn-primary' data-toggle='collapse' href='#info'>more info</a>
										
										<div class='collapse well' id='info'>
											This review(s) is/are now just waiting on approval of the app owner,<br/>
											<br/>
											A mail has been sent to him/her<br/>
											<br/>
											It is now worth one extra point in the to be reviewed list;<br/>
											if (s)he'd approve, you get another extra point for your apps in the to be reviewed list :D<br/>
											<br/>
											+ -> you'd get a vote for which you can use to upvote this, or other apps on the app list.<br/>
											(not your own)<br/>
											<br/>
											You'll be notified about approval/rejection via mail.<br/>
											<br/>
											If you'd edit this review it would need moderator approval again to get to this state.<br/>
											<br/>
											You can also delete this review, it will no longer be accounted for in the to be reviewed list.<br/>
											<br/>
											Deleting is no longer possible once the review is accepted.<br/>			
											<br/>
											Thanks for your review and thanks for using Android Liftoff :)<br/>
										</div>
<?
	}
?>										
									</p>
<?

$infix = "need_owner";

$strategy->setSql3("SELECT `id`, `app_id`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`, ownerId, rejectReason FROM `review` WHERE app_id=", 
	" and `ownerId`=".$_SESSION['id']." and status='need_owner'");
$strategy->setShowButtons(true);
$strategy->setShowEditButton(true);
$strategy->setShowDeleteButton(true);
$strategy->setShowAlterButtons(true);

include 'reviewList.php';

$strategy->setSql3("", "");		
$strategy->setShowButtons(false);
$strategy->setShowEditButton(false);
$strategy->setShowDeleteButton(false);
$strategy->setShowAlterButtons(false);

?>						
								</div>
								<div class="col-sm-1"></div>
							</div>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
<?							

	$sql = "SELECT  `app_id` FROM  `review` WHERE  `ownerId` ='".$_SESSION['id']."' and status='approved'";
	$result = $conn->query($sql);
?>
									<h4>Published: <? echo $result->num_rows; ?></h4>
<?							
	$infix = "published";

	$strategy->setSql3("SELECT `id`, `app_id`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`, ownerId FROM `review` WHERE app_id=", " and status='approved'");

	include 'reviewList.php';	

	$strategy->setSql3("","");
?>	
								</div>
								<div class="col-sm-1"></div>
							</div>
							<br/>
<?
	$sql = "SELECT  `app_id` FROM  `review` WHERE  `ownerId` ='".$_SESSION['id']."' and (status='reject_mod' or status='reject_own')";
	$result = $conn->query($sql);

	if($result->num_rows > 0){
?>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<h4>Rejected: <? echo $result->num_rows; ?></h4>
<?
		$sql = "SELECT  `id`, `app_id` FROM  `review` WHERE  `ownerId` ='".$_SESSION['id']."' and status='reject_mod'";
		$result = $conn->query($sql);
		
		$strategy->setShowReason(true);
		$strategy->setShowButtons(true);
		$strategy->setShowWriteNewReviewButton(true);
		$strategy->setShowAlterButtons(true);
		$strategy->setShowEditButton(true);
		$strategy->setShowDeleteButton(true);
		$strategy->setSql3("SELECT `id`, `app_id`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`, ownerId, rejectReason FROM `review` WHERE app_id=", 
			" and `ownerId`=".$_SESSION['id']." and status='reject_mod'");//TODO: ownerid of review != ownerid of app!!!
?>	
									<div class="row">
										<div class="col-sm-1"></div>
										<div class="col-sm-10">
											<h4>By moderator: <? echo $result->num_rows; ?></h4>
										</div>
										<div class="col-sm-1"></div>
									</div>
<?
		include 'reviewList.php';		

		$sql = "SELECT  `app_id` FROM  `review` WHERE  `ownerId` ='".$_SESSION['id']."' and status='reject_own'";
		$result = $conn->query($sql);
?>	
									<div class="row">
										<div class="col-sm-1"></div>
										<div class="col-sm-10">
											<h4>By app owner: <? echo $result->num_rows; ?></h4>
										</div>
										<div class="col-sm-1"></div>
									</div>
<?	
		$infix = "rejected";

		$strategy->setSql3("SELECT `id`, `app_id`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`, ownerId, rejectReason FROM `review` WHERE app_id=", 
			" and `ownerId`=".$_SESSION['id']." and status='reject_own'");

		include 'reviewList.php';
?>		
								</div>
								<div class="col-sm-1"></div>
							</div>
<?	
		$strategy->setShowReason(false);
		$strategy->setShowButtons(false);
		$strategy->setShowWriteNewReviewButton(false);
		$strategy->setShowAlterButtons(false);
		$strategy->setShowEditButton(false);
		$strategy->setShowDeleteButton(false);
		$strategy->setSql3("","");
	}
}
?>
						</div>
						<div class="col-sm-1"></div>
					</div>
<?
	$sql = "SELECT * FROM `review` WHERE app_id in (";
		$sql .= "select id from app where reviewCandidate_id in (";
			$sql .= "select id from reviewCandidate where ownerId = '".$_SESSION['id']."'";
			$sql .= ")) and status<>'need_admin' and status!='deleted'";
			
	$result = $conn->query($sql);		
?>					
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<h4>Recieved: <? echo $result->num_rows; ?></h4>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
<?
	$sql = "SELECT `id`, `app_id` FROM `review` WHERE app_id in (";
		$sql .= "select id from app where reviewCandidate_id in (";
			$sql .= "select id from reviewCandidate where ownerId = '".$_SESSION['id']."'";
			$sql .= ")) and status='need_owner' order by app_id";
	$result = $conn->query($sql);
?>
									<h4>To be approved: <? echo $result->num_rows; ?></h4>
<?
	if($result->num_rows > 0){
		$approve = true;
		
		$strategy->setShowButtons(true);
		$strategy->setshowDecisionButtons(true);
		$strategy->setSql3("SELECT `id`, `app_id`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`, ownerId FROM `review` WHERE app_id=", " and status='need_owner'");
		
		$infix = "need_owner";

		include 'reviewList.php';		
		
		$strategy->setShowButtons(false);
		$strategy->setshowDecisionButtons(false);
		$strategy->setSql3("","");
	}
?>								
								</div>
								<div class="col-sm-1"></div>
							</div>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
<?
	$sql = "SELECT `id`, `app_id` FROM `review` WHERE app_id in (";
		$sql .= "select id from app where reviewCandidate_id in (";
			$sql .= "select id from reviewCandidate where ownerId = '".$_SESSION['id']."'";
			$sql .= ")) and status='approved' order by app_id";
	$result = $conn->query($sql);
?>
									<h4>Published: <? echo $result->num_rows; ?></h4>
<?
	if($result->num_rows > 0){
		$approve = false;
		$published = true;

		$strategy->setSql3("SELECT `id`, `app_id`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`, ownerId FROM `review` WHERE app_id=", " and status='approved'");
		
		$infix = "published";

		include 'reviewList.php';		

		$strategy->setSql3("", "");
	}
?>								
								</div>
								<div class="col-sm-1"></div>
							</div>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
<?
	$sql = "SELECT `id`, `app_id` FROM `review` WHERE app_id in (";
		$sql .= "select id from app where reviewCandidate_id in (";
			$sql .= "select id from reviewCandidate where ownerId = '".$_SESSION['id']."'";
			$sql .= ")) and status='reject_own' order by app_id";
	$result = $conn->query($sql);

?>								
									<h4>Rejected: <? echo $result->num_rows; ?></h4>
<?
	if($result->num_rows > 0){

		$strategy->setSql3("SELECT `id`, `app_id`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`, ownerId FROM `review` WHERE app_id=", " and status='reject_own'");
	
		$infix = "reject_own";

		include 'reviewList.php';		

		$strategy->setSql3("", "");
	}
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
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
			
				<div class="well">
				
					<h3>Apps</h3>
<?

include 'tbrlpAlgo.php';

$sql = "SELECT id, title, src, status FROM reviewCandidate where ownerId='".$_SESSION['id']."' and id not in (";
	$sql .= "SELECT reviewCandidate_id from app where status='approved')";
$result = $conn->query($sql);

?>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<h4>To be reviewed (yet): <? echo $result->num_rows; ?></h4>
							<p>
								Your apps remain in the 'to be reviewed' status until you approve a review for this app.<br/>
							</p>
							<br/>
<?	

if($result->num_rows > 0){

	while($row = $result->fetch_assoc()) {
?>		
							<div class="row well">
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
			if(isset($appList)){

				$counter = 1;

				foreach($appList as $app){

					if($app['id']==$row['id']){
						$position = $counter;
					}

					$counter++;
				}

				echo "<h4>position: ".$position."</h4>";
			}
		}
?>
										
										</div>
									</div>
								</div>
								<div class="col-sm-2"></div>
							</div>
							<br/>
<?		
	}
?>
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
<?

$sql = "SELECT id, title, src, status FROM reviewCandidate where ownerId='".$_SESSION['id']."' and id in (";
	$sql .= "SELECT reviewCandidate_id from app where status='approved')";
$result = $conn->query($sql);

?>
							<h4>Published: <? echo $result->num_rows; ?></h4>
							<?	

if($result->num_rows > 0){

	while($row = $result->fetch_assoc()) {
?>		
							<div class="row well">
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
											<h4><? echo "number of reviews: "; ?> </h4>
											<h4><? echo "votes: "; ?> </h4>
										</div>
									</div>
								</div>
								<div class="col-sm-2"></div>
							</div>
							<br/>
<?		
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
							<h4>Submit a fresh app:</h4>
							<br/>
							<form class="form-inline" id="subscribeAppForm" action="register_app.php" method="post">
								<input type="app" class="form-control subscribe" size="80" 
									placeholder="https://play.google.com/store/apps/details?id=" 
									id="appurl" name="appurl" />
								<button type="submit" class="btn btn-primary" id="register_app" disabled="disabled">Launch!!!</button><br/>
							</form>
						</div>
						<div class="col-sm-1"></div>
					</div>
				</div>
			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>

<div id="rejectModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
		<div class="modal-content">
			<form action="reject_review.php" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Reject</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-2">Reason:</div>
						<div class="col-sm-7">
							<input type="text" name="reason" id="reason" />
						</div>
						<div class="col-sm-2">
							<input type='hidden' name="id" id='rejectId' value='' />
							<button class="btn btn-default pull-right" type="submit">Submit</button>
						</div>
					</div>
				</div>
			</form>
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