<html>
<head>
<meta charset="utf-8">
<title>Welcome This is twitter</title>
</head>
<body>
<?php session_destroy(); ?>
		<div id="top-navbar">
			<h1> Login</h1>
      			<form name="login" action="../control/auth.php" method="post">
					<fieldset >
					<legend>Login</legend>
					<label for='username' >UserName:</label>
					<input type='text' name='username' id='username' />
					<label for='password'>Password:</label>
					<input type='password' name='password' id='password' />
					<input type='submit' name='Submit' value='Login' />
					</fieldset>
                </form>	
		</div>
</body>
</html>