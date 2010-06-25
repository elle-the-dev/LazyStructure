<?php
/*
    All pages should directly or indirectly inherit from this class.
    Template contains only the basic XHTML page structure and no more.
    The vast majority, if not all, of your pages should extend the PageTemplate
    class as it should be the one to contain CSS and JavaScript files,
    along with the majority of your page markup.
*/
class Template
{
    public $top;
    public $closeTop;
    public $title = "";
    public $head = "";
    public $bodyTop = "";
    public $sidebar = "";
    public $body = "";
    public $bodyBottom = "";
    public $bottom;


    public function __construct()
    {
    }

    public function render()
    {
        /* 
            Serve as XHTML if the browser accepts it
            Some browsers *cough IE* server up XHTML content as a file-download
        */
        $bXHTML = strpos($_SERVER['HTTP_ACCEPT'], "application/xhtml+xml"); 
        if (false && $bXHTML) 
            header('content-type: application/xhtml+xml; charset=utf-8'); 
        else 
            header('content-type: text/html; charset=utf-8');

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
            echo json_encode(array('title' => $this->title, 'markup' => $this->body));
        }
        else
        {
            $this->top = <<<TEMPLATE
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>{$this->title}</title>
TEMPLATE;

            $this->closeTop = <<<TEMPLATE
</head>
<body>
TEMPLATE;

            $this->bottom = <<<TEMPLATE
</body>
</html>
TEMPLATE;

            echo $this->top, $this->head, $this->closeTop, $this->bodyTop, $this->body, $this->bodyBottom, $this->bottom;
        }
    }
}
?>
