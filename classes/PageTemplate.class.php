<?php
class PageTemplate extends Template
{
    public $heading = "";
    public $tab = "home";
    public $sidebarItems = array();

    public function __construct()
    {
        $_SESSION['lastPage'] = $_SERVER['PHP_SELF'];
    }

    function addSidebarItem($text, $url)
    {
        $this->sidebarItems[] = array('text' => $text, 'url' => $url);
    }

    function addStyle($style)
    {
        $this->styles[] = $style;
    }

    function render()
    {
        $path = PATH;

        $this->title .= " - LazyStructure";

        $styles = "";    
        foreach($this->styles as $style)
            $styles .= "<link rel='stylesheet' type='text/css' href='$style' class='pageStyle' />";

        $this->head .= <<<TEMPLATE
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
        <meta name="Keywords" content="generic, structure, reusable"></meta>
        <meta name="Description" content="Your name in generic"></meta>
        <meta name="fragment" content="!"></meta>

        <!-- Enable Chrome Frame in IE when installed -->
        <meta http-equiv="X-UA-Compatible" content="chrome=1"></meta>

        <link rel="stylesheet" href="{$path}css/main.css" />
        {$styles}

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="{$path}js/jquery.address.min.js"></script>
        <script type="text/javascript" src="{$path}js/main.js"></script>
TEMPLATE;
        $this->bodyTop .= <<<TEMPLATE
            <div id="containerBg">
                <div id="container">
                    <div id="header">
                        <h1 id="h1"><a href="{$path}1/home">LazyStructure</a></h1>
                    </div>
                    <div id="content">
                    <div id="tabs">
                        <ul id="{$this->tab}Header">
                            <li class="home">
                                <a href="{$path}1/home" rel="address:1/home">Home</a>
                                <ul>
                                    <li><a href="#">Lorem</a></li>
                                    <li><a href="#">Ipsum</a></li>
                                    <li><a href="#">Dolor</a></li>
                                    <li><a href="#">Sit Amet</a></li>
                                </ul>
                            </li>
                            <li class="browse">
                                <a href="{$path}2/alpha" rel="address:2/alpha">Alpha</a>
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
                                <a href="{$path}4/login" rel="address:4/login">Members</a>
                                <ul>
                                    <li>
                                        <a href="{$path}3/join" rel="address:3/join">Join</a>
                                    </li>
                                    <li>
                                        <a href="{$path}4/login" rel="address:4/login">Login</a>
                                    </li>
                                    <li>
                                        <a href="do/doLogout.php">Logout</a>
                                    </li>
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
                    <li><a href="{$item['url']}" rel="address:{$item['url']}">{$item['text']}</a></li>
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
            $messages .= '<div id="errors" class="errors" style="display: block">'.Reporting::showErrors().'</div>';
        else
            $messages .= '<div id="errors" class="errors"></div>';

        if(isset($_SESSION['successes'][0]))
            $messages .= '<div id="successes" class="successes" style="display: block">'.Reporting::showSuccesses().'</div>';
        else
            $messages .= '<div id="successes" class="successes"></div>';

        $this->body = <<<TEMPLATE
            <div id="mainContent">
                <h2>{$this->heading}</h2>
                {$messages}
                {$this->body}
TEMPLATE;
        $this->body = $this->sidebar.$this->body;

        $this->body .= <<<TEMPLATE
                            </div>
TEMPLATE;
        $this->bodyBottom .= <<<TEMPLATE
                        </div>
                    </div>
                    <div id="footer">
                        <ul id="{$this->tab}Footer">
                            <li><a href="#">About</a></li>
                            <li><a href="#">Contact</a></li>
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
