SELECT id, username, email, phone, CONCAT(address1, ' ', address2) AS address 
FROM users
ORDER BY username ASC 
LIMIT <?php echo $this->limit; ?>
