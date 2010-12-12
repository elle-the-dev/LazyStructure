<?php
class Database
{
    static $instance;
    
    private $db;
    private $dbDriver = "mysql"; // "pgsql" for Postgres
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
            $this->db = new PDO($this->dbDriver.':host='.$this->dbHost.';dbname='.$this->database, $this->dbUsername, $this->dbPassword);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

    public function queryKey($key, $query)
    {
        /*
            Executes an SQL query
            -SELECT returns results in associative array
             based on the key provided
        */
        $args = func_get_args();
        array_shift($args);
        $return = $this->getPdoResult($args);
        return $this->getPdoReturn($return[0], $return[1], true, $key);
    }

    public function getPdoResult($args, $allColumns=true)
    {
        $query = $args[0];
        array_shift($args);
        $statement = $this->db->prepare($query);

        // if the statement failed, there's an issue with the query itself
        // the first element is false as the statement failed (return false)
        if(!$statement)
            return array(false, $statement);

        /*
            checks to see if the first parameter passed is an array
            if it's an array, use that instead of multiple parameters
            this allows the query functions to accept the parameters
            as part of an array rather than passing them individually
        */
        if(isset($args[0]) && is_array($args[0]))
            $args = $args[0];

        // execute returns false if the query fails (syntax error or other such issue)
        if($statement->execute($args) === false)
            return array(false, $statement);

        try
        {
            // default, return everything in an associative array
            if($allColumns)
                $rows = $statement->fetch(PDO::FETCH_ASSOC);
            else
                $rows = $statement->fetchColumn(); // specifically for queryColumn
        }
        catch(Exception $err)
        {
            $rows = false;
        }

        $lastId = $this->db->lastInsertId();
        $return = $lastId > 0 ? $lastId : $statement->rowCount();
        $result = $rows ? $rows : $return;
        return array($result, $statement);
    }

    public function getPdoReturn($result, $statement, $allRows=true, $key=false)
    {
        // is only false when query fails
        if($result === false || $result === true)
            return $result;
        else if(!is_array($result))
            return $result;
        else // SELECT statements
        {
            $rows = array();

            // if queryKey, index based on the column (key) provided
            $key ? $rows[$result[$key]] = $result : $rows = array($result);

            if($allRows)
            {
                if($key)
                {
                    while(@$row = $statement->fetch(PDO::FETCH_ASSOC))
                        $rows[$row[$key]] = $row;
                }
                else
                {
                    while(@$row = $statement->fetch(PDO::FETCH_ASSOC))
                        $rows[] = $row;
                }
            }
            else if(!empty($result))
                return $result;

            return $rows;
        }
    }

    public static function getDatabase()
    {
        /*
            Singleton pattern as applied to the database connection
        */
        if(isset(self::$instance))
            return self::$instance;
        else
            return self::$instance = new Database();
    }

    public function authenticate($xsrfToken)
    {
        // user object exists and xsrfToken matches
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
