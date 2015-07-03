jQuery(function($){
	// BestOf
	var bestOf = {
		collections: [
			$('#zz_pyrobundle_bestof_channels'),
			$('#zz_pyrobundle_bestof_externalVideos')
		]
	};
	
	manageCollections(bestOf.collections);
	
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
