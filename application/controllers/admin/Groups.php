<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CI_Controller {

	function __construct()
    {
        parent::__construct();       
			
		$this->load->helper('site_helper');	
		$this->load->library('session');
		$this->load->library('form_validation');	
		
		$this->load->model('User_model');
		$this->load->model('Groups_model');
		$this->load->model('Products_model');	
			
		
		allow_if_logged_in();		
				
		$this->data['pageDesc'] = '';
    }
	
	public function index()
	{		
		set_page_title('Groups');
			
		// Total Groups
		$total_groups = $this->Groups_model->nor();
		$this->data['total_groups'] = $total_groups;
			
		// Get Groups Products
		$groups  = $this->Groups_model->get_all_with_count();
		$this->data['groupsData'] = $groups;	
			
		$data['content'] =  $this->load->view('admin/groups', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
	}
	
	// Edit Groups
	public function edit($slug=0)
	{
		if(empty($slug))
		{
			redirect('admin/groups');
		}
		
		$search['slug'] = $slug;
		$groupInfo = $this->Groups_model->search($search);
		if(empty($groupInfo))
			redirect('admin/groups');
			
		$this->data['groupInfo'] = $groupInfo;
		
		set_page_title('Groups');
		
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
					'table' => 'groups',
					'id' => 'id',
				);
				$this->load->library('Slug',$config);
				$slug = $this->slug->create_uri($update['name'] , $groupInfo->id);	
				$update['slug'] = $slug;
				
				$this->Groups_model->update($update,$groupInfo->id);
				$session_message['type'] = 1;
				$session_message['title'] = 'Success!';
				$session_message['content'] = 'Group Name has been successfully saved.';
				$this->session->set_flashdata('message', $session_message);
				
				redirect('admin/groups');
			}
		}
		
		$data['content'] =  $this->load->view('admin/group-edit', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
	}
}
