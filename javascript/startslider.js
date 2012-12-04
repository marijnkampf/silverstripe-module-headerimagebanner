jQuery(window).load(function() {
	jQuery('#slider').nivoSlider({
		pauseTime: 5000, // How long each slide will show
		directionNav: false, // Next & Prev navigation
		directionNavHide: false, // Only show on hover		
		startSlide: 0, // Set starting Slide (0 index)
		effect: 'fade', // Specify sets like: 'fold,fade,sliceDown'
	});
});
