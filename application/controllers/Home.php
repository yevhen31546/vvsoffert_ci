<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('ListMaster_model');
        $this->load->model('Estore_model');
        $this->load->helper('custom_functions_helper');
        $this->load->model('FrontendUser_model');
        $this->load->model('Groups_model');
        $this->load->model('Category_model');
        $this->load->model('Products_model');
        $this->load->model('Invoice_histories_model');
    }

    public function product() {
        setlocale(LC_ALL, 'hu_HU.UTF8');

        $param = $this->uri->segment(2);

        $paramArray = explode('pid-', $param);

        $productId = (int) $paramArray[1];

        //var_dump($param);die();
        $this->load->model('Category_model');

        if (!$productId) {


            redirect(site_url('errors/error_404'));


        }

        // Load Model
        $this->load->model('Groups_model');
        $this->load->model('Products_model');

        // Find Product 
        $productData = $this->Products_model->get($productId);

        if (empty($productData)) {

            redirect(site_url('errors/error_404'));

        } else {

            $this->data['productData'] = $productData;

        }

        // Group Data
        $groupData = $this->Groups_model->get($productData->groupName);
        if ($this->session->userdata('user_id') != '') {
            $otherStore = $this->Estore_model->get_store_pro_by_rsk_order_by_discount_price($productData->RSKnummer);
        } else {
            $otherStore = $this->Estore_model->get_store_pro_by_rsk($productData->RSKnummer);
        }

        $this->data['groupData'] = $groupData;
        // Related Products
        $storesPricedata = $this->ListMaster_model->getProductByRSK($productData->RSKnummer, $this->session->userdata("user_id"));
        if (isset($storesPricedata[0]->price)) {
            $priceArr = unserialize($storesPricedata[0]->price);
            $index = 0;
            foreach ($otherStore as $otherStoreValue) {
                if (isset($priceArr[$otherStoreValue->store_id])) {
                    $otherStore[$index]->discountprice = number_format($priceArr[$otherStoreValue->store_id], 2);
                }
                $index++;
            }
        }

        if ($this->session->userdata('user_id') != '') {

            usort($otherStore, function ($item1, $item2) {
                if ($item1->discountprice == $item2->discountprice) return 0;
                return $item1->discountprice < $item2->discountprice ? -1 : 1;
            });

        }

        if(isset($_POST) && count($_POST) > 0) {


            //echo 'Got In';die();

            /* $this->form_validation->set_rules('message', 'Message', 'trim|required');

             if ($this->form_validation->run() == TRUE) {

             }*/

            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['telefon'] = $this->input->post('telefon');
            $data['subject'] = $this->input->post('subject');
            $data['message'] = $this->input->post('message');
            $data['product_name'] = $this->input->post('product_name');
            $data['product_rsk'] = $this->input->post('product_rsk');
            $data['product_manufacturer'] = $this->input->post('product_manufacturer');


            //$data['productInfo'] = $this->input->post('product_name') . ' [ RSK-NO: ' . $this->input->post('product_rsk') . ' | Tillverkare: ' . $this->input->post('product_manufacturer') . ' ]';
            $data['productInfo'] = $this->input->post('product_name');

            //var_dump($data); die();

            $htmlContent = $this->load->view('email/offer', $data, TRUE);



            $this->email->to('info@vvsoffert.se');
//$this->email->to('nfury112@gmail.com');
            $this->email->from('info@vvsoffert.se','vvsoffert');
            $this->email->subject('Kontrollera Nytt Erbjudande.');
            $this->email->message($htmlContent);

//Send email
            try {
                $this->email->send();
                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = 'Tack för din förfrågan, vi återkommer till Er med en offert.';
                $this->session->set_flashdata('message', $session_message);
            } catch (Exception $e) {
                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = $e->getMessage();
                $this->session->set_flashdata('message', $session_message);
            }


        }



        $this->data['otherStore'] = $otherStore;
        $relateProductData = $this->Products_model->related_products($productData->ProductType);
        $this->data['relateProductData'] = $relateProductData;
        $this->data['user_id'] = $user_id = ($this->session->userdata('user_id') != '') ? $this->session->userdata('user_id') : 0;
        $this->data['all_list'] = $all_list = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));

        $category1 = $this->Category_model->get($productData->category1);
        $category2 = $this->Category_model->get($productData->category2);
        $category3 = $this->Category_model->get($productData->category3);
        $this->data['categories1']=$category1;
        $this->data['categories2']=$category2;
        $this->data['categories3']=$category3;
        //var_dump($category1);exit;

        $this->data['content'] = $this->load->view('pages/product-info', $this->data, true);
        $this->load->view('layout', $this->data);
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
                    '<img src="' . $img_src . '" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">' .
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


                $this->load->library('email');

                //SMTP & mail configuration
                /*$config = array(
                    'protocol'  => 'smtp',
                    'smtp_host' => 'send.one.com',
                    'smtp_port' =>  25,
                    'smtp_user' => 'info@vvsoffert.se',
                    'smtp_pass' => 'Vv$offert@123',
                    'mailtype'  => 'html',
                    'charset'   => 'utf-8'
                );
                $this->email->initialize($config);
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");*/

                //Email content
                $htmlContent = $this->load->view('email/contact-us-mail', $data, TRUE);

                $this->email->to('pinaler@gmail.com');
                //$this->email->to('tamal.majumder@infoway.us');
                $this->email->from('info@vvsoffert.se','vvsoffert');
                $this->email->subject('Kontakta Meddelande mottaget!!');
                $this->email->message($htmlContent);

                //Send email
                try {
                    $this->email->send();
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

    public function nyheter() {
        $this->load->model('Cms_model');
        $cmsInfo = $this->Cms_model->find('nyheter');
        $this->data['cmsInfo'] = $cmsInfo;
        $this->data['content'] = $this->load->view('pages/nyheter', $this->data, true);
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

        // Inquere form submit
        if ($this->input->post('submit')) {

            $category = array(
                '1' => 'Badrumsrenovering',
                '2' => 'Köksrenovering',
                '3' => 'Stambyte',
                '4' => 'Vatten',
                '5' => 'VVS-arbeten / Rördragning',
                '6' => 'Värmepumpar'
            );

            $timespan = array(
                '1' => 'Klart inom en vecka',
                '2' => 'Klart inom en månad',
                '3' => 'Klart inom 3 månader',
                '4' => 'Klart inom ett halvår',
                '5' => 'Klart inom ett år'
            );

            $buyertype = array(
                '1' => 'Privatperson',
                '2' => 'Företag',
                '3' => 'Entreprenör/Byggare',
                '4' => 'Bostadsrättsförening',
                '5' => 'Annan förening',
                '6' => 'Myndighet/Kommun'
            );

            $this->form_validation->set_rules('quote_description', 'description', 'trim|required');
            $this->form_validation->set_rules('quote_zip', 'zip', 'trim|required');
            $this->form_validation->set_rules('quote_name', 'name', 'trim|required');
            $this->form_validation->set_rules('quote_email', 'email', 'trim|required|valid_email');
            $this->form_validation->set_rules('quote_phone', 'phone', 'trim|required|regex_match[/^[0-9+.-]*$/]');
            $this->form_validation->set_rules('quote_terms', 'terms', 'trim|required');

            if ($this->form_validation->run() == TRUE) {

                $data['quote_description'] = $this->input->post('quote_description');
                $data['quote_zip'] = $this->input->post('quote_zip');
                $data['quote_name'] = $this->input->post('quote_name');
                $data['quote_email'] = $this->input->post('quote_email');
                $data['quote_phone'] = $this->input->post('quote_phone');

                $quote_category = $this->input->post('quote_category');
                $data['quote_category'] = $category[$quote_category];

                $quote_timespan = $this->input->post('quote_timespan');
                $data['quote_timespan'] = $timespan[$quote_timespan];

                $quote_buyertype = $this->input->post('quote_buyertype');
                $data['quote_buyertype'] = $buyertype[$quote_buyertype];

                //SMTP & mail configuration
                $this->load->config('email');
                $this->load->library('email');

                $from = $this->config->item('smtp_user');
                $to = 'info@vvsoffert.se';

                //Email content
                $htmlContent = $this->load->view('email/inquere-email', $data, TRUE);

                //$this->email->set_mailtype("html");
                //$this->email->set_header('Content-Type', 'text/html');
                $this->email->clear();
                $this->email->from($from, 'vvsoffert');
                $this->email->to($to);
                $this->email->subject('Få offert från rörmokare!!');
                $this->email->message($htmlContent);

                //Send email
                try {
                    $this->email->send();
                    //echo $this->email->print_debugger(); exit;
                    $session_message['type'] = 1;
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = 'Tack för din förfrågan, vi återkommer till Er med en offert.';
                    $this->session->set_flashdata('message', $session_message);
                } catch (Exception $e) {
                    $session_message['type'] = 1;
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = $e->getMessage();
                    $this->session->set_flashdata('message', $session_message);
                }
            }
        }

        $this->data = array();
        $this->data['content'] = $this->load->view('pages/home', $this->data, true);
        $this->load->view('layout', $this->data);
    }

    public function language_section() {
        $this->load->view("check-language");
    }

    function signup() {
        if ($this->session->userdata('is_valid')) {
            redirect(site_url('kontrollpanel'));
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


            $this->form_validation->set_rules('name', 'Namn', 'trim|required');
            $this->form_validation->set_rules('contact', 'Telefon Nummer', 'trim|regex_match[/^[0-9+.-]*$/]');
            $this->form_validation->set_rules('email', 'E-Post', 'trim|required|valid_email|is_unique[user_master.email]');
            $this->form_validation->set_rules('password', 'Lösenord', 'required|min_length[6]|max_length[12]|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Bekräfta lösenord', 'trim|required');
            $this->form_validation->set_rules('org_no', 'Organisation Nummer', 'trim|required');
            $this->form_validation->set_message('is_unique', 'Fältet %s är redan taget!');
            $this->form_validation->set_message('required', 'Detta %s fält är obligatoriskt!');

            if ($this->form_validation->run() == true) {

                $email = set_value('email');
                $FName = set_value('name');
                $SName = ' ';
                $Phone = set_value('contact');
                $orgno = set_value('org_no');
                $company =  ' ';
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
                    'status' => '0',
                );


                $this->FrontendUser_model->insert($user_master_data);


//                    Events::trigger('new_user_registration_success', $user_master_data);


                $this->load->library('email');

//SMTP & mail configuration
                /*$config = array(
                    'protocol'  => 'smtp',
                    'smtp_host' => 'send.one.com',
                    'smtp_port' =>  25,
                    'smtp_user' => 'info@vvsoffert.se',
                    'smtp_pass' => 'Vv$offert@123',
                    'mailtype'  => 'html',
                    'charset'   => 'utf-8'
                );
                $this->email->initialize($config);
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");*/

//Email content
                $htmlContent = $this->load->view('email/registrationmail', $user_master_data, TRUE);
//$htmlContent = "You are successfully Registered Now";

                $this->email->to($email);
                $this->email->from('info@vvsoffert.se','vvsoffert');
                $this->email->subject('Du är framgångsrik registrerad');
                $this->email->message($htmlContent);
                try {
                    $this->email->send();
                    $this->ajax_response['type'] = 'success';
                    $this->ajax_response['message'] = 'You have successfully sign up successfully.Please Wait for Admin Approval.';
                    $this->ajax_response['url'] = site_url('/');
                    $session_message['type'] = 1;
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = 'Tack för att du kontaktade oss. Vi kommer snart tillbaka';
                    $this->session->set_flashdata('message', $session_message);
                } catch (Exception $e) {
                    $this->ajax_response['type'] = 'success';
                    $this->ajax_response['message'] = 'You have successfully sign up successfully.Please Wait for Admin Approval.';
                    $this->ajax_response['url'] = site_url('/');
                    $session_message['type'] = 1;
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = $e->getMessage();
                    $this->session->set_flashdata('message', $session_message);
                }




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

    public function token() {

        $this->ajax_response['type'] = 'success';
        $this->ajax_response['message'] = 'API Token Verification.';
        $this->ajax_response['code'] = '112';
        $this->ajax_response['verified'] = true;

        echo json_encode($this->ajax_response);
    }

    public function invoiceHistory(){
        //var_dump($this->input->post);exit;
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            //if (!$this->auth->is_login()) {
            $this->form_validation->set_rules('customer_sel', 'First Name', 'trim|required');
            if ($this->form_validation->run() == true) {

                //$this->load->model('Invoice_histories_model');
                $data['user_id'] = $this->session->userdata("user_id");
                $data['customer_sel'] = $this->input->post('customer_sel');
                $data['email'] = $this->input->post('email');
                $data['address'] = $this->input->post('address');
                $data['city'] = $this->input->post('city');
                $data['special_comments'] = $this->input->post('special_comments');
                $data['invoice_number'] = $this->input->post('invoice_number');
                $data['store_name'] = $this->input->post('store_name');
                $data['selected_products'] = $this->input->post('selected_products');
                $data['invoice_type'] = $this->input->post('invoice_type');
                $data['date_value'] = $this->input->post('date_value');

                $inserted_id =$this->Invoice_histories_model->insert($data);

                $this->ajax_response['type'] = 'success';
                $this->ajax_response['insertedID'] = $inserted_id;
                $this->ajax_response['message'] = "We've just sent a confirmation link to <strong>$inserted_id</strong>. Just click the link in that email & you're in!";
            } else {

                $this->ajax_response['type'] = 'warning';
                $error = [];
                foreach ($this->form_validation->error_array() as $key => $val) {
                    $error[$key] = $val;
                }
                $this->ajax_response['message'] = $error;
            }
            //}
        }
        echo json_encode($this->ajax_response);
        exit;
        /*
        if ($this->input->is_ajax_request()) {
            if(isset( $_POST['name'])){
                echo "okokok";
            }else{
                echo "hohoho";
            }
        }
        // echo json_encode($this->ajax_response);
        exit;
        */
    }
}
