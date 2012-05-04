<?php
require_once('../../global.php');
require_once('../authenticate.php');
$db = new Model("do/admin/doChangePassword");

$passwordOld = $_POST['passwordOld'];
$passwordNew = $_POST['passwordNew'];
$passwordConfirm = $_POST['passwordConfirm'];

$salt = $db->queryColumn("salt.sql", $user->id);
if(!$db->queryColumn("passwordOld.sql", $user->id, $db->getPassword($passwordOld, $salt)))
    Reporting::setFieldError("passwordOld", "Incorrect password");
if(!Validate::password($passwordNew))
    Reporting::setFieldError("passwordNew", "Must be at least 8 characters");
else if($passwordNew != $passwordConfirm)
    Reporting::setFieldError("passwordConfirm", "Passwords do not match");

if(!Reporting::hasAnyErrors())
{
    if($db->query("update.sql", $db->getPassword($passwordNew, $db->getSalt()), $user->id))
        Reporting::setSuccess("Password updated.");
    else
        Reporting::setError("Something went wrong! Please try again.");
}

Reporting::endDo();
?>
