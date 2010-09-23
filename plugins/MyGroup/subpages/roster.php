<?php
class subpage extends flowController implements controllable
{
    private $isLeader;
    
    public function GET()
    {
        template::customCSS('plugins/admin/ui/viewpages.css');
        template::customCSS('plugins/roster/ui/viewuser.css');
        $this->template->addTemplate('roster');
        template::assign('title', 'Group Roster');
        $users = $this->getUsers();
        template::assign('allUsers', $users);

        $this->db->query("SELECT is_leader FROM users_groups WHERE id_user = ? AND id_group=? LIMIT 1", array($this->auth->safeID(), $_SESSION['curr_group']), 'ii');
        $res = $this->db->easyArray();
        
        $this->isLeader = ($this->isLeader || $this->user->hasMinPremission(4));
        template::assign('isLeader', $this->isLeader);
        
        if(isset($_POST['submit']) && $this->isLeader)
        {
            $this->db->query("UPDATE users_groups SET is_leader = 0 WHERE id_group=?", $_SESSION['curr_group'], 'i');
            foreach($users as $arr)
            {
                if($_POST['l' . $arr[0]] == 1)
                {
                    $this->db->query("UPDATE users_groups SET is_leader = 1 WHERE id_user=? AND id_group=?",
                                       array($arr[0], $_SESSION['curr_group']), 'ii');
                }
            }
            
            template::assign('updated', true);
        }
    }
    
    public function forward($name)
    {
        $this->GET();
    }
    
    protected function getUsers()
    {
       $this->db->query("SELECT
                            users.id, users.fname, users.lname, users.email, users.phone, users_groups.is_leader
                        FROM
                            users_groups, users
                       WHERE
                            users_groups.id_user = users.id
                        AND
                            users_groups.id_group = ?", $_SESSION['curr_group'], 'i');
       
       return $this->db->easyMultiArray();
    }
}

?>