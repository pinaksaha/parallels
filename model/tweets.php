<?php 
	
	class tweets
	{
		public $user;
		public $tweet;
		public $reTweets; //list retweets which contains tweets
		
		public function __construct($user,$message)
		{
			$user = $user;
			$tweet = $message;
		}
		
	}
	
?>