<?php
function blogolytics_get_option( $tab, $key ) {
	$settings = get_option( 'blogolytics_' . $tab );

	$value = '';
	if( $settings[ $key ] ) {
		$value = $settings[ $key ];
	}

	return $value;
}