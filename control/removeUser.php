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

	$server = "tcp://128.238.64.5:3000";
	$param = "/GET/".$user;
	
	$fp = stream_socket_client($server,$errno,$errstr,10240);
	$fileContent = "";
	fwrite($fp, $param);
			
			while(!feof($fp))
			{
				$fileContent = $fileContent . fgets($fp,10240);
			}
			
	fclose($fp);
	//////////////////////////////////////
	
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
	
	//////////////////////////////////////
	
	$server = "tcp://128.238.64.5:3000";
	$param = "/PUT/".$user."/".$fileContent;
	$fp = stream_socket_client($server,$errno,$errstr,10240);
	fwrite($fp, $param);

			
	fclose($fp);

	header("Location: ../view/welcome.php");

?>