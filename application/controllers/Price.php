<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Price extends CI_Controller {

	function __construct() {

        parent::__construct();

    }

    function index()
    {

    	$this->data = array();
        $this->data['content'] = $this->load->view('pages/price-table', $this->data, true);
        $this->load->view('layout', $this->data);
        
    }
} 