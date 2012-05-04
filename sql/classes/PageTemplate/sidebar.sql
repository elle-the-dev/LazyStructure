SELECT id, title, link, parent_id, is_ajax
FROM page_menu 
WHERE parent_id IS NULL 
    AND page_id = ?
ORDER BY position ASC;
