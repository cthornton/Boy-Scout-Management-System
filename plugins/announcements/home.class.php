<?php
plugin_load('announcements');

class home extends Controller implements controllable
{
    protected $protected = true;
    
    private $announce;
    
    public function __construct()
    {
        parent::__construct();
        $this->announce = new announcements();
        
        // If they're in a patrol...
        if($this->user->patrolID() != 0)
            $this->subpages[] = "My Patrol";
        
    }
    
    /**
     * Default Page
     */
    public function GET()
    {
        $permission = $this->user->hasPermission(5);
        
        if($_GET['action'] == 'edit')
        {
            $this->editPage($permission);
        }
        else
        {
            $this->template->addTemplate('home');
            
            template::assign('hasPremission', $permission);
            template::assign('announcements', $this->announce->getBasic());
            template::assign('title', 'Troop Announcements');
            template::assign('ltitle', 'Announcements');
            
            template::customCSS('plugins/announcements/ui/view.css');
        }
        
    }
    
    public function forward($name)
    {
        if($this->user->isPL() || $this->user->hasPermission(5))
            $permission = true;
        else
            $permission = false;
        
        if($_GET['action'] == 'edit')
        {
            $this->editPage($permission);
        }
        else
        {
        
            $this->template->addTemplate('home');
            
            template::assign('hasPremission', $permission);
            template::assign('announcements', $this->announce->getBasic($this->user->patrolID()));
            template::assign('title', 'Patrol Announcements');
            template::assign('ltitle', 'Announcements for My Patrol');
            template::assign('isPatrol', true);
            
            template::customCSS('plugins/announcements/ui/view.css');
        }
    }
    
    private function updateAnnouncement($id)
    {
        $this->db->query("UPDATE announcements SET title=?, content=?, time_edited=? WHERE id=?",
                         array(htmlentities($_POST['name']), htmlentities($_POST['descript']), time(), $id), 'ssii');
    }
    
    private function deleteAnnouncement($id)
    {
        $this->db->query("DELETE FROM announcements WHERE id=?", $id, 'i');
    }
    
    private function handlePost()
    {
        if($_POST['submit'] == 'Delete')
        {
            $this->deleteAnnouncement($_GET['id']);
            throw new http_redirect('?page=announcements');
        }
        else
        {
            $this->updateAnnouncement($_GET['id']);
            template::assign('created', true);
        }
    }
    
    private function getAnnouncement($id)
    {
        $this->db->query("SELECT title, content FROM announcements WHERE id=? LIMIT 1", $id, 'i');
        return $this->db->easyArray();
    }
    
    private function editPage($permission)
    {
        template::assign('title', 'Edit Announcement');
        
        // Do we have premission
        if(!$permission)
            throw new unauthorized_exception();
        
        $info = $this->getAnnouncement($_GET['id']);
        
        // Does the page exist?
        if($info[0] == null)
            throw new notfound_exception();
        
        if(isset($_POST['submit']))
        {
            $this->handlePost();
            
            // Refresh data
            $info = $this->getAnnouncement($_GET['id']);
        }
        
        template::assign('aid', $_GET['id']);
        template::assign('aName', $info[0]);
        template::assign('description', $info[1]);
        template::customCSS('plugins/admin/ui/addpage.css');
        $this->template->addTemplate('edit');
    }

}    
?>