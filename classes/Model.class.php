<?php
class Model extends Database
{
    static $instance;

    private $root = 'sql/';
    private $path;
    private $name;
    private $vars;

    protected function __construct()
    {
        parent::connect();
    }

    public function __get($name)
    {
        return isset($this->vars[$name]) ? $this->vars[$name] : false;
    }

    public function __set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function query($file)
    {
        $args = func_get_args();
        $this->prepQuery($file, $query, $args);
        return parent::query($query, $args);
    }

    public function queryRow($file)
    {
        $args = func_get_args();
        $this->prepQuery($file, $query, $args);
        return parent::queryRow($query, $args);
    }

    public function queryColumn($file)
    {
        $args = func_get_args();
        $this->prepQuery($file, $query, $args);
        return parent::queryColumn($query, $args);
    }

    public function queryKey($key, $file)
    {
        $args = func_get_args();
        $this->prepQuery($file, $query, $args);
        array_shift($args);
        return parent::queryKey($key, $query, $args);
    }

    private function prepQuery($file, &$query, &$args)
    {
        ob_start();
        require(dirname(__FILE__).'/../'.$this->path.$file);
        $query = ob_get_clean();
        if(is_array($args))
            array_shift($args);
    }

    public function init($name)
    {
        $this->name = $name;
        $this->path = $this->root.$this->name.'/';
        $this->vars = array();
    }

    public static function getModel()
    {
        if(isset(self::$instance))
            return self::$instance;
        else
            return self::$instance = new Model();
    }
}
?>
