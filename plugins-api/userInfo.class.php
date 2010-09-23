<?php
class userInfo
{
    private $db;
    
    /**
     * Simply create a new database object.
     */
    public function __construct()
    {
        $this->db = new db();
    }
    
    /**
     * Fetches basic user information by a given ID
     * @param int $id Id of the user to find
     * @return array User information:
     *  [0] => ID
     *  [1] => Patrol ID
     *  [2] => Email Address
     *  [3] => First Name
     *  [4] => Last Name
     * If no user is found, an empty array will be displayed.
     */
    public function getBasicUserByID($id)
    {
        $this->db->query("SELECT
                            ID, ID_PATROL, email, fname, lname
                          FROM users WHERE
                            ID=?
                          LIMIT 0, 1", $id, 'i');
        
        $this->db->result($result);
        $this->db->fetch();
        return $result;
    }
    
    /**
     * Gets the name of someone based off an ID
     * @param int $id ID of the user to find
     * @return array User Information:
     *  [0] => First Name
     *  [1] => Last Name
     */
    public function getNameByID($id)
    {
        $this->db->query("SELECT
                            fname, lname
                          FROM users WHERE
                            ID=?
                          LIMIT 0,1", $id, 'i');
        
        $this->db->result($result);
        $this->db->fetch();
        return $result;
    }
    
    /**
     * Returns a person's name by ID parsed in this format:
     *  Joe Smith
     *   - or -
     *  FirstName LastName
     *
     *  @param int $id ID of the user to find
     *  @return string Name
     */
    public function getParsedNameByID($id)
    {
        $arr = $this->getNameByID($id);
        return $arr[0]. ' '. $arr[1];
    }
    
    /**
     * Get all of the possible user information, except the password
     * @param int $id ID of the user to find
     * @return array Info:
     *  [0] => ID
     *  [1] => Patrol ID
     *  [2] => Username
     *  [3] => Email
     *  [4] => First Name
     *  [5] => Last Name
     *  [6] => Phone Number
     *  [7] => Address Line 1
     *  [8] => Address Line 2
     *  [9] => City
     *  [10] => Date Registered (timestamp)
     */
    public function getAllDataByID($id)
    {
        $this->db->query("SELECT
                            ID, ID_PATROL, user, email, fname, lname, phone, address1, address2, city, date_reg
                          FROM users WHERE
                            ID=?
                          LIMIT 0, 1", $id, 'i');
        
        $this->db->result($result);
        $this->db->fetch();
        
        return $result;
    }
}