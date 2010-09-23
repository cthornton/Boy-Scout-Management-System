<?php
class users
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
                          LIMIT 1", $id, 'i');
        
        $this->db->result($result);
        
        // We need to do fetch() twice :<
        $this->db->fetch();
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
                          LIMIT 1", $id, 'i');
        
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
     * Get a list of "Interactive" groups that this user is in
     */
    public function getInteractiveGroups($id)
    {
        $this->db->query("SELECT
                            groups.id, groups.name
                          FROM
                            groups
                          LEFT JOIN
                            users_groups
                          ON
                            users_groups.id_group = groups.id
                         WHERE
                            groups.is_interactive = 1
                          AND
                            users_groups.id_user = ?",
                          $id, 'i');
        
        return $this->db->easyMultiArray();
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
                            id=?
                          LIMIT 1", $id, 'i');
        
        $arr =  $this->db->easyArray();
        
        // Don't know why, but this fixes an issue...
        $this->db->fetch();
        return $arr;
    }
    
    /**
     * Get an array of groups
     * 
     */
    
    public function getGroups($id)
    {
        $groups = array();
        $this->db->query("SELECT id_group FROM users_groups WHERE id_user=?",
                         $id, 'd');
        
        $this->db->result($result);
        while($this->db->fetch())
            $groups[] = $result[0];
        
        return $groups;
    }
    
    /**
     * Get the latest announcements for the user
     */
    public function getLatestAnnouncements($id)
    {
        $this->db->query("
            SELECT ID, ID_PATROL, title, content, time_posted
            FROM `announcements`
            WHERE id_patrol =0
            OR id_patrol = (
            SELECT id_patrol
            FROM users
            WHERE id=? )
            AND time_posted > " . (time() - 2678400) . "
            ORDER BY time_edited ASC
            LIMIT 0 , 10 ", $id, 'i');
        
        return $this->db->easyMultiArray();

    }
    
    /**
     * This shouldn't be here, but oh well I don't care.
     *
     * Gets the latest calendar events
     */
    public function getCalEvents()
    {
        $t = time();
        
        $d1 = date('j', $t) - 1;
        $m1 = date('n', $t) - 1;
        $y1 = date('Y', $t) - 1;
        
        $m2 = $m1 + 2;
        
        if($m2 > 12)
            $m2 = $m2 % 12;
        
        $y2 = $m2 >= 12 ?  $y1 + 3 : $y1 + 2;
        
        $this->db->query(
           "SELECT DISTINCT t1.id, t1.month, t1.day, t1.year, t1.title, t1.description, t1.recuring, t2.id_cal FROM calendar AS t1
            LEFT JOIN calendar_recuring AS t2 
            ON t1.id = t2.id_cal
            WHERE (t1.day > {$d1} OR t2.day > {$d1}) AND (t1.month > {$m1} OR t2.month > {$m1})   AND (t1.year > {$y1} OR t2.year > {$y1})
            AND   (t1.day < 32 OR t2.day < 32) AND (t1.month < {$m2} OR t2.month < {$m2}) AND (t1.year < {$y2} OR t2.year < {$y2})
            ORDER BY YEAR desc, month DESC, day DESC LIMIT 0, 15");
        
        return $this->db->easyMultiArray();
    }
}