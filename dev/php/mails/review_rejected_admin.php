<?

	$subject = 'Review rejected...';

	$mailContent = "Dear ".$_POST['reviewOwnerName'].",<br/><br/>";

	$mailContent .= "Unfortunately your review has been rejected by the admin.<br/><br/>";

	$mailContent .= "With following reason: '".$_POST['reason']."' <br/><br/>";

	$mailContent .= "You can still <a href='".$liftoffBaseUrl."toBeReviewedList.php'>write a new review</a> if you like,<br/><br/>";

	$mailContent .= "Sincerely,<br/>The Android Liftoff team.";

?>