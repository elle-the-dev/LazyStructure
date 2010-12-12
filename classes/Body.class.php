<?php
class Body
{
    public $content;
    public function __construct($name)
    {
        $this->content = new View($name);
    }

    public function render()
    {
        parent::render();
    }
}
?>
