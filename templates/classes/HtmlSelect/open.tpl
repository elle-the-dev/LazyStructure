<<?php echo $this->type; ?>
<?php echo !$this->id ? "" : ' id="'.$this->id.'"'; ?>
<?php echo !$this->selectName ? "" : ' name="'.$this->selectName.($this->multiple ? '[]' : '').'"'; ?> 
<?php echo !$this->class ? "" : ' class="'.$this->class.'"'; ?>
<?php echo !$this->size ? "" : ' size="'.$this->size.'"'; ?>
<?php echo !$this->multiple ? "" : ' multiple="multiple"'; ?>>
