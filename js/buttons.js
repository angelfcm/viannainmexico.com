
// Posicion de los botones flotantes
	var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0)-100;
	$( "#buttons" ).css( "top", h);
	$( window ).scroll(function() {
		var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0)-100;
		$( "#buttons" ).css( "top", h);
	});
	$( window ).resize(function() {
		var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0)-100;
		$( "#buttons" ).css( "top", h);
	});


	$('.modal').on('shown', function () {
		$('.modal input:text:visible:first').focus();
	});
