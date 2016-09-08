<?

class ListStrategy{
	
	private $prefix = "";
	private $suffix = "";
	
	function setPrefix($prefixIn){
		
		$this->prefix = $prefixIn;
	}
	
	function setSuffix($suffixIn){
		
		$this->suffix = $suffixIn;
	}

    function echoButtons($id){
		
        echo $this->prefix.$id.$this->suffix; 
    }
}


?>