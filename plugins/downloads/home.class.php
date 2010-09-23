<?php
plugin_load('downloads');

class home extends Controller implements controllable
{
    protected $protected = true;
    
    public function __construct()
    {
        parent::__construct();
        
        $p = $this->user->hasPermission(11);
        if($p)
        {
            $this->subpages[] = 'New Download';
            $this->subpages[] = 'Edit Categories';
        }
        
        template::customCSS('plugins/admin/ui/addpage.css');
        template::customCSS('plugins/admin/ui/viewpages.css');
        
        template::assign('canEdit', $p);
    }
    
    public function GET()
    {
        $d = new downloads();
        
        
        /**
         * Download Attempt!
         */
        if(isset($_GET['download']))
        {
            $info = $d->getDownload($_GET['download']);
            
            if($info[0] == null)
                throw new notfound_exception();
            
            $file = BASE_DIR . '/plugins/downloads/files/' . $info[0];
            
            header('Content-Description: File Transfer');
            header('Content-type: ' . $info[3]);
            header('Content-Disposition: attachment; filename="' . htmlentities($info[2]) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            
            readfile($file);
            
            // Make sure we kill the script so we don't download some extra HTML
            die();
        }
        
        /**
         * Regular View
         */
        else
        {
            if(isset($_GET['viewcat']))
            {
                $cat = $_GET['viewcat'];
                
                if($cat == 'NONE')
                {
                    $info = $d->getDownloadsByCat(0);
                    $name[0] = 'Uncategorized';
                }
                else
                {
                    if(!$d->catExists($cat))
                        throw new notfound_exception();
                
                    $info = $d->getDownloadsByCat($cat);
                    $name = $d->getCatName($cat);
                }
                
                $this->template->addTemplate('viewdownloadlist');
                template::assign('downloads', $info);
                template::assign('cName', $name[0]);
                template::assign('title', 'Downloads - ' . $name[0]);
            }
            else
            {
                $a = array();
                $c = $d->getCats();
                foreach($c as $z)
                    $a[] = $d->mostRecent($z[0]);
                
                template::assign('nocat', $d->mostRecent(0));
                template::assign('cinfo', $a);
                // Template Assignments
                template::assign('title', 'Download Categories');
                template::assign('categories', $d->getCats());
                template::assign('downloads', $d->getDownloads());
                
                $this->template->addTemplate('default');
            }
        }
    }
    
    public function forward($name)
    {
        $this->easy_forward($name);
    }
}

?>