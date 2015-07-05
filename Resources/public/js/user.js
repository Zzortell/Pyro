jQuery(function($){
	manageUserForms();
});
	
function manageUserForms () {
	var containers = [
		$('#user_login_container'),
		$('#user_register_container')
	];
	
	for ( var i = 0, c = containers.length; i < c; i++ ) {
		if ( containers[i].length !== 0 ) {
			manageUserForm(containers[i]);
		}
	}
}
	
function manageUserForm ( container ) {
	function requestForm () {
		$.ajax({
			url:		container.attr('path'),
			type:		'GET',
			success: 	processResponse,
			error: 		handleAjaxError
		});
	}
	
	function control () {
		container.find('form').on('submit', function ( e ) {
			e.preventDefault();
			
			var data = $(this).serialize();
				
			$.ajax({
				url:		$(this).attr('action') || container.attr('path'),
				type:		'POST',
				data:		data,
				success: 	processResponse,
				error: 		handleAjaxError
			});
		});
		
		container.find('button#close_frame').on('click', function ( e ) {
			location.reload();
		});
	}
	
	function processResponse ( response, status ) {
		var frame = $(response).filter('#user_frame');
		
		if ( frame.length === 0 ) {
			location.reload();
		} else {
			container.html(frame.children());
			control();
		}
	}
	
	function handleAjaxError ( xhr, status, error ) {
		alert ('Une erreur s\'est produite dans le chargement du contenu. \n\
				Il est possible que votre navigateur soit obsolète. \
				Dans ce cas, essayez de le mettre à jour. \n\
				Si vous le pouvez, merci de nous reporter cette erreur. \n\
				Veuillez nous excuser pour le dérangement occasionné. \n\
				Message du serveur : \n' + xhr.status + ' : ' + error );
		console.error(xhr, status, error);
	}
	
	requestForm();
}
