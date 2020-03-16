<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index()
	{	
		setlocale(LC_ALL, 'hu_HU.UTF8');	

		if(!$this->input->get('no'))
			redirect(site_url());
		
		// Load Model
		$this->load->model('Groups_model');	
		$this->load->model('Products_model');
		
		// Find Product	
		$productId = $this->input->get('no');
		$productData = $this->Products_model->get($productId);
		if(empty($productData))
			redirect(site_url());
		else
			$this->data['productData'] = $productData;			
		
		// Group Data
		$groupData = $this->Groups_model->get($productData->groupName);
		$this->data['groupData'] = $groupData;
		
		// Related Products
		
		$relateProductData = $this->Products_model->related_products($productData->ProductType);
		$this->data['relateProductData'] = $relateProductData;
		
		$this->data['content'] = $this->load->view('pages/product-info',$this->data,true);	
		$this->load->view('layout',$this->data);
	}
}
