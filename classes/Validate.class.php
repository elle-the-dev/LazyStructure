<?php
class Validate
{
    public static function address($address, $required=true)
    {
        return (!$required && empty($address)) || (!empty($address) && preg_match('/[a-zA-Z0-9 \'\.-]+/', $address));
    }

    public static function dob($dob, $required=true)
    {
        return (!$required && empty($dob)) || (strtotime($dob) > 0 && strtotime($dob) < time());
    }

    public static function calendarDate($date, $required=true)
    {
        return (!$required && empty($date)) || (strtotime($date) > 0);
    }

    public static function email($email, $required=true)
    {
        return (!$required && empty($email)) || filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function name($name, $required=true)
    {
        return (!$required && empty($name)) || preg_match('/[a-zA-Z \'\.-]+/', $name);
    }

    public static function password($password)
    {
        return !(strlen($password) < 8);
    }

    public static function phone($phone, $required=true)
    {
        return (!$required && empty($phone)) || strlen($phone) === 10;
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
