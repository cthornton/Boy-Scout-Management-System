<?php
plugin_load('getuserinfo');
plugin_load('handle');

class home extends Controller implements controllable
{
    protected $protected = true;
    private $uid;
    
    public function __construct()
    {
        parent::__construct();
        
        if(!empty($_GET['uid']))
            $uid = $_GET['uid'];
        else
            $uid = $this->auth->safeID();
        
        // Prevent hacking attempts!
        if(!$this->user->hasPermission(1) && $uid != $this->auth->safeID())
            throw new unauthorized_exception();
        
        $this->uid = $uid;
    }
    
    public function GET()
    {
        $uinfo = new getuserinfo();
        
        // If they sent us a POST...
        if(isset($_POST['submit']))
        {
            $info[3] = htmlentities($_POST['email']);
            $info[4] = htmlentities($_POST['fname']);
            $info[5] = htmlentities($_POST['lname']);
            $info[6] = htmlentities($_POST['phone']);
            $info[7] = htmlentities($_POST['address']);
            $info[9] = htmlentities($_POST['city']);
            
            $handle = new handle($this->uid);
            
            // Step 1: Groups (if they have premission)
            if($this->user->hasPermission(7))
                $handle->updateGroups();
            
            if($handle->validateAndInsert())
                template::assign('success', true);
            else
                template::assign('errors', $handle->getErrors());
            
        }
        else
        {
            $users = new users();
            $info = $users->getAllDataByID($this->uid);
        }
        

        $this->template->addTemplate('edit');
        
        template::customCSS('plugins/admin/ui/addpage.css');
        template::assign('title', 'User Modification');
        
        template::assign('privledged', $this->user->hasPermission(7));
        template::assign('email', $info[3]);
        template::assign('rfname', $info[4]);
        template::assign('rlname', $info[5]);
        template::assign('phone', $info[6]);
        template::assign('address', $info[7]);
        template::assign('city', $info[9]);
        template::assign('allgroups', $uinfo->getAllGroups());
        template::assign('currgroups', $uinfo->getGroups($this->uid));
        
        // Other important stuff
        template::assign('tUID', $this->uid);
        template::assign('pid', $uinfo->getPatrolId($this->uid));
        template::assign('patrols', $uinfo->getAllPatrols());
        
        template::assign('canDelete', $this->user->hasMinPremission(8));
        
        
    }
    
    public function forward($name){}
    
}