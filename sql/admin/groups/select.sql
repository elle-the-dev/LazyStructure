SELECT id, name, description
FROM groups
ORDER BY name ASC 
LIMIT <?php echo $this->limit; ?>;
