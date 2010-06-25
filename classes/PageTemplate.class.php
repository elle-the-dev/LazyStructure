<?php
class PageTemplate extends Template
{
    public $tab = "home";
    public $sidebarItems = array();

    public function __construct()
    {
        $_SESSION['page'] = $_SERVER['PHP_SELF'];
    }

    function addSidebarItem($text, $url)
    {
        $this->sidebarItems[] = array('text' => $text, 'url' => $url);
    }

    function render()
    {
        $this->title .= " - LazyStructure";

        $this->head .= <<<TEMPLATE
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
        <meta name="Keywords" content="generic, structure, reusable"></meta>
        <meta name="Description" content="Your name in generic"></meta>

        <!-- Enable Chrome Frame in IE when installed -->
        <meta http-equiv="X-UA-Compatible" content="chrome=1"></meta>

        <link rel="stylesheet" href="css/main.css" />

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
TEMPLATE;
        $this->bodyTop .= <<<TEMPLATE
            <div id="containerBg">
                <div id="container">
                    <div id="header">
                        <h1 id="h1"><a href="index.php">LazyStructure</a></h1>
                    </div>
                    <div id="content">
                    <div id="tabs">
                        <ul id="{$this->tab}Header">
                            <li class="home">
                                <a href="index.php" onclick="return loadPage(this);">Home</a>
                                <ul>
                                    <li><a href="#">Lorem</a></li>
                                    <li><a href="#">Ipsum</a></li>
                                    <li><a href="#">Dolor</a></li>
                                    <li><a href="#">Sit Amet</a></li>
                                </ul>
                            </li>
                            <li class="browse">
                                <a href="alpha.php" onclick="return loadPage(this);">Alpha</a>
                                <ul>
                                    <li>
                                        <a href="#">Lorem</a>
                                        <ul>
                                            <li><a href="#">Lorem</a></li>
                                            <li><a href="#">Ipsum</a></li>
                                            <li><a href="#">Dolor</a></li>
                                            <li><a href="#">Sit Amet</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Ipsum</a></li>
                                    <li>
                                        <a href="#">Dolor</a>
                                        <ul>
                                            <li><a href="#">Lorem</a></li>
                                            <li><a href="#">Ipsum</a></li>
                                            <li><a href="#">Dolor</a></li>
                                            <li><a href="#">Sit Amet</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Sit Amet</a></li>
                                </ul>
                            </li>
                            <li class="stats">
                                <a href="beta.php" onclick="return loadPage(this);">Beta</a>
                                 <ul>
                                    <li><a href="#">Lorem</a></li>
                                    <li>
                                        <a href="#">Ipsum</a>
                                        <ul>
                                            <li><a href="#">Lorem</a></li>
                                            <li><a href="#">Ipsum</a></li>
                                            <li><a href="#">Dolor</a></li>
                                            <li><a href="#">Sit Amet</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Dolor</a></li>
                                    <li><a href="#">Sit Amet</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div id="mainBg">
                        <div id="main" class="main">
TEMPLATE;

        $this->sidebar .= <<<TEMPLATE
                            <div id="sidebar" class="sidebar">
                                <div id="sidebarTitle">Menu</div>
TEMPLATE;

        if(isset($this->sidebarItems[0]))
        {
            $this->sidebar .= '<ul id="sidebarItems">';
            foreach($this->sidebarItems AS $item)
            {
                $this->sidebar .= <<<TEMPLATE
                    <li><a href="{$item['url']}" onclick="return loadPage(this);">{$item['text']}</a></li>
TEMPLATE;
            }
            $this->sidebar .= '</ul>';
        }
        $this->sidebar .= '</div>';

        /*
            If possible, user notification messages are displayed via AJAX calls.
            However, if the user has JavaScript disabled, we still want the messages to display.
            The following checks if there are messages in the session, and loads them as necessary.
        */
        $messages = "";
        if(isset($_SESSION['errors'][0]))
            $messages .= '<div id="error" class="error" style="display: block">'.Reporting::showErrors().'</div>';
        else
            $messages .= '<div id="error" class="error"></div>';

        if(isset($_SESSION['successes'][0]))
            $messages .= '<div id="success" class="success" style="display: block">'.Reporting::showSuccesses().'</div>';
        else
            $messages .= '<div id="success" class="success"></div>';

        $this->body = <<<TEMPLATE
            <div id="mainContent">
                {$messages}
                {$this->body}
TEMPLATE;
        $this->body = $this->sidebar.$this->body;

        $this->body .= <<<TEMPLATE
                            </div>
                        </div>
                    </div>
TEMPLATE;
        $this->bodyBottom .= <<<TEMPLATE
                    <div id="footer">
                        <ul id="{$this->tab}Footer">
                            <li><a href="#" onclick="return loadPage(this);">About</a></li>
                            <li><a href="#" onclick="return loadPage(this);">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
TEMPLATE;
        parent::render();
    }
}
?>
