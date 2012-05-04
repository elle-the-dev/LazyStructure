SELECT pages.id, pages.title, gp1.group_id
FROM pages
    LEFT JOIN groups_to_pages gp1 ON pages.id = gp1.page_id
        AND gp1.group_id = ? 
WHERE pages.id NOT IN  
(
    SELECT pages.id
    FROM pages
        INNER JOIN groups_to_pages ON pages.id = page_id
            AND group_id = <?php echo GROUP_GUEST; ?>
)
ORDER BY title ASC;
