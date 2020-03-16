<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category3 extends CI_Controller {

	public function index()
	{	
			
		/*$sql = "SELECT products.id, CONVERT(SUBSTRING_INDEX(category1,'-',-1),UNSIGNED INTEGER) AS category1, CONVERT(SUBSTRING_INDEX(category2,'-',-1),UNSIGNED INTEGER) AS category2, category3 FROM `products` GROUP BY `category1`, `category2`, category3 ORDER BY `category1` ASC, Category2 ASC, category3 ASC";
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
			if(!empty($category->category3))
			{				
				$slug = $this->slug->create_uri($category->category3);
				$insert['name'] = $category->category3;
				$insert['mp'] = 'false';
				$insert['pid'] = $category->category1;
				$insert['pid2'] = $category->category2;	
				$insert['slug'] = $slug;			
				//$this->Category_model->insert($insert);
				//print_r($insert);
				echo "<hr>";
			}
		}*/
		
		/*$this->load->model('Category_model');
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
					$subcategory2 = $this->Category_model->get_sub_category2($subcategory->id);
					foreach($subcategory2 as $subcat2)
					{
						print_r($subcat2);				
						$update['category3'] = $subcat2->id;
						$where ['category1'] = $subcat2->pid;
						$where ['category2'] = $subcat2->pid2;
						$where ['category3'] = $subcat2->name;
						print_r($where);
						print_r($update);
						//$this->Products_model->update_where($update, $where);
						echo "<hr>";
					}
				}
			}
		}
		echo "</pre>";	*/
	}
}
