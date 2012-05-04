<?php
/**
 * PDO Database handler
 *
 * Interface with the database through PDO connection
 * @package LazyStructure
 */
class Database
{
    private static $db;
    private $dbDriver = "mysql"; // "pgsql" for Postgres
    private $dbHost = "localhost";
    private $dbUsername = "lazystructure";
    private $dbPassword = "lazystructure";
    private $database = "lazystructure";

    private $passwordSalt = ""; 
    private $tokenSeed = "";

    private $hash = 'sha512';

    protected function __construct()
    {
        $this->connect();
    }

    /**
     * connect() makes the database connection
     *
     * Creates a new PDO object with a connection to the database. Triggers a warning if connection fails.
     */
    private function connect()
    {
        try
        {
            self::$db = new PDO($this->dbDriver.':host='.$this->dbHost.';dbname='.$this->database, $this->dbUsername, $this->dbPassword);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(Exception $err)
        {
            trigger_error("Database class is unable to connect", E_USER_WARNING);
        }
    }

    /**
     * query(string) executes an SQL query and returns the result
     *
     * Executes an SQL query
     * - INSERT returns lastInsertId
     * - SELECT returns a multi-dimensional array of resulting records (0 if none)
     * - UPDATE/DELETE returns true if successful, false otherwise
     *
     * Example usage:
     * <code>
     * $this->query("SELECT * FROM table WHERE id = ?", $id);
     * $this->query("SELECT * FROM table WHERE username = ? AND password = ?", $username, $password);
     * $this->query("SELECT * FROM table WHERE username = ? AND password = ?", array($username, $password));
     * </code>
     *
     * @param string $query SQL statement to execute
     * @param mixed any additional arguments are passed as parameters to the query
     * @return array two-dimensional array of results or boolean false
     */
    public function query($query)
    {
        $return = $this->getPdoResult(func_get_args());
        return $this->getPdoReturn($return[0], $return[1]);
    }
    
    /**
     * queryRow(string) executes an SQL query and returns the resulting row
     *
     * Executes an SQL query
     * - SELECT returns a one-dimensional array of the first record retrieved
     *
     * @param string $query SQL statement to execute
     * @param mixed any additional arguments are passed as parameters to the query
     * @return array one-dimensional array of results or boolean false
     */
    public function queryRow($query)
    {
        $return = $this->getPdoResult(func_get_args());
        return $this->getPdoReturn($return[0], $return[1], false);
    }

    /**
     * queryColumn(string) executes an SQL query and returns the resulting value
     *
     * Executes an SQL query
     * - SELECT returns results as a single string;
     *   meant for use in retrieving a single column value
     *
     * @param string $query SQL statement to execute
     * @param mixed any additional arguments are passed as parameters to the query
     * @return string column value
     */
    public function queryColumn($query)
    {
        $return = $this->getPdoResult(func_get_args(), false);
        return $this->getPdoReturn($return[0], $return[1], false);
    }

    /**
     * queryKey(string) executes an SQL query and returns the resulting value
     *
     * Executes an SQL query
     * - SELECT returns results in associative array
     *   based on the key provided
     *
     * @param string $key the key to index on
     * @param string $query SQL statement to execute
     * @param mixed any additional arguments are passed as parameters to the query
     * @return array two-dimensional array of values
     */
    public function queryKey($key, $query)
    {
        $args = func_get_args();
        array_shift($args);
        $return = $this->getPdoResult($args);
        return $this->getPdoReturn($return[0], $return[1], true, $key);
    }

    /**
     * queryKeyRow(string, string) executes an SQL query and returns the resulting value
     *
     * Executes an SQL
     * - SELECT returns results in one-dimensional associative array
     *   comprised of elements of the given key
     *
     * @param string $key the key of the column whose records will comprise the array
     * @param string $query SQL statement to execute
     * @param mixed any additional arguments are passed as parameters to the query
     * @return array one-dimensional array of values
     */
    public function queryKeyRow($key, $query)
    {
        $args = func_get_args();
        array_shift($args);
        $return = $this->getPdoResult($args);
        return $this->getPdoReturn($return[0], $return[1], true, $key, false);
    }

    private function getPdoResult($args, $allColumns=true)
    {
        $query = $args[0];
        array_shift($args);
        $statement = self::$db->prepare($query);

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
        while(isset($args[0]) && is_array($args[0]))
            $args = $args[0];

        try
        {
            // execute returns false if the query fails (syntax error or other such issue)
            if($statement->execute($args) === false)
                return array(false, $statement);
        }
        catch(PDOException $err)
        {
            trigger_error("<pre class=\"triggeredError\">Failed query: {$statement->queryString}</pre>", E_USER_WARNING);
            trigger_error('<pre class="triggeredError">'.$err.'</pre>', E_USER_WARNING);
        }

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

        $lastId = self::$db->lastInsertId();

        
        /*
            For returns when the query does not return any rows: 
                If there's a lastInsertId, it was an insert, so return the lastInsertId
                Otherwise, we want to return the rowCount
        */
        $return = $lastId > 0 ? $lastId : $statement->rowCount();

        /*
            If there are rows to return, return the rows
            Otherwise, return the value calculated above
        */
        $result = $rows ? $rows : $return;
        return array($result, $statement);
    }

    private function getPdoReturn($result, $statement, $allRows=true, $key=false, $allColumns=true)
    {
        // is only false when query fails
        if($result === false || $result === true)
            return $result;
        else if(!is_array($result)) // single column value or number of rows affected
            return $result;
        else // SELECT statements - returns array of rows
        {
            $rows = array();

            // if queryKey, index based on the column (key) provided

            if($allColumns)
                $key ? $rows[$result[$key]] = $result : $rows = array($result);
            else
                $key ? $rows[$result[$key]] = reset($result) : $rows = array(reset($result));

            if($allRows)
            {
                if($key)
                {
                    while($row = $statement->fetch(PDO::FETCH_ASSOC))
                        $rows[$row[$key]] = $allColumns ? $row : reset($row);
                }
                else
                {
                    while($row = $statement->fetch(PDO::FETCH_ASSOC))
                        $rows[] = $allColumns ? $row : reset($row);
                }
            }
            else if(!empty($result))
                return $result;

            return $rows;
        }
    }

    /**
     * getDatabase() returns an instance of the database connection
     *
     * Singleton pattern as applied to the database connection.
     * We only ever want a single connection.
     * 
     * @return Database database connection object
     */
    public static function getDatabase()
    {
        if(isset(self::$instance))
            return self::$instance;
        else
            return self::$instance = new Database();
    }

    /**
     * authenticate(string) verifies a user is logged in
     *
     * Checks if $_SESSION['user'] is set, and if its xsrfToken matches
     * xsrfToken is to protect against cross-site request forgeries
     *
     * @return bool user is authenticated or not
     */
    public function authenticate($xsrfToken)
    {
        // user object exists and xsrfToken matches
        return (isset($_SESSION['user']) && !empty($xsrfToken) && unserialize($_SESSION['user'])->xsrfToken == $xsrfToken);
    }

    /**
     * getHash(string) generates a hash based on the text passed
     *
     * Uses the algorithm specified in $this->hash and salted with $this->passwordSalt
     * 
     * @return string hashed value
     */
    public function getHash($text)
    {
        return hash($this->hash, $this->passwordSalt.$text);
    }

    /**
     * getRandomToken() generates a random string
     *
     * Uses $this->getHash() to hash a combination of $this->tokenSeed and mt_rand()
     *
     * @return string hashed random string
     */
    public function getRandomToken()
    {
        return $this->getHash($this->tokenSeed.mt_rand());
    }

    /**
     * getPassword(string, string) generates the hash for a given password and salt
     *
     * Uses $this->getHash in order to create the hash for the given password
     *
     * @return string hashed password
     */
    public function getPassword($password, $salt)
    {
        return $salt.$this->getHash($salt.$password);
    }

    /**
     * getSalt([int]) generates a random salt of the given length
     *
     * Uses $this->getRandomToken() in order to generate the random string.
     * Length is then a substring of the random token.
     * $this->hash must be a cipher that generates a string longer 
     * than the given salt length
     */
    public function getSalt($length=16)
    {
        return substr($this->getRandomToken(), 0, $length);
    }
    
    /**
     * getPlaceholders([int|array]) returns a comma separated list of PDO placeholders (?)
     *
     * Takes either the number provided or the length of the array and returns that many placeholders
     *
     * @return string list of placeholders
     */
     public function getPlaceholders($amount)
     {
        $num = is_array($amount) ? count($amount) : (int) $amount;
        $list = "";
        for($i=0;$i<$num;++$i)
            $list .= "?,";
        return rtrim($list, ',');
     }
}
?>
