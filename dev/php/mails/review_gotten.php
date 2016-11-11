<?

	$subject = 'Good news everyone!!!';

	$mailContent = "Dear ".$_POST['appOwnerName'].",<br/><br/>";

	$mailContent .= "You have gotten a review at <a href='".$liftoffBaseUrl."m.php'>Android Liftoff</a>!!!<br/><br/>";

	$mailContent .= "If you approve this review it will be visible on the app page within milliseconds!!!<br/><br/>";

	$mailContent .= "Furthermore, if this is the first review you approve for this app,<br/>";
	$mailContent .= "the app will be promoted to the <a href='".$liftoffBaseUrl."apps.php'>app list</a>;<br/>";
	$mailContent .= "listed in app discoverer, our sister project, and available through the ADAPI web services...<br/><br/>";

	$mailContent .= "Of course, if the content for some reason would be unsuitable, you can always reject;<br/>";
	$mailContent .= "the review will not be made public then.<br/><br/>";

	$mailContent .= "Thanks for choosing Android Liftoff and keep having fun!!!<br/><br/>";

	$mailContent .= "Sincerely,<br/>The Android Liftoff team.";

?>