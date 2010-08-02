<?php
class Filter
{
    public function __construct()
    {

    }

    public static function filterEmail($text)
    {
        return strip_tags(nl2br(stripslashes($text)));
    }

    public static function filterStrong($text)
    {
        return strip_tags(stripslashes($text));
    }

    public static function filterText($text, $breaks=true)
    {
        $newText = $text;
        $newText = str_replace('&nbsp;', ' ', $newText);
        $newText = self::filterHtml($newText);
        if($breaks)
            $newText = nl2br($newText);
        $newText = str_replace('  ', "&nbsp;&nbsp;", $newText);
        $newText = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $newText);
        //$newText = kses($newText, $allowed, array('http', 'https'));

        $newText = $newText;
        return $newText;
    }

    public static function filterHtml($text)
    {
        $text = stripslashes($text);

        if(is_dir('../htmlpurifier'))
            require_once('../htmlpurifier/library/HTMLPurifier.auto.php');
        else
            require_once('htmlpurifier/library/HTMLPurifier.auto.php');

        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.DefinitionID', 'stupidFixForTargetLinks');

        // configuration goes here:
        $config->set('Core.Encoding', 'UTF-8'); // replace with your encoding
        $config->set('HTML.Doctype', 'XHTML 1.0 Strict'); // replace with your doctype

        $config->set('HTML.AllowedElements', array('table','th','tr','tbody','thead','td','b', 'i', 'p', 'a', 'strong', 'em', 'img', 'font', 'br', 'span', 'div', 'blockquote', 'ol', 'ul', 'li', 'pre', 'font','hr','strike','s'));
        $config->set('HTML.AllowedAttributes', array('a.href', 'a.target', '*.id', '*.class', 'div.style', 'span.style', 'pre.style', 'img.src', 'img.alt', 'img.title', '*.width', '*.height', 'img.style', 'font.size', 'font.color', 'font.face','table.border','table.style', 'td.style', 'th.style', 'tr.style'));
        $config->set('Filter.YouTube', true);

        $def =& $config->getHTMLDefinition(true);
        $def->addAttribute('a', 'rel', 'Enum#nofollow');
        $def->addAttribute('a', 'target', 'Enum#_blank');
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($text);
    }

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
