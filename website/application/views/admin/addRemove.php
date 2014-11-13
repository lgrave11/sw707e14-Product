<?php
	ViewHelper::printError('addRemove');
	ViewHelper::printSuccess('addRemove');
?>

<div id="admin-actions-left">
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
</div>

<div id="admin-actions-right">
    <div id="addbicycle" class="admin-action">
        <form action="/Admin/AddBicycle/" method="post">
            <h2>Add a new Bicycle</h2>
            <div id="create-fields" >
                 <input id="button" type="submit" name="submit" value="Create Bicycle"> 
            </div>
        </form>
    </div>

    <div id="removebicycle" class="admin-action">
        <form action="/Admin/RemoveBicycle/" method="post">
            <h2>Remove a bicycle</h2>
            <select type="text" name="bicycles">
            <?php
            foreach($allBicycles as $b) 
            {
                echo ViewHelper::generateHTMLSelectOption($b->bicycle_id);
            }
            ?>
            </select>

            <div id="create-fields" >
                 <input id="button" type="submit" name="submit" value="Remove Bicycle"> 
            </div>
        </form>

    </div>
    
    <div id="adddock" class="admin-action">
        <form action="/Admin/AddDock/" method="post">
            <h2>Add a new Dock</h2>
            <b>Select station</b>
            <select type="text" name="docksStation">
            <?php
            foreach($allStations as $s) 
            {
                echo ViewHelper::generateHTMLSelectOption($s->name, array('value'=>$s->station_id));
            }
            ?>
            </select>
            <div id="create-fields" >
                 <input id="button" type="submit" name="submit" value="Create Dock"> 
            </div>
        </form>
    </div>

    <div id="removedock" class="admin-action">
        <form action="/Admin/RemoveDock/" method="post">
            <h2>Remove a Dock</h2>
            <select type="text" name="docksRemove">
            <?php
            foreach($allDocks as $d) 
            {
                echo ViewHelper::generateHTMLSelectOption($d->dock_id . ' -> ' . $d->name, array('value'=>$d->dock_id));
            }
            ?>
            </select>

            <div id="create-fields" >
                 <input id="button" type="submit" name="submit" value="Remove Dock"> 
            </div>
        </form>

    </div>
</div>
