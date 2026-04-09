(function( $ ) {
	'use strict';
	/*
	//this is for masonry / packery - it adds the item class to each image
	$('#packery-grid').find('img').each(function() {
		$(this).addClass('item');
	});

	$('#packery-grid').packery({
		// options
		itemSelector: '.item',
		gutter: 10
	});
  */
  var $grid = $('.packery-grid').imagesLoaded( function() {
		// init Masonry after all images have loaded
		$grid.packery({
			// options...
			//columnWidth: 200,
			itemSelector: '.packery-grid img',
      gutter: 10
		});
	});

})( jQuery );
