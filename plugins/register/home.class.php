<?php

class home extends Controller implements controllable
{
    private $registration_password;
    
    public function __construct()
    {
        global $reg_pass;
        parent::__construct();
        
        $this->registration_password = $reg_pass;
        
        template::assign('title', 'Registration');
        template::customCSS('plugins/register/ui/register.css');
    }
    
    public function GET()
    {
        // Make sure they're not logged in first :D
        if(!$this->auth->isLogged())
        {
            
            // If they submitted a form :D
            if(isset($_POST['submit']))
            {
                $err = array();
                
                // Fix stuff
                $user = htmlentities($_POST['login']);
                $fname = htmlentities($_POST['fname']);
                $lname = htmlentities($_POST['lname']);
                $phone =  htmlentities($_POST['phone']);
                $city =  htmlentities($_POST['city']);
                $email = htmlentities($_POST['email']);
                $address = htmlentities($_POST['address']);
                
                $validate = new validate();
                $validate->check($user,  'Username must be at least 1 character long');
                $validate->check($_POST['pass1'],  'Password must have at least 6 characters', null, 6);
                $validate->check($fname, 'First name can only contains letters and spaces', "/^[a-zA-Z0-9\s]*$/i");
                $validate->check($lname, 'Last name can only contain letters and spaces', "/^[a-zA-Z0-9\s]*$/i");
                $validate->check($city,  'Please enter something for a city');
                $validate->check($address,  'Please enter something for your address');
                $validate->check($phone, 'Your phone number must be at least 10 digits and in the form of \'dddddddddd\'', '/^[0-9]*$/i', 10, 10);
                $validate->check($email, 'Invalid email address', "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i");
                

                // We need to check to see if the user exists :D   
                $this->db->query("SELECT COUNT(*) FROM users WHERE user=?", $user, 's');
                $this->db->result($result);
                $this->db->fetch();
                
                if($validate->isError())
                    $err = $validate->getErrors();
                    
                if($result[0] != 0)
                    $err[] = 'The username you selected is already in use';
                
                if($_POST['pass1'] != $_POST['pass2'])
                    $err[] = 'The passwords do not match';
                
                if($_POST['regpass'] != $this->registration_password)
                    $err[] = 'You entered an invalid registration password';
                
                
                // Everything checks out!
                if(count($err) == 0)
                {
                    $this->db->query("INSERT INTO users
                                 (ID_PATROL, user, pass, email, fname, lname, phone, address1, address2, city, date_reg)
                                VALUES
                                  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                                array(0, $user, hashPassword($user, $_POST['pass1']), $email, $fname, $lname, $phone, $address, ' ', $city, time()),
                                'isssssssssi');
                    template::load('genericpage');
                    template::assign('longtitle', 'Create an Accout');
                    template::assign('content', '<p>You have now created your account. You may now login and join a patrol.</p><p><a href="?page=login">Continue</a></p>');
                // It doesn't check out :(
                } else {
                    // Alright... we get to assign stuff! YAY!
                    template::assign('login', $user);
                    template::assign('fname', $fname);
                    template::assign('lname', $lname);
                    template::assign('phone', $phone);
                    template::assign('address', $address);
                    template::assign('city', $city);
                    template::assign('email', $email);
                    
                    template::assign('errors', $err);
                    $this->template->addTemplate('register');
                }
                
            } else {
            
                // No POST data, just show the normal template
                $this->template->addTemplate('register');
            }
        
        } else {
            template::load('genericpage');
            template::assign('longtitle', 'Registration');
            template::assign('content', '<p>Sorry, you cannot create a new account when you are already logged in.</p>');
        }
    }
    
    public function forward($name){}
}

?>