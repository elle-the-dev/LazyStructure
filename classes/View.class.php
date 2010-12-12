<?php
class View
{
    private $root = "templates/";
    private $name;
    private $path;
    private $templates = array();
    private $vars = array();

    public function __construct($name, $template=false, $root=false)
    {
        $this->name = $name;
        if($root)
            $this->root = $root;
        $this->path = $this->root.$this->name.'/';
        if($template)
            $this->addTemplate($template);
    }

    public function __get($name)
    {
        return isset($this->vars[$name]) ? $this->vars[$name] : false;
    }

    public function __set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function addTemplate($template, $path=false)
    {
        if(!$path)
            $path = $this->path;
        $this->templates[] = $path.$template;
    }

    public function render()
    {
        foreach($this->templates AS $template)
            include $template;
    }
}
?>
