<?php
require_once('../global.php');

$email = $_POST['email'];

$db = new Model("do/doForgotPassword");
if($row = $db->queryRow("select.sql", array('email' => $email)))
{
    if(time() - $row['reset_time'] > 14400)
    {
        Mailer::sendResetPassword($row['username'], $email);
        Reporting::setSuccess("An email has been sent to your email address containing a link to reset your password.");
    }
    else
        Reporting::setError("You may only reset your password once every 4 hours");
}
else
{
    Reporting::setError("Email address unknown.");
}
Reporting::endDo();
?>
