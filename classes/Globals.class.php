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
        // web root to the site directory - this also needs to be set in js/main.js
        define('PATH', '/LazyStructure/');

        // system root to the site directory
        define('FILE_PATH', dirname(dirname(__FILE__)).'/');

        // site domain
        define('DOMAIN', 'lazystructure.com');
        
        // relative root to SQL files
        define('SQL_PATH', 'sql/');

        // relative root to template files
        define('TEMPLATES_PATH', 'templates/');

        // the text to append after the window title
        define('TITLE_SUFFIX', ' - LazyStructure');

        // universal user group. should always be 1
        define('GROUP_GUEST', 1);

        // universal admin group, should always be 2
        define('GROUP_ADMIN', 2);

        // size of select box for admin permissions
        define('PERMISSIONS_SELECT_SIZE', 8);

        // number of rows for pagination
        define('ROWS_PER_PAGE', 10);
        
        //
        define('BREAK_PAGES', 7);

        define('ERROR_LINES', 10);
    }
}
?>
