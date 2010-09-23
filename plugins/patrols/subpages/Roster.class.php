<?php
class subpage extends flowController implements controllable
{
    public function GET()
    {
        $patrol = new patrols();
        throw new http_redirect('?page=roster&pid=' . $patrol->pid() . '&callback=patrol');
    }
    
    public function forward($name)
    {
        $this->GET();
    }
}


?>