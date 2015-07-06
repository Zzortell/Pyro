function handleAjaxError ( xhr, status, error ) {
	alert ('Une erreur s\'est produite dans le chargement du contenu. \n\
			Il est possible que votre navigateur soit obsolète. \
			Dans ce cas, essayez de le mettre à jour. \n\
			Si vous le pouvez, merci de nous reporter cette erreur. \n\
			Veuillez nous excuser pour le dérangement occasionné. \n\
			Message du serveur : \n' + xhr.status + ' : ' + error );
	console.error(xhr, status, error);
}
