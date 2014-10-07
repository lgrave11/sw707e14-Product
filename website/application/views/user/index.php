<div id="sign-in"> 
        <?php
        	if(isset($_SESSION['error']))
        	{
            	echo '<div id="errorlogin">'.$_SESSION['error'].'</div>';
            	unset($_SESSION['error']);
            }
        ?>
		<form method="POST" action="/user/login" id="form-login">
			 <b>User</b><br><input type="text" name="username" size="50%"><br> 
			 <b>Password</b><br><input type="password" name="password" size="50%"><br> 
			 <div id="login-fields" >
				 <a href="#">Forgotten your password?</a>
				 <a href="#">Create new user</a>
				 <input id="button" type="submit" name="submit" value="Log-In"> 
			</div>
		 </form> 	
 </div>