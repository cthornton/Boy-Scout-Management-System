<?php
class patrols extends apifunctions
{
    public function createPatrol($name, $desc)
    {
        $this->db->query("INSERT INTO patrols (id_pl, special, name, description)
                          VALUES (?, ?, ?, ?)", array(0, 0, $name, $desc), 'iiss');
    }
}

?>