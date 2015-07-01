jQuery(function($){
	var videoSelect 			= $('#zz_pyrobundle_extract_video'),
		externalVideoIdInput 	= $('#zz_pyrobundle_extract_externalVideo_id');
	
	videoSelect.attr('required', true);
	
	videoSelect.on('change', function () {
		console.log($(this).val());
		if ( $(this).val() !== '' ) {
			externalVideoIdInput.val('');
			externalVideoIdInput.attr('disabled', true);
		} else {
			externalVideoIdInput.attr('disabled', false);
		}
	});
	
	externalVideoIdInput.on('input', function () {
		if ( $(this).val() !== '' ) {
			videoSelect.val('');
			videoSelect.attr('disabled', true);
		} else {
			videoSelect.attr('disabled', false);
		}
	});
	
	videoSelect.trigger('change');
	externalVideoIdInput.trigger('input');
});
