<?php
class subpage extends flowController implements controllable
{
    public function GET()
    {
        /**
         * Fetch a list of patrols!
         */
        
        $this->db->query("SELECT id, name, special FROM patrols ORDER BY special ASC");
        
        template::assign('patrols', $this->db->easyMultiArray());
        
        $this->template->addTemplate('patrols');
        template::customCSS('plugins/admin/ui/viewpages.css');
        template::assign('title', 'Patrol Management');
    }
    
    public function forward($name)
    {
        if($name == 'createpatrol')
        {
            template::customCSS('plugins/admin/ui/addpage.css');
            template::assign('title', 'Create a New Patrol');
            
            if(isset($_POST['submit']))
            {
                $err = array();
                if(empty($_POST['name']))
                    $err[] = 'Name was left empty';
                if(empty($_POST['desc']))
                    $err[] = 'Description was left empty';
                
                if(count($err) != 0)
                {
                    template::assign('errors', $err);
                    $this->template->addTemplate('createpatrol');
                } else {
                    plugin_load('patrols');
                    $patr = new patrols();
                    $patr->createPatrol(htmlentities($_POST['name']), htmlentities($_POST['desc']));
                    
                    throw new http_redirect('?page=admin&page1=Patrols');
                }
                
            } else {
                $this->template->addTemplate('createpatrol');
            }
            
        }
        else
            throw new notfound_exception();
    }
    
}