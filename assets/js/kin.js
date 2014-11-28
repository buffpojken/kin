$(document).ready( function(){
	$('form#post-update').submit(function(event){
		var $form = $(this);
		var $update = $('textarea#statusUpdate').val();
		var $action = $('input[name="action"]').val();
		var $latestUpdate = $('ul#updates > li.update:first-child').data('updateId');
		$('textarea#statusUpdate').prop('disabled', true);
		
		request = $.ajax({
			url: '/',
			type: 'post',
			data: { ajax: '1', action:	$action, statusUpdate: $update, latestUpdate: $latestUpdate }
		});
		
		request.done(function (response, textStatus, jqXHR){
			console.log( 'The following message returned: '+ textStatus + ' / ', response );
			$('textarea#statusUpdate').val('');
			$('textarea#statusUpdate').animate({ height: 30 }, 'normal');
			$(response).hide().prependTo('ul#updates').fadeIn('slow');
		});
		
		request.fail(function (jqXHR, textStatus, errorThrown){
			console.error( 'The following error occurred: '+ textStatus, errorThrown );
		});
		
		request.always(function () {
			$('textarea#statusUpdate').prop('disabled', false);
		});
		event.preventDefault();
	});
	
	$('textarea#statusUpdate').focus(function() {
		$(this).animate({
			height: 100
		}, 'normal');
	});
	
	$('textarea#statusUpdate').blur(function() {
		var count = $(this).val().length;
		if( count === 0 ) {
			$(this).animate({
				height: 30
			}, 'normal');
		}
	});
});

function fetchNewUpdates() {}