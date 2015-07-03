function manageSelectOrText ( select, text ) {
	select.attr('required', true);
	
	select.on('change', function () {
		if ( $(this).val() !== '' ) {
			text.val('');
			text.attr('disabled', true);
		} else {
			text.attr('disabled', false);
		}
	});
	
	text.on('input', function () {
		if ( $(this).val() !== '' ) {
			select.val('');
			select.attr('disabled', true);
		} else {
			select.attr('disabled', false);
		}
	});
	
	select.trigger('change');
	text.trigger('input');
}
