
$.validator.addMethod("app", function(appUrl, element) {

	//validates postalcode.
	return appUrl.match(/https:\/\/play\.google\.com\/store\/apps\/details\?id=[a-z\.]+/);
}, "This doesn't seem like a good app id...");

$(document).ready(function () {

    $('#subscribeForm').validate({
        rules: {
			appurl: {
				app: true
			}
        }
    });

    $('#subscribeForm input#appurl').on('keyup blur', function () { // fires on every keyup & blur

		if($('#subscribeForm').valid()){

			$('button#subscribe.btn').prop('disabled', false);        // enables button
			//$("#inputEmail").prop('disabled', 'disabled');   // disables email
		}else{
			
			$('button#subscribe.btn').prop('disabled', 'disabled');   // disables button
			//$("#inputEmail").prop('disabled', false);   // disables email
		}
	
    });
});    

