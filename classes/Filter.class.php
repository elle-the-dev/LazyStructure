<?php
class Filter
{
    public static function toXhtml($html)
    {
        return tidy_repair_string($html, array('output-xhtml' => true, 'show-body-only' => true, 'doctype' => 'strict', 'drop-font-tags' => true, 'drop-proprietary-attributes' => true, 'lower-literals' => true, 'quote-ampersand' => true, 'wrap' => 0), 'raw');
    }

    public static function filterXML($text)
    {
        return self::htmlnumericentities(html_entity_decode($text));
    }

    public static function htmlnumericentities($str)
    {
        return preg_replace('/[^!-%\x27-;=?-~ ]/e', '"&#".ord("$0").chr(59)', $str);
    }
}
?>
