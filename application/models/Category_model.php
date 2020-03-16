<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_model extends CI_Model {

    protected $table = 'categories';

    public function __construct() {
        parent::__construct();
    }

    public function nor() {
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function search($search) {
        return $this->db->get_where($this->table, $search)->row();
    }

    public function get_by_slug($slug) {
        //echo $slug;exit;
        return $this->db->get_where($this->table, array('slug' => $slug))->row_array();
    }

    public function get($id) {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function get_all() {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function get_main_category() {
        $sql = 'SELECT * FROM `categories` WHERE pid IS NULL and pid2 IS NULL ORDER BY name ASC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_main_category_nor() {
        $sql = 'SELECT count(id) as totalRows FROM `categories` WHERE pid IS NULL and pid2 IS NULL ORDER BY ID ASC';
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function get_sub_category1($id) {
        $sql = 'SELECT * FROM `categories` WHERE pid = ? AND `pid2` IS NULL ORDER BY name ASC';
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    public function get_sub_category1_nor() {
        $sql = 'SELECT pid, count(id) as subcategory FROM `categories` WHERE `pid` IS NOT NULL AND `pid2` IS NULL GROUP BY pid';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_sub_category2($id) {
        $sql = 'SELECT * FROM `categories` WHERE pid2 = ? ORDER BY name ASC';
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    public function get_sub_category2_nor($pid) {
        $sql = 'SELECT pid2, count(id) as subcategory FROM `categories` WHERE pid = ? AND `pid2` IS NOT NULL GROUP BY pid2';
        $query = $this->db->query($sql, $pid);
        return $query->result();
    }

    public function get_by_group($id) {
        $sql = 'SELECT DISTINCT categories.id, categories.name, categories.slug, products.category1 FROM products INNER JOIN categories ON categories.id=products.category1 WHERE products.groupName=? LIMIT 0,10';
        $query = $this->db->query($sql, array($id));
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

    public function update_where($update, $where) {
        $this->db->update($this->table, $update, $where);
    }

    public function delete($id) {
        $this->db->delete('posts', array('id' => $id));
    }

    public function ajax_search_field_autocomplete($_s_key, $_pid, $_pid2) {
        $searchKey = "%$_s_key%";
        if ($_pid == NULL && $_pid2 == NULL) {
            $condition = "t.name LIKE '$searchKey' AND t.pid IS NULL AND t.pid2 IS NULL";
        } elseif ($_pid > 0 && $_pid2 == NULL) {
            $condition = "t.name LIKE '$searchKey' AND pid = $_pid AND t.pid2 IS NULL";
        } elseif ($_pid > 0 && $_pid2 > 0) {
            $condition = "t.name LIKE '$searchKey' AND pid = $_pid AND t.pid2 = $_pid2";
        }

        return $this->db->select('t.name')
                        ->from($this->table . " as t")
                        ->where($condition)
                        ->get()
                        ->result();
    }

    public function count_main_category($_s_key = "") {
        $searchKey = "%$_s_key%";
        return $this->db->select('t.*')
                        ->from($this->table . " as t")
                        ->where("t.name LIKE '$searchKey' AND pid IS NULL AND t.pid2 IS NULL")
                        ->count_all_results();
    }

    public function search_main_category($_s_key, $_s_sort_by, $_s_order_by, $limit, $pageNumber) {
        $offset = ($pageNumber - 1) * $limit;
        $searchKey = "%$_s_key%";
        return $this->db->select('t.id, t.name, t.slug, t.pid, t.pid2, IFNULL( ( SELECT  COUNT(subcat.id) FROM categories as subcat WHERE subcat.pid = t.id AND subcat.pid2 IS NULL ), 0) as subCatCount, IFNULL((SELECT COUNT(pro.id) FROM products as pro WHERE pro.category1 = t.id), 0) as pCount')
                        ->from("$this->table as t")
                        ->where("t.name LIKE '$searchKey' AND t.pid IS NULL AND t.pid2 IS NULL")
                        ->order_by("$_s_sort_by", "$_s_order_by")
                        ->limit($limit)
                        ->offset($offset)
                        ->get()
                        ->result();
    }

    public function count_sub_main_category($_s_key = "", $_pid) {
        $searchKey = "%$_s_key%";
        return $this->db->select('t.*')
                        ->from($this->table . " as t")
                        ->where("t.name LIKE '$searchKey' AND pid = $_pid AND t.pid2 IS NULL")
                        ->count_all_results();
    }

    public function search_sub_main_category($_s_key, $_pid, $_s_sort_by, $_s_order_by, $limit, $pageNumber) {
        $offset = ($pageNumber - 1) * $limit;
        $searchKey = "%$_s_key%";
        return $this->db->select('t.id, t.name, t.slug, t.pid, t.pid2, IFNULL(( SELECT COUNT(subcat.id) FROM categories as subcat WHERE subcat.pid = t.pid AND subcat.pid2 = t.id ), 0) as subCatCount, IFNULL((SELECT COUNT(pro.id) FROM products as pro WHERE pro.category1 LIKE t.pid AND pro.category2 LIKE t.id), 0) as pCount')
                        ->from("$this->table as t")
                        ->where("t.name LIKE '$searchKey' AND t.pid = $_pid AND t.pid2 IS NULL")
                        ->order_by("$_s_sort_by", "$_s_order_by")
                        ->limit($limit)
                        ->offset($offset)
                        ->get()
                        ->result();
    }

    public function count_sub_category($_s_key = "", $_pid, $_pid2) {
        $searchKey = "%$_s_key%";
        return $this->db->select('t.*')
                        ->from($this->table . " as t")
                        ->where("t.name LIKE '$searchKey' AND pid = $_pid AND t.pid2 = $_pid2")
                        ->count_all_results();
    }

    public function search_sub_category($_s_key, $_pid, $_pid2, $_s_sort_by, $_s_order_by, $limit, $pageNumber) {
        $offset = ($pageNumber - 1) * $limit;
        $searchKey = "%$_s_key%";
        return $this->db->select('t.id, t.name, t.slug, t.pid, t.pid2, IFNULL( ( SELECT  COUNT(subcat.id) FROM categories as subcat WHERE subcat.pid = t.pid AND subcat.pid2 = t.id ), 0) as subCatCount, IFNULL((SELECT COUNT(pro.id) FROM products as pro WHERE pro.category1 LIKE t.pid AND pro.category2 LIKE t.pid2 AND pro.category3 LIKE t.id), 0) as pCount')
                        ->from("$this->table as t")
                        ->where("t.name LIKE '$searchKey' AND t.pid = $_pid AND t.pid2 = $_pid2")
                        ->order_by("$_s_sort_by", "$_s_order_by")
                        ->limit($limit)
                        ->offset($offset)
                        ->get()
                        ->result();
    }

    public function main_category($_s_key = "") {
        return $this->db->select('t.*')
                        ->from($this->table . " as t")
                        ->where("t.name LIKE '$_s_key' AND pid IS NULL AND t.pid2 IS NULL")
                        ->get()
                        ->row();
    }

    public function sub_main_category($_s_key = "", $_pid) {
        return $this->db->select('t.*')
                        ->from($this->table . " as t")
                        ->where("t.name LIKE '$_s_key' AND pid = $_pid AND t.pid2 IS NULL")
                        ->get()
                        ->row();
    }

    public function sub_category($_s_key = "", $_pid, $_pid2) {
        return $this->db->select('t.*')
                        ->from("$this->table as t")
                        ->where("t.name LIKE '$_s_key' AND t.pid = $_pid AND t.pid2 = $_pid2")
                        ->get()
                        ->row();
    }

    public function get_cat_total_product($catId) {
        return $this->db->select('t.id')
                        ->from("products as t")
                        ->where("t.category1 = '$catId' OR t.category2 = '$catId' OR t.category3 = '$catId'")
                        ->count_all_results();
    }

    public function delete_categories($catId) {
        $category = $this->db->select('t.id, t.pid, t.pid2')
                ->from("$this->table as t")
                ->where("t.id = '$catId'")
                ->get()
                ->row();
        
        if (count($category) > 0 && $category->pid == NULL && $category->pid2 == NULL) {
            $subMainCat = $this->db->select('t.id')
                    ->from("$this->table as t")
                    ->where("t.pid = '$category->id' AND t.pid2 is NULL")
                    ->get()
                    ->result();

            if (count($subMainCat) > 0) {
                foreach ($subMainCat as $v) {
                    $v = (object) $v;
                    $subCat = $this->db->select('t.id, t.pid, t.pid2')
                            ->from("$this->table as t")
                            ->where("t.pid = '$category->id' AND t.pid2 = $v->id")
                            ->get()
                            ->result();
                    if (count($subCat) > 0) {
                        foreach ($subCat as $sV) {
                            $this->db->delete("$this->table", array('id' => $sV->id));
                        }
                    }

                    $this->db->delete("$this->table", array('id' => $v->id));
                }
            }
            $this->db->delete("$this->table", array('id' => $category->id));
        }

        if (count($category) > 0 && $category->pid != NULL && $category->pid2 == NULL) {
            $subCat = $this->db->select('t.id, t.pid, t.pid2')
                    ->from("$this->table as t")
                    ->where("t.pid = '$category->pid' AND t.pid2 = '$category->id")
                    ->get()
                    ->result();

            if (count($subCat) > 0) {
                foreach ($subCat as $v) {
                    $v = (object) $v;
                    $this->db->delete("$this->table", array('id' => $v->id));
                }
            }
            $this->db->delete("$this->table", array('id' => $category->id));
        }

        if (count($category) > 0 && $category->pid != NULL && $category->pid2 != NULL) {
            $this->db->delete("$this->table", array('id' => $category->id));
        }
        return 1;
    }

}
