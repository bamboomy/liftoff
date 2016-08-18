<?php

include_once("simple_html_dom.php");

$html = file_get_html($_POST['appurl']);

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

foreach($html->find('a') as $element) {
	
	$link = $element->href;
	
	if(startsWith($link, "mailto:")){
		$mail = explode(":",$link)[1];
		
		break;
	}
}

foreach($html->find('span') as $element) {
	
	if($element->itemprop == "name"){
		$name = $element->innertext;
		
		break;
	}
}
	
/* for debugging purposes...
	
if(strpos($maxDownloads, ',') !== false){
	
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
  <script src="../js/register_app.js"></script>
  
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
		<h1>Sorry, <?php echo $name; ?>...</h1> 
	</div>
	<div class="well">
		<p>
		We're sorry, but your app already has 500 downloads, apps with more then 500 downloads outnumber the apps where this site is intended for...<br/>
		<br/>
		<a href="m.php">back.</a><br/>
		</p>
	</div>
</nav>
</body>
</html>

<?	

}else{
	
*/

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
  <script src="../js/register_app.js"></script>
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
      <a class="navbar-brand" href="#">Android Liftoff : submit app</a>
    </div>
  </div>
  
	<div class="jumbotron text-center">
		<h1>Welcome, <?php echo $name; ?>!!!</h1> 
	</div>

	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		
			<h2>This is how your app will look in the to be reviewed list:</h2>
		
			<div class="well">
			
				<div class="row">
					<div class="col-sm-2">
<?php

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
								<h4><?php echo $title." by ".$name; ?></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p><? echo $genre; ?></p>
							</div>
						</div>
						<form action="submitApp.php" method="post">
						<div class="row">
							<div class="col-sm-12">
								<? echo "<input type='hidden' name='appName' value='".$title."' />\n";?>
								<? echo "<input type='hidden' name='url' value='".$_POST['appurl']."' />\n";?>
								<? echo "<input type='hidden' name='mailAddress' value='".$mail."' />\n";?>
								<? echo "<input type='hidden' name='username' value='".$name."' />\n";?>
								<? echo "<input type='hidden' name='src' value='".$src."' />\n";?>
								<? echo "<input type='hidden' name='title' value='".$title."' />\n";?>
								<? echo "<input type='hidden' name='genre' value='".$genre."' />\n";?>
								<? echo "<input type='hidden' name='maxDownloads' value='".$maxDownloads."' />\n";?>
								<input id='sentence' type="text" placeholder="Say in one sentence what your app does." size="100" 
										onkeyup="verifySentence();countChar(this);" name="sentence" /><br/>
								<div id="charNum"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-2">
					</div>
				</div>
			</div>
			
			<div class="well">
				<p>We will send an e-mail to this address to verify that you are really the app owner, 
				<br/>this e-mail address will be used for future communication with you...</p>
				<div class="row">
					<div class="col-sm-10">
						<p><?php echo $mail; ?></p>
					</div>
					<div class="col-sm-2">
						<button type="submit" class="btn btn-primary" id="register_app" disabled="disabled">I agree</button>
					</div>
					</form>
				</div>
				<p>We will also reserve your user name '<? echo $name; ?>' for future registration purposes...</p>
				<p>We don't have a policy (yet) and hope not to need one in the future, this site is inteded to do good, please don't misuse it...</p>
			</div>
			
		</div>
		<div class="col-sm-2"></div>
	</div>
  
</nav>
</body>
</html>
<?

//}

?>
