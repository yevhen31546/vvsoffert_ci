<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Groups_model extends CI_Model 
{    
	protected $table = 'groups';
	
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

    public function get_all() {
        $query = $this->db->get($this->table);
        return $query->result();
    }
	
	public function get_all_with_count() {
       $sql = 'SELECT '.$this->table.'.*, count(products.id) as total FROM products LEFT JOIN '.$this->table.' ON '.$this->table.'.id = products.groupName GROUP BY products.groupName ORDER BY '.$this->table.'.name ASC';
	   $query = $this->db->query($sql);
	   return $query->result();
    }
	
	public function get_home_groups() {
		$this->db->limit(4, 0);
		$this->db->order_by('name', 'ASC');
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

    public function delete($id){
        $this->db->delete('posts', array('id' => $id)); 
    }
}