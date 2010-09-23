<?php
function __autoload($className)
{
    $file = BASE_DIR. '/sources/'. $className .'.class.php';
    
    // It's a more useful error if it says that they cound't
    // find the class than if it says a file can't be found.
    if(file_exists($file))
        require_once($file);
}

function hashPassword($user, $pass)
{
    return sha1(strtolower($user) . $pass);
}


function loadAPI()
{
    require_once(BASE_DIR . '/plugins-api/includes.php');
}


/**
 * Parse the body of an announcement!
 * 
 */
function BBC($body)
{
    $img = URL . '/ui/img/smilies';
    
    /**
     * Patterns
     */
    $patterns =  array(
                       // BBC Code & HTML
                       "/\n/",                  // Line Breaks
                       "/\[b\](.*?)\[\/b\]/i",  // [b][/b]
                       "/\[i\](.*?)\[\/i\]/i",  // [i][/i]
                       "/\[u\](.*?)\[\/u\]/i",  // [u][/u]
                       
                       // Smilies
                       "/(:\)|:-\))/",          // :) :-)
                       "/(:D|:-D)/",            // :D :-D
                       "/(8\)|8-\))/",          // 8) 8-) 
                       "/(:\\\|:-\\\|:s)/i",    // :\ :-\ :S
                       "/(:\(|:-\()/",          // :( :-(
                       "/(o\.O)/",              // o.O
                       "/(O\.o)/",              // O.o
                       "/(:\|)/",               // :|
                       "/(:p)/i",               // :p :P
                       "/(:'\()/",              // :'(
                       "/(:o)/i",               // :o :O
                       "/(o\.o|O\.O)/");        // o.o O.O
    
    
    
    /**
     * Replacement
     */
    $replace = array(
                     // BBC Code & HTML
                     "\n<br>",
                     "<strong>$1</strong>",
                     "<em>$1</em>",
                     "<u>$1</u>",
                     
                     // Smilies
                     "<img src=\"$img/smile.png\" alt=\"$1\">",
                     "<img src=\"$img/laugh.png\" alt=\"$1\">",
                     "<img src=\"$img/cool.png\" alt=\"$1\">",
                     "<img src=\"$img/confused.png\" alt=\"$1\">",
                     "<img src=\"$img/sad.png\" alt=\"$1\">",
                     "<img src=\"$img/dizzy1.png\" alt=\"$1\">",
                     "<img src=\"$img/dizzy2.png\" alt=\"$1\">",
                     "<img src=\"$img/normal.png\" alt=\"$1\">",
                     "<img src=\"$img/tongue.png\" alt=\"$1\">",
                     "<img src=\"$img/cry.png\" alt=\"$1\">",
                     "<img src=\"$img/surprised.png\" alt=\"$1\">",
                     "<img src=\"$img/eek.png\" alt=\"$1\">");
    
    return preg_replace($patterns, $replace, $body);
    
}


/**
 * Unescapes data if Magic Quotes is enabled
 */
function unscape($str)
{
    if(get_magic_quotes_gpc())
        $str = stripslashes($str);
    
    return $str;
}

/**
 * Automatically shorten a word, e.g. shorten_word('Hello World!', 2) -> He...
 */
function shorten_word($word, $length)
{
    if(strlen($word) > $length)
       return substr($word, 0, $length - 5) . '...';
    
    return $word;
}


/**
 * Check a URL parameter to see if it's safe
 */
function urlCheck($name)
{
    if(!preg_match('/^[0-9]$/', $_GET[$name]))
        throw new notfound_exception();
}


?>