<?php

function plugin_include($file)
{
    global $plugin_name;
    include(BASE_DIR . '/plugins/' . $plugin_name . '/'. $file);
}

?>