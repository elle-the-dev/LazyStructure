DELETE FROM groups_to_users
WHERE group_id IN (<?php echo $this->placeholders; ?>);
