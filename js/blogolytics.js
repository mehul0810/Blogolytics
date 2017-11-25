
jQuery(function() {

	// Scroll Depth Analytics
	jQuery.scrollDepth({
		elements: ['#page'],
		percentage: true,
		userTiming: false,
		pixelDepth: false,
		nonInteraction: false,
		trackerName: 'Scroll Depth Analytics'
	});
});