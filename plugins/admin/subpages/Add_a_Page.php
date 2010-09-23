<?php
plugin_load('validateFields');

class subpage extends flowController implements controllable
{
    public function __construct()
    {
        parent::__construct();
        template::assign('title', 'Create a new page');
        template::assign('action', 'Add a Page&amp;page2=add');
        template::customCSS('plugins/admin/ui/addpage.css');
        template::assign('button', 'Create Page');
        
        $_SESSION['uploadmode'] = true;
    }
    
    public function GET()
    {
        
        // So we can get all of the pages
        $return = array();
        
        $this->db->query("SELECT
                            small_title, sub_id, ID
                         FROM pages WHERE sub_id = 0
                         ORDER BY is_hidden, id, sub_id ASC");
        
        $this->db->result($result);
        while($this->db->fetch())
            $return[] = array($result[0], $result[1], $result[2], $result[3]);
        
        
        template::assign('allLinks', $return);
        $this->template->addTemplate('addpage');
    }
    
    public function forward($name)
    {

        // Make sure they're accessing this page correctly
        if($name == 'add' && isset($_POST['submit']))
        {
            $v = new validateFields();
            template::assign('linktitle', htmlentities($_POST['stitle']));
            template::assign('pagetitle', htmlentities($_POST['ltitle']));
            template::assign('content', $_POST['content']);
            template::assign('subid', $_POST['subpg']);
            template::assign('pghidden', $_POST['hidden']);
            template::assign('pgprotected', $_POST['protected']);
           
            $err = array();
            
            // Check for errors
            
            if(!$v->validate($_POST['stitle'], 1, 10))
               $err[] = 'Link title must be between 1 and 10 characters';
            
            if(!$v->validate($_POST['ltitle'], 1))
                $err[] = 'Page title must be at least 1 character';
            
            if(!$v->validate($_POST['content'], 1))
                $err[] = ('Content must be at least 1 character');
        
            // What to do w/ the errors
            if(count($err) > 0)
            {
                $db->query("SELECT
                                    small_title, sub_id, ID
                                 FROM pages
                                 ORDER BY is_hidden, id, sub_id ASC");
                
                $db->result($result);
                while($db->fetch())
                    $return[] = array($result[0], $result[1], $result[2], $result[3]);
                
        
                template::assign('allLinks', $return);
                template::assign('POSTERR', $err);
                $this->template->addTemplate('addpage');
            
            // No errors; add it to the database
            } else {
                
                $hidden = ($_POST['hidden'] == 1) ? 1 : 0;
                $protected = ($_POST['protected'] == 1) ? 1 : 0;
                $this->db->query("INSERT INTO pages
                                 (SUB_ID, position, small_title, large_title, content, time_edited, is_hidden, is_protected)
                                 VALUES
                                  (?, ?, ?, ?, ?, ?, ?, ?)",
                        array($_POST['subpg'], 0, $_POST['stitle'], $_POST['ltitle'], $_POST['content'], time(), $hidden, $protected)
                                  , 'iisssiii' );
                
                template::load('genericpage');
                template::assign('longtitle', 'Page added!');
                template::assign('content', 'You have successfully created a new page.<p><a href="?page=admin&amp;page1=Add a Page">Back</a>');
            }
        
        } else {
            throw new http_redirect('?page=admin&page1=Add a Page');
        }
    }
}
?>