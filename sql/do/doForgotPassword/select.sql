SELECT username, resetTime 
FROM users 
WHERE email IS NOT NULL
    AND email = :email;
