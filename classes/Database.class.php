<?php
class Database
{
    static $instance;
    
    private $db;
    private $dbHost = "localhost";
    private $dbUsername = "";
    private $dbPassword = "";
    private $database = "";

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
        return implode($this->queryRow($query));
    }

    public function getPdoResult($args)
    {
        $query = $args[0];
        array_shift($args);
        $statement = $this->db->prepare($query);
        $statement->execute($args);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
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

    public function authenticate()
    {    
        return (isset($_SESSION['login']) && $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']);
    }
    
    public function getHash($text)
    {
        return hash('sha512', $text);
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
