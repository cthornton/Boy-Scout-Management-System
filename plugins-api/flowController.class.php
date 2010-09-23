<?php
class flowController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->get[0] = null;
    }
    
    /**
     * A quick fix so that any subpages will be valid, therefore
     * calling the controller's forward() method. USE WITH CAUTION!
     */
    public function subpageExists()
    {
        return true;
    }
    
    /**
     * Get the name of the subpage being requested
     * @return string Name
     */
    public function getSubpageName()
    {
        return array_pop($this->get);
    }
    
    
    /**
     * Fix for subpages
     */
    public function setSubpages()
    {
        if(count($this->subpages) > 0)
            parent::setSubpages();
    }
}

?>