<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {

	public function index()
	{	
		// SELECT groupName FROM products GROUP by groupName ORDER BY groupName ASC
			
		$this->db->select('groupName');
		$this->db->group_by('groupName'); 
		$this->db->order_by('groupName', 'asc'); 
		$query = $this->db->get('products');
		$groups = $query->result();
		
		$config = array(
			'field' => 'slug',
			'title' => 'name',
			'table' => 'groups',
			'id' => 'id',
		);
		$this->load->library('Slug',$config);
		
		$this->load->model('Groups_model');	
		/*foreach($groups as $group)
		{
			$slug = $this->slug->create_uri($group->groupName);		
			$insert['name'] = $group->groupName;
			$insert['slug'] = $slug;
			$this->Groups_model->insert($insert);				
		}*/
		
		$this->load->model('Products_model');	
		/*$groups = $this->Groups_model->get_all();
		foreach($groups as $group)
		{
			$update['groupName'] = $group->id;
			$where ['groupName'] = $group->name;
			$this->Products_model->update_where($update, $where);
		}*/
	}
}
