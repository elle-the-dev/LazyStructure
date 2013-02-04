<?php
/**
 * Permissions object for user authentication
 *
 * Object for authenticating actions and page access
 * @package LazyStructure
 */
class Permissions
{
    private $actions;
    private $allActions;
    private $pages;

    public function __construct($groups=array())
    {
        $this->actions      = $this->queryActions($groups);
        $this->allActions   = $this->queryAllActions();
        $this->pages        = $this->queryPages($groups);
    }

    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Validate a client against a page and give a 403 error on fail
     *
     * Checks $this->isAuthorizedPage for page permission, and if authorization
     * fails, redirects to the 403 error page.
     *
     * @param int $pageId the page ID
     */
    public function authenticatePage($pageId)
    {
        if(!$this->isAuthorizedPage($pageId))
        {
            header('403 Forbidden');
            header('Location: '.PATH.'errors/403.php');
            die;
        }
    }
    
    /**
     * Validate against a page
     *
     * Verifies if a there are adequate permissions to view a given page
     *
     * @param int $pageId the page ID
     * @return bool If there is permission to view the page
     */
    public function isAuthorizedPage($pageId)
    {
        return !empty($this->pages) && in_array($pageId, $this->pages);
    }

    /**
     * Retrieve and return page permissions
     *
     * Queries the database for page IDs associated with $this->groups and 
     * returns them in an array
     *
     * @param mixed $groups array or number of groups
     * @return array the pages with the permissions to access
     */
    private function queryPages($groups)
    {
        return $this->queryPermissions($groups, "selectPages.sql");
    }

    /**
     * Validate a client against a page and give a 403 error on fail
     *
     * Checks $this->isAuthorizedPage for page permission, and if authorization
     * fails, redirects to the 403 error page.
     *
     * @param int $pageId the page ID
     */
    public function authenticateAction($actionId)
    {
        if(!$this->isAuthorizedAction($actionId))
        {
            header('403 Forbidden');
            header('Location: '.PATH.'errors/403.php');
            die;
        }
    }
 
    /**
     * Validate against an action
     *
     * Verifies if there are adequate permissions to perform a given action
     *
     * @param int $actionId the action ID
     * @return bool If there is permission to perform the action
     */
    public function isAuthorizedAction($actionId)
    {
        return !empty($this->actions) && in_array($actionId, $this->actions);
    }

    /**
     * Verifies if the given actions are in the permissions
     *
     * Compares an array of actions against the existing set for intersects.
     *
     * @param array $actions the actions to check
     * @return bool if there are any intersects
     */
    public function hasAnyActions($actions)
    {
        return (is_array($this->actions) && is_array($actions)) && count(array_intersect($this->actions, $actions)) > 0;
    }

    /**
     * Verify permission to edit page
     *
     * Verifies there are permissions to both have access to the given page
     * and that the permission exists to edit any pages
     *
     * @param int $pageId the page to verify
     * @return bool has permission to edit
     */
    public function canEditPage($pageId)
    {
        return $this->isAuthorizedPage($pageId) && $this->isAuthorizedAction(CONTENT_EDIT);
    }

    public function hasChmodUserRead($chmod)
    {
        $bin = "".$this->octbin($chmod{1});
        return $bin{0} === '1';
    }

   public function hasChmodUserWrite($chmod)
    {
        $bin = "".$this->octbin($chmod{1});
        return $bin{1} === '1';
    }

    public function hasChmodUserExecute($chmod)
    {
        $bin = "".$this->octbin($chmod{1});
        return $bin{2} === '1';
    }

    public function hasChmodGroupRead($chmod)
    {
        $bin = "".$this->octbin($chmod{2});
        return $bin{0} === '1';
    }

   public function hasChmodGroupWrite($chmod)
    {
        $bin = "".$this->octbin($chmod{2});
        return $bin{1} === '1';
    }

    public function hasChmodGroupExecute($chmod)
    {
        $bin = "".$this->octbin($chmod{2});
        return $bin{2} === '1';
    }

    public function hasChmodOtherRead($chmod)
    {
        $bin = "".$this->octbin($chmod{3});
        return $bin{0} === '1';
    }

    public function hasChmodOtherWrite($chmod)
    {
        $bin = "".$this->octbin($chmod{3});
        return $bin{1} === '1';
    }

    public function hasChmodOtherExecute($chmod)
    {
        $bin = "".$this->octbin($chmod{3});
        return $bin{2} === '1';
    }



    public function octbin($oct)
    {
        return sprintf("%03d", decbin(octdec($oct)));
    }


    /**
     * Retrieve and return action permissions
     *
     * Queries the database for action IDs associated with $this->groups and
     * returns them in an array
     *
     * @param mixed $groups array or number of groups
     * @return array the permissible actions
     */
    private function queryActions($groups)
    {
        return $this->queryPermissions($groups, "selectActions.sql");
    }

    /**
     * Retrieve all possible actions
     *
     * Queries the database for the complete list of actions
     *
     * @return array all possible actions
     */
    private function queryAllActions()
    {
        $db = new Model("classes/Permissions");
        return $db->queryKey("id", "selectAllActions.sql");
    }

    /** 
     * Retrieve permissions
     *
     * Queries the database for the specified permissions and
     * returns them in an array
     *
     * @param mixed $groups array or number of groups
     * @param string $query SQL file name
     * @return array the permissions
     */
    private function queryPermissions($groups, $query)
    {
        if(empty($groups))
            return array();
        $rows = array();
        $db = new Model("classes/Permissions");
        $db->placeholders = $db->getPlaceholders($groups);
        if($rows = $db->query($query, $groups))
            $this->array_flatten($rows);
        return $rows;
    }

    /**
     * Convert a 2D array to 1D
     *
     * Converts a 2D array to 1D.
     * NOTE: Does not flatten n-depth
     *
     * @param array $rows array to be flattened
     */
    private function array_flatten(&$rows)
    {
        array_walk($rows, function(&$a)
        {
            $a = implode($a);
        });
    }
}
?>
