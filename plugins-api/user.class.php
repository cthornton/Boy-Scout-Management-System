<?php
class user
{
    private $auth, $uid, $logged, $groups = array(), $db, $patrol;
    
    private $premissions;
    
    public function __construct()
    {
        $this->auth = new auth();
        $this->db = new db();
        
        // Now let's check some stuff!
        $this->logged = $this->auth->isLogged();
        
        if($this->logged)
        {
            $this->uid = $this->auth->safeID();
            $this->exePatrols();
            $this->exeGroups();
            $this->premissions = $this->getDBPremissions();
        }
    }
    
    /**
     * Helper function to get the user's premissions
     */
    private function getDBPremissions()
    {
        $ret = array();
        
        $this->db->query("SELECT
                            groups_permission.ID_PERMISSION
                          FROM
                            groups_permission, users_groups
                          WHERE
                            users_groups.ID_USER  = ?
                          AND
                            groups_permission.ID_GROUP = users_groups.ID_GROUP
                            ",
                            $this->uid, 'i');
        
        $this->db->result($result);
        
        while($this->db->fetch())
            $ret[] = 0 + $result[0];
        
        return $ret;
    }
    
    private function exePatrols()
    {
        $this->db->query("SELECT patrols.ID, patrols.ID_PL, patrols.name FROM patrols LEFT JOIN users ON users.ID_PATROL = patrols.id WHERE users.id=?",
                         $this->uid, 'i');
        
        $this->db->result($result);
        $this->db->fetch();
        $this->patrol = $result;
    }
    
    
    private function exeGroups()
    {
        $this->db->query("SELECT id_group FROM users_groups WHERE id_user=? ORDER BY id_group ASC",
                         $this->uid, 'd');
        
        $this->db->result($result);
        while($this->db->fetch())
            $this->groups[] = $result[0];
    }
    
    public function getPremissions()
    {
        return $this->premissions;
    }
    
    
    public function getGroups()
    {
        return $this->groups;
    }
    
    public function logged()
    {
        return $this->logged;
    }
    
    public function ID()
    {
        return $this->uid;
    }
    
    public function inGroup($id)
    {
        return in_array($id, $this->groups);
    }
    
    public function isAdmin()
    {
        return $this->inGroup(1);
    }
    
    /**
     * Gets the premission level of the user
     * 1 - Administrator
     * 2 - Webmaster
     * 3 - Scoutmaster
     * 4 - SPL or ASPL
     * 0 - None
     */
    public function premissionLevel()
    {
        if($this->isAdmin())
            return 1;
        if($this->inGroup(2))
            return 2;
        if($this->inGroup(3))
            return 3;
        if($this->inGroup(4))
            return 4;
        if($this->inGroup(5))
            return 4;
        
        return 0;
    }
    
    /**
     * Does the user have premission? Valid numbers:
     * 1 - Administrator
     * 2 - Webmaster
     * 3 - Scoutmaster
     * 4 - SPL or ASPL
     * @deprecated
     */
    public function hasMinPremission($num)
    {
        return ($this->premissionLevel() <= $num && $this->premissionLevel() != 0);
    }
    
    /**
     * A newer version of permissions. This should be used over the hasMinPremission
     * method. Groups are now assigned premissions via the Web site. This checks to
     * see if the user's group has premission, based off the ID given. Note that you
     * can pass an array instead of a single integer.
     * @param int $id ID for the premission
     * @return boolean Has Premission
     */
    public function hasPremission($id)
    {
        
        if(!$this->logged)
            return false;
        
        // Let's first check to see if they're an admin so
        // admins aren't accidentally locked out of anything!
        if($this->inGroup(1))
            return true;
        
        // If they gave us an array!
        if(is_array($id))
        {
            foreach($id as $arr)
            {
                if(in_array($arr, $this->premissions))
                    return true;
            }
        
        // They gave us a single integer value :O
        }
        else
        {
            if(in_array($id, $this->premissions))
                return true;
        }
        
        // If we're here, then they don't have premission
        return false;
    }
    
    /**
     * Since I mispelt "Permission" D:
     */
    public function hasPermission($id)
    {
        return $this->hasPremission($id);
    }
    
    
    public function patrolID()
    {
        return $this->patrol[0];
    }
    
    public function isPL()
    {
        return ($this->uid == $this->patrol[1]);
    }
    
    public function patrolName()
    {
        return $this->patrol[2];
    }
    
}

?>