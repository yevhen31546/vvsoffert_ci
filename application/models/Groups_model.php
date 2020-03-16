<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Groups_model extends CI_Model {

    protected $table = 'groups';

    public function __construct() {
        parent::__construct();
    }

    public function nor() {
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function get($id) {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function search($search) {
        return $this->db->get_where($this->table, $search)->row();
    }

    public function get_all() {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function get_all_with_count() {
        $sql = 'SELECT ' . $this->table . '.*, count(products.id) as total FROM products LEFT JOIN ' . $this->table . ' ON ' . $this->table . '.id = products.groupName GROUP BY products.groupName ORDER BY ' . $this->table . '.name ASC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_home_groups() {
//        $this->db->limit(4, 0);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function insert($insert) {
        $insert['created'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $insert);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function update($update, $id) {
        $this->db->update($this->table, $update, array('id' => $id));
    }

    public function delete($id) {
        $this->db->delete('posts', array('id' => $id));
    }

    public function delete_group($id) {
        $this->db->delete($this->table, array('id' => $id));
    }

    public function ajax_search_field_autocomplete($_s_key) {
        $searchKey = "%$_s_key%";
        return $this->db->select('t.id,t.name')
                        ->from($this->table . " as t")
                        ->where("t.name LIKE '$searchKey'")
                        ->get()
                        ->result_array();
    }

    public function total_group_search_res($_s_key) {
        $searchKey = "%$_s_key%";
        return $this->db->select('t.*')
                        ->from($this->table . " as t")
                        ->where("t.name LIKE '$searchKey'")
                        ->count_all_results();
    }

    public function get_search_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $pageNumber) {
        $offset = ($pageNumber - 1) * $limit;
        $searchKey = "%$_s_key%";

        return $this->db->select('t.*, count(pro.id) as total_product')
                        ->from($this->table . " as t")
                        ->join('products as pro', 't.id = pro.groupName', 'left')
                        ->where("t.name LIKE '$searchKey'")
                        ->group_by("t.id")
                        ->order_by("$_s_sort_by", "$_s_order_by")
                        ->limit($limit)
                        ->offset($offset)
                        ->get()
                        ->result_array();
    }

    public function check_group_product($groupId) {
        return $this->db->select('products.id')
                        ->from("products")
                        ->where("products.groupName = $groupId")
                        ->count_all_results();
    }

    public function find_group($_name) {
        return $this->db->select('*')
                        ->from($this->table." as t")
                        ->where("t.name LIKE '$_name'")
                        ->get()
                        ->row();
    }

}
