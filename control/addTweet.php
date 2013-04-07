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
	$tweet = $_REQUEST['tweet'];
		
	
	$server = $server = "tcp://172.16.239.128:3000";
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
	$tempfollowers = $fileContent->followers;
	$tempfollowing = $fileContent->following;
	
	$obj = new tweets($user,$tweet);
	$tempTweet[] = $obj;
	
	$fileContent = new tweetUser($tempName,$tempPass,$tempTweet);
	$fileContent->followers = $tempfollowers;
	$fileContent->following =$tempfollowing;
	
	$fileContent = serialize($fileContent);
	
	$server = $server = "tcp://172.16.239.128:3000";
	$param = "/PUT/".$user."/".$fileContent;
	
	$fp = stream_socket_client($server,$errno,$errstr,10240);
	
	
	fwrite($fp, $param);
		
	header("Location: ../view/welcome.php");
	
?>