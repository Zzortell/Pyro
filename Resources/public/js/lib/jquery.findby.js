jQuery(function($){
	$.fn.findBy = function ( attr, value ) {
		return this.find('[' + attr + '="' + value + '"]');
	}
	
	$.fn.filterBy = function ( attr, value ) {
		return this.filter('[' + attr + '="' + value + '"]');
	}
});
