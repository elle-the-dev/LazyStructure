SELECT groups.id, groups.name, user_id
FROM groups
    LEFT JOIN groups_to_users ON groups.id = group_id
        AND user_id = ?
WHERE groups.id <> <?php echo GROUP_GUEST; ?> 
ORDER BY name ASC;
