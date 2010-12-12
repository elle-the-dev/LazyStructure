<?php
class Validate
{
    public static function email($email)
    {
        return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function password($password)
    {
        return !(strlen($password) < 8);
    }

    public static function phone($phone)
    {
        return strlen($phone) === 10;
    }

    public static function postal_code($postal_code)
    {
        return preg_match('/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/', $postal_code);
    }

    public static function username($username)
    {
        return !empty($username) && ctype_alnum(str_replace(array('-','_','.'), '', $username));
    }
}
?>
