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
ini_set('display_errors', 1);

/*
    Since global.php should be included on every page,
    this is the only place that session_start() should appear
*/
session_start();

/*
    Model extends Database, allowing the query functions instead to accept
    filename parameters for SQL files.  Functions are still otherwise the
    same as Database. Each PHP should call Model->init("page") before
    calling any queries.
*/
$db = Model::getModel();

// Initializes global constants
new Globals();

// Make the user object immediately available
$user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : false;

/*
    Catches any PHP errors and converts them into LazyStructure errors
    This prevents syntax errors from preventing AJAX pageloads from completing;
    Instead, they appear as an error message when the page loads.
*/
set_error_handler(function($errno, $errstr, $errfile, $errline, $errcontext)
{
   Reporting::setError("Line $errline: $errstr\n<br />$errfile"); 
   return true;
}, E_ALL);

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
