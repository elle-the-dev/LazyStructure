<?php
class Database
{
    static $instance;
    
    private $db;
    private $dbHost = "localhost";
    private $dbUsername = "";
    private $dbPassword = "";
    private $database = "lazystructure";

    private $passwordSalt = ""; 
    private $tokenSeed = "";

    private function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        try
        {
            $this->db = new PDO('mysql:host='.$this->dbHost.';dbname='.$this->database, $this->dbUsername, $this->dbPassword);
        }
        catch(Exception $err)
        {
            trigger_error("Database class is unable to connect", E_USER_WARNING);
        }
    }

    public function query($query)
    {
        /*
            Executes an SQL query
            -INSERT returns lastInsertId
            -SELECT returns a multi-dimensional array of resulting records (0 if none)
            -UPDATE returns true if successful, false otherwise
            
            Example usage:
            $this->query("SELECT * FROM table WHERE id = ?", $id);
            $this->query("SELECT * FROM table WHERE username = ? AND password = ?", $username, $password);
            $this->query("SELECT * FROM table WHERE username = ? AND password = ?", array($username, $password));
        */
        $return = $this->getPdoResult(func_get_args());
        return $this->getPdoReturn($return[0], $return[1]);
    }
    
    public function queryRow($query)
    {
        /*
            Executes an SQL query
            -SELECT returns a one-dimensional array of the first record retrieved
        */
        $return = $this->getPdoResult(func_get_args());
        return $this->getPdoReturn($return[0], $return[1], false);
    }

    public function queryColumn($query)
    {
        /*
            Executes an SQL query
            -SELECT returns results as a single string;
             meant for use in retrieving a single column value
        */
        $return = $this->getPdoResult(func_get_args(), false);
        return $this->getPdoReturn($return[0], $return[1], false);
    }

    public function getPdoResult($args, $allColumns=true)
    {
        $query = $args[0];
        array_shift($args);
        $statement = $this->db->prepare($query);
        if(is_array($args[0]))
            $args = $args[0];
        $statement->execute($args);
        if($allColumns)
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        else
            $result = $statement->fetchColumn();
        return array($result, $statement);
    }

    public function getPdoReturn($result, $statement, $allRows=true)
    {
        $rows = array($result);
        if($allRows)
        {
            while(@$row = $statement->fetch(PDO::FETCH_ASSOC))
                $rows[] = $row;
        }
        else if(!empty($result))
            return $result;

        if(is_array($rows[0]))
            return $rows;
        else
            return $this->db->lastInsertId();
    }

    public static function getDatabase()
    {
        if(isset($instance))
            return $this->instance;
        else
            return self::$instance = new Database();
    }

    public function authenticate($xsrfToken)
    {    
        return (isset($_SESSION['user']) && !empty($xsrfToken) && unserialize($_SESSION['user'])->xsrfToken == $xsrfToken);
    }
    
    public function getHash($text)
    {
        return hash('sha512', $this->passwordSalt.$text);
    }

    public function getRandomToken()
    {
        return $this->getHash($this->tokenSeed.mt_rand());
    }
    
    public static function isAjax()
    {
        /*
            If a request is made via AJAX, the server's HTTP_X_REQUESTED_WITH value will be XMLHttpRequest
        */
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
?>
