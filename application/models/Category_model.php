<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model 
{
	protected $table = 'categories';
	
    public function __construct() {
        parent::__construct();
    }
	
	public function nor()
	{
		$query = $this->db->get($this->table);
        return $query->num_rows();
	}
	
	public function search($search){
        return $this->db->get_where($this->table, $search)->row();
    }
	
    public function get($id){
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function get_all() {
        $query = $this->db->get($this->table);
        return $query->result();
    }

	public function get_main_category()
	{
		$sql = 'SELECT * FROM `categories` WHERE pid IS NULL and pid2 IS NULL ORDER BY name ASC';
		$query = $this->db->query($sql);
        return $query->result();
	}
	
	public function get_main_category_nor()
	{
		$sql = 'SELECT count(id) as totalRows FROM `categories` WHERE pid IS NULL and pid2 IS NULL ORDER BY ID ASC';
		$query = $this->db->query($sql);
        return $query->row();
	}
	
	public function get_sub_category1($id)
	{
		$sql = 'SELECT * FROM `categories` WHERE pid = ? AND `pid2` IS NULL ORDER BY name ASC';
		$query = $this->db->query($sql,array($id));
        return $query->result();
	}
	
	public function get_sub_category1_nor()
	{
		$sql = 'SELECT pid, count(id) as subcategory FROM `categories` WHERE `pid` IS NOT NULL AND `pid2` IS NULL GROUP BY pid';
		$query = $this->db->query($sql);
        return $query->result();
	}
	
	public function get_sub_category2($id)
	{
		$sql = 'SELECT * FROM `categories` WHERE pid2 = ? ORDER BY name ASC';
		$query = $this->db->query($sql,array($id));
        return $query->result();
	}
	
	public function get_sub_category2_nor($pid)
	{
		$sql = 'SELECT pid2, count(id) as subcategory FROM `categories` WHERE pid = ? AND `pid2` IS NOT NULL GROUP BY pid2';
		$query = $this->db->query($sql,$pid);
        return $query->result();
	}
	
	public function get_by_group($id)
	{
		$sql = 'SELECT categories.id, categories.name, products.category1 FROM products INNER JOIN categories ON categories.id=products.category1 WHERE products.groupName=? GROUP BY products.category1 LIMIT 0,10';
		$query = $this->db->query($sql, array($id));
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