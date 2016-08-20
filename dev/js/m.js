
$.validator.addMethod("app", function(appUrl, element) {

	return appUrl.match(/https:\/\/play\.google\.com\/store\/apps\/details\?id=[a-z\.]+/);
}, "");

$(document).ready(function () {

    $('#subscribeForm').validate({
        rules: {
			appurl: {
				app: true
			}
        }
    });

    $('#subscribeAppForm input#appurl').on('keyup blur', function () { // fires on every keyup & blur

		//alert($('#subscribeForm').valid());
	
		if($('#subscribeAppForm').valid()){

			$('button#register_app.btn').prop('disabled', false);        // enables button

		}else{
			
			$('button#register_app.btn').prop('disabled', 'disabled');   // disables button
		}
	
    });
});    

function login(){
	$.post( "login.php", { user: $("#username").val(), pw: $("#password").val() } 
	).done(function( data ) {
		if(data !== 'not found'){

			$("#welcome").html("Hellow there, " + data);
			
			$("#loginModal").modal("hide");
			
			addDropDown(data);

			setTimeout(function(){ $("#welcomeModal").modal("show"); }, 1000);

		}else{
			$("#error").html("we couldn't find this user");
		}
	});
}

function logout(){
	$.post( "logout.php").done(function( data ) {
		if(data == "done"){
			$("#logoutModal").modal("show");
			
			removeDropdown();
		}
	});
}

function addDropDown(name){

	var element = $("#login");

	element.addClass("dropdown");
	
	//if you change this you should also change the code in m.php
	
	html = "<a data-toggle='dropdown' class='dropdown-toggle' href='#'>" + name + "\n";
	html += "<b class='caret'></b></a>\n";
	html += "<ul class='dropdown-menu'>\n";
	html += "<li><a href='toBeReviewedList.php'>Review</a></li>\n";
	html += "<li><a href='#'>Submit app</a></li>\n";
	html += "<li><a href='#'>Stats</a></li>\n";
	html += "<li class='divider'></li>\n";
	html += "<li><a href='#' onclick='logout();'>Log out</a></li>\n";
	html += "</ul>\n";

	element.html(html);
}

function removeDropdown(){
	
	var element = $("#login");

	element.removeClass("dropdown");
	
	html = "<a href='#loginModal' data-toggle='modal'>Log in/register</a>";
	
	element.html(html);
}