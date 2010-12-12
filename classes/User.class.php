<?php
class User
{
    private $id;
    private $username;
    private $password;
    private $name;
    private $surname;
    private $email;
    private $phone;
    private $address1;
    private $address2;
    private $ip;
    private $xsrfToken;

    public function User($id=null)
    {
        if(isset($id))
        {
            global $db;
            $db->init("classes/User");
            $row = $db->queryRow("init.sql", $id);
            $this->setValues($row);
        }
    }

    public function __get($value)
    {
        return $this->$value;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function login($username, $password, $remember)
    {
        global $db;
        $db->init("classes/User/login");
        $row = $db->queryRow("select.sql", $username, $password);
        if(is_array($row))
        {
            $loginToken = $db->getRandomToken();
            if($remember == "true")
            {
                setcookie("id", $row['id'], time()+1209600);
                setcookie("username", $row['username'], time()+1209600);
                setcookie("loginToken", $loginToken, time()+1209600);
                setcookie("ip", $_SERVER['REMOTE_ADDR'], time()+1209600);
            }

            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->xsrfToken = $db->getRandomToken();
            setcookie('xsrfToken', $this->xsrfToken, 0, '/');
            $db->query("update.sql", $loginToken, $row['id']);

            $this->setValues($row);
            Reporting::setSuccess("Login successful");
        }
        else
            Reporting::setError("Login unsuccessful");
    }

    private function setValues($row)
    {
        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->firstName = $row['name'];
        $this->lastName = $row['surname'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->address1 = $row['address1'];
        $this->address2 = $row['address2'];
        $_SESSION['user'] = serialize($this);
    }

    public function update($fields=null)
    {
        $db = Database::getDatabase();
        if(isset($fields))
        {
            $count = 0;
            if(is_array($fields))
            {
                $query = "UPDATE users SET";
                $params = array();
                $comma = '';
                foreach($fields AS $field)
                {
                    $query .= "{$comma} $field = ?";
                    $params[] = $this->$field;
                    $comma = ',';
                }
                $query .= " WHERE id = ?";
                $params[] = $this->id;
                $db->sql = $query;
                $db->query("field.sql", $params);
            }
            else
            {
                $db->fields = $fields;
                $db->query("fields.sql", $this->$fields, $this->id);
            }
        }
        else
        {
            $db->query("all.sql", $this->password, $this->firstName, $this->lastName, $this->email, $this->phone, $this->address1, $this->address2, $this->id);
        }
        $_SESSION['user'] = serialize($this);
    }
}
?>
