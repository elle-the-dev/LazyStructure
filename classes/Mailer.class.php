<?php
class Mailer
{  
    public function __construct()
    {

    }

    public static function sendMailByUsername($to, $from, $title, $text)
    {
        $db = DBConnect::getDB();
        $row = $db->query("SELECT id FROM users WHERE username = ?", $to);

        $errors = "";

        if(!(is_array($row) > 0))
            $errors .= "Invalid username<br />";
        if(!(strlen($title) > 0))
            $errors .= "Title cannot be blank<br />";
        if(!(strlen($text) > 0))
            $errors .= "Blog text cannot be blank<br />";


        if(strlen($errors) > 0)
            echo $errors;
        else
        {
            $userID = $row[0]['id'];
            $now = time();
            $db->query("INSERT INTO messages (date, userID, senderID, title, text) VALUES(?, ?, ?, ?, ?)", $now, $userID, $from, $title, $text);
        }
    }

    public static function sendMailByID($to, $from, $title, $text)
    {    
        $errors = "";
        if(!(strlen($title) > 0))
            $errors .= "Title cannot be blank<br />";
        if(!(strlen($text) > 0))
            $errors .= "Message text cannot be blank<br />";

        $db = DBConnect::getDB();
        if(strlen($errors) > 0)
            echo $errors;
        else
        {
            $now = time();
            $db->query("INSERT INTO messages (date, userID, senderID, title, text) VALUES(?, ?, ?, ?, ?)", $now, $to, $from, $title, $text);
        }
    }

    public static function sendNewPassword($userID, $newpassword)
    {
        $db = DBConnect::getDB();
        $rows = $db->query("SELECT email FROM users WHERE id = ?", $userID);
        $to = $rows[0]['email'];
        $from = "noreply@thevgpress.com";
        $subject = "The VG Press: Your new password";
        $message = <<<TEMPLATE
            Your new password is: {$newpassword}

            It is highly recommended that you login and change your password.
TEMPLATE;
        $db->query("UPDATE users SET resetToken = -1 WHERE id = ?", $userID);
        self::sendEmail($to, $from, $subject, $message);
    }

    public static function sendResetPassword($username, $email)
    {
        $db = DBConnect::getDB();
        $from = "noreply@thevgpress.com";
        $token = $db->generateToken();
        $now = time();
        $db->query("UPDATE users SET resetToken = ?, resetTime = ? WHERE username = ?", $token, $now, $username);
        $resetUrl = "http://thevgpress.com/resetComplete.php?token=$token&user=$username";
        $subject = "The VG Press: Password Reset";
        $message = <<<TEMPLATE
            In order to reset your password at The VG Press, you must go to the following address: {$resetUrl}
TEMPLATE;
        self::sendEmail($email, $from, $subject, $message);
    }

    private static function sendEmail($to, $from, $subject, $message)
    {
        $message = strip_tags(nl2br($message));
        $to = strip_tags($to);
        $from = strip_tags($from);

        $headers = 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n"; 

        mail($to, $subject, $message, $headers);
    }

}
?>
