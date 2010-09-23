<?php
class permissions extends apifunctions
{
    public function getPermissions()
    {
        $this->db->query("SELECT * FROM permissions");
        return $this->db->easyMultiArray();
    }
    
    public function getGroupPermissions($gid)
    {
        $this->db->query("SELECT id_permission FROM groups_permissions WHERE id_group=?", $gid, 'i');
        return $this->db->easyArray();
    }
    
    /**
     * [0] => Title
     * [1] => Description
     * [2] => Does the group have this permission?
     */
    public function getPermissionsWithGroup($gid)
    {
        $ret = array();
        $this->db->query("SELECT permissions.title, permissions.description, groups_permission.ID_GROUP
                          FROM permissions, groups_permission LEFT JOIN
                          groups_permission.ID_PERMISSION = permissions.ID
                          WHERE groups_permission.ID_GROUP = ?", $gid, 'i');
        
        $this->db->result($result);
        
        while($this->db->fetch())
        {
            $ret[] = array($result[0], $result[1], ($result[2] != 0));
        }
        
        return $ret;
    }
    
}
?>