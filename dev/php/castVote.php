<?

session_start();

include_once("settings.php");

//first set mail parameters for possible errors

require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'email-smtp.eu-west-1.amazonaws.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'AKIAIMKPUBJMO74AKAPQ';                 // SMTP username
$mail->Password = 'AmxqPmX2st17Ace/QDU2uffcBMfZ4w2kiAx1yIQZ5JVD';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;    

$mail->setFrom('bamboomy@gmail.com', 'Liftoff staff');

$mail->isHTML(true); 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {

	$mail->Subject = 'error encountered: no database';

	$mail->Body = "couldn't connect to database... -> ".$conn->connect_error;
	
	$mail->addAddress('sander.theetaert@gmail.com', 'asignee'); 
	
	$mail->send();//fire and forget

	echo "error";
	
	die;
} 

$sql = "INSERT INTO appVote (appId, userId) ";
$sql .= "VALUES ('".$_GET['id']."', '".$_SESSION['id']."')";

if ($conn->query($sql) !== TRUE) {

	//TODO: error module
	
	$mail->Subject = "error encountered: couldn't insert vote";

	$mail->Body = "couldn't insert vote... -> ".$conn->error;
	
	$mail->addAddress('sander.theetaert@gmail.com', 'asignee'); 
	
	$mail->send();//fire and forget

	echo "error";

	die;

}

$sql = "UPDATE user SET votes=(";
$sql .= "select votes - 1 from (SELECT * FROM user) AS something where id='".$_SESSION['id']."'";
$sql .= ") WHERE id='".$_SESSION['id']."'";

if ($conn->query($sql) !== TRUE) {

	$mail->Subject = "error encountered: couldn't update user's votes";

	$mail->Body = "couldn't update user's votes... -> ".$conn->error;
	
	$mail->addAddress('sander.theetaert@gmail.com', 'asignee'); 
	
	$mail->send();//fire and forget

	echo "error";

	die;
}


echo "done";

?>