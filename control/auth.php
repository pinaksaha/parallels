<?php 

	
	$user = $_REQUEST['username'];
	$pass = $_REQUEST['password'];
	$hash = md5($pass);
	//print $user;
	//print $pass	;
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

	// open the user file
	$dir = "../user/".$user;
	if(!is_dir($dir))
	{
		$error = "Hey Its Free So Why not Sign Up Today?";	
		header("Location: http://localhost/parallels/view/register.php?error=$error");
	}
	
	if(is_dir($dir))
	{
		$fileName = $dir."/".$user.".twitt";
		if(is_file($fileName))
		{
			$handel = fopen($fileName, 'r');
			$user  = file_get_contents($fileName,true);
			$data = unserialize($user);
			
			//var_dump($data);
			//print $data->getHash();
			if($hash == $data->getHash())
			{	
				session_start();
				
				//print "\n\n".$data->getName();
				
				$_SESSION['user'] = $data->getName();
			
				header("Location: ../view/welcome.php");
			}
			
			else
			{
				header("Location: ../view/login.php");
			}
		
		}
		
		else
		{
			
			header("Location: ../view/login.php");
		}
	}
		
	//De serialize the object
	
	//check the if the the hash matches
	
	// if the has matches start session
	
	// redirect to welcome view
	
?>