(function( $ ) {
	'use strict';
	
	//this is for masonry / packery - it adds the item class to each image
	$('#packery-grid').find('img').each(function() {       
		$(this).addClass('item');
	}); 
	
	$('#packery-grid').packery({
		// options
		itemSelector: '.item',
		gutter: 10
	});

})( jQuery );
