<?php
/**
 * Class for converting an array to an HTML list
 *
 * Manipulation of PHP arrays as HTML lists
 * @package LazyStructure
 */
class HtmlList extends Itemize
{
    /**
     * HtmlList Constructor
     *
     * @param array $items the list items
     */
    public function __construct($items=array(), $id=null, $class=null)
    {
        $this->view = new ItemizeView("classes/HtmlList");
        $this->view->items = $items;
        $this->view->id = $id;
        $this->view->class = $class;
    }

}
