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
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#">Android Liftoff</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#about">The System</a></li>
        <li><a href="#services">The reviews</a></li>
        <li><a href="#contact">Contact</a></li>
<?
	if(isset($_SESSION['login_user'])){
		//whenever changing this code change the code in m.js as well...
?>
		<li class="dropdown" id='login'>
			<? echo "<a data-toggle='dropdown' class='dropdown-toggle' href='#'>".$_SESSION['login_user']; ?>
			<b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
				<li><a href="toBeReviewedList.php">Review an app</a></li>
				<li><a href="#">Submit an app</a></li>
				<li><a href="crib.php">Crib</a></li>
				<li class="divider"></li>
				<li><a href="#" onclick="logout();">Log out</a></li>
			</ul>
		</li>
<?
	}else{
		echo "<li id='login'><a href='#loginModal' data-toggle='modal'>Log in/register</a></li>";
	}
?>
      </ul>
    </div>
  </div>
</nav>
<div class="jumbotron text-center">
	<h1>Android Liftoff</h1> 
	
	<img src="../imgz/android_liftoff.jpg" class="img-circle" alt="Logo" width="304" height="400">

	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<p>
				You've worked long and hard on your very own android app and finally it's ready to be let loose in the wild.<br/>
				<br/>
				You post your app on some forum or try to get in into a website review but allas,<br/>
				<br/>
				you don't seem to be the only one trying...<br/>
				<br/>
				How can you even stand out if no one even downloads your precious work?<br/>
				<br/>
				There seem to be many others and your first potential users seem to find it important that your app has enough downloads already...<br/>
				<br/>
				Seems a bit like a vicious circle to me :-/<br/>
				<br/>
				But...<br/>
				<br/>
				There is hope!!!<br/>
				<br/>
				This site will help you along the way (at least for a mere distance).<br/>
				<br/>
				You can put your app here (for free) and we promise it won't will be removed until you get 500 downloads.<br/>
				<br/>
				(Unless you misbehave of course ;-p)<br/>
				<br/>
				Once you get your 500th download however your app will be removed from this site to make place for others.<br/>
				<br/>
				Sounds like a fair system?<br/>
				<br/>
				Put the (play store) link below to register...<br/>
			</p> 
			
			<div class="row">
				<form class="form-inline" id="subscribeAppForm" action="register_app.php" method="post">
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
						<input type="app" class="form-control subscribe" size="80" 
							placeholder="https://play.google.com/store/apps/details?id=" 
							id="appurl" name="appurl" />
						<button type="submit" class="btn btn-primary" id="register_app" disabled="disabled">Register app</button><br/>
					</div>
					<div class="col-sm-2"></div>
				</form>
			</div>
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

<!-- Modal -->
<div id="loginModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login/register</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-4">username/e-mail:</div>
			<div class="col-sm-5">
				<input type="text" class="pull-right" id="username" />
			</div>
			<div class="col-sm-2"></div>
		</div>
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-4">password:</div>
			<div class="col-sm-5">
				<input type="password" class="pull-right" id="password"/>
			</div>
			<div class="col-sm-2"></div>
		</div>
		<div class="row">
			<div class="col-sm-5"></div>
			<div class="col-sm-5">
				<span class="red pull-right" id="error"></span>
			</div>
			<div class="col-sm-2"></div>
		</div>
		<div class="row">
			<div class="col-sm-5"></div>
			<div class="col-sm-5">
				<button class="btn btn-default pull-right" onclick="login();">Login</button>
			</div>
			<div class="col-sm-2"></div>
		</div>
		<br/>
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-4">email:</div>
			<div class="col-sm-5">
				<input type="text" class="pull-right" />
			</div>
			<div class="col-sm-2"></div>
		</div>
		<div class="row">
			<div class="col-sm-5"></div>
			<div class="col-sm-5">
				<button class="btn btn-default pull-right" type="submit" >Register</button>
			</div>
			<div class="col-sm-2"></div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="welcomeModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Welcome :)</h4>
      </div>
      <div class="modal-body">
		<p id="welcome"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="logoutModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Goodbye!!!</h4>
      </div>
      <div class="modal-body">
		<p>You are logged out.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

</body>
</html>