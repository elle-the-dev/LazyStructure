<?php
/**
 * Class for functions required for Itemize classes
 *
 * @package LazyStructure
 */
class ItemizeView extends View
{
    /**
     * Return selected string if option is selected
     *
     * Compares the provided value with the current item passed.
     * if the values match, returns the string attribute ' selected="selected"'
     *
     * @param mixed $item the current list item to check
     * @param string $selected the value to compare against
     * @return string the selected attribute string
     */
    public function getIfSelected($item, $selected)
    {
        if(is_array($item))
            return $this->getIfSelected($item['value'], $selected);
        else if($item == $selected)
            return ' selected="selected"';
        else
            return '';
    }

    /**
     * Return the array value at the index provided
     *
     * If the item is an array, it digs down to find the value at the index provided
     * otherwise, returns the item value passed
     *
     * @param mixed $item the variable to return the value of
     * @param mixed $index the array index to recurse on
     * @return mixed the variable value
     */
    public function getValue($item, $index=null)
    {
        if(is_array($item))
            return $this->getValue($item[$index]);
        else
            return $item;
    }

}
?>
