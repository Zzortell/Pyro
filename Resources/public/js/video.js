jQuery(function($){
	var videoList = $('.video_list'), player;
	
	if ( videoList.length ) {
		var prototype 	= videoList.find('template'),
			videos 		= videoList.find('.video')
		;
		
		videos.on('click', function ( e ) {
			e.preventDefault();
			
			var id = this.id;
			var video_more = $(prototype.html().replace(/__id__/g, id));
			videos.parent().after(video_more);
			
			listenYt(function () {
				player = new YT.Player('youtube_player_video_' + id, {
					videoId: id,
				});
				
				/* FIRST METHOD: check time every second
				 * PB: latency
				 */
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
				}
				
				/* SECOND METHOD: listen HTML5 video's event
				 * PB: same-origin policy
				 *
				 * Solution: it could work with a player like popcorn.js
				 * http://popcornjs.org/popcorn-with-youtube
				 * http://popcornjs.org/popcorn-docs/events/#timeupdate
				var video = video_more.find('iframe').get().contentWindow.document.find('video');
				video.on('timeupdate', function () {
					console.log('captured!');
					$('.capture:not([captured])').trigger('click').removeAttr('captured');
				});
				 */
			});
			
			// Control form submittion
			var form = $('[name="bestof_extract"]');
			controlForm(form, controlExtractForm);
		});
		
		//DEV
		videos.trigger('click');
	}
	
	function controlExtractForm ( form ) {
		// Handle seonds fields submittion
		var seconds = form.find('.seconds');
		
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
			var id = $(this).attr('for');
			$('#' + id).val(
				formatIntToSeconds(player.getCurrentTime(), id.indexOf('end') !== -1)
			);
			$(this).attr('captured', '');
		});
	}
});
