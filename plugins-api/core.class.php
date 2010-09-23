<?php
class core
{
    
    private $plugin, $user;
    
    private $get; 
    
    /**
     * Includes the plugin file.
     * @param Controller The source file of the plugin
     */
    public function __construct(controllable $controller)
    {
        $this->plugin = $controller;
        $this->user = new user();
    }
    
    /**
     * Execute it!
     */
    public function execute()
    {
        
        // Step 1: See if we have authorization
        if(!$this->plugin->hasAuthorization())
            throw new unauthorized_exception();
        
        // Step 2: Make supage links!
       $this->plugin->setSubpages();
        
        // Step 3: check to see if a subpage is being requested. If
        // so, call the plugin's "forward()" method.
        if($this->plugin->subpageRequested())
        {
            // Now see if it exists!
            if($this->plugin->subpageExists())
            {
                $this->plugin->forward($this->plugin->getSubpageName());
            } else {
                throw new notfound_exception();
            }
        } else {
            
            // Step 4: Now we can call the plugin's GET or POST method!
            if($_SERVER['REQUEST_METHOD'] == 'POST')
                $this->plugin->POST();
            else
                $this->plugin->GET(); 
        }
    }
    
 
    
}

?>