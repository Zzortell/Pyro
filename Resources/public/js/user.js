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
	
	requestForm();
}
