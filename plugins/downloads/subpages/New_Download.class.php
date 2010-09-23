<?php
class subpage extends flowController implements controllable
{
    private $v;
    
    private $ext = array('jpg', 'jpeg', 'gif', 'png', 'doc', 'docx', 'xls', 'xlsx', 'pdf', 'ppt', 'pptx', 'zip', 'gz', 'psd');
    
    private $err = array();
    
    public function __construct()
    {
        parent::__construct();
        $this->v = new validate();
        
        $this->template->addTemplate('editdownload');
        template::customCSS('plugins/admin/ui/addpage.css');
    }
    
    public function GET()
    {
        $d = new downloads();
        
        template::assign('cats', $d->getCats());
        
        if(isset($_POST['submit']))
        {
            if(empty($_FILES['file']['name']))
                $this->v->check(null, 'Please select a file to upload');
                
            $this->uploadCheck();
            
            if($this->validate())
            {
                template::assign('isError', true);
                template::assign('errors', $this->v->getErrors());
                $this->assignPost();
            }
            
            // Success!
            {
                $this->upload();
                template::assign('success', true);
            }
        }
        
        template::assign('title', 'New Download');
        template::assign('categories', $d->getCats());
        
        
    }
    
    public function forward($name)
    {
        $d = new downloads();
        
        template::assign('cats', $d->getCats());
        
        
        $info = $d->getDownload($name);
        if($info[0] == null)
            throw new notfound_exception;
        
        
        // Atempting to edit it..
        if(isset($_POST['submit']))
        {
            $this->assignPost();
            
            // Deleting it!
            if($_POST['submit'] == 'Delete')
            {
                $this->db->query("DELETE FROM downloads WHERE id=?", $name, 'i');
                unlink(BASE_DIR . '/plugins/downloads/files/' . $info[0]);
                throw new http_redirect('?page=downloads');
            }
            
            // Modifying
            else
            {
                if(!empty($_FILES['file']['name']))
                    $this->uploadCheck();
                    
                // Invalid!
                if($this->validate())
                {
                    template::assign('isError', true);
                    template::assign('errors', $this->v->getErrors());
                }
                
                // Valid!
                else
                {
                    
                    $this->db->query("UPDATE downloads SET id_cat=?, title=?, description=? WHERE id=?",
                                     array($_POST['cat'], htmlentities($_POST['title']), htmlentities($_POST['desc']), $name), 'issi');
                    
                    //$this->db->fetch();
                    
                    // Modifying the file!
                    if(!empty($_FILES['file']['name']))
                    {
                        unlink(BASE_DIR . '/plugins/downloads/files/' . $info[0]);
                        $this->upload($info[0]);
                        $this->db->query("UPDATE downloads SET filename=?, mime=?, size=? WHERE id=?",
                                         array($_FILES['file']['name'], $_FILES['file']['type'], filesize($_FILES['file']['tmp_name']), $name), 'ssii');
                    }
                    
                    template::assign('success', true);
                }
            }
            
        }
        
        // Default view
        else
        
        {
            template::assign('eTitle', $info[5]);
            template::assign('descript', $info[6]);
        }
        
        template::assign('eid', $info[0]);
        template::assign('editmode', true);
        template::assign('title', 'Edit Download');
    }
    
    
    private function assignPost()
    {
        template::assign('eTitle', htmlentities($_POST['title']));
        template::assign('descript', htmlentities($_POST['desc']));
    }
    
    private function validate()
    {
        $d = new downloads();
        
        $this->v->check($_POST['title'], 'Please enter something for the title');
        $this->v->check($_POST['desc'], 'Please enter something for the description');
        
        $i = $d->getCat($_POST['cat']);
        
        if($i[0] == null && $_POST['cat'] != 0)
             $this->v->check(null, 'The category you selected does not exits');
        
        return $this->v->isError();
    }
    
    public function uploadCheck()
    {
        $ext = array_reverse(explode('.', $_FILES['file']['name']));
        
        if(!in_array($ext[0], $this->ext))
        {
             $this->v->check(null, 'The file you specified has an invalid extension');   
        }
    }
    
    public function upload($id = 0)
    {
        // get latest id...
        $this->db->query("SHOW TABLE STATUS LIKE 'downloads'");
        
        $z = $this->db->easyArray();
        
        if($id == 0)
            $increment = $z[10];
        else
            $increment = $id;
        
        if($id == 0)
        {
            $this->db->query("INSERT INTO downloads (id_cat, filename, mime, size, title, description) VALUES
                              (?, ?, ?, ?, ?, ?)",
                              array($_POST['cat'], $_FILES['file']['name'], $_FILES['file']['type'], filesize($_FILES['file']['tmp_name']), $_POST['title'], $_POST['desc']),
                              'ississ');
        }
        
        // Yes, I know you shouldn't do this.. but oh well!
        move_uploaded_file($_FILES['file']['tmp_name'], BASE_DIR . '/plugins/downloads/files/' . $increment);
        
        //Yay! Done!

    }
    
}

?>