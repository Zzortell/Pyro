function controlForm ( form, callback, args ) {
	callback.apply(form, args);
	
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
		response = $(response.replace('__id__', form.parent().attr('for')));
		form.replaceWith(response);
		
		var newForm = response.filter('form');
		newForm.each(function () {
			controlForm($(this), callback, args);
		});
		
		var confirm = response.filter('.form_confirm');
		form = confirm;
		confirm.children('#resubmit').on('click', function () {
			$.ajax({
				url:		$(this).attr('path'),
				type:		'GET',
				success: 	processResponse,
				error: 		handleAjaxError
			});
		});
	}
}
