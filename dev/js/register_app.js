
function verifySentence(){
	
	if($('#sentence').val().length > 0){
		$('#register_app').prop('disabled', false); 
	}else{
		$('#register_app').prop('disabled', 'disabled'); 
	}
}