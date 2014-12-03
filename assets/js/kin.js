$(document).ready( function(){
	$('select.chosen-select').chosen({
		disable_search_threshold: 10,
		no_results_text: "Oops, nothing found!",
		width: "100%",
		max_selected_options: 1
	});
	
	$('a.likeUpdate').on('click', function() {
		var $text = $(this).text();
		var $updateID = $(this).data('id');
		var $identifier = $(this).attr('id');
		if( $text === 'Like' ) {
			request = $.ajax({
				url: '/index.php',
				type: 'post',
				data: { ajax: '1', action:	'likeUpdate', updateID: $updateID }
			});
			
			request.done(function (response, textStatus){
				//console.log( 'The following message returned: '+ textStatus + ' / ', response );
				$('a.likeUpdate#'+$identifier).text('Unlike');
				$('a.likeUpdate#'+$identifier).siblings('span.like-description').text(' · You like this');
			});
			
			request.fail(function (jqXHR, textStatus, errorThrown){
				console.log( 'The following error occurred: '+ textStatus, errorThrown );
			});
		} else if( $text === 'Unlike' ) {
			request = $.ajax({
				url: '/index.php',
				type: 'post',
				data: { ajax: '1', action:	'unlikeUpdate', updateID: $updateID }
			});
			
			request.done(function (response, textStatus, jqXHR){
				console.log( 'The following message returned: '+ textStatus + ' / ', response );
				$('a.likeUpdate#'+$identifier).text('Like');
				$('a.likeUpdate#'+$identifier).siblings('span.like-description').empty();
			});
			
			request.fail(function (jqXHR, textStatus, errorThrown){
				console.log( 'The following error occurred: '+ textStatus, errorThrown );
			});
		}
		event.preventDefault();
	});
	
	$('form#post-update').submit(function(event){
		var $form = $(this);
		var $update = $('textarea#statusUpdate').val();
		var $action = $('input[name="action"]').val();
		var $latestUpdate = $('ul#updates > li.update:first-child').data('updateId');
		if( $latestUpdate === null ) {
			$latestUpdate = 0;
		}
		$('textarea#statusUpdate').prop('disabled', true);
		
		request = $.ajax({
			url: '/index.php',
			type: 'post',
			data: { ajax: '1', action:	$action, statusUpdate: $update, latestUpdate: $latestUpdate }
		});
		
		request.done(function (response, textStatus, jqXHR){
			//console.log( 'The following message returned: '+ textStatus + ' / ', response );
			$('textarea#statusUpdate').val('');
			$('textarea#statusUpdate').animate({ height: 30 }, 'normal');
			$('ul.updates').hide().prepend(response).fadeIn('slow');
		});
		
		request.fail(function (jqXHR, textStatus, errorThrown){
			console.log( 'The following error occurred: '+ textStatus, errorThrown );
		});
		
		request.always(function () {
			$('textarea#statusUpdate').prop('disabled', false);
		});
		event.preventDefault();
	});
	
	$('form#post-comment').submit(function(event){
		var $form = $(this);
		var $comment = $('input#comment_message').val();
		var $updateID = $('input[name="updateID"]').val();
		var $action = $('input[name="action"]').val();
		var $latestComment = $('ul#updates > li.comment:last-child').data('updateId');
		if( $latestComment === null ) {
			$latestComment = 0;
		}
		$('input#comment_message').prop('disabled', true);
		
		request = $.ajax({
			url: '/index.php',
			type: 'post',
			data: { ajax: '1', action:	$action, updateID: $updateID, comment_message: $comment, latestComment: $latestComment }
		});
		
		request.done(function (response, textStatus, jqXHR){
			//console.log( 'The following message returned: '+ textStatus + ' / ', response );
			$('input#comment_message').val('');
			$('ul.updates').hide().append(response).fadeIn('slow');
		});
		
		request.fail(function (jqXHR, textStatus, errorThrown){
			console.log( 'The following error occurred: '+ textStatus, errorThrown );
		});
		
		request.always(function () {
			$('input#comment_message').prop('disabled', false);
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

if(("standalone" in window.navigator) && window.navigator.standalone){
	$( document ).on(
		'click',
		'a',
		function( event ){
			// Stop the default behavior of the browser, which
			// is to change the URL of the page.
			event.preventDefault();
			// Manually change the location of the page to stay in
			// "Standalone" mode and change the URL at the same time.
			location.href = $( event.target ).attr( 'href' );
		}
	);
}