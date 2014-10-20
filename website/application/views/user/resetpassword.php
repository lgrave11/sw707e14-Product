<div id="forgot-password">
    <?php ViewHelper::printMessages("resetpassword"); ?>
    <p>Reset your password.</p>
    <form method="POST" action="/User/ResetPasswordForm" id="form-forgot-password">
        <b>Password</b><br><input type="password" name="password" size="50%"><br>
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <input type="hidden" name="reset_time" value="<?php echo time(); ?>">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input id="button" type="submit" name="submit" value="Submit">
    </form>
</div>