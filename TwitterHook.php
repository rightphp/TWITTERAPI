<?php
/**
 * This class demonstrate simplest implementation of Twitter API uisng ZendFramework2 service packages
 * 
 * To get started, first you'll need to either create a new application with Twitter, or get the details of an existing one you control. 
 * To do this:
 *    Go to https://dev.twitter.com/ and sign in.
 *    Go to https://dev.twitter.com/apps
 *    Either create a new application, or select an existing one.
 *    On the application's settings page, grab the following information:
 *        From the header "OAuth settings", grab the "Consumer key" and "Consumer secret" values.
 *        From the header "Your access token", grab the "Access token" and "Access token secret" values.
 *
 *
 * @link      https://github.com/zendframework/ZendService_Twitter                 for source repository
 * 
 */

require 'vendor/autoload.php';

class TwitterHook {
	
	/**
	 * Hold an instance of the class
	 */
	private static $_instance;
	
	/**
	 * Holds an instance to the Twitter service
	 */
	private $_twitter_hook;
	
	private $_access_token = '3060060216-GPXw60X8gUXe60IM8XGfXlXYkEkVNpSRLucSrPt';
	private $_access_secret = 'VNhTN4ZpJZTK4O9GtrvVF1GPaY2IjXmnX3eoXeTbKXhZC';
	private $_consumer_key = '5WJQKeVgra5rEhojFrSKxpv2C';
	private $_consumer_secret = 'oSj0RroqNQom0GBcjkCh4eEErSSs1iuwwTejl6L2Mo3naqph2V';

	public $_records_count = 25;
	public $_records_type = 'recent';
	
	/**
	 * A private constructor; prevents direct creation of object
	 */ 
	private function __construct() {
		//
	}
	
	/**
	 * Prevent users to clone the instance
	 */
	public function __clone() {
		trigger_error ( 'Clone is not allowed.', E_USER_ERROR );
	}
	
	/**
	 * The singleton method, insuring only one instance of the class in execuition sequence
	 */
	public static function singleton() {
		if (! isset ( self::$_instance )) {
			self::$_instance = new self ();
		}
		return self::$_instance;
	}
	
	/**
	 * Initiating twitter object
	 */
	private function setTwitterHook() {
		$config = array (
				'access_token' => array (
						'token' => $this->_access_token,
						'secret' => $this->_access_secret,
				),
				'oauth_options' => array (
						'consumerKey' => $this->_consumer_key,
						'consumerSecret' => $this->_consumer_secret,
				),
				'http_client_options' => array (
						'adapter' => 'Zend\Http\Client\Adapter\Curl',
						'curloptions' => array (
								CURLOPT_SSL_VERIFYHOST => false,
								CURLOPT_SSL_VERIFYPEER => false, 
						) 
				) 
		);
		
		$this->_twitter_hook = new ZendService\Twitter\Twitter ( $config );
		
		// Verify credentials:
		if (! $this->_twitter_hook->account->verifyCredentials ()->isSuccess ()) {
			throw new Exception ( "Wrong Twitter Credntials!" );
		}
	}
	
	/**
	 * Returns twitter object, checks if object was created previously otherwise fresh object is created 
	 */
	private function getTwitterHook() {
		if (null === $this->_twitter_hook) {
			$this->setTwitterHook ();
		}
		return $this->_twitter_hook;
	}
	
	/**
	 * Search for tweets and filters out the tweets which are not even re-tweeted once. 
	 * 
	 * @see For more search options: https://dev.twitter.com/rest/public/search
	 */
	public function getTweetsReTweeted() {
		$temp = array ();
		$tweets = $this->getTwitterHook()->search->tweets ( '#custserv -RT', array (
				'count' => $this->_records_count,
				'result_type' => $this->_records_type 
		) )->toValue ();
		
		foreach ( $tweets->statuses as $tweet ) {
			if ($tweet->retweet_count === 0)
				continue;
			$temp [] = $tweet;
		}
		return $temp;
	}
}


