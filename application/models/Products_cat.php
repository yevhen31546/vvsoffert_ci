<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products_cat extends CI_Model {
    
    public function get_main_category() {
        $sql = 'SELECT * FROM `categories` WHERE pid IS NULL and pid2 IS NULL ORDER BY name ASC';
        $query = $this->db->query($sql);
        return $query->result();
    }

}	

?>