<!doctype html>

<html>
<head>
<meta charset="UTF-8">
<title>Welcome</title>
<style type="text/css">
div.inline { float:left; padding: 2em; max-height: 800px;}
.clearBoth { clear:both; }
</style>
</head>

<body>

<?php 
	session_start();
	$user=$_SESSION['user'];
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
		
			
	
	
	if($user == "")
	{
		session_destroy();
		header("Location: ./view/login.php");
	}
	
	else
	{
		$user = $_SESSION['user'];
			
		print "<h1>Welcome ". $user ." </h1>";
		print "<a href='../view/login.php'>Logout</a>";
		
		print "<form action='../control/addTweet.php' method='post'>";
		print "<input type='hidden' name='user' value='$user'>";
		print "<textarea rows='8' cols='50' name='tweet' maxlength='140'  placeholder='Compose a new Tweet'>";
		print "</textarea>";
		print "<input type='submit' name='Submit' value='POST' />";
		print "</form>";
		
		// display all my tweets
		
			//open the file
			
			print "<div  class='inline' width='270px'>";	
			print "<h1> My Tweets </h1>";
			$dir = "../user/".$user."/".$user.".twitt";
			$handel  = fopen($dir, 'r');
			$fileContent = fread($handel, filesize($dir));
			$fileContent = unserialize($fileContent);
			$fileContent->printTweets();
			fclose($handel);
			print "</div>";
			
			print "<div class='inline' width='270px'>";	
			print "<h1> People I follow  </h1>";
				print "<pre>";
				print_r($fileContent->following);
				print "</pre>";
			print "</div>";
			
			
			
			
			print "<div  class='inline' width='270px'>";	
			print "<h1> People I May Know  </h1>";
			
			$userDir = "../user/";
			$listUser = scandir($userDir, 1);
			
			for($i=0; $i < count($listUser)-4;$i++)
			{
				print "<ul>";
				if($listUser[$i]!= $user)
				{
					if(!$fileContent->isFollowing($listUser[$i]))
					{
						$toFollow = $listUser[$i];
						print "<form action='../control/followUser.php' method='post'>";
						print "<input type='hidden' name='user' value='$user'>";
						print "<input type='hidden' name='followUser' value='$toFollow'>";
						print $listUser[$i]."<input type='submit' name='Submit' value='follow' />";
						print "</form>";
					}
				}
				print "</ul>";
			}
			
		
			print "</div>";
			
			print "<div  class='inline' width='270px'>";	
			print "<h1> Stream  </h1>";
				//print_r($fileContent->followers);
				print "<ul>";
				for($i=0;$i<count($fileContent->following);$i++)
				{
					$folowing_dir = "../user/".$fileContent->following[$i]."/".$fileContent->following[$i].".twitt";
					$handel  = fopen($folowing_dir, "r");
					$following_fileContent = fread($handel, 330000);
					$feed = unserialize($following_fileContent);
					$tempName = $feed->userName;
					$tempTweet = $feed->tweets;
					print "<li>".$tempName."=>";
					print $tempTweet[count($tempTweet)-1]->tweet;
					print "</li>";

					fclose($handel);
				}
				print "</ul>";
			print "</div>";


	}
	

	
?>


</body>
</html>
