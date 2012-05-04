SELECT username
FROM users
WHERE id IN (<?php echo $this->placeholders; ?>);
