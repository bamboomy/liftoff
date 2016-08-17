
function verifySentence(){
	
	if($('#sentence').val().length > 0){
		$('#register_app').prop('disabled', false); 
	}else{
		$('#register_app').prop('disabled', 'disabled'); 
	}
	
	
}

function countChar(val) {
	var len = val.value.length;
	
	var maxLenght = 100;
	
	if (len > maxLenght) {
		val.value = val.value.substring(0, maxLenght);
	} else {
		$('#charNum').text(maxLenght - len);
		if(maxLenght - len < 5){
			$('#charNum').css( "color", "red" );
		} else if(maxLenght - len < 10){
			$('#charNum').css( "color", "orange" );
		}else{
			$('#charNum').css( "color", "green" );
		}
	}
};

$( document ).ready(function() {
	$( "#sentence" ).focus();
});