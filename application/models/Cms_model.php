<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms_model extends CI_Model {

    protected $table = 'cms';
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
