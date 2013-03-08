<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome This is twitter</title>
<script>
	function validate()
	{
		if(document.register.password.value != document.register.re_password.value)
		{
			alert('Password didnt match');
			return false;
		}
		else 
		{
			document.register.submit();

			return true;
		}
	}
</script>
</head>
<body>
		<div id="top-navbar">
			<h1> Welcome Twitter 0.0.3 </h1>
      			<form name="login" action="./control/auth.php" method="post">
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

		<div id="registration">
			
			 <form name="register" action="./control/register.php" method="post">
                                <fieldset >
                                <legend>Register Today:</legend>
                                <label for='username' >UserName:</label>
                                <input type='text' name='username' id='username' />
                                <label for='password'>Password:</label>
                                <input type='password' name='password' id='password' />
                                <label for='re_password' id='re_password'>Re-type Password: </label>
                                <input type="password" name='re_password' id='re_password' />
                                <input type="button" onclick="return validate()" value="Submit">
                                </fieldset>
                        </form>
		</div> 
</body>

</html>
