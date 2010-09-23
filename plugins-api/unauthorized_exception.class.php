<?php
class unauthorized_exception extends Exception
{   
    public function head()
    {
        header('HTTP/1.x 403 Unauthorized');
    }
}
?>