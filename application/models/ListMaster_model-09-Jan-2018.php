<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ListMaster_model extends CI_Model {

    protected $table = 'list_master';
    protected $list_pro_tbl = 'list_master_product';

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
        $this->db->limit(4, 0);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function insert($insert) {
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

    public function get_by_user_id($id) {
        return $this->db->get_where($this->table, array('user_id' => $id))->result();
    }

    public function delete_list($id) {
        $this->db->delete($this->table, array('id' => $id));
    }

    public function insert_into_product_list($record = array()) {
        $recordObj = (object) $record;
        $proSql = "SELECT id FROM $this->list_pro_tbl WHERE rsk_no LIKE '$recordObj->pro_rsk' AND list_id = $recordObj->list_id";
        $pro = $this->db->query($proSql)->row();

        if (count($pro) > 0) {
//            $proListId = $pro["id"];
            $findPro = "UPDATE $this->list_pro_tbl SET quantity = $recordObj->quantity WHERE id = $pro->id";
            $this->db->query($findPro);
        } else {
            $updateSql = "SELECT id FROM products WHERE RSKnummer LIKE '$recordObj->pro_rsk'";
            $product = $this->db->query($updateSql)->row();

            if (count($product) > 0) {
                $currentDate = date("Y-m-d H:i:s");
//                $productId = $product['id'];
                $insertSql = "INSERT INTO $this->list_pro_tbl (list_id, product_id, rsk_no, quantity, status, created_at, updated_at) VALUES ('$recordObj->list_id', '$product->id', '$recordObj->pro_rsk','$recordObj->quantity', '1', '$currentDate','$currentDate')";
                $this->db->query($insertSql);
            }
        }
    }

    public function getListProduct($listId) {
        return $this->db->select('t.product_id,t.rsk_no, t.quantity, pro.name as pro_name')
                        ->from($this->list_pro_tbl . " as t")
                        ->join("products as pro", "pro.id = t.product_id")
                        ->where("t.list_id = $listId")
                        ->get()
                        ->result();
    }

    public function getEstoreProduct($proRsk = array()) {
        $RSK = implode(",", $proRsk);
        $insertSql = "SELECT * FROM estore_products WHERE FIND_IN_SET(rsk_no, '$RSK') ORDER BY store_id ASC";
        $result = $this->db->query($insertSql)->result();
        return $result;
    }

}
