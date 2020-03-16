<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

	function __construct()
    {
        parent::__construct();       
			
		$this->load->helper('site_helper');	
		
		$this->load->library('session');
		
		$this->load->model('User_model');
		$this->load->model('Category_model');
		$this->load->model('Groups_model');
		$this->load->model('Products_model');	
			
		
		allow_if_logged_in();		
				
		$this->data['pageDesc'] = '';
    }
	
	public function index()
	{		
		set_page_title('Categories');
		
		$pid = $this->input->get('pid');
		$pid = intval($pid);
		$this->data['pid'] = $pid;
		
		$pid2 = $this->input->get('pid2');
		$pid2 = intval($pid2);
		$this->data['pid2'] = $pid2;
				
		// Total Categories
		$total_rows = $this->Category_model->get_main_category_nor();	
		$this->data['total_rows'] = $total_rows->totalRows;
			
		// Main Categories
		if($pid==0 and $pid2==0)
		{
			$main_categories = $this->Products_model->category1();
			$this->data['main_categories'] = $main_categories;
			
			$subcategories_count = $this->Category_model->get_sub_category1_nor();
			foreach($subcategories_count as $scount)
			{		
				$subcategory[$scount->pid] = $scount->subcategory;
			}
			$this->data['subcategory'] = $subcategory;
		}
		else if($pid>0 and $pid2==0)
		{
			$parent_category = $this->Category_model->get($pid);
			if(empty($parent_category))
				redirect('admin/categories');
			$this->data['parent_category'] = $parent_category;
			set_page_title('Categories : '.$parent_category->name);
			
			$main_categories = $this->Products_model->category2($pid);
			$this->data['main_categories'] = $main_categories;
				
			$subcategories_count = $this->Category_model->get_sub_category2_nor($pid);
			foreach($subcategories_count as $scount)
			{		
				$subcategory[$scount->pid2] = $scount->subcategory;
			}
			$this->data['subcategory'] = $subcategory;	
				
		}
		else if($pid2>0)
		{
			$parent_category = $this->Category_model->get($pid);
			if(empty($parent_category))
				redirect('admin/categories');
			$this->data['parent_category'] = $parent_category;
			
			$sub_category = $this->Category_model->get($pid2);
			if(empty($sub_category))
				redirect('admin/categories');
			$this->data['sub_category'] = $sub_category;
			
			set_page_title('Categories : '.anchor('admin/categories?pid='.$pid, $parent_category->name). " : ".$sub_category->name);
			
			$main_categories = $this->Products_model->category3($pid, $pid2);		
			$this->data['main_categories'] = $main_categories;
		}
		
		
		$data['content'] =  $this->load->view('admin/categories', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
	}
	
	public function getCategory2()
	{
		$category1 = $this->input->post('category1');
		$category1 = intval($category1);
		if($category1>0)
		{
			$categories2 = $this->Category_model->get_sub_category1($category1);
			if(!empty($categories2))
			{
				foreach($categories2 as $category)
				{			
					$subCategory[$category->id] = $category->name;
				}		
				$output['result']= true;
				$output['categories'] = $subCategory;
			}
		}
		else
		{
			$output['result']= false;
		}
		
		echo json_encode($output);
	}
	
	public function getCategory3()
	{
		$category2 = $this->input->post('category2');
		$category2 = intval($category2);
		if($category2>0)
		{
			$categories3 = $this->Category_model->get_sub_category2($category2);
			if(!empty($categories3))
			{
				foreach($categories3 as $category)
				{			
					$subCategory[$category->id] = $category->name;
				}		
				$output['result']= true;
				$output['categories'] = $subCategory;
			}
		}
		else
		{
			$output['result']= false;
		}
		
		echo json_encode($output);
	}
	
	// Edit Manufacturer
	public function edit($slug=0)
	{
		if(empty($slug))
		{
			redirect('admin/categories');
		}
		
		$search['id'] = $slug;
		$CategoryInfo = $this->Category_model->search($search);
		if(empty($CategoryInfo))
			redirect('admin/categories');
			
		$this->data['CategoryInfo'] = $CategoryInfo;
		
		set_page_title('Categories');
		
		$this->load->library('form_validation');	
		$submit = set_value('submit');
		if($submit=="save")
		{				
			$this->form_validation->set_rules('name', 'Category name', 'trim|required|max_length[250]');
			
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
					'table' => 'categories',
					'id' => 'id',
				);
				$this->load->library('Slug',$config);
				$slug = $this->slug->create_uri($update['name'] , $CategoryInfo->id);	
				$update['slug'] = $slug;
				
				$this->Category_model->update($update,$CategoryInfo->id);
				$session_message['type'] = 1;
				$session_message['title'] = 'Success!';
				$session_message['content'] = 'Categories has been successfully saved.';
				$this->session->set_flashdata('message', $session_message);
				
				redirect(current_url());
			}
		}
		
		$data['content'] =  $this->load->view('admin/category-edit', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
	}
}
