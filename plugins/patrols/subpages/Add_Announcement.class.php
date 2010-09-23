<?php
class subpage extends flowController implements controllable
{
    public function GET()
    {
        $pt = new patrols();
        template::assign('title', 'Create an Announcement');
        template::customCSS('plugins/admin/ui/addpage.css');
        
        if(isset($_POST['submit']))
        {
            $err = array();
            if(empty($_POST['name']))
                $err[] = 'Title was left empty';
            if(empty($_POST['body']))
                $err[] = 'Body was left empty';
            
            
            if(count($err) != 0)
            {
                template::assign('errors', $err);
                template::assign('t', htmlentities($_POST['name']));
                template::assign('body', htmlentities($_POST['body']));
                
                $this->template->addTemplate('addannouncement');  
            } else {
                
                $this->db->query("INSERT INTO announcements (id_patrol, id_posted, id_edited, title, content, time_posted, time_edited)
                                  VALUES (?, ?, ?, ?, ?, ?, ?)",
                                  array($pt->pid(), $this->auth->safeID(), 0, htmlentities($_POST['name']), htmlentities($_POST['body']), time(), 0), 'iiissii');
                
                $this->template->addTemplate('addannouncement');
                template::assign('success', true);
            }
            
        } else {
            $this->template->addTemplate('addannouncement');
        }
    }
    
    public function forward($name)
    {
        $this->GET();
    }
    
}

?>