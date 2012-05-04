<?php
/**
 * Sanitization for markup and text
 *
 * Handler for stripping and santitizing values
 * @package LazyStructure
 */
class Filter
{
    /**
     * toXhtml parses and formats into valid XHTML
     *
     * Takes the given HTML and uses tidy to convert it to valid XHTML Strict
     *
     * @param string $html the HTML to be parsed
     * @return transformed XHTML Strict mark-up
     */
    public static function toXhtml($html)
    {
        return tidy_repair_string($html, array('output-xhtml' => true, 'show-body-only' => true, 'doctype' => 'strict', 'drop-font-tags' => true, 'drop-proprietary-attributes' => true, 'lower-literals' => true, 'quote-ampersand' => true, 'wrap' => 0), 'raw');
    }

    /**
     * filterXML converts invalid XML characters
     *
     * Takes the given XML and converts invalid characters to their corresponding numeric HTML entity values
     *
     * @param string $text the XML to be parsed
     * @return transformed XML text
     */
    public static function filterXML($text)
    {
        return self::htmlnumericentities(html_entity_decode($text));
    }

    /**
     * htmlnumericentities converts characters to numeric HTML entities
     *
     * Takes the given string and converts the appropriate characters to their corresponding numeric HTML entity values
     *
     * @param string $str the string to be parsed
     * @return transformed text
     */
    public static function htmlnumericentities($str)
    {
        return preg_replace('/[^!-%\x27-;=?-~ ]/e', '"&#".ord("$0").chr(59)', $str);
    }

    /**
     * filterStrong sanitizes text for output
     *
     * Removes all tags and converts to HTML entities in order to sanitize the provided string
     * 
     * @param string $text the string to be sanitized
     * @return sanitized text
     */
    public static function filterStrong($text)
    {
        return htmlentities(strip_tags($text));
    }

    /**
     * stripNonNumeric removes all characters that aren't 0-9
     *
     * @param string $str the string to filter
     * @return string $str the filtered string
     */
    public static function stripNonNumeric($str)
    {  
        return preg_replace('/\D/', '', $str);
    }  

    /**
     * stripNonAlphaNumeric removes all characters that aren't alphabetical or numeric
     *
     * @param string $str the string to filter
     * @return string $str the filtered string
     */
    public static function stripNonAlphaNumeric($str)
    {  
        return preg_replace('/[^a-zA-Z0-9]/', '', $str);
    } 

}
?>
