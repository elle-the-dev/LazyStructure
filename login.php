<?php
require_once('classloader.php');
$out = new PageTemplate();

$out->title = "Login";

$out->body .= <<<OUT
<div id="formClass">
    <form action="{$path}do/doLogin.php" method="post" onsubmit="return formSubmit(this);">
        <table>
            <tr>
                <td>Username</td>
                <td>
                    <input type="text" id="username" name="username" value="" />
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td>
                    <input type="password" id="password" name="password" value="" />
                </td>
            </tr>
            <tr>
                <td>Remember Me</td>
                <td>
                    <input type="checkbox" id="remember" name="remember" checked="checked" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Log In" />
                </td>
            </tr>
        </table>
    </form>
</div>
OUT;

$out->render();
?>
