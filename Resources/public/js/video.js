jQuery(function($){
	var videoList = $('.video_list');
	
	if ( videoList.length ) {
		var prototype 	= videoList.find('template'),
			videos 		= videoList.find('.video')
		;
		
		videos.on('click', function ( e ) {
			e.preventDefault();
			
			var id = this.id;
			video_more = $(prototype.html().replace(/__id__/g, id));
			videos.parent().after(video_more);
			
			var player;
			listenYt(function () {
				player = new YT.Player('youtube_player_video_' + id, {
					videoId: id,
				});
			
				// Listen player stateChange
				var timerId;
				
				player.addEventListener('onStateChange', function ( e ) {
					if ( e.data === YT.PlayerState.PLAYING ) {
						onPlaying();
					} else {
						clearTimeout(timerId);
					}
				});
				
				function onPlaying () {
					$('.capture:not([captured])').trigger('click').removeAttr('captured');
					
					timerId = setTimeout(onPlaying, 1000);
					console.log('captured!');
				}
			});
			
			// Handle seonds fields submittion
			var form 	= $('[name="bestof_extract"]'),
				seconds = form.find('.seconds');
			;
			
			seconds.each(function () {
				transformSecondsToInt(form, $(this));
			});
			
			// Add capture buttons
			seconds.each(function () {
				$(this).after($(
					'<button type="button" class="capture" for="' + this.id + '">Capturer</button>'
				));
			});
			
			var capture = $('.capture');
			capture.on('click', function () {
				$('#' + $(this).attr('for')).val(formatIntToSeconds(player.getCurrentTime()));
				$(this).attr('captured', '');
			});
			
			capture.parent().css('text-align', 'right');
		});
		
		//DEV
		videos.trigger('click');
	}
});
