$(document).ready( function(){
	$('form#post-update').submit(function(event){
		var $form = $(this);
		var $inputs = $form.find('input[type="hidden"],textarea');
		var serializedData = $form.serialize();
		$inputs.prop('disabled', true);
		
		request = $.ajax({
			url: "/",
			type: "post",
			data: serializedData
		});
		
		request.done(function (response, textStatus, jqXHR){
			console.log(
				'The following message returned: '+
				textStatus, response
			);
			$('textarea#statusUpdate').val('');
		});
		
		// Callback handler that will be called on failure
		request.fail(function (jqXHR, textStatus, errorThrown){
			// Log the error to the console
			console.error(
				'The following error occurred: '+
				textStatus, errorThrown
			);
		});
		
		request.always(function () {
			// Reenable the inputs
			$inputs.prop('disabled', false);
		});
		event.preventDefault();
	});
	$('textarea#statusUpdate').focus(function() {
		$(this).animate({
			height: 100
		}, "normal");
	});
	$('textarea#statusUpdate').blur(function() {
		var count = $(this).val().length;
		if( count === 0 ) {
			$(this).animate({
				height: 30
			}, "normal");
		}
	});
});