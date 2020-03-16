<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_model extends CI_Model {

    protected $table = 'customers';
    
    public function __construct() {

        parent::__construct();
    }

    
    public function get_customers($id) {
        
        $this->db->order_by("created_at", "desc");
        return $this->db->get_where($this->table, array('user_id' => $id))->result();
    }

    public function get_customersbyid($id) {
        
        $this->db->order_by("created_at", "desc");
        return $this->db->get_where($this->table, array('id' => $id))->result();
    }

    public function get_customersbyuserid($id) {
        
        $this->db->order_by("created_at", "desc");
        return $this->db->get_where($this->table, array('user_id' => $id))->result();
        
        return $query->result();      
    }

    public function get_customersbycustomid($id) {
        
        $this->db->order_by("created_at", "desc");
        return $this->db->get_where($this->table, array('id' => $id))->result();
        
        return $query->result();      
    }


    public function insert($insert) {
        //var_dump($insert);exit;

        $this->db->insert($this->table, $insert);
        
        $insert_id = $this->db->insert_id();

        return true;;
    }


    public function update($update, $id) {
        
        $this->db->update($this->table, $update, array('id' => $id));
    }

    public function delete($id) {

        $this->db->delete($this->table, array('id' => $id));
    }

 

   

}
