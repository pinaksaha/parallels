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
		$userContent = "";

	$server = "tcp://172.16.239.128:3000";
	$param = "/GET/".$user."/".$hash;

	$fp = stream_socket_client($server, $errno, $errstr, 10240);

	fwrite($fp, $param);

	while(!feof($fp))
	{
		$userContent = $userContent . fgets($fp, 10240);
	}
	fclose($fp);


	
	$userContent = unserialize($userContent);

	$userContent = json_encode($userContent);
	$userContent = json_decode($userContent,true);

	//print"<pre>";
	//print_r($userContent);
	//print "</pre>";

	if($user == $userContent[userName])
	{
		if($hash == $userContent[pass])
		{
			session_start();
			$_SESSION['user'] = $userContent[userName];
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


	//De serialize the object

	//check the if the the hash matches

	// if the has matches start session

	// redirect to welcome view

?>