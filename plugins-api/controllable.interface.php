<?php
interface controllable
{
    /**
     * What to do when the home page is simply called.
     */
    public function GET();
    
    /**
     * What to do when a subpage is called
     * @param string $name The name of the subpage
     */
    public function forward($name);
    
    public function subpageRequested();
    public function subpageExists();
    public function getSubpageName();
}