<?php
plugin_load('validateFields');

class subpage extends flowController implements controllable
{
    private $id;
    
    public function __construct()
    {
        parent::__construct();
        $this->id = $_SESSION['curr_group'];
        template::customCSS('plugins/admin/ui/viewpages.css');
        template::customCSS('plugins/admin/ui/addpage.css');
        template::assign('title', 'Modify Pages');
        
        // Allow file uploads
        if($this->user->hasMinPremission(4))
            $_SESSION['uploadmode'] = true;
    }
    
    public function GET()
    {
       throw new notfound_exception();
    }
    
    public function forward($name)
    {
        
        template::assign('allLinks', $return);
        
        
        if($_GET['pid'] != 'HOME')
        {
            urlCheck('pid');
            $this->db->query("SELECT small_title, long_title, body FROM groups_pages WHERE id=? AND id_group=?",
                             array($_GET['pid'], $this->id), 'ii');
            
            $home = false;
        }
        else
        {
            $this->db->query("SELECT small_title, long_title, body FROM groups_pages WHERE small_title=? AND id_group=?",
                              array('home',$this->id), 'si');
            
            $newhome = $this->db->numRows() == 1 ? false : true;
            
            $home = true;
        }
        //echo $this->id;
        if($this->db->numRows() > 0 || $home)
        {
            template::assign('action', 'edit&amp;pid='. $_GET['pid']);
            // They want to delete a page!
            if($_GET['action'] == 'delete')
            {
                $this->db->query("DELETE FROM groups_pages WHERE id=? and id_group=?", array($name, $name), 'ii');
                throw new http_redirect('?page=admin&page1=Edit Pages');
            } else {
                $result = $this->db->easyArray();
                
                template::assign('button', 'Edit Page');
                
                if(!isset($_POST['submit']))
                {
                    
                    template::assign('linktitle', $result[0]);
                    template::assign('pagetitle', $result[1]);
                    template::assign('content', $result[2]);
                }
                
                // Are they trying to update it?
                if(isset($_POST['submit']))
                {
                    // Other stuff
                    template::assign('linktitle', unscape(htmlentities($_POST['stitle'])));
                    template::assign('pagetitle', unscape(htmlentities($_POST['ltitle'])));
                    template::assign('content', unscape($_POST['content']));
                    
                    
                    
                    $v = new validateFields();
                    $err = array();
            
                    // Check for errors
                        
                    if(!$v->validate($_POST['stitle'], 1, 10) && !$home)
                       $err[] = 'Link title must be between 1 and 10 characters';
                    
                    if(!$v->validate($_POST['ltitle'], 1))
                        $err[] = 'Page title must be at least 1 character';
                    
                    if(!$v->validate($_POST['content'], 1))
                        $err[] = ('Content must be at least 1 character');
                        
                    
                        
                    if(count($err) == 0)
                    {
                        if($home)
                        {
                            if($newhome)
                            {
                                $this->db->query("INSERT INTO groups_pages (id_group, small_title, long_title, body, time_edited, is_home) VALUES (?, ?, ?, ?, ?, ?)",
                                                 array($this->id, 'Home', htmlentities($_POST['ltitle']), $_POST['content'], time(), 1), 'isssii');
                            }
                            else
                            {
                                $this->db->query('UPDATE groups_pages SET small_title=?, long_title=?, body=? WHERE is_home=1 AND id_group=?',
                                           array('Home', htmlentities($_POST['ltitle']), $_POST['content'], $this->id),
                                           'sssi');
                            }
                        }
                        else
                        {
                            
                            if($_POST['submit'] == 'Delete')
                            {
                                $this->db->query("DELETE FROM groups_pages WHERE id=? AND id_group=? AND is_home=0", array($_GET['pid'], $this->id), 'ii');
                                throw new http_redirect('?page=MyGroup&page1=Add / Edit Pages');
                            }
                            else
                            {
                                $this->db->query('UPDATE groups_pages SET small_title=?, long_title=?, body=? WHERE id=? AND id_group=? AND is_home != 1',
                                                 array(htmlentities($_POST['stitle']), htmlentities($_POST['ltitle']), $_POST['content'], $_GET['pid'], $this->id),
                                                 'sssii');
                            }
                        }
                          template::assign('message', '<p style="color:#009933;font-weight:bold;">The page has been updated.</p>');
                    } else {
                        template::assign('POSTERR', $err);
                    }
                }
                
                
                $this->template->addTemplate('addpage');
                
            }
        
        // Can't find it!
        } else {
            throw new notfound_exception();
        }
    }

}

?>