SELECT page_id
FROM groups_to_pages
WHERE group_id IN (<?php echo $this->placeholders; ?>);
