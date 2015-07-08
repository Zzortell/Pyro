jQuery(function($){
	// BestOf
	var bestOf = {
		form: $('[name="bestof"]')
	};
	controlForm(bestOf.form, function () {
		collections = [
			$('#bestof_channels'),
			$('#bestof_externalVideos')
		];
		
		manageCollections(collections);
		transformChannelsUrlToId(this, collections[0]);
		transformVideosUrlToId(this, collections[1]);
	});
	
	// Extract
	var extract = {
		form: 					$('[name="extract"]'),
		videoSelect: 			$('#extract_video'),
		externalVideoIdInput: 	$('#extract_externalVideo_id'),
		externalVideoIdLabel: 	$('[for="extract_externalVideo_id"]')
	};
	
	// Todo
	// manageSelectOrText(extract.videoSelect, extract.externalVideoIdInput);
	// transformVideoUrlToId(extract.form, extract.externalVideoIdInput, extract.externalVideoIdLabel);
});
