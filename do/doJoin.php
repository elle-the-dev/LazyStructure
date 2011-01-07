<?php
require_once('../global.php');

$username = $_POST['username'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];
$email    = Filter::filterStrong($_POST['email']);
$phone    = Filter::filterStrong($_POST['phone']);
$name     = Filter::filterStrong($_POST['name']);
$surname  = Filter::filterStrong($_POST['surname']);
$address1 = Filter::filterStrong($_POST['address1']);
$address2 = Filter::filterStrong($_POST['address2']);

$phoneFiltered = preg_replace('/\D/', '', $_POST['phone']);

$db->init("do/doJoin");

if(!Validate::username($username))
    Reporting::setFieldError("username", "Invalid username");
else
{
    if($db->queryColumn("username.sql", $username))
        Reporting::setFieldError("username", "Username is already taken");
}
if(!Validate::password($password))
    Reporting::setFieldError("password", "Must be at least 8 characters");
if($password != $passwordConfirm)
    Reporting::setError("Passwords do not match");
if(!Validate::email($email))
    Reporting::setFieldError("email", "Invalid email address");
if(!Validate::phone($phoneFiltered))
    Reporting::setFieldError("phone", "Invalid phone number");

if(!Reporting::hasAnyErrors())
{
    $id = $db->query("insert.sql", $username, $db->getPassword($password, $db->getSalt()), $email, $name, $surname, $phone, $address1, $address2);
    if($id)
    {
        $user = new User($id);
        Reporting::setSuccess("Registration completed successfully.");
    }
    else
        Reporting::setError("Something went wrong!  Please try again.");
}

Reporting::endDo();
?>
