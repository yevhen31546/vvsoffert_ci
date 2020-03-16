<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products_model extends CI_Model {

    protected $table = 'products';

    public function __construct() {
        parent::__construct();
    }

    public function get_total2($search = NULL) {
        $this->db->select('id');
        if (!empty($search)) {
            if (isset($search['text'])) {
                $this->db->like('Name', $search['text']);
                $this->db->or_like('RSKnummer0', $search['text']);
                $this->db->or_like('RSKnummer', $search['text']);
                unset($search['text']);
            }
            $this->db->where($search);
        }
        $query = $this->db->get($this->table);
        $num = $query->num_rows();
        return $num;
    }

    public function get_total($search = NULL) {

        if (isset($search['Manufacturer']))
            $where = 'and Manufacturer=' . $search['Manufacturer'];
        else
            $where = '';

        if (empty($search)) {
            $sql = 'SELECT id FROM ' . $this->table;
            $query = $this->db->query($sql);
        } else if (isset($search['category1'])) {
            if (isset($search['text'])) {
                $sql = "SELECT id From " . $this->table . " WHERE category1=? and (Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Tillverkarensartikelnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Tillverkarensartikelnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Produkt LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Produktnamn LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR TryckFlodeTemp LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR EffektEldata LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Funktion LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Utforande LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Farg LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Ytbehandling LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Material LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Standard LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Ovriginfo LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR EgenbenamningSvensk LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Ersattav LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Varumarke LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Tillverkarensproduktsida LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . ") " . $where;
                $query = $this->db->query($sql, array($search['category1']));
            } else {
                $sql = 'SELECT id From ' . $this->table . ' WHERE category1=? ' . $where;
                $query = $this->db->query($sql, array($search['category1']));
            }
        } else if (isset($search['category2'])) {
            if (isset($search['text'])) {
                $sql = "SELECT id From " . $this->table . " WHERE category2=? and (Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Tillverkarensartikelnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Tillverkarensartikelnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Produkt LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Produktnamn LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR TryckFlodeTemp LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR EffektEldata LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Funktion LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Utforande LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Farg LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Ytbehandling LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Material LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Standard LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Ovriginfo LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR EgenbenamningSvensk LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Ersattav LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Varumarke LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Tillverkarensproduktsida LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . ") " . $where;
                $query = $this->db->query($sql, array($search['category2']));
            } else {
                $sql = 'SELECT id From ' . $this->table . ' WHERE ' . $this->table . '.category2=? ' . $where;
                $query = $this->db->query($sql, array($search['category2']));
            }
        } else if (isset($search['category3'])) {
            if (isset($search['text'])) {
                $sql = "SELECT id From " . $this->table . " WHERE category3=? and (Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Tillverkarensartikelnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Tillverkarensartikelnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Produkt LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Produktnamn LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR TryckFlodeTemp LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR EffektEldata LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Funktion LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Utforande LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Farg LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Ytbehandling LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Material LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Standard LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Ovriginfo LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR EgenbenamningSvensk LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Ersattav LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Varumarke LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR Tillverkarensproduktsida LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . ") " . $where;
                $query = $this->db->query($sql, array($search['category3']));
            } else {
                $sql = 'SELECT id From ' . $this->table . ' WHERE ' . $this->table . '.category3=? ' . $where;
                $query = $this->db->query($sql, array($search['category3']));
            }
        } else if (isset($search['text'])) {
            $sql = "SELECT id From " . $this->table . " WHERE (Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Tillverkarensartikelnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Tillverkarensartikelnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Produkt LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Produktnamn LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR TryckFlodeTemp LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR EffektEldata LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Funktion LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Utforande LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Farg LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Ytbehandling LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Material LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Standard LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Ovriginfo LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR EgenbenamningSvensk LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Ersattav LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Varumarke LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR Tillverkarensproduktsida LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . ") " . $where;
            $query = $this->db->query($sql);
        } else if (isset($search['Manufacturer'])) {
            $sql = "SELECT id From " . $this->table . " WHERE Manufacturer=" . $search['Manufacturer'];
            $query = $this->db->query($sql);
        }
        return $query->num_rows();
    }

    public function get_total_bk_2017_12_19($search = NULL) {

        if (isset($search['Manufacturer']))
            $where = 'and Manufacturer=' . $search['Manufacturer'];
        else
            $where = '';

        if (empty($search)) {
            $sql = 'SELECT id FROM ' . $this->table;
            $query = $this->db->query($sql);
        } else if (isset($search['category1'])) {
            if (isset($search['text'])) {
                $sql = "SELECT id From " . $this->table . " WHERE category1=? and (Name LIKE '%" . $search['text'] . "%' ESCAPE '!' OR RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!' OR RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!') " . $where;
                $query = $this->db->query($sql, array($search['category1']));
            } else {
                $sql = 'SELECT id From ' . $this->table . ' WHERE category1=? ' . $where;
                $query = $this->db->query($sql, array($search['category1']));
            }
        } else if (isset($search['category2'])) {
            if (isset($search['text'])) {
                $sql = "SELECT id From " . $this->table . " WHERE category2=? and (Name LIKE '%" . $search['text'] . "%' ESCAPE '!' OR RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!' OR RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!') " . $where;
                $query = $this->db->query($sql, array($search['category2']));
            } else {
                $sql = 'SELECT id From ' . $this->table . ' WHERE ' . $this->table . '.category2=? ' . $where;
                $query = $this->db->query($sql, array($search['category2']));
            }
        } else if (isset($search['category3'])) {
            if (isset($search['text'])) {
                $sql = "SELECT id From " . $this->table . " WHERE category3=? and (Name LIKE '%" . $search['text'] . "%' ESCAPE '!' OR RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!' OR RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!') " . $where;
                $query = $this->db->query($sql, array($search['category3']));
            } else {
                $sql = 'SELECT id From ' . $this->table . ' WHERE ' . $this->table . '.category3=? ' . $where;
                $query = $this->db->query($sql, array($search['category3']));
            }
        } else if (isset($search['text'])) {
            $sql = "SELECT id From " . $this->table . " WHERE (Name LIKE '%" . $search['text'] . "%' ESCAPE '!' OR RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!' OR RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!') " . $where;
            $query = $this->db->query($sql);
        } else if (isset($search['Manufacturer'])) {
            $sql = "SELECT id From " . $this->table . " WHERE Manufacturer=" . $search['Manufacturer'];
            $query = $this->db->query($sql);
        }
        return $query->num_rows();
    }

    public function get($id) {
        
        $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, ' . $this->table . '. * From ' . $this->table . ' LEFT JOIN categories ON categories.id = ' . $this->table . '.category1 LEFT JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.id=? ORDER BY id DESC LIMIT 0 , 1';
        // $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, ' . $this->table . '. * From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category1 INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.id=? ORDER BY id DESC LIMIT 0 , 1';
        //$sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, ' . $this->table . '. * From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category1 WHERE ' . $this->table . '.id=? ORDER BY id DESC LIMIT 0 , 1';
        $query = $this->db->query($sql, $id);
        return $query->row();
    }
    
    public function getbyrsknumber($id) {
        $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, ' . $this->table . '. * From ' . $this->table . ' LEFT JOIN categories ON categories.id = ' . $this->table . '.category1 LEFT JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.RSKnummer=? ORDER BY id DESC LIMIT 0 , 1';
        // $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, ' . $this->table . '. * From ' . $this->table . ' LEFT JOIN categories ON categories.id = ' . $this->table . '.category1 LEFT JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.id=? ORDER BY id DESC LIMIT 0 , 1';
        // $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, ' . $this->table . '. * From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category1 INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.id=? ORDER BY id DESC LIMIT 0 , 1';
        //$sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, ' . $this->table . '. * From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category1 WHERE ' . $this->table . '.id=? ORDER BY id DESC LIMIT 0 , 1';
        $query = $this->db->query($sql, $id);
        return $query->row();
    }

    public function get_products($search = NULL, $start = 0) {

        if (isset($search['Manufacturer']))
            $where = 'and ' . $this->table . '.Manufacturer=' . $search['Manufacturer'];
        else
            $where = '';

        if (empty($search)) {
            $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, ' . $this->table . '. * From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category3 INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer ORDER BY ' . $this->table . '.id DESC LIMIT ? , 99';
            $query = $this->db->query($sql, $start);
        } else if (isset($search['category1'])) {
            if (isset($search['text'])) {
                $sql = "SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, " . $this->table . ". * From " . $this->table . " INNER JOIN categories ON categories.id = " . $this->table . ".category1 INNER JOIN manufacturer ON manufacturer.id = " . $this->table . ".Manufacturer WHERE " . $this->table . ".category1=? and (" . $this->table . ".Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensartikelnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensartikelnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Produkt LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Produktnamn LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".TryckFlodeTemp LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".EffektEldata LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Funktion LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Utforande LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Farg LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ytbehandling LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Material LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Standard LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ovriginfo LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".EgenbenamningSvensk LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ersattav LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Varumarke LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensproduktsida LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . ") " . $where . " ORDER BY " . $this->table . ".id DESC LIMIT ? , 99";
                $query = $this->db->query($sql, array($search['category1'], $start));
            } else {
                $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, ' . $this->table . '. * From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category1 INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.category1=? ' . $where . ' ORDER BY ' . $this->table . '.id DESC LIMIT ? , 99';
                $query = $this->db->query($sql, array($search['category1'], $start));
            }
        } else if (isset($search['category2'])) {
            if (isset($search['text'])) {
                $sql = "SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, " . $this->table . ". * From " . $this->table . " INNER JOIN categories ON categories.id = " . $this->table . ".category1 INNER JOIN manufacturer ON manufacturer.id = " . $this->table . ".Manufacturer WHERE " . $this->table . ".category2=? and (" . $this->table . ".Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensartikelnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensartikelnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Produkt LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Produktnamn LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".TryckFlodeTemp LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".EffektEldata LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Funktion LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Utforande LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Farg LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ytbehandling LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Material LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Standard LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ovriginfo LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".EgenbenamningSvensk LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ersattav LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Varumarke LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensproduktsida LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . ") " . $where . " ORDER BY " . $this->table . ".id DESC LIMIT ? , 99";
                $query = $this->db->query($sql, array($search['category2'], $start));
            } else {
                $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, ' . $this->table . '. * From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category1 INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.category2=? ' . $where . ' ORDER BY ' . $this->table . '.id DESC LIMIT ? , 99';
                $query = $this->db->query($sql, array($search['category2'], $start));
            }
        } else if (isset($search['category3'])) {
            if (isset($search['text'])) {
                $sql = "SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, " . $this->table . ". * From " . $this->table . " INNER JOIN categories ON categories.id = " . $this->table . ".category1 INNER JOIN manufacturer ON manufacturer.id = " . $this->table . ".Manufacturer WHERE " . $this->table . ".category3=? and (" . $this->table . ".Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensartikelnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensartikelnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Produkt LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Produktnamn LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".TryckFlodeTemp LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".EffektEldata LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Funktion LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Utforande LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Farg LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ytbehandling LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Material LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Standard LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ovriginfo LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".EgenbenamningSvensk LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ersattav LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Varumarke LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensproduktsida LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . ") " . $where . " ORDER BY " . $this->table . ".id DESC LIMIT ? , 99";
                $query = $this->db->query($sql, array($search['category3'], $start));
            } else {
                $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, ' . $this->table . '. * From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category1 INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.category3=? ' . $where . ' ORDER BY ' . $this->table . '.id DESC LIMIT ? , 99';
                $query = $this->db->query($sql, array($search['category3'], $start));
            }
        } else if (isset($search['text'])) {
            $sql = "SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, " . $this->table . ". * From " . $this->table . " LEFT JOIN categories ON categories.id = " . $this->table . ".category1 LEFT JOIN manufacturer ON manufacturer.id = " . $this->table . ".Manufacturer WHERE (" . $this->table . ".Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
            //  $sql = "SELECT  " . $this->table . ". * From " . $this->table . " WHERE (" . $this->table . ".Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Tillverkarensartikelnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Tillverkarensartikelnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Produkt LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Produktnamn LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".TryckFlodeTemp LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".EffektEldata LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Funktion LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Utforande LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Farg LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Ytbehandling LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Material LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Standard LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Ovriginfo LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".EgenbenamningSvensk LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Ersattav LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Varumarke LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Tillverkarensproduktsida LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . ") " . $where . " ORDER BY " . $this->table . ".id DESC LIMIT ? , 99";
                    //echo $sql;exit;
            $query = $this->db->query($sql, array($start));
        } else if (isset($search['Manufacturer'])) {
            $sql = "SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, " . $this->table . ". * From " . $this->table . " INNER JOIN categories ON categories.id = " . $this->table . ".category1 INNER JOIN manufacturer ON manufacturer.id = " . $this->table . ".Manufacturer WHERE " . $this->table . ".Manufacturer=" . $search['Manufacturer'] . " ORDER BY " . $this->table . ".id DESC LIMIT ? , 99";
            $query = $this->db->query($sql, array($start));
        }
        return $query->result();
    }

    public function get_manu($search = NULL) {

        if (isset($search['Manufacturer']))
            $where = 'and ' . $this->table . '.Manufacturer=' . $search['Manufacturer'];
        else
            $where = '';

        if (empty($search) || (count($search) == 1 and isset($search['Manufacturer']))) {
            $sql = 'SELECT manufacturer.name AS Mname, manufacturer.id AS MID, ' . $this->table . '.id From ' . $this->table . ' INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer GROUP BY ' . $this->table . '.Manufacturer';
            $query = $this->db->query($sql);
        } else if (isset($search['category1'])) {
            if (isset($search['text'])) {
                $sql = "SELECT manufacturer.name AS Mname, manufacturer.id AS MID, " . $this->table . ".id From " . $this->table . " INNER JOIN manufacturer ON manufacturer.id = " . $this->table . ".Manufacturer WHERE " . $this->table . ".category1=? and (" . $this->table . ".Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensartikelnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensartikelnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Produkt LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Produktnamn LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".TryckFlodeTemp LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".EffektEldata LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Funktion LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Utforande LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Farg LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ytbehandling LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Material LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Standard LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ovriginfo LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".EgenbenamningSvensk LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ersattav LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Varumarke LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensproduktsida LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . ") GROUP BY " . $this->table . ".Manufacturer";
                $query = $this->db->query($sql, array($search['category1']));
            } else {
                $sql = 'SELECT manufacturer.name AS Mname, manufacturer.id AS MID, ' . $this->table . '.id From ' . $this->table . ' INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.category1=? GROUP BY ' . $this->table . '.Manufacturer';
                $query = $this->db->query($sql, array($search['category1']));
            }
        } else if (isset($search['category2'])) {
            if (isset($search['text'])) {
                $sql = "SELECT manufacturer.name AS Mname, manufacturer.id AS MID, " . $this->table . ".id From " . $this->table . " INNER JOIN manufacturer ON manufacturer.id = " . $this->table . ".Manufacturer WHERE " . $this->table . ".category2=? and (" . $this->table . ".Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensartikelnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensartikelnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Produkt LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Produktnamn LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".TryckFlodeTemp LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".EffektEldata LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Funktion LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Utforande LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Farg LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ytbehandling LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Material LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Standard LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ovriginfo LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".EgenbenamningSvensk LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ersattav LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Varumarke LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensproduktsida LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . ") GROUP BY " . $this->table . ".Manufacturer";
                $query = $this->db->query($sql, array($search['category2']));
            } else {
                $sql = 'SELECT manufacturer.name AS Mname, manufacturer.id AS MID, ' . $this->table . '.id From ' . $this->table . ' INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.category2=? GROUP BY ' . $this->table . '.Manufacturer';
                $query = $this->db->query($sql, array($search['category2']));
            }
        } else if (isset($search['category3'])) {
            if (isset($search['text'])) {
                $sql = "SELECT manufacturer.name AS Mname, manufacturer.id AS MID, " . $this->table . ".id From " . $this->table . " INNER JOIN manufacturer ON manufacturer.id = " . $this->table . ".Manufacturer WHERE " . $this->table . ".category3=? and (" . $this->table . ".Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensartikelnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensartikelnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Produkt LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Produktnamn LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".TryckFlodeTemp LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".EffektEldata LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Funktion LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Utforande LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Farg LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ytbehandling LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Material LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Standard LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ovriginfo LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".EgenbenamningSvensk LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Ersattav LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Varumarke LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . " OR " . $this->table . ".Tillverkarensproduktsida LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                        . ") GROUP BY " . $this->table . ".Manufacturer";
                $query = $this->db->query($sql, array($search['category3']));
            } else {
                $sql = 'SELECT manufacturer.name AS Mname, manufacturer.id AS MID, ' . $this->table . '.id From ' . $this->table . ' INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.category3=? GROUP BY ' . $this->table . '.Manufacturer';
                $query = $this->db->query($sql, array($search['category3']));
            }
        } else if (isset($search['text'])) {
            $sql = "SELECT manufacturer.name AS Mname, manufacturer.id AS MID, " . $this->table . ".id From " . $this->table . " INNER JOIN manufacturer ON manufacturer.id = " . $this->table . ".Manufacturer WHERE (" . $this->table . ".Name LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".RSKnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".RSKnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Tillverkarensartikelnummer0 LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Tillverkarensartikelnummer LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Produkt LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Produktnamn LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".TryckFlodeTemp LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".EffektEldata LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Funktion LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Utforande LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Farg LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Ytbehandling LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Material LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Standard LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Ovriginfo LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".EgenbenamningSvensk LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Ersattav LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Varumarke LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . " OR " . $this->table . ".Tillverkarensproduktsida LIKE '%" . $search['text'] . "%' ESCAPE '!'"
                    . ") GROUP BY " . $this->table . ".Manufacturer";
            $query = $this->db->query($sql);
        }

        return $query->result();
    }

    public function random() {
        $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, ' . $this->table . '. * From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category1 INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.markera_populer = "1" ORDER BY id DESC LIMIT 0 , 25';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function recent() {
        $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, ' . $this->table . '. * From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category1 INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer ORDER BY ' . $this->table . '.id DESC LIMIT 0 , 6';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function related_products($id) {
        $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, ' . $this->table . '. * From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category1 INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.ProductType=? ORDER BY id DESC LIMIT 0 , 10';
        $query = $this->db->query($sql, $id);
        return $query->result();
    }

    public function group_product($id) {
        $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, categories.slug AS CSLUG, manufacturer.name AS MName, ' . $this->table . '.* From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category1 INNER JOIN manufacturer ON manufacturer.id = ' . $this->table . '.Manufacturer WHERE ' . $this->table . '.groupName=' . $id . ' ORDER BY id DESC LIMIT 0 , 4';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function category1() {
        $sql = 'SELECT categories.id, categories.name, COUNT(' . $this->table . '.id) as pcount From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category1 GROUP BY ' . $this->table . '.category1';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function category2($pid) {
        $sql = 'SELECT categories.id, categories.name, COUNT(' . $this->table . '.id) as pcount From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category2 WHERE pid=? AND `pid2` IS NULL GROUP BY ' . $this->table . '.category2';
        $query = $this->db->query($sql, $pid);
        return $query->result();
    }

    public function category3($pid, $pid2) {
        $sql = 'SELECT categories.id, categories.name, COUNT(' . $this->table . '.id) as pcount From ' . $this->table . ' INNER JOIN categories ON categories.id = ' . $this->table . '.category3 WHERE pid=? AND `pid2`=? GROUP BY ' . $this->table . '.category3';
        $query = $this->db->query($sql, array($pid, $pid2));
        return $query->result();
    }

    public function search($search, $limit = NULL) {
        $this->db->where($search);
        if (!empty($limit))
            $this->db->limit($limit);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function get_all() {
        $this->db->order_by("id", "asc");
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function insert($insert) {
//        $insert['created'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $insert);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    
    
    public function addSeo($id,$title)
    {
        
         $sitemapUrl=('sitemap5.xml');
        $xml=simplexml_load_file($sitemapUrl);
        $title=   site_url('product/' . url_title($id) . '-pid-' . $title);       
        $newNode = $xml->addChild('url');
        $newNode->addChild('loc', $title);
        $newNode->addChild('changefreq', 'weekly');
       $newNode->addChild('priority', '0.80');  
       $xml->asXML('sitemap5.xml');
        
    }

    public function update($update, $id) {
        $this->db->update($this->table, $update, array('id' => $id));
    }

    public function update_where($update, $where) {
        $this->db->update($this->table, $update, $where);
    }

    public function delete($id) {
        return $this->db->delete($this->table, array('id' => $id));
    }

    public function total_product_search_res($_s_key) {
        $searchKey = "%$_s_key%";
        return $this->db->select('t.*')
                        ->from($this->table . " as t")
                        ->join('categories', "categories.id = t.category1", "LEFT")
                        ->join('manufacturer', "manufacturer.id = t.Manufacturer", "LEFT")
                        ->where("t.Name LIKE '$searchKey' OR t.RSKnummer0 LIKE '$searchKey' OR t.RSKnummer LIKE '$searchKey' OR manufacturer.name LIKE '$searchKey' OR t.Produktnamn LIKE '$searchKey' OR t.CreatedDate LIKE '$searchKey'")
                        ->count_all_results();
    }

    public function get_product_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $pageNumber) {
        $offset = ($pageNumber - 1) * $limit;
        $searchKey = "%$_s_key%";
        return $this->db->select('t.*, categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName')
                        ->from($this->table . " as t")
                        ->join('categories', "categories.id = t.category1", "LEFT")
                        ->join('manufacturer', "manufacturer.id = t.Manufacturer", "LEFT")
                        ->where("t.Name LIKE '$searchKey' OR t.RSKnummer0 LIKE '$searchKey' OR t.RSKnummer LIKE '$searchKey' OR manufacturer.name LIKE '$searchKey' OR t.Produktnamn LIKE '$searchKey' OR t.CreatedDate LIKE '$searchKey'")
                        ->order_by("$_s_sort_by", "$_s_order_by")
                        ->limit($limit)
                        ->offset($offset)
                        ->get()
                        ->result();
    }

    public function ajax_search_field_autocomplete($_s_key) {
        $searchKey = "%$_s_key%";
        return $this->db->select('t.Name, t.RSKnummer0 as RSK,t.RSKnummer as Rsk1, categories.name AS CNAME, manufacturer.name AS MName')
                        ->from($this->table . " as t")
                        ->join('categories', "categories.id = t.category1", "LEFT")
                        ->join('manufacturer', "manufacturer.id = t.Manufacturer", "LEFT")
                        ->where("t.Name LIKE '$searchKey' OR t.RSKnummer0 LIKE '$searchKey' OR t.RSKnummer LIKE '$searchKey' OR manufacturer.name LIKE '$searchKey' OR t.Produktnamn LIKE '$searchKey'")
                        ->order_by("t.Name", "ASC")
                        ->get()
                        ->result();
    }

    public function find_rsknumber($_name) {
        return $this->db->select('t.id, t.Name')
                        ->from($this->table . " as t")
                        ->where("t.RSKnummer = '$_name'")
                        ->get()
                        ->row();
    }

    public function find_product_by_id($id) {
        return $this->db->select('*')
                        ->from($this->table . " as t")
                        ->where("t.id = $id")
                        ->get()
                        ->row();
    }

    public function change_protype_counting($proTypeId, $type = "") {
        $findProType = $this->db->select('*')
                ->from("ProductTypes")
                ->where("id = $proTypeId")
                ->get()
                ->row();
        if (count($findProType) > 0) {
            if ($type == "insert") {
                $totalProduct = $findProType->total_pro + 1;
            } else {
                $totalProduct = $findProType->total_pro - 1;
            }
            $sql = "UPDATE ProductTypes SET total_pro = $totalProduct WHERE id = $findProType->id";
            $this->db->query($sql);
        }
    }

    public function search_by_rsk($rsk_no){
        $this->db->select('id');
        $this->db->where('RSKnummer', $rsk_no);
        $query = $this->db->get($this->table);
        return $query->result();
    }
}
