<?

	$subject = 'You\'ve gained a vote!!!';

	$mailContent = "Dear ".$_POST['reviewOwnerName'].",<br/><br/>";

	$mailContent .= "Your review has now also been approved by the app owner;<br/><br/>";

	$mailContent .= "Which means you get a well deserved extra vote to use on the app list page!!!<br/><br/>";

	$mailContent .= "Congratulations and thanks a lot for your review,<br/>";
	$mailContent .= "it's people like you that make Android Liftoff a great place to be!!!<br/><br/>";

	$mailContent .= "Sincerely,<br/>The Android Liftoff team.";

?>