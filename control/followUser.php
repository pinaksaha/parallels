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
		
	///////////////////////////////////////////////////////////////////////////	
	
	$user = $_REQUEST['user'];
	$follower = $_REQUEST['followUser'];
	
	
			$server = $server = "tcp://128.238.64.5:3000";
			$param = "/GET/".$user."/";
	
			$fp = stream_socket_client($server,$errno,$errstr,10240);
			$fileContent = "";
	
	
			fwrite($fp, $param);
			
			while(!feof($fp))
			{
				$fileContent = $fileContent . fgets($fp,10240);
			}
			
			fclose($fp);
			
			$fileContent = unserialize($fileContent);
	
	
	
	$tempName = $fileContent->userName;
	$tempPass = $fileContent->pass;
	$tempTweet = $fileContent->tweets; 
	$tempFollowing = $fileContent->following;
	$tempFollowers = $fileContent->followers;

	//new user object
	$fileContent = new tweetUser($tempName,$tempPass,$tempTweet);
	$fileContent->following = $tempFollowing;
	$fileContent->addFollowing($follower);
	$fileContent->follower = $tempFollowers;
	//print_r($fileContent);
	//array_push($fileContent->following,$follower);
	$fileContent = serialize($fileContent);
	
	$server = "tcp://128.238.64.5:3000";
	$param = "/PUT/".$user."/".$fileContent;
	$fp = stream_socket_client($server,$errno,$errstr,10240);
	fwrite($fp, $param);
	
	//fclose($handel);
	//$handel  = fopen($filename, "w");	
	//fwrite($handel, $fileContent);
	//fclose($handel);

///////////////////////////////////////////////////////////////////////
	
	/*
			$server = $server = "tcp://172.16.239.128:3000";
			$param = "/GET/".$follower."/";
	
			$fp = stream_socket_client($server,$errno,$errstr,10240);
			$fileContent = "";
	
	
			fwrite($fp, $param);
			
			while(!feof($fp))
			{
				$fileContent = $fileContent . fgets($fp,10240);
			}
			
			fclose($fp);
			
	$fileContent = unserialize($fileContent);
	
	$tempName = $fileContent->userName;
	$tempPass = $fileContent->pass;
	$tempTweet = $fileContent->tweets; 
	$tempFollowers = $fileContent->followers;
	$temmFollowing = $fileContent->following;

	$fileContent = new tweetUser($tempName,$tempPass,$tempTweet);
	$fileContent->followers = $tempFollowers;
	$fileContent->addFollwer($user);


	$fileContent->following = $temmFollowing;

	//$fileContent->addFollowing($follower);
	//array_push($fileContent->followers,$user);
	
	//print_r($fileContent);
	$fileContent = serialize($fileContent);
	$server = "tcp://172.16.239.128:3000";
	$param = "/PUT/".$user."/".$fileContent;
	$fp = stream_socket_client($server,$errno,$errstr,10240);
	fwrite($fp, $param);
	
	*/
	
	header("Location: ../view/welcome.php");
	
?>