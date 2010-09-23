<?php
class validate
{
    private $numErrors;
    private $messages = array();
    
    /**
     * Check to validate a field
     * @param string $field Field to check
     * @param string $errmsg The error to give if it fails validation
     * @param string $regex Pattern to check
     * @param int $min Minimum amount of characters
     * @param int $max Maximum amount of characters
     */
    public function check($field, $errmsg, $regex = null, $min = 1, $max = null)
    {
        if(!empty($regex) && !preg_match($regex, $field))
        {
            $this->numErrors++;
            $this->messages[] = $errmsg;
        } else if(strlen($field) < $min) {
            $this->numErrors++;
            $this->messages[] = $errmsg;
        } else if(!empty($max) && strlen($field) > $max) {
            $this->numErrors++;
            $this->messages[] = $errmsg;
        }
    }
    
    /**
     * Check to see if there were any errors
     * @return boolean Errors
     */
    public function isError()
    {
        return (count($this->messages) > 0);
    }
    
    public function getErrors()
    {
        return $this->messages;
    }
}


?>