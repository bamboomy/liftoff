
$.validator.addMethod("app", function(appUrl, element) {

	return appUrl.match(/https:\/\/play\.google\.com\/store\/apps\/details\?id=[a-z\.]+/);
}, "This doesn't seem like a good app id...");

function validatePw(pwElement){

	$("#pwoutput").css("color", "red");

	if(pwElement.value.length<6){
		$("#pwoutput").text("Not 6 long...");
		return;
	}else if(pwElement.value.length>20){
		$("#pwoutput").text("That's to much...");
		return;
	}else{
		if(!pwElement.value.match(/[a-z]/)){
			$("#pwoutput").text("Need a lower case character...");
			return;
		}
		if(!pwElement.value.match(/[A-Z]/)){
			$("#pwoutput").text("Need a Upper case character...");
			return;
		}
		if(!pwElement.value.match(/[0-9]/)){
			$("#pwoutput").text("Need a number...");
			return;
		}
	}
	
	$("#pwoutput").text("excellent!!!");
	$("#pwoutput").css("color", "green");
}

function verifyEquality(){
	
	if($("#pw1").val() !== $("#pw2").val()){
		$("#pwoutput2").text("Passwords must match...");
	}else{
		$("#pwoutput2").text("");
	}
}