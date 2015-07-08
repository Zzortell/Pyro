function transformVideosUrlToId ( form, collection ) {
	form.on('submit', function ( e ) {
		var inputs = collection.find(':regex(id,^[^_]+_externalVideos_\\d+_id$)');
		inputs.each(function () {
			if ( $(this).val() ) {
				var id = formatVideoUrlToId($(this).val());
				if ( id ) {
					$(this).val(id);
				} else {
					e.preventDefault();
					warn('Can\'t get the Youtube video\'s id. Please put a valid video url.');
				}
			}
		});
	});
	
	var inputs = collection.find(':regex(id,^[^_]+_externalVideos_\\d+_id$)');
	removeInputsLabels(inputs);
	collection.prev('label').remove();
}

function formatVideoUrlToId ( url ) {
	url = urlObject({ 'url': url });
	
	if (
		url.hostname.indexOf('youtube.com') === -1
		|| url.pathname !== '/watch'
		|| typeof url.parameters.v === 'undefined'
	) {
		return false;
	}
	
	return url.parameters.v;
}

function transformChannelsUrlToId ( form, collection ) {
	form.on('submit', function ( e ) {
		var inputs = collection.find(':regex(id,^[^_]+_channels_\\d+_idOrUser$)');
		inputs.each(function () {
			if ( $(this).val() ) {
				var id = formatChannelUrlToId($(this).val());
				if ( id ) {
					$(this).val(id);
				} else {
					e.preventDefault();
					warn('Can\'t get the Youtube channel or user\'s id. Please put a valid channel url.');
				}
			}
		});
	});
	
	var inputs = collection.find(':regex(id,^[^_]+_channels_\\d+_idOrUser$)');
	removeInputsLabels(inputs);
}

function formatChannelUrlToId ( url ) {
	url = urlObject({ 'url': url });
			
	if (
		url.hostname.indexOf('youtube.com') !== -1 && url.pathname.indexOf('/channel/') === 0
	) {
		return url.pathname.substring(9);
	} else if (
		url.hostname.indexOf('youtube.com') !== -1 && url.pathname.indexOf('/user/') === 0
	) {
		return 'user:' + url.pathname.substring(6);
	} else {
		return false;
	}
}

function removeInputsLabels ( inputs ) {
	inputs.prev('label').text('Url :');
	inputs.parent().parent().siblings('label').remove();
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
