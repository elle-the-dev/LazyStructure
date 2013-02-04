<?php
/*
    Error reporting set to show notices, warnings and errors
    Set to E_NONE to disable
*/
error_reporting(E_ALL^E_NOTICE);

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

// Initializes global constants
new Globals();

/*
    Model extends Database, allowing the query functions instead to accept
    filename parameters for SQL files.  Functions are still otherwise the
    same as Database. Each PHP should call Model->init("page") before
    calling any queries.
*/
$db = new Model("global");


/*
    Catches any PHP errors and converts them into LazyStructure errors
    This prevents syntax errors from preventing AJAX pageloads from completing;
    Instead, they appear as an error message when the page loads.
*/
set_error_handler(function($errno, $errstr, $errfile, $errline, $errcontext)
{
    //Reporting::setError("<span class=\"errorLine\">Line $errline:</span> $errstr\n<br />$errfile"); 
    $_SESSION['phpErrors'] = "<span class=\"errorLine\">Line $errline:</span> $errstr\n<br />$errfile" .
    getErrorHtml($errfile, $errline);
    $backtraces = debug_backtrace(0);

/*
    foreach($backtraces as $backtrace)
    {
        if($backtrace['file'] != $errfile || $backtrace['line'] != $errline)
        {
            //$_SESSION['phpErrors'] .= "Line {$backtrace['line']} in {$backtrace['file']}" . 
            //getErrorHtml($backtrace['file'], $backtrace['line']);
        }
    }
*/
    if(Reporting::isAjax())
    {
        //die("ISAJAX");
        Reporting::setError($_SESSION['phpErrors']);
        Reporting::endDo();
        die();
    }
    else
    {
        echo $_SESSION['phpErrors'];
        die();
    }
    return true;
}, E_ALL);

function getErrorHtml($errfile, $errline)
{
    ob_start();
        highlight_string("\r".file_get_contents($errfile)."\r");
    $code = ob_get_clean();
    $lines = explode("<br />", $code);
    array_shift($lines);
    array_pop($lines);
    $startLine = $errline - ceil(ERROR_LINES / 2);
    $lines = array_slice($lines, $startLine > 0 ? $startLine : 0, ERROR_LINES);
    ob_start();
    echo '<pre>';
    foreach($lines as $key => $line)
    {
        $lineNumber = $key + $errline - (ceil(ERROR_LINES / 2) - 2);
        if($lineNumber == $errline)
        {
            echo '<div class="errorLine" style="background-color: #FFBBCC">';
        }
        echo "<span style='color: #000'>$lineNumber</span>".' '.$line;
        if($lineNumber == $errline)
        {
            echo '</div>';
        }
        echo "\n";
    }
    echo '</pre>';
    $errorOutput = ob_get_clean();
    return $errorOutput;
}

function shutdown()
{
/*
    if(isset($_SESSION['phpErrors']))
    {
        echo $_SESSION['phpErrors'];
        unset($_SESSION['phpErrors']);
        die;
    }
    else
        echo ob_get_clean();
*/
}

register_shutdown_function('shutdown');

// Make the user object immediately available
$user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : false;

// Create global constants for each action
$actions = $db->queryKeyRow("key", "selectActions.sql");
foreach($actions as $key => $val)
    define($key, $val);

//$user = false;
//print_r($user->groups);

unset($_SESSION['permissions']);
if(!isset($_SESSION['permissions']))
{
    $_SESSION['permissions'] = serialize(new Permissions($user ? $user->groups : array(GROUP_GUEST)));
}
$permissions = unserialize($_SESSION['permissions']);

// Reporting::setError(Reporting::debugArray($permissions->pages));

// Reporting::setError(Reporting::debugArray($_SESSION));

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
