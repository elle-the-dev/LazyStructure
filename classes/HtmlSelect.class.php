<?php
/**
 * Class for converting an array to an HTML select menu
 *
 * Manipulation of PHP arrays as HTML select menus
 * @package LazyStructure
 */
class HtmlSelect extends Itemize
{
    private $selected;
    private $value = "value";
    private $label = "label";

    /**
     * HtmlList Constructor
     *
     * @param array $items the list items
     */
    public function __construct($items=array(), $selected=null, $id=null, $class=null)
    {
        $this->view = new ItemizeView("classes/HtmlSelect");
        $this->view->items = $items;
        $this->view->selected = $selected;
        $this->view->id = $id;
        $this->view->class = $class;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * Generates a select dropdown
     *
     * Add the necessary templates to the view for the list
     *
     * @param string $label the default dummy value to appear on load
     */
    public function generate($label=null)
    {
        if($label)
        {
            array_unshift($this->view->items, $label);
        }
        
        $this->view->type = "select";
        $this->view->value = $this->value;
        $this->view->label = $this->label;
        $this->view->addTemplate("open.tpl");
        foreach($this->view->items as $item)
        {
            $this->view->addTemplate("item.tpl");
        }
        $this->view->addTemplate("close.tpl");
    }

    /**
     * Sets the keys for list creation
     *
     * @param string $value the value attribute of the option
     * @param string $label the visible display text of the option
     */
    public function setIndexes($value, $label)
    {
        $this->value = $value;
        $this->label = $label;
    }
}
