<?php

session_start();

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
  <script src="../js/m.js"></script>

  <style>
		.jumbotron { 
			background-color: #a4ca39; /* Orange */
			color: #000000;
		}
		
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

		.navbar li a, .navbar .navbar-brand {
			color: #000 !important;
		}

		.navbar-nav li a:hover, .navbar-nav li.active a {
			color: #a4ca39 !important;
			background-color: #000 !important;
		}

		.navbar-default .navbar-toggle {
			border-color: transparent;
			color: #000 !important;
		}
		
		img {
			padding: 50px 25px;
		}
		
		.modal-dialog {
			position: absolute;
			top: 50px;
			right: 100px;
			bottom: 0;
			left: 0;
			z-index: 10040;
			overflow: auto;
			overflow-y: auto;
		}
		
		button{
			
			margin: 10px;
			
		}
		
		.red{
			color: red;
		}
		
	</style>
</head>
<body>
<?

include "nav.php";

?>
<div class="jumbotron text-center">
	<h1>Android Liftoff</h1> 
	
	<img src="../imgz/android_liftoff.jpg" class="img-circle" alt="Logo" width="304" height="400">

	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<p>
				Android Liftoff is a site where great apps with little downloads are gathered and reviewed.<br/>
				<br/>
				Any app developer can submit his/her app here.<br/>
				<br/>
				However, it needs to be reviewed first to be visible to you (the site visitor).<br/>
				<br/>
				Furthermore;<br/>
				<br/>
				The app list is sorted on votes.<br/>
				<br/>
				App owners can vote (only for other apps then their own)<br/>
				votes are made expensive so app owners are not going to vote for any app.<br/>
				<br/>
				Also, when apps reach 500 downloads they are removed from this site<br/>
				(to make place for other app developers' apps).<br/>
				<br/>
				This way we find the equilibrium between underappreciated good apps<br/>
				and<br/>
				apps that are in the process of becoming rising stars.<br/>
				<br/>
				This is a nice site for disovering various apps who are yet to make it big.<br/>
				<br/>
				The apps can be found <a href='apps.php'>here</a>.<br/>
				<br/>
				As app developer you can register your app in the upper right corner.<br/>
				<br/>
				Enjoy the site :)<br/>
				<br/>
				The Android Liftoff team.<br/>
			</p> 
		</div>
		<div class="col-sm-2"></div>
	</div>
</div>
<div class="container-fluid bg-grey">
  <h2 class="text-center">CONTACT</h2>
  <div class="row">
	<div class="col-sm-1"></div>
    <div class="col-sm-10">
      <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br>
      <div class="row">
        <div class="col-sm-5 form-group">
          <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
        </div>
        <div class="col-sm-5 form-group">
          <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
        </div>
        <div class="col-sm-2 form-group">
          <button class="btn btn-default pull-right" type="submit">Send</button>
        </div>
      </div> 
    </div>
	<div class="col-sm-1"></div>
  </div>
</div>
</body>
</html>