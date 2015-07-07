function transformVideosUrlToId ( form, collection ) {
	inputs = collection.find(':regex(id,^[^_]+_externalVideos_\\d+_id$)');
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
				
				warn('Can\'t get the Youtube video\'s id. Please put a valid video url.');
			}
			
			text.val( url.parameters.v );
		}
	});
	
	label.text('Url');
}

function transformSecondsToInt ( form, text ) {
	form.on('submit', function ( e ) {
		var time = formatSecondsToInt(text.val());
		if ( time !== false ) {
			text.val(time);
		} else {
			e.preventDefault();
			
			warn('Invalid time format. A valid format is HH:MM:SS');
		}
	});
	
	if ( !parseInt(text.val()) ) {
		text.val('00:00');
	}
}

function formatSecondsToInt ( time ) {
	var matches = time.match(/^(?:(?:(\d+):)?([0-5]\d):)?([0-5]\d)$/);
	
	if ( !matches ) {
		return false;
	}
	
	var seconds = parseInt(matches[3]),
		minutes = parseInt(matches[2]),
		hours 	= parseInt(matches[1])
	;
	
	return ((hours||0)*60 + (minutes||0))*60 + seconds;
}

function formatIntToSeconds ( time, ceil ) {
	hours = Math.floor(time/3600);
	time %= 3600;
	minutes = Math.floor(time/60);
	time %= 60;
	if ( ceil ) {
		seconds = Math.ceil(time);
	} else {
		seconds = Math.floor(time);
	}
	
	return (hours ? (hours < 10 ? '0' : '') + hours + ':' : '')
			+ (minutes < 10 ? '0' : '') + minutes + ':'
			+ (seconds < 10 ? '0' : '') + seconds;
}

function warn ( message ) {
	alert(message);
}
