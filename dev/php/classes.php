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

    function echoVotes($owner, $id){
		
		if($this->showVotes){
			if($owner !== $_SESSION['login_user']){
				echo "<img src='../imgz/up_grey.png' width='30' height='30' onmouseover=\"this.src='../imgz/up_green.png';\" ";
				echo "onmouseout=\"this.src='../imgz/up_grey.png';\" onclick='castVote(".$id.")' /><h2 class='closeer'>0</h2>";	
			}else{
				echo "<h2 class='closeer'>0</h2>";	
			}
		}
    }
}


?>