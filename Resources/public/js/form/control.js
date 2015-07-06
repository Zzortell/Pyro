function controlForm ( form, callback ) {
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
		newForm = $(response).filterBy('name', form.attr('name'));
		form.replaceWith(newForm);
		
		controlForm(newForm, callback);
	}
	
	callback(form);
}
