jQuery(function($){
	// BestOf
	var bestOf = {
		form: $('[name="zz_pyrobundle_bestof"]'),
		collections: [
			$('#zz_pyrobundle_bestof_channels'),
			$('#zz_pyrobundle_bestof_externalVideos')
		]
	};
	
	manageCollections(bestOf.collections);
	transformVideosUrlToId(bestOf.form, bestOf.collections[1]);
	
	//Extract
	var extract = {
		form: 					$('[name="zz_pyrobundle_extract"]'),
		videoSelect: 			$('#zz_pyrobundle_extract_video'),
		externalVideoIdInput: 	$('#zz_pyrobundle_extract_externalVideo_id'),
		externalVideoIdLabel: 	$('[for="zz_pyrobundle_extract_externalVideo_id"]')
	};
	
	manageSelectOrText(extract.videoSelect, extract.externalVideoIdInput);
	transformVideoUrlToId(extract.form, extract.externalVideoIdInput, extract.externalVideoIdLabel);
});
