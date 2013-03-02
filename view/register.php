<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Register Today</title>
</head>

<body>

			<div id="registration">
			<?php 
				
					$error = $_REQUEST['error'];
					
					print "<h1>".$error."</h1>";
			?>
			 <form name="register" action="../control/register.php" method="post">
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
