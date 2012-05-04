<div id="errors" class="errors"></div>
<div id="successes" class="successes"></div>
<form method="post" action="<?php echo PATH; ?>do/doForgotPassword.php" onsubmit="return formSubmit(this)">
<p>Enter your email address and you'll receive an email containing a link to reset your password.</p>
<p>
    Email: <input type="text" name="email" id="email" />
    <input type="submit" value="Submit" />
</p>
</form>
