<?php
require_once('../../global.php');
require_once('../authenticate.php');
$permissions->authenticateAction(USERS);

$origUser = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : false;

$id = (int) $_POST['id'];
$changePassword = isset($_POST['changePassword']);

$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];
$email    = Filter::filterStrong($_POST['email']);
$phone    = Filter::filterStrong($_POST['phone']);
$name     = Filter::filterStrong($_POST['name']);
$surname  = Filter::filterStrong($_POST['surname']);
$address1 = Filter::filterStrong($_POST['address1']);
$address2 = Filter::filterStrong($_POST['address2']);
$city     = Filter::filterStrong($_POST['city']);
$allowedGroups = isset($_POST['allowedGroups']) ? $_POST['allowedGroups'] : array();

$phoneFiltered = Format::dbPhone($_POST['phone']);

$db = new Model("do/admin/doUpdateUser");

if(!Validate::email($email))
    Reporting::setFieldError("email", "Invalid email address");
if(!Validate::phone($phoneFiltered))
    Reporting::setFieldError("phone", "Invalid phone number");

if($id)
{
    if($changePassword)
    {
        if(!Validate::password($password))
            Reporting::setFieldError("password", "Must be at least 8 characters");
        if($password != $passwordConfirm)
            Reporting::setError("Passwords do not match");
    }
}
else
{
    $username = $_POST['username'];
    if(!Validate::password($password))
        Reporting::setFieldError("password", "Must be at least 8 characters");
    if($password != $passwordConfirm)
        Reporting::setError("Passwords do not match");

    if(!Validate::username($username))
        Reporting::setFieldError("username", "Invalid username");
    else
    {
        if($db->queryColumn("username.sql", $username))
            Reporting::setFieldError("username", "Username is already taken");
    }
}

if(!Reporting::hasAnyErrors())
{
    if($id)
    {
        $db->query("deleteGroupsToUser.sql", $id);

        foreach($allowedGroups as $allowedGroup)
            $db->query("insertGroupsToUser.sql", $allowedGroup, $id);


        $user = new User($id);
        if($changePassword)
            $user->password = $db->getPassword($password, $db->getSalt());

        $user->name     = $name;
        $user->surname  = $surname;
        $user->email    = $email;
        $user->phone    = $phone;
        $user->address1 = $address1;
        $user->address2 = $address2;
        $user->city     = $city;

        $user->update();

        Reporting::setSuccess("Update completed successfully.");
        Reporting::setRedirect(PATH."admin/users.php");
    }
    else
    {
        if($id = $db->query("insert.sql", $username, $db->getPassword($password, $db->getSalt()), $email, $name, $surname, $phone, $address1, $address2, $city))
        {
            foreach($allowedGroups as $allowedGroup)
                $db->query("insertGroupsToUser.sql", $allowedGroup, $id);
            Reporting::setSuccess("Registration completed successfully.");
            Reporting::setRedirect(PATH."admin/users.php");
        }
        else
            Reporting::setError("Something went wrong!  Please try again.");
    }
}

$_SESSION['user'] = serialize($origUser);

Reporting::endDo();
?>
