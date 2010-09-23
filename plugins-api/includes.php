<?php


function plugin_require($file)
{
    require_once(BASE_DIR . '/plugins-api/'. $file . '.class.php');
}

// The one special require
require_once(BASE_DIR . '/plugins-api/controllable.interface.php');

plugin_require('http_redirect');
plugin_require('unauthorized_exception');
plugin_require('notfound_exception');
plugin_require('apifunctions');
plugin_require('Controller');
plugin_require('flowController');
plugin_require('auth');
plugin_require('user');
plugin_require('core');
plugin_require('userInfo');
plugin_require('templateWrapper');

?>