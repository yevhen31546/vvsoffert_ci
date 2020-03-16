<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rsk_model extends CI_Model 
{
	protected $table = 'products';
	
    public function __construct() {
        parent::__construct();
    }

    public function get($id){
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function get_all() {
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