<?php
class logs
{
    public static $LOGINERR = 1, $LOGINSUCCESS = 2, $REGERR = 3,
                  $REGSUCCESS = 4, $EDITPAGE = 5, $OTHER = 6,
                  $EXCEPTION = 7;
    
    private $db;
    
    public function __construct()
    {
        $this->db = new db();
    }
    
    public function add($type, $description, $uid = null)
    {
        if(empty($uid))
            if(!empty($_SESSION['uid']))
                $uid = $_SESSION['uid'];
            else
                $uid = 0;
        
        $this->db->query("INSERT INTO logs
                           (id_user, id_type, ip, description, time)
                          VALUES
                            (?, ?, ?, ?, ?)",
                         array($uid, $type, $_SERVER['REMOTE_ADDR'], $description, time()),
                         'iissi');
    }
    
    
    public function getNumLogsByTime($type, $mins = 5)
    {
        $secs = time() - ($mins * 60);
        $this->db->query("SELECT COUNT(*) FROM logs WHERE ip=? AND id_type=? AND time > ? LIMIT 1",
                    array($_SERVER['REMOTE_ADDR'], $type, $secs), 'sii');
        $this->db->result($result);
        
        // For whatever reason, I need two fetches :(
        $this->db->fetch();
        $this->db->fetch();
        return $result[0];
    }
    
    public function getLogsByUID($uid)
    {
        $this->db->query("SELECT * FROM logs WHERE id_user=? ORDER BY time DESC", $uid, 's');
        $this->db->result($result);
        $this->db->fetch();
        return $result;
    }
    
}
?>