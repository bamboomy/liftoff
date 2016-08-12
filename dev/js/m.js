
$.validator.addMethod("app", function(appUrl, element) {

	//validates postalcode.
	return this.optional(element) || appUrl.match(/https:\/\/play\.google\.com\/store\/apps\/details\?id=[a-z\.]+/);
}, "Please specify a valid zip code");


$(document).ready(function () {

    $('#subscribeForm').validate({
        rules: {
            inputEmail: {
                email: true
            }
        }
    });

    $('#subscribeForm input').on('keyup blur', function () { // fires on every keyup & blur
        if ($('#subscribeForm').valid()) {                   // checks form for validity
            $('button#subscribe.btn').prop('disabled', false);        // enables button
        } else {
            $('button#subscribe.btn').prop('disabled', 'disabled');   // disables button
        }
    });

});    

