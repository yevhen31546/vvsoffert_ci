<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct()
    {
        parent::__construct();       
			
		$this->load->helper('site_helper');	
		$this->load->library('session');
		$this->load->library('form_validation');	
		
		$this->load->model('User_model');	
		
		$this->lang->load('auth_lang');
		
		allow_if_logged_in();		
				
		$this->data['pageDesc'] = '';
    }
	
	public function index()
	{		
		set_page_title('Admin Profile');	
		$this->data['pageDesc'] = 'Your Website Details';
		
		$userInfo = $this->session->userdata('user');	
		$userInfo = $this->User_model->get_by_id($userInfo['id']);
		$this->data['userInfo'] = $userInfo;
		
		if($this->input->post('submit'))
		{
			$submit = $this->input->post('submit');
			if($submit=="save")
			{
				$this->form_validation->set_rules('sitename', 'Website name', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|required');	
				$this->form_validation->set_rules('username', 'Username', 'trim|required');	
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				$this->form_validation->set_rules('copyrights', 'Copyrights', 'trim|required|max_length[250]');	
				
				$npassword = $this->input->post('npassword');
				if(!empty($npassword))
				{
					$this->form_validation->set_rules('npassword', 'New Password', 'trim|required|min_length[8]|max_length[15]|valid_password');
					$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[npassword]');
				}
				
				$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
				$this->form_validation->set_message('required','Required.');
				$this->form_validation->set_message('matches','The %s does not match the %s.');
				$this->form_validation->set_message('min_length','The %s must be at least %s characters in length.');
				$this->form_validation->set_message('max_length','The %s cannot exceed %s characters in length.');
				
				if ($this->form_validation->run() == TRUE)
				{
					$this->load->library('password');
					$pwd = $this->input->post('password');
					if($this->password->validate_password($pwd, $userInfo->password))
					{
						$update['sitename'] = $this->input->post('sitename');
						$update['email'] = $this->input->post('email');
						$update['username'] = $this->input->post('username');
						$update['copyrights'] = $this->input->post('copyrights');
						
						$cpassword = $this->input->post('cpassword');
						if($cpassword==$npassword)
							$update['password'] = $this->_encrypt_password($this->input->post('cpassword',TRUE));
											
						$this->User_model->update($userInfo->id,$update);										
							
						$session_message['type'] = 1;
						$session_message['title'] = 'Success!';
						$session_message['content'] = 'Your details has been successfully saved.';
						$this->session->set_flashdata('message', $session_message);
						redirect('admin/profile');					
					}
					else
					{
						$session_message['type'] = 2;
						$session_message['title'] = 'Invalid Password';
						$session_message['content'] = 'You must submit current password to save the details.';
						$this->session->set_flashdata('message', $session_message);
						redirect('admin/profile');
					}
				}
				else
				{
					
				}
				
			}
		}
		
		$data['content'] =  $this->load->view('admin/profile', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
	}
	
	// Encrypt user password
	public function _encrypt_password($password)
	{
		$this->load->library('Password');
		$hash = $this->password->create_hash($password);
		return $hash;
	}	
}
