<div id="sign-in"> 
        <?php
        	ViewHelper::printError('createuser');
        ?>
		<form method="POST" action="/User/CreateUser" id="form-create">
			 <b>User</b><br><input type="text" name="username" size="50%"><br> 
			 <b>Password</b><br><input type="password" name="password" size="50%"><br> 
			 <b>Confirm Password</b><br><input type="password" name="passwordconfirm" size="50%"><br>
			 <b>Email</b><br><input type="text" name="email" size="50%"><br>
			 <b>Phone</b><br><input type="tel" name="phone" size="50%"><br>

			 <div id="create-fields" >
				 <input id="button" type="submit" name="submit" value="Create User"> 
			</div>
		 </form> 	
</div>