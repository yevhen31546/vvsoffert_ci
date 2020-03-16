<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Price_model extends CI_Model {

    protected $table = 'products';

    public function __construct() {
        parent::__construct();
    }
public function product_price($search,$limit, $start) {
	
	$a=$search['min'];
	$b=$search['max'];
	$c=$search['manuf'];
	$d=$search['cat'];
if (isset($search['min'])) {
  
 $this->db->query('SET SQL_BIG_SELECTS=1'); 

  $this->db->select('products.url, products.Name, products.id, products.Produktnamn,products.Produkt, products.ImageName, products.Manufacturer, products.ProductId ,products.RSKnummer, products.RSKnummer0 ,estore_products.price , estore_products.track_id,manufacturer.name,categories.Name AS catname');



$this->db->from('products');
$this->db->join('estore_products', 'estore_products.rsk_no = products.RSKnummer');
$this->db->join('manufacturer', 'manufacturer.id = products.Manufacturer');
 $this->db->join('categories', 'products.category1 = categories.id');   
if (!empty($c) && !empty($d))
{
$this->db->where('estore_products.price between "'.$a.'" and "'.$b.'" AND products.Manufacturer IN ('.$c.') AND products.category1 IN ('.$d.')');
}
if (!empty($c))
{
$this->db->where('estore_products.price between "'.$a.'" and "'.$b.'" AND products.Manufacturer IN ('.$c.')');
}
if (!empty($d))
{

$this->db->where('estore_products.price between "'.$a.'" and "'.$b.'" AND categories.id IN ('.$d.')');
}
if (empty($c) && empty($d))
{
    $this->db->where('estore_products.price between "'.$a.'" and "'.$b.'"');
}

$this->db->limit($limit, $start);
$query = $this->db->get();

$data = $query->result_array();



return $data;

        }
       

}	
 public function count_all() {
        
$query = $this->db->get("products");
  return $query->num_rows();



    }
}
?>
