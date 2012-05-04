SELECT actions.id, actions.name, group_id
FROM actions
    LEFT JOIN actions_to_groups ON actions.id = action_id
        AND group_id = ?
ORDER BY name ASC;
