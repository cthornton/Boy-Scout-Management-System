<?php


/**
 *
 * Right now, we're creating some settings and loading up some important files!
 *
 */
session_start();
error_reporting(E_ALL ^ E_NOTICE);
require_once('config.php');
require_once('sources/functions.php');
loadAPI();


// This *should* be kept outside of the try{} block
$template = new template();


try
{
    
    /**
     *  We're loading some variables that will be used strictly
     *  in the index.php file!
     */
    $template->assign('subpages', array());
    $users = new users();
    $auth = new auth();
    
    
    
    /**
     * Now we're dealing with the template and creating some very
     * useful variables that will be very convienent when
     * using the template system :D
     */
    $template->assign('logged', $auth->isLogged());
    $template->assign('uid', $auth->getUidCookie());
    
    if($auth->isLogged())
    {
        $info = $users->getAllDataByID($auth->getUidCookie());
        $groups = $users->getGroups($auth->getUidCookie());
        
        // Bunches of variables
        $template->assign('fname', $info[4]);
        $template->assign('lname', $info[5]);
        $template->assign('groups', $groups);
        $template->assign('is_admin', (in_array(1, $groups)));
        $template->assign('hasAdmin', (in_array(1, $groups) || in_array(2, $groups) || in_array(3, $groups) || in_array(4, $groups)));
        
        $template->assign('recent_announcements', $users->getLatestAnnouncements($auth->safeID()));
        $template->assign('upcoming_events', $users->getCalEvents());
        $template->assign('interGroups', $users->getInteractiveGroups($auth->safeID()));
        
    } else {
        $template->assign('is_admin', false); 
    }
    
    
    
    /**
     * This creates a variable for the page that the user is trying to view
     */
    if($_GET['page'] == null)
        $page = "Home";
    else
        $page = $_GET['page'];
    
    $pages = new pages($page);
    
    
    // Assing the links for the template
    $template->assign('links', $pages->getNormalPages());
    
    
    
    
    
    
    /**
     *
     * This group right here handles any pages that are in the database.
     * The "page" object checks to see if the page the user is trying to
     * access exists in the database. If it does, then we load it. If not,
     * then we will go on.
     *
     */
    if($pages->exists())
    {
        // Page data
        $data = $pages->getData();
        
        // Does the page required the user to be logged on when viewing it?
        if($data[8] == 1 && !$auth->isLogged())
            throw new unauthorized_exception();
            
        /**
         * Just a bunch of template related stuff
         */
        $template->load('genericpage');
        $template->assign('longtitle', $data[4]);
        $template->assign('content', $data[5]);
        $template->assign('subpages', $pages->getSubPages());
        $template->assign('title', $data[4]);
        
        // Makes the display of subpages work properly
        if($pages->isSub())
            $template->assign('parent', $pages->getParent());
        else
            $template->assign('parent', $data[3]);
    
    
    
    
    
    
    
    
    /**
     *
     * This is the section where we have the "plugins" (oh how fun!). As you can
     * probably see, not a whole lot is done on this page. We first check to see
     * if the file exists, and if not, give them a 404 error.
     *
     */
    } else {
        
        // The configuration file we want to load!
        $file = BASE_DIR . '/plugins/'. $page . '/home.class.php';
        
        /**
         * We found the plugin! It exists!
         */
        if(file_exists($file))
        {
            // Now let's make it a constant
            define('PLUGIN_NAME', $page);
            
            /**
             * Now we're going to make a nice little function that
             * will make creating the plugin SOOO much easier.
             */
            function plugin_load($file)
            {
                global $page;
                $file = BASE_DIR . '/plugins/'. $page . '/'. $file;
                
                /**
                 * Attempt either FILE.class.php or FILE.php
                 */
                if(file_exists($file . '.class.php'))
                    include($file . '.class.php');
                else if(file_exists($file . '.php'))
                    include($file . '.php');
                else
                    throw new Exception("Requested file via \"plugin_load()\" could not be found!");
                
            }
            
            plugin_load('home');
            
            $core = new core(new home());
            $core->execute();
        
        /**
         * We couldn't find the file!
         */
        } else {
            throw new notfound_exception();
        }
    }



    templateWrapper::loadCustomTemplates();


    
} catch (http_redirect $h) {
    $h->head();

/**
 * Unauthorized Exception - The user is trying to view a page that they do not have
 * premission to view!
 */
} catch (unauthorized_exception $u) {
    $u->head();
    $template->load('genericpage');
    $template->assign('title', 'Unauthorized (403)');
    $template->assign('longtitle', 'Unauthorized');
    $template->assign('content', '
                    <p>
                      You do not have premission to view this page. Some possible causes:
                    </p>
                    <ul>
                        <li>You clicked on link that leads to a page that you do not have premission to view</li>
                        <li>You typed something random into the address that exists, but you don\'t have
                            premission to view</li>
                        <li>You tried to access a file that may require you to be logged on</li>
                        <li>If you\'re logged on, you just may not have the privleges required to view this page</li>
                    </ul>
                    <p>
                        If you think you have recieved this page in error, please contact
                        an administrator.
                    </p>');

/**
 * Not Found Exception - The user is trying to view a page that
 * does not exist
 */
} catch (notfound_exception $n) {
    $n->head();
    $template->load('genericpage');
    $template->assign('title', 'Page Not Found (404)');
    $template->assign('longtitle', 'Page Not Found');
    $template->assign('content', '
                    <p>
                      The page you requested could not be found. Some possible causes of this error:
                    </p>
                    <ul>
                        <li>You clicked on link that leads to a page that does not exist</li>
                        <li>You typed something random into the address bar that does not exist</li>
                        <li>You tried to access a file that may require you to be logged on</li>
                    </ul>
                    <p>
                        If you think you have recieved this page in error (haha pun!), please contact
                        an administrator.
                    </p>');
    
} catch (Exception $e) {
    die(require_once('siteError.php'));
}


/**
 *
 * Thought we were through, didn't you? :D
 *
 * Anyways, this actually displays the templates and such. This MUST be last!
 *
 */

try
{
    $template->load('bottom');
    $template->display();
} catch (Exception $e) {
    require_once('siteError.php');
}

?>
