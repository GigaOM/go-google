<?php
/**
 * Plugin Name: Gigaom Google API Library
 * Plugin URI: http://kitchen.gigaom.com
 * Description: Add the Google API for use in other plugins
 * Version: 0a
 * Author: Gigaom
 * Author URI: http://kitchen.gigaom.com
 */

/**
 * singleton for GO_Google
 */
function go_google()
{
	global $go_google;

	if ( ! $go_google )
	{
		require_once __DIR__ . '/components/class-go-google.php';
		$go_google = new GO_Google;
	}//end if

	return $go_google;
}//end go_google