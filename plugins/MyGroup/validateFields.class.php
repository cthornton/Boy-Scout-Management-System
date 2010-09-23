<?php
class validateFields
{
    public function validate($content, $minLength, $maxLength = null)
    {
        if(empty($content))
            return false;
        
        if(strlen($content) < $minLength)
            return false;
        
        if(strlen($content) > $maxLength && !empty($maxLength))
            return false;
        
        return true;
    }

}