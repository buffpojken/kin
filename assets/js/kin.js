$(document).ready( function(){
	$('textarea#statusUpdate').focus(function() {
		$(this).animate({
			height: 100
		}, "normal");
	}).blur(function() {
		$(this).animate({
			height: 51
		}, "normal");
	});
});