<?

	$subject = 'App registered';

	$mailContent = "Hey ".$_POST['username'].", <br/><br/>someone, ideally you, has registerd the app '".$_POST['appName']."' on ".$liftoffUrl."...<br/><br/>";

	$mailContent .= "If it was you, you can click <a href='".$liftoffBaseUrl."mailRegistration.php?hash=".$hash."&id=".$ownerId."'>this link</a> to register your app.<br/><br/>";

	$mailContent .= "If you weren't expecting this e-mail you can safely ignore it.<br/><br/>";

	$mailContent .= "Thanks for choosing Android Liftoff,<br/><br/>we wish you a nice day and all the best with your app :).<br/><br/>";

	$mailContent .= "Sincerely,<br/>The Android Liftoff team.";

?>