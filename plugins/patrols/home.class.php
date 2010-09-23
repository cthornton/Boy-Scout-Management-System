<?php
plugin_load('patrols');

class home extends Controller implements controllable
{
    
    private $patrols;
    
    public function __construct()
    {
        parent::__construct();
        $this->protected = true;
        $this->patrols = new patrols();
        
        
        if($this->patrols->inPatrol())
        {
            $this->subpages[] = 'Roster';
        }
        
        
        // Admin features
        if(($this->user->hasPermission(6) || $this->user->isPL()) && $this->patrols->exists)
        {
            $this->subpages[] = 'Add Announcement';
            $this->subpages[] = 'Edit Patrol';
        }
    
    }
    
    public function GET()
    {   
        
        /**
         * Do they have premissions to view this patrol / Are they in a patrol?
         */
        if($this->patrols->inPatrol())
        {
            $info = $this->patrols->getInfo();
            // Template stuff
            //template::assign('title', $this->patrols->name());
            template::assign('pInfo', $info);
            template::assign('notOwnPatrol', ($_SESSION['pid'] != 0));
            template::assign('title', 'My Patrol');
        
            $this->template->addTemplate('home');    
    
        /**
         * They aren't in a patrol, so prompt them to join one!
         */
        } else  {
            
            if(isset($_POST['submit']))
            {
                // Let's check to see if it exists!
                $this->db->query("SELECT NULL FROM patrols WHERE id=?", $_POST['ptrl'], 'i');
                
                if($this->db->numRows() == 1)
                {
                    $this->db->query("UPDATE users SET id_patrol=? WHERE id=?", array($_POST['ptrl'], $this->auth->safeID()), 'ii');
                    throw new http_redirect('?page=patrols');
                }   
                
            }
            
            // CSS
            template::customCSS('plugins/register/ui/register.css');
            template::assign('title', 'Join a Patrol');
            $this->template->addTemplate('selectPatrol');
            
            
            /**
             * Now let's get a list of patrols from the Database!
             */
            $val = array();
            $this->db->query("SELECT id, name, special FROM patrols ORDER BY special, ID ASC");
            $this->db->result($result);
            while($this->db->fetch())
                $val[] = array($result[0], $result[1], $result[2]);
            
            template::assign('ptrls', $val);
            
        }
    }
    
    public function forward($name)
    {
        $this->easy_forward($name);
    }
    
}

?>