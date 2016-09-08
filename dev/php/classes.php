<?

class ListStrategy{
	
	private $prefix = "";
	private $suffix = "";
	private $showButton = false;
	
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
}


?>