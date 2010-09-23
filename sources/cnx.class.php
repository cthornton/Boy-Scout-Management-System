<?php
class cnx
{
    private $cnx;

    /**
     * Make a new conneciton to the database
     */
    public function __construct()
    {
    	global $db_user, $db_pass, $db_host, $db_name;

        $this->cnx = @new mysqli($db_host, $db_user, $db_pass, $db_name);

        // If we didn't get a 0, then we didn't connect
        if(@$this->cnx->errno !== 0)
            throw new Exception("Cannot connect to Database!");

		// Destroy these variables for security purposes
        unset($db_host, $db_user, $db_pass, $db_name);
    }

    /**
     * Return the current connection
     */
    public function getConnection()
    {
        return $this->cnx;
    }
}


?>