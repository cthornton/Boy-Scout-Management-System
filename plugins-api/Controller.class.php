<?php
class Controller extends apifunctions
{
    protected $get;

    public function __construct()
    {
        parent::__construct();
        $this->get  = array($_GET['page1'], $_GET['page2']);
    }
    
    
    /**
     * This is used to specify if this page is only accesible to those
     * who are logged into the Web site
     */
    protected $protected = false;
    
    /**
     * An array of groups that have premission to access this page.
     * Use the ID of a group.
     */
    protected $validGroups;
    
    /**
     * An array of valid premission ID's that can access this page
     */
    protected $validPermissions;
    
    /**
     * A list of valid subpages. 
     */
    protected $subpages = array();
    
    /**
     * Subpage breaks
     */
    protected $subBreak = array();

    /**
     * Is the page currently protected?
     * @retuen boolean Protected
     */
    public function isProtected()
    {
        return $this->protected;
    }
    
    /**
     * Return a list of valid groups
     * @return array Valid Groups
     */
    public function getValidGroups()
    {
        return $this->validGroups;
    }
    
    
    /**
     * Return a list of valid subpages
     * @return array Subpages
     */
    public function getSubpages()
    {
        return $this->subpages;
    }
    
    /**
     * 
     */
    final public function quick_method($forward, $object)
    {
        $method = 'action_' . $forward;
        
        if(method_exists($object, $method))
            $object->$method();
    }
    
    
    /**
     * Easily load (and execute) a subpage! How easy!
     * @param string $forward The supage being requested
     */
    final public function easy_forward($forward)
    {
        $str = preg_replace("/\s/", "_", $forward);
        plugin_load('subpages/' . $str);
        
        $core = new core(new subpage());
        $core->execute();
    }
    
    
    public function setSubpages()
    {
        $this->template->setSubpages($this->getSubpages(), $this->subBreak);
    }
    
    
    /**
     * Create a break in the links
     */
    protected function addSubpageBreak()
    {
        $this->subBreak[count($this->subpages)] = true;
    }
    
    
    /**
     * Check to see if the current person viewing this page
     * has authorization to do so.
     * @return boolean Has Premission
     */
    final public function hasAuthorization()
    {
        // If the page is protected, check the user's groups
        if($this->isProtected())
        {
            // They just want to allow only those who are logged in!
            if(count($this->getValidGroups()) == 0)
            {
                return $this->auth->isLogged();
            
            } else {
            
                // First make sure the person using this set some groups
                if(is_array($this->getValidGroups()))
                {
                    // Now loop and check!
                    foreach($this->getValidGroups() as $arr)
                    {
                        if(in_array($arr, $this->user->getGroups()))
                            return true;
                    }
                    // If we're at this point, we don't have authorization!
                    return false;
                }
                
                if(count($this->validPermissions) > 0)
                {
                    // Now let's check to see if the user
                    // has the permission to view this page!
                    foreach($this->validPermissions() as $arr)
                    {
                        if(in_array($arr, $this->user->getPermissions()))
                            return true;
                    }
                    
                    // If we're here, no auth!
                    return false;
                }
            }
            
        } else {
            return true;
        }
    }
    
    /**
     * Is a subpage being requested by the user?
     * @return boolean Requested
     */
    public function subpageRequested()
    {
        foreach($this->get as $arr)
            if(!empty($arr))
                return true;
        
        return false;
    }
    
    /**
     * Does one of the requested subpages exist?
     * @return boolean Exists
     */
    public function subpageExists()
    {
        foreach($this->get as $arr)
        {
            if(in_array($arr, $this->getSubpages()))
                return true;
        }
        
        return false;
    }
    
    /**
     * Get the name of the subpage being requested
     * @return string Name
     */
    public function getSubpageName()
    {
        foreach($this->get as $arr)
        {
            if(in_array($arr, $this->getSubpages()))
                return $arr;
        }
        
        return null;
    }
    
    
    /**
     * Handle any POST calls
     */
    public function POST()
    {
        return $this->GET();
    }
    

}
?>