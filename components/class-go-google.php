<?php

class GO_Google
{
	private $analytics;
	private $client;

	private $application_name;
	private $account;
	private $key_file;

	public function __construct( $application_name, $account, $key_file )
	{
		if ( empty( $application_name ) || empty( $account ) || empty( $key_file ) )
		{
			return FALSE;
		}// end if

		$this->application_name = $application_name;
		$this->account = $account;
		$this->key_file = $key_file;

		// required by the Google library
		set_include_path( get_include_path() . PATH_SEPARATOR . __DIR__ . '/external' );
		$this->client();
	}// end __construct

	public function client()
	{
		if ( ! $this->client )
		{
			require_once 'external/Google/Client.php';

			$this->client = new Google_Client();
			$this->client->setApplicationName( $this->application_name );

			$key = file_get_contents( $this->key_file );
			$cred = new Google_Auth_AssertionCredentials(
				$this->account,
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
}// end class
