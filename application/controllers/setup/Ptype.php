<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ptype extends CI_Controller {

	public function index()
	{	
			
		/*$this->db->select('ProductType');
		$this->db->group_by('ProductType'); 
		$this->db->order_by('ProductType', 'asc'); 
		$query = $this->db->get('products');
		$ProductTypes = $query->result();*
		
		$config = array(
			'field' => 'slug',
			'title' => 'name',
			'table' => 'ProductTypes',
			'id' => 'id',
		);
		$this->load->library('Slug',$config);*/
		
		$this->load->model('ProductTypes_model');	
		/*foreach($ProductTypes as $ProductType)
		{
			if(!empty($ProductType->ProductType))
			{			
				$slug = $this->slug->create_uri($ProductType->ProductType);		
				$insert['name'] = $ProductType->ProductType;
				$insert['slug'] = $slug;	
				$this->ProductTypes_model->insert($insert);		
			}				
		}*/	
		
		$this->load->model('Products_model');
		$ProductTypes = $this->ProductTypes_model->get_all();
			
		/*foreach($ProductTypes as $ProductType)
		{
			$update['ProductType'] = $ProductType->id;
			$where ['ProductType'] = $ProductType->name;		
			$this->Products_model->update_where($update, $where);
			echo $ProductType->id;
			echo "<hr>";
		}*/
	}
}
