<?php

   	class tweets
	{
		public $user;
		public $tweet;
		public $reTweets; //list retweets which contains tweets
		
		public function __construct($user,$message)
		{
			$this->user = $user;
			$this->tweet = $message;
			
		}
		
	}
	
		class tweetUser
	{
		public $userName;
		public $pass;
		public $tweets; //array containing tweets
		public $followers = array();
		public $following = array();
		public function __construct($userName,$pass,$tweets)
		{
			$this->userName = $userName;
			$this->pass = $pass;
			$this->tweets = $tweets;
			
		}
			public function getName()
		{
			return $this->userName;
		}

		public function getHash()
		{
			return $this->pass;
		}
		public function addFollwer($name)
		{
			//$this->followers[] = $name;
			array_push($this->followers, $name);
		}
		public function addFollowing($name)
		{
			array_push($this->following, $name);
		}
		public function isFollowing($name)
		{
			for($i=0; $i<count($this->following);$i++)
			{
				if($this->following[$i] == $name)
				{
					return true;
				}
			}
		}
		public function printTweets()
		{
			print "<ul>";
			for($i=0;$i< count($this->tweets); $i++)
			{
				print "<li>".$this->tweets[$i]->user . " => ". $this->tweets[$i]->tweet."</li>";
			}
			print "</ul>";
		}
	}
	////////////////////////////////////

	$user = $_REQUEST['user'];
	$remove = $_REQUEST['removeUser'];

	$filename = "../user/".$user."/".$user.".twitt";
	$handel  = fopen($filename, "r");
	$fileContent = fread($handel, 330000);
	$fileContent = unserialize($fileContent);
	$tempName = $fileContent->userName;
	$tempPass = $fileContent->pass;
	$tempTweet = $fileContent->tweets; 
	$tempFollowing = $fileContent->following;
	$tempFollowers = $fileContent->followers;


	$fileContent = new tweetUser($tempName,$tempPass,$tempTweet);
	$fileContent->following = $tempFollowing;
	$fileContent->followers = $tempFollowers;

	$followerList = array();

	for($i=0;$i< count($fileContent->following);$i++)
	{
		if($fileContent->following[$i] != $remove)
		{
			array_push($followerList, $fileContent->following[$i]);
		}
	}
	$fileContent->following = $followerList;

	$fileContent = serialize($fileContent);
	fclose($handel);
	$handel  = fopen($filename, "w");	
	fwrite($handel, $fileContent);
	fclose($handel);

	header("Location: ../view/welcome.php");

?>