function manageCollections ( collections ) {
	for ( var i = 0, c = collections.length; i < c; i++ ) {
		if ( collections[i].length !== 0 ) {
			manageCollection(collections[i]);
		}
	}
}

	
function manageCollection ( collection ) {
	var addButton = $('<button type="button" id="add_channel">Ajouter</button>'),
		prototype = collection.attr('data-prototype').replace(/__name__label__/g, '')
	;
	
	// Ajout du button#add_channel
	collection.parent().append(addButton);
	addButton.on('click', addField);
	
	// Compteur de champs
	var index = collection.find('input').length;
	
	// Ajout d'un premier champs
	if ( index === 0 ) {
		addField();
	} else {
		collection.children('div').each(function () {
			addDeleteButton($(this));
		})
	}
	
	function addField () {
		var fields = $( prototype.replace(/__name__/g, index) );
		addDeleteButton(fields);
		removeInputsLabels(fields.find('input'));
		collection.append(fields);
		index++;
	}
	
	function addDeleteButton ( fields ) {
		var link = $('<button type="button" id="delete">Supprimer</button>');
		fields.append(link);
		link.on('click', function () {
			fields.remove();
		});
	}
}
