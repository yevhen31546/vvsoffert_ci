<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Errors extends CI_Controller {

    function __construct() {

        parent::__construct();

    }


	function error_404() {

		$this->output->set_status_header('404');
    	$this->data["heading"] = "404 Page Not Found.";
    	$this->data["message"] = "The page you are looking for was not found.";


        $this->load->view('errors/error_template', $this->data);


	}


}



?>