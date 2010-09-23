<?php
class announcements extends apifunctions
{
    /**
     * Create a new announcement
     * @param int $patrol ID of the patrol to use (0 = Global announcement)
     * @param string $title Title of the announcement
     * @param string $content Content of the announcement
     */
    public function create($patrol = 0, $title, $content)
    {
        $this->db->query("INSERT INTO announcements
                            (id_patrol, id_posted, id_edited, title, content, time_posted, time_edited)
                          VALUES
                            (?, ?, ?, ?, ?, ?, ?)",
                            array($patrol, $this->auth->safeID(), 0, htmlentities($title), htmlentities($content), time(), time()   ),
                            'iiissii');
    }
    
    /**
     * Update an announcement
     */
    public function update($id, $title, $content)
    {
        $this->db->query("UPDATE announcements SET
                            id_edited=?, title=?, content=?, time_edited=?
                          WHERE id=?", array($this->auth->safeID(), $title, $content, time(), $id), 'issii');
    }
    
    /**
     * Delete an announcement
     */
    public function delete($id)
    {
        $this->db->query("DELETE FROM announcements WHERE id=?", $id, 'i');
    }
    
    /**
     * Get an announcement by ID
     *
     *  [0] => User ID of  who posted it
     *  [1] => User ID of who last edited
     *  [2] => Title of the announcement
     *  [3] => Content of the announcement
     *  [4] => Timestamp of when posted
     *  [5] => Timestamp of last edited
     */
    public function getById($id)
    {
        $this->db->query("SELECT
                            id_posted, id_edited, title, content, time_posted, time_edited
                          FROM announcements WHERE id=?", $id, 'i');
        $this->db->result($result);
        $this->db->fetch();
        return $result;
    }

    
    /**
     * Gets basic announcements. No parameter gets global announcements
     *
     *  [0] =>
     *      [0] => ID of the announcement
     *      [1] => ID of the user who posted
     *      [2] => Title
     *      [3] => Timestamp posted
     *      [4] => Content
     *  [1] =>
     *      ...
     *
     * @param int $pid Patrol ID
     */
    public function getBasic($pid = 0)
    {
        $ret = array();
        
        $this->db->query("SELECT id, id_posted, title, time_posted, content FROM announcements
                         WHERE id_patrol=? ORDER BY time_posted DESC", $pid, 'i');
        
        return $this->db->easyMultiArray();
    }

}

?>