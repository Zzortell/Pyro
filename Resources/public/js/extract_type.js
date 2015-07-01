jQuery(function($){
	var form 					= $('[name="zz_pyrobundle_extract"]'),
		videoSelect 			= $('#zz_pyrobundle_extract_video'),
		externalVideoIdInput 	= $('#zz_pyrobundle_extract_externalVideo_id'),
		externalVideoIdLabel 	= $('[for="zz_pyrobundle_extract_externalVideo_id"]')
	;
	
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
	
	form.on('submit', function ( e ) {
		if ( externalVideoIdInput.val() ) {
			url = urlObject({ 'url': externalVideoIdInput.val() });
			
			if (
				url.hostname.indexOf('youtube.com') === -1
				|| url.pathname !== '/watch'
				|| typeof url.parameters.v === 'undefined'
			) {
				e.preventDefault();
				
				alert('Can\'t get the Youtube video\'s id. Please put a valid video url.');
			}
			
			externalVideoIdInput.val( url.parameters.v );
		}
	});
	
	externalVideoIdLabel.text('Url');
});
