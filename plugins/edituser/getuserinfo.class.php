<?php
class getuserinfo extends apifunctions
{
    public function getGroups($id)
    {
        $res = array();
        $this->db->query("SELECT id_group FROM users_groups WHERE id_user=?", $id, 'i');
        $this->db->result($result);
        while($this->db->fetch())
            $res[] = 0 + $result[0];
        
        return $res;
    }
    
    public function getAllGroups()
    {
        $this->db->query("SELECT id, name FROM `groups`");
        $res =  $this->db->easyMultiArray();
        return $res;
    }
    
    public function getAllPatrols()
    {
        $this->db->query("SELECT id, name, special FROM `patrols` ORDER BY special ASC");
        $res =  $this->db->easyMultiArray();
        return $res;
    }
    
    public function getPatrolId($id)
    {
        $this->db->query("SELECT ID_PATROL FROM users WHERE ID=?", $id, 'i');
        $res = $this->db->easyArray();
        
        return $res[0];
    }
}


?>