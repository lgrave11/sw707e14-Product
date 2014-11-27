<?php
	ViewHelper::printError('addRemove');
	ViewHelper::printSuccess('addRemove');
?>


<div>

<div><form action="/Admin/AddNewUserForm/" method="post">
    <fieldset>
        <legend><b>Add user</b></legend>
        <ul>
            <li><label for="usernameInput">User: </label><input type="text" name="username" id="usernameInput"></li>
            <li><label for="passwordInput">Password: </label> <input type="password" name="password" id="passwordInput"></li>
            <li><label for="confirmPasswordInput">Confirm Password: </label> <input type="password" name="passwordconfirm" id="passwordConfirmInput"></li>
            <li><label for="emailInput">Email: </label><input type="text" name="email" id="emailInput"></li>
            <li><label for="phoneInput">Phone: </label><input type="tel" name="phone" id="phoneInput"></li>
            <li><label for="roleSelect">Role: </label>
                <select type="text" name="role" id="roleInput">
                    <option value="user">User</option> 
                    <option value="admin">Admin</option>
                </select>
            </li>
        </ul>
        <input class="button" id="button" type="submit" name="addUserBtnSubmit" value="Submit">
    </fieldset>
</form></div>

<div><form action="/Admin/RemoveUserForm/" method="post">
    <fieldset>
    <legend><b>Remove user</b></legend>
    <ul>
    <li>
        <label for="removeUserSelectInput">User: </label>
        <select type="text" name="users" id="removeUserSelectInput">
        <?php
        foreach($allAccounts as $a) 
        {
            echo ViewHelper::generateHTMLSelectOption($a);
        }
        ?>
        </select>
    </li>
    </ul>
    <input class="button" id="button" type="submit" name="removeUserBtnSubmit" value="Submit"> 
    </fieldset>
</form></div>

<div><form action="/Admin/AddBicycle/" method="post">
    <fieldset>
    <legend><b>Add bicycle</b></legend>
    <input class="button" id="button" type="submit" name="addBicycleBtnSubmit" value="Submit"> 
    </fieldset>
</form></div>

<div><form action="/Admin/RemoveBicycle/" method="post">
    <fieldset>
    <legend><b>Remove bicycle</b></legend>
    <ul>
    <li>
    <label for="removeBicycleSelectInput">Bicycle: </label>
    <select type="text" name="bicycles" id="removeBicycleSelectInput">
        <?php
        foreach($allBicycles as $b) 
        {
            echo ViewHelper::generateHTMLSelectOption($b->bicycle_id);
        }
        ?>
    </select>
    </li>
    </ul>
    <input class="button" id="button" type="submit" name="removeBicycleBtnSubmit" value="Submit"> 
    </fieldset>
</form></div>
<!--
<div><form action="/Admin/AddDock/" method="post">
    <fieldset>
    <legend><b>Add dock</b></legend>
    <ul>
    <li>
    <label for="addDockSelectInput">Station: </label>
    <select type="text" name="docksStation" id="addDockSelectInput">
        <?php
        foreach($allStations as $s) 
        {
            echo ViewHelper::generateHTMLSelectOption($s->name, array('value'=>$s->station_id));
        }
        ?>
    </select>
    </li>
    </ul>
    <input class="button" id="button" type="submit" name="addDockBtnSubmit" value="Submit"> 
    </fieldset>
</form></div>

<div><form action="/Admin/RemoveDock/" method="post">
    <fieldset>
    <legend><b>Remove dock</b></legend>
    <small>Note: Only shows docks with no bicycles in them</small>
    <ul>
    <li>
    <label for="removeDockSelectInput">Dock: </label>
    <select type="text" name="docksRemove" id="removeDockSelectInput">
        <?php
        foreach($allDocks as $d) 
        {
            echo ViewHelper::generateHTMLSelectOption($d->dock_id . ' -> ' . $d->name, array('value'=>$d->dock_id));
        }
        ?>
    </select>
    </li>
    </ul>
    <input class="button" id="button" type="submit" name="removeDockBtnSubmit" value="Submit"> 
    </fieldset>
</form></div>-->


<div><form action="/Admin/AddStation/" method="post">
    <fieldset>
    <legend><b>Add station</b></legend>
    <ul>
    <li><label for="addStationName">Name: </label><input type="text" name="name" id="addStationName"></li>
    <li><label for="addStationLatitude">Latitude: </label><input type="text" name="latitude" id="addStationLatitude"></li>
    <li><label for="addStationLongitude">Longitude: </label><input type="text" name="longitude" id="addStationLongitude"></li>
    <li><label for="addStationIpAdress">IP address: </label><input type="text" name="ipaddress" id="addStationIpAdress"></li>
    </ul>
    <input class="button" id="button" type="submit" name="addStationBtnSubmit" value="Submit"> 
    </fieldset>
</form></div>

<div id="dialog-confirm"></div>
<div><form name="removeStationForm" action="/Admin/RemoveStation/" method="post">
    <fieldset>
    <legend><b>Remove station</b></legend>
    <ul>
    <li>
    <label for="removeDockSelectInput">Station: </label>
    <select type="text" name="stationRemove">
        <?php
        foreach($allStations as $s) 
        {
            echo ViewHelper::generateHTMLSelectOption($s->name, array('value'=>$s->station_id));
        }
        ?>
    </select>
    </li>
    </ul>
    <input class="button" id="button" type="button" name="removeStationBtnSubmit" onclick="fnOpenNormalDialog();" value="Submit"> 
    </fieldset>
</form></div>
</div>