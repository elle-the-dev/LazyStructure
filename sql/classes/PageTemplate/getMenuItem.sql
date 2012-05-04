SELECT id, title, link, parent_id, is_ajax
FROM <?php echo $this->table; ?> 
WHERE parent_id = ?
ORDER BY position ASC
