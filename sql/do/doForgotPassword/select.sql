SELECT username, reset_time 
FROM users 
WHERE email IS NOT NULL
    AND email = :email;
