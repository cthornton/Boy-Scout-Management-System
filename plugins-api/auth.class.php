<?php
class auth
{
    private $db;
    private $logged;
    
    /**
     * Creates a new "db" object
     */
    public function __construct()
    {
        $this->db = new db();
        $this->logged();
    }
    
    /**
     * Gets the User ID as shown in a cookie.
     * @return int User ID
     */
    final public function getUidCookie()
    {
        if(isset($_SESSION['uid']))
            return $_SESSION['uid'];
        // else  // Was reviewing this code in 2013 for fun - this looks like a security flaw!
        //    return $_COOKIE['uid'];
    }

    /**
     * Set a cookie with a given UID which will be used to log them in
     * @param int $uid User ID
     */
    final public function setCookie($uid)
    {
        // Set an experation date of 30 days.
        $time = time() + 2592000;
        
        setcookie('authkey', $this->generateKey($uid), $time);
        setcookie('uid', $uid, $time);
    }
    
    /**
     * Safely get the user's ID
     */
    final public function safeID()
    {
        if($this->logged())
            return $this->getUidCookie();
    }
    
    
    final public function isLogged()
    {
        return $this->logged();
    }
    
    /**
     * Is the user currently logged on?
     * @return boolean Logged on
     */
    private function logged()
    {
        // Already has a set UID
        if(isset($_SESSION['uid']))
        {
            return true;
        
        // No set UID, but they have cookies!
        } else if(isset($_COOKIE['authkey']) && isset($_COOKIE['uid'])) {
            
            $valid = $this->validateKey($_COOKIE['uid'], $_COOKIE['authkey']);
            
            if($valid)
            {
                $_SESSION['uid'] = $_COOKIE['uid'];
                return true;
            } else {
                return false;
            }
            
        } else {
            return false;
        }
    }
    
    /**
     * Attempt to log in the user. If successful, the SESSION and
     * cookie will then be set.
     * @param string $username Username
     * @param string @password Password
     * @return boolean Logged in
     */
    final public function attemptLogin($username, $password)
    {
        $this->db->query("SELECT id FROM users WHERE user=? AND pass=? LIMIT 1",
                          array($username, hashPassword($username, $password)), 'ss');
        $this->db->result($result1);
        $this->db->fetch();
        
        
        
        // Get the cookie!
        if($result1[0] != 0)
        {
            $this->setCookie($result1[0]);
            $_SESSION['uid'] = $result1[0];
            
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Log a user out
     */
    final public function logout()
    {
        if($this->isLogged())
        {
            session_destroy();
            setcookie('authkey', 'a', time() - 5000);
            setcookie('uid', 'a', time() - 5000);
        }
    }
    
    /**
     * Gets the User's key from their cookies.
     * @return string Key
     */
    private function getKeyCookie()
    {
        return $_COOKIE['authkey'];
    }
    
    /**
     * Encode a key
     * @param string Username
     * @param string Hashed Password
     * @return string Hashed key
     */
    private function encodeKey($username, $pwd)
    {
        return sha1(strtolower($username) . $pwd);
    }
    
    /**
     * Does the key and UID match?
     * @param int $uid User ID
     * @param string $key Key to check
     * @return boolean Valid key
     */
    private function validateKey($uid, $key)
    {
        return ($this->generateKey($uid) == $key);
    }
    
    /**
     * Generate a key based off a user ID
     */
    private function generateKey($uid)
    {
        $this->db->query("SELECT user, pass FROM users WHERE ID=? LIMIT 1", $uid, 'i');
        $this->db->result($result);
        $this->db->fetch();
        $this->db->fetch();
        
        return $this->encodeKey($result[0], $result[1]);
    }
    
}

?>
