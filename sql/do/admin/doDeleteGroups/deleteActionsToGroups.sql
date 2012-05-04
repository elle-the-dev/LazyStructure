DELETE FROM actions_to_groups
WHERE group_id IN (<?php echo $this->placeholders; ?>);
