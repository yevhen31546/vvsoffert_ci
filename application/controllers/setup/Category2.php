<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category2 extends CI_Controller {

	public function index()
	{	
			
		/*$sql = "SELECT CONVERT(SUBSTRING_INDEX(category1,'-',-1),UNSIGNED INTEGER) AS category1 , `category2` FROM `products` GROUP BY `category1`, `category2` ORDER BY `category1` ASC, Category2 ASC";
		$query = $this->db->query($sql);
		$categories  = $query->result();
		
		$config = array(
			'field' => 'slug',
			'title' => 'name',
			'table' => 'categories',
			'id' => 'id',
		);
		$this->load->library('Slug',$config);
		
		$this->load->model('Category_model');	
		foreach($categories as $category)
		{	
			if(!empty($category->category2))
			{	
				$slug = $this->slug->create_uri($category->category2);
				$insert['name'] = $category->category2;
				$insert['mp'] = 'false';
				$insert['pid'] = $category->category1;	
				$insert['slug'] = $slug;			
				//$this->Category_model->insert($insert);
				print_r($insert);
			}
		}*/
		
		
		$this->load->model('Category_model');
		$this->load->model('Products_model');
			
		$main_categories = $this->Category_model->get_main_category();
		echo "<pre>";
		foreach($main_categories as $category)
		{
			$subcategoreis = $this->Category_model->get_sub_category1($category->id);
			if(!empty($subcategoreis))
			{
				foreach($subcategoreis as $subcategory)
				{
					$update['category2'] = $subcategory->id;
					$where ['category1'] = $subcategory->pid;
					$where ['category2'] = $subcategory->name;
					print_r($where);
					print_r($update);
					//$this->Products_model->update_where($update, $where);
					echo "<hr>";
				}
			}
		}
		echo "</pre>";	
	}
}
