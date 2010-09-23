<?php
class subpage extends flowController implements controllable
{
    public function GET()
    {
        $ptrl = new patrols();
        
        // Basic Information
        $this->db->query("SELECT id_pl, name, description FROM patrols WHERE id=? LIMIT 1", $ptrl->pid(), 'i');
        template::assign('pInfo', $this->db->easyArray());
        
        // List of users
        $this->db->query("SELECT id, fname, lname FROM users WHERE id_patrol=?", $ptrl->pid(), 'i');
        template::assign('pUsers', $this->db->easyMultiArray());
        
        template::assign('canDelete', $this->user->hasMinPremission(3));
        template::customCSS('plugins/admin/ui/addpage.css');
        template::assign('title', 'Edit Patrol');
        
        
        
        if(isset($_POST['submit']))
        {
            // They want to delete the patrol :<
            if($_POST['submit'] == "Delete" && $this->user->hasMinPremission(3))
            {
                // Now remove everybody from that patrol and then delete the patrol
                $this->db->query("UPDATE users SET ID_PATROL = 0 WHERE ID_PATROL = ?", $ptrl->pid(), 'i');
                $this->db->query("DELETE FROM patrols WHERE ID=?", $ptrl->pid(), 'i');
                throw new http_redirect('?page=admin&page1=Patrols');
            }
            
            $error = array();
            
            if(empty($_POST['pname']))
                $error[] = 'You might consider entering something for the patrol name';
            
            if(empty($_POST['desc']))
                $error[] = 'Enter something for the description';
            
            // They want to change the PL
            if($_POST['pl'] != 0)
            {
                // Make sure they're not attempting to put someone as PL
                // when they aren't even in the patrol!
                $this->db->query("SELECT NULL FROM users WHERE id=? AND id_patrol=?", array($_POST['pl'], $ptrl->pid()), 'ii');
                if($this->db->numRows() != 1)
                    $error[] = 'Stop manually changing the value for the "Patrol Leader"! Either the ID you, the poor excuse for a hacker,'
                             . ' gave doesn\'t exist OR the ID of the person isn\'t in this patrol! Just stop your lame hack attempts; it\'s not going to work anyway'
                         . ' (You = <strong>FAIL</strong>)';
            }
            
            // Uh-oh! Errors!
            if(count($error) > 0)
            {
                template::assign('errors', $error);
            
            // They're good to go!
            } else {
                template::assign('success', true);
                $this->db->query("UPDATE patrols SET id_pl=?, name=?, description=? WHERE id=?",
                                 array($_POST['pl'], htmlentities($_POST['pname']), htmlentities($_POST['desc']), $ptrl->pid()), 'issi');
            }
            
        }
        
        $this->template->addTemplate('editpatrol');
        
    }
    
    public function forward($name)
    {
        $this->GET();
    }

}
?>