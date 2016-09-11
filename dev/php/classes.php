<?

class ListStrategy{
	
	private $showButtons = false;
	private $showVotes = false;
	private $showReason = false;
	private $showDecisionButtons = false;
	private $showDeleteButton = true;
	private $showEditButton = true;
	private $showWriteNewReviewButton = true;
	private $showAlterButtons = true;
	
	function setShowButtons($showButton){
		
		$this->showButtons = $showButton;
	}

	function setshowDecisionButtons($showDecisionButtons){
		
		$this->showDecisionButtons = $showDecisionButtons;
	}

	function setShowDeleteButton($showDeleteButton){
		
		$this->showDeleteButton = $showDeleteButton;
	}

    function echoButtons($id){

		if($this->showButtons){
			if($this->showWriteNewReviewButton){
?>
											<div class="row">
												<div class="col-sm-2"></div>
												<div class="col-sm-6"></div>
												<div class="col-sm-4">
													<? echo "<a class='btn btn-primary' href='delete_review.php?id=".$id."'>Write new review</a>"; ?>
												</div>
											</div>	
											<br/>
<?
			}
			if($this->showDecisionButtons){
?>
											<div class="row">
												<div class="col-sm-2"></div>
												<div class="col-sm-6"></div>
												<div class="col-sm-4">
													<? echo "<a class='btn btn-primary' href='approve_review.php?id=".$id."'>Approve</a>"; ?>
													<? echo "<a class='btn btn-primary' href='delete_review.php?id=".$id."'>Reject</a>"; ?>
												</div>
											</div>	
											<br/>
<?
			}
			if($this->showAlterButtons){
?>
											<div class="row">
												<div class="col-sm-2"></div>
												<div class="col-sm-6"></div>
												<div class="col-sm-4">
<?
				if($this->showDeleteButton){
					echo "<a class='btn btn-primary' href='delete_review.php?id=".$id."'>Delete</a>&nbsp;"; 
				}
				if($this->showEditButton){
					echo "<a class='btn btn-primary' href='delete_review.php?id=".$id."'>Edit</a>"; 
				}
?>
												</div>
											</div>	
<?
			}
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

	function setShowReason($showReason){
		
		$this->showReason = $showReason;
	}

    function echoReason($reason){
		
		if($this->showReason){
			echo "<span class='red big'>Rejected...</span><br/>Reason: ".$reason;
		}
    }

}


?>