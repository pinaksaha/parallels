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
		
	
	
		$user = $_REQUEST['username'];
		$pass = $_REQUEST['password'];
		
		$hash = md5($pass);
		// Check if the use exists
		
		//echo $user . " ". $hash."\n";
		
		$dir = "../user/".$user;
		//echo $dir;
		
		$fileName = $dir."/".$user.".twitt";
		if(!is_dir($dir))
		{
			
			//make the user
			mkdir($dir,0777,TRUE);
		
			//make the user
			//echo "\n\n".$user . " ". $hash."\n";
			$newUsr = new tweetUser($user,$hash);
			 
			//format in json
			$fileFormat = $newUsr;
			$fileFormat = serialize($fileFormat);
			//Save the data
			$handel = fopen($fileName, 'x+');
			fwrite($handel, $fileFormat);
			fclose($handel);
			session_start();
			$_SESSION['user'] = $newUsr->getName();
			header("Location: 	../view/welcome.php");
			
			
		}
		
		else
		{
			$error = "Use Already Exists.";
			
			header("Location: ../view/register.php?error=$error");
			
		}	
		
?>
	