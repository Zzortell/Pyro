var isYtReady = false;

function onYouTubeIframeAPIReady () {
	isYtReady = true;
	jQuery('html').trigger('ready.yt');
}

function listenYt ( callback, args ) {
	if ( isYtReady ) {
		callback.apply(null, args);
	} else {
		jQuery('html').on('ready.yt', callback);
	}
}
