DELETE FROM groups
WHERE id IN (<?php echo $this->placeholders; ?>);
