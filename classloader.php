<?php
/*
Error reporting set to show notices, warnings and errors
Set to E_NONE to disable
*/
error_reporting(E_ALL);

/*
Sets php.ini settings to temporarily display errors
Set to 0 to hide errors (do this before publishing live)
*/
ini_set('display_errors', 0);

session_start();

/*
Instantiating the database will make it available
just by including the classloader file.
The database uses a singleton pattern such that multiple
MySQL connections are not created, so this is not a performance issue
*/
$db = Database::getDatabase();

new Globals();
$path = PATH;

isset($_SESSION['user']) ? $user = unserialize($_SESSION['user']) : $user = false;

function __autoload($classname)
{
    /*
        The autoload magic function makes all classes fitting the pattern
        available automatically upon use.  This means you do not have to
        require the class file before using it.
    */
    require_once("classes/$classname.class.php");
}
?>
