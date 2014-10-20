<div id="sign-in"> 
        <?php
        	ViewHelper::printError('login');
            ViewHelper::printMessages("resetpassword");
        ?>
		<form method="POST" action="/user/login<?php if ($target !== '') echo '/?target='.$target; ?>" id="form-login">
			 <b>User</b><br><input type="text" name="username" size="50%"><br> 
			 <b>Password</b><br><input type="password" name="password" size="50%"><br> 
			 <div id="login-fields" >
				 <a href="/User/ForgotPassword">Forgotten your password?</a>
				 <a href="/User/CreateUser/">Create new user</a>
				 <input id="button" type="submit" name="submit" value="Log-In"> 
			</div>
		 </form> 	
 </div>