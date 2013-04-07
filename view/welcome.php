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
			//print "<pre>";print_r($fileContent);print "<pre>";
			
			print "<div  class='inline' width='270px'>";	
			print "<h1> My Tweets </h1>";
	
				$fileContent->printTweets();
			print "</div>";
			
			print "<div class='inline' width='270px'>";	
			print "<h1> People I follow  </h1>";
			for($i=0; $i<count($fileContent->following);$i++)
				{
					$removeUser = $fileContent->following[$i];
					print "<form action='../control/removeUser.php' method='post'>";
					print "<input type='hidden' name='user' value='$user'>";
					print "<input type='hidden' name='removeUser' value='$removeUser'>";
					print $removeUser."<input type='submit' name='Submit' value='remove' />";
					print "</form>";
				}
			print "</div>";
			
			
			
			
			print "<div  class='inline' width='270px'>";	
			print "<h1> People I May Know  </h1>";
						
			//define the server 
			$server = $server = "tcp://172.16.239.128:3000";
			$param = "/VIEW/";
			//connect using the socket
			$fp = stream_socket_client($server,$errno,$errstr,10240);
			
			// call the method view
			$usersInNetwork = "";
			fwrite($fp, $param);
			while(!feof($fp))
			{
				$usersInNetwork = $usersInNetwork . fgets($fp,10240);
			}
			fclose($fp);
			// tokenize the value delimination '/'
			
			$usersInNetwork = explode('/', $usersInNetwork);
			
			//print '<pre>'.print_r($usersInNetwork).print "</pres>";
			
			//display the usere
			print "<ul>";
			for($i=0; $i< count($usersInNetwork);$i++)
			{
			
				if($usersInNetwork[$i] != $user)
				{
					if(!$fileContent->isFollowing($usersInNetwork[$i]))
					{
						
							$toFollow = $usersInNetwork[$i];
							print "<li>";					
							print "<form action='../control/followUser.php' method='post'>";
		                    print "<input type='hidden' name='user' value='$user'>";
		                    print "<input type='hidden' name='followUser' value='$toFollow'>";
		                    print $usersInNetwork[$i]."<input type='submit' name='Submit' value='follow' />";
		                    print "</form>";
		                    print "<li>";
		                
					}
				}
			}
			print "</ul>";
			print "</div>";
			
			
			/*
				Get Every Users Tweet that i follow
			*/
			
			print "<div  class='inline' width='270px'>";	
			print "<h1> Stream  </h1>";
			
				for($i=0;$i<(count(($fileContent->following)));$i++)
				{
					$server = "tcp://172.16.239.128:3000";
					$param = "/GET/".$fileContent->following[$i]."/";
			
					$fp = stream_socket_client($server,$errno,$errstr,10240);
					$temp_fileContent = "";
			
			
					fwrite($fp, $param);
					
					while(!feof($fp))
					{
						$temp_fileContent = $temp_fileContent . fgets($fp,10240);
					}
					
					fclose($fp);
					$temp_fileContent = unserialize($temp_fileContent);
					$temp_tweets = $temp_fileContent->tweets;
					print "<li>".$temp_fileContent->name."=>".$temp_fileContent->tweets[(count($temp_tweets)-1)]->tweet."</li>";
					
					
				}
			
			print "</div>";


	}
	

	
?>


</body>
</html>
