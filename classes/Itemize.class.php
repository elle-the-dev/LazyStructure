<?php
/**
 * Base functions for classes for itemized output
 *
 * @package LazyStructure
 */
 
abstract class Itemize
{
    protected $view;
    protected $id;
    protected $class;

    /**
     * Output the list
     *
     * Renders the list that has been generated
     */
    public function render()
    {
        // items are looped, so we have to ensure it starts from the top
        reset($this->view->items);

        $this->view->render();
    }
    
    /*
     * Sorts the list
     *
     * Sorts the list items in ascending or descending order
     *
     * @param bool $asc whether it's ascending. If not, descending.
     */
    public function sort($asc=true)
    {
        $asc ? sort($this->view->items) : rsort($this->view->items);
    }

   /**
     * Generates an unordered list
     *
     * Add the necessary templates to the view for the list
     *
     * @param string $type the HTML tag to use (ul, ol)
     */
    public function generate($type="ul")
    {
        $this->view->type = $type;
        $this->view->addTemplate("open.tpl");
        foreach($this->view->items as $item)
        {
            $this->view->addTemplate("item.tpl");
        }
        $this->view->addTemplate("close.tpl");
    }

}
