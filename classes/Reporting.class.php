<?php
class Reporting
{
    public function __construct()
    {

    }

    public static function endDo($clear=true)
    {
        /*
            Setting $clear=false when calling endDo maintains error messages in the session
            This allows for setting an error or success message alongside a redirect
        */
        if(Database::isAjax())
        {
            if(self::hasAnyErrors() || self::hasSuccesses() || self::hasMarkup() || self::hasRedirect())
                echo self::getJsonAll($clear);
        }
        else
            header('Location: '.$_SESSION['lastPage']);
    }

    public static function debugArray($ar)
    {
        ob_start();
        echo '<pre>';
        print_r($ar);
        echo '</pre>';
        return ob_get_clean();
    }

    public static function hasErrors()
    {
        return isset($_SESSION['errors'][0]);
    }

    public static function hasSuccesses()
    {
        return isset($_SESSION['successes'][0]);
    }

    public static function hasFieldErrors()
    {
        return isset($_SESSION['fieldErrors']);
    }

    public static function hasAnyErrors()
    {
        return self::hasErrors() || self::hasFieldErrors();
    }
    
    public static function hasMarkup()
    {
        return isset($_SESSION['markup'][0]);
    }

    public static function hasRedirect()
    {
        return isset($_SESSION['redirect']);
    }

    public static function setError($message)
    {
        $_SESSION['errors'][] = $message;
    }

    public static function setSuccess($message)
    {
        $_SESSION['successes'][] = $message;
    }

    public static function setFieldError($name, $message)
    {
        $_SESSION['fieldErrors'][$name] = '<span class="fieldError">'.$message.'</span>';
    }

    public static function setMarkup($message)
    {
        $_SESSION['markup'][] = $message;
    }

    public static function setRedirect($link)
    {   
        $_SESSION['redirect'] = $link;
    }  

    public static function getJsonErrors($clear=true)
    {
        return self::getJsonMessages('errors', $clear);
    }

    public static function getJsonSuccesses($clear=true)
    {
        return self::getJsonMessages('successes', $clear);
    }

    public static function getJsonFieldErrors($clear=true)
    {
        return self::getJsonMessages('fieldErrors', $clear);
    }

    public static function getJsonMarkup($clear=true)
    {
        return self::getJsonMessages('markup', $clear);
    }

    public static function getFieldErrors($clear=true)
    {
        if(!isset($_SESSION['fieldErrors']))
            return array();

        $fieldErrors = $_SESSION['fieldErrors'];
        if($clear)
            unset($_SESSION['fieldErrors']);
        return $fieldErrors;
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
        $output = "";
        if(isset($_SESSION[$type]))
        {
            $output = '<ul>';
            foreach($_SESSION[$type] as $val)
                $output .= "<li>$val</li>";
            $output .= '</ul>';
            if($clear)
                $_SESSION[$type] = array();
        }
        return $output;
    }

    private static function getJsonAll($clear=true)
    {
        $ar = array();
        if(self::hasErrors())
            $ar['errors'] = $_SESSION['errors'];
        if(self::hasSuccesses())
            $ar['successes'] = $_SESSION['successes'];
        if(self::hasFieldErrors())
            $ar['fieldErrors'] = $_SESSION['fieldErrors'];
        if(self::hasMarkup())
            $ar['markup'] = $_SESSION['markup'];
        if(self::hasRedirect())
            $ar['redirect'] = $_SESSION['redirect'];
        if($clear)
        {
            unset($_SESSION['errors']);
            unset($_SESSION['successes']);
            unset($_SESSION['fieldErrors']);
            unset($_SESSION['markup']);
        }

        /*
            Need to unset redirect as it if stays set, PageTemplate will redirect
            via header after it already redirected via JavaScript on an AJAX post
        */
        unset($_SESSION['redirect']);
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
