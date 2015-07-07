jQuery(function($){
	// BestOf
	var bestOf = {
		form: $('[name="bestof"]'),
		collections: [
			$('#bestof_channels'),
			$('#bestof_externalVideos')
		]
	};
	
	manageCollections(bestOf.collections);
	transformChannelsUrlToId(bestOf.form, bestOf.collections[0]);
	transformVideosUrlToId(bestOf.form, bestOf.collections[1]);
	
	// Extract
	var extract = {
		form: 					$('[name="extract"]'),
		videoSelect: 			$('#extract_video'),
		externalVideoIdInput: 	$('#extract_externalVideo_id'),
		externalVideoIdLabel: 	$('[for="extract_externalVideo_id"]')
	};
	
	manageSelectOrText(extract.videoSelect, extract.externalVideoIdInput);
	transformVideoUrlToId(extract.form, extract.externalVideoIdInput, extract.externalVideoIdLabel);
});
