<?php
class home extends flowController implements controllable
{
    protected $isLeader;
    public function __construct()
    {
        parent::__construct();
        $this->protected = true;
        template::customCSS('plugins/admin/ui/viewpages.css');
        template::customCSS('plugins/roster/ui/viewuser.css');
        
    }
    
    public function GET()
    {

        
        // Viewing a single patrol!
        if(is_numeric($_GET['pid']) && isset($_GET['pid']))
        {
            $this->db->query("SELECT
                users.id, users.fname, users.lname, users.email, users.phone, users.id_patrol, patrols.name, patrols.id, patrols.id_pl
             FROM
                users
             LEFT JOIN
                patrols
            ON
                users.id_patrol = patrols.id
            WHERE
                users.id_patrol=?
            ORDER BY
                users.lname, users.fname ASC", $_GET['pid'], 'i');
        
            template::assign('viewingpatrol', true);
        }
        else
        {
            $this->db->query("SELECT
                                users.id, users.fname, users.lname, users.email, users.phone, users.id_patrol, patrols.name, patrols.id, patrols.id_pl
                             FROM
                                users
                             LEFT JOIN
                                patrols
                            ON
                                users.id_patrol = patrols.id
                             ORDER BY
                                patrols.special, users.id_patrol, users.lname ASC");
            
            template::assign('viewingpatrol', false);
        }
        $arr = $this->db->easyMultiArray();
        
        $this->template->addTemplate('view');
        template::assign('title', 'Troop Roster');
        template::assign('allUsers', $arr);
    }
    
    public function forward($name)
    {
        /**
         * First, we are going to find the user information!
         */
        $this->db->query("SELECT
                        users.email, users.fname, users.lname, users.phone, users.address1, users.city, users.date_reg, patrols.name, users.user
                    FROM users LEFT JOIN patrols ON users.id_patrol = patrols.id WHERE users.id=?", $name, 'i');
        
        // If we can't find the user, redirect them back!
        if($this->db->numRows() != 1)
            throw new http_redirect('?page=roster');
        
        // If we're here, we found them!
        $this->db->result($result);
        $this->db->fetch();
        
        template::assign('user', $result);
        
        $groups = array();
        
        
        template::assign('id_user', $name);
        template::assign('canEdit', $this->user->hasPermission(1));
        template::assign('title', 'Viewing information for \'' . $result[1] . ' '. $result[2] . '\'');

        // Now to get groups. If we're here, then we know we have a valid ID
        $this->db->query("SELECT groups.name, groups.description FROM groups LEFT JOIN users_groups ON groups.ID = users_groups.ID_GROUP WHERE users_groups.ID_USER=?",
                    $name, 'i');
        
        $this->db->result($result);
        while($this->db->fetch())
            $groups[] = array($result[0], $result[1]);
        
        template::assign('groups', $groups);
        
        $this->template->addTemplate('viewuser');
    }
}

?>