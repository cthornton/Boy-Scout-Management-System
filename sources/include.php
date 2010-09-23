<?php
/**
 * Include this file for a seperate file that isn't integrated!
 */

require_once(realpath(dirname(__FILE__)) . '/../config.php');
require_once('functions.php');

// Load the API objects!
loadAPI();


$users = new users();
$auth = new auth();

$is_logged = $auth->isLogged();

?>