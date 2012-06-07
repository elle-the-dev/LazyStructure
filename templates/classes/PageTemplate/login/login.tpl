<div class="login">
    <form method="post" action="<?php echo PATH; ?>do/doLogin.php" onsubmit="return formSubmit(this)">
    <div>
        <input type="text" name="username" placeholder="username" />
        <input type="password" name="password" />
        <input type="hidden" name="remember" value="1" />
        <input type="submit" value="login" />
    </div>
    </form>
</div>
