SELECT id, title, editable 
FROM pages
ORDER BY title ASC
LIMIT <?php echo $this->limit; ?>
