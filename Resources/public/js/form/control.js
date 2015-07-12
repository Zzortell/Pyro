function controlForm ( form, options ) {
	var dispatcher = new EventDispatcher ();
	dispatcher.listen('control', options.control);
	dispatcher.listen('submit', options.submit);
	
	dispatcher.dispatch('control', { form: form });
	
	form.on('submit', function ( e ) {
		clonedForm = form.clone();
		dispatcher.dispatch('submit', { form: clonedForm, originalEvent: e });
		
		var data = clonedForm.serialize();
		
		if ( e.isDefaultPrevented() ) {
			return;
		}
		
		e.preventDefault();
		
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
			controlForm($(this), options);
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
	
	return dispatcher;
}
