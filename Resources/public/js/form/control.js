function controlForm ( form, callback ) {
	callback(form);
	
	form.on('submit', function ( e ) {
		e.preventDefault();
		
		var data = $(this).serialize();
		
		$.ajax({
			url:		$(this).attr('action'),
			type:		'POST',
			data:		data,
			success: 	processResponse,
			error: 		handleAjaxError
		});
	});
	
	function processResponse ( response, status ) {
		response = $(response);
		form.replaceWith(response);
		
		var newForm = response.filter('form');
		newForm.each(function () {
			controlForm($(this), callback);
		});
	}
}
