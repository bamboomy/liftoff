
function castVote(id){
	
	$.post( "castVote.php?id="+id).done(function( data ) {
		if(data == "done"){
			$("#voteCastModal").modal("show");
		}
	});
}

$('#voteCastModal').on('hidden.bs.modal', function () {
  	window.location.reload();
})