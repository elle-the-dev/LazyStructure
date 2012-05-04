ELECT pages.id, pages.title, group_id
FROM pages
    LEFT JOIN groups_to_pages ON pages.id = page_id
        AND group_id = ? 
ORDER BY title ASC;
