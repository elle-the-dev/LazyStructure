<?php
/**
 * Validator for data types
 *
 * Functions for validating data types
 * @package LazyStructure
 */
class Validate
{
    /**
     * Validate a street address
     *
     * Receives a street address and returns if it passes validity requirements
     *
     * @param string $address the address to validate
     * @param bool $required whether the field is permitted to be blank
     * @return bool true if valid, false if not
     */
    public static function address($address, $required=true)
    {
        return (!$required && empty($address)) || (!empty($address) && preg_match('/[a-zA-Z0-9 \'\.-]+/', $address));
    }

    /**
     * Validate a date of birth
     *
     * Receives a date and verifies it is a valid date of birth
     *
     * @param string $dob the date to validate
     * @param bool $required whether the field is permitted to be blank
     * @return bool true if valid, false if not
     */
    public static function dob($dob, $required=true)
    {
        return (!$required && empty($dob)) || (strtotime($dob) > 0 && strtotime($dob) < time());
    }

    /**
     * Validate a date
     *
     * Receives a date and verifies if it's valid
     *
     * @param string $date the date to validate
     * @param bool $required whether the field is permitted to be blank
     * @return bool true if valid, false if not
     */
    public static function calendarDate($date, $required=true)
    {
        return (!$required && empty($date)) || (strtotime($date) > 0);
    }

    /**
     * Validate an email address
     *
     * Receives an email address and verifies if it's valid.
     *
     * Warning: This uses the filter_var PHP function, which does not meet RFC 5321 standards.
     *
     * @param string $email the email address to validate
     * @param bool $required whether the field is permitted to be blank
     * @return bool true if valid, false if not
     */
    public static function email($email, $required=true)
    {
        return (!$required && empty($email)) || filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Validate a name
     *
     * Receives a person's name and verifies if it's valid
     *
     * @param string $name the name to validate
     * @param bool $required whether the field is permitted to be blank
     * @return bool true if valid, false if not
     */
    public static function name($name, $required=true)
    {
        return (!$required && empty($name)) || preg_match('/[a-zA-Z \'\.-]+/', $name);
    }

    /**
     * Validate a password
     *
     * Receives a password and verifies it meets the minimum security requirements
     *
     * @param string $password the password to validate
     * @param int $minLength the minimum password length
     * @param bool $upper if it must contain an uppercase character
     * @param bool $numeric if it must contain a number
     * @param bool $special if it must contain a special character
     * @return bool true if valid, false if not
     */
    public static function password($password, $minLength=8, $upper=false, $numeric=false, $special=false)
    {
        return strlen($password) >= $minLength
            && (!$upper || preg_match('/[A-Z]/', $password) > 0) // contains an uppercase character
            && (!$numeric || preg_match('/\D/', $password) > 0) // contains a number
            && (!$special || preg_match('/[^a-zA-Z0-9]/', $password) > 0); // contains a non-alphanumeric character
    }

    /**
     * Validate a phone number
     *
     * Receives a US/Canadian phone number and verifies if it's valid
     *
     * @param string $phone the phone number to validate
     * @param bool $required whether the field is permitted to be blank
     * @return bool true if valid, false if not
     */
    public static function phone($phone, $required=true)
    {
        $phone = Filter::stripNonNumeric($phone);
        return (!$required && empty($phone)) || strlen($phone) === 10;
    }

    /**
     * Validate a postal code
     *
     * Receives a postal code and verifies if it's valid
     *
     * @param string $postalCode the postal code to validate
     * @param bool $required whether the field is permitted to be blank
     * @return bool true if valid, false if not
     */
    public static function postalCode($postalCode)
    {
        return preg_match('/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/', $postalCode);
    }

    /**
     * Validate a username
     *
     * Receives a username and verifies if it's valid
     *
     * @param string $username the username to validate
     * @param bool $required whether the field is permitted to be blank
     * @return bool true if valid, false if not
     */
    public static function username($username)
    {
        return !empty($username) && ctype_alnum(str_replace(array('-','_','.'), '', $username));
    }
}
?>
