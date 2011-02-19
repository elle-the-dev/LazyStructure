<option value="<?php echo $this->getValue(current($this->items), $this->value); ?>"<?php echo $this->getIfSelected(current($this->items), $this->selected); ?>><?php echo $this->getValue(current($this->items), $this->label); ?></option>
<?php
next($this->items);
?>
