<?php
class template
{
    protected static $dir;
    protected static $html;
    
    protected static $assign = array(), $templates = array('top'), $css = array();
    
    public function __construct()
    {
        self::$dir = BASE_DIR . '/templates';
    }
    
    public static function assign($var, $value)
    {
        self::$assign[$var] = $value;
    }
    
    public static function customCSS($url)
    {
        self::$css[] = $url;
    }
    
    /**
     * Load up a template
     */
    public static function load($name)
    {
        
        $file = self::$dir . '/' . $name . '.tpl.php';
        if(file_exists($file))
            self::$templates[] = $name;
        else
            throw new Exception("Cannot load template \"". $name . "\"");
    }
    
    public function display()
    {
        $this->assign('customStylesheets', self::$css);
        // Include the constants (if any)
        if(file_exists(self::$dir . '/constants.php'))
            require_once(self::$dir . '/constants.php');
        
        $var = self::$assign;
        
        foreach(self::$templates as $arr)
            require_once(self::$dir . '/' . $arr . '.tpl.php');
    }
}


?>