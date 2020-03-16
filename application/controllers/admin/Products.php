<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();       
			
		$this->load->helper('site_helper');
		$this->load->helper('form');
		
		$this->load->library('session');
		
		$this->load->model('Groups_model');	
		$this->load->model('Category_model');
		$this->load->model('Products_model');
		$this->load->model('Manufacturer_model');	
		$this->load->model('ProductTypes_model');
				
		allow_if_logged_in();		
				
		$this->data['pageDesc'] = '';
    }

	public function index()
	{	
		set_page_title('Categories');
				
		$this->load->helper('form');	
		$manu[''] = 'Select';	
		
		$per_page = 99;	
		$total_rows = $this->Products_model->get_total();
			
		if(isset($_GET['per_page']) and intval($_GET['per_page'])>0)
		{	
			$start = max(0, ( $_GET['per_page'] -1 ) * $per_page);		
			$products = $this->Products_model->get_products('', $start);		
			$this->data['productsList'] = $products;	
			$this->data['slno'] = $start+1;
		}
		else
		{
			$products = $this->Products_model->get_products();		
			$this->data['productsList'] = $products;	
			$this->data['slno'] = 1;	
		}
		
		// Pagination
		$this->load->library('pagination');
		
		$get = $_GET;
		unset($get['per_page']);
		$actionParam = http_build_query($get);
		$this->data['actionParam'] = $actionParam;
		
		$config['base_url'] = site_url('admin/products');
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
		$this->data['content'] = $this->load->view('admin/products',$this->data,true);		
			
		$this->load->view('layouts/admin',$this->data);
	}
	
	
	// Edit Product Information
	public function edit($id=0)
	{	
		if($id==0)
			redirect('admin/products');
		
		$productInformation = $this->Products_model->get($id);
		if(empty($productInformation))
			redirect('admin/products');
		$this->data['productInfo'] = $productInformation;
		
		set_page_title('Product Information');
		
		// Get All Groups
		$temp[''] = 'Select';
		$groups = $this->Groups_model->get_all();
		foreach($groups as $group)
		{
			$temp[$group->id] = $group->name;
		}
		$this->data['groups'] = $temp;
		
		// Get All Product Types
		$productTypes = $this->ProductTypes_model->get_all(0,false);	
		$string = '';
		foreach($productTypes as $pType)
		{
			$string .= '"'.addslashes(trim($pType->name)).'", ';
		}	
		$this->data['productTypes'] = $string;
		$productTypeInfo = $this->ProductTypes_model->get($productInformation->ProductType);
		$this->data['productTypeInfo'] = $productTypeInfo;
		
		// Get all manufacturers
		$Manufacturer = $this->Manufacturer_model->get_all();
		$string = '';
		foreach($Manufacturer as $manu)
		{
			$string .= '"'.$manu->name.'", ';
		}
		$this->data['ManuArray'] = $string;
		
		// Get Current Manufacturer Info
		$this->data['Manufacturer'] = $Manufacturer;
		$ManufacturerInfo = $this->Manufacturer_model->get($productInformation->Manufacturer);
		$this->data['ManufacturerInfo'] = $ManufacturerInfo;
		
		// Get Parent Categories
		$categories = $this->Category_model->get_main_category();
		$mainCategory[''] = 'Select';
		if(!empty($categories))
		{
			foreach($categories as $category)
			{			
				$mainCategory[$category->id] = $category->name;
			}		
			$this->data['mainCategory'] = $mainCategory;
		}
		
		// Get Category 2
		$subCategory[''] = 'Select';
		if($productInformation->category1>0)
		{
			$categories2 = $this->Category_model->get_sub_category1($productInformation->category1);
			if(!empty($categories2))
			{
				foreach($categories2 as $category)
				{			
					$subCategory[$category->id] = $category->name;
				}		
				$this->data['subCategory'] = $subCategory;
			}
		}
		
		// Get Category 3
		$subCategory2[''] = 'Select';
		if($productInformation->category2>0)
		{
			$categories3 = $this->Category_model->get_sub_category2($productInformation->category2);
			if(!empty($categories3))
			{
				foreach($categories3 as $category)
				{			
					$subCategory2[$category->id] = $category->name;
				}		
				$this->data['subCategory2'] = $subCategory2;
			}
		}
		
		// Delete Product
		if($this->input->post('delete'))
		{
			$delete = set_value('delete');
			if($delete=="delete")
			{
				$this->Products_model->delete($productInformation->id);
				$session_message['type'] = 1;
				$session_message['title'] = 'Success!';
				$session_message['content'] = 'Product has been successfully deleted.';
				$this->session->set_flashdata('message', $session_message);
				redirect('admin/products/');
			}
		}
		// Save Product Details
		if($this->input->post('submit'))
		{
			$submit = set_value('submit');
			if($submit=="save")
			{			
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('Name', 'Name', 'trim|required|max_length[250]');
				$this->form_validation->set_rules('groupName', 'Group', 'trim|required|max_length[250]');
				$this->form_validation->set_rules('category1', 'Category1', 'trim|required|max_length[250]');
				$this->form_validation->set_rules('category2', 'Category2', 'trim|max_length[250]');
				$this->form_validation->set_rules('category3', 'Category3', 'trim|max_length[250]');
				$this->form_validation->set_rules('Manufacturer', 'Manufacturer', 'trim|required|max_length[250]');	
				$this->form_validation->set_rules('ProductType', 'ProductType', 'trim|required|max_length[250]');		
				$this->form_validation->set_rules('ProductId', 'ProductId', 'trim|required|max_length[11]');
				$this->form_validation->set_rules('Unit', 'Unit', 'trim|max_length[250]');
				$this->form_validation->set_rules('RSKnummer0', 'RSKnummer0', 'trim|required');	
				$this->form_validation->set_rules('Tillverkarensartikelnummer0', 'Tillverkarensartikelnummer0', 'trim|max_length[250]');
				$this->form_validation->set_rules('RSKnummer', 'RSKnummer', 'trim|required|max_length[250]|max_length[250]');
				$this->form_validation->set_rules('Tillverkarensartikelnummer', 'Tillverkarensartikelnummer', 'trim|max_length[250]');
				$this->form_validation->set_rules('GTIN', 'GTIN', 'trim');			
				$this->form_validation->set_rules('Produkt', 'Produkt', 'trim');
				$this->form_validation->set_rules('Produktnamn', 'Produktnamn', 'trim');
				$this->form_validation->set_rules('Dimension', 'Dimension', 'trim');
				$this->form_validation->set_rules('Storlek', 'Storlek', 'trim');
				$this->form_validation->set_rules('TryckFlodeTemp', 'TryckFlodeTemp', 'trim');
				$this->form_validation->set_rules('EffektEldata', 'EffektEldata', 'trim');
				$this->form_validation->set_rules('Funktion', 'Funktion', 'trim');
				$this->form_validation->set_rules('Utforande', 'Utforande', 'trim');
				$this->form_validation->set_rules('Farg', 'Farg', 'trim');
				$this->form_validation->set_rules('Ytbehandling', 'Ytbehandling', 'trim');
				$this->form_validation->set_rules('Material', 'Material', 'trim');
				$this->form_validation->set_rules('Standard', 'Standard', 'trim');
				$this->form_validation->set_rules('Ovriginfo', 'Ovriginfo', 'trim');
				$this->form_validation->set_rules('EgenbenamningSvensk', 'EgenbenamningSvensk', 'trim');
				$this->form_validation->set_rules('Varumarke', 'Varumarke', 'trim');
				$this->form_validation->set_rules('Tillverkarensproduktsida', 'Tillverkarensproduktsida', 'trim');
				
				$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
				$this->form_validation->set_message('required','Required.');
				$this->form_validation->set_message('matches','The %s does not match the %s.');
				$this->form_validation->set_message('min_length','The %s must be at least %s characters in length..');
				$this->form_validation->set_message('max_length','The %s cannot exceed %s characters in length.');
				
				if ($this->form_validation->run() == TRUE)
				{				
					$manuText = set_value('Manufacturer');
					$search['name'] = $manuText;
					$Manufacturer = $this->Manufacturer_model->search($search);
					if(isset($Manufacturer->id))
					{
						$update['Manufacturer'] = $Manufacturer->id;
					}
					
					$ptypeText = set_value('ProductType');
					$search['name'] = $ptypeText;
					$ProductType = $this->ProductTypes_model->search($search);
					if(isset($ProductType->id))
					{
						$update['ProductType'] = $ProductType->id;
					}
					
					$update['Name'] 							= set_value('Name');
					$update['groupName'] 					= set_value('groupName');
					$update['category1'] 					= set_value('category1');
					$update['category2'] 					= set_value('category2');
					$update['category3'] 					= set_value('category3');
					$update['ProductId'] 					= set_value('ProductId');
					$update['Unit'] 							= set_value('Unit');
					$update['RSKnummer0'] 					= set_value('RSKnummer0');
					$update['Tillverkarensartikelnummer0'] 	= set_value('Tillverkarensartikelnummer0');
					$update['RSKnummer'] 					= set_value('RSKnummer');
					$update['Tillverkarensartikelnummer'] 	= set_value('Tillverkarensartikelnummer');
					$update['GTIN'] 							= set_value('GTIN');
					$update['Produkt'] 						= set_value('Produkt');
					$update['Produktnamn'] 					= set_value('Produktnamn');
					$update['Dimension'] 					= set_value('Dimension');
					$update['Storlek'] 						= set_value('Storlek');
					$update['TryckFlodeTemp'] 				= set_value('TryckFlodeTemp');
					$update['EffektEldata'] 					= set_value('EffektEldata');
					$update['Funktion'] 						= set_value('Funktion');
					$update['Utforande'] 					= set_value('Utforande');
					$update['Farg'] 							= set_value('Farg');
					$update['Ytbehandling'] 					= set_value('Ytbehandling');
					$update['Material'] 						= set_value('Material');
					$update['Standard'] 						= set_value('Standard');
					$update['Ovriginfo'] 					= set_value('Ovriginfo');
					$update['EgenbenamningSvensk'] 			= set_value('EgenbenamningSvensk');
					$update['Varumarke'] 					= set_value('Varumarke');
					$update['Tillverkarensproduktsida'] 		= set_value('Tillverkarensproduktsida');
					
					$this->Products_model->update($update, $productInformation->id);
					$session_message['type'] = 1;
					$session_message['title'] = 'Success!';
					$session_message['content'] = 'Product details has been successfully saved.';
					$this->session->set_flashdata('message', $session_message);
					redirect('admin/products/edit/'.$productInformation->id);				
				}
			}
		}
		
		$this->data['content'] = $this->load->view('admin/product-edit',$this->data,true);		
		$this->load->view('layouts/admin',$this->data);	
	}
}
