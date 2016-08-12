<!DOCTYPE html>
<html lang="en">
<head>
  <title>Android Liftoff</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
      </button>
      <a class="navbar-brand" href="#">Android Liftoff</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#about">The System</a></li>
        <li><a href="#services">The reviews</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="jumbotron text-center">
	<h1>Android Liftoff</h1> 

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
				This site will help you along the way (at least for some distance).<br/>
				<br/>
				You can put your app here (for free) and we promise it won't will be removed until you get 500 downloads.<br/>
				<br/>
				Once you get your 500th download however your app will be removed from this site to make place for others.<br/>
				<br/>
				Sounds like a fair system?<br/>
				<br/>
				Put the (play store) link below to register...<br/>
			</p> 
			<form class="form-inline">
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-5">
							I'm an app developer and want to submit my app:
						</div>
						<div class="col-sm-5">
							<input type="app" class="form-control" size="50" placeholder="https://play.google.com/store/apps/details?id=">
						</div>
						<div class="col-sm-1"></div>
					</div>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-5">
							I like to review new work from promising app developers:
						</div>
						<div class="col-sm-5">
							<input type="email" class="form-control" size="50" placeholder="someone@somewhere.com"><br/>
						</div>
						<div class="col-sm-1"></div>
					</div>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<button type="button" class="btn btn-danger">Subscribe</button><br/>
						</div>
						<div class="col-sm-1"></div>
					</div>
			</form>
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