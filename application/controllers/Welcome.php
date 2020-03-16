<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		
		
		$output= shell_exec('php index.php pdt index');
		print "<pre>$output</pre>\n";
		
		// rskdatabasen	
		//SELECT CONVERT(SUBSTRING_INDEX(category1,'-',-1),UNSIGNED INTEGER) AS category1 , `category2` FROM `rsk` GROUP BY `category1`, `category2` ORDER BY `category1` ASC
		
		/*
		// Groups - Rör & teknisk armatur - 117825
		$this->db->select('groupName');
		$this->db->group_by('groupName'); 
		$this->db->order_by('groupName', 'asc'); 
		$query = $this->db->get('rsk');
		$groups = $query->result();
		
		$this->load->model('Groups_model');
		$this->load->model('Rsk_model');
		foreach($groups as $group)
		{
			$insert['name'] = $group->groupName;
			$groupId  = $this->Groups_model->insert($insert);
			
			$update['groupName'] = $groupId;
			$where ['groupName'] = $group->groupName;
			$this->Rsk_model->update_where($update, $where);
		}
		*/
		
		/*
		// Manufacturer
		$this->db->select('Manufacturer');
		$this->db->group_by('Manufacturer'); 
		$this->db->order_by('Manufacturer', 'asc'); 
		$query = $this->db->get('rsk');
		$Manufacturers = $query->result();
				
		$this->load->model('Manufacturer_model');
		$this->load->model('Rsk_model');
		foreach($Manufacturers as $Manufacturer)
		{
			print_r($Manufacturer);		
			$insert['name'] = $Manufacturer->Manufacturer;
			$ManufacturerId  = $this->Manufacturer_model->insert($insert);
			
			$update['Manufacturer'] = $ManufacturerId;
			$where ['Manufacturer'] = $Manufacturer->Manufacturer;
			$this->Rsk_model->update_where($update, $where);
		}
		*/
		
		/*
		// Product Type - Tryckrör - 190	
		$this->db->select('ProductType');
		$this->db->group_by('ProductType'); 
		$this->db->order_by('ProductType', 'asc'); 
		$query = $this->db->get('rsk');
		$ProductTypes = $query->result();		
		$this->load->model('ProductTypes_model');
		$this->load->model('Rsk_model');
		echo "<pre>";
		//print_r($ProductTypes);
		foreach($ProductTypes as $ProductType)
		{		
			$insert['name'] = $ProductType->ProductType;
			$ProductTypeId  = $this->ProductTypes_model->insert($insert);
			
			$update['ProductType'] = $ProductTypeId;
			$where ['ProductType'] = $ProductType->ProductType;
			$this->Rsk_model->update_where($update, $where);
		}
		echo "</pre>";
		*/
			
		// Category - Automatik/Styrventiler
		/*$this->db->select('category1');
		$this->db->group_by('category1'); 
		$this->db->order_by('category1', 'asc'); 
		$query = $this->db->get('rsk');
		$categories = $query->result();
		
		$this->load->model('Category_model');
		$this->load->model('Rsk_model');
		foreach($categories as $category)
		{		
			$insert['name'] = $category->category1;
			$categoryId  = $this->Category_model->insert($insert);
			
			$update['category1'] = $categoryId;
			$where ['category1'] = $category->category1;
			$this->Rsk_model->update_where($update, $where);
		}*/
		
		
		/*
		// Category 2
		$sql = "SELECT CONVERT(SUBSTRING_INDEX(category1,'-',-1),UNSIGNED INTEGER) AS category1 , `category2` FROM `rsk` GROUP BY `category1`, `category2` ORDER BY `category1` ASC, Category2 ASC";
		$query = $this->db->query($sql);
		$categories  = $query->result();
		echo "<pre>";	
		$this->load->model('Category_model');
		$this->load->model('Rsk_model');	
		foreach($categories as $category)
		{		
			$insert['name'] = $category->category2;
			$insert['pid'] = $category->category1;				
			$categoryId  = $this->Category_model->insert($insert);
			
			$update['category2'] = $categoryId;
			$where ['category2'] = $category->category2;
			$this->Rsk_model->update_where($update, $where);
		}*/
		
		
		/*
		// Category 3 - 233
		$sql = "SELECT CONVERT(SUBSTRING_INDEX(category1,'-',-1),UNSIGNED INTEGER) AS category1, CONVERT(SUBSTRING_INDEX(category2,'-',-1),UNSIGNED INTEGER) AS category2, category3 FROM `products` GROUP BY `category1`, `category2`, category3 ORDER BY `category1` ASC, Category2 ASC, category3 ASC";
		$query = $this->db->query($sql);
		$categories  = $query->result();
		echo "<pre>";
		//print_r($categories);
			
		$this->load->model('Category_model');
		$this->load->model('Rsk_model');	
		foreach($categories as $category)
		{		
			$insert['name'] = $category->category3;
			$insert['pid'] = $category->category1;
			$insert['pid2'] = $category->category2;				
			$categoryId  = $this->Category_model->insert($insert);
			
			print_r($insert);
			$update['category3'] = $categoryId;
			$where['category3'] = $category->category3;
			$this->Rsk_model->update_where($update, $where);		
		}
		echo "</pre>";
		*/
		
		die();
		$this->load->view('welcome_message');
	}
}
