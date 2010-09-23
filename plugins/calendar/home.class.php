<?php
plugin_load('calendar');

class home extends Controller implements controllable
{
    protected $protected = true;
    
    public function __construct()
    {
        parent::__construct();
        
        if($this->user->hasPermission(10))
            $this->subpages[] = 'Add Event';
    }
    
    public function GET()
    {
        template::customCSS('plugins/calendar/ui/layout.css');
        $calendar = new calendar($_GET['month'], $_GET['year']);
        template::assign('daysInMonth', $calendar->daysInMonth());
        template::assign('firstDay', $calendar->firstDay());
        template::assign('canEdit', $this->user->hasPermission(10));
        $this->template->addTemplate('default');

    }
    
    public function forward($name)
    {
        $this->easy_forward($name);
    }
}
?>