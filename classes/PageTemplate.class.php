<?php
/**
 * Main content per web page
 *
 * The main class for tailoring the page structure for a specific site
 * Inheriting from Template which includes the necessities (doctype declaration, meta tags)
 * PageTemplate adds the main navigation, handles the stylesheets, and adds content to the page sections
 * @package LazyStructure
 */
class PageTemplate extends Template
{
    public $heading = "";
    public $tab = "home";
    public $content;

    /**
     * Constructor for PageTemplate
     *
     * Redirects if required, otherwise stores the last page visited in the session,
     * creates Views for styles, messages, and content
     * $this->head->styles will hold the markup for outputting per-page stylesheets
     * $this->body->messages will hold the markup for error and success messages
     * $this->body->content will hold the main content per page
     *
     * @param string $name the template name, which defines the relative folder path
     * @param string $template an initial template to add
     * @param string $root the root path from which $name is relative. By default this is the "templates" folder, as defined in View.
     */
    public function __construct($name, $template=false, $root=false)
    {
        if(isset($_SESSION['redirect']) && $_SESSION['redirect'] != Reporting::RELOAD) // reload can be ignored
        {
            $redirect = $_SESSION['redirect'];
            unset($_SESSION['redirect']);
            header('location: '.$redirect);
            die();
        }

        // remember the last page to return to on form submit if not AJAX
        if(isset($_SESSION['lastPage']))
            $_SESSION['lastLastPage'] = $_SESSION['lastPage'];
        else
            $_SESSION['lastLastPage'] = $_SERVER['PHP_SELF'];
        $_SESSION['lastPage'] = $_SERVER['PHP_SELF'];

        parent::__construct($name, $template, $root);
        $this->head->styles     = new View($name, $template, $root);
        $this->body->messages   = new View($name, $template, $root);
        $this->body->content    = new View($name, $template, $root);
        $this->body->sidebarItems = array();
    }

    /**
     * __set is used to map direct object variable access to $this->body->content->variable
     *
     * In order to reduce the need for lengthy calls to $pageTemplate->body->content->somevalue
     * __set is used to allow for $pageTemplate->somevalue to map directly to the aforementioned
     * value
     *
     * @param string $name the name of the variable
     * @param mixed $val the value stored
     */
    public function __set($name, $val)
    {
        $this->body->content->$name = $val;
    }

    public function &__get($name)
    {
        /*
            Okay, so here's what's going on.  Calling $this->body then checks this __get() function
            this creates a weird logical paradox where everything goes to hell
            to avoid this, we call __get('body') of the parent, instead of $this->body.
        */
        $body = parent::__get('body');
        if(is_object($body) && is_object($body->content) && !is_null($body->content->$name))
        {
            //echo isset($this->body) ? "TRUE" : "FALSE";  // - FALSE
            //echo is_null($this->body) ? "TRUE" : "FALSE"; // - FALSE :|
            $a = &$this->body->content->$name;
            return $a; 
        }
        else
            return parent::__get($name);
    }
    

    function getMenuItems($rows, $table, $id=false, $class=false, $appendItems="")
    {
        if(is_array($rows))
        {
            $db = new Model("classes/PageTemplate");
            if(!is_array($this->menuItemIds))
                $this->menuItemIds = array();

            $ulId = $id ? ' id = "'.$id.'"' : '';
            $ulClass = $class ? ' class="'.$class.'"' : '';

            $output = <<<OUT

            <ul{$ulId}{$ulClass}>
OUT;
            foreach($rows AS $row)
            {
                if(in_array($row['id'], $this->menuItemIds) === false)
                {
                    $output .= '<li>';
                    if($row['is_ajax'])
                    {
                        $rel = ' rel="address:'.$row['link'].'"';
                        $link = PATH.$row['link'];
                    }
                    else
                    {
                        $rel = "";
                        $link = $row['link'];
                    }

                    $output .= empty($row['link']) ? $row['title'] : '<a href="'.$link.'"'.$rel.'><span>'.$row['title'].'</span></a>';
                    if(in_array($row['id'], $this->menuItemIds) === false)
                    {
                        if(isset($row['id']))
                        {
                            $db->table = $table;
                            $subRows = $db->query("getMenuItem.sql", $row['id']);
                        }

                        if(is_array($subRows))
                            $output .= $this->getMenuItems($subRows, $table);
                        else
                            $output .= "<ul><li class=\"empty\"> </li></ul>";
                    }
                    $this->menuItemIds[] = $row['id'];
                    $output .= <<<OUT

                        <input type="hidden" class="menuItemId" value="{$row['id']}" />
                    </li>
OUT;
                }
            }
            return $output.$appendItems.'</ul>';
        }
        else
            return "<ul><li class=\"empty\"> </li></ul>";
                                                                                                                                                                                                                             
    }

    /**
     * addSidebarItem adds a link to the sidebar
     *
     * The sidebar is generated per-page via calls to this method.
     * Links are stored in an array until the page is rendered.
     *
     * @param string $text the display text for the link
     * @param string $url the link address
     * @param string $class the CSS class for the <a> tag
     */
    public function addSidebarItem($title, $link, $class="")
    {
        $items = is_array($this->body->sidebarItems) ? $this->body->sidebarItems : array();
        $items[] = array('title' => $title, 'link' => $link, 'class' => $class);
        $this->body->sidebarItems = $items;
    }

    /**
     * addStyle adds a stylesheet to the page
     *
     * Stylesheets are updated per-page via calls to this method.
     * Stylesheets are stored in an array until the page is rendered.
     *
     * @param string $style the stylesheet to add
     */
    public function addStyle($style)
    {
        $styles = $this->styles;
        array_push($styles, PATH.$style);
        $this->styles = $styles;
    }

   
    public function addTemplate($template, $path=false)
    {
        $this->body->content->addTemplate($template, $path);
    }

    /**
     * render outputs the markup
     *
     * Templates comprising the content and style for each page is added here.
     * Any messages are detected and generated, as are all sidebar items and stylesheets.
     * It finishes by calling render() in Template
     */
    public function render()
    {
        define('TEMPLATE_PATH', $this->getRoot().'classes/PageTemplate/');
        global $permissions;
        global $user;

        $this->title .= TITLE_SUFFIX;

        $this->head->styles->styles = $this->styles;
        foreach($this->styles as $style)
        {
            $this->head->styles->addTemplate('style.tpl', TEMPLATE_PATH);
        }

        $this->head->addTemplate("head.tpl", TEMPLATE_PATH);
        $this->head->admin = new View("../".TEMPLATE_PATH."admin");
        if($permissions->isAuthorizedAction(CONTENT_EDIT))
            $this->head->admin->addTemplate("head.tpl");

        $this->bodyTop->addTemplate("bodyTop.tpl", TEMPLATE_PATH);
        $this->bodyTop->menu = new View("classes/PageTemplate/menu");
        $this->bodyTop->menu->tab = $this->tab;
        $this->bodyTop->menu->addTemplate("content.tpl");

        $this->bodyTop->menu->admin = new View("classes/PageTemplate/menu/admin");
        $this->bodyTop->login = new View("classes/PageTemplate/login");
        if($user)
        {
            $this->bodyTop->login->username = $user->username;
            $this->bodyTop->login->addTemplate("loggedIn.tpl");
        }
        else
            $this->bodyTop->login->addTemplate("login.tpl");
        $menuActions = array(USERS, GROUPS, PAGES);
        $menuActionItems = array();
        if($permissions->hasAnyActions($menuActions))
        {
            //$this->bodyTop->menu->admin->actions = $permissions->actions;
            $this->bodyTop->menu->admin->addTemplate("open.tpl");
            foreach($menuActions as $menuAction)
            {
                if($permissions->isAuthorizedAction($menuAction))
                {
                    $this->bodyTop->menu->admin->items[] = array(
                        'name' => $permissions->allActions[$menuAction]['name'],
                        'url' => $permissions->allActions[$menuAction]['url']
                    );
                    $this->bodyTop->menu->admin->addTemplate("item.tpl");
                }
            }
            $this->bodyTop->menu->admin->addTemplate("close.tpl");
        }


        /*
            If possible, user notification messages are displayed via AJAX calls.
            However, if the user has JavaScript disabled, we still want the messages to display.
            The following checks if there are messages in the session, and loads them as necessary.
        */
        $this->body->messages->errorStyle = Reporting::hasErrors() ? "block" : "none";
        $this->body->messages->addTemplate('errors.tpl', TEMPLATE_PATH);

        $this->body->messages->successStyle = Reporting::hasSuccesses() ? "block" : "none";
        $this->body->messages->addTemplate('successes.tpl', TEMPLATE_PATH);


        $db = new Model("classes/PageTemplate");
        $rows = $db->query("mainMenu.sql");
        $username = isset($_GET['username']) ? $_GET['username'] : "FAIL";
        ob_start();
        $this->bodyTop->menu->admin->render();
        $adminItems = ob_get_clean();
        $this->bodyTop->mainMenu = $this->getMenuItems($rows, "main_menu", $this->tab, "mainMenu", $adminItems);

        //$rows = $db->query("footerMenu.sql", $siteUserId);
        //$this->bodyBottom->footerMenu = $this->getMenuItems($rows, "footer_menu", $this->tab, "footerMenu");

        /*
            Generate the sidebar based on the links added through $this->addSidebarItem
            This is so the sidebar links can be customized for each page as opposed to
            global navigation
        */
        $this->body->sidebar = new View("classes/PageTemplate/sidebar");
        $this->body->sidebar->addTemplate("top.tpl");
        $this->body->sidebar->page = $this->page; // ul class to identify which page is active
        if(isset($this->body->sidebarItems[0]))
        //if($sidebarItems = $db->query("sidebar.sql"))
        {
            $this->body->sidebar->addTemplate("ultop.tpl");
            $this->body->sidebar->items = $this->body->sidebarItems;
            //$this->body->sidebar->items = $sidebarItems;

            foreach($this->body->sidebar->items AS $item)
            {
                $this->body->sidebar->addTemplate("li.tpl");
            }
            reset($this->body->sidebar->items);
            $this->body->sidebar->addTemplate("ulbottom.tpl");
        }
        $this->body->sidebar->addTemplate("bottom.tpl");

        $this->body->addTemplate("body.tpl", TEMPLATE_PATH);
        $this->bodyBottom->addTemplate("bodyBottom.tpl", TEMPLATE_PATH);
        if($permissions->isAuthorizedAction(CONTENT_EDIT))
        {
            $pages = $db->query("pages.sql");
            array_unshift($pages, array('id' => '', 'title' => '-- Select a Page --'));
            $this->bodyBottom->pages = new HtmlSelect($pages, array('value' => 'id', 'label' => 'title', 'id' => 'newTabPage'));
            $this->bodyBottom->pages->generate();
            $this->bodyBottom->addTemplate("newTab.tpl", TEMPLATE_PATH);
            $this->bodyBottom->addTemplate("tabTooltip.tpl", TEMPLATE_PATH);
        }

        /*
        $phpErrors = isset($_SESSION['phpErrors']) ? $_SESSION['phpErrors'] : false;
        ob_start();
        parent::render();
        $output = ob_get_clean();
        if($phpErrors)
        {
            echo $phpErrors;
            die("FFFFUUUUUUUUUUU");
        }
        else
            echo $output;
        */
        parent::render();

    }
}
?>
