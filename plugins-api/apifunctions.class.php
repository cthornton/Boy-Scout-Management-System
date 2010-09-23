<?php
/**
 * apifunctions.class.php   *   Christopher Thornton
 *
 *  As you can see, this does not have very much code involved. However, this is extended by
 *  the Controller.class.php. This file creates a "link" between the "BASE_DIR/sources" and
 *  many of the API features. In addition, this can be extended by an ordinary class to access
 *  several of the API featues without actually controlling the plugin itself.
 */

class apifunctions
{
    /**
     * Objects that will be used A LOT
     */
    protected $auth;
    protected $user;
    protected $db;
    protected $template;
    
    public function __construct()
    {
        $this->auth = new auth();
        $this->user = new user();
        $this->db   = new db();
        $this->template = new templateWrapper();
    }
}


?>