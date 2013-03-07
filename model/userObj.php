<?php

	class tweetUser
	{
		public $userName;
		public $pass;
		public $tweets; //array containing tweets
		public function __construct($userName,$pass)
		{
			$userName = $userName;
			$pass = $pass;
		}
	}
?>