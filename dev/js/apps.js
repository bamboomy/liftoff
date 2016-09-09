
function castVote(id){
	
	$.post( "castVote.php?id="+id).done(function( data ) {
		if(data == "done"){
			$("#voteCastModal").modal("show");
		}
	});
}