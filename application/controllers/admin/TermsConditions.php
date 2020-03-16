<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TermsConditions extends CI_Controller {

	function __construct()
    {
        parent::__construct();       
			
		$this->load->helper('site_helper');	
		$this->load->library('session');
		$this->load->library('form_validation');	
		
		$this->load->model('User_model');	
		$this->load->model('Cms_model');
		
		
		$this->lang->load('auth_lang');
		
		allow_if_logged_in();		
				
		$this->data['pageDesc'] = '';
                
        $this->load->helper('Ckeditor');

        //Ckeditor's configuration
        $this->data['ckeditor'] = array(

                //ID of the textarea that will be replaced
                'id'    =>      'content',
                'path'  =>      'js/ckeditor',

                //Optionnal values
                'config' => array(
                        'toolbar'       =>      "Full",         //Using the Full toolbar
                        'width'         =>      "550px",        //Setting a custom width
                        'height'        =>      '100px',        //Setting a custom height

                ),

                //Replacing styles from the "Styles tool"
                'styles' => array(

                        //Creating a new style named "style 1"
                        'style 1' => array (
                                'name'          =>      'Blue Title',
                                'element'       =>      'h2',
                                'styles' => array(
                                        'color'         =>      'Blue',
                                        'font-weight'   =>      'bold'
                                )
                        ),

                        //Creating a new style named "style 2"
                        'style 2' => array (
                                'name'  =>      'Red Title',
                                'element'       =>      'h2',
                                'styles' => array(
                                        'color'                 =>      'Red',
                                        'font-weight'           =>      'bold',
                                        'text-decoration'       =>      'underline'
                                )
                        )                              
                )
        );

        $this->data['ckeditor_2'] = array(

                //ID of the textarea that will be replaced
                'id'    =>      'content_2',
                'path'  =>      'js/ckeditor',

                //Optionnal values
                'config' => array(
                        'width'         =>      "550px",        //Setting a custom width
                        'height'        =>      '100px',        //Setting a custom height
                        'toolbar'       =>      array(  //Setting a custom toolbar
                                array('Bold', 'Italic'),
                                array('Underline', 'Strike', 'FontSize'),
                                array('Smiley'),
                                '/'
                        )
                ),

                //Replacing styles from the "Styles tool"
                'styles' => array(

                        //Creating a new style named "style 1"
                        'style 3' => array (
                                'name'          =>      'Green Title',
                                'element'       =>      'h3',
                                'styles' => array(
                                        'color'         =>      'Green',
                                        'font-weight'   =>      'bold'
                                )
                        )

                )
        );             
                
                
                
    }
	
	public function index()
	{	
            
            
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');


        $this->ckeditor->basePath = base_url().'assets/ckeditor_bk/';
        $this->ckeditor->config['toolbar'] = array(
                        array( 'Source', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList','JustifyLeft','JustifyCenter','JustifyRight','JustifyFull' )
                                                            );
        $this->ckeditor->config['language'] = 'it';
        $this->ckeditor->config['width'] = '730px';
        $this->ckeditor->config['height'] = '300px';            

        //Add Ckfinder to Ckeditor
        $this->ckfinder->SetupCKEditor($this->ckeditor,'../../assets/ckfinder/'); 
            
            
		set_page_title('Terms & Conditions');	
		$this->data['pageDesc'] = 'Your Website Details';
		
		$cmsInfo = $this->Cms_model->find('terms_and_conditions');
		$this->data['cmsInfo'] = $cmsInfo;
		
		if($this->input->post('submit'))
		{
			$submit = $this->input->post('submit');
			if($submit=="save")
			{
				$this->form_validation->set_rules('content', 'Content', 'trim|required');
                                $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
				if ($this->form_validation->run() == TRUE)
				{
						$update['content'] = $this->input->post('content');					
						$this->Cms_model->update($cmsInfo->id,$update);										
							
						$session_message['type'] = 1;
						$session_message['title'] = 'Success!';
						$session_message['content'] = 'Content has been successfully saved.';
						$this->session->set_flashdata('message', $session_message);
						redirect('admin/TermsConditions');					
				}
				else
				{
					
				}
				
			}
		}
		
		$data['content'] =  $this->load->view('admin/terms_conditions', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
	}
	
		
}
