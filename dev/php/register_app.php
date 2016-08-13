<?php

include_once("simple_html_dom.php");

$html = file_get_html($_POST['appurl']);

$title = $html->find('div.id-app-title',0)->innertext;

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
      <a class="navbar-brand" href="#">Android Liftoff : submit app</a>
    </div>
  </div>
  
	<div class="jumbotron text-center">
		<h1>Welcome, <?php echo $title; ?>!!!</h1> 
	</div>

	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		
			<h2>This is how your app will look in the review list:</h2>
		
			<div class="well">
			
				<div class="row">
					<div class="col-sm-2">
	<?php

foreach($html->find('img.cover-image') as $element) {
	
	echo "<img src='".$element->src."'/ width='100' height='100'>";

	break;
}

?>					
					</div>
					<div class="col-sm-8">
						<p>MemDicez</p>
					</div>
					<div class="col-sm-2"></div>
				</div>
			</div>
			
		</div>
		<div class="col-sm-2"></div>
	</div>
  
</nav>
</body>
</html>