<?php
require_once('classloader.php');

$out = new PageTemplate();
$out->title = "Join";
$out->addStyle("css/join.css");

$fieldErrors = Reporting::getFieldErrors();
$out->body .= <<<OUT
{$print}
<form action="{$path}do/doJoin.php" method="post" onsubmit="return formSubmit(this);">
    <table id="join">
        <tr>
            <td>Username:</td>
            <td>
                <input type="text" name="username" id="username" maxlength="20" />{$fieldErrors['username']}
            </td>
        </tr>
        <tr>
            <td>Password:</td>
            <td>
                <input type="password" name="password" id="password" />{$fieldErrors['password']}
            </td>
        </tr>
        <tr>
            <td>Confirm Password:</td>
            <td>
                <input type="password" name="passwordConfirm" id="passwordConfirm" />{$fieldErrors['passwordConfirm']}
            </td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>
                <input type="text" name="email" id="email" maxlength="100" />{$fieldErrors['email']}
            </td>
        </tr>
        <tr>
            <td>Name:</td>
            <td>
                <input type="text" name="name" id="name" maxlength="30" />{$fieldErrors['name']}
            </td>
        </tr>
        <tr>
            <td>Surname:</td>
            <td>
                <input type="text" name="surname" id="surname" maxlength="30" />{$fieldErrors['surname']}
            </td>
        </tr>
        <tr>
            <td>Phone:</td>
            <td>
                <input type="text" name="phone" id="phone" />{$fieldErrors['phone']}
            </td>
        </tr>
        <tr>
            <td rowspan="2">Address:</td>
            <td>
                <input type="text" name="address1" maxlength="100" />{$fieldErrors['address1']}
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="address2" maxlength="100" />{$fieldErrors['address2']}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Submit" />
            </td>
        </tr>
    </table>
</form>
OUT;

$out->render();
?>
