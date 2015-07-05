var isYtReady = false;

function onYouTubeIframeAPIReady () {
	isYtReady = true;
	jQuery('html').trigger('ready.yt');
}

function listenYt ( callback ) {
	if ( isYtReady ) {
		callback();
	} else {
		jQuery('html').on('ready.yt', callback);
	}
}
