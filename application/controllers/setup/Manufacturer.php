<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturer extends CI_Controller {

	public function index()
	{	
			
		$this->db->select('Manufacturer');
		$this->db->group_by('Manufacturer'); 
		$this->db->order_by('Manufacturer', 'asc'); 
		$query = $this->db->get('products');
		$manufacturers = $query->result();	
		
		$config = array(
			'field' => 'slug',
			'title' => 'name',
			'table' => 'manufacturer',
			'id' => 'id',
		);
		$this->load->library('Slug',$config);
		
		$this->load->model('Manufacturer_model');	
		/*foreach($manufacturers as $manufacturer)
		{
			$slug = $this->slug->create_uri($manufacturer->Manufacturer);		
			$insert['name'] = $manufacturer->Manufacturer;
			$insert['slug'] = $slug;				
			$this->Manufacturer_model->insert($insert);				
		}*/
		
		$this->load->model('Products_model');
		/*$manufacturers = $this->Manufacturer_model->get_all();	
		foreach($manufacturers as $manufacturer)
		{
			$update['Manufacturer'] = $manufacturer->id;
			$where ['Manufacturer'] = $manufacturer->name;		
			$this->Products_model->update_where($update, $where);
		}*/
	}
}
