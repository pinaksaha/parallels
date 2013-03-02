<?php 
	class tweetUser
	{
		public $userName;
		public $pass;
		public $tweets; //array containing tweets
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
			mkdir($dir,0777);
		
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
	