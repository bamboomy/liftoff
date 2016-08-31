
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

		if($('#subscribeAppForm').valid()){

			$('button#register_app.btn').prop('disabled', false);        // enables button

		}else{
			
			$('button#register_app.btn').prop('disabled', 'disabled');   // disables button
		}
	
    });
});    