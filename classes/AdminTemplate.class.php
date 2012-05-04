<?php
/**
 * Main content per admin web page
 *
 * A wrapper class tailoring the PageTemplate for administrative pages.
 * @package LazyStructure
 */
class AdminTemplate extends PageTemplate
{
    /**
     * Constructor for AdminTemplate
     * 
     * Restricts based on a given action.
     *
     * @param int $action the action requiring permission
     * @param string $name 
     * @param string $name the template name, which defines the relative folder path
     * @param string $template an initial template to add
     * @param string $root the root path from which $name is relative. By default this is the "templates" folder, as defined in View.
    */
    public function __construct($action, $name, $template=false, $root=false)
    {
        global $permissions;
        $permissions->authenticateAction($action);
        parent::__construct("admin/$name", $template, $root);
    }
}
?>
