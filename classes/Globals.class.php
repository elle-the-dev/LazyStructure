<?php
/*
    Constants to appear globally are contained within __construct
*/
class Globals
{
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
