<?php
class http_redirect extends Exception
{
    private $url;
    
    public function __construct($url = "")
    {
        $this->url = URL . '/' . $url;
    }
    
    public function head()
    {
        header('location: ' . $this->url);
    }
}

?>