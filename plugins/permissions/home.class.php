<?php
plugin_load('permissions');

class home extends Controller implements controllable
{
    protected $protected = true;
    protected $validGroups = array(1);
    
    public function __construct()
    {
        parent::__construct();
        template::customCSS('plugins/admin/ui/viewpages.css');
        template::customCSS('plugins/admin/ui/addpage.css');
        
        $this->subpages[] = 'Create New Permission';
    }
    
    public function GET()
    {
        $this->template->addTemplate('edit');
        $perm = new permissions();
        template::assign('permissions', $perm->getPermissions());
    }
    
    public function forward($name)
    {
        if(isset($_POST['submit']))
        {
            if(!empty($_POST['name']) && !empty($_POST['descript']))
            {
                $this->db->query("INSERT INTO permissions (title, description) VALUES (? , ?)",
                                 array(htmlentities($_POST['name']), htmlentities($_POST['descript'])), 'ss');
                template::assign('success', true);
            }
            else
            {
                template::assign('error', true);
            }
            
        }
        // We only have one subpage... Yay!
        $this->template->addTemplate('create');
    }
}
?>