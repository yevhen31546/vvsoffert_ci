<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
    {
        parent::__construct();       
			
		$this->load->helper('site_helper');	
		$this->load->library('session');
		$this->load->library('form_validation');	
		
		$this->load->model('User_model');
		$this->load->model('Groups_model');
		$this->load->model('Category_model');
		$this->load->model('Products_model');
		$this->load->model('Manufacturer_model');
		$this->load->model('ProductTypes_model');	
		
		$this->lang->load('auth_lang');
		
		allow_if_logged_in();		
				
		$this->data['pageDesc'] = '';
    }
	
	public function index()
	{		
		set_page_title('Dashboard');	
		$this->data['pageDesc'] = 'Your Website Summary';
		
		// Total Products 
		$total_products = $this->Products_model->get_total();
		$this->data['total_products'] = $total_products;
		
		// Total Groups
		$total_groups = $this->Groups_model->nor();
		$this->data['total_groups'] = $total_groups;
		
		// Total Categories
		$total_categories = $this->Category_model->nor();
		$this->data['total_categories'] = $total_categories;
		
		// Total Manufacturer
		$total_manufacturer = $this->Category_model->nor();
		$this->data['total_manufacturer'] = $total_manufacturer;
		
		// Total Product Types
		$total_ptypes = $this->ProductTypes_model->nor();
		$this->data['total_ptypes'] = $total_ptypes;
		
		// Get Groups Products
		$groups  = $this->Groups_model->get_all();
		if(!empty($groups))
		{
			foreach($groups as $group)
			{
				$groupData['name'] = $group->name;
				$search['groupName'] = $group->id;
				
				$groupData['total'] = $this->Products_model->get_total2($search);
				$groupsData[] = $groupData;
			}
			
			if(isset($groupsData))
				$this->data['groupsData'] = $groupsData;
		}
		
		// Get Admin Latest Products
		$recentProducts = $this->Products_model->recent();
		$this->data['recentProducts'] = $recentProducts;	
		
		$data['content'] =  $this->load->view('admin/dashboard', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
	}
}
