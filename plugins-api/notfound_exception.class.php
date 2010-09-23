<?php
class notfound_exception extends Exception
{
    public function head()
    {
        header('HTTP/1.x 404 Not Found');
    }
}

?>