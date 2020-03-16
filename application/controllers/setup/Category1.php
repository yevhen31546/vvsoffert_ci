<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category1 extends CI_Controller {

	public function index()
	{	
		// SELECT groupName FROM products GROUP by groupName ORDER BY groupName ASC
			
		/*$this->db->select('category1');
		$this->db->group_by('category1'); 
		$this->db->order_by('category1', 'asc'); 
		$query = $this->db->get('products');
		$categories = $query->result();
		
		$config = array(
			'field' => 'slug',
			'title' => 'name',
			'table' => 'categories',
			'id' => 'id',
		);
		$this->load->library('Slug',$config);*/
		
		$this->load->model('Category_model');	
		/*foreach($categories as $category)
		{
			$slug = $this->slug->create_uri($category->category1);		
			$insert['name'] = $category->category1;
			$insert['slug'] = $slug;
			$insert['mp'] = 'true';
			print_r($insert);
			$this->Category_model->insert($insert);				
		}*/
		
		$this->load->model('Products_model');	
		/*$categories = $this->Category_model->get_all();
		foreach($categories as $category)
		{
			$update['category1'] = $category->id;
			$where ['category1'] = $category->name;
			$this->Products_model->update_where($update, $where);
		}*/
	}
}
