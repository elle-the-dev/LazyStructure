SELECT id, title, link, parent_id, is_ajax
FROM main_menu 
WHERE parent_id IS NULL 
ORDER BY position ASC;
