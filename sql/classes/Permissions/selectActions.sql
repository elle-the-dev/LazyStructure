SELECT action_id
FROM actions_to_groups, actions
WHERE group_id IN (<?php echo $this->placeholders; ?>)
    AND actions.id = action_id;
