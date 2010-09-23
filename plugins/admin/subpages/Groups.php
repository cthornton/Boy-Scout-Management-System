<?php
class subpage extends flowController implements controllable
{
    public function __construct()
    {
        parent::__construct();
        
        template::customCSS('plugins/admin/ui/viewpages.css');
        template::customCSS('plugins/admin/ui/addpage.css');
        template::customCSS('plugins/admin/ui/dropmenu.css');
        template::assign('title', 'Groups');
    }
    
    public function GET()
    {
        $this->template->addTemplate('groupsview');
        template::assign('allgroups', $this->getGroups());
    }
    
    public function forward($name)
    {
        // They want to create a page O.o
        if($name == 'Create')
        {
            if(isset($_POST['submit']))
            {
                template::assign('created', true);
                $this->createGroup();
            }
            
            $this->template->addTemplate('creategroup');
            
        }
        
        // They're modifying a page
        else
        {
            $info = $this->getGroup($name);
            
            
            // Make sure the group exists!    
            if($info[0] == null)
                throw new notfound_exception();
                
            $permissions = $this->getPermissions();
            
            if($_POST['interactive'] == 1)
                template::assign('isInteractive', true);
            else
                template::assign('isInteractive', $info[4]);
            
            
            // Handle POST data
            if(isset($_POST['submit']))
            {
                if($_POST['submit'] == 'Delete' && $info[3] == 0)
                {
                    $this->deleteGroup($name);
                    throw new http_redirect('?page=admin&page1=Groups');
                }
                else
                {
                    template::assign('edited', true);
                    $this->updateGroup($name);
                    $this->handleGroupPost($info[0], $permissions);
                    
                    // Refresh the data
                    $info = $this->getGroup($name);
                }
            }
            
            $this->template->addTemplate('editgroup');
            template::assign('gName', $info[1]);
            template::assign('gid', $info[0]);
            template::assign('canEditGroups', $this->user->hasPremission(4));
            template::assign('permissions', $permissions);
            template::assign('gpermissions', $this->getGroupPermissions($info[0]));
            template::assign('description', $info[2]);
            template::assign('isSpecial', $info[3]);
            
        }
        
    }
    
    
    /**
     * Helper Methods
     */
    
    private function getGroups()
    {
        $this->db->query("SELECT * FROM groups ORDER BY special DESC");
        return $this->db->easyMultiArray();
    }
    
    
    private function getGroup($id)
    {
        $this->db->query("SELECT * FROM groups WHERE id=? LIMIT 1", $id, 'i');
        return $this->db->easyArray();
    }
    
    private function interactive()
    {
        if($_POST['interactive'] == 1)
            return 1;
        else
            return 0;
    }
    
    private function updateGroup($id)
    {
        $this->db->query("UPDATE groups SET name=?, description=?, is_interactive=? WHERE id=?",
                         array(htmlentities($_POST['name']), htmlentities($_POST['descript']), $this->interactive(), $id), 'ssii');
    }
    
    private function deleteGroup($id)
    {
        $this->db->query("DELETE FROM groups WHERE id=? AND special != 1", $id, 'i');
    }
    
    private function createGroup()
    {
        $this->db->query("INSERT INTO groups (name, description, special) VALUES (?, ?, ?)",
                         array(htmlentities($_POST['name']), htmlentities($_POST['descript']), 0), 'ssi');
    }
    
    /**
     * Get group permissions
     */
    private function getPermissions()
    {
        $this->db->query("SELECT * FROM permissions");
        

        return $this->db->easyMultiArray();
    }
    
    private function getGroupPermissions($id)
    {
        $ret = array();
        $this->db->query("SELECT ID_PERMISSION FROM groups_permission WHERE ID_GROUP=?", $id, 'i');
        $this->db->result($result);
        
        while($this->db->fetch())
            $ret[] = 0 + $result[0];
        
        return $ret;
    }
    
    private function handleGroupPost($id, $permissions)
    {
        if(($this->user->hasPremission(4) || $this->user->inGroup(1)) && $id != 1)
        {
            // Delete existing refrences
            $this->db->query("DELETE FROM groups_permission WHERE id_group = ?", $id, 'i');
            
            // Now create new ones!
            foreach($permissions as $arr)
            {
                if($_POST['p'. $arr[0]] == 1)
                {
                    $this->db->query("INSERT INTO groups_permission (id_group, id_permission) VALUES (?, ?)",
                                     array($id, $arr[0]), 'ii');
                }
            }
            
        }
    }
}

?>