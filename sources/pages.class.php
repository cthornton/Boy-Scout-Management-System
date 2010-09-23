<?php
class pages
{
    private $db, $title, $data;
    private $exists = true;
    
    /**
     * Load up a database object. Get the title of the page.
     * @param string $title Title of the page
     */
    public function __construct($title)
    {
        $this->db = new db();
        $this->title = $title;
        $this->loadData();
    }
    
    /**
     * Helper method to get information from the database. Used
     * by the constructor and is imparitive for the rest 
     */
    private function loadData()
    {
        $this->db->query("SELECT * FROM pages WHERE small_title=? LIMIT 1",
                            $this->title, 's');
        
        
        if($this->db->numRows() == 0)
            $this->exists = false;
        
        $this->db->result($result);
        $this->db->fetch();
        $this->data = $result;
    }
    
    /**
     * Does the page exist?
     * @return boolean Page exists
     */
    public function exists()
    {
        return $this->exists;
    }
    
    /**
     * Return an array of data about the page
     * @return array Data:
     *  [0] => ID
     *  [1] => Subpage ID (Zero if it isn't a subpage)
     *  [2] => Position
     *  [3] => Small Title (Used for links)
     *  [4] => Large Title (Used for the title on a page)
     *  [5] => Content of the page
     *  [6] => Date last edited (timestamp)
     *  [7] => Is Hidden (0 = not hidden, 1 = hidden)
     *  [8] => Is Protected (0 = not proctected, 1 = protected). Used to
     *         require a login to see the page.
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * Get an array of all visible pages, protected or not.
     * @return array Pages:
     *  [0] =>
     *      [0] => Small Title (Used for links)
     *      [1] => Large Title (Used for the title on a page)
     *  [1] =>
     *      ...
     */
    public function getNormalPages()
    {
        $return = array();
        
        $this->db->query("SELECT
                            small_title, large_title, ID
                         FROM pages WHERE
                            sub_id = 0 AND is_hidden = 0
                         ORDER BY id ASC");
        
        $this->db->result($result);
        while($this->db->fetch())
            $return[] = array($result[0], $result[1], $result[2]);
        
        return $return;
    }
    
    /**
     * Get an array of subpages for the current page
     * @return array Pages:
     *  [0] =>
     *      [0] => Small Title (Used for links)
     *      [1] => Large Title (Used for the title on a page)
     *  [1] =>
     *      ...
     */
    public function getSubPages()
    {
        $return = array();
        
        //  Fix to make sure we show all of the subpages WHILE we
        // are currently viewing a subpage.
        if($this->data[1] != 0)
            $val = $this->data[1];
        else
            $val = $this->data[0];
        
        $this->db->query("SELECT
                            small_title, ID
                         FROM pages WHERE
                            sub_id = ?
                         ORDER BY position ASC", $val, 'i');
        
        $this->db->result($result);
        while($this->db->fetch())
            $return[] = array($result[0], $result[0], $result[1]);
        
        return $return;
    }
    
    /**
     * Get the information of the parent page. Nothing is returned
     * if the page doesn't have a parent.
     * @return string Title
     */
    public function getParent()
    {
        $this->db->query("SELECT
                            small_title, ID
                          FROM pages WHERE
                            id=?", $this->data[1], 'i');
        
        $this->db->result($result);
        $this->db->fetch();
        return $result[0];
        
    }
    
    /**
     * Check to see if the current page is a subpage
     * @return boolean Is a sub page
     */
    public function isSub()
    {
        return ($this->data[1] != 0);
    }
}


?>