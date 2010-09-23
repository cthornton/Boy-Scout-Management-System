<?php
class subpage extends flowController implements controllable
{
    private $v;
    
    public function __construct()
    {
        parent::__construct();
        $this->v = new validate();
    }
    
    public function GET()
    {
        $d = new downloads();
        
        template::assign('title', 'Edit Categories');
        template::assign('categories', $d->getCats());
        
        $this->template->addTemplate('viewcats');
    }
    
    public function forward($name)
    {
        template::customCSS('plugins/admin/ui/addpage.css');
        $d = new downloads();
        
        $this->template->addTemplate('editcat');
        
        /**
         * Creating a new category!
         */
        if($name == 'new')
        {
            template::assign('title', 'Create new Category');
            
            if(isset($_POST['submit']))
            {
                if($this->validate())
                {
                    template::assign('isError', true);
                    template::assign('errors', $this->v->getErrors());
                    $this->assignPost();
                }
                
                // Success!
                {
                    $d->createCat(htmlentities($_POST['title']), htmlentities($_POST['desc']));
                    template::assign('success', true);
                }
            }
            
        }
        
        /**
         * Editing a category!
         */
        else
        {
            
            $info = $d->getCat($name);
            
            if($info[0] == null)
                throw new notfound_exception;
            
            
            
            if(isset($_POST['submit']))
            {
                
                // Deleting it!
                if($_POST['submit'] == 'Delete')
                {
                    $d->deleteCat($name);
                    throw new http_redirect('?page=downloads&page1=Edit Categories');
                }
                
                // Modifying
                else
                {
                    // Invalid!
                    if($this->validate())
                    {
                        template::assign('isError', true);
                        template::assign('errors', $v->getErrors());
                    }
                    
                    // Valid!
                    else
                    {
                        $d->editCat($name, htmlentities($_POST['title']), htmlentities($_POST['desc']));
                        template::assign('success', true);
                    }
                }
            }
            
            // Default view
            else
            {
                template::assign('eid', $info[0]);
                template::assign('eTitle', $info[2]);
                template::assign('descript', $info[3]);
            }
            
            template::assign('editmode', true);
            template::assign('title', 'Edit Category');
        }
    }
    
    
    private function assignPost()
    {
        template::assign('eTitle', htmlentities($_POST['title']));
        template::assign('descript', htmlentities($_POST['desc']));
    }
    
    private function validate()
    {
        $this->v->check($_POST['title'], 'Title must be between 1 and 30 characters', null, 1, 30);
        $this->v->check($_POST['desc'], 'Please enter something for the description');
        
        return $this->v->isError();
    }
    
}

?> 