jQuery(function($){
	var form 		= $('[name="zz_pyrobundle_bestof"]'),
		channels 	= $('#zz_pyrobundle_bestof_channels')
	;
	
	var addButton = $('<button type="button" id="add_channel">Ajouter une chaîne</button>'),
		prototype = channels.attr('data-prototype').replace(/__name__label__/g, '')
	;
	
	// Ajout du button#add_channel
	channels.append(addButton);
	addButton.on('click', addChannel);
	
	// Compteur de champs
	var index = channels.find('input').length;
	
	// Ajout d'un premier champs
	if ( index === 0 ) {
		addChannel();
	} else {
		channels.children('div').each(function () {
			addDeleteButton($(this));
		})
	}
	
	function addChannel () {
		var channel = $( prototype.replace(/__name__/g, index) );
		addDeleteButton(channel);
		channels.append(channel);
		index++;
	}
	
	function addDeleteButton ( channel ) {
		var link = $('<button type="button" id="delete">Supprimer</button>');
		channel.append(link);
		link.on('click', function () {
			channel.remove();
		});
	}
});
