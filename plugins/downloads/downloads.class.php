<?php
class downloads extends apifunctions
{
    private static $GROUP_ID = 1;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Downloads Section
     */
    
    public function getDownloads()
    {
        $this->db->query("SELECT * FROM downloads ORDER BY id_cat, title ASC");
        return $this->db->easyMultiArray();
    }
    
    
    public function getDownload($id)
    {
                
        $this->db->query("SELECT * FROM downloads WHERE id=?", $id, 'i');
        $a =  $this->db->easyArray();
        $this->db->fetch();
        return $a;
    
    }
    
    public function getDownloadsByCat($cat)
    {
        $this->db->query("SELECT * FROM downloads WHERE id_cat=? ORDER BY id_cat, title ASC", $cat, 'i');
        return $this->db->easyMultiArray();
    }
    
    public function catExists($cat)
    {
        $arr = $this->getCat($cat);
        return ($arr[0] != null);
    }
    
    /**
     * Categories Section
     */
    
    
    public function mostRecent($cid)
    {
        $this->db->query("SELECT id, title, description FROM downloads WHERE id_cat=? ORDER BY id DESC", array($cid), 'i');
        return $this->db->easyMultiArray();
    }

    
    public function getCats()
    {
        $this->db->query("SELECT *  FROM categories WHERE id_type=?", self::$GROUP_ID, 'i');
        return $this->db->easyMultiArray();
    }
    
    public function getCatName($id)
    {
        $this->db->query("SELECT title FROM categories WHERE id_type=? AND id=? LIMIT 1", array(self::$GROUP_ID, $id), 'ii');
        return $this->db->easyArray();
    }
    
    public function getCat($id)
    {
        $this->db->query("SELECT * FROM categories WHERE id_type=? AND id=? LIMIT 1", array(self::$GROUP_ID, $id), 'ii');
        return $this->db->easyArray();
    }
    
    public function createCat($title, $descript)
    {
        $this->db->query("INSERT INTO categories (ID_TYPE, title, description) VALUES (?, ?, ?)",
                          array(self::$GROUP_ID, $title, $descript), 'iss');
    }
    
    public function editCat($id, $title, $descript)
    {
        $this->db->query("UPDATE categories SET title=?, description=? WHERE id=? AND id_type=?",
                         array($title, $descript, $id, self::$GROUP_ID), 'ssii');
    }
    
    public function deleteCat($id)
    {
        $this->db->query("DELETE FROM categories WHERE id=? AND id_type=?",
                         array($id, self::$GROUP_ID), 'ii');
    }
}

?>