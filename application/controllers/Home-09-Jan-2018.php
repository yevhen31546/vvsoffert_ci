<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('custom_functions_helper');
        $this->load->model('FrontendUser_model');
        $this->load->model('Groups_model');
        $this->load->model('Category_model');
        $this->load->model('Products_model');
    }

    public function searchProductAjax() {
        // process posted form data  
        $keyword = $this->input->post('term');
        $data['response'] = false; //Set default response  
        $query = lookupProduct($keyword); //Search DB  
        $data['response'] = true;
            $html_product = '<ul class="product-results"><h4 class="stl-head"><font style="vertical-align: inherit;"><font style="vertical-align: inherit; font-weight: 600;">Produkter</font></font></h4>';
        if (!empty($query)) {
            $data['response'] = true; //Set response  
            $data['message'] = array(); //Create array  
            foreach ($query as $row) {
                $img_src=(file_exists($row->ImageName)) ? $row->ImageName : 'http://www.vvsoffert.se/scraper/' . $row->ImageName;
                $html_product .= '<li>' .
                                    '<a href="' . site_url() . 'product?pname=' . $row->Name . '&no=' . $row->id . '" class="">' .
                                    '<img src="' . $img_src . '" alt="">' .
                                    '<p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' . $row->Name . '</font></font></p>' .
                                    '</a>' .
                                '</li>';
            }
        }else{
            $html_product .= '<li>No Data</li>';
        }
            $html_product .= '</ul>';
            $data['html_product'] = $html_product;
        $query_category = lookupCategory($keyword); //Search DB  
            $html_category = '<ul class="category-results"><h4 class="stl-head"><font style="vertical-align: inherit;"><font style="vertical-align: inherit; font-weight: 600;">Kategorier</font></font></h4>';
        if (!empty($query_category)) {
            $data['response'] = true; //Set response   
            foreach ($query_category as $row) {
                $url='javascript:;';
                if($row->pid!='' && $row->pid2!=''){
                    //c3no
                    $url=site_url().'Products?c3no='.$row->id;
                }else if($row->pid!='' && $row->pid2==''){
                   //c2no 
                    $url=site_url().'Products?c2no='.$row->id;
                }else if($row->pid=='' && $row->pid2==''){
                    //cno
                    $url=site_url().'Products?cno='.$row->id;
                }
//                <span class="parent-name"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Underfloor heating system&gt; </font></font></span>
                $html_category .= '<li>'.
                '<a href="'.$url.'" class=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'.$row->name.'</font></font></a>'.
            '</li>';
            }
        }else{
            $html_category.='<li>No Data</li>';
        }
            $html_category .= '</ul>';
            $data['html_category'] = $html_category;
            
        $query_manufacturer = lookupManufacturer($keyword); //Search DB  
            $html_manufacturer = '<ul class="category-results"><h4 class="stl-head"><font style="vertical-align: inherit;"><font style="vertical-align: inherit; font-weight: 600;">Tillverkare</font></font></h4>';
        if (!empty($query_manufacturer)) {
            $data['response'] = true; //Set response   
            foreach ($query_manufacturer as $row) {
                $count_products=countProductByManufacturer($row->id);
                $url=site_url().'Products?search=&tillverkare='.$row->id;
                $html_manufacturer .= '<li>'.
                '<a href="'.$url.'" class=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'.$row->name.' ( '.$count_products.' Produkter )</font></font></a>'.
            '</li>';
            }
        }else{
            $html_manufacturer.='<li>No Data</li>';
        }
            $html_manufacturer .= '</ul>';
            $data['html_manufacturer'] = $html_manufacturer;
        if ('IS_AJAX') {
            echo json_encode($data); //echo json string if ajax request  
        } else {
            $data['message'][] = array(
                'id' => '',
                'value' => 'No Data Found',
                'imgsrc' => '',
                'category1' => '',
                'manufacturer_name' => '',
                ''
            );  //Add a row to array  
        }
    }

    public function contactus() {
       

        if ($this->input->post('submit')) {


            $this->form_validation->set_rules('name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
            $this->form_validation->set_rules('contact', 'Phone', 'trim|required|regex_match[/^[0-9+.-]*$/]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('message', 'Message', 'trim|required');



            if ($this->form_validation->run() == TRUE) {

                $data['name'] = $this->input->post('name');
                $data['email'] = $this->input->post('email');
                $data['last_name'] = $this->input->post('last_name');
                $data['contact'] = $this->input->post('contact');
                $data['message'] = $this->input->post('message');

               $address = "pinaler@gmail.com";
               // $address = "tamal.majumder@infoway.us";
                $subject = "Kontakta Meddelande mottaget!!";
                $message = $this->load->view('email/contact-us-mail', $data, TRUE);


                $headers = "MIME-Version: 1.0" . "\n";

                $headers .= "Content-type: text/html; charset=iso-8859-1" . "\n";

                $headers .= "Content-transfer-encoding: 8bit" . "\n";

                $headers .= "Date: " . date("r", time()) . "\n";

                $headers .= "X-Priority: 1" . "\n";

                $headers .= "X-MSMail-Priority: High" . "\n";

                $headers .= "X-Mailer: PHP/" . PHP_VERSION . "\n";

                $headers .= "X-MimeOLE: Produced by cardverify.net" . "\n";

               $headers .= "From: " . 'VVSOFFERT' . " <" . 'developer@wsfreelanzer.com' . ">" . "\n";

                $headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER["HTTP_HOST"] . ">" . "\n";

                try {
                    @mail($address, $subject, $message, $headers);
                    $session_message['type'] = 1;
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = 'Tack för att du kontaktade oss. Vi kommer snart tillbaka';
                    $this->session->set_flashdata('message', $session_message);
                } catch (Exception $e) {
                    $session_message['type'] = 1;
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = $e->getMessage();
                    $this->session->set_flashdata('message', $session_message);
                }
            }
//            }
        }

        $this->data['productsList'] = "TERMS and condition";
        $this->data['content'] = $this->load->view('pages/contact', $this->data, true);
        $this->load->view('layout', $this->data);
    }
    
      public function terms() {
       $this->load->model('Cms_model');
       $cmsInfo = $this->Cms_model->find('terms_and_conditions');
       $this->data['cmsInfo'] = $cmsInfo;
       $this->data['productsList'] = "TERMS and condition";
       $this->data['content'] = $this->load->view('pages/terms', $this->data, true);
       $this->load->view('layout', $this->data);
    }
    public function lookup() {
        // process posted form data  
        $keyword = $this->input->post('term');
        $data['response'] = 'false'; //Set default response  
        $query = lookup($keyword); //Search DB  
        if (!empty($query)) {
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach ($query as $row) {
                $data['message'][] = array(
                    'id' => $row->id,
                    'value' => $row->Name,
                    'imgsrc' => (file_exists($row->ImageName)) ? $row->ImageName : 'http://www.vvsoffert.se/scraper/' . $row->ImageName,
                    'category1' => $row->category1,
                    'manufacturer_name' => $row->manufacturer_name,
                    ''
                );  //Add a row to array  
            }
        }
        if ('IS_AJAX') {
            echo json_encode($data); //echo json string if ajax request  
        } else {
            $data['message'][] = array(
                'id' => '',
                'value' => 'No Data Found',
                'imgsrc' => '',
                'category1' => '',
                'manufacturer_name' => '',
                ''
            );  //Add a row to array  
        }
    }

    public function index() {
        // Load Model
//            $this->load->library('auth', array('user_type' => 2));
        $this->load->model('Groups_model');
        $this->load->model('Category_model');
        $this->load->model('Products_model');

        $this->load->helper('form');

        // Load Groups	
        $this->load->model('Groups_model');
        $groups = $this->Groups_model->get_home_groups();
        $this->data['groupsList'] = $groups;
        if (!empty($groups)) {

            foreach ($groups as $group) {
                $categories[$group->id] = $this->Category_model->get_by_group($group->id);
            }
            if (isset($categories))
                $this->data['categories'] = $categories;

            foreach ($groups as $group) {
                $groupPdt[$group->id] = $this->Products_model->group_product($group->id);
            }
            if (isset($groupPdt))
                $this->data['groupPdtList'] = $groupPdt;
        }


        $products = $this->Products_model->random();
        $this->data['productsList'] = $products;
        $this->data['content'] = $this->load->view('pages/home', $this->data, true);
        $this->load->view('layout', $this->data);
    }

    public function language_section() {
        $this->load->view("check-language");
    }

    function signup() {
        if ($this->session->userdata('is_valid')) {
            redirect(site_url('dashboard'));
            exit;
        }

        $products = $this->Products_model->random();
        $this->data['productsList'] = $products;
        $this->data['content'] = $this->load->view('pages/signup', $this->data, true);
        $this->load->view('layout', $this->data);
    }

    public function dosignup() {
        $this->load->model('FrontendUser_model');
        if ($this->input->is_ajax_request()) {
            $error = [];

            $this->load->library('form_validation');
            if (!isset($_POST['terms_conditions'])) {
                $this->form_validation->set_rules('terms_conditions', 'Terms and Conditions', 'trim|required');
            }

            $this->form_validation->set_rules('name', 'Förnamn', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Efternamn', 'trim|required');
            $this->form_validation->set_rules('contact', 'Telefon', 'trim|regex_match[/^[0-9+.-]*$/]');
            $this->form_validation->set_rules('email', 'E-post', 'trim|required|valid_email|is_unique[user_master.email]');
            $this->form_validation->set_rules('password', 'Lösenord', 'required|min_length[6]|max_length[12]|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Bekräfta lösenord', 'trim|required');
            $this->form_validation->set_rules('org_no', 'Organisation siffra', 'trim|required');
            $this->form_validation->set_rules('company_name', 'Företag name', 'trim|required');
            $this->form_validation->set_message('is_unique', 'Fältet %s är redan taget!');
            $this->form_validation->set_message('required', 'Detta %s fält är obligatoriskt!');

            if ($this->form_validation->run() == true) {

                $email = set_value('email');
                $FName = set_value('name');
                $SName = set_value('last_name');
                $Phone = set_value('contact');
                $orgno = set_value('org_no');
                $company = set_value('company_name');
                $password = $_POST['password'];
                $ActivationCode = generate_activation_code($email);
                $UserId = pk();

                $value = $FName . "-" . $SName;
//                    $value = $this->all_function->get_value($value);
//                    $slug = $this->all_function->get_user_slug($value);

                $user_master_data = array(
//                        'Slug' => $slug,
                    'name' => $FName,
                    'last_name' => $SName,
                    'contact' => $Phone,
                    'email' => $email,
                    'password' => md5($password),
                    'org_no' => $orgno,
                    'company_name' => $company,
                    'activation_code' => $ActivationCode,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => '0000-00-00 00:00:00',
                    'status' => '1',
                );


                $this->FrontendUser_model->insert($user_master_data);


//                    Events::trigger('new_user_registration_success', $user_master_data);


                $this->ajax_response['type'] = 'success';
                $this->ajax_response['message'] = 'You have successfully sign up successfully.You can login now.';
                $this->ajax_response['url'] = site_url('login');

//                    $this->ajax_response['message'] = "We've just sent a confirmation link to <strong>$email</strong>. Just click the link in that email & you're in!";
            } else {
                $this->ajax_response['type'] = 'warning';
                $error = [];

                foreach ($this->form_validation->error_array() as $key => $val) {
                    $error[$key] = $val;
                }

                $this->ajax_response['message'] = $error;
            }
        }
        echo json_encode($this->ajax_response);
    }

    public function dosignup11() {

        if (IS_AJAX) {
            if (!$this->auth->is_login()) {
                $this->form_validation->set_rules('FName', 'First Name', 'trim|required');
                $this->form_validation->set_rules('SName', 'Last name', 'trim|required');
                $this->form_validation->set_rules('EmailId', 'Email', 'trim|required|valid_email|is_unique_email');
                $this->form_validation->set_rules('Phone', 'Phone', 'trim|regex_match[/^[0-9+.-]*$/]');
                $this->form_validation->set_rules('Password', 'Password', 'required|min_length[6]|max_length[12]|matches[ConfirmPassword]');
                $this->form_validation->set_rules('ConfirmPassword', 'Confirm password', 'trim|required');
                if ($this->form_validation->run() == true) {

                    $email = set_value('EmailId');
                    $password = set_value('password');
                    $FName = set_value('FName');
                    $SName = set_value('SName');
                    $Phone = set_value('Phone');
                    $password = $_POST['Password'];
                    $ActivationCode = generate_activation_code($email);
                    $UserId = pk();

                    $value = $FName . "-" . $SName;
                    $value = $this->all_function->get_value($value);
                    $slug = $this->all_function->get_user_slug($value);

                    $user_master_data = array(
                        'UserTypeId' => '3',
                        'EmailId' => $email,
                        'Slug' => $slug,
                        'Password' => md5($password),
                        'FName' => $FName,
                        'SName' => $SName,
                        'Phone' => $Phone,
                        'Sex' => '6',
                        'AboutMe' => '',
                        'ProfileImage' => '',
                        'CustomerType' => 'customer',
                        'ActivationCode' => $ActivationCode,
                        //'AddedDate' => date('Y-m-d H:i:s'),
                        'AddedDate' => date('Y-m-d H:i:s'),
                        'UpdatedDate' => '0000-00-00 00:00:00',
                        'Status' => '0',
                    );


                    $this->auth_model->insert_into_user_master($user_master_data);


                    Events::trigger('new_user_registration_success', $user_master_data);


                    $this->ajax_response['type'] = 'success';

                    $this->ajax_response['message'] = "We've just sent a confirmation link to <strong>$email</strong>. Just click the link in that email & you're in!";
                } else {
                    $this->ajax_response['type'] = 'warning';
                    $error = [];

                    foreach ($this->form_validation->error_array() as $key => $val) {
                        $error[$key] = $val;
                    }

                    $this->ajax_response['message'] = $error;
                }
            }
        }
        $this->render_ajax_response();
    }

}
