<?php
class Format
{
    public static function names($fullName, &$name, &$surname)
    {
        $pieces = explode(' ', $fullName);
        $name = $pieces[0];
        array_shift($pieces);
        $surname = implode($pieces, ' ');
    }

    public static function price($price)
    {
        return '$'.number_format($price / 100, 2);
    }
    
    // functions meant for conversion/formatting before insertion into the database
    public static function dbPrice($price)
    {
        $pieces = preg_split('/[,\.]/', $price);
        $cents = isset($pieces[1]) ? array_pop($pieces) : "00";
        $cents = sprintf("%02d", round($cents / pow(10,strlen("".$cents)-2)));
        $dollars = $pieces[0];

        return Filter::stripNonNumeric($dollars.$cents);
    }

    public static function dbPhone($phone)
    {
        return Filter::stripNonNumeric($phone);
    }

    public static function dbPostalCode($postal_code)
    {
        return strtoupper(Filter::stripNonAlphanumeric($postal_code));
    }
}
?>
