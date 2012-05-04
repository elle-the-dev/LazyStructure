<?php
/**
 * Class for an authenticated user
 *
 * Handler for a logged in user
 * @package LazyStructure
 */
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
    private $city;
    private $ip;
    private $groups;
    private $xsrfToken;

    /**
     * Constructor for User
     *
     * Instantiates a user. If an ID is given, the attributes are populated with the values for that user
     * Calls the init.sql query from sql/classes/User/
     *
     * @param int $id user ID for instantiating an existing user
     */
    public function User($id=null)
    {
        if(isset($id))
        {
            $db = new Model("classes/User");
            $row = $db->queryRow("init.sql", $id);
            $this->setValues($row);
        }
    }

    /**
     * Getter magic method
     *
     * Returns the class attribute
     *
     * @param string $name the name of the class variable to return
     * @return variable value, or false if not set
     */
    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : false;
    }

    /**
     * Setter magic method
     *
     * Assigns the given value to the given attribute
     *
     * @param string $name the name of the class variable to assign to
     * @param mixed $value the value to assign
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * login method
     *
     * Validates login information and applies the appropriate class values
     *
     * @param string $username username
     * @param string $password password
     * @param string $remember save the session in a cookie
     */
    public function login($username, $password, $remember=false, $redirect=false, $successMessage="Login successful", $failureMessage="Login unsuccessful")
    {
        $db = new Model("classes/User/login");
        $salt = $db->queryColumn("salt.sql", $username);
        $row = $db->queryRow("select.sql", $username, $db->getPassword($password, $salt));
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

            $this->groups = $db->query("selectGroups.sql", $row['id']);
            if(!empty($this->groups))
            {
                array_walk($this->groups, function(&$a)
                {
                    $a = implode($a);
                });
            }
            else
                $this->groups = array();
            $this->groups[] = GROUP_GUEST;

            $this->setValues($row);
            Reporting::setSuccess($successMessage);
            if($redirect)
            {
                if($redirect == -1)
                    Reporting::setReload();
                else
                    Reporting::setRedirect($redirect, false);
            }
        }
        else
            Reporting::setError($failureMessage);
    }

    private function setValues($row)
    {
        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->name     = $row['name'];
        $this->surname  = $row['surname'];
        $this->email    = $row['email'];
        $this->phone    = $row['phone'];
        $this->address1 = $row['address1'];
        $this->address2 = $row['address2'];
        $_SESSION['user'] = serialize($this);
    }

    public function update($fields=null)
    {
        $db = new Model("classes/User/update");
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
            $db->query("all.sql", $this->password, $this->name, $this->surname, $this->email, $this->phone, $this->address1, $this->address2, $this->city, $this->id);
        }
        $_SESSION['user'] = serialize($this);
    }
}
?>
