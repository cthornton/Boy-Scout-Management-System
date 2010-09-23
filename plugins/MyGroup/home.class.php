<?php
class home extends Controller implements controllable
{
    protected $protected = true;
    private $info = array(), $id, $isLeader;
    
    public function __construct()
    {
        parent::__construct();
        
        
        
        if(isset($_SESSION['curr_group']) && !isset($_GET['id']))
        {
            $this->id = $_SESSION['curr_group'];
        }
        else
        {
            // Make sure they're in this group!
            $this->db->query("SELECT NULL FROM users_groups LEFT JOIN groups ON
                              groups.id = users_groups.id_group
                              WHERE
                              users_groups.id_group=? AND users_groups.id_user=?
                              AND groups.is_interactive = 1",
                              array($_GET['id'], $this->auth->safeID()), 'ii');
            
            if($this->db->numRows() == 1)
            {
                $_SESSION['curr_group'] = $_GET['id'];
                throw new http_redirect('?page=MyGroup');
            }
            else
            {
                throw new unauthorized_exception();
            }
        }
        
        
        
        $this->db->query("SELECT name, description, is_interactive FROM groups WHERE id=? LIMIT 1", $this->id, 'i');
        $this->info = $this->db->easyArray();
        
        
        if($this->info[2] != 1)
        {
            unset($_SESSION['curr_group']);
            throw new notfound_exception();
        }
        
        
        
        // Now the subpages!
        $pages = $this->db->query("SELECT small_title FROM groups_pages WHERE is_home = 0 AND id_group=?", $this->id, 'i');
        
        $r = $this->db->easyMultiArray();
        foreach($r as $a)
            $this->subpages[] = $a[0];
        
        if(count($this->subpages) != 0)
            $this->addSubpageBreak();
        
        $this->subpages[] = 'Roster';
        
        
        // Now is this person the leader?
        $this->db->query("SELECT is_leader FROM users_groups WHERE id_user = ? AND id_group=? LIMIT 1", array($this->auth->safeID(), $this->id), 'ii');
        $res = $this->db->easyArray();
        
        $this->isLeader = ($res[0] == 1 || $this->user->hasMinPremission(4));
        
        // Without this, we get an error!
        $this->db->fetch();
        
        if($this->isLeader)
            $this->subpages[] = 'Add / Edit Pages';
    }
    
    
    
    /**
     * What do do on the default page
     */
    public function GET()
    {
        // Get the default page!
        $this->db->query("SELECT long_title, body, small_title, time_edited FROM groups_pages WHERE is_home = 1 AND id_group=? LIMIT 1", $this->id, 'i');
        
        
        // Yay, it exists!
        if($this->db->numRows() == 1)
        {
            $pinfo = $this->db->easyArray();
            template::assign('ltitle', $pinfo[0]);
            template::assign('body', $pinfo[1]);
            template::assign('title', $this->info[0] . ' - '. $pinfo[2]);
        }
        // Does not exist!
        else
        {
            template::assign('ltitle', 'Error');
            template::assign('body', 'The leader of this group has not yet created a home page.');
            template::assign('title', $this->info[0]);
        }
        
        $this->template->addTemplate('get');
        
    }
    
    public function forward($name)
    {
        if($name == 'Add / Edit Pages')
        {
            if($_GET['page2'] == 'new' || $_GET['page2'] == 'edit')
            {
                $this->easy_forward($_GET['page2']);
            }
            else
            {
                $this->template->addTemplate('addedit');
                $this->db->query("SELECT id, small_title, is_home FROM groups_pages WHERE id_group=? AND is_home=0", $this->id, 'i');
                
                template::assign('mpages', $this->db->easyMultiArray());
                template::assign('title', $this->info[0] . ' - Add &amp; Edit Pages');
            }
        }
        else if($name == 'Roster')
        {
            $this->easy_forward('roster');
        }
        
        // Basic Page
        else
        {
            $this->db->query("SELECT long_title, body, small_title, time_edited FROM groups_pages
                             WHERE is_home = 0 AND id_group=? AND small_title=? LIMIT 1", array($this->id, $name), 'is');
            $pinfo = $this->db->easyArray();
            template::assign('ltitle', $pinfo[0]);
            template::assign('body', $pinfo[1]);
            template::assign('title', $this->info[0] . ' - '. $pinfo[2]);
            
            $this->template->addTemplate('get');
            template::assign('showbottom', true);
        }
    }
    
    
    
}

?>