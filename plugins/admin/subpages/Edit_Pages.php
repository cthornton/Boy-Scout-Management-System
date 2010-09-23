<?php
plugin_load('validateFields');

class subpage extends flowController implements controllable
{
    public function __construct()
    {
        parent::__construct();
        $this->validGroups = array(1);
        template::customCSS('plugins/admin/ui/viewpages.css');
        template::customCSS('plugins/admin/ui/addpage.css');
        template::assign('title', 'Modify Pages');
        
        // Allow file uploads
        $_SESSION['uploadmode'] = true;
    }
    
    public function GET()
    {
        // So we can get all of the pages
        $return = array();
        
        $this->db->query("SELECT
                            small_title, large_title, sub_id, ID
                         FROM pages
                         ORDER BY is_hidden, id, sub_id ASC");
        
        $this->db->result($result);
        while($this->db->fetch())
            $return[] = array($result[0], $result[1], $result[2], $result[3]);
        
        
        template::assign('allLinks', $return);
        $this->template->addTemplate('viewpages');
    }
    
    public function forward($name)
    {
        // So we can get all of the pages
        $return = array();
        
        $this->db->query("SELECT
                            small_title, sub_id, ID
                         FROM pages WHERE sub_id = 0
                         ORDER BY is_hidden, id, sub_id ASC");
        
        $this->db->result($result);
        while($this->db->fetch())
            $return[] = array($result[0], $result[1], $result[2]);
        
        
        template::assign('allLinks', $return);
        
        
        $this->db->query("SELECT * FROM pages WHERE id=?", $name, 'd');
        
        if($this->db->numRows() > 0)
        {
            template::assign('action', 'Edit Pages&amp;page2=' . $name);
            // They want to delete a page!
            if($_GET['action'] == 'delete')
            {
                $this->db->query("DELETE FROM pages WHERE id=? OR sub_id=?", array($name, $name), 'ii');
                throw new http_redirect('?page=admin&page1=Edit Pages');
            } else {
                $this->db->result($result);
                $this->db->fetch();
                
                template::assign('button', 'Edit Page');
                
                if(!isset($_POST['submit']))
                {
                    
                    template::assign('linktitle', $result[3]);
                    template::assign('pagetitle', $result[4]);
                    template::assign('content', $result[5]);
                    template::assign('subid', $result[1]);
                    // 7, 8
                    template::assign('pghidden', $result[7]);
                    template::assign('pgprotected', $result[8]);
                }
                
                // Are they trying to update it?
                if(isset($_POST['submit']))
                {
                    // Other stuff
                    template::assign('linktitle', unscape(htmlentities($_POST['stitle'])));
                    template::assign('pagetitle', unscape(htmlentities($_POST['ltitle'])));
                    template::assign('content', unscape($_POST['content']));
                    template::assign('subid', unscape($_POST['subpg']));
                    template::assign('pghidden', unscape($_POST['hidden']));
                    template::assign('pgprotected', unscape($_POST['protected']));
                    
                    
                    
                    $v = new validateFields();
                    $err = array();
            
                    // Check for errors
                    
                    if(!$v->validate($_POST['stitle'], 1, 10))
                       $err[] = 'Link title must be between 1 and 10 characters';
                    
                    if(!$v->validate($_POST['ltitle'], 1))
                        $err[] = 'Page title must be at least 1 character';
                    
                    if(!$v->validate($_POST['content'], 1))
                        $err[] = ('Content must be at least 1 character');
                        
                    
                        
                    if(count($err) == 0)
                    {
                        $hidden = ($_POST['hidden'] == 1) ? 1 : 0;
                        $protected = ($_POST['protected'] == 1) ? 1 : 0;
                        
                        //$db->query('UPDATE pages SET sub_id=?, small_title=? WHERE id=?', array(1, 'aaa', 1), 'isi');
                        
                          $this->db->query('UPDATE pages SET sub_id=?, small_title=?, large_title=?, content=?, time_edited=?, is_hidden=?, is_protected=?
                                   WHERE id=?',
                                   array($_POST['subpg'], $_POST['stitle'], $_POST['ltitle'], $_POST['content'], time(), $hidden, $protected, $name),
                                   'isssiiii');
                          template::assign('message', '<p style="color:#009933;font-weight:bold;">The page has been updated.</p>');
                    } else {
                        template::assign('POSTERR', $err);
                    }
                }
                
                
                $this->template->addTemplate('addpage');
                
            }
        
        // Can't find it!
        } else {
            throw new http_redirect('?page=admin&page1=Edit Pages');
        }
    }

}

?>