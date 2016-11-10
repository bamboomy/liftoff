<?

	$subject = 'Password set.';

	$mailContent = "Hey ".$_POST['username'].", <br/><br/>someone, ideally you, set a password on ".$liftoffUrl."...<br/><br/>";

	$mailContent .= "If it was you, you can go to <a href='".$liftoffBaseUrl."toBeReviewedList.php'>the to be reviewed list</a> from now on to review apps from other users.<br/><br/>";

	$mailContent .= "If not, reply to this mail and we'll remove you from our database.<br/><br/>";

	$mailContent .= "Remember: for every review that is approved you get a vote to vote up apps that you like from the <a href='".$liftoffBaseUrl."apps.php'>main site app list</a>.<br/><br/>";

	$mailContent .= "We've created a nice cosy home for ya which is available when you <a href='".$liftoffBaseUrl."m.php'>log in</a>, where you can review your stats and written/recieved reviews...<br/><br/>";

	$mailContent .= "Thanks for choosing Android Liftoff,<br/><br/>we wish you a lot of fun on the site :).<br/><br/>";

	$mailContent .= "Sincerely,<br/>The Android Liftoff team.";

?>