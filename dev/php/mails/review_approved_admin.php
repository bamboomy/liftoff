<?

	$subject = 'Good news everyone!!!';

	$mailContent = "Dear ".$_SESSION['login_user'].",<br/><br/>";

	$mailContent .= "Your review has been approved by the moderator :-D<br/><br/>";

	$mailContent .= "It is now only awaiting owner approval and you get an extra vote!!!<br/><br/>";

	$mailContent .= "Sincerely,<br/>The Android Liftoff team.";

?>