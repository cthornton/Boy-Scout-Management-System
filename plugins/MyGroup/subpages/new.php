<?php
plugin_load('validateFields');

class subpage extends flowController implements controllable
{
    private $id;
    public function __construct()
    {
        parent::__construct();
        template::assign('title', 'Create a new page');
        template::assign('action', 'new');
        template::customCSS('plugins/admin/ui/addpage.css');
        template::assign('button', 'Create Page');
        
        if($this->user->hasMinPremission(1))
            $_SESSION['uploadmode'] = true;
        
        $this->id = $_SESSION['curr_group'];
    }
    
    public function GET()
    {
        
        // So we can get all of the pages
        $return = array();
        
        $this->db->query("SELECT
                            small_title, ID, is_home
                         FROM groups_pages WHERE id_group = 0
                         ORDER BY id ASC", $this->id, 'i');
        
        $return = $this->db->easyMultiArray();
        
        
        template::assign('allLinks', $return);
        $this->template->addTemplate('addpage');
    }
    
    public function forward($name)
    {
        if(isset($_POST['submit']))
        {
            $v = new validateFields();
            template::assign('linktitle', htmlentities($_POST['stitle']));
            template::assign('pagetitle', htmlentities($_POST['ltitle']));
            template::assign('content', $_POST['content']);
           
            $err = array();
            
            // Check for errors
            
            if(!$v->validate($_POST['stitle'], 1, 10))
               $err[] = 'Link title must be between 1 and 10 characters';
            
            if(!$v->validate($_POST['ltitle'], 1))
                $err[] = 'Page title must be at least 1 character';
            
            if(!$v->validate($_POST['content'], 1))
                $err[] = ('Content must be at least 1 character');
        
            // Make sure the title doesn't exist
            $this->db->query("SELECT NULL FROM groups_pages
                             WHERE ID_GROUP = ? AND small_title=?
                             ORDER BY id DESC", array($this->id, $_POST['stitle']), 'is');
            
            if($this->db->numRows() != 0)
                $err[] = 'The title you selected already exists';
        
            // What to do w/ the errors
            if(count($err) > 0)
            {
                
                $this->template->addTemplate('addpage');
                template::assign('allLinks', $return);
                template::assign('POSTERR', $err);
            
            // No errors; add it to the database
            } else {
                
                $this->db->query("INSERT INTO groups_pages (id_group, small_title, long_title, body, time_edited)
                                  VALUES (?, ?, ?, ?, ?)", array($this->id, htmlentities($_POST['stitle']), htmlentities($_POST['ltitle']),
                                                                 $_POST['content'], time()), 'isssi');
                
                template::load('genericpage');
                template::assign('longtitle', 'Page added!');
                template::assign('content', 'You have successfully created a new page.<p><a href="?page=MyGroup&amp;page1=Add / Edit Pages">Back</a>');
            }
        }
        else
        {
            $this->template->addTemplate('addpage');
        }
        
    }
}
?>