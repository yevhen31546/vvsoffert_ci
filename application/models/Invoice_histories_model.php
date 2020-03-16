<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoice_histories_model extends CI_Model {

    protected $table = 'invoice_histories';
    public $id = 'id';
    public function __construct() {
        parent::__construct();
    }

    public function find($slug = '') {
        return $this->db->select('*')
                        ->from($this->table)
                        ->where("slug = '$slug'")
                        ->get()
                        ->row();
    }

    public function getAll() {
        // return $this->db->select('*')
        //                 ->from($this->table)
        //                 ->order_by('updated_at','desc')
        //                 ->get()
        //                 ->row();
                        
        $this->db->select("*");
        $this->db->from($this->table);
        // $this->db->where('id', 'your id');
        $query = $this->db->get();        
        return $query->result();
        // OR
        // $query = $this->db->query("SELECT * from employees_tasks WHERE your condition");
        // return $query->result();                        
    }
    public function getSub($userid, $invoice_type) {
        $this->db->select("*");
        $this->db->from($this->table);
         $this->db->where("user_id = '$userid' and invoice_type = '$invoice_type'");
        $query = $this->db->get();        
        return $query->result();
    }

    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    public function insert($insert) {
        $insert['created_at'] = date('Y-m-d H:i:s');
        $insert['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $insert);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
}
