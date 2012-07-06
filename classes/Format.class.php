<?php
/**
 * Transforms datatypes to and from database formats and user input
 *
 * Handler for transforming datatypes into the appropriate format
 * Methods for formatting for database fields are prefixed with db
 * @package LazyStructure
 */
class Format
{
    /**
     * names method
     *
     * Extracts name and surname from a single string
     * Names are stored in the values passed by reference
     *
     * @param string $fullName full name
     * @param string &$name will store the name
     * @param string &$surname will for the surname
     */
    public static function names($fullName, &$name, &$surname)
    {
        $pieces = explode(' ', $fullName);
        $name = $pieces[0];
        array_shift($pieces);
        $surname = implode($pieces, ' ');
    }

    /**
     * price method
     *
     * Creates the monetary representation from an integer value
     *
     * @param int $price the price
     * @param char $symbol currency symbol
     * @return formatted price string
     */
    public static function price($price, $symbol='$')
    {
        return $symbol.number_format($price / 100, 2);
    }
    

    // functions meant for conversion/formatting before insertion into the database

    /**
     * dbPrice method
     *
     * Transforms a formatted price string into its corresponding int value
     *
     * @param string $price the formatted price to be transformed
     * @return integer price value
     */
    public static function dbPrice($price)
    {
        $pieces = preg_split('/[,\.]/', $price); // separators could be . or ,
        $cents = isset($pieces[1]) ? array_pop($pieces) : "00";
        $cents = sprintf("%02d", round($cents / pow(10,strlen("".$cents)-2)));
        $dollars = $pieces[0];

        return Filter::stripNonNumeric($dollars.$cents);
    }

    /**
     * dbPhone method
     *
     * Transforms a formatted phone string into its corresponding int value
     *
     * @param string $phone the formatted phone number to be transformed
     * @return integer phone value
     */
    public static function dbPhone($phone)
    {
        return Filter::stripNonNumeric($phone);
    }

    /**
     * dbPostalCode
     *
     * Transforms a formatted postal code into its corresponding stored format
     * Format is A0A0A0 with no spaces
     *
     * @param string $postalCode the postal code to be transformed
     * @return formatted postal code in the format A0A0A0 having stripped all whitespace and converted to uppercase
     */
    public static function dbPostalCode($postal_code)
    {
        return strtoupper(Filter::stripNonAlphanumeric($postal_code));
    }

    /**
     * toUrlString
     *
     * Converts a string to a URL slug
     *
     * @param string $str the string to convert
     * @return string formatted for a url
     */
    public static function toUrlString($str)
    {
        $str = strtolower($str);
        $len = strlen($str);
        $newStr = "";
        for($i=0;$i<$len;$i++)
        {
            $ord = ord($str[$i]);
            if(($ord >= 97 && $ord <= 132) || ($ord >= 48 && $ord <= 57))
                $newStr .= $str[$i];
            else if($ord == 32 || $ord == 47 || $ord == 95) //space or fwd-slash or underscore
                $newStr .= '-';
        }
        return $newStr;
    }
}
?>
