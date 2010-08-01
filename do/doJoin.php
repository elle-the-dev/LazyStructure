<?php
require_once('../classloader.php');

$username = $_POST['username'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];
$email    = $_POST['email'];
$phone    = $_POST['phone'];
$name     = $_POST['name'];
$surname  = $_POST['surname'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];

$phoneFiltered = preg_replace('/\D/', '', $_POST['phone']);

if(empty($username))
    Reporting::setFieldError("username", "Required");
else
{
    $exists = $db->queryColumn("SELECT 1 FROM users WHERE LCASE(username) = LCASE(?)", $username);
    if($exists)
        Reporting::setFieldError("username", "Username is already taken");
}
if(strlen($password) < 8)
    Reporting::setFieldError("password", "Must be at least 8 characters");
if($password != $passwordConfirm)
    Reporting::setError("Passwords do not match");
if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    Reporting::setFieldError("email", "Invalid email address");
if(!empty($phone) && strlen($phoneFiltered) != 10)
    Reporting::setFieldError("phone", "Invalid phone number");

if(!Reporting::hasErrors() && !Reporting::hasFieldErrors())
{
    $id = $db->query("INSERT INTO users (username, password, email, name, surname, phone, address1, address2) VALUES(?, ?, ?, ?, ?, ?, ?, ?)", $username, $db->getHash($password), $email, $name, $surname, $phone, $address1, $address2);
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
