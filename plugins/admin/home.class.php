<?php
class home extends Controller implements controllable
{
    protected $protected = true;
    protected $validPermissions = array(1, 2, 3, 4, 5, 6);
    
    public function __construct()
    {
        parent::__construct();
        
        /**
         * Set subpages for the correct people
         */
        if($this->user->hasPermission(5))
            $this->subpages[] = 'Announcements';
        
        if($this->user->hasPermission(6))
            $this->subpages[] = 'Patrols';
        
        if($this->user->hasPremission(3))
            $this->subpages[] = 'Groups';
        
        if($this->user->hasPremission(2))
        {
            $this->subpages[] = 'Add a Page';
            $this->subpages[] = 'Edit Pages';
        }
    }
    
    /**
     * What do do on the default page
     */
    public function GET()
    {
        template::assign('title', 'Admin Central');
        $this->template->addTemplate('GET');
        
    }
    
    public function forward($name)
    {
        $this->easy_forward($name);
    }
    
    
    
}

?>