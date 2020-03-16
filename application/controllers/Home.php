<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{	
		// Load Model
		$this->load->model('Groups_model');
		$this->load->model('Category_model');
		$this->load->model('Products_model');
		
		$this->load->helper('form');	
		
		// Load Groups	
		$this->load->model('Groups_model');
		$groups = $this->Groups_model->get_home_groups();	
		$this->data['groupsList'] = $groups;
		if(!empty($groups))
		{
			
			foreach($groups as $group)
			{
				$categories[$group->id] = $this->Category_model->get_by_group($group->id);
			}
			if(isset($categories))
				$this->data['categories'] = $categories;
				
			foreach($groups as $group)
			{			
				$groupPdt[$group->id] = $this->Products_model->group_product($group->id);					
			}
			if(isset($groupPdt))
				$this->data['groupPdtList'] = $groupPdt;		
		}
		
		
		$products = $this->Products_model->random();	
		$this->data['productsList'] = $products;	
		
		$this->data['content'] = $this->load->view('pages/home',$this->data,true);	
		$this->load->view('layout',$this->data);
	}
}
