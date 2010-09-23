<?php
class home extends Controller implements controllable
{
    public function __construct()
    {
        parent::__construct();
        if($this->auth->isLogged())
        {
            $this->subpages[] = 'Logout';
        }
        
        template::customCSS('plugins/register/ui/register.css');
        template::assign('title', 'Login');
    }
    
    /**
     * What do do on the default page
     */
    public function GET()
    {
        // Let's make sure they're not logged in to begin with
        if(!$this->auth->isLogged())
        {
            
            $logs = new logs();
            
            if(isset($_POST['submit']))
            {
                $attempts = $logs->getNumLogsByTime(logs::$LOGINERR, 15);
                template::assign('numlogs', $attempts);
                
                // Make sure they don't pass the limit
                if($attempts < 5)
                {
                    // Successful Login!
                    if($this->auth->attemptLogin(htmlentities($_POST['user']), $_POST['pass']))
                    {
                        template::load('genericpage');
                        template::assign('longtitle', 'Login');
                        $logs->add(logs::$LOGINSUCCESS, 'User "'. htmlentities($_POST['user']) . '" has been logged in.');
                        throw new http_redirect();
                        
                    // Bad Login!
                    } else {
                        template::assign('logerr', true);
                        $this->template->addTemplate('login');
                        $logs->add(logs::$LOGINERR, 'Invalid login with username "'. htmlentities($_POST['user']) . '"');
                    }
                
                // Their IP is blocked!
                } else {
                        template::assign('ipblocked', true);
                        $this->template->addTemplate('login');
                }
            
            // They haven't attempted to login yet
            } else {
                $this->template->addTemplate('login');
            }
        } else {
            template::load('genericpage');
            template::assign('longtitle', 'Login');
            template::assign('content', '<p>You are already logged in, so there is no need to login again.</p>');
        }
        
    }
    
    public function forward($name)
    {
        if($this->auth->isLogged())
        {
            $this->auth->logout();
            throw new http_redirect();
        } else {
            $this->GET();
        }
    }
    
    
    
}

?>