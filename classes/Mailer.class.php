<?php
class Mailer
{  
    public function __construct()
    {

    }

    public static function sendNewPassword($userID, $newpassword)
    {
        $db = new Model("classes/Mailer");
        $rows = $db->query("selectUser.sql", $userID);
        $to = $rows[0]['email'];
        $from = "noreply@windsorexecutives.com";
        $subject = "WEA: Your new password";
        $message = <<<TEMPLATE
            Your new password is: {$newpassword}

            It is highly recommended that you login and change your password.
TEMPLATE;
        $db->query("updateToken.sql", $userID);
        self::sendEmail($to, $from, $subject, $message);
    }

    public static function sendResetPassword($username, $email)
    {
        $db = new Model("classes/Mailer");
        $from = "noreply@windsorexecutives.com";
        $token = $db->getRandomToken();
        $now = time();
        $db->query("updateUser.sql", $token, $now, $username);
        $resetUrl = "http://wea.dev.ass-kickin.com/resetComplete.php?token=$token&user=$username";
        $subject = "Windsor Executives: Password Reset";
        $message = <<<TEMPLATE
            In order to reset your password, you must go to the following address: {$resetUrl}
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
