$(document).ready( function(){
	$('textarea#statusUpdate').focus(function() {
		$(this).animate({
			height: 100
		}, "normal");
	});
	$('textarea#statusUpdate').blur(function() {
		var count = $(this).val().length;
		if( count == 0 ) {
			$(this).animate({
				height: 30
			}, "normal");
		}
	});
});