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
		public function __construct($userName,$pass)
		{
			$this->userName = $userName;
			$this->pass = $pass;
			
			
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
		
	
	
		$user = $_REQUEST['username'];
		$pass = $_REQUEST['password'];
		
		$hash = md5($pass);

		$mk_usr = new tweetUser($user,$hash);
		$mk_usr = serialize($mk_usr);
		// Check if the use exists
		
		//echo $user . " ". $hash."\n";
		
		//$dir = "../user/".$user;
		//echo $dir;
		$server = "tcp://172.16.239.128:3000";
		$param = "/CREATE/".$user."/".$mk_usr."/";
		
		$fp = stream_socket_client($server, $errno, $errstr, 10240);
			$userContent ="";
			fwrite($fp, $param);

		header("Location: ../index.php");
?>
	