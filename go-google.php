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
function go_google( $application_name, $account = NULL, $key_file = NULL )
{
	global $go_google;

	if ( ! is_array( $go_google ) )
	{
		$go_google = array();
	}// end if

	if ( ! isset( $go_google[ $application_name ] ) || ! is_object( $go_google[ $application_name ] ) )
	{
		require_once __DIR__ . '/components/class-go-google.php';
		$go_google[ $application_name ] = new GO_Google( $application_name, $account, $key_file );
	}//end if

	return $go_google[ $application_name ];
}//end go_google