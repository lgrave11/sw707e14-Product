<?php
	ViewHelper::printError('addRemove');
	ViewHelper::printSuccess('addRemove');
?>
<div id="adduser" class="admin-action">
    <form action="/Admin/AddNewUserForm/" method="post">
        <h2>Add a new user</h2>
        <b>User</b><br><input type="text" name="username" size="50%"><br> 
        <b>Password</b><br><input type="password" name="password" size="50%"><br> 
        <b>Confirm Password</b><br><input type="password" name="passwordconfirm" size="50%"><br>
        <b>Email</b><br><input type="text" name="email" size="50%"><br>
        <b>Phone</b><br><input type="tel" name="phone" size="50%"><br>
        <b>Role</b><br>
        <select type="text" name="role">
        <option value="user">User</option> 
        <option value="admin">Admin</option>
        </select>

        <div id="create-fields" >
             <input id="button" type="submit" name="submit" value="Create User"> 
        </div>
    </form>

</div>

<div id="removeuser" class="admin-action">
    <form action="/Admin/RemoveUserForm/" method="post">
        <h2>Remove a user</h2>
        <select type="text" name="users">
        <?php
        foreach($allAccounts as $a) 
        {
            echo ViewHelper::generateHTMLSelectOption($a);
        }
        ?>
        </select>

        <div id="create-fields" >
             <input id="button" type="submit" name="submit" value="Remove User"> 
        </div>
    </form>

</div>