<?

	$subject = 'That\'s a pitty...';

	$mailContent = "Dear ".$reviewOwnerName.",<br/><br/>";

	$mailContent .= "Your review has been rejected by the app owner for following reason:<br/>";
	$mailContent .= "'".$_POST['reason']."'...<br/><br/>";

	$mailContent .= "Your review did comply with the site guidelines,<br/><br/>";
	$mailContent .= "but the app owner couldn't find itself in your review...<br/><br/>";

	$mailContent .= "You didn't gain a vote, but you did gain a to be reviewed point,<br/>";
	$mailContent .= "placing your app(s) higher on the to be reviewed list.<br/><br/>";

	$mailContent .= "You could try to <a href='".$liftoffBaseUrl."crib.php'>adapt your review</a><br/>";
	$mailContent .= "or <a href='".$liftoffBaseUrl."toBeReviewedList.php'>write another review for another app</a>.<br/><br/>";

	$mailContent .= "Sincerely,<br/>The Android Liftoff team.";

?>