<?php
/**
 * Handles POST data and checks to see if it's correct
 */
class handle extends apifunctions
{
    private $isError, $errors = array(), $uid;
    
    // Master User ID; Cannot be deleted, have admin status removed or have his
    // password changed by someone else.
    private $MASTER_USER = 3;
    
    public function __construct($uid)
    {
        parent::__construct();
        $this->uid = $uid;
    }
    
    public function updateGroups()
    {   
        // Step 1: Delete any old group refrences. Prevent the admin status
        // from being removed by another administrator :)
        if(!$this->user->hasMinPremission(1))
            $this->db->query("DELETE FROM users_groups WHERE id_user=? AND id_group != 1" , $this->uid, 'i');
        
        // Regular Delete
        else
            $this->db->query("DELETE FROM users_groups WHERE id_user=?", $this->uid, 'i');
        
        
        // Step 2: Create new group refrences
        $uinfo = new getuserinfo();
        $groups = $uinfo->getAllGroups();
        
        if(!$this->user->inGroup(1))
            unset($_POST['g1']);

        if($this->uid == $this->MASTER_USER)
            $_POST['g1'] = 1;
        
        foreach($groups as $arr)
        {
            if($_POST['g' . $arr[0]] == 1)
            {
                $this->db->query("INSERT INTO users_groups (id_group, id_user) VALUES (? , ?)",
                                  array($arr[0], $this->uid), 'ii');
            }
        }
        
        // Step 3: Update the patrol
        $patrols = $uinfo->getAllPatrols();
        
            // Make sure the patrol exists!
        $this->db->query("SELECT NULL FROM patrols WHERE id=?", $_POST['patrol'], 'i');
        if($this->db->numRows() != 0 || $_POST['patrol'] == 0)
        {
            $this->db->query('UPDATE users SET id_patrol=? WHERE id=?',
                             array($_POST['patrol'], $this->uid), 'ii');
        }
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
    
    public function validateAndInsert()
    {
        $validate = new validate();
        
        // They want to delete the user!
        if($_POST['submit'] == 'Delete')
        {
            // They're trying to delete the master user!
            if($this->uid == $this->MASTER_USER)
            {
                $validate->check('a', 'You cannot delete this user', '', 2);
            }
            else
            {
                $this->db->query("DELETE FROM users WHERE id=?", $this->uid, 'i');
                throw new http_redirect('?page=roster');
            }
        }
        
        
        $fname = htmlentities($_POST['fname']);
        $lname = htmlentities($_POST['lname']);
        $phone =  htmlentities($_POST['phone']);
        $city =  htmlentities($_POST['city']);
        $email = htmlentities($_POST['email']);
        $address = htmlentities($_POST['address']);
        
        
        $validate->check($fname, 'First name can only contains letters and spaces', "/^[a-zA-Z0-9\s]*$/i");
        $validate->check($lname, 'Last name can only contain letters and spaces', "/^[a-zA-Z0-9\s]*$/i");
        $validate->check($city,  'Please enter something for a city');
        $validate->check($address,  'Please enter something for a city');
        $validate->check($phone, 'Bad phone number. It must be at least 10 digits long and in the form of \'dddddddddd\'', '/^[0-9]*$/i', 10, 20);
        $validate->check($email, 'Invalid email address', "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i");
        
        if(!empty($_POST['pass1']))
        {
            $validate->check($_POST['pass1'],  'Password must have at least 6 characters', null, 6);
        }
        
        $this->errors = $validate->getErrors();
        
        if(!empty($_POST['pass1']) && $_POST['pass1'] != $_POST['pass2'])
            $this->errors[] = "Passwords do not match";
        
        $this->isError = (count($this->errors) > 0);
        
        // Don't insert it into the db!
        if($this->isError)
        {
            return false;
        }
        else
        {
            $this->db->query("UPDATE users SET
                                email=?, fname=?, lname=?, phone=?, address1=?, city=?
                              WHERE
                               ID=?",
                               array($email, $fname, $lname, $phone, $address, $city, $this->uid),
                               'ssssssi');
            
            // If we're here, we can safely update their password!
            if(!empty($_POST['pass1']))
            {
                $u = $this->auth->safeID();
                
                // Make sure the user's password being edited isn't the one of the master user,
                // unless it is the master user himself
                if($this->uid != $this->MASTER_USER && ($u == $this->MASTER_USER || $this->uid == $this->MASTER_USER))
                {
                	//echo 'Password Updated';
                    $this->db->query("SELECT user FROM users WHERE id=?", $this->uid, 'i');
                    $result = $this->db->easyArray();
                    
                    // var_dump($result);
                    
                    $this->db->query("UPDATE users SET pass=? WHERE id=?",
                                     array(hashPassword($result[0], $_POST['pass1']) , $this->uid), 'si');
                }
            }
            
            return true;
        } 
    }
}

?>