<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Estore_model extends CI_Model {

    protected $table = 'estore_master';
    protected $estore_pro_table = 'estore_products';

    public function __construct() {
        parent::__construct();
    }

    public function find($id = 0) {
        return $this->db->select('*')
                        ->from($this->table)
                        ->where("id = $id")
                        ->get()
                        ->row();
    }

    public function insert($insert) {
        $this->db->insert($this->table, $insert);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function insert_store_product($insert) {
        $this->db->insert($this->estore_pro_table, $insert);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function update($update, $id) {
        $this->db->update($this->table, $update, array('id' => $id));
    }

    public function update_store_product($update, $id) {
        $this->db->update($this->estore_pro_table, $update, array('id' => $id));
    }

    public function delete($id) {
        $this->db->delete($this->table, array('id' => $id));
    }

    public function check_eproduct($id) {
        return 0;
    }

    public function count_total_store($_s_key = "") {
        $_searchKey = "%$_s_key%";
        return $this->db->select('t.*')
                        ->from($this->table . " as t")
                        ->where("t.name LIKE '$_searchKey' AND status = 1")
                        ->count_all_results();
    }

    public function all_store() {
        return $this->db->select('t.id, t.name')
                        ->from($this->table . " as t")
                        ->where("status = 1")
                        ->get()
                        ->result();
    }

    public function get_search_store_result($_s_key = "", $_limit = 10, $_page = 1, $_s_sort_by = "t.name", $_s_order_by = "ASC") {
        $_offset = ($_page - 1) * $_limit;

        $_searchKey = "%$_s_key%";
        return $this->db->select("t.id, t.name, t.logoImage, IFNULL((SELECT COUNT(pro.id) FROM $this->estore_pro_table as pro WHERE pro.store_id = t.id), 0) as pCount")
                        ->from("$this->table as t")
                        ->where("t.name LIKE '$_searchKey' AND status = 1")
                        ->order_by("$_s_sort_by", "$_s_order_by")
                        ->limit($_limit)
                        ->offset($_offset)
                        ->get()
                        ->result();
    }

    public function ajax_search_field_autocomplete($_s_key = "") {
        $_searchKey = "%$_s_key%";
        return $this->db->select('t.*')
                        ->from($this->table . " as t")
                        ->where("t.name LIKE '$_searchKey' AND status = 1")
                        ->get()
                        ->result();
    }

    public function total_store_products($storeId, $_s_key = "") {
        $_searchKey = "%$_s_key%";
        return $this->db->select('t.*')
                        ->from("$this->estore_pro_table as t")
                        ->where("REPLACE(t.rsk_no,' ','') LIKE '$_searchKey' AND t.store_id = $storeId")
                        ->count_all_results();
    }

    public function find_store_products($storeId, $_s_key = "", $_limit = 10, $_page = 1, $_s_sort_by = "t.rsk_no", $_s_order_by = "ASC") {
        $_offset = ($_page - 1) * $_limit;

        $_searchKey = "%$_s_key%";
        return $this->db->select('t.*')
                        ->from("$this->estore_pro_table as t")
                        ->where("(REPLACE(t.rsk_no,' ','') LIKE '$_searchKey' OR t.product_name LIKE '$_searchKey') AND t.store_id = $storeId")
                        ->order_by("$_s_sort_by", "$_s_order_by")
                        ->limit($_limit)
                        ->offset($_offset)
                        ->get()
                        ->result();
    }

    public function ajax_store_product_search_field_autocomplete($storeId, $_s_key = "") {
        $_searchKey = "%$_s_key%";
        return $this->db->select('t.rsk_no, t.product_name')
                        ->from("$this->estore_pro_table as t")
                        ->where("(REPLACE(t.rsk_no,' ','') LIKE '$_searchKey' OR t.product_name LIKE '$_searchKey') AND t.store_id = $storeId")
                        ->get()
                        ->result();
    }

    public function find_store_pro($store, $proRSK) {
        return $this->db->select('id')
                        ->from("$this->estore_pro_table as t")
                        ->where("t.store_id = $store AND REPLACE(t.rsk_no,' ','') LIKE '$proRSK'")
                        ->get()
                        ->row();
    }

    public function productTrackId($digits = 15) {
        $alphanum = "0123456789";

        // generate the random string
        $rand = substr(str_shuffle($alphanum), 0, $digits);
        $findTrackPro = $this->db->select('id')
                ->from("$this->estore_pro_table as t")
                ->where("t.track_id LIKE '$rand'")
                ->count_all_results();
        if ($findTrackPro > 0) {
            $this->productTrackId();
        }
        return $rand;
    }

    public function user_imporet_pro_rsk_insert($importData) {
        $this->db->insert("user_import_pro_rsk_number", $importData);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function get_user_request_pro_list($userId, $tokenId) {
        return $this->db->select('*')
                        ->from("user_import_pro_rsk_number")
                        ->where("trackId = $tokenId AND user_id = $userId")
                        ->get()
                        ->result();
    }

    public function get_user_request_pro_list_track($userId) {
        return $this->db->select('*')
                        ->from("user_import_pro_rsk_number")
                        ->where("user_id = $userId")
                        ->order_by("id", "DESC")
                        ->get()
                        ->row();
    }

    public function remove_user_request_pro_list($userId, $tokenId) {
        return $this->db->delete("user_import_pro_rsk_number", array('trackId' => $tokenId, 'user_id' => $userId));
    }

    public function get_store_pro_by_rsk($proRSK) {
        $proRSK = str_replace(" ", "", $proRSK);
        if(empty($proRSK)) {
            // $proRSK = '%any%';
        }
        return $this->db->select('t.*, sellerTbl.name as seller, sellerTbl.logoImage as logoImage')
                        ->from("$this->estore_pro_table as t")
                        ->join("$this->table as sellerTbl", 't.store_id = sellerTbl.id', 'left')
                        ->where("REPLACE(t.rsk_no,' ','') LIKE '$proRSK'")
                        ->where("sellerTbl.status" , '1')
                         ->order_by("t.price", "ASC")
                        ->get()
                        ->result();
    }
    public function get_store_pro_by_rsk_order_by_discount_price($proRSK) {
        $proRSK = str_replace(" ", "", $proRSK);
        return $this->db->select('t.*, sellerTbl.name as seller, sellerTbl.logoImage as logoImage')
                        ->from("$this->estore_pro_table as t")
                        ->join("$this->table as sellerTbl", 't.store_id = sellerTbl.id', 'left')
                        ->where("REPLACE(t.rsk_no,' ','') LIKE $proRSK")
                        ->where("sellerTbl.status" , '1')
                         ->order_by("t.discountprice", "ASC")
                        ->get()
                        ->result();
    }

    public function find_store_pro_by_RSK($proRSK) {
        $proRSK = str_replace(" ", "", $proRSK);
        return $this->db->select('*')
                        ->from("$this->estore_pro_table as t")
                        ->where("REPLACE(t.rsk_no,' ','') LIKE '$proRSK'")
                        ->get()
                        ->row();
    }

    public function find_all_store_pro_by_RSK($proRSK) {
        $proRSK = str_replace(" ", "", $proRSK);
        return $this->db->select('*')
                        ->from("$this->estore_pro_table as t")
                        ->where("REPLACE(t.rsk_no,' ','') LIKE '$proRSK'")
                        ->get()
                        ->result();
    }

    public function find_store_pro_by_RSK_store($proRSK, $estore) {
        $proRSK = str_replace(" ", "", $proRSK);
        return $this->db->select('*')
                        ->from("$this->estore_pro_table as t")
                        ->where("REPLACE(t.rsk_no,' ','') LIKE '$proRSK' AND t.store_id = $estore")
                        ->get()
                        ->row();
    }

}
