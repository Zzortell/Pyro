function transformVideosUrlToId ( form, collection ) {
	inputs = collection.find(':regex(id,^[^_]+_externalVideos_\\d+_id$)');
	console.log(inputs);
	inputs.each(function () {
		transformVideoUrlToId(form, $(this), $(this).prev('label'));
	});
}

function transformVideoUrlToId ( form, text, label ) {
	form.on('submit', function ( e ) {
		if ( text.val() ) {
			url = urlObject({ 'url': text.val() });
			
			if (
				url.hostname.indexOf('youtube.com') === -1
				|| url.pathname !== '/watch'
				|| typeof url.parameters.v === 'undefined'
			) {
				e.preventDefault();
				
				alert('Can\'t get the Youtube video\'s id. Please put a valid video url.');
			}
			
			text.val( url.parameters.v );
		}
	});
	
	label.text('Url');
}
