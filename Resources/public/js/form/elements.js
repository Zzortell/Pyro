jQuery(function($){
	// BestOf
	var collections = [
		$('#zz_pyrobundle_bestof_channels'),
		$('#zz_pyrobundle_bestof_externalVideos')
	];
	
	manageCollections(collections);
	
	//Extract
	var form 					= $('[name="zz_pyrobundle_extract"]'),
		videoSelect 			= $('#zz_pyrobundle_extract_video'),
		externalVideoIdInput 	= $('#zz_pyrobundle_extract_externalVideo_id'),
		externalVideoIdLabel 	= $('[for="zz_pyrobundle_extract_externalVideo_id"]')
	;
	
	manageSelectOrText(videoSelect, externalVideoIdInput);
	transformVideoUrlToId(form, externalVideoIdInput, externalVideoIdLabel);
});
