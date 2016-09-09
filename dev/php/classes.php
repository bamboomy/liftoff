<?

class ListStrategy{
	
	private $prefix = "";
	private $suffix = "";
	private $showButton = false;
	private $showVotes = false;
	
	function setPrefix($prefix){
		
		$this->prefix = $prefix;
	}
	
	function setSuffix($suffix){
		
		$this->suffix = $suffix;
	}
	
	function setShowButton($showButton){
		
		$this->showButton = $showButton;
	}

    function echoButtons($id){
		
		if($this->showButton){
			echo $this->prefix.$id.$this->suffix; 	
		}
    }

	function setShowVotes($showVotes){
		
		$this->showVotes = $showVotes;
	}
	
	function setConn($conn){
		
		$this->conn = $conn;
	}

    function echoVotes($owner, $id, $votes){
		
		if($this->showVotes){
			
			$sql9 = "SELECT `id` FROM `appVote` WHERE appId = '".$id."' and userId='".$_SESSION['id']."'";
			
			//echo $sql9;

			$result9 = $this->conn->query($sql9);
			
			if($result9->num_rows != 0){
				echo "<img src='../imgz/up_orange.png' width='30' height='30' /><h2 class='closeer'>".$votes."</h2>";	
			}else{
				if($owner !== $_SESSION['login_user']){
					echo "<img src='../imgz/up_grey.png' width='30' height='30' onmouseover=\"this.src='../imgz/up_green.png';\" ";
					echo "onmouseout=\"this.src='../imgz/up_grey.png';\" onclick='castVote(".$id.")' /><h2 class='closeer'>".$votes."</h2>";	
				}else{
					echo "<h2 class='closeer'>".$votes."</h2>";	
				}
			}
		}
    }
}


?>