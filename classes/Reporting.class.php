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
            if(self::hasErrors() || self::hasSuccesses() || self::hasMarkup())
                echo self::getJsonAll();
        }
        else
            header('Location: '.$_SESSION['lastPage']);
    }

    public static function hasErrors()
    {
        return isset($_SESSION['errors'][0]);
    }

    public static function hasSuccesses()
    {
        return isset($_SESSION['successes'][0]);
    }
    
    public static function hasMarkup()
    {
        return isset($_SESSION['markup'][0]);
    }

    public static function setError($message)
    {
        $_SESSION['errors'][] = $message;
    }

    public static function setSuccess($message)
    {
        $_SESSION['successes'][] = $message;
    }

    public static function setMarkup($message)
    {
        $_SESSION['markup'][] = $message;
    }
    
    public static function getJsonErrors($clear=true)
    {
        return self::getJsonMessages('errors', $clear);
    }

    public static function getJsonSuccesses($clear=true)
    {
        return self::getJsonMessages('successes', $clear);
    }

    public static function getJsonMarkup($clear=true)
    {
        return self::getJsonMessages('markup', $clear);
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

    private static function getJsonAll($clear=true)
    {
        $ar = array();
        if(self::hasErrors())
            $ar['errors'] = $_SESSION['errors'];
        if(self::hasSuccesses())
            $ar['successes'] = $_SESSION['successes'];
        if(self::hasMarkup())
            $ar['markup'] = $_SESSION['markup'];
        if($clear)
        {
            unset($_SESSION['errors']);
            unset($_SESSION['successes']);
            unset($_SESSION['markup']);
        }
        return json_encode($ar);
    }

    private static function getJsonMessages($type, $clear)
    {
        $output = json_encode(array($type => $_SESSION[$type]));
        if($clear)
            $_SESSION[$type] = array();
        return $output;
    }
}
?>

