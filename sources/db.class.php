<?php
class db
{
    private static $cnx;
    private $stmt, $result = array();
    
    /**
     * Create a new Database connection if it does not exist
     */
    public function __construct()
    {
        if(empty(self::$cnx))
        {
            $cnx = new cnx();
            self::$cnx = $cnx->getConnection();
        }
    }
    
    /**
     * Prepare a query to use and then execute it. Examples:
     *  - $db->query("SELECT * FROM ?", "table", 's');
     *  - $db->query("SELECT * FROM ? WHERE ID=?", array("table", 12), 'si');
     *  
     * @param string $query Query to execute
     * @param string/array $params Parameters to use - can either be an array or string
     * @param string $types Types to bind to the query
     */
    public function query($query, $params = null, $types = null)
    {
        if(!empty($this->stmt))
        {
            $this->stmt->free_result();
            $this->stmt->close();
        }
        
        $this->stmt = self::$cnx->prepare($query);
        
        if(!$this->stmt)
            throw new Exception("Error preparing query! Make sure you typed the query correctly.");
        
        // If they're actually binding parameters
        if(!empty($params) || !empty($types))
        {
            // Convert the params to an array if it isn't
            if(!is_array($params))
                $params = array($params);
            
            // Make sure parameters and types match
            if(strlen($types) !== count($params))
                throw new Exception("Number of parameters do not match number of types!");
            
            $this->bindParams($this->stmt, $params, $types);
        }
        
        // Now we can execute it!
        if(!$this->stmt->execute())
            throw new Exception("Error with Query!");
    }
    
    /**
     * Assign what will be an array to a variable
     * Example:
     *  - $db->result($result);
     *  
     * @param null $arr Array to use for the results
     */
    public function result(&$arr)
    {
        for($i = 0; $i < $this->stmt->field_count; $i++)
        {
            $params[] = &$arr[$i];
        }
        
        // Now bind the results!
        call_user_func_array(array($this->stmt, 'bind_result'), $params);
    }
    
    
    /**
     * Easily returns an array with a single row for a result
     */
    public function easyArray()
    {
        $this->result($result);
        $this->fetch();
        return $result;
    }
    
    
    /**
     * Returns a simple to use array with the drawback of a bit
     * more CPU usage
     */
    public function easyMultiArray()
    {
        $ret = array();
        
        $this->result($result);
        
        while($this->fetch())
        {
            $val = array();
            for($i = 0; $i < $this->stmt->field_count; $i++)
            {
                $val[$i] = $result[$i];
            }
            
            $ret[] = $val;
        }
        
        return $ret;
        
    }
    
    
    /**
     * Get the number of rows
     * @return int Number of rows
     */
    public function numRows()
    {
        $this->stmt->store_result();
        return $this->stmt->num_rows;
    }
    
    /**
     * Used for a "for" loop.
     * @return boolean More rows
     */
    public function fetch()
    {
       return $this->stmt->fetch();
    }
    
    
    /**
     * Bind parameters to a statement given, which is refrenced
     * @param statement &$statement Statement to bind
     * @param array $params Parameters to bind
     * @param string $types Types to bind to the parameters
     */
    private function bindParams(&$statement, $params, $types)
    {
        // The array we will pass
        $vals = array($types);
        
        foreach($params as $arr)
        {
        	if(get_magic_quotes_gpc())
            	$vals[] = stripslashes($arr);
            else
            	$vals[] = $arr;
        }
        
        // Now we need to make it pass by ref for PHP 5.3+
        $refArr = array();
        foreach($vals as $k=>$v) $refArr[$k] = &$vals[$k];
        call_user_func_array(array($this->stmt, 'bind_param'), $refArr);
    }
    
    /**
     * Escape a string for Database use (unnescesary with prepared statements).
     * Compatible with both magic_quotes on or off.
     * @param string $str String to escape
     * @param boolean $html Preform htmlentities (DEFAULT: no)
     * @return string Escaped String
     */
    public function es($str, $html = false)
    {
        // If Magic Quotes are enabled, undo it!
        if(get_magic_quotes_gpc())
            $str = stripslashes($str);
        
        // Did they want to run htmlentities?
        if($html)
            $str = htmlentities($str);
        
        return self::$cnx->real_escape_string($str);
    }
    
}
?>
