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
        $this->db->order_by('created_at', 'desc');
        return $this->db->get_where($this->table, array('user_id' => $id))->result();
    }

    public function delete_list($id) {

        $this->db->delete($this->table, array('id' => $id));
    }

    public function insert_into_product_list($record = array()) {

        $recordObj = (object) $record;

        $proSql = "SELECT id FROM $this->list_pro_tbl WHERE rsk_no LIKE '$recordObj->pro_rsk' AND list_id = $recordObj->list_id";

        $pro = $this->db->query($proSql)->row();



        if (!empty($pro)) {

//            $proListId = $pro["id"];

            $findPro = "UPDATE $this->list_pro_tbl SET quantity = $recordObj->quantity WHERE id = $pro->id";

            $this->db->query($findPro);
        } else {

            $updateSql = "SELECT id FROM products WHERE RSKnummer LIKE '$recordObj->pro_rsk'";

            $product = $this->db->query($updateSql)->row();



            if (!empty($product)) {

                $currentDate = date("Y-m-d H:i:s");

//                $productId = $product['id'];

                $insertSql = "INSERT INTO $this->list_pro_tbl (list_id, product_id, rsk_no, quantity, status, created_at, updated_at) VALUES ('$recordObj->list_id', '$product->id', '$recordObj->pro_rsk','$recordObj->quantity', '1', '$currentDate','$currentDate')";

                $this->db->query($insertSql);
            }
        }
    }

    public function insert_into_product_list_price($record = array()) {

        ini_set('max_execution_time', 0);
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
        $recordObj = (object) $record;

        $proSql = "SELECT id,price FROM $this->list_pro_tbl WHERE rsk_no LIKE '$recordObj->pro_rsk' AND user_id = $recordObj->user_id";

        $pro = $this->db->query($proSql)->row();



        if (!empty($pro)) {

//            $proListId = $pro["id"];
            $price_array = [];
            if ($pro->price != '') {
                $priceArrOld = unserialize($pro->price);
                if (!empty($priceArrOld)) {
                    foreach ($priceArrOld as $priceArr => $priceVal) {
                        $price_array[$priceArr] = $priceVal;
                    }
                }
            }
            if (!empty($recordObj->price)) {
                foreach ($recordObj->price as $priceKey => $priceV) {
                    $price_array[$priceKey] = $priceV;
                }
            }
            $quantity_arr = serialize($price_array);
            $findPro = "UPDATE $this->list_pro_tbl SET price = '$quantity_arr', user_id='$recordObj->user_id' WHERE id = $pro->id";

            $this->db->query($findPro);
        } else {

            $updateSql = "SELECT id FROM products WHERE RSKnummer LIKE '$recordObj->pro_rsk'";

            $product = $this->db->query($updateSql)->row();



            if (!empty($product)) {

                $currentDate = date("Y-m-d H:i:s");

//                $productId = $product['id'];
                $quantity_arr = serialize($recordObj->price);
                $insertSql = "INSERT INTO $this->list_pro_tbl (product_id, rsk_no, price, status, created_at, updated_at, user_id) VALUES ('$product->id', '$recordObj->pro_rsk','$quantity_arr', '1', '$currentDate','$currentDate','$recordObj->user_id')";

                $this->db->query($insertSql);
            }
        }
    }

    public function getListProduct($listId) {

        return $this->db->select('t.product_id,t.rsk_no, t.user_id, t.price, t.quantity, pro.name as pro_name')
                        ->from($this->list_pro_tbl . " as t")
                        ->join("products as pro", "pro.id = t.product_id")
                        ->where("t.list_id = $listId")
                        ->get()
                        ->result();
    }
    public function getListProductNew($listId) {

        return $this->db->select('t.product_id,t.rsk_no, t.user_id, t.price, t.quantity, pro.name as pro_name, pro.unit as pro_unit')
                        ->from($this->list_pro_tbl . " as t")
                        ->join("products as pro", "pro.id = t.product_id")
                        ->where("t.list_id = $listId")
                        ->get()
                        ->result();
    }

    public function getSelectedListProduct($Ids) {

        return $this->db->select('t.product_id,t.rsk_no, t.quantity, t.price, t.user_id, t.list_id, pro.name as pro_name')
                        ->from($this->list_pro_tbl . " as t")
                        ->join("products as pro", "pro.id = t.product_id")
                        ->where("t.product_id IN ($Ids)")
                        ->get()
                        ->result();
    }

    public function getSelectedListProductNew($Ids) {

        return $this->db->select('t.product_id,t.rsk_no, t.quantity, t.price, t.user_id, t.list_id, pro.name as pro_name, pro.unit as pro_unit')
                        ->from($this->list_pro_tbl . " as t")
                        ->join("products as pro", "pro.id = t.product_id")
                        ->where("t.product_id IN ($Ids)")
                        ->get()
                        ->result();
    }

    public function getSelectedListProductByUserId($Ids, $user_id) {

        return $this->db->select('t.product_id,t.rsk_no, t.quantity, t.price, t.user_id, t.list_id, pro.name as pro_name')
                        ->from($this->list_pro_tbl . " as t")
                        ->join("products as pro", "pro.id = t.product_id")
                        ->where("t.product_id IN ($Ids)  AND user_id='$user_id'")
                        ->get()
                        ->result();
    }

    public function getProductByRSK($rsk, $user_id) {

        return $this->db->select('t.product_id,t.rsk_no, t.quantity, t.price, t.user_id, t.list_id, pro.name as pro_name')
                        ->from($this->list_pro_tbl . " as t")
                        ->join("products as pro", "pro.id = t.product_id")
                        ->where("t.rsk_no = '$rsk' AND user_id='$user_id'")
                        ->get()
                        ->result();
    }

    public function getAllListProduct() {

        return $this->db->select('pro.id, pro.name as pro_name')
                        ->from("products as pro")
                        ->limit(10)
                        ->get()
                        ->result();

        /*

          return $this->db->select('t.product_id,t.rsk_no, t.quantity, pro.name as pro_name')

          ->from($this->list_pro_tbl . " as t")

          ->join("products as pro", "pro.id = t.product_id")

          ->get()

          ->result();

         * 

         */
    }

    public function getAllEstoreMaster() {

        return $this->db->select('em.*')
                        ->from("estore_master as em")
                        ->where('em.status', '1')
                        ->get()
                        ->result();

        /*

          return $this->db->select('t.product_id,t.rsk_no, t.quantity, pro.name as pro_name')

          ->from($this->list_pro_tbl . " as t")

          ->join("products as pro", "pro.id = t.product_id")

          ->get()

          ->result();

         * 

         */
    }

    public function getEstoreProduct($proRsk = array()) {

        $RSK = implode(",", $proRsk);

        $insertSql = "SELECT * FROM estore_products WHERE FIND_IN_SET(rsk_no, '$RSK') ORDER BY store_id ASC";

        $result = $this->db->query($insertSql)->result();

        return $result;
    }

}
