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
			});
			
			manageUserForms();
		});
		
		//DEV
		videos.trigger('click');
	}
});
