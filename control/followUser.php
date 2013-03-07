<?php
	
	
   //	print $user ."=>".$follower;
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
		
		
	
	$user = $_REQUEST['user'];
	$follower = $_REQUEST['followUser'];
	
	
	$filename = "../user/".$user."/".$user.".twitt";
	$handel  = fopen($filename, "r");
	//	print(filesize($filename));print "<br />";
	$fileContent = fread($handel, 330000);
	$fileContent = unserialize($fileContent);
	
	$tempName = $fileContent->userName;
	$tempPass = $fileContent->pass;
	$tempTweet = $fileContent->tweets; 
	$tempFollowing = $fileContent->following;
	$fileContent = new tweetUser($tempName,$tempPass,$tempTweet);
	$fileContent->followers[] = $follower;
	//print_r($fileContent);
	//array_push($fileContent->following,$follower);
	$fileContent = serialize($fileContent);
	fclose($handel);
	$handel  = fopen($filename, "w");	
	fwrite($handel, $fileContent);
	fclose($handel);

///////////////////////////////////////////////////////////////////////
	
	$filename = "../user/".$follower."/".$follower.".twitt";
	$handel  = fopen($filename, "r");
	//	print(filesize($filename));print "<br />";
	$fileContent = fread($handel, 330000);
	$fileContent = unserialize($fileContent);
	
	$tempName = $fileContent->userName;
	$tempPass = $fileContent->pass;
	$tempTweet = $fileContent->tweets; 
	$tempFollower = $fileContent->followers;
	$fileContent = new tweetUser($tempName,$tempPass,$tempTweet);
	
	//array_push($fileContent->followers,$user);
	$fileContent->following[] = $user;
	//print_r($fileContent);
	$fileContent = serialize($fileContent);
	fclose($handel);
	$handel  = fopen($filename, "w");	
	fwrite($handel, $fileContent);
	fclose($handel);
	
	
	
	header("Location: ../view/welcome.php");
	
?>