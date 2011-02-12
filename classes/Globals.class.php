<?php
/**
 * Container for global constants
 *
 * Constants to appear globally are contained within __construct
 * @package LazyStructure
*/
class Globals
{
    /**
     * Constructur for Globals
     *
     * Instantiates the global constants.
     * These will be available in any file that instantiates a Globals object, even if not stored.
     * By default, these are instantiated in /global.php
     */
    public function __construct()
    {
        // web root to the site directory
        define('PATH', '/LazyStructure/');

        // system root to the site directory
        define('FILE_PATH', '/var/www/LazyStructure/');

        // the text to append after the window title
        define('TITLE_SUFFIX', ' - LazyStructure');
    }
}
?>
