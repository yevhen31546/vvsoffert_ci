<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculator extends CI_Controller {

	function __construct()
    {
        parent::__construct();       
			
		$this->load->helper('site_helper');	
		$this->load->library('session');
		$this->load->library('form_validation');	
		
		$this->load->model('User_model');
		
		$this->load->model('Plumbing_service_model');
        
        $this->load->model('Plumbing_service_price_model');
		
		$this->lang->load('auth_lang');
		
		allow_if_logged_in();		
				
		$this->data['pageDesc'] = '';
    }
	
	public function index() {

		set_page_title('PLUMBING COST CALCULATOR');	
		$this->data['pageDesc'] = 'Plumbing Services & Pricings';
		
		
		$this->data['all_plumbing_services'] = $this->Plumbing_service_model->get_all_plumbing_services();

        $this->data['all_plumbing_service_prices'] = $this->Plumbing_service_price_model->get_all_plumbing_service_prices();
		
		$data['content'] =  $this->load->view('admin/calculator/calculator', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);

	}

	function add_service() {
    
		set_page_title('PLUMBING COST CALCULATOR');	

		$this->form_validation->set_rules('title','Service Title','required');
		
		if($this->form_validation->run())     
        {   
            $params = array(
				'title' => $this->input->post('title')
            );
            
            $plumbing_service_id = $this->Plumbing_service_model->add_plumbing_service($params);

            $session_message['type'] = 1;
            $session_message['title'] = 'Success!';
            $session_message['content'] = 'Plumbing service has been successfully added.';
            $this->session->set_flashdata('message', $session_message);

            redirect('admin/calculator');
        }
        else
        {
			$data['content'] = $this->load->view('admin/calculator/add-service', $this->data, TRUE);
        	$this->load->view('layouts/admin', $data);
        }
    }




	public function edit_service($id = 0) {

		set_page_title('PLUMBING COST CALCULATOR');	


        if (empty($id)) {
            redirect('admin/calculator');
        }

        $this->data['service'] = $this->Plumbing_service_model->get_plumbing_service((int) $id);

        if (empty($this->data['service'])) {

            redirect('admin/calculator');

        } else {

            $this->form_validation->set_rules('title','Service Title','required');
		
			if($this->form_validation->run())     
	        {   
	            $params = array(
					'title' => $this->input->post('title')
	            );
	            
	            $this->Plumbing_service_model->update_plumbing_service((int) $id, $params);

	            $session_message['type'] = 1;
	            $session_message['title'] = 'Success!';
	            $session_message['content'] = 'Plumbing service has been successfully updated.';
	            $this->session->set_flashdata('message', $session_message);

	            redirect('admin/calculator');
	        }
	        else
	        {
				$data['content'] = $this->load->view('admin/calculator/edit-service', $this->data, TRUE);
	        	$this->load->view('layouts/admin', $data);
	        }
        }

    }


	public function delete_service($id = 0) {

        if (empty($id)) {
            redirect('admin/calculator');
        }

        $service = $this->Plumbing_service_model->get_plumbing_service((int) $id);

        if (empty($service)) {

            redirect('admin/calculator');

        } else {

            $this->Plumbing_service_model->delete_plumbing_service((int) $id);

            $session_message['type'] = 1;
            $session_message['title'] = 'Success!';
            $session_message['content'] = 'Plumbing service has been successfully deleted.';
            $this->session->set_flashdata('message', $session_message);
            
            redirect('admin/calculator');
        }

    }



    function add_price() {

        set_page_title('PLUMBING COST CALCULATOR');

        $this->data['all_plumbing_services'] = $this->Plumbing_service_model->get_all_plumbing_services();

        $this->form_validation->set_rules('psId','Service Title','required');
        $this->form_validation->set_rules('rskNumber','RSK Number','required');
        $this->form_validation->set_rules('jobTitle','Job Title','required');
        $this->form_validation->set_rules('time','Time','required');
        $this->form_validation->set_rules('price','Price','required');
        
        if($this->form_validation->run())     
        {   
            $params = array(
                'psId' => $this->input->post('psId'),
                'rskNumber' => $this->input->post('rskNumber'),
                'jobTitle' => $this->input->post('jobTitle'),
                'jobDescription' => $this->input->post('jobDescription'),
                'time' => $this->input->post('time'),
                'price' => $this->input->post('price')
            );
            
            $plumbing_service_price_id = $this->Plumbing_service_price_model->add_plumbing_service_price($params);

            $session_message['type'] = 1;
            $session_message['title'] = 'Success!';
            $session_message['content'] = 'Plumbing service Price has been successfully added.';
            $this->session->set_flashdata('message', $session_message);

            redirect('admin/calculator');
        }
        else
        {
            $data['content'] = $this->load->view('admin/calculator/add-price', $this->data, TRUE);
            $this->load->view('layouts/admin', $data);
        }

    }

    public function edit_price($id = 0) {

        set_page_title('PLUMBING COST CALCULATOR'); 

        $this->data['all_plumbing_services'] = $this->Plumbing_service_model->get_all_plumbing_services();


        if (empty($id)) {
            redirect('admin/calculator');
        }

        $this->data['service_price'] = $this->Plumbing_service_price_model->get_plumbing_service_price((int) $id);

        if (empty($this->data['service_price'])) {

            redirect('admin/calculator');

        } else {

            $this->form_validation->set_rules('psId','Service Title','required');
            $this->form_validation->set_rules('rskNumber','RSK Number','required');
            $this->form_validation->set_rules('jobTitle','Job Title','required');
            $this->form_validation->set_rules('time','Time','required');
            $this->form_validation->set_rules('price','Price','required');
            
            if($this->form_validation->run())     
            {   
                $params = array(
                    'psId' => $this->input->post('psId'),
                    'rskNumber' => $this->input->post('rskNumber'),
                    'jobTitle' => $this->input->post('jobTitle'),
                    'jobDescription' => $this->input->post('jobDescription'),
                    'time' => $this->input->post('time'),
                    'price' => $this->input->post('price')
                );
                
                $plumbing_service_price_id = $this->Plumbing_service_price_model->update_plumbing_service_price((int) $id, $params);

                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = 'Plumbing service Price has been successfully updated.';
                $this->session->set_flashdata('message', $session_message);

                redirect('admin/calculator');
            }
            else
            {
                $data['content'] = $this->load->view('admin/calculator/edit-price', $this->data, TRUE);
                $this->load->view('layouts/admin', $data);
            }
        }

    }


    public function delete_price($id = 0) {

        if (empty($id)) {
            redirect('admin/calculator');
        }

        $service_price = $this->Plumbing_service_price_model->get_plumbing_service_price((int) $id);

        if (empty($service_price)) {

            redirect('admin/calculator');

        } else {

            $this->Plumbing_service_price_model->delete_plumbing_service_price((int) $id);

            $session_message['type'] = 1;
            $session_message['title'] = 'Success!';
            $session_message['content'] = 'Plumbing service price has been successfully deleted.';
            $this->session->set_flashdata('message', $session_message);
            
            redirect('admin/calculator');
        }

    }


	public function cpst() {

		$this->load->dbforge();

        $fields = array(

            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            )

        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('plumbing_services', TRUE);

	}

    public function cpspt() {

        $this->load->dbforge();

        $fields = array(

            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'psId' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ),
            'rskNumber' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'jobTitle' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'jobDescription' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'time' => array(
                'type' => 'FLOAT',
                'default' => 0
            ),
            'price' => array(
                'type' => 'FLOAT',
                'default' => 0
            )

        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('plumbing_service_prices', TRUE);

    }

	
}
