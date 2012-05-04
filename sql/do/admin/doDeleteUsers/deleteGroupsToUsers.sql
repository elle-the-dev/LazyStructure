DELETE FROM groups_to_users
WHERE user_id IN (<?php echo $this->placeholders; ?>);
