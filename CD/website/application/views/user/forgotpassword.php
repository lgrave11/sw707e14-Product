<div id="forgot-password">
    <?php ViewHelper::printMessages("resetpassword"); ?>
    <p>Forgot your password? Submit your e-mail.</p>
    <form method="POST" action="/User/ForgotPasswordForm" id="form-forgot-password">
        <b>E-Mail</b><br><input type="text" name="email" size="50%"><br>
        <input id="button" type="submit" name="submit" value="Submit">
    </form>
</div>