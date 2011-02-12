<?php
/**
 * Processing script handler for messages and form content
 *
 * Used for handling postbacks with error/success messages and redirects
 * @package LazyStructure
 */
class Reporting
{
    public function __construct()
    {

    }

    /**
     * endDo([bool]) processing file handler
     * 
     * Used to end processing scripts.  It will handle the return of JSON data if necessary
     * or redirect header if there was no JSON call
     *
     * @param bool $clear denotes whether to unset success and error messages, and markup
     */
    public static function endDo($clear=true)
    {
        /*
            Setting $clear=false when calling endDo maintains error messages in the session
        */
        if(Database::isAjax())
        {
            if(self::hasRedirect())
                echo self::getJsonAll(false);
            if(self::hasAnyErrors() || self::hasSuccesses() || self::hasMarkup())
                echo self::getJsonAll($clear);
        }
        else
            header('Location: '.$_SESSION['lastPage']);
    }

    /**
     * debugArray(array) return printed array
     * 
     * Used to generate and return print_r output of an array within <pre> tags
     *
     * @param array $ar the array to print
     * @return string
     */
    public static function debugArray($ar)
    {
        ob_start();
        echo '<pre>';
        print_r($ar);
        echo '</pre>';
        return ob_get_clean();
    }

    /**
     * hasErrors() returns true if there are errrors
     *
     * @return bool result of if there are any error messages
     */
    public static function hasErrors()
    {
        return !empty($_SESSION['errors']);
    }

    /**
     * hasSuccesses() returns true if there are successes
     *
     * @return bool result of if there are any success messages
     */
    public static function hasSuccesses()
    {
        return !empty($_SESSION['successes']);
    }

    /**
     * hasFieldErrors() returns true if there are field errors
     *
     * @return bool result of if there are any field-specific error messages
     */
    public static function hasFieldErrors()
    {
        return !empty($_SESSION['fieldErrors']);
    }

    /**
     * hasAnyErrors() returns true if there are any errors
     *
     * @return bool result of if there are any error messages or any field-specific error messages
     */
    public static function hasAnyErrors()
    {
        return self::hasErrors() || self::hasFieldErrors();
    }
    
    /**
     * hasMarkup() returns true if there is markup
     *
     * @return bool result of if there is any markup to return
     */
    public static function hasMarkup()
    {
        return !empty($_SESSION['markup']);
    }

    /**
     * hasRedirect() returns true if a redirect is set
     *
     * @return bool result of if there is a redirect pending
     */
    public static function hasRedirect()
    {
        return isset($_SESSION['redirect']);
    }

    /**
     * setError(string) adds an error to the session
     *
     * Adds an error message to the array of error messages to display
     *
     * @param string $message the text to display in the message
     */
    public static function setError($message)
    {
        $_SESSION['errors'][] = $message;
    }

    /**
     * setSuccess(string) adds a success to the session
     *
     * Adds a success message to the array of success messages to display
     *
     * @param string $message the text to display in the message
     */
    public static function setSuccess($message)
    {
        $_SESSION['successes'][] = $message;
    }

    /**
     * setFieldError(string, string) adds a field error to the session
     *
     * Adds a field-specific error message to the list of field errors to display
     *
     * @param string $id the HTML id attribute of the field that the message is applicable
     * @param string $message the text to display in the message
     */
    public static function setFieldError($id, $message)
    {
        $_SESSION['fieldErrors'][$id] = '<span class="fieldError">'.$message.'</span>';
    }

    /**
     * setMarkup(string) adds markup to the session
     *
     * Adds the passed HTML markup to the list of markup strings to return
     *
     * @param string $markup the HTML markup to add to the array of markup returns
     */
    public static function setMarkup($markup)
    {
        $_SESSION['markup'][] = $markup;
    }

    /**
     * setRedirect(string) adds a redirect to the session
     *
     * Sets the intended redirect path
     *
     * @param string $link the URL path to redirect to
     */
    public static function setRedirect($link)
    {   
        $_SESSION['redirect'] = $link;
    }  

    /**
     * getJsonErrors(bool) returns errors as a JSON string
     *
     * Returns errors in JSON object
     *
     * @param bool $clear indicates whether to unset the errors
     */
    public static function getJsonErrors($clear=true)
    {
        return self::getJsonMessages('errors', $clear);
    }

    /**
     * getJsonSuccesses(bool) returns successes as a JSON string
     *
     * Returns successes in JSON object
     *
     * @param bool $clear indicates whether to unset the successes
     */
    public static function getJsonSuccesses($clear=true)
    {
        return self::getJsonMessages('successes', $clear);
    }

    /**
     * getJsonFieldErrors(bool) returns field errors as a JSON string
     *
     * Returns field errors in JSON object
     *
     * @param bool $clear indicates whether to unset the field errors
     */
    public static function getJsonFieldErrors($clear=true)
    {
        return self::getJsonMessages('fieldErrors', $clear);
    }

    /**
     * getJsonMarkup(bool) returns markup as a JSON string
     *
     * Returns markup in JSON object
     *
     * @param bool $clear indicates whether to unset the markup
     */
    public static function getJsonMarkup($clear=true)
    {
        return self::getJsonMessages('markup', $clear);
    }

    /**
     * getFieldErrors(bool) returns field errors array
     *
     * Returns an array of field errors
     *
     * @param bool $clear indicates whether to unset the field errors
     */
    public static function getFieldErrors($clear=true)
    {
        if(!isset($_SESSION['fieldErrors']))
            return array();

        $fieldErrors = $_SESSION['fieldErrors'];
        if($clear)
            unset($_SESSION['fieldErrors']);
        return $fieldErrors;
    }

    /**
     * showErrors(bool) returns HTML list of errors
     *
     * Returns an unordered HTML list of errors
     *
     * @param bool $clear indicates whether to unset the errors
     */
    public static function showErrors($clear=true)
    {
        return self::showMessages('errors', $clear);
    }

    /**
     * showSuccesses(bool) returns HTML list of successes
     *
     * Returns an unordered HTML list of successes
     *
     * @param bool $clear indicates whether to unset the successes
     */
    public static function showSuccesses($clear=true)
    {
        return self::showMessages('successes', $clear);
    }

    /**
     * showMessages(string, bool) returns HTML list of messages
     *
     * Returns an unordered HTML list of messages
     *
     * @param string $type is the index of the session array that holds the messages
     * @param bool $clear indicates whether to unset the messages
     */
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

    /**
     * getJsonAll(bool) returns session values as a JSON string
     *
     * Returns all set values in a JSON object
     *
     * @param bool $clear indicates whether to unset the values
     */
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
            $ar['redirect'] = array($_SESSION['redirect']); // 2D array avoids a JSON parsing glitch
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

    /**
     * getJsonMessages(string, bool) returns messages as JSON string
     *
     * Returns messages in a JSON object
     *
     * @param string $type is the index of the session array that holds the messages
     * @param bool $clear indicates whether to unset the messages
     */
    private static function getJsonMessages($type, $clear)
    {
        $output = json_encode(array($type => $_SESSION[$type]));
        if($clear)
            $_SESSION[$type] = array();
        return $output;
    }
}
?>
