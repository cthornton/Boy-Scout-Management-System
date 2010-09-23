<?php
class templateWrapper
{
    private static $templates = array();
    
    public function __construct()
    {
        template::assign('parent', PLUGIN_NAME);
    }
    
    /**
     * Assign the subpages!
     */
    public function setSubpages($pages, $breaks = null)
    {
        $real = array();
        foreach($pages as $arr)
            $real[] = array(PLUGIN_NAME . '&amp;page1='. $arr, $arr);
        template::assign('subpages', $real);
        
        if(!empty($breaks))
            template::assign('subbreaks', $breaks);
    }
    
    public function setSmallTitle($title)
    {
        template::assign('title', $title);
    }
    
    public function setTitle($title)
    {
        template::assign('longtitle', $title);
    }
    
    public function addTemplate($name)
    {
        self::$templates[] = $name;

    }
    
    public static function loadCustomTemplates()
    {
        foreach(self::$templates as $arr)
        {
            $path = '../plugins/'. PLUGIN_NAME . '/templates/'. $arr;
            template::load($path);
        }
    }

}
?>