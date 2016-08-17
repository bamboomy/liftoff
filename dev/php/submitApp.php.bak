<?php


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
      <a class="navbar-brand" href="#">Android Liftoff : app submitted</a>
    </div>
  </div>
  
	<div class="jumbotron text-center">
		<h1>One more thing...</h1> 
	</div>

	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		
			<div class="well">

				<p>Good news: a mail has been sent to '<?echo $_POST['mailAddress'];?>' with a link to register the app.<br/>
				<br/>
				Once you verify the app it is registered and will be put on the to be reviewed list.<br/>
				<br/>
				However,<br/>
				<br/>
				Your app will not be visible to normal users until someone else has reviewed your app...<br/>
				<br/>
				Other app developers are in the same situation...<br/>
				<br/>
				If you'd care to review one of their apps, their app becomes visible on the main site for potential users to download it...<br/>
				<br/>
				For the present moment you are known to us as '<?echo $_POST['username'];?>' with '<?echo $_POST['mailAddress'];?>' as mail address.<br/>
				<br/>
				As long as you don't choose a password you will not be able to log in and you can't:<br/>
					<ul>
						<li>Write reviews.</li>
						<li>Vote up apps (you get one vote for every app you reviewed).</li>
						<li>Submit more then one app to the to be reviewed list (and the reviewed list).</li>
					</ul>
				</p>
			
			</div>
			
		</div>
		<div class="col-sm-2"></div>
	</div>
  
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<form action="registerUser" method="post">
				<div class="well">
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-2"><p>Username:</p></div>
						<div class="col-sm-6">
							<?echo "<input type='text' value='".$_POST['username']."'/>";?>
						</div>
						<div class="col-sm-2"></div>
					</div>
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-2"><p>E-mail:</p></div>
						<div class="col-sm-6">
							<?echo "<p>".$_POST['mailAddress']."</p>\n";?>
							<?echo "<input type='hidden' value='".$_POST['mailAddress']."' />";?>
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
				</div>
			</form>
		</div>
		<div class="col-sm-2"></div>
	</div>
</nav>
</body>
</html>