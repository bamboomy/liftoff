<?

session_start();

include_once("settings.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {

	echo "not found";
	
	die;
}

$sql = "SELECT id, salt FROM user where name='".addslashes($_POST['user'])."' or email='".addslashes($_POST['user'])."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	
	while($row = $result->fetch_assoc()){
		
		$pwHash = md5(md5(md5($row['salt'])) . md5($_POST['pw']));

		$sql = "SELECT name, id FROM user where pwHash='".$pwHash."' and id='".$row['id']."'";
		
		$result2 = $conn->query($sql);

		if ($result2->num_rows == 1) {
			
			$row2 = $result2->fetch_assoc();
			
			echo $row2['name'];
			
			$_SESSION['login_user']= $row2['name'];
			$_SESSION['id']= $row2['id'];
			
			$sql = "UPDATE user SET last_online=now() WHERE id='".$row2['id']."'";

			if ($conn->query($sql) !== TRUE) {
				
				echo "error";

				//TODO: error handling!!!
			}

			$conn->close();
			
			die;
		}
	}

	echo "not found";
	
}else{

	echo "not found";
	
}

$conn->close();
?>