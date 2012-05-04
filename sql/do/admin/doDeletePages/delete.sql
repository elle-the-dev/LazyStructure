DELETE FROM pages
WHERE id IN (<?php echo $this->placeholders; ?>);
