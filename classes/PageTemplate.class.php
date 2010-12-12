<?php
class PageTemplate extends Template
{
    public $heading = "";
    public $tab = "home";
    public $content;

    public function __construct($name, $template=false, $root=false)
    {
        // remember the last page to return to on form submit if not AJAX
        $_SESSION['lastPage'] = $_SERVER['PHP_SELF'];

        parent::__construct($name, $template, $root);
        $this->head->styles     = new View($name, $template, $root);
        $this->body->messages   = new View($name, $template, $root);
        $this->body->content    = new View($name, $template, $root);
        $this->body->sidebarItems = array();
    }

    public function addSidebarItem($text, $url)
    {
        $items = $this->body->sidebarItems;
        $items[] = array('text' => $text, 'url' => $url);
        $this->body->sidebarItems = $items;
    }

    public function addStyle($style)
    {
        $this->styles[] = $style;
    }

    public function render()
    {
        if(isset($_SESSION['redirect']))
        {
            $redirect = $_SESSION['redirect'];
            unset($_SESSION['redirect']);
            header('location: '.$redirect);
            die();
        }

        define('TEMPLATE_PATH', $this->getRoot().'classes/PageTemplate/');

        $this->title .= TITLE_SUFFIX;

        foreach($this->styles as $style)
        {
            $this->head->styles->style = $style;
            $this->head->styles->addTemplate('style.tpl', TEMPLATE_PATH);
        }

        $this->head->addTemplate("head.tpl", TEMPLATE_PATH);
        $this->bodyTop->addTemplate("bodyTop.tpl", TEMPLATE_PATH);

        /*
            If possible, user notification messages are displayed via AJAX calls.
            However, if the user has JavaScript disabled, we still want the messages to display.
            The following checks if there are messages in the session, and loads them as necessary.
        */
        $this->body->messages->errorStyle = Reporting::hasErrors() ? "block" : "none";
        $this->body->messages->addTemplate('errors.tpl', TEMPLATE_PATH);

        $this->body->messages->successStyle = Reporting::hasSuccesses() ? "block" : "none";
        $this->body->messages->addTemplate('successes.tpl', TEMPLATE_PATH);

        /*
            Generate the sidebar based on the links added through $this->addSidebarItem
            This is so the sidebar links can be customized for each page as opposed to
            global navigation
        */
        $this->body->sidebar = new View("classes/PageTemplate/sidebar");
        $this->body->sidebar->addTemplate("top.tpl");
        if(isset($this->body->sidebarItems[0]))
        {
            $this->body->sidebar->addTemplate("ultop.tpl");

            foreach($this->body->sidebarItems AS $item)
            {
                $this->body->sidebar->item = array('url' => $item['url'], 'text' => $item['text']);
                $this->body->sidebar->addTemplate("li.tpl");
            }

            $this->body->sidebar->addTemplate("ulbottom.tpl");
        }
        $this->body->sidebar->addTemplate("bottom.tpl");

        $this->body->addTemplate("body.tpl", TEMPLATE_PATH);
        $this->bodyBottom->addTemplate("bodyBottom.tpl", TEMPLATE_PATH);

        parent::render();
    }
}
?>
