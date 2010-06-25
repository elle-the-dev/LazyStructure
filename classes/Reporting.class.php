<?php
class Reporting
{
    public function __construct()
    {

    }

    public static function endDo()
    {
        if(Database::isAjax())
        {
            if(self::hasErrors())
                echo self::getJsonErrors();
            else if(self::hasSuccesses())
                echo self::getJsonSuccesses();
        }
        else
            header('Location: '.$_SESSION['page']);
    }

    public static function hasErrors()
    {
        return isset($_SESSION['errors'][0]);
    }

    public static function hasSuccesses()
    {
        return isset($_SESSION['successes'][0]);
    }

    public static function setError($message)
    {
        $_SESSION['errors'][] = $message;
    }

    public static function setSuccess($message)
    {
        $_SESSION['successes'][] = $message;
    }
    
    public static function getJsonErrors($clear=true)
    {
        return self::getJsonMessages('errors', $clear);
    }

    public static function getJsonSuccesses($clear=true)
    {
        return self::getJsonMessages('successes', $clear);
    }

    public static function showErrors($clear=true)
    {
        return self::showMessages('errors', $clear);
    }

    public static function showSuccesses($clear=true)
    {
        return self::showMessages('successes', $clear);
    }

    private static function showMessages($type, $clear)
    {
        $output = '<ul>';
        foreach($_SESSION[$type] as $val)
            $output .= "<li>$val</li>";
        $output .= '</ul>';
        if($clear)
            $_SESSION[$type] = array();
        return $output;
    }

    private static function getJsonMessages($type, $clear)
    {
        $output = json_encode(array($type => $_SESSION[$type]));
        if($clear)
            $_SESSION[$type] = array();
        return $output;
    }
}
