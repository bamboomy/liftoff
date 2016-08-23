
function verifyLength(){
	
	textElement = $("#reviewText");
	
	count = countWords(textElement);
	
	min = 100;
	
	max = 300;
	
	$("#feedback").css("color","green");
	
	if(count < min){
		
		$("#feedback").html("We expect at least " + min + " words from a decent review, " 
			+ (min - count) + " words to go...");
			
		$("#submitMessage").html("");
		
	}else if(count > max){
		
		chop(textElement);
		
		$("#feedback").html("That's to much...");
		$("#feedback").css("color","red");
		
	}else{
		
		$("#feedback").html("You can keep typing, but we don't think that people will read anything longer then " + max + " words -> " 
			+ "we give you another " + (max - count) + " words...");
			
		$("#submitMessage").html("give at least one pro (positive point) and one con (negative point)");
	}
	
	updateSubmitMessage();
		
}

function countWords(element){
	
	var myarr = element.val().split(" ");
	
	return myarr.length;
}

function chop(element){
	
	var myarr = element.val().split(" ");
	
	var result = "";
	
	for(i=0; i<300; i++){
		
		result += myarr[i] + " ";
		
	}
	
	element.val(result);
}

function updateSubmitMessage(){

	count = countWords($("#reviewText"));	

	if(min < count && count < max 
		&& $("#pro0").val().length > 0 
		&& $("#con0").val().length > 0){
		
		$("#submitReview").prop('disabled', false);
		
		$("#submitMessage").html("all goooood :)");
		
	}else{
		
		$("#submitReview").prop('disabled', 'disabled');
		
		if(min > count){
			
			$("#submitMessage").html("review is not long enough");
			
		}else if(count > max){
			
			$("#submitMessage").html("review is to long");
			
		}else if($("#pro0").val().length == 0 ){
			
			$("#submitMessage").html("give at least a positive point (in the first box)");

		}else if($("#con0").val().length == 0){
		
			$("#submitMessage").html("give at least a negative point (in the first box)");
			
		}
		
	}
	
}