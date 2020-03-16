<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductTypes extends CI_Controller {

	function __construct()
    {
        parent::__construct();       
			
		$this->load->helper('site_helper');	
		$this->load->library('session');
		$this->load->library('form_validation');	
		
		$this->load->model('User_model');
		$this->load->model('ProductTypes_model');
		$this->load->model('Products_model');	
			
		
		allow_if_logged_in();		
				
		$this->data['pageDesc'] = '';
    }
	
	public function index()
	{		
		set_page_title('Product Types');
			
		$per_page = 50;
			
		// Total Groups
		$total_rows = $this->ProductTypes_model->nor();
		$this->data['total_rows'] = $total_rows;
			
		// Get Groups Products
		if(isset($_GET['per_page']) and intval($_GET['per_page'])>0)
		{	
			$start = max(0, ( $_GET['per_page'] -1 ) * $per_page);		
			$ProductTypes = $this->ProductTypes_model->get_all_with_count($start);		
			$this->data['ProductTypes'] = $ProductTypes;
			$this->data['slno'] = $start+1;	
		}
		else
		{
			$ProductTypes = $this->ProductTypes_model->get_all_with_count();			
			$this->data['ProductTypes'] = $ProductTypes;
			$this->data['slno'] = 1;	
		}
		
		// Pagination
		$this->load->library('pagination');	
		
		$get = $_GET;
		unset($get['per_page']);
		$actionParam = http_build_query($get);
		$this->data['actionParam'] = $actionParam;
		
		$config['base_url'] = site_url('admin/ProductTypes');
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
			
		$data['content'] =  $this->load->view('admin/ProductTypes', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
	}
	
	// Edit Product Types
	public function edit($slug=0)
	{
		if(empty($slug))
		{
			redirect('admin/ProductTypes');
		}
		
		$search['slug'] = $slug;
		$productTypeInfo = $this->ProductTypes_model->search($search);
		if(empty($productTypeInfo))
			redirect('admin/ProductTypes');
			
		$this->data['productTypeInfo'] = $productTypeInfo;
		
		set_page_title('Product Types');
		
		$submit = set_value('submit');
		if($submit=="save")
		{
			$this->load->library('form_validation');			
			$this->form_validation->set_rules('name', 'Group name', 'trim|required|max_length[250]');
			
			$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
			$this->form_validation->set_message('required','Required.');
			$this->form_validation->set_message('matches','The %s does not match the %s.');
			$this->form_validation->set_message('min_length','The %s must be at least %s characters in length..');
			$this->form_validation->set_message('max_length','The %s cannot exceed %s characters in length.');
			
			if ($this->form_validation->run() == TRUE)
			{
				$update['name'] = set_value('name');
						
				$config = array(
					'field' => 'slug',
					'title' => 'name',
					'table' => 'ProductTypes',
					'id' => 'id',
				);
				$this->load->library('Slug',$config);
				$slug = $this->slug->create_uri($update['name'] , $productTypeInfo->id);	
				$update['slug'] = $slug;
				
				$this->ProductTypes_model->update($update,$productTypeInfo->id);
				$session_message['type'] = 1;
				$session_message['title'] = 'Success!';
				$session_message['content'] = 'Product Type has been successfully saved.';
				$this->session->set_flashdata('message', $session_message);
				
				redirect('admin/ProductTypes');
			}
		}
		
		$data['content'] =  $this->load->view('admin/ProductTypes-edit', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
	}
}
