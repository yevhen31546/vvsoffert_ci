<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdt extends CI_Controller {

	public function index()
	{		
		
		$config = array(
			'field' => 'slug',
			'title' => 'Name',
			'table' => 'products',
			'id' => 'id',
		);
		$this->load->library('Slug',$config);
		
		$this->load->model('Products_model');
		$products = $this->Products_model->get_all();
		echo $this->db->last_query();
		echo "<hr>";	
		foreach($products as $product)
		{
			$slug = $this->slug->create_uri($product->Name);		
			$update['slug'] = $slug;	
			$where ['id'] = $product->id;	
			print_r($update);
			print_r($where);	
			$this->Products_model->update_where($update, $where);
			echo '<hr style="border: 2px ridge #ccc;">';		
			die();
		}
			
		/*$groups = $this->Groups_model->get_all();
		foreach($groups as $group)
		{
			$update['groupName'] = $group->id;
			$where ['groupName'] = $group->name;
			$this->Products_model->update_where($update, $where);
		}*/
	}
}
