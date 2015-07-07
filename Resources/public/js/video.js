jQuery(function($){
	var videoList = $('.video_list');
	
	if ( videoList.length ) {
		var prototype 	= videoList.find('template'),
			videos 		= videoList.find('.video')
		;
		
		videos.on('click', function ( e ) {
			e.preventDefault();
			
			history.replaceState(null, null, window.location.pathname + '#' + this.id);
			selectVideo($(this));
		});
	
		// Listen popstate event
		$(window).on('popstate', onPopstate);
		onPopstate();
	
		function onPopstate () {
			var video = videos.filterBy('id', urlObject().hash);
			selectVideo(video);
		}
		
		function selectVideo ( video ) {
			var id = video.attr('id');
			var video_more = $('.video_more');
			video_more.css('display', 'none');
			video_more = video_more.filterBy('for', id);
			
			if ( video_more.length === 0 ) {
				video_more = $(prototype.html().replace(/__id__/g, id));
				video_more.attr('for', id);
				video.parent().after(video_more);
				
				listenYt(function () {
					var player = new YT.Player('youtube_player_video_' + id, {
						videoId: id,
					});
			
					// Control form submittion
					var form = video_more.find('[name="bestof_extract"]');
					controlForm(form, controlExtractForm, [ player ]);
					
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
						form.find('.capture:not([captured])').trigger('click').removeAttr('captured');
						
						timerId = setTimeout(onPlaying, 1000);
					}
				});
			} else {
				video_more.css('display', 'block');
			}
		}
	}
	
	function controlExtractForm ( player ) {
		var form = this;
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
		
		var capture = form.find('.capture');
		capture.on('click', function () {
			var id = $(this).attr('for');
			$(this).siblings('#' + id).val(
				formatIntToSeconds(player.getCurrentTime(), id.indexOf('end') !== -1)
			);
			$(this).attr('captured', '');
		});
	}
});
