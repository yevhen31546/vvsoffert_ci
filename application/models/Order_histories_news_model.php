<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order_histories_news_model extends CI_Model {

    protected $table = 'order_histories_news';
    public $id = 'id';
    public function __construct() {
        parent::__construct();
    }

    // public function find($slug = '') {
    //     return $this->db->select('*')
    //                     ->from($this->table)
    //                     ->where("slug = '$slug'")
    //                     ->get()
    //                     ->row();
    // }

    // public function getAll() {
    //     // return $this->db->select('*')
    //     //                 ->from($this->table)
    //     //                 ->order_by('updated_at','desc')
    //     //                 ->get()
    //     //                 ->row();
                        
    //     $this->db->select("*");
    //     $this->db->from($this->table);
    //     // $this->db->where('id', 'your id');
    //     $query = $this->db->get();        
    //     return $query->result();
    //     // OR
    //     // $query = $this->db->query("SELECT * from employees_tasks WHERE your condition");
    //     // return $query->result();                        
    // }
    public function getSub($userid) {
        $this->db->select("*");
        $this->db->from($this->table);
         $this->db->where("user_id = '".$userid."'");
        $query = $this->db->get();
        return $query->result();
    }
    public function get_orderbyid($id) {
        $this->db->select("*");
        $this->db->from($this->table);
         $this->db->where("id = '".$id."'");
        $query = $this->db->get();
        return $query->result();
    }

    function update($data, $id)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    public function insert($insert) {
        $insert['created_at'] = date('Y-m-d H:i:s');
        $insert['updated_at'] = date('Y-m-d H:i:s');
        // var_dump($insert);exit;
        $this->db->insert($this->table, $insert);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
}
