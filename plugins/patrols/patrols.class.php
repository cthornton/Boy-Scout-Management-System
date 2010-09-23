<?php
class patrols extends apifunctions
{
    protected $inPatrol, $patrolExists, $pid, $realPid, $info = array(), $name;
    
    function __construct()
    {
        parent::__construct();
        
        
        /**
         * Find the ID of the patrol that the user is really in
         */
        $this->realPid = $this->user->patrolID();
        $this->pid= $this->realPid;
        
        
        /**
         * Sets the session if they want to view another patrol. Make sure
         * that they have premission to do so!
         */
        if(!empty($_GET['pid']) && is_numeric($_GET['pid']) && $this->user->hasPermission(6))
        {
            $_SESSION['pid'] = $_GET['pid'];
            $this->pid =  $_GET['pid'];
            throw new http_redirect('?page=patrols');
        }
        
        if(isset($_SESSION['pid']))
            $this->pid = $_SESSION['pid'];
        
        
        /**
         * They want to view their own patrol
         */
        if(isset($_GET['ownpatrol']))
        {
            unset($_SESSION['pid']);
            throw new http_redirect('?page=patrols');
        }
        
        
        // Now let's assign a variable to see if they're in a patrol
        $this->inPatrol = ($this->pid != 0);
        
        // Load data from the DB and check to see if it exists
        $this->db->query("SELECT * FROM patrols WHERE id=?", $this->pid, 'i');
        
        // Patrol doesn't exist! (Wha?)
        $this->exists = ($this->db->numRows() != 0);
        
        // They're trying to access another patrol, BUT it does not exist!
        if(!$this->exists && $this->pid != $this->realPid)
            throw new http_redirect('?page=patrols&ownpatrol=1');
        
        
        // Now let's get the information
        $this->db->result($result);
        $this->db->fetch();
        $this->info = $result;
        
        // Assign the name for easy refrence later
        $this->name = $this->info[3];
    }
    
    /**
     * Is the in a patrol / does the user have premission to view this patrol?
     */
    public function inPatrol()
    {
        return $this->inPatrol;
    }
    
    /**
     * Does this patrol exist? 
     */
    public function patrolExists()
    {
        return $this->patrolExists;
    }
    
    /**
     * Gets the patrol id that the user is trying to view
     */
    public function pid()
    {
        return $this->pid;
    }
    
    /**
     * Get the patrol id that the user is actually in
     */
    public function realPid()
    {
        return $this->realPid;
    }
    
    /**
     * Get some information about the patrol currently being viewed
     *
     *  [0] => ID
     *  [1] => ID_PL
     *  [2] => Special (1 = special, 0 = not special)
     *  [3] => Name
     *  [4] => Patrol Name
     *  [5] => Patrol Description
     */
    public function getInfo()
    {
        return $this->info;
    }
    
    /**
     * Get the name of the patrol
     */
    public function name()
    {
        return $this->name;
    }
    
    
}

?>