<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('set_meta_title')){
    function set_meta_title($title='')
    {
       $ci = &get_instance();
	   $ci->data['meta_title'] = $title;
    }
}

if(!function_exists('meta_title')){
	function meta_title($title='')
    {
		$ci = &get_instance();
		echo $ci->data['meta_title']." | ".$ci->config->item('site_name');
	}
}

if(!function_exists('set_page_title')){
    function set_page_title($title='')
    {
       $ci = &get_instance();
	   $ci->data['page_title'] = $title;
    }
}

if(!function_exists('page_title')){
	function page_title($title='')
    {
		$ci = &get_instance();
		echo $ci->data['page_title'];
	}
}

if(!function_exists('show_session_message')){
	function show_session_message($title='')
    {
		$ci = &get_instance();
		if($ci->session->flashdata('message'))
		{
			$message = $ci->session->flashdata('message');			
			$view = $ci->load->view('includes/message',$message,TRUE);
			echo $view;		
		}			
	}
}

// Check If User Logged In
if(!function_exists('allow_if_logged_in')){
	function allow_if_logged_in()
    {
		$ci = &get_instance();
		if(!$ci->session->userdata('user'))
		{
			redirect('admin');
		}			
	}
}

// Check If User Not Logged In
if(!function_exists('allow_not_logged_in')){
	function allow_not_logged_in()
    {
		$ci = &get_instance();
		if($ci->session->userdata('user'))
		{
			redirect('admin/dashboard');
		}			
	}
}



// Get Role
if(!function_exists('get_roles')){
	function get_roles($id)
    {
		$ci = &get_instance();		
		$roles = $ci->config->item('user_roles');
		return $roles[$id];
	}
}

// Encrypt Password
if(!function_exists('encrypt_password')){
	function encrypt_password($password)
    {
		$ci = &get_instance();
		$ci->load->library('Password');
		$hash = $ci->password->create_hash($password);
		return $hash;
	}
}

// Record Not Found
if(!function_exists('record_not_found'))
{
	function record_not_found($url='admin')
	{
		$ci = &get_instance();
		
		$session_message['type'] = 2;
		$session_message['title'] = 'Sorry';
		$session_message['content'] = 'Record Not Found.';
		$ci->session->set_flashdata('message', $session_message);
		redirect(site_url($url));
	}
}

// Record - Create / Updated
if(!function_exists('crud_done'))
{
	function crud_done($name=NULL, $url='admin',$action=1)
	{
		$ci = &get_instance();
		
		$session_message['title'] = 'Done';
		
		if($action==1)
			$session_message['content'] = $name.' successfully created.';
		else if($action==2)
			$session_message['content'] = $name.' successfully updated.';	
		else if($action==3)
			$session_message['content'] = $name.' successfully deleted.';
		else
			$session_message['content'] = '';
			
		$ci->session->set_flashdata('message', $session_message);
		redirect(site_url($url));
	}
}

// Post / NULL
if(!function_exists('get_value'))
{
	function get_value($name)
	{	
		$ci = &get_instance();
		return $ci->input->post($name,TRUE)!=NULL?$ci->input->post($name,TRUE):NULL;	
	}
}			
?>