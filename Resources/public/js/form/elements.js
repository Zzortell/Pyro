jQuery(function($){
	// BestOf
	var bestOf = {
		form: $('[name="bestof"]'),
		collections: [
			$('#bestof_channels'),
			$('#bestof_externalVideos')
		]
	};
	controlForm(bestOf.form, {
		control: function () {
			manageCollections(bestOf.collections);
			
			var inputs = bestOf.collections[0].find(':regex(id,^[^_]+_channels_\\d+_idOrUser$)');
			removeInputsLabels(inputs);
			
			var inputs = bestOf.collections[1].find(':regex(id,^[^_]+_externalVideos_\\d+_id$)');
			removeInputsLabels(inputs);
			bestOf.collections[1].prev('label').remove();
		},
		submit: function ( e ) {
			transformChannelsUrlToId(e);
			transformVideosUrlToId(e);
		}
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
