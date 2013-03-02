<?php 

	session_start();
	
	
	$user = $_SESSION['user'];
	
	if($user == "")
	{
		session_destroy();
		header("Location: ./view/login.php");
	}
	
	else
	{
		$user = $_SESSION['user'];
		
		print "<h1>Welcome ". $user ." </h1>";
		print "<a href='http://localhost/parallels/view/login.php'>Logout</a>";
	}
	
?>