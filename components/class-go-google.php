<?php

class GO_Google
{
	private $analytics;
	private $client;
	private $config;

	public function __construct()
	{
		// required by the Google library
		set_include_path( get_include_path() . PATH_SEPARATOR . __DIR__ . '/external' );
		$this->client();
	}// end __construct

	public function client()
	{
		if ( ! $this->client )
		{
echo 'include path: ' . get_include_path();
			require_once 'external/Google/Client.php';

			$this->client = new Google_Client();
			$this->client->setApplicationName( $this->config( 'application_name' ) );

			$key = file_get_contents( $this->config( 'key_file' ) );
			$cred = new Google_Auth_AssertionCredentials(
				$this->config( 'google_auth_account' ),
				array( 'https://www.googleapis.com/auth/analytics.readonly' ),
				$key
			);
			$this->client->setAssertionCredentials( $cred );
		}//end if

		return $this->client;
	}// end client

	public function analytics()
	{
		if ( ! $this->analytics )
		{
			require_once 'external/Google/Service/Analytics.php';
			$this->analytics = new Google_Service_Analytics( $this->client() );
		}//end if

		return $this->analytics;
	}//end analytics

	/**
	 * get the configuration for this plugin
	 *
	 * @param $key (string) if not NULL, return the value of this configuration
	 *  key if it's set. else return FALSE. if $key is NULL then return
	 *  the whole config array.
	 */
	private function config( $key = NULL )
	{
		if ( ! $this->config )
		{
			$this->config = apply_filters( 'go_config', array(), 'go-google' );
		}//end if

		if ( $key )
		{
			if ( isset( $this->config[ $key ] ) )
			{
				return $this->config[ $key ];
			}//end if
			else
			{
				return FALSE;
			}//end else
		}//end if

		return $this->config;
	}//end config
}// end class