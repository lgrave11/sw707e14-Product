<div>
	<center>
		<h1><?php echo $username;?></h1>
	</center>
	<center>
		<div id="changepass">
			<form action="/user/changepassword" method="post">
				<table>
					<tr>
						<td>
							<p> Current Password</p>
						</td>
						<td>
							<input class="padding-field" type="password" name="currpass"/> <br/>
						</td>
					</tr>
					<tr>
						<td>
							<p> New Password</p>
						</td>
						<td>
							<input class="padding-field" type="password" name="newpass1"/> <br/>
						</td>
					</tr>
					<tr>
						<td>
							<p> Repeat New Password</p>
						</td>
						<td>
							<input class="padding-field" type="password" name="newpass2"/> <br/>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<center>
							<input type="submit" class="button" value="Change Password"/> <br/>
							</center>
						</td>
					</tr>			
				</table>
			</form>
		</div>
	</center>
	<center>
		<div id="changeother">
			<form action="/User/ChangeAccountInfo" method="post">
				<table>
					<tr>
						<td>
							<p> Email</p>
						</td>
						<td>
							<input class="padding-field" type="text" name="email" value="<?php echo $email; ?>"/> <br/>
						</td>
					</tr>
					<tr>
						<td>
							<p> Phone Number</p>
						</td>
						<td>
							<input class="padding-field" type="text" name="phone" value="<?php echo $phone;?>"/> <br/>
						</td>
					</tr>
					<tr>
						<td>
							<p>&nbsp;</p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<center>
								<input type="submit" class="button" value="Update Profile Data"/> <br/>
							</center>
						</td>
					</tr>			
				</table>
			</form>
		</div>
	</center>
	<br/>
	<p>&nbsp;</p>
	<center>
	    <div>
	        <?php ViewHelper::printMessages('changepassword');
	              ViewHelper::printMessages('accountinfo'); ?>
	    </div>
		<div>
			<input type="button" style="font-size:20px;" class="button" value="View History" onclick="navigateTo('/User/ViewHistory')" /> <br/>
		</div>
	</center>
</div>
