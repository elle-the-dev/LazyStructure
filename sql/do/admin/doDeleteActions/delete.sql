DELETE FROM actions
WHERE id IN (<?php echo $this->placeholders; ?>);
