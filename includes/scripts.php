<?php
/**
 * Enqueue Script details.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Scripts and Styles.
 *
 * @since 1.0.0
 */
function blogolytics_localize_scripts() {

	// Call GA Analytics.js
	wp_enqueue_script( 'ga-analytics', 'https://www.google-analytics.com/analytics.js' );

}

add_action( 'wp_enqueue_scripts', 'blogolytics_localize_scripts' );

/**
 * Place GA Tracking Code in Footer.
 *
 * @since 1.0.0
 */
function blogolytics_google_tracking() {
	?>
	<!-- Google Analytics by Blogolytics -->
	<script type="text/javascript">
		window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
		ga('create', '<?php echo blogolytics_get_option( 'connection', 'tracking_code'); ?>', 'auto');
		ga('send', 'pageview');
	</script>
	<script async src='https://www.google-analytics.com/analytics.js'></script>
	<!-- End Google Analytics by Blogolytics -->
	<?php
}

add_action( 'wp_footer', 'blogolytics_google_tracking' );


