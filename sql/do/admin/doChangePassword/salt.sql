SELECT SUBSTRING(password, 1, 16) AS salt FROM users WHERE id = ?;
