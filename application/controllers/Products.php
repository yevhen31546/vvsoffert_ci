<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function index()
	{	
		
		$this->load->model('Groups_model');	
		$this->load->model('Category_model');
		$this->load->model('Products_model');
		$this->load->model('Manufacturer_model');
		
		$this->load->helper('form');
		
		$this->data['currentCategory'] = 0;
		$this->data['currentManu'] = 0;
		$this->data['currentSub2'] = 0;
		$manu[''] = 'Select';	
		
		$per_page = 99;	
		$cid = $this->input->get('cno');	
		$subcat1 = $this->input->get('c2no');
		$subcat2 = $this->input->get('c3no');
		$string = $this->input->get('search');	
		if(!empty($string))
		{
			$search['text'] = urldecode($string);
			$this->data['text'] = $string;
		}
		$manuId = $this->input->get('tillverkare');
		if(!empty($manuId))
		{
			$search['Manufacturer'] = urldecode($manuId);
			$this->data['currentManu'] = urldecode($manuId);
		}
		
		
				
		// Get All Categories
		$categories = $this->Category_model->get_main_category();
		$this->data['categoryList'] = $categories;	
		if(!empty($categories))
		{
			$treeData = '';
			foreach($categories as $category)
			{
				$expand1 = false;
				$expand2 = false;
				$expand3 = false;
				if(isset($tempData['state']))
				{
					unset($tempData['state']);				
				}
				$tempData['text'] = $category->name;
				$tempData['href'] = site_url('Products?cno='.$category->id);
				
				$subcategories = $this->Category_model->get_sub_category1($category->id);	
				if(!empty($subcategories))
				{
					foreach($subcategories as $sub_category)
					{
						if(isset($tempData2['state']))
						{
							unset($tempData2['state']);				
						}
						$tempData2['text'] = $sub_category->name;
						$tempData2['href'] = site_url('Products?c2no='.$sub_category->id);														
						
						$subcategories2 = $this->Category_model->get_sub_category2($sub_category->id);
						if(!empty($subcategories2))
						{
							foreach($subcategories2 as $sub_category2)
							{
								if(isset($tempData3['state']))
								{
									unset($tempData3['state']);				
								}
								$tempData3['text'] = $sub_category2->name;
								$tempData3['href'] = site_url('Products?c3no='.$sub_category2->id);
								
								if($sub_category2->id==$subcat2)
								{						
									$state['checked'] = true;
									$state['disabled'] = false;
									$state['expanded'] = true;
									$state['selected'] = true;
									
									$tempData3['state'] = $state;
									$expand2 = true;				
								}
								$nodeData3[] = $tempData3;
							}
							$tempData2['nodes'] = $nodeData3;
							unset($nodeData3);
						}
						if($sub_category->id==$subcat1 || $expand2==true)
						{						
							$state['checked'] = true;
							$state['disabled'] = false;
							$state['expanded'] = true;
							$state['selected'] = true;
							
							$tempData2['state'] = $state;
							$expand1 = true;	
							$expand2 = false;			
						}
						$nodeData[] = $tempData2;
					}
					if($category->id==$cid || $expand1==true)
					{
						$state['checked'] = true;
						$state['disabled'] = false;
						$state['expanded'] = true;
						$state['selected'] = true;
						
						$tempData['state'] = $state;	
						$expant1 = false;			
					}
					$tempData['nodes'] = $nodeData;
					unset($nodeData);
				}				
				$treeData[] = $tempData;					
			}
			/*echo "<pre>";
			print_r($treeData);
			echo "</pre>";
			echo json_encode($treeData);
			die();*/
			$this->data['categoryData'] = json_encode($treeData);		
		}
		
		
		if(!empty($cid))
		{		
			$this->data['currentCategory'] = $cid;		
			$search['category1'] = $cid;
			
			if(!empty($subcat1))
				$search['category2'] = $subcat1;
					
			$total_rows = $this->Products_model->get_total($search);		
			
			if(isset($_GET['per_page']) and intval($_GET['per_page'])>0)
			{	
				$start = max(0, ( $_GET['per_page'] -1 ) * $per_page);		
				$products = $this->Products_model->get_products($search, $start);		
				$this->data['productsList'] = $products;	
			}
			else
			{
				$products = $this->Products_model->get_products($search);		
				$this->data['productsList'] = $products;	
			}	
		}
		else if(!empty($subcat1))
		{		
			$this->data['currentCategory2'] = $subcat1;		
			$search['category2'] = $subcat1;				
			$total_rows = $this->Products_model->get_total($search);		
			
			if(isset($_GET['per_page']) and intval($_GET['per_page'])>0)
			{	
				$start = max(0, ( $_GET['per_page'] -1 ) * $per_page);		
				$products = $this->Products_model->get_products($search, $start);		
				$this->data['productsList'] = $products;	
			}
			else
			{
				$products = $this->Products_model->get_products($search);		
				$this->data['productsList'] = $products;	
			}	
		}
		else if(!empty($subcat2))
		{		
			$this->data['currentCategory3'] = $subcat2;		
			$search['category3'] = $subcat2;				
			$total_rows = $this->Products_model->get_total($search);		
			
			if(isset($_GET['per_page']) and intval($_GET['per_page'])>0)
			{	
				$start = max(0, ( $_GET['per_page'] -1 ) * $per_page);		
				$products = $this->Products_model->get_products($search, $start);		
				$this->data['productsList'] = $products;	
			}
			else
			{
				$products = $this->Products_model->get_products($search);		
				$this->data['productsList'] = $products;	
			}	
		}
		else if(!empty($string))
		{
			$total_rows = $this->Products_model->get_total($search);			
			
			if(isset($_GET['per_page']) and intval($_GET['per_page'])>0)
			{	
				$start = max(0, ( $_GET['per_page'] -1 ) * $per_page);		
				$products = $this->Products_model->get_products($search, $start);		
				$this->data['productsList'] = $products;	
			}
			else
			{
				$products = $this->Products_model->get_products($search);		
				$this->data['productsList'] = $products;	
			}
			
		}
		else if(!empty($manuId))
		{
			$total_rows = $this->Products_model->get_total($search);			
			
			if(isset($_GET['per_page']) and intval($_GET['per_page'])>0)
			{	
				$start = max(0, ( $_GET['per_page'] -1 ) * $per_page);		
				$products = $this->Products_model->get_products($search, $start);		
				$this->data['productsList'] = $products;	
			}
			else
			{
				$products = $this->Products_model->get_products($search);		
				$this->data['productsList'] = $products;	
			}
		}
		else
		{
			$total_rows = $this->Products_model->get_total();
			
			if(isset($_GET['per_page']) and intval($_GET['per_page'])>0)
			{	
				$start = max(0, ( $_GET['per_page'] -1 ) * $per_page);		
				$products = $this->Products_model->get_products('', $start);		
				$this->data['productsList'] = $products;	
			}
			else
			{
				$products = $this->Products_model->get_products();		
				$this->data['productsList'] = $products;	
			}		
		}
		
		// Get All Manufacturers
		if(!isset($search) || empty($search))
		{
			$manufacturers = $this->Manufacturer_model->get_all();
			foreach($manufacturers as $manufacturer)
			{
				$manu[$manufacturer->id] = $manufacturer->name;
			}
			$this->data['manufacturerList'] = $manu;	
		}
		else
		{
			$manufacturers = $this->Products_model->get_manu($search);	
			if(!empty($manufacturers))
			{
				foreach($manufacturers as $manufacturer)
				{
					$manu[$manufacturer->MID] = $manufacturer->Mname;
				}
				$this->data['manufacturerList'] = $manu;	
			}
		}
		
		// Pagination
		$this->load->library('pagination');
		
		$get = $_GET;
		unset($get['per_page']);
		$actionParam = http_build_query($get);
		$this->data['actionParam'] = $actionParam;
		
		$config['base_url'] = site_url('Products');
		$config['base_url'] = $config['base_url'].'?'.http_build_query($get);
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['num_links'] = 3;
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['attributes'] = array('class' => 'page-link');
		
		 $config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		 
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		 
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		 
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="page-item active"><a href="" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';	
		
		$this->pagination->initialize($config);		

		$this->data['total_rows'] = $total_rows;
		$this->data['content'] = $this->load->view('pages/products',$this->data,true);		
			
		$this->load->view('layout',$this->data);
	}
	
	//======================================================================
	// Products Compare
	//======================================================================
	
	public function compare()
	{
		$p1 = $this->input->get('p1');
		$p2 = $this->input->get('p2');
		$p3 = $this->input->get('p3');
		
		if(empty($p1) or empty($p2))
			redirect('Products');
					
		$this->load->model('Products_model');	
				
		if(!empty($p1))
		{
			$product1 = $this->Products_model->get($p1);
			$this->data['productData1'] = $product1;
		}
		
		if(!empty($p2))
		{
			$product2 = $this->Products_model->get($p2);
			$this->data['productData2'] = $product2;
		}
		
		if(!empty($p3))
		{
			$product3 = $this->Products_model->get($p3);
			$this->data['productData3'] = $product3;
		}
		
		$this->data['content'] = $this->load->view('pages/products-compare',$this->data,true);		
			
		$this->load->view('layout',$this->data);
	}
}
