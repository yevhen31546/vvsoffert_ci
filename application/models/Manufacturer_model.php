<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manufacturer_model extends CI_Model 
{
	protected $table = 'manufacturer';
	
    public function __construct() {
        parent::__construct();
    }
	
	public function nor()
	{
		$query = $this->db->get($this->table);
        return $query->num_rows();
	}

    public function get($id){
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }
	
	public function search($search){
        return $this->db->get_where($this->table, $search)->row();
    }
	
	public function get_all_with_count($start=0) {
       $sql = 'SELECT '.$this->table.'.*, count(products.id) as total FROM products LEFT JOIN '.$this->table.' ON '.$this->table.'.id = products.Manufacturer GROUP BY products.Manufacturer ORDER BY '.$this->table.'.name ASC LIMIT ?, 50';
	   $query = $this->db->query($sql,$start);
	   return $query->result();
    }
	
    public function get_all() {
		$this->db->select('id,name');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function insert($insert) {       
        $insert['created'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $insert);
		$insert_id = $this->db->insert_id();
	    return  $insert_id;
    }

    public function update($update, $id) {       
        $this->db->update($this->table, $update, array('id' => $id));
    }
	
	public function update_where($update, $where) {       
        $this->db->update($this->table, $update, $where);
    }

    public function delete($id){
        $this->db->delete('posts', array('id' => $id)); 
    }
}