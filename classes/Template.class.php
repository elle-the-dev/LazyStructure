<?php
/*
    All pages should directly or indirectly inherit from this class.
    Template contains only the basic XHTML page structure and no more.
    The vast majority, if not all, of your pages should extend the PageTemplate
    class as it should be the one to contain CSS and JavaScript files,
    along with the majority of your page markup.
*/
class Template extends View
{
    public $styles = array();

    public function __construct($name, $template=false, $root=false)
    {
        $this->head         = new View($name, $template, $root);
        $this->bodyTop      = new View($name, $template, $root);
        $this->body         = new View($name, $template, $root);
        $this->bodyBottom   = new View($name, $template, $root);
        parent::__construct($name, $template, $root);
    }

    public function render()
    {

        /* Turn off IE8's "XSS Protection" that actually makes sites vulnerable */
        header('X-XSS-Protection: 0');

        /* Checks if it's an AJAX request -- if so, no need for the whole site structure */
        if(Database::isAjax())
        {
            /*
                If it's an AJAX call, the markup is handled by jQuery, so we want to pass a JSON object.
                The page title is passed separate from the overall page markup so that even though
                We technically remain on the same page, the browser can change the window title.
            */
            header('content-type: application/json; charset=utf-8'); 
            ob_start();
            $this->body->render();
            $markup = ob_get_clean();
            echo json_encode(array('title' => $this->title, 'markup' => $markup, 'styles' => $this->styles));
        }
        else
        {
            /*
                Given this whole thing is XHTML standards compliant, it would be nice to actually serve it as such
                However, some browsers *cough*IE*cough* can't handle that, so we have to check.

                -- Slight problem: This doesn't work with nicEdit, so it's disabled for now.

                if (strpos($_SERVER['HTTP_ACCEPT'], "application/xhtml+xml") !== false) 
                    header('content-type: application/xhtml+xml; charset=utf-8'); 
                else 
                    header('content-type: text/html; charset=utf-8');
            */

            header('content-type: text/html; charset=utf-8');

            $this->addTemplate("template.tpl", $this->getRoot()."classes/Template/");
            parent::render();
        }
    }
}
?>
