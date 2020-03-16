<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('custom_functions_helper');
        $this->load->model('Login_model');
        $this->load->model('ListMaster_model');
        $this->load->model('Estore_model');
        $this->load->model('Customer_model');
        $this->load->model('Plumbing_service_model');
        $this->load->model('Products_model');
        $this->load->model('Plumbing_service_price_model');
        $this->load->model('Invoice_histories_model');
        $this->load->model('SetCompany_model');
        $this->load->model('SetInvoice_model');
        $this->load->model('Invoice_histories_news_model');
        $this->load->model('Order_histories_news_model');
        $this->load->model('Offerter_histories_news_model');
        $this->load->model('Article_model');

        $this->load->library('excel');
    }

    public function ajaxproductaddtolist() {
        if ($this->input->is_ajax_request()) {
            $error = [];
            $error = false;
            $list_id = trim($_POST['list_id']);
            $product_id = trim($_POST['product_id']);
            $product_rsk = trim($_POST['product_rsk']);
            if (!$this->session->userdata("user_id")) {
                $error = true;
                $this->ajax_response['type'] = 'warning';
                $this->ajax_response['msg'] = 'Vänligen logga in.';
            } else {
                $checkproduct = $this->db->query("SELECT id FROM list_master_product WHERE list_id=" . $list_id . " and product_id=" . $product_id)->row();
                if ($checkproduct == '') {
                    $error = false;
                    $Array = array(
                        'list_id' => $list_id,
                        'product_id' => $product_id,
                        'rsk_no' => $product_rsk,
                        'quantity' => 1,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $query = savedata('list_master_product', $Array);
                    $this->ajax_response['type'] = 'success';
                    $this->ajax_response['msg'] = 'Produkten har lagts till på din lista.';
                } else {
                    $error = true;
                    $this->ajax_response['type'] = 'warning';
                    $this->ajax_response['msg'] = 'Produkten har redan lagts till i din lista.';
                }
            }
        }
        echo json_encode($this->ajax_response);
    }

    public function useraccount_details() {

        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $data_msg = array();
        $update = $this->Login_model->get_by_id($this->session->userdata("user_id"));

        if ($this->input->post('submit')) {

            $submit = $this->input->post('submit');
//            if ($submit == "Update Profile") {

            $checkemail = $this->db->query("SELECT email FROM user_master WHERE user_id = " . $this->session->userdata("user_id"))->row()->email;

            if ($this->input->post('email') != $checkemail) {
                echo $checkemail;
                $is_unique = '|is_unique[user_master.email]';
            } else {
                $is_unique = '';
            }

            $this->form_validation->set_rules('email', 'Email', 'trim|required' . $is_unique);
            $this->form_validation->set_rules('name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('contact', 'Phone No', 'trim|required');
            $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('org_no', 'Organization Number', 'trim|required');
            $this->form_validation->set_message('is_unique', 'The %s is already taken');



            if ($this->form_validation->run() == TRUE) {

                $update->name = $this->input->post('name');
                $update->email = $this->input->post('email');
                $update->last_name = $this->input->post('last_name');
                $update->contact = $this->input->post('contact');
                $update->company_name = $this->input->post('company_name');
                $update->org_no = $this->input->post('org_no');



                $this->Login_model->update($update->user_id, $update);



                $session_message['type'] = 1;
                $session_message['title'] = 'Framgång!';
                $session_message['content'] = 'Your details has been successfully saved.';
                $this->session->set_flashdata('message', $session_message);
            }
//            }
        }

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;

        $this->data['content'] = $this->load->view('user/account_details', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function add_list() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $data_msg = array();
        $all_list = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));
        $this->data['model'] = $all_list;

        $this->data['content'] = $this->load->view('user/list_index', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function new_add_list() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $data_msg = array();
        $all_list = $this->Article_model->get_articles($this->session->userdata("user_id"));
        $this->data['articles'] = $all_list;

        $this->data['content'] = $this->load->view('user/list_new_index', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function new_add_article(){
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $this->data['content'] = $this->load->view('user/add_article','',true);
        $this->load->view('layout_sidebar',$this->data);
    }

    public function add_new_article_update() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $data = $this->input->post();
        //var_dump($data);exit;
        $data['user_id'] = $this->session->userdata("user_id");
        $data['created_at'] = date('Y-m-d');
        $data_msg = array();
        // $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[customers.email]');
        // if ($this->form_validation->run() == TRUE) {
            if($data['id']){
                $result = $this->Article_model->update($data, $data['id']);
            }else{
                $result = $this->Article_model->insert($data);
            }
            $session_message['type'] = 1;
            $session_message['title'] = 'Framgång!';
            $session_message['content'] = 'Listan har sparats.';
            $this->session->set_flashdata('message', $session_message);
        // } else {
        //     $this->session->set_flashdata('error', $this->form_validation->error_array());
        // }

        $all_list = $this->Article_model->get_articles($this->session->userdata("user_id"));
        $this->data['articles'] = $all_list;

        $this->data['content'] = $this->load->view('user/list_new_index', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function add_list_form() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $data_msg = array();
        if ($this->input->post('submit')) {

            $submit = $this->input->post('submit');
//            if ($submit == "submit") {
            $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[list_master.name]');
            if ($this->form_validation->run() == TRUE) {

                $update->user_id = $this->session->userdata("user_id");
                $update->name = $this->input->post('name');
                $update->status = 1;
                $update->created_at = date('Y-m-d H:i:s');
                $this->ListMaster_model->insert($update);

                $session_message['type'] = 1;
                $session_message['title'] = 'Framgång!';
                $session_message['content'] = 'Listan har sparats.';
                $this->session->set_flashdata('message', $session_message);
            } else {
                $this->session->set_flashdata('error', $this->form_validation->error_array());
            }
//            }
        }

        $all_list = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));
        $this->data['model'] = $all_list;

        $this->data['content'] = $this->load->view('user/add_list_form', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function edit_list_form() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $id = base64_decode($_GET['id']);
        $data_msg = array();
        if ($this->input->post('submit')) {
            $id = $_POST['id'];
            $submit = $this->input->post('submit');
//            if ($submit == "submit") {
            $original_value = $this->db->query("SELECT name FROM list_master WHERE id = " . $id)->row()->name;
            if ($this->input->post('name') != $original_value) {
                $is_unique = '|is_unique[list_master.name]';
            } else {
                $is_unique = '';
            }
            $this->form_validation->set_rules('name', 'Name', 'trim|required' . $is_unique);
            if ($this->form_validation->run() == TRUE) {

                $update->user_id = $this->session->userdata("user_id");
                $update->name = $this->input->post('name');
                $update->status = 1;
                $update->created_at = date('Y-m-d H:i:s');
                $this->ListMaster_model->update($update, $id);

                $session_message['type'] = 1;
                $session_message['title'] = 'Framgång!';
                $session_message['content'] = 'List has been successfully updated.';
                $this->session->set_flashdata('message', $session_message);
            } else {
                $this->session->set_flashdata('error', $this->form_validation->error_array());
            }
//            }
        }

        $all_list = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));
        $singlelist = $this->ListMaster_model->get($id);
        $this->data['model'] = $all_list;
        $this->data['singlelist'] = $singlelist;

        $this->data['content'] = $this->load->view('user/add_list_form', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function list_details() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;
        
        $id = base64_decode($_GET['id']);
        $data_msg = array();

        $singlelist = $this->ListMaster_model->get($id);
        
        $productlist = getjoinlist_product($id);
        // print_r($productlist);
        $this->data['productlist'] = $productlist;
        $this->data['singlelist'] = $singlelist;

        $this->data['content'] = $this->load->view('user/product_listings_by_list', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);
    }

    // public function list_invoice_form() {
    //     if (!$this->session->userdata("user_id")) {
    //         redirect('logga-in');
    //         exit;
    //     }

    //     $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
    //     $this->data['model'] = $user;

    //     $listId = base64_decode($_GET['id']);
    //     $productList = $this->ListMaster_model->getListProduct($listId);
    //     $this->data['productlist'] = $productList;

    //     $productAllList = $this->ListMaster_model->getAllListProduct();
    //     $this->data['productalllist'] = $productAllList;

    //     $estoreAllList = $this->ListMaster_model->getAllEstoreMaster();
    //     $this->data['estoreAllList'] = $estoreAllList;
    //     $this->data['content'] = $this->load->view('user/list_invoice_form', $this->data, true);
    //     $this->load->view('layout_sidebar', $this->data);
    // }

    public function searchProductAjax() {
        // process posted form data  
        $keyword = $this->input->post('term');
        $store_id = substr($this->input->post('store_id'), -2);
        $data['response'] = false; //Set default response  
        $query = lookupProduct3($keyword, $store_id); //Search DB  
        $data['response'] = true;
        $html_product = '';
        if (!empty($query)) {
            $data['response'] = true; //Set response  
            $data['message'] = array(); //Create array  
            $html_product .= '<ul class="suggestions">';
            foreach ($query as $row) {
                $img_src = (file_exists($row->ImageName)) ? $row->ImageName : 'http://www.vvsoffert.se/scraper/' . $row->ImageName;
                $html_product .= '<li>' .
                        '<a href="javascript:void(0)" class="product_' . $row->id . '" data-name="' . $row->Name . '" onClick="AddProduct(' . $row->id . ');">' .
                        '<img src="' . $img_src . '" alt="">' .
                        '<p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' . $row->Name . '</font></font></p>' .
                        '</a></li>'
                ;
            }
            $html_product .= '</ul>';
        }
        $data['html_product'] = !empty($html_product) ? $html_product : 'No Data Found.';
        echo json_encode($data); //echo json string if ajax request  
    }

    public function list_sale_history() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $type = 1;
        isset($_GET["type"]) ? $type = $_GET["type"]  : $type = 1;

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;
        if($type==3){
            // $invoiceHistoryList = $this->Invoice_histories_model->getSub($this->session->userdata("user_id"), $type);
            $invoiceHistoryList = $this->Invoice_histories_news_model->getSub($this->session->userdata("user_id"));
            $this->data['invoiceHistoryList'] = $invoiceHistoryList;

            $customers = $this->Customer_model->get_customers($this->session->userdata('user_id'));
            $this->data['customers'] = $customers;

            $this->data['content'] = $this->load->view('user/list_sale_history', $this->data, true);
            $this->load->view('layout_sidebar', $this->data);
        }elseif($type==2){
            // $invoiceHistoryList = $this->Invoice_histories_model->getSub($this->session->userdata("user_id"), $type);
            $orderHistoryList = $this->Order_histories_news_model->getSub($this->session->userdata("user_id"));
            $this->data['orderHistoryList'] = $orderHistoryList;

            $customers = $this->Customer_model->get_customers($this->session->userdata('user_id'));
            $this->data['customers'] = $customers;

            $this->data['content'] = $this->load->view('user/list_sale_history_order', $this->data, true);
            $this->load->view('layout_sidebar', $this->data);
        }else{
            // $invoiceHistoryList = $this->Invoice_histories_model->getSub($this->session->userdata("user_id"), $type);
            $offerterHistoryList = $this->Offerter_histories_news_model->getSub($this->session->userdata("user_id"));
            $this->data['offerterHistoryList'] = $offerterHistoryList;

            $customers = $this->Customer_model->get_customers($this->session->userdata('user_id'));
            $this->data['customers'] = $customers;

            $this->data['content'] = $this->load->view('user/list_sale_history_offerter', $this->data, true);
            $this->load->view('layout_sidebar', $this->data);
        }
    }

    public function list_sale_history_new() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $type = 1;
        isset($_GET["type"]) ? $type = $_GET["type"]  : $type = 1;

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;

        $invoiceHistoryList = $this->Invoice_histories_model->getSub($this->session->userdata("user_id"), $type);
        $this->data['invoiceHistoryList'] = $invoiceHistoryList;

        $customers = $this->Customer_model->get_customers($this->session->userdata('user_id'));
        $this->data['customers'] = $customers;

        $this->data['content'] = $this->load->view('user/list_sale_history', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function list_invoice() {

        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $listId = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        $stores = [];
        $estoreProducts = [];
        $getAllStores = $this->Estore_model->all_store();

        $selectedproductList = $this->ListMaster_model->getListProduct($listId);
        // print_r($productList);
        // if ($_POST['selected_products']) {
        //     $ids = implode(",", $_POST['selected_products']);            
        //     $selectedproductListRaw = $this->ListMaster_model->getSelectedListProduct($ids);
        //     //$this->data['selectedproductlist'] = $selectedproductList;
        // }
        
        // $selectedproductList = [];
        // $selectedproductIds = [];
        // foreach ($selectedproductListRaw as $prodKey => $prodVal) {
        //     if (!in_array($prodVal->product_id, $selectedproductIds) && $prodVal->rsk_no != '') {
        //         array_push($selectedproductIds, $prodVal->product_id);
        //         array_push($selectedproductList, $prodVal);
        //     } elseif ($prodVal->rsk_no != '') {
        //         foreach ($selectedproductList as $ke => $val) {
        //             if ($val->product_id == $prodVal->product_id && $prodVal->quantity > $val->quantity) {
        //                 $selectedproductList[$ke]->quantity = $prodVal->quantity;
        //                 // $selectedproductList[$ke]->pro_id = $prodVal->product_id;
        //             }
        //         }
        //     }
        // }
        // print_r($selectedproductList);
        $proRsk = [];
        foreach ($selectedproductList as $v) {
            array_push($proRsk, $v->rsk_no);
        }
        $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);
        // print_r($estore_Pro);
        $highlitedColumn = [];

        if (count($selectedproductList) > 0) {
            foreach ($selectedproductList as $k => $v) {
                $itemMinPrrice = [];
                $itemColumn = 'D';
                $itemRow = $k + 1;
                $vArr = (object) $v;
                $estoreProducts[$k]["PRO_ID"] = $vArr->product_id;
                $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
                $estoreProducts[$k]["PRO_NAME"] = $vArr->pro_name;
                $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                $tmp=[];
                foreach ($getAllStores as $key => $estore) {
                    $amount = 0;
                    foreach ($estore_Pro as $kV => $value) {
                        if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
                            if($value->discountprice > 0) {
                                $amount = $value->discountprice;
                            }
                            else{
                                $amount = $value->price;
                            }
                        }
                    }
                    // var_dump($amount);
                    // print_r($amount);
                    $amount = number_format($amount, 2);
                    // $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                    $tmp[$key]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                    // all store product amount into array
                    
                }
                $json=json_encode($tmp);
                $estoreProducts[$k]['PRICE'] = $json;
                // print_r($estoreProducts[$k]);
            }
        }
        $this->data['productlist'] = $estoreProducts;
        
        $this->data['post'] = !empty($_POST) ? $_POST : '';

        $productList = $this->ListMaster_model->getListProduct($listId);

        $this->data['selectedproductList'] = $selectedproductList;

        $productAllList = $this->ListMaster_model->getAllListProduct();
        $this->data['productalllist'] = $productAllList;

        $estoreAllList = $this->ListMaster_model->getAllEstoreMaster();
        $this->data['estoreAllList'] = $estoreAllList;
        foreach ($estoreAllList as $estore){
            if($estore->name == "Dahl"){
                $this->data['defaultEstore'] = $estore->name . '-' . $estore->id;
            }
        }
        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;
        // print_r($this->data);

        // $invoiceHistoryList = $this->Invoice_histories_model->getSub($user->id, $_GET['type']);
        // $this->data['invoiceHistoryList'] = $invoiceHistoryList;
        $this->data['content'] = $this->load->view('user/list_invoice_form', $this->data);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function list_invoice_save() {

        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }

        $this->data['post'] = !empty($_POST) ? $_POST : '';

        $this->data['content'] = $this->load->view('user/product_listings_invoice_saved_by_list', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout', $this->data);
    }

    public function list_invoice_edit() {

        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
//        $listId = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        $stores = [];
        $estoreProducts = [];
        $getAllStores = $this->Estore_model->all_store();

//        $productList = $this->ListMaster_model->getListProduct($listId);
        if ($_GET['selected_products']) {
            $ids = implode(",", $_GET['selected_products']);
            $selectedproductListRaw = $this->ListMaster_model->getSelectedListProduct($ids);
            //$this->data['selectedproductlist'] = $selectedproductList;
        }
        $selectedproductList = [];
        $selectedproductIds = [];
        foreach ($selectedproductListRaw as $prodKey => $prodVal) {
            if (!in_array($prodVal->product_id, $selectedproductIds) && $prodVal->rsk_no != '') {
                array_push($selectedproductIds, $prodVal->product_id);
                array_push($selectedproductList, $prodVal);
            } elseif ($prodVal->rsk_no != '') {
                foreach ($selectedproductList as $ke => $val) {
                    if ($val->product_id == $prodVal->product_id && $prodVal->quantity > $val->quantity) {
                        $selectedproductList[$ke]->quantity = $prodVal->quantity;
                    }
                }
            }
        }
        $proRsk = [];
        foreach ($selectedproductList as $v) {
            array_push($proRsk, $v->rsk_no);
        }
        $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);

        $highlitedColumn = [];

        if (count($selectedproductList) > 0) {
            foreach ($selectedproductList as $k => $v) {
                $itemMinPrrice = [];
                $itemColumn = 'D';
                $itemRow = $k + 1;

                $vArr = (object) $v;
                $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
                $estoreProducts[$k]["PRO_NAME"] = "$vArr->pro_name";
                $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                foreach ($getAllStores as $key => $estore) {
                    $amount = 0;
                    foreach ($estore_Pro as $kV => $value) {
                        if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
                            $amount += $value->discountprice;
                        }
                    }
                    foreach ($selectedproductListRaw as $prodKey => $prodVal) {
                        if ($prodVal->rsk_no == $vArr->rsk_no && $prodVal->user_id == $this->session->userdata("user_id")) {
                            $unserializedArr = unserialize($prodVal->price);
                            foreach ($unserializedArr as $storeId => $storeprice) {
                                if ($estore->id == $storeId) {
                                    $amount = $storeprice;
                                    break;
                                }
                            }
                        }
                    }
                    $amount = number_format($amount, 2);
                    $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                    // all store product amount into array
                    if ($amount == 0) {
                        $amountValue = "";
                    } else {
                        $amountValue = $amount;
                    }
                    array_push($itemMinPrrice, $amountValue);
                }
                // removing blank value from array
                $removeNullValues = array_filter($itemMinPrrice, function($value) {
                    return $value !== '';
                });
                // calculating excel cell Id
                if (count($removeNullValues) > 0) {
                    $lowAmtKey = array_search(min($removeNullValues), $removeNullValues);
                    for ($i = 1; $i <= $lowAmtKey; $i++) {
                        $itemColumn++;
                    }
                    $actualBlock = $itemColumn . ($k + 2);
                    array_push($highlitedColumn, $actualBlock);
                }
            }
        }
        $this->data['productlist'] = $estoreProducts;

        $this->data['post'] = !empty($_REQUEST) ? $_REQUEST : '';

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;

        $this->data['content'] = $this->load->view('user/list_inoive_form', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout', $this->data);
    }

    public function list_invoice_reedit() {

        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $this->data['post'] = !empty($_GET) ? $_GET : '';
        $this->data['content'] = $this->load->view('user/product_listings_invoice_reedit_by_list', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout', $this->data);
    }

    public function pdf_export_invoice() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
//        $listId = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        $stores = [];
        $estoreProducts = [];
        $getAllStores = $this->Estore_model->all_store();

//        $productList = $this->ListMaster_model->getListProduct($listId);
        if ($_GET['selected_products']) {
            $ids = implode(",", $_GET['selected_products']);
            $selectedproductListRaw = $this->ListMaster_model->getSelectedListProduct($ids);
            //$this->data['selectedproductlist'] = $selectedproductList;
        }
        $selectedproductList = [];
        $selectedproductIds = [];
        foreach ($selectedproductListRaw as $prodKey => $prodVal) {
            if (!in_array($prodVal->product_id, $selectedproductIds) && $prodVal->rsk_no != '') {
                array_push($selectedproductIds, $prodVal->product_id);
                array_push($selectedproductList, $prodVal);
            } elseif ($prodVal->rsk_no != '') {
                foreach ($selectedproductList as $ke => $val) {
                    if ($val->product_id == $prodVal->product_id && $prodVal->quantity > $val->quantity) {
                        $selectedproductList[$ke]->quantity = $prodVal->quantity;
                    }
                }
            }
        }
        $proRsk = [];
        foreach ($selectedproductList as $v) {
            array_push($proRsk, $v->rsk_no);
        }
        $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);

        $highlitedColumn = [];

        if (count($selectedproductList) > 0) {
            foreach ($selectedproductList as $k => $v) {
                $itemMinPrrice = [];
                $itemColumn = 'D';
                $itemRow = $k + 1;

                $vArr = (object) $v;
                $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
                $estoreProducts[$k]["PRO_NAME"] = "$vArr->pro_name";
                $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                foreach ($getAllStores as $key => $estore) {
                    $amount = 0;
                    foreach ($estore_Pro as $kV => $value) {
                        if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
                            $amount += $value->discountprice * $vArr->quantity;
                        }
                    }
                    foreach ($selectedproductListRaw as $prodKey => $prodVal) {
                        if ($prodVal->rsk_no == $vArr->rsk_no && $prodVal->user_id == $this->session->userdata("user_id")) {
                            $unserializedArr = unserialize($prodVal->price);
                            foreach ($unserializedArr as $storeId => $storeprice) {
                                if ($estore->id == $storeId) {
                                    $amount = $storeprice * $vArr->quantity;
                                    break;
                                }
                            }
                        }
                    }
                    $amount = number_format($amount, 2);
                    $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                    // all store product amount into array
                    if ($amount == 0) {
                        $amountValue = "";
                    } else {
                        $amountValue = $amount;
                    }
                    array_push($itemMinPrrice, $amountValue);
                }
                // removing blank value from array
                $removeNullValues = array_filter($itemMinPrrice, function($value) {
                    return $value !== '';
                });
                // calculating excel cell Id
                if (count($removeNullValues) > 0) {
                    $lowAmtKey = array_search(min($removeNullValues), $removeNullValues);
                    for ($i = 1; $i <= $lowAmtKey; $i++) {
                        $itemColumn++;
                    }
                    $actualBlock = $itemColumn . ($k + 2);
                    array_push($highlitedColumn, $actualBlock);
                }
            }
        }
        $this->data['productlist'] = $estoreProducts;

        $this->data['post'] = !empty($_GET) ? $_GET : '';

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;

        // boost the memory limit if it's low ;)
        $html = $this->load->view('user/pdf_export_invoice', $this->data, true);

        $this->load->library('pdf');
        $pdf = $this->pdf->pdf;
        //$pdf->debug = true;
        // render the view into HTML
        $pdf->WriteHTML($html);
        // write the HTML into the PDF
        $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';

        if ($_GET['action'] == 'pdf_export') {
            $pdf->Output("$output", 'D');
//            $pdf->Output();
            die;
        } else {
            $path = FCPATH . 'uploads/invoices/' . $output;
            $pdf->Output("$path", 'F');
            $to = $_POST['email'];
            $message = "Hi,<br>
                Please find the attach file.</br></br>
                
                Regards,
                VvoSoffert Team
                ";

            $email_status = $this->email_invoice($to, $message, $path);
            if ($email_status == "true") {
                $this->data['content'] = $this->load->view('user/invoice_success_msg', $email_status, true);
                $this->load->view('layout', $this->data);
            }
        }
    }
    public function pdf_export_only_invoice_edited() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
//        $listId = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        //$this->data['post'] = !empty($_POST) ? $_POST : '';
        //var_dump($_POST);exit;
        $insert_data['customer_sel']=$_POST['customer_sel'];
        $insert_data['invoice_date_value']=$_POST['invoice_date_value'];
        $insert_data['due_date_value']=$_POST['due_date_value'];
        $insert_data['delivery_date_value']=$_POST['delivery_date_value'];
        $insert_data['your_ref']=$_POST['your_ref'];
        $insert_data['our_ref']=$_POST['our_ref'];
        $insert_data['custom_ref']=$_POST['custom_ref'];
        $insert_data['store_name_inv']=$_POST['store_name_inv'];
        //$insert_data['article_num']=$_POST['article_num'];

        $insert_data['art_id']= json_encode($_POST['art_id']);
        $insert_data['art_name']= json_encode($_POST['art_name']);
        $insert_data['art_quantity']= json_encode($_POST['art_quantity']);
        $insert_data['unit']= json_encode($_POST['unit']);
        $insert_data['sale_price_excl']= json_encode($_POST['sale_price_excl']);
        $insert_data['discount']= json_encode($_POST['discount']);

        $insert_data['sum_excl']=json_encode($_POST['sum_excl']);
        $insert_data['total_sum']=$_POST['total_sum'];

        //$insert_data['price_list'] = json_encode($_POST['price_list']);
       
        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $insert_data['user_id'] = $user->user_id;
        // var_dump($insert_data);exit;

        $data_msg = array();
        // $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[customers.email]');
        // if ($this->form_validation->run() == TRUE) {
            if($_POST['id']){
                $result = $this->Invoice_histories_news_model->update($insert_data, $_POST['id']);
            }else{
                $result = $this->Invoice_histories_news_model->insert($insert_data);
            }
            $session_message['type'] = 1;
            $session_message['title'] = 'Framgång!';
            $session_message['content'] = 'Listan har sparats.';
            $this->session->set_flashdata('message', $session_message);
        // } else {
        //     $this->session->set_flashdata('error', $this->form_validation->error_array());
        // }

        
        $customers = $this->Customer_model->get_customers($this->session->userdata('user_id'));
        $this->data['customers'] = $customers;
        $invoiceHistoryList = $this->Invoice_histories_news_model->getSub($this->session->userdata("user_id"));
        $this->data['invoiceHistoryList'] = $invoiceHistoryList;

        $this->data['content'] = $this->load->view('user/list_sale_history', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
        
    }

    public function pdf_export_only_order_edited() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        //var_dump($_POST);exit;
//        $listId = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        
        $this->data['productlist'] = json_decode($_POST['selected_products']);
        
        $this->data['post'] = !empty($_POST) ? $_POST : '';
        $insert_data = $this->data['post'];
        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $insert_data['user_id'] = $user->user_id;
        $insert_data['state']='Skickad';

        $insert_data['customer_sel']=$_POST['customer_sel'];
        $insert_data['order_date']=$_POST['order_date'];
        $insert_data['plan_delivery_date']=$_POST['plan_delivery_date'];
        $insert_data['your_ref']=$_POST['your_ref'];
        $insert_data['our_ref']=$_POST['our_ref'];
        $insert_data['store_name_inv']=$_POST['store_name_inv'];
        //$insert_data['article_num']=$_POST['article_num'];

        $insert_data['art_id']= json_encode($_POST['art_id']);
        $insert_data['art_name']= json_encode($_POST['art_name']);
        $insert_data['art_quantity']= json_encode($_POST['art_quantity']);
        $insert_data['unit']= json_encode($_POST['unit']);
        $insert_data['sale_price_excl']= json_encode($_POST['sale_price_excl']);
        $insert_data['discount']= json_encode($_POST['discount']);

        $insert_data['sum_excl']=json_encode($_POST['sum_excl']);
        $insert_data['total_sum']=$_POST['total_sum'];

        $data_msg = array();
        // $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[customers.email]');
        // if ($this->form_validation->run() == TRUE) {
            if($_POST['id']){
                $result = $this->Order_histories_news_model->update($insert_data, $_POST['id']);
            }else{
                $result = $this->Order_histories_news_model->insert($insert_data);
            }
            $session_message['type'] = 1;
            $session_message['title'] = 'Framgång!';
            $session_message['content'] = 'Listan har sparats.';
            $this->session->set_flashdata('message', $session_message);
        // } else {
        //     $this->session->set_flashdata('error', $this->form_validation->error_array());
        // }

        
        $customers = $this->Customer_model->get_customers($this->session->userdata('user_id'));
        $this->data['customers'] = $customers;
        $orderHistoryList = $this->Order_histories_news_model->getSub($this->session->userdata("user_id"));
        $this->data['orderHistoryList'] = $orderHistoryList;

        $this->data['content'] = $this->load->view('user/list_sale_history_order', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
        
    }

    public function pdf_export_only_offerter_edited() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        //var_dump($_POST);exit;
//        $listId = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        
        $this->data['productlist'] = json_decode($_POST['selected_products']);
        
        $this->data['post'] = !empty($_POST) ? $_POST : '';
        $insert_data = $this->data['post'];
        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $insert_data['user_id'] = $user->user_id;
        $insert_data['state']='Skickad';

        $insert_data['customer_sel']=$_POST['customer_sel'];
        $insert_data['quote_date']=$_POST['quote_date'];
        $insert_data['valid_date']=$_POST['valid_date'];
        $insert_data['your_ref']=$_POST['your_ref'];
        $insert_data['our_ref']=$_POST['our_ref'];
        $insert_data['store_name_inv']=$_POST['store_name_inv'];

        $insert_data['art_id']= json_encode($_POST['art_id']);
        $insert_data['art_name']= json_encode($_POST['art_name']);
        $insert_data['art_quantity']= json_encode($_POST['art_quantity']);
        $insert_data['unit']= json_encode($_POST['unit']);
        $insert_data['sale_price_excl']= json_encode($_POST['sale_price_excl']);
        $insert_data['discount']= json_encode($_POST['discount']);

        $insert_data['sum_excl']=json_encode($_POST['sum_excl']);
        $insert_data['total_sum']=$_POST['total_sum'];

        $data_msg = array();
        // $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[customers.email]');
        // if ($this->form_validation->run() == TRUE) {
            if($_POST['id']){
                $result = $this->Offerter_histories_news_model->update($insert_data, $_POST['id']);
            }else{
                $result = $this->Offerter_histories_news_model->insert($insert_data);
            }
            $session_message['type'] = 1;
            $session_message['title'] = 'Framgång!';
            $session_message['content'] = 'Listan har sparats.';
            $this->session->set_flashdata('message', $session_message);
        // } else {
        //     $this->session->set_flashdata('error', $this->form_validation->error_array());
        // }

        $customers = $this->Customer_model->get_customers($this->session->userdata('user_id'));
        $this->data['customers'] = $customers;
        $offerterHistoryList = $this->Offerter_histories_news_model->getSub($this->session->userdata("user_id"));
        $this->data['offerterHistoryList'] = $offerterHistoryList;

        $this->data['content'] = $this->load->view('user/list_sale_history_offerter', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
        
    }

    public function pdf_export_invoice_edited() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
//        $listId = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        // print_r($_POST['selected_products']);
       
        $tmp = $_POST['store_name'];
        $store_id = substr($tmp, strpos($tmp, '-')+1, strlen($tmp));
        $stores = [];
        $estoreProducts = [];
        $getAllStores = $this->Estore_model->all_store();
        $this->data['productlist'] = json_decode($_POST['selected_products']);
        
        /*if ($_GET['selected_products']) {
            $ids = implode(",", $_GET['selected_products']);
            $selectedproductListRaw = $this->ListMaster_model->getSelectedListProduct($ids);
            //$this->data['selectedproductlist'] = $selectedproductList;
        }
        $selectedproductList = [];
        $selectedproductIds = [];
        foreach ($selectedproductListRaw as $prodKey => $prodVal) {
            if (!in_array($prodVal->product_id, $selectedproductIds) && $prodVal->rsk_no != '') {
                array_push($selectedproductIds, $prodVal->product_id);
                array_push($selectedproductList, $prodVal);
            } elseif ($prodVal->rsk_no != '') {
                foreach ($selectedproductList as $ke => $val) {
                    if ($val->product_id == $prodVal->product_id && $prodVal->quantity > $val->quantity) {
                        $selectedproductList[$ke]->quantity = $prodVal->quantity;
                    }
                }
            }
        }
        $proRsk = [];
        foreach ($selectedproductList as $v) {
            array_push($proRsk, $v->rsk_no);
        }
        $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);

        $highlitedColumn = [];

        if (count($selectedproductList) > 0) {
            foreach ($selectedproductList as $k => $v) {
                $itemMinPrrice = [];
                $itemColumn = 'D';
                $itemRow = $k + 1;

                $vArr = (object) $v;
                $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
                $estoreProducts[$k]["PRO_NAME"] = "$vArr->pro_name";
                $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                foreach ($getAllStores as $key => $estore) {
                    $amount = 0;
                    foreach ($estore_Pro as $kV => $value) {
                        if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
                            $amount += $value->discountprice * $vArr->quantity;
                        }
                    }
                    foreach ($selectedproductListRaw as $prodKey => $prodVal) {
                        if ($prodVal->rsk_no == $vArr->rsk_no && $prodVal->user_id == $this->session->userdata("user_id")) {
                            $unserializedArr = unserialize($prodVal->price);
                            foreach ($unserializedArr as $storeId => $storeprice) {
                                if ($estore->id == $storeId) {
                                    $amount = $storeprice * $vArr->quantity;
                                    break;
                                }
                            }
                        }
                    }
                    $amount = number_format($amount, 2);
                    $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                    // all store product amount into array
                    if ($amount == 0) {
                        $amountValue = "";
                    } else {
                        $amountValue = $amount;
                    }
                    array_push($itemMinPrrice, $amountValue);
                }
                // removing blank value from array
                $removeNullValues = array_filter($itemMinPrrice, function($value) {
                    return $value !== '';
                });
                // calculating excel cell Id
                if (count($removeNullValues) > 0) {
                    $lowAmtKey = array_search(min($removeNullValues), $removeNullValues);
                    for ($i = 1; $i <= $lowAmtKey; $i++) {
                        $itemColumn++;
                    }
                    $actualBlock = $itemColumn . ($k + 2);
                    array_push($highlitedColumn, $actualBlock);
                }
            }
        }
        $this->data['productlist'] = $estoreProducts;*/
        
        // $selectedproductList = [];
        // $selectedproductIds = [];
        // foreach ($selectedproductListRaw as $prodKey => $prodVal) {
        //     if (!in_array($prodVal->product_id, $selectedproductIds) && $prodVal->rsk_no != '') {
        //         array_push($selectedproductIds, $prodVal->product_id);
        //         array_push($selectedproductList, $prodVal);
        //     } elseif ($prodVal->rsk_no != '') {
        //         foreach ($selectedproductList as $ke => $val) {
        //             if ($val->product_id == $prodVal->product_id && $prodVal->quantity > $val->quantity) {
        //                 $selectedproductList[$ke]->quantity = $prodVal->quantity;
        //             }
        //         }
        //     }
        // }
        // $proRsk = [];
        // foreach ($selectedproductList as $v) {
        //     array_push($proRsk, $v->rsk_no);
        // }
        // $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);

        // $highlitedColumn = [];

        // if (count($selectedproductList) > 0) {
        //     foreach ($selectedproductList as $k => $v) {
        //         $itemMinPrrice = [];
        //         $itemColumn = 'D';
        //         $itemRow = $k + 1;

        //         $vArr = (object) $v;
        //         $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
        //         $estoreProducts[$k]["PRO_NAME"] = "$vArr->pro_name";
        //         $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
        //         foreach ($getAllStores as $key => $estore) {
        //             $amount = 0;
        //             foreach ($estore_Pro as $kV => $value) {
        //                 if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
        //                     $amount += $value->discountprice * $vArr->quantity;
        //                 }
        //             }
        //             foreach ($selectedproductListRaw as $prodKey => $prodVal) {
        //                 if ($prodVal->rsk_no == $vArr->rsk_no && $prodVal->user_id == $this->session->userdata("user_id")) {
        //                     $unserializedArr = unserialize($prodVal->price);
        //                     foreach ($unserializedArr as $storeId => $storeprice) {
        //                         if ($estore->id == $storeId) {
        //                             $amount = (float)$storeprice * (int)$vArr->quantity;
        //                             break;
        //                         }
        //                     }
        //                 }
        //             }
        //             $amount = number_format($amount, 2);
        //             $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
        //             // all store product amount into array
        //             if ($amount == 0) {
        //                 $amountValue = "";
        //             } else {
        //                 $amountValue = $amount;
        //             }
        //             array_push($itemMinPrrice, $amountValue);
        //         }
        //         // removing blank value from array
        //         $removeNullValues = array_filter($itemMinPrrice, function($value) {
        //             return $value !== '';
        //         });
        //         // calculating excel cell Id
        //         if (count($removeNullValues) > 0) {
        //             $lowAmtKey = array_search(min($removeNullValues), $removeNullValues);
        //             for ($i = 1; $i <= $lowAmtKey; $i++) {
        //                 $itemColumn++;
        //             }
        //             $actualBlock = $itemColumn . ($k + 2);
        //             array_push($highlitedColumn, $actualBlock);
        //         }
        //     }
        // }
        // $this->data['productlist'] = $estoreProducts;
        $this->data['post'] = !empty($_POST) ? $_POST : '';
        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        
        $this->data['model'] = $user;
        $html = $this->load->view('user/pdf_export_invoice_edited', $this->data, true);
        
        $this->load->library('pdf');
        $pdf = $this->pdf->pdf;
        $pdf->WriteHTML($html);
        $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        if ($_GET['action'] == 'pdf_export') {
            $pdf->Output("$output", 'D');
//            $pdf->Output();
            die;
        } else {
            // $path = 'https://filemanager.one.com/#info@vvsgroup.se/vvsoffert.se/files/assets/Invoice/' . $output;
            $path = FCPATH . 'uploads/invoices/' . $output;
            // print_r($path);
            // print_r($_POST['email']);
            $pdf->Output("$path", 'F');
            $to = $_POST['email'];
            // print_r($to);
            $message = "Hi,<br>
                Please find the attach file.</br></br>
                
                Regards,
                VvoSoffert Team
                ";

            $email_status = $this->email_invoice($to, $message, $path);
            if ($email_status == "true") {
                $this->data['content'] = $this->load->view('user/invoice_success_msg', $email_status, true);
                $this->load->view('layout', $this->data);
            }
        }
    }

    public function pdf_export_invoice_edited_new() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        ini_set('memory_limit', '256M');
        $invoice_id = $_GET['inv_id'];

        $invoice_info = $this->Invoice_histories_news_model->get_invoicebyid($invoice_id);

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        // var_dump($user);exit;
        $insert_data['user_id'] = $user->user_id;
        $this->preview_data['invoice_id'] = $invoice_id;
        $this->preview_data['user_name'] = $user->name;
        $this->preview_data['user_email'] = $user->email;
        
        $this->preview_data['art_ids'] = json_decode($invoice_info[0]->art_id);
        $this->preview_data['art_names'] = json_decode($invoice_info[0]->art_name);
        $this->preview_data['art_quatities'] = json_decode($invoice_info[0]->art_quantity);
        $this->preview_data['unit'] = json_decode($invoice_info[0]->unit);
        $this->preview_data['art_prices'] = json_decode($invoice_info[0]->sale_price_excl);
        $this->preview_data['sum_prices'] = json_decode($invoice_info[0]->sum_excl);

        $customer_id = $invoice_info[0]->customer_sel;
        $store_name = $invoice_info[0]->store_name_inv;
        $sel_store = explode ("-", $store_name);

        $invoice_date_value = $invoice_info[0]->invoice_date_value;

        $customer = $this->Customer_model->get_customersbycustomid($customer_id);
        
        $this->preview_data['customer_postcode']=$customer[0]->post_code?$customer[0]->post_code:'';
        $this->preview_data['customer_city']=$customer[0]->city?$customer[0]->city:'';
        $this->preview_data['customer_num']=$customer[0]->customer_num?$customer[0]->customer_num:'';
        $this->preview_data['note']=$customer[0]->note?$customer[0]->note:'';
        $this->preview_data['phone']=$customer[0]->phone_number?$customer[0]->phone_number:'';
        $this->preview_data['web_plats']=$customer[0]->web_address?$customer[0]->web_address:'';
        $this->preview_data['reverse_tax']=$customer[0]->reverse_tax?$customer[0]->reverse_tax:'';

        $this->preview_data['your_ref']=$invoice_info[0]->your_ref;
        $this->preview_data['our_ref']=$invoice_info[0]->our_ref;
        $this->preview_data['custom_ref']=$invoice_info[0]->custom_ref;
         
         $this->preview_data['company_name']='VVSGroup';
         $this->preview_data['customer_email']=$customer[0]->email?$customer[0]->email:'';
         $this->preview_data['company_email']=$customer[0]->ref_email_address?$customer[0]->ref_email_address:'';
         $this->preview_data['invoice_type']=$customer[0]->customer_type?$customer[0]->customer_type:'';

         $this->preview_data['invoice_number']=$invoice_info[0]->id;
         $this->preview_data['date_value']=$invoice_info[0]->invoice_date_value;
         $this->preview_data['delivery_date']=$invoice_info[0]->delivery_date_value;
         $this->preview_data['name']=$customer[0]->first_name?$customer[0]->first_name:''.' '.$customer[0]->last_name?$customer[0]->last_name:'';
         $this->preview_data['user_email']=$customer[0]->email?$customer[0]->email:'';
         $this->preview_data['special_comments']=$customer[0]->note?$customer[0]->note:'';
         $this->preview_data['total_sum']=$invoice_info[0]->total_sum;
         
        //var_dump($invoice_info);exit;
        
        //  $print_data['store_name']=$sel_store[0];
       
        $html = $this->load->view('user/pdf_export_invoice_edited', $this->preview_data, true);
        
        $this->load->library('pdf');
        $pdf = $this->pdf->pdf;
        $pdf->WriteHTML($html);
        $output = 'invoice' . date('Y_m_d_H_i_s') . '_.pdf';
        $action = 'pdf_export';
        if ($action == 'pdf_export') {
            $pdf->Output("$output", 'D');
//            $pdf->Output();
            //die;
        } else {
            // $path = 'https://filemanager.one.com/#info@vvsgroup.se/vvsoffert.se/files/assets/Invoice/' . $output;
            $path = FCPATH . 'uploads/invoices/' . $output;
            // print_r($path);
            // print_r($_POST['email']);
            $pdf->Output("$path", 'F');
            $to = $_POST['email'];
            // print_r($to);
            $message = "Hi,<br>
                Please find the attach file.</br></br>
                
                Regards,
                VvoSoffert Team
                ";

            $email_status = $this->email_invoice($to, $message, $path);
            if ($email_status == "true") {
                $this->data['content'] = $this->load->view('user/invoice_success_msg', $email_status, true);
                $this->load->view('layout', $this->data);
            }
        }
    }

    public function pdf_export_invoice_preview_new() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        ini_set('memory_limit', '256M');
        $invoice_id = $_GET['inv_id'];

        $invoice_info = $this->Invoice_histories_news_model->get_invoicebyid($invoice_id);

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        // var_dump($user);exit;
        $this->preview_data['invoice_id'] = $invoice_id;
        $insert_data['user_id'] = $user->user_id;
        $this->preview_data['user_name'] = $user->name;
        $this->preview_data['user_email'] = $user->email;
        
        $this->preview_data['art_ids'] = json_decode($invoice_info[0]->art_id);
        $this->preview_data['art_names'] = json_decode($invoice_info[0]->art_name);
        $this->preview_data['art_quatities'] = json_decode($invoice_info[0]->art_quantity);
        $this->preview_data['unit'] = json_decode($invoice_info[0]->unit);
        $this->preview_data['art_prices'] = json_decode($invoice_info[0]->sale_price_excl);
        $this->preview_data['sum_prices'] = json_decode($invoice_info[0]->sum_excl);

        $customer_id = $invoice_info[0]->customer_sel;
        $store_name = $invoice_info[0]->store_name_inv;
        $sel_store = explode ("-", $store_name);

        $invoice_date_value = $invoice_info[0]->invoice_date_value;

        $customer = $this->Customer_model->get_customersbycustomid($customer_id);
        //var_dump($customer);exit;
        //var_dump($invoice_info);exit;
        $this->preview_data['customer_postcode']=$customer[0]->post_code?$customer[0]->post_code:'';
        $this->preview_data['customer_city']=$customer[0]->city?$customer[0]->city:'';
        $this->preview_data['customer_num']=$customer[0]->customer_num?$customer[0]->customer_num:'';
        $this->preview_data['note']=$customer[0]->note?$customer[0]->note:'';
        $this->preview_data['phone']=$customer[0]->phone_number?$customer[0]->phone_number:'';
        $this->preview_data['web_plats']=$customer[0]->web_address?$customer[0]->web_address:'';
        $this->preview_data['reverse_tax']=$customer[0]->reverse_tax?$customer[0]->reverse_tax:'';

        $this->preview_data['your_ref']=$invoice_info[0]->your_ref;
        $this->preview_data['our_ref']=$invoice_info[0]->our_ref;
        $this->preview_data['custom_ref']=$invoice_info[0]->custom_ref;
         
         $this->preview_data['company_name']='VVSGroup';
         $this->preview_data['customer_email']=$customer[0]->email?$customer[0]->email:'';
         $this->preview_data['company_email']=$customer[0]->ref_email_address?$customer[0]->ref_email_address:'';
         $this->preview_data['invoice_type']=$customer[0]->customer_type?$customer[0]->customer_type:'';

         $this->preview_data['invoice_number']=$invoice_info[0]->id;
         $this->preview_data['date_value']=$invoice_info[0]->invoice_date_value;
         $this->preview_data['delivery_date']=$invoice_info[0]->delivery_date_value;
         $this->preview_data['name']=$customer[0]->first_name?$customer[0]->first_name:''.' '.$customer[0]->last_name?$customer[0]->last_name:'';
         $this->preview_data['user_email']=$customer[0]->email?$customer[0]->email:'';
         $this->preview_data['special_comments']=$customer[0]->note?$customer[0]->note:'';
         $this->preview_data['total_sum']=$invoice_info[0]->total_sum;
         
        //  $print_data['store_name']=$sel_store[0];
        // var_dump($this->data);exit;
        $this->data['content'] = $this->load->view('user/pdf_export_invoice_preview', $this->preview_data, true);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function pdf_export_offerter_preview_new() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        ini_set('memory_limit', '256M');
        $offerter_id = $_GET['inv_id'];

        //$invoice_info = $this->Invoice_histories_news_model->get_invoicebyid($offerter_id);
        $offerter_info = $this->Offerter_histories_news_model->get_offerterbyid($offerter_id);

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        // var_dump($user);exit;
        $this->preview_data['offerter_id'] = $offerter_id;
        $insert_data['user_id'] = $user->user_id;
        $this->preview_data['user_name'] = $user->name;
        $this->preview_data['user_email'] = $user->email;
        
        $this->preview_data['art_ids'] = json_decode($offerter_info[0]->art_id);
        $this->preview_data['art_names'] = json_decode($offerter_info[0]->art_name);
        $this->preview_data['art_quatities'] = json_decode($offerter_info[0]->art_quantity);
        $this->preview_data['unit'] = json_decode($offerter_info[0]->unit);
        $this->preview_data['art_prices'] = json_decode($offerter_info[0]->sale_price_excl);
        $this->preview_data['sum_prices'] = json_decode($offerter_info[0]->sum_excl);

        $customer_id = $offerter_info[0]->customer_sel;
        $store_name = $offerter_info[0]->store_name_inv;
        $sel_store = explode ("-", $store_name);

        $quote_date = $offerter_info[0]->quote_date;

        $customer = $this->Customer_model->get_customersbycustomid($customer_id);
        
        $this->preview_data['customer_postcode']=$customer[0]->post_code?$customer[0]->post_code:'';
        $this->preview_data['customer_city']=$customer[0]->city?$customer[0]->city:'';
        $this->preview_data['customer_num']=$customer[0]->customer_num?$customer[0]->customer_num:'';
        $this->preview_data['note']=$customer[0]->note?$customer[0]->note:'';
        $this->preview_data['phone']=$customer[0]->phone_number?$customer[0]->phone_number:'';
        $this->preview_data['web_plats']=$customer[0]->web_address?$customer[0]->web_address:'';
        $this->preview_data['reverse_tax']=$customer[0]->reverse_tax?$customer[0]->reverse_tax:'';

        
         
         $this->preview_data['company_name']='VVSGroup';
         $this->preview_data['customer_email']=$customer[0]->email?$customer[0]->email:'';
         $this->preview_data['company_email']=$customer[0]->ref_email_address?$customer[0]->ref_email_address:'';
         $this->preview_data['invoice_type']=$customer[0]->customer_type?$customer[0]->customer_type:'';

         
         $this->preview_data['name']=$customer[0]->first_name?$customer[0]->first_name:''.' '.$customer[0]->last_name?$customer[0]->last_name:'';
         $this->preview_data['user_email']=$customer[0]->email?$customer[0]->email:'';
         $this->preview_data['special_comments']=$customer[0]->note?$customer[0]->note:'';
        
        //var_dump($invoice_info);exit;
        

        $this->preview_data['your_ref']=$offerter_info[0]->your_ref;
        $this->preview_data['our_ref']=$offerter_info[0]->our_ref;
         
        
         $this->preview_data['invoice_number']=$offerter_info[0]->id;
         $this->preview_data['date_value']=$offerter_info[0]->quote_date;
         $this->preview_data['delivery_date']=$offerter_info[0]->valid_date;
         
         $this->preview_data['total_sum']=$offerter_info[0]->total_sum;
         
        //  $print_data['store_name']=$sel_store[0];
        // var_dump($this->data);exit;
        $this->data['content'] = $this->load->view('user/pdf_export_offerter_preview', $this->preview_data, true);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function pdf_export_offerter_edited_new() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        ini_set('memory_limit', '256M');
        $offerter_id = $_GET['inv_id'];

        //$invoice_info = $this->Invoice_histories_news_model->get_invoicebyid($offerter_id);
        $offerter_info = $this->Offerter_histories_news_model->get_offerterbyid($offerter_id);

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        // var_dump($user);exit;
        $this->preview_data['offerter_id'] = $offerter_id;
        $insert_data['user_id'] = $user->user_id;
        $this->preview_data['user_name'] = $user->name;
        $this->preview_data['user_email'] = $user->email;
        
        $this->preview_data['art_ids'] = json_decode($offerter_info[0]->art_id);
        $this->preview_data['art_names'] = json_decode($offerter_info[0]->art_name);
        $this->preview_data['art_quatities'] = json_decode($offerter_info[0]->art_quantity);
        $this->preview_data['unit'] = json_decode($offerter_info[0]->unit);
        $this->preview_data['art_prices'] = json_decode($offerter_info[0]->sale_price_excl);
        $this->preview_data['sum_prices'] = json_decode($offerter_info[0]->sum_excl);

        $customer_id = $offerter_info[0]->customer_sel;
        $store_name = $offerter_info[0]->store_name_inv;
        $sel_store = explode ("-", $store_name);

        $quote_date = $offerter_info[0]->quote_date;

        $customer = $this->Customer_model->get_customersbycustomid($customer_id);
        
        $this->preview_data['customer_postcode']=$customer[0]->post_code?$customer[0]->post_code:'';
        $this->preview_data['customer_city']=$customer[0]->city?$customer[0]->city:'';
        $this->preview_data['customer_num']=$customer[0]->customer_num?$customer[0]->customer_num:'';
        $this->preview_data['note']=$customer[0]->note?$customer[0]->note:'';
        $this->preview_data['phone']=$customer[0]->phone_number?$customer[0]->phone_number:'';
        $this->preview_data['web_plats']=$customer[0]->web_address?$customer[0]->web_address:'';
        $this->preview_data['reverse_tax']=$customer[0]->reverse_tax?$customer[0]->reverse_tax:'';

         $this->preview_data['company_name']='VVSGroup';
         $this->preview_data['customer_email']=$customer[0]->email?$customer[0]->email:'';
         $this->preview_data['company_email']=$customer[0]->ref_email_address?$customer[0]->ref_email_address:'';
         $this->preview_data['invoice_type']=$customer[0]->customer_type?$customer[0]->customer_type:'';

         
         $this->preview_data['name']=$customer[0]->first_name?$customer[0]->first_name:''.' '.$customer[0]->last_name?$customer[0]->last_name:'';
         $this->preview_data['user_email']=$customer[0]->email?$customer[0]->email:'';
         $this->preview_data['special_comments']=$customer[0]->note?$customer[0]->note:'';

         
        //var_dump($invoice_info);exit;
        

        $this->preview_data['your_ref']=$offerter_info[0]->your_ref;
        $this->preview_data['our_ref']=$offerter_info[0]->our_ref;
         
         

         $this->preview_data['invoice_number']=$offerter_info[0]->id;
         $this->preview_data['date_value']=$offerter_info[0]->quote_date;
         $this->preview_data['delivery_date']=$offerter_info[0]->valid_date;
         
         $this->preview_data['total_sum']=$offerter_info[0]->total_sum;
         
         $html = $this->load->view('user/pdf_export_offerter_edited', $this->preview_data, true);
        
         $this->load->library('pdf');
         $pdf = $this->pdf->pdf;
         $pdf->WriteHTML($html);
         $output = 'offerter' . date('Y_m_d_H_i_s') . '_.pdf';
         $action = 'pdf_export';
         if ($action == 'pdf_export') {
             $pdf->Output("$output", 'D');
 //            $pdf->Output();
             //die;
         } else {
             // $path = 'https://filemanager.one.com/#info@vvsgroup.se/vvsoffert.se/files/assets/Invoice/' . $output;
             $path = FCPATH . 'uploads/invoices/' . $output;
             // print_r($path);
             // print_r($_POST['email']);
             $pdf->Output("$path", 'F');
             $to = $_POST['email'];
             // print_r($to);
             $message = "Hi,<br>
                 Please find the attach file.</br></br>
                 
                 Regards,
                 VvoSoffert Team
                 ";
 
             $email_status = $this->email_invoice($to, $message, $path);
             if ($email_status == "true") {
                 $this->data['content'] = $this->load->view('user/invoice_success_msg', $email_status, true);
                 $this->load->view('layout', $this->data);
             }
         }
    }

    public function pdf_export_order_preview_new() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        ini_set('memory_limit', '256M');
        $order_id = $_GET['inv_id'];

        $order_info = $this->Order_histories_news_model->get_orderbyid($order_id);

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        // var_dump($user);exit;
        $this->preview_data['order_id'] = $order_id;
        $insert_data['user_id'] = $user->user_id;
        $this->preview_data['user_name'] = $user->name;
        $this->preview_data['user_email'] = $user->email;
        
        $this->preview_data['art_ids'] = json_decode($order_info[0]->art_id);
        $this->preview_data['art_names'] = json_decode($order_info[0]->art_name);
        $this->preview_data['art_quatities'] = json_decode($order_info[0]->art_quantity);
        $this->preview_data['unit'] = json_decode($order_info[0]->unit);
        $this->preview_data['art_prices'] = json_decode($order_info[0]->sale_price_excl);
        $this->preview_data['sum_prices'] = json_decode($order_info[0]->sum_excl);

        $customer_id = $order_info[0]->customer_sel;
        $store_name = $order_info[0]->store_name_inv;
        $sel_store = explode ("-", $store_name);

        $order_date = $order_info[0]->order_date;

        $customer = $this->Customer_model->get_customersbycustomid($customer_id);
        
        $this->preview_data['customer_postcode']=$customer[0]->post_code?$customer[0]->post_code:'';
        $this->preview_data['customer_city']=$customer[0]->city?$customer[0]->city:'';
        $this->preview_data['customer_num']=$customer[0]->customer_num?$customer[0]->customer_num:'';
        $this->preview_data['note']=$customer[0]->note?$customer[0]->note:'';
        $this->preview_data['phone']=$customer[0]->phone_number?$customer[0]->phone_number:'';
        $this->preview_data['web_plats']=$customer[0]->web_address?$customer[0]->web_address:'';
        $this->preview_data['reverse_tax']=$customer[0]->reverse_tax?$customer[0]->reverse_tax:'';

        
         $this->preview_data['company_name']='VVSGroup';
         $this->preview_data['customer_email']=$customer[0]->email?$customer[0]->email:'';
         $this->preview_data['company_email']=$customer[0]->ref_email_address?$customer[0]->ref_email_address:'';
         $this->preview_data['invoice_type']=$customer[0]->customer_type?$customer[0]->customer_type:'';

         
         $this->preview_data['name']=$customer[0]->first_name?$customer[0]->first_name:''.' '.$customer[0]->last_name?$customer[0]->last_name:'';
         $this->preview_data['user_email']=$customer[0]->email?$customer[0]->email:'';
         $this->preview_data['special_comments']=$customer[0]->note?$customer[0]->note:'';
         
         
        //var_dump($invoice_info);exit;
        

        $this->preview_data['your_ref']=$order_info[0]->your_ref;
        $this->preview_data['our_ref']=$order_info[0]->our_ref;
         
        
         $this->preview_data['invoice_number']=$order_info[0]->id;
         $this->preview_data['date_value']=$order_info[0]->order_date;
         $this->preview_data['delivery_date']=$order_info[0]->plan_delivery_date;
         
         $this->preview_data['total_sum']=$order_info[0]->total_sum;
         
        //  $print_data['store_name']=$sel_store[0];
        // var_dump($this->data);exit;
        $this->data['content'] = $this->load->view('user/pdf_export_order_preview', $this->preview_data, true);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function pdf_export_order_edited_new() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        ini_set('memory_limit', '256M');
        $order_id = $_GET['inv_id'];

        $order_info = $this->Order_histories_news_model->get_orderbyid($order_id);

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        // var_dump($user);exit;
        $this->preview_data['order_id'] = $order_id;
        $insert_data['user_id'] = $user->user_id;
        $this->preview_data['user_name'] = $user->name;
        $this->preview_data['user_email'] = $user->email;
        
        $this->preview_data['art_ids'] = json_decode($order_info[0]->art_id);
        $this->preview_data['art_names'] = json_decode($order_info[0]->art_name);
        $this->preview_data['art_quatities'] = json_decode($order_info[0]->art_quantity);
        $this->preview_data['unit'] = json_decode($order_info[0]->unit);
        $this->preview_data['art_prices'] = json_decode($order_info[0]->sale_price_excl);
        $this->preview_data['sum_prices'] = json_decode($order_info[0]->sum_excl);

        $customer_id = $order_info[0]->customer_sel;
        $store_name = $order_info[0]->store_name_inv;
        $sel_store = explode ("-", $store_name);

        $order_date = $order_info[0]->order_date;

        $customer = $this->Customer_model->get_customersbycustomid($customer_id);
        
        $this->preview_data['customer_postcode']=$customer[0]->post_code?$customer[0]->post_code:'';
        $this->preview_data['customer_city']=$customer[0]->city?$customer[0]->city:'';
        $this->preview_data['customer_num']=$customer[0]->customer_num?$customer[0]->customer_num:'';
        $this->preview_data['note']=$customer[0]->note?$customer[0]->note:'';
        $this->preview_data['phone']=$customer[0]->phone_number?$customer[0]->phone_number:'';
        $this->preview_data['web_plats']=$customer[0]->web_address?$customer[0]->web_address:'';
        $this->preview_data['reverse_tax']=$customer[0]->reverse_tax?$customer[0]->reverse_tax:'';

         $this->preview_data['company_name']='VVSGroup';
         $this->preview_data['customer_email']=$customer[0]->email?$customer[0]->email:'';
         $this->preview_data['company_email']=$customer[0]->ref_email_address?$customer[0]->ref_email_address:'';
         $this->preview_data['invoice_type']=$customer[0]->customer_type?$customer[0]->customer_type:'';

         
         $this->preview_data['name']=$customer[0]->first_name?$customer[0]->first_name:''.' '.$customer[0]->last_name?$customer[0]->last_name:'';
         $this->preview_data['user_email']=$customer[0]->email?$customer[0]->email:'';
         $this->preview_data['special_comments']=$customer[0]->note?$customer[0]->note:'';
         
         
        //var_dump($invoice_info);exit;
        

        $this->preview_data['your_ref']=$order_info[0]->your_ref;
        $this->preview_data['our_ref']=$order_info[0]->our_ref;
        

         $this->preview_data['invoice_number']=$order_info[0]->id;
         $this->preview_data['date_value']=$order_info[0]->order_date;
         $this->preview_data['delivery_date']=$order_info[0]->plan_delivery_date;
         
         $this->preview_data['total_sum']=$order_info[0]->total_sum;
         
         $html = $this->load->view('user/pdf_export_order_edited', $this->preview_data, true);
        
         $this->load->library('pdf');
         $pdf = $this->pdf->pdf;
         $pdf->WriteHTML($html);
         $output = 'order' . date('Y_m_d_H_i_s') . '_.pdf';
         $action = 'pdf_export';
         if ($action == 'pdf_export') {
             $pdf->Output("$output", 'D');
 //            $pdf->Output();
             //die;
         } else {
             // $path = 'https://filemanager.one.com/#info@vvsgroup.se/vvsoffert.se/files/assets/Invoice/' . $output;
             $path = FCPATH . 'uploads/invoices/' . $output;
             // print_r($path);
             // print_r($_POST['email']);
             $pdf->Output("$path", 'F');
             $to = $_POST['email'];
             // print_r($to);
             $message = "Hi,<br>
                 Please find the attach file.</br></br>
                 
                 Regards,
                 VvoSoffert Team
                 ";
 
             $email_status = $this->email_invoice($to, $message, $path);
             if ($email_status == "true") {
                 $this->data['content'] = $this->load->view('user/invoice_success_msg', $email_status, true);
                 $this->load->view('layout', $this->data);
             }
         }
    }

    

    public function email_invoice($to_email, $message, $file) {
        $this->load->library('email');
      //  $config['mailtype'] = 'html';
    //    $config['newline'] = "\r\n";
     //   $config['crlf'] = "\r\n";

        //$this->email->initialize($config);
       // $cc = "";
    //    $bcc = "mmuzammil45@gmail.com";
      //  $this->email->from('noreply.explorelogics@gmail.com', 'Vvsoffert Team');
    //    if (!empty($to_email)) {
     //       $this->email->to($to_email);
      //  }

       // $this->email->reply_to('noreply.explorelogics@gmail.com', 'Vvosoffert Team');
        //if (!empty($bcc)) {
        //    $this->email->bcc($bcc);
        //}


        $this->email->to($to_email);
        $this->email->from('info@vvsoffert.se','vvsoffert');
        $this->email->subject('Invoice from Vvosoffert');
        $this->email->message($message);

        if ($file != '') {
            $this->email->attach($file);
        }
        try {
        $mail_status = $this->email->send();
        if (!$mail_status) {
            return $this->email->print_debugger();
        } else {
            return 'true';
        }                } catch (Exception $e) {
               print_r($e->getMessage());
                }
    }

    public function pdf_export() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $id = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        // load library
        $this->load->library('pdf');
        $pdf = $this->pdf->pdf;
        //$pdf->debug = true;
        // retrieve data from model
        $data['productlist'] = getjoinlist_product($id);
        $data['singlelist'] = $this->ListMaster_model->get($id);

        // boost the memory limit if it's low ;)
        $html = $this->load->view('user/pdf_export', $data, true);
        // render the view into HTML
        $pdf->WriteHTML($html);
        // write the HTML into the PDF
        $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
//        $pdf->Output("$output", 'D');
    }

    public function export_excel() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $listId = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        $stores = [];
        $estoreProducts = [];
        $getAllStores = $this->Estore_model->all_store();

        $productList = $this->ListMaster_model->getListProduct($listId);
        $idsArr = [];
        foreach ($productList as $productListKey => $productListValue) {
            array_push($idsArr, $productListValue->product_id);
        }
        $ids = implode(',', $idsArr);
        $selectedproductListRaw = $this->ListMaster_model->getSelectedListProductByUserId($ids, $this->session->userdata("user_id"));
//        $selectedproductListRaw = $this->ListMaster_model->getListProductByUserId($listId, $this->session->userdata("user_id"));

        $proRsk = [];
        foreach ($productList as $v) {
            array_push($proRsk, $v->rsk_no);
        }
        $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);

        $highlitedColumn = [];

        if (count($productList) > 0) {
            foreach ($productList as $k => $v) {
                $itemMinPrrice = [];
                $itemColumn = 'D';
                $itemRow = $k + 1;

                $vArr = (object) $v;
                $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
                $estoreProducts[$k]["PRO_NAME"] = "$vArr->pro_name";
                $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                foreach ($getAllStores as $key => $estore) {
                    $amount = 0;
                    foreach ($estore_Pro as $kV => $value) {
                        if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
                            $amount += $value->discountprice * $vArr->quantity;
                        }
                    }
                    foreach ($selectedproductListRaw as $prodKey => $prodVal) {
                        if ($prodVal->rsk_no == $vArr->rsk_no && $prodVal->user_id == $this->session->userdata("user_id")) {
                            $unserializedArr = unserialize($prodVal->price);
                            foreach ($unserializedArr as $storeId => $storeprice) {
                                if ($estore->id == $storeId) {
                                    $amount = $storeprice * $vArr->quantity;
                                    break;
                                }
                            }
                        }
                    }
                    //$amount = number_format($amount, 2);
                    $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                    // all store product amount into array
                    if ($amount == 0) {
                        $amountValue = "";
                    } else {
                        $amountValue = $amount;
                    }
                    array_push($itemMinPrrice, $amountValue);
                }
                // removing blank value from array
                $removeNullValues = array_filter($itemMinPrrice, function($value) {
                    return $value !== '';
                });
                // calculating excel cell Id
                if (count($removeNullValues) > 0) {
                    $lowAmtKey = array_search(min($removeNullValues), $removeNullValues);
                    for ($i = 1; $i <= $lowAmtKey; $i++) {
                        $itemColumn++;
                    }
                    $actualBlock = $itemColumn . ($k + 2);
                    array_push($highlitedColumn, $actualBlock);
                }
            }
        }
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('E-butik Produkter Prislista');

        $this->excel->getActiveSheet()->setCellValue('A1', 'ARTIKLE NUMMER');
        $this->excel->getActiveSheet()->setCellValue('B1', 'PRODUKTNAMN');
        $this->excel->getActiveSheet()->setCellValue('C1', 'KVANTITET');
        $char = "D";
        foreach ($getAllStores as $key => $estore) {
            $cell = $char . '1';
            $this->excel->getActiveSheet()->setCellValue("$cell", "$estore->name");
            $this->excel->getActiveSheet()->getStyle("$cell")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //make the font become bold
            $this->excel->getActiveSheet()->getStyle("$cell")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("$cell")->getFont()->setSize(16);
            $this->excel->getActiveSheet()->getStyle("$cell")->getFill()->getStartColor()->setARGB('#333');
            $char ++;
        }

        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setARGB('#333');
        $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('C1')->getFill()->getStartColor()->setARGB('#333');
//        for ($col = ord('A'); $col <= ord('C'); $col++) { //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
//            //change the font size
//            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
//
//            $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//        }

        $exceldata = array();
        foreach ($estoreProducts as $row) {
            $row = (array) $row;
            $exceldata[] = $row;
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A2');

//        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// set cell background color
        foreach ($highlitedColumn as $vHigh) {
            $this->excel->getActiveSheet()->getStyle($vHigh)->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => "#FFE468"
                )
            ));
//            $this->excel->getActiveSheet()->getStyle("$vHigh")->getFill()->getStartColor()->setARGB('#DD0000');
        }
        foreach (range('A', $this->excel->getActiveSheet()->getHighestDataColumn()) as $col) {
            $this->excel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        $filename = 'E-butik Produkter Prislista.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function export_excel_new() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        //$listId = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        $stores = [];
        $estoreProducts = [];
        $getAllStores = $this->Estore_model->all_store();

        // $articles = $this->Article_model->get_articles($this->session->userdata("user_id"));
        // $idsArr=[];
        // foreach($articles as $key=> $article){
        //     array_push($idsArr, $article->id);
        // }
        // $ids =  implode(',',$idsArr);

        // if(count($articles)>0){
        //     foreach($articles as $key => $article){
        //         $itemMinPrice = [];
        //         $itemColumn = 'D';
        //         $itemRow = $key + 1;
        //         $articleArr = (object) $article;
        //         $estoreProducts[$key]["RSK_NO"] = $articleArr->art_num;
        //         $estoreProducts[$key]["PRO_NAME"] = $articleArr->art_name;
        //         $estoreProducts[$key]["QUANTITY"] =$articleArr->stock_bal;
        //         foreach($getAllStores as $key => $estore) {
        //             $amount = 0;
        //             //for
        //         }

        //     }
        // }
        $selectedproductListRaw = $this->ListMaster_model->getSelectedListProductByUserId($ids, $this->session->userdata("user_id"));
//        $selectedproductListRaw = $this->ListMaster_model->getListProductByUserId($listId, $this->session->userdata("user_id"));
        $proRsk = [];
        foreach ($productList as $v) {
            array_push($proRsk, $v->rsk_no);
        }
        $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);

        $highlitedColumn = [];

        if (count($productList) > 0) {
            foreach ($productList as $k => $v) {
                $itemMinPrrice = [];
                $itemColumn = 'D';
                $itemRow = $k + 1;

                $vArr = (object) $v;
                $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
                $estoreProducts[$k]["PRO_NAME"] = "$vArr->pro_name";
                $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                foreach ($getAllStores as $key => $estore) {
                    $amount = 0;
                    foreach ($estore_Pro as $kV => $value) {
                        if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
                            $amount += $value->discountprice * $vArr->quantity;
                        }
                    }
                    foreach ($selectedproductListRaw as $prodKey => $prodVal) {
                        if ($prodVal->rsk_no == $vArr->rsk_no && $prodVal->user_id == $this->session->userdata("user_id")) {
                            $unserializedArr = unserialize($prodVal->price);
                            foreach ($unserializedArr as $storeId => $storeprice) {
                                if ($estore->id == $storeId) {
                                    $amount = $storeprice * $vArr->quantity;
                                    break;
                                }
                            }
                        }
                    }
                    //$amount = number_format($amount, 2);
                    $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                    // all store product amount into array
                    if ($amount == 0) {
                        $amountValue = "";
                    } else {
                        $amountValue = $amount;
                    }
                    array_push($itemMinPrrice, $amountValue);
                }
                // removing blank value from array
                $removeNullValues = array_filter($itemMinPrrice, function($value) {
                    return $value !== '';
                });
                // calculating excel cell Id
                if (count($removeNullValues) > 0) {
                    $lowAmtKey = array_search(min($removeNullValues), $removeNullValues);
                    for ($i = 1; $i <= $lowAmtKey; $i++) {
                        $itemColumn++;
                    }
                    $actualBlock = $itemColumn . ($k + 2);
                    array_push($highlitedColumn, $actualBlock);
                }
            }
        }
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('E-butik Produkter Prislista');

        $this->excel->getActiveSheet()->setCellValue('A1', 'RSK NUMMER');
        $this->excel->getActiveSheet()->setCellValue('B1', 'PRODUKTNAMN');
        $this->excel->getActiveSheet()->setCellValue('C1', 'KVANTITET');
        $char = "D";
        foreach ($getAllStores as $key => $estore) {
            $cell = $char . '1';
            $this->excel->getActiveSheet()->setCellValue("$cell", "$estore->name");
            $this->excel->getActiveSheet()->getStyle("$cell")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //make the font become bold
            $this->excel->getActiveSheet()->getStyle("$cell")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("$cell")->getFont()->setSize(16);
            $this->excel->getActiveSheet()->getStyle("$cell")->getFill()->getStartColor()->setARGB('#333');
            $char ++;
        }

        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setARGB('#333');
        $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('C1')->getFill()->getStartColor()->setARGB('#333');
//        for ($col = ord('A'); $col <= ord('C'); $col++) { //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
//            //change the font size
//            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
//
//            $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//        }

        $exceldata = array();
        foreach ($estoreProducts as $row) {
            $row = (array) $row;
            $exceldata[] = $row;
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A2');

//        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// set cell background color
        foreach ($highlitedColumn as $vHigh) {
            $this->excel->getActiveSheet()->getStyle($vHigh)->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => "#89C0C7"
                )
            ));
//            $this->excel->getActiveSheet()->getStyle("$vHigh")->getFill()->getStartColor()->setARGB('#DD0000');
        }
        foreach (range('A', $this->excel->getActiveSheet()->getHighestDataColumn()) as $col) {
            $this->excel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        $filename = 'E-butik Produkter Prislista.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function change_password() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $data_msg = array();
        $update = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        if ($this->input->post('submit')) {
            $submit = $this->input->post('submit');
//            if ($submit == "Change Password") {
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|callback_password_matches');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]|max_length[15]');
            $this->form_validation->set_rules('cn_password', 'Confirm Password', 'required|min_length[8]|max_length[15]|matches[new_password]');
            $checkpass = $this->db->query("SELECT password FROM user_master WHERE user_id = " . $this->session->userdata("user_id"))->row()->password;
            if (md5($this->input->post('old_password')) != $checkpass) {
                $this->form_validation->set_message('old_password', 'Sorry Your Old Password Dose not match.');
            }
            if ($this->form_validation->run() == TRUE) {
                $update->password = md5($this->input->post('cn_password'));
                $this->Login_model->update($update->user_id, $update);
                $session_message['type'] = 1;
                $session_message['title'] = 'Framgång!';
                $session_message['content'] = 'Your Password has been successfully saved.';
                $this->session->set_flashdata('message', $session_message);
            }
//            }
        }

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;

        $this->data['content'] = $this->load->view('user/change_password', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);
    }

    function password_matches($rows) {

        $checkpass = $this->db->query("SELECT password FROM user_master WHERE user_id = " . $this->session->userdata("user_id"))->row()->password;
        if (md5($this->input->post('old_password')) != $checkpass) {//didnt find any
            $this->form_validation->set_message('password_matches', 'Old Password Dose Not match');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_list($id = 0) {
        if (empty($id)) {
            redirect('user/add_list');
        }
        $groupInfo = $this->ListMaster_model->delete_list($id);
        $session_message['type'] = 1;
        $session_message['title'] = 'Framgång!';
        $session_message['content'] = 'List has been successfully deleted.';
        $this->session->set_flashdata('message', $session_message);
        redirect('user/add_list');
    }

    public function delete_list_product() {
        $id = $_GET['id'];
        $list_id = $_GET['list_id'];
        if (empty($id)) {
            redirect('user/add_list');
        }
        $groupInfo = delete_product_from_user_list($id);
        $session_message['type'] = 1;
        $session_message['title'] = 'Framgång!';
        $session_message['content'] = 'Product has been successfully deleted.';
        $this->session->set_flashdata('message', $session_message);
        redirect(site_url('list-details') . '?id=' . $list_id);
    }

    public function import_product_rsk_excel() {
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));

        $this->data['allList'] = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;
        $proReqData = $this->Estore_model->get_user_request_pro_list_track($this->session->userdata("user_id"));
        $this->data['proReqData'] = $proReqData;

        if ($this->input->method(TRUE) == "POST") {
            $error = false;
            $productRSK = [];

            $lestId = isset($_POST["user_list"]) ? trim($_POST["user_list"]) : 0;
            if ($lestId > 0) {
                if (isset($_FILES['import_product_rsk_file'])) {
                    if ($_FILES['import_product_rsk_file']['error'] == 0) {
                        $imgExt = array("xls", 'xlsx', 'csv');

                        $imgArr = explode('.', $_FILES['import_product_rsk_file']['name']);
                        $uploadedFileExt = end($imgArr);

                        if (in_array(strtolower($uploadedFileExt), $imgExt)) {
                            $filePathArr = explode("controllers", __FILE__);
                            require_once($filePathArr[0] . '/libraries/excel-reader/php-excel-reader/excel_reader2.php');
                            require_once($filePathArr[0] . '/libraries/excel-reader/SpreadsheetReader.php');
                            $fileName = time() . "_" . $_FILES['import_product_rsk_file']['name'];
                            $uploadPath = FCPATH . '/uploads/import_file/';

                            if (move_uploaded_file($_FILES['import_product_rsk_file']['tmp_name'], $uploadPath . $fileName)) {

                                try {
                                    $Spreadsheet = new SpreadsheetReader($uploadPath . $fileName);

                                    $Sheets = $Spreadsheet->Sheets();

                                    $Spreadsheet->ChangeSheet($Sheets[0]);
                                    foreach ($Spreadsheet as $Key => $Row) {
                                        if (trim($Row[0]) != "") {
                                            if ($Key == 0) {
                                                if (strcasecmp(strtolower(str_replace(" ", "", $Row[0])), strtolower("PRODUKTRSK")) == 0 && strcasecmp(strtolower(str_replace(" ", "", $Row[1])), strtolower("KVANTITET")) == 0) {
                                                    
                                                } else {
                                                    $error = true;
                                                    break;
                                                }
                                            } else {
                                                $productRSK["pro_rsk"] = str_replace(" ", "", trim($Row[0]));
                                                $productRSK["quantity"] = number_format(trim($Row[1]), 0);
                                                $productRSK["list_id"] = trim($lestId);
                                                $this->ListMaster_model->insert_into_product_list($productRSK);
                                            }
                                            if ($error == true) {
                                                break;
                                            }
                                        } else {
                                            $error = true;
                                            break;
                                        }
                                    }
                                    if ($error == true) {
                                        $session_message['type'] = 2;
                                        $session_message['title'] = 'Varning!';
                                        $session_message['content'] = 'Excel / CSV-filkolumner matchar inte.';
                                        $this->session->set_flashdata('error', $session_message);
                                        unlink($uploadPath . $fileName);
                                        redirect($this->uri->uri_string());
                                    } else {
                                        $session_message['type'] = 1;
                                        $session_message['title'] = 'Framgång!';
                                        $session_message['content'] = 'Din produktlista har laddats upp.';
                                        $this->session->set_flashdata('message', $session_message);
                                        redirect($this->uri->uri_string());
                                    }
                                } catch (Exception $E) {
                                    echo $E->getMessage();
                                }
                                unlink($uploadPath . $fileName);
                            }
                        } else {
                            $session_message['type'] = 2;
                            $session_message['title'] = 'Varning!';
                            $session_message['content'] = "Endast filer med följande tillägg accepteras: xls, xlsx, csv";
                            $this->session->set_flashdata('error', $session_message);
                            redirect($this->uri->uri_string());
                        }
                    } else {
                        $session_message['type'] = 2;
                        $session_message['title'] = 'Varning!';
                        $session_message['content'] = "Uppladdat filfel. Var god försök igen.";
                        $this->session->set_flashdata('error', $session_message);
                        redirect($this->uri->uri_string());
                    }
                } else {
                    $session_message['type'] = 2;
                    $session_message['title'] = 'Varning!';
                    $session_message['content'] = "Din förfrågan kan inte proceduren";
                    $this->session->set_flashdata('error', $session_message);
                    redirect($this->uri->uri_string());
                }
            } else {
                $session_message['type'] = 2;
                $session_message['title'] = 'Varning!';
                $session_message['content'] = "Du har inte valt någon lista";
                $this->session->set_flashdata('error', $session_message);
                redirect($this->uri->uri_string());
            }
        }

        $this->data['content'] = $this->load->view('user/import-product-rsk', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function import_product_rsk_price_excel() {
        // Total Groups
        $_s_key = "";
        $_s_sort_by = "t.name";
        $_s_order_by = "ASC";

        $resp['crntPage'] = $_page_no = 1;

        $resp['_limit'] = $_limit = self::LIMIT_PER_PAGE;

        $resp['total_stores'] = $total_stores = $this->Estore_model->count_total_store($_s_key);
        $resp['storeData'] = $storeData = $this->Estore_model->get_search_store_result($_s_key, $_limit, $_page_no, $_s_sort_by, $_s_order_by);

        if (($total_stores % $_limit) == 0) {
            $totalPages = $total_stores / $_limit;
        } else {
            $totalPages = floor($total_stores / $_limit) + 1;
        }
        $resp['totalPages'] = $totalPages;

        $data['content'] = $this->load->view('user/e-store', $resp, TRUE);
        $this->load->view('layout_sidebar', $data);
    }

    public function import_product_rsk_estore_price_excel($store_id) {
        ini_set('max_execution_time', 0);
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));

        $this->data['allList'] = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;
        $proReqData = $this->Estore_model->get_user_request_pro_list_track($this->session->userdata("user_id"));
        $this->data['proReqData'] = $proReqData;

        if ($this->input->method(TRUE) == "POST") {
            $error = false;
            $productRSK = [];

//            $lestId = isset($_POST["user_list"]) ? trim($_POST["user_list"]) : 0;
//            if ($lestId > 0) {
            if (isset($_FILES['import_product_rsk_file'])) {
                if ($_FILES['import_product_rsk_file']['error'] == 0) {
                    $imgExt = array("xls", 'xlsx', 'csv');

                    $imgArr = explode('.', $_FILES['import_product_rsk_file']['name']);
                    $uploadedFileExt = end($imgArr);

                    if (in_array(strtolower($uploadedFileExt), $imgExt)) {
                        $filePathArr = explode("controllers", __FILE__);
                        require_once($filePathArr[0] . '/libraries/excel-reader/php-excel-reader/excel_reader2.php');
                        require_once($filePathArr[0] . '/libraries/excel-reader/SpreadsheetReader.php');
                        $fileName = time() . "_" . $_FILES['import_product_rsk_file']['name'];
                        $uploadPath = FCPATH . '/uploads/import_file/';

                        if (move_uploaded_file($_FILES['import_product_rsk_file']['tmp_name'], $uploadPath . $fileName)) {

                            try {
                                $Spreadsheet = new SpreadsheetReader($uploadPath . $fileName);

                                $Sheets = $Spreadsheet->Sheets();

                                $Spreadsheet->ChangeSheet($Sheets[0]);
                                foreach ($Spreadsheet as $Key => $Row) {
                                    if (trim($Row[0]) != "") {
                                        if ($Key == 0) {
                                            if (strcasecmp(strtolower(str_replace(" ", "", $Row[0])), strtolower("PRODUKTRSK")) == 0 && strcasecmp(strtolower(str_replace(" ", "", $Row[1])), strtolower("REAPRIS")) == 0) {
                                                
                                            } else {
                                                $error = true;
                                                break;
                                            }
                                        } else {
                                            $array = [];
                                            $array[$store_id] = trim($Row[1]);
                                            $productRSK["pro_rsk"] = str_replace(" ", "", trim($Row[0]));
                                            $productRSK["price"] = $array;
//                                                $productRSK["list_id"] = trim($lestId);
                                            $productRSK["user_id"] = trim($this->session->userdata("user_id"));
                                            $this->ListMaster_model->insert_into_product_list_price($productRSK);
                                        }
                                        if ($error == true) {
                                            break;
                                        }
                                    } else {
                                        $error = true;
                                        break;
                                    }
                                }
                                if ($error == true) {
                                    $session_message['type'] = 2;
                                    $session_message['title'] = 'Varning!';
                                    $session_message['content'] = 'Excel / CSV-filkolumner matchar inte.';
                                    $this->session->set_flashdata('error', $session_message);
                                    unlink($uploadPath . $fileName);
                                    redirect($this->uri->uri_string());
                                } else {
                                    $session_message['type'] = 1;
                                    $session_message['title'] = 'Framgång!';
                                    $session_message['content'] = 'Din produktlista har laddats upp.';
                                    $this->session->set_flashdata('message', $session_message);
                                    redirect($this->uri->uri_string());
                                }
                            } catch (Exception $E) {
                                echo $E->getMessage();
                            }
                            unlink($uploadPath . $fileName);
                        }
                    } else {
                        $session_message['type'] = 2;
                        $session_message['title'] = 'Varning!';
                        $session_message['content'] = "Endast filer med följande tillägg accepteras: xls, xlsx, csv";
                        $this->session->set_flashdata('error', $session_message);
                        redirect($this->uri->uri_string());
                    }
                } else {
                    $session_message['type'] = 2;
                    $session_message['title'] = 'Varning!';
                    $session_message['content'] = "Uppladdat filfel. Var god försök igen.";
                    $this->session->set_flashdata('error', $session_message);
                    redirect($this->uri->uri_string());
                }
            } else {
                $session_message['type'] = 2;
                $session_message['title'] = 'Varning!';
                $session_message['content'] = "Din förfrågan kan inte proceduren";
                $this->session->set_flashdata('error', $session_message);
                redirect($this->uri->uri_string());
            }
//            } else {
//                $session_message['type'] = 2;
//                $session_message['title'] = 'Varning!';
//                $session_message['content'] = "Du har inte valt någon lista";
//                $this->session->set_flashdata('error', $session_message);
//                redirect($this->uri->uri_string());
//            }
        }

        $this->data['content'] = $this->load->view('user/import-product-rsk-estore-price', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function cost_caclulator() {


        if(!$this->session->userdata("user_id")) {

            redirect('logga-in');

        } else {

            $this->data['all_plumbing_services'] = $this->Plumbing_service_model->get_all_plumbing_services();

            $this->data['all_plumbing_service_prices'] = $this->Plumbing_service_price_model->get_all_plumbing_service_prices();

            $this->data['content'] = $this->load->view('user/cost-calculator', $this->data, true);
            $this->load->view('layout_sidebar', $this->data);

        }


    }

    

    public function service_prices() {

        $response = array();

        try {

            $psId = $this->input->get('psid');

            $service_prices = $this->Plumbing_service_price_model->get_plumbing_service_prices($psId);

            $response['status'] = 200;
            $response['servicePrices'] = $service_prices;
            $response['count'] = (!empty($service_prices)) ? count($service_prices) : 0;

            $responseJSON = json_encode($response);

            echo $responseJSON;
            die();


        } catch(Exception $ex) {

            $response['status'] = 500;
            $response['servicePrices'] = null;
            $response['count'] = 0;
            $response['message'] = $ex->getMessage();

            $responseJSON = json_encode($response);

            echo $responseJSON;
            die();

        }
        
    }
    
    public function add_new_project(){
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        if ($this->input->post()) {
            
            $name = $this->input->post('name');
            // print_r ($submit);
//            if ($submit == "submit") {
            $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[list_master.name]');
            if ($this->form_validation->run() == TRUE) {

                $update->user_id = $this->session->userdata("user_id");
                $update->name = $this->input->post('name');
                $update->status = 1;
                $update->created_at = date('Y-m-d H:i:s');
                $this->ListMaster_model->insert($update);

                $session_message['type'] = 1;
                $session_message['title'] = 'Framgång!';
                $session_message['content'] = 'Listan har sparats.';
                $this->session->set_flashdata('message', $session_message);
            } else {
                $this->session->set_flashdata('error', $this->form_validation->error_array());
            }
//            }
        }
        // $this->session->set_flashdata('error', '');
        $all_list = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));
        $this->data['model'] = $all_list;

        $this->data['content'] = $this->load->view('user/list_index', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);

    }
    
    public function company_settings() {

        if(!$this->session->userdata("user_id")) {

            redirect('logga-in');

        } else {

            //$this->data['content'] = $this->load->view('user/cost-calculator', $this->data, true);
            $com_list = $this->SetCompany_model->get_by_user_id($this->session->userdata("user_id"));
            $this->data['model'] = $com_list;
            $this->data['content'] = $this->load->view('user/company_settings',  $this->data['model'], true);
            //print_r($this->data['content']);exit;
            $this->load->view('layout_sidebar', $this->data);

        }


    }

    public function invoice_settings() {

        if(!$this->session->userdata("user_id")) {

            redirect('logga-in');

        } else {

            //$this->data['content'] = $this->load->view('user/cost-calculator', $this->data, true);
            $invoice_list = $this->SetInvoice_model->get_by_user_id($this->session->userdata("user_id"));
            $this->data['model'] = $invoice_list;
            $this->data['content'] = $this->load->view('user/invoice_settings',  $this->data['model'], true);
            //print_r($this->data['content']);exit;
            $this->load->view('layout_sidebar', $this->data);

        }


    }
    
    public function set_company(){
        $data = $_REQUEST;
        //var_dump($data);exit;
        
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        if ($this->input->post()) {
            
            // $name = $this->input->post('name');
            // $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[list_master.name]');
            // if ($this->form_validation->run() == TRUE) {
                // if($data['use_quote']=="on"){
                //     $data['use_quote']="checked";
                // }else{
                //     $data['use_quote']="";
                // }
                // if($data['use_order']=="on"){
                //     $data['use_order']="checked";
                // }else{
                //     $data['use_order']="";
                // }
                $data['user_id'] = $this->session->userdata("user_id");
                $data['created_at'] = date('Y-m-d H:i:s');
                $com_list = $this->SetCompany_model->get_by_user_id($this->session->userdata("user_id"));
                if($com_list){ 
                    $this->SetCompany_model->update($data,$this->session->userdata("user_id"));
                }else{
                    $this->SetCompany_model->insert($data);
                    
                }

                $session_message['type'] = 1;
                $session_message['title'] = 'Framgång!';
                $session_message['content'] = 'Company settings has been successfully saved.';
                $this->session->set_flashdata('message', $session_message);
            // } else {
            //     $this->session->set_flashdata('error', $this->form_validation->error_array());
            // }
            //}
        }
        $com_list = $this->SetCompany_model->get_by_user_id($this->session->userdata("user_id"));
        $this->data['model'] = $com_list;

        $this->data['content'] = $this->load->view('user/company_settings', $this->data, true);
        //$this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);

    }

    public function set_invoice(){
        $data = $_REQUEST;
        //var_dump($data);exit;
        
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        if ($this->input->post()) {
            
            // $name = $this->input->post('name');
            // $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[list_master.name]');
            // if ($this->form_validation->run() == TRUE) {
                if($data['has_ftax']=="on"){
                    $data['has_ftax']="checked";
                }else{
                    $data['has_ftax']="";
                }
                if($data['vat_reserve']=="on"){
                    $data['vat_reserve']="checked";
                }else{
                    $data['vat_reserve']="";
                }
                if($data['vat_triangle']=="on"){
                    $data['vat_triangle']="checked";
                }else{
                    $data['vat_triangle']="";
                }
                if($data['telecom']=="on"){
                    $data['telecom']="checked";
                }else{
                    $data['telecom']="";
                }
                if($data['show_price']=="on"){
                    $data['show_price']="checked";
                }else{
                    $data['show_price']="";
                }
                if($data['domestic_service']=="on"){
                    $data['domestic_service']="checked";
                }else{
                    $data['domestic_service']="";
                }
                if($data['charge_reminder']=="on"){
                    $data['charge_reminder']="checked";
                }else{
                    $data['charge_reminder']="";
                }
                if($data['edit_purchase_invoice']=="on"){
                    $data['edit_purchase_invoice']="checked";
                }else{
                    $data['edit_purchase_invoice']="";
                }
                if($data['use_outgoing_payment']=="on"){
                    $data['use_outgoing_payment']="checked";
                }else{
                    $data['use_outgoing_payment']="";
                }
                if($data['debit_purchase_invoice']=="on"){
                    $data['debit_purchase_invoice']="checked";
                }else{
                    $data['debit_purchase_invoice']="";
                }
                $data['user_id'] = $this->session->userdata("user_id");
                $data['created_at'] = date('Y-m-d H:i:s');
                $invoice_list = $this->SetInvoice_model->get_by_user_id($this->session->userdata("user_id"));
                if($invoice_list){ 
                    $this->SetInvoice_model->update($data,$this->session->userdata("user_id"));
                }else{
                    $this->SetInvoice_model->insert($data);
                    
                }

                $session_message['type'] = 1;
                $session_message['title'] = 'Framgång!';
                $session_message['content'] = 'Company settings has been successfully saved.';
                $this->session->set_flashdata('message', $session_message);
            // } else {
            //     $this->session->set_flashdata('error', $this->form_validation->error_array());
            // }
            //}
        }
        $invoice_list = $this->SetInvoice_model->get_by_user_id($this->session->userdata("user_id"));
        $this->data['model'] = $invoice_list;

        $this->data['content'] = $this->load->view('user/invoice_settings', $this->data, true);
        //$this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);

    }

    public function edit_project() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $id = base64_decode($_GET['id']);
        $data_msg = array();
        if ($this->input->post()) {
            // $id = $_POST['id'];
            $name = $this->input->post('name');
//            if ($submit == "submit") {
            $original_value = $this->db->query("SELECT * FROM list_master WHERE id = ".$id)->row()->name;
            if ($this->input->post('name') != $original_value) {
                $is_unique = '|is_unique[list_master.name]';
            } else {
                $is_unique = '';
            }
            $this->form_validation->set_rules('name', 'Name', 'trim|required' . $is_unique);
            if ($this->form_validation->run() == TRUE) {

                $update->user_id = $this->session->userdata("user_id");
                $update->name = $this->input->post('name');
                $update->status = 1;
                $update->created_at = date('Y-m-d H:i:s');
                $this->ListMaster_model->update($update, $id);

                $session_message['type'] = 1;
                $session_message['title'] = 'Framgång!';
                $session_message['content'] = 'List has been successfully updated.';
                $this->session->set_flashdata('message', $session_message);
            } else {
                $this->session->set_flashdata('error', $this->form_validation->error_array());
            }
//            }
        }

        $all_list = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));
        $singlelist = $this->ListMaster_model->get($id);
        $this->data['model'] = $all_list;
        $this->data['singlelist'] = $singlelist;

        $this->data['content'] = $this->load->view('user/list_index', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);
    }
    
    public function list_invoice_ajax() {

       if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $listId = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        $stores = [];
        $estoreProducts = [];
        $getAllStores = $this->Estore_model->all_store();
        $tmp =[];
        $productList = $this->ListMaster_model->getListProduct($listId);
        foreach($productList as $v){
            array_push($tmp, $v->product_id);
            
        }
        $ids = implode(",", $tmp);
        $selectedproductListRaw = $this->ListMaster_model->getSelectedListProduct($ids);

        $selectedproductList = [];
        $selectedproductIds = [];
       foreach ($selectedproductListRaw as $prodKey => $prodVal) {
            if (!in_array($prodVal->product_id, $selectedproductIds) && $prodVal->rsk_no != '') {
                array_push($selectedproductIds, $prodVal->product_id);
                array_push($selectedproductList, $prodVal);
            } elseif ($prodVal->rsk_no != '') {
                foreach ($selectedproductList as $ke => $val) {
                    if ($val->product_id == $prodVal->product_id && $prodVal->quantity > $val->quantity) {
                        $selectedproductList[$ke]->quantity = $prodVal->quantity;
                    }
                }
            }
        }
        $proRsk = [];
        foreach ($selectedproductList as $v) {
            array_push($proRsk, $v->rsk_no);
        }
        $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);

        $highlitedColumn = [];

        if (count($selectedproductList) > 0) {
            foreach ($selectedproductList as $k => $v) {
                $itemMinPrrice = [];
                $itemColumn = 'D';
                $itemRow = $k + 1;
                $tmp=[];
                $vArr = (object) $v;
                $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
                $estoreProducts[$k]["PRO_NAME"] = "$vArr->pro_name";
                $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                $estoreProducts[$k]["PRO_ID"] = $selectedproductIds[$k];
                    // print_r($k);
                foreach ($getAllStores as $key => $estore) {
                    $amount = 0;
                    foreach ($estore_Pro as $kV => $value) {
                        if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
                            $amount += $value->discountprice * $vArr->quantity;
                        }
                    }
                    foreach ($selectedproductListRaw as $prodKey => $prodVal) {
                        if ($prodVal->rsk_no == $vArr->rsk_no && $prodVal->user_id == $this->session->userdata("user_id")) {
                            $unserializedArr = unserialize($prodVal->price);
                            foreach ($unserializedArr as $storeId => $storeprice) {
                                if ($estore->id == $storeId) {
                                    $amount = $storeprice * $vArr->quantity;
                                    break;
                                }
                            }
                        }
                    }
                    // print_r($amount);
                    $amount = number_format($amount, 2);
                    $tmp[$key]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                        
                    // print_r($amount);
                    $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                    // all store product amount into array
                    if ($amount == 0) {
                        $amountValue = "";
                    } else {
                        $amountValue = $amount;
                    }
                    array_push($itemMinPrrice, $amountValue);
                }
                // removing blank value from array
                $removeNullValues = array_filter($itemMinPrrice, function($value) {
                    return $value !== '';
                });
                // calculating excel cell Id
                if (count($removeNullValues) > 0) {
                    $lowAmtKey = array_search(min($removeNullValues), $removeNullValues);
                    for ($i = 1; $i <= $lowAmtKey; $i++) {
                        $itemColumn++;
                    }
                    $actualBlock = $itemColumn . ($k + 2);
                    array_push($highlitedColumn, $actualBlock);
                }
                
                $json=json_encode($tmp);
                $estoreProducts[$k]['PRICE'] = $json;
            }
        }
        $this->data['productlist'] = $estoreProducts;
        // print_r($estoreProducts);
        $this->data['post'] = !empty($_POST) ? $_POST : '';
        
        $customers = $this->Customer_model->get_customers($this->session->userdata('user_id'));
        $this->data['customers'] = $customers;
        $this->data['selectedproductList'] = $selectedproductList;
        $estoreAllList = $this->ListMaster_model->getAllEstoreMaster();
        $this->data['estoreAllList'] = $estoreAllList;
        
        foreach ($estoreAllList as $estore){
            if($estore->name == "Dahl"){
                $this->data['defaultEstore'] = $estore->name . '-' . $estore->id;
            }
        }
        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;
        // print_r($this->data);
        
        $invoiceHistoryList = $this->Invoice_histories_model->getSub($this->session->userdata("user_id"), $_GET['type']);
        $this->data['invoiceHistoryList'] = $invoiceHistoryList;

        $this->data['content'] = $this->load->view('user/list_invoice_form', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function list_only_invoice_ajax() {

        if (!$this->session->userdata("user_id")) {
             redirect('logga-in');
             exit;
         }
         $listId = base64_decode($_GET['id']);
         ini_set('memory_limit', '256M');
         $stores = [];
         $estoreProducts = [];
         $getAllStores = $this->Estore_model->all_store();
         $tmp =[];
         $productList = $this->ListMaster_model->getListProductNew($listId);
         foreach($productList as $v){
             array_push($tmp, $v->product_id);
             
         }
         $ids = implode(",", $tmp);
         $selectedproductListRaw = $this->ListMaster_model->getSelectedListProductNew($ids);
 
         $selectedproductList = [];
         $selectedproductIds = [];
        foreach ($selectedproductListRaw as $prodKey => $prodVal) {
             if (!in_array($prodVal->product_id, $selectedproductIds) && $prodVal->rsk_no != '') {
                 array_push($selectedproductIds, $prodVal->product_id);
                 array_push($selectedproductList, $prodVal);
             } elseif ($prodVal->rsk_no != '') {
                 foreach ($selectedproductList as $ke => $val) {
                     if ($val->product_id == $prodVal->product_id && $prodVal->quantity > $val->quantity) {
                         $selectedproductList[$ke]->quantity = $prodVal->quantity;
                     }
                 }
             }
         }
         $proRsk = [];
         foreach ($selectedproductList as $v) {
             array_push($proRsk, $v->rsk_no);
         }
         $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);
 
         $highlitedColumn = [];
 
         if (count($selectedproductList) > 0) {
             foreach ($selectedproductList as $k => $v) {
                 $itemMinPrrice = [];
                 $itemColumn = 'D';
                 $itemRow = $k + 1;
                 $tmp=[];
                 $vArr = (object) $v;
                 $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
                 $estoreProducts[$k]["PRO_NAME"] = "$vArr->pro_name";
                 $estoreProducts[$k]["PRO_UNIT"] = "$vArr->pro_unit";
                 $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                 $estoreProducts[$k]["PRO_ID"] = $selectedproductIds[$k];
                     // print_r($k);
                 foreach ($getAllStores as $key => $estore) {
                     $amount = 0;
                     foreach ($estore_Pro as $kV => $value) {
                         if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
                             $amount += $value->discountprice * $vArr->quantity;
                         }
                     }
                     foreach ($selectedproductListRaw as $prodKey => $prodVal) {
                         if ($prodVal->rsk_no == $vArr->rsk_no && $prodVal->user_id == $this->session->userdata("user_id")) {
                             $unserializedArr = unserialize($prodVal->price);
                             foreach ($unserializedArr as $storeId => $storeprice) {
                                 if ($estore->id == $storeId) {
                                     $amount = $storeprice * $vArr->quantity;
                                     break;
                                 }
                             }
                         }
                     }
                     // print_r($amount);
                     $amount = number_format($amount, 2);
                     $tmp[$key]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                         
                     // print_r($amount);
                     $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                     // all store product amount into array
                     if ($amount == 0) {
                         $amountValue = "";
                     } else {
                         $amountValue = $amount;
                     }
                     array_push($itemMinPrrice, $amountValue);
                 }
                 // removing blank value from array
                 $removeNullValues = array_filter($itemMinPrrice, function($value) {
                     return $value !== '';
                 });
                 // calculating excel cell Id
                 if (count($removeNullValues) > 0) {
                     $lowAmtKey = array_search(min($removeNullValues), $removeNullValues);
                     for ($i = 1; $i <= $lowAmtKey; $i++) {
                         $itemColumn++;
                     }
                     $actualBlock = $itemColumn . ($k + 2);
                     array_push($highlitedColumn, $actualBlock);
                 }
                 
                 $json=json_encode($tmp);
                 $estoreProducts[$k]['PRICE'] = $json;
             }
         }
         $this->data['productlist'] = $estoreProducts;
         // print_r($estoreProducts);
         $this->data['post'] = !empty($_POST) ? $_POST : '';
         
         
         
         $this->data['selectedproductList'] = $selectedproductList;
         $estoreAllList = $this->ListMaster_model->getAllEstoreMaster();
         $this->data['estoreAllList'] = $estoreAllList;
         
         foreach ($estoreAllList as $estore){
             if($estore->name == "Dahl"){
                 $this->data['defaultEstore'] = $estore->name . '-' . $estore->id;
             }
         }
         $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
         $this->data['model'] = $user;
         // print_r($this->data);
         
         $invoiceHistoryList = $this->Invoice_histories_model->getSub($this->session->userdata("user_id"), $_GET['type']);
         $this->data['invoiceHistoryList'] = $invoiceHistoryList;

         $customers = $this->Customer_model->get_customersbyuserid($this->session->userdata('user_id'));
         //var_dump($customers);exit;
         $this->data['customers'] = $customers;

         $estoreAllList = $this->ListMaster_model->getAllEstoreMaster();
         $this->data['estoreAllList'] = $estoreAllList;

         $article_list = $this->Article_model->get_articles($this->session->userdata("user_id"));
         //var_dump($article_list);exit;
         $this->data['articles'] = $article_list;

 
         $this->data['content'] = $this->load->view('user/list_only_invoice_form', $this->data, true);
 //        $this->load->view('layout', $this->data);
         $this->load->view('layout_sidebar', $this->data);
     }

     public function list_only_order_ajax() {

        if (!$this->session->userdata("user_id")) {
             redirect('logga-in');
             exit;
         }
         $listId = base64_decode($_GET['id']);
         ini_set('memory_limit', '256M');
         $stores = [];
         $estoreProducts = [];
         $getAllStores = $this->Estore_model->all_store();
         $tmp =[];
         $productList = $this->ListMaster_model->getListProductNew($listId);
         foreach($productList as $v){
             array_push($tmp, $v->product_id);
             
         }
         $ids = implode(",", $tmp);
         $selectedproductListRaw = $this->ListMaster_model->getSelectedListProductNew($ids);
 
         $selectedproductList = [];
         $selectedproductIds = [];
        foreach ($selectedproductListRaw as $prodKey => $prodVal) {
             if (!in_array($prodVal->product_id, $selectedproductIds) && $prodVal->rsk_no != '') {
                 array_push($selectedproductIds, $prodVal->product_id);
                 array_push($selectedproductList, $prodVal);
             } elseif ($prodVal->rsk_no != '') {
                 foreach ($selectedproductList as $ke => $val) {
                     if ($val->product_id == $prodVal->product_id && $prodVal->quantity > $val->quantity) {
                         $selectedproductList[$ke]->quantity = $prodVal->quantity;
                     }
                 }
             }
         }
         $proRsk = [];
         foreach ($selectedproductList as $v) {
             array_push($proRsk, $v->rsk_no);
         }
         $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);
 
         $highlitedColumn = [];
 
         if (count($selectedproductList) > 0) {
             foreach ($selectedproductList as $k => $v) {
                 $itemMinPrrice = [];
                 $itemColumn = 'D';
                 $itemRow = $k + 1;
                 $tmp=[];
                 $vArr = (object) $v;
                 $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
                 $estoreProducts[$k]["PRO_NAME"] = "$vArr->pro_name";
                 $estoreProducts[$k]["PRO_UNIT"] = "$vArr->pro_unit";
                 $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                 $estoreProducts[$k]["PRO_ID"] = $selectedproductIds[$k];
                     // print_r($k);
                 foreach ($getAllStores as $key => $estore) {
                     $amount = 0;
                     foreach ($estore_Pro as $kV => $value) {
                         if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
                             $amount += $value->discountprice * $vArr->quantity;
                         }
                     }
                     foreach ($selectedproductListRaw as $prodKey => $prodVal) {
                         if ($prodVal->rsk_no == $vArr->rsk_no && $prodVal->user_id == $this->session->userdata("user_id")) {
                             $unserializedArr = unserialize($prodVal->price);
                             foreach ($unserializedArr as $storeId => $storeprice) {
                                 if ($estore->id == $storeId) {
                                     $amount = $storeprice * $vArr->quantity;
                                     break;
                                 }
                             }
                         }
                     }
                     // print_r($amount);
                     $amount = number_format($amount, 2);
                     $tmp[$key]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                         
                     // print_r($amount);
                     $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                     // all store product amount into array
                     if ($amount == 0) {
                         $amountValue = "";
                     } else {
                         $amountValue = $amount;
                     }
                     array_push($itemMinPrrice, $amountValue);
                 }
                 // removing blank value from array
                 $removeNullValues = array_filter($itemMinPrrice, function($value) {
                     return $value !== '';
                 });
                 // calculating excel cell Id
                 if (count($removeNullValues) > 0) {
                     $lowAmtKey = array_search(min($removeNullValues), $removeNullValues);
                     for ($i = 1; $i <= $lowAmtKey; $i++) {
                         $itemColumn++;
                     }
                     $actualBlock = $itemColumn . ($k + 2);
                     array_push($highlitedColumn, $actualBlock);
                 }
                 
                 $json=json_encode($tmp);
                 $estoreProducts[$k]['PRICE'] = $json;
             }
         }
         $this->data['productlist'] = $estoreProducts;
         // print_r($estoreProducts);
         $this->data['post'] = !empty($_POST) ? $_POST : '';
         
         $customers = $this->Customer_model->get_customersbyuserid($this->session->userdata('user_id'));
         //var_dump($customers);exit;
         $this->data['customers'] = $customers;
         
         $this->data['selectedproductList'] = $selectedproductList;
         $estoreAllList = $this->ListMaster_model->getAllEstoreMaster();
         $this->data['estoreAllList'] = $estoreAllList;
         
         foreach ($estoreAllList as $estore){
             if($estore->name == "Dahl"){
                 $this->data['defaultEstore'] = $estore->name . '-' . $estore->id;
             }
         }
         $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
         $this->data['model'] = $user;
         // print_r($this->data);
         
         $invoiceHistoryList = $this->Invoice_histories_model->getSub($this->session->userdata("user_id"), $_GET['type']);
         $this->data['invoiceHistoryList'] = $invoiceHistoryList;

         $article_list = $this->Article_model->get_articles($this->session->userdata("user_id"));
         //var_dump($article_list);exit;
         $this->data['articles'] = $article_list;
 
         $this->data['content'] = $this->load->view('user/list_only_order_form', $this->data, true);
 //        $this->load->view('layout', $this->data);
         $this->load->view('layout_sidebar', $this->data);
     }

     public function list_only_offerter_ajax() {

        if (!$this->session->userdata("user_id")) {
             redirect('logga-in');
             exit;
         }
         $listId = base64_decode($_GET['id']);
         ini_set('memory_limit', '256M');
         $stores = [];
         $estoreProducts = [];
         $getAllStores = $this->Estore_model->all_store();
         $tmp =[];
         $productList = $this->ListMaster_model->getListProductNew($listId);
         foreach($productList as $v){
             array_push($tmp, $v->product_id);
             
         }
         $ids = implode(",", $tmp);
         $selectedproductListRaw = $this->ListMaster_model->getSelectedListProductNew($ids);
 
         $selectedproductList = [];
         $selectedproductIds = [];
        foreach ($selectedproductListRaw as $prodKey => $prodVal) {
             if (!in_array($prodVal->product_id, $selectedproductIds) && $prodVal->rsk_no != '') {
                 array_push($selectedproductIds, $prodVal->product_id);
                 array_push($selectedproductList, $prodVal);
             } elseif ($prodVal->rsk_no != '') {
                 foreach ($selectedproductList as $ke => $val) {
                     if ($val->product_id == $prodVal->product_id && $prodVal->quantity > $val->quantity) {
                         $selectedproductList[$ke]->quantity = $prodVal->quantity;
                     }
                 }
             }
         }
         $proRsk = [];
         foreach ($selectedproductList as $v) {
             array_push($proRsk, $v->rsk_no);
         }
         $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);
 
         $highlitedColumn = [];
 
         if (count($selectedproductList) > 0) {
             foreach ($selectedproductList as $k => $v) {
                 $itemMinPrrice = [];
                 $itemColumn = 'D';
                 $itemRow = $k + 1;
                 $tmp=[];
                 $vArr = (object) $v;
                 $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
                 $estoreProducts[$k]["PRO_NAME"] = "$vArr->pro_name";
                 $estoreProducts[$k]["PRO_UNIT"] = "$vArr->pro_unit";
                 $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                 $estoreProducts[$k]["PRO_ID"] = $selectedproductIds[$k];
                     // print_r($k);
                 foreach ($getAllStores as $key => $estore) {
                     $amount = 0;
                     foreach ($estore_Pro as $kV => $value) {
                         if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
                             $amount += $value->discountprice * $vArr->quantity;
                         }
                     }
                     foreach ($selectedproductListRaw as $prodKey => $prodVal) {
                         if ($prodVal->rsk_no == $vArr->rsk_no && $prodVal->user_id == $this->session->userdata("user_id")) {
                             $unserializedArr = unserialize($prodVal->price);
                             foreach ($unserializedArr as $storeId => $storeprice) {
                                 if ($estore->id == $storeId) {
                                     $amount = $storeprice * $vArr->quantity;
                                     break;
                                 }
                             }
                         }
                     }
                     // print_r($amount);
                     $amount = number_format($amount, 2);
                     $tmp[$key]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                         
                     // print_r($amount);
                     $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                     // all store product amount into array
                     if ($amount == 0) {
                         $amountValue = "";
                     } else {
                         $amountValue = $amount;
                     }
                     array_push($itemMinPrrice, $amountValue);
                 }
                 // removing blank value from array
                 $removeNullValues = array_filter($itemMinPrrice, function($value) {
                     return $value !== '';
                 });
                 // calculating excel cell Id
                 if (count($removeNullValues) > 0) {
                     $lowAmtKey = array_search(min($removeNullValues), $removeNullValues);
                     for ($i = 1; $i <= $lowAmtKey; $i++) {
                         $itemColumn++;
                     }
                     $actualBlock = $itemColumn . ($k + 2);
                     array_push($highlitedColumn, $actualBlock);
                 }
                 
                 $json=json_encode($tmp);
                 $estoreProducts[$k]['PRICE'] = $json;
             }
         }
         $this->data['productlist'] = $estoreProducts;
         // print_r($estoreProducts);
         $this->data['post'] = !empty($_POST) ? $_POST : '';
         
         $customers = $this->Customer_model->get_customersbyuserid($this->session->userdata('user_id'));
         //var_dump($customers);exit;
         $this->data['customers'] = $customers;
         
         $this->data['selectedproductList'] = $selectedproductList;
         $estoreAllList = $this->ListMaster_model->getAllEstoreMaster();
         $this->data['estoreAllList'] = $estoreAllList;
         
         foreach ($estoreAllList as $estore){
             if($estore->name == "Dahl"){
                 $this->data['defaultEstore'] = $estore->name . '-' . $estore->id;
             }
         }
         $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
         $this->data['model'] = $user;
         // print_r($this->data);
         
         $invoiceHistoryList = $this->Invoice_histories_model->getSub($this->session->userdata("user_id"), $_GET['type']);
         $this->data['invoiceHistoryList'] = $invoiceHistoryList;

         $article_list = $this->Article_model->get_articles($this->session->userdata("user_id"));
         //var_dump($article_list);exit;
         $this->data['articles'] = $article_list;
 
         $this->data['content'] = $this->load->view('user/list_only_offerter_form', $this->data, true);
 //        $this->load->view('layout', $this->data);
         $this->load->view('layout_sidebar', $this->data);
     }
    
    public function customer(){
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $customers = $this->Customer_model->get_customers($this->session->userdata('user_id'));
        $this->data['customers'] = $customers;
        
        $this->data['content'] = $this->load->view('user/customer', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
        
    }

    public function add_customer(){
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $this->data['content'] = $this->load->view('user/add_customer','',true);
        $this->load->view('layout_sidebar',$this->data);
    }
    
    public function add_new_customer_update() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $data = $this->input->post();
        //var_dump($data);exit;
        $data['user_id'] = $this->session->userdata("user_id");
        $data['created_at'] = date('Y-m-d');
        if($data['reverse_tax']){
            $data['reverse_tax']="on";
        }else{
            $data['reverse_tax']="";
        }
        //var_dump($data);exit;
        $data_msg = array();
        // $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[customers.email]');
        // if ($this->form_validation->run() == TRUE) {
            if($data['id']){
                $result = $this->Customer_model->update($data, $data['id']);
            }else{
                $result = $this->Customer_model->insert($data);
            }
            $session_message['type'] = 1;
            $session_message['title'] = 'Framgång!';
            $session_message['content'] = 'Listan har sparats.';
            $this->session->set_flashdata('message', $session_message);
        // } else {
        //     $this->session->set_flashdata('error', $this->form_validation->error_array());
        // }

        $all_list = $this->Customer_model->get_customers($this->session->userdata("user_id"));
        $this->data['customers'] = $all_list;

        $this->data['content'] = $this->load->view('user/customer', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function edit_invoice_update() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $id = $_GET["id"];
        
        $invoice_info = $this->Invoice_histories_news_model->get_invoicebyid($id);
        $this->data['invoice_info'] = $invoice_info;

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
         $this->data['model'] = $user;
         // print_r($this->data);
         
         $invoiceHistoryList = $this->Invoice_histories_model->getSub($this->session->userdata("user_id"), $_GET['type']);
         $this->data['invoiceHistoryList'] = $invoiceHistoryList;

         $estoreAllList = $this->ListMaster_model->getAllEstoreMaster();
         $this->data['estoreAllList'] = $estoreAllList;

         $article_list = $this->Article_model->get_articles($this->session->userdata("user_id"));
         //var_dump($article_list);exit;
         $this->data['articles'] = $article_list;

         $customers = $this->Customer_model->get_customersbyuserid($this->session->userdata('user_id'));
         //var_dump($customers);exit;
         $this->data['customers'] = $customers;

        $this->data['content'] = $this->load->view('user/list_only_invoice_edit_form', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
        // return json_encode($this->data);
    }

    public function edit_order_update() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $id = $_GET["id"];
        
        $order_info = $this->Order_histories_news_model->get_orderbyid($id);
        $this->data['order_info'] = $order_info;

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
         $this->data['model'] = $user;
         // print_r($this->data);
         
         $invoiceHistoryList = $this->Invoice_histories_model->getSub($this->session->userdata("user_id"), $_GET['type']);
         $this->data['invoiceHistoryList'] = $invoiceHistoryList;

         $estoreAllList = $this->ListMaster_model->getAllEstoreMaster();
         $this->data['estoreAllList'] = $estoreAllList;

         $article_list = $this->Article_model->get_articles($this->session->userdata("user_id"));
         //var_dump($article_list);exit;
         $this->data['articles'] = $article_list;

         $customers = $this->Customer_model->get_customersbyuserid($this->session->userdata('user_id'));
         //var_dump($customers);exit;
         $this->data['customers'] = $customers;

        $this->data['content'] = $this->load->view('user/list_only_order_edit_form', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
        // return json_encode($this->data);
    }

    public function edit_offerter_update() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $id = $_GET["id"];
        
        $offerter_info = $this->Offerter_histories_news_model->get_offerterbyid($id);
        $this->data['offerter_info'] = $offerter_info;

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
         $this->data['model'] = $user;
         // print_r($this->data);
         
         $invoiceHistoryList = $this->Invoice_histories_model->getSub($this->session->userdata("user_id"), $_GET['type']);
         $this->data['invoiceHistoryList'] = $invoiceHistoryList;

         $estoreAllList = $this->ListMaster_model->getAllEstoreMaster();
         $this->data['estoreAllList'] = $estoreAllList;

         $article_list = $this->Article_model->get_articles($this->session->userdata("user_id"));
         //var_dump($article_list);exit;
         $this->data['articles'] = $article_list;

         $customers = $this->Customer_model->get_customersbyuserid($this->session->userdata('user_id'));
         //var_dump($customers);exit;
         $this->data['customers'] = $customers;

        $this->data['content'] = $this->load->view('user/list_only_offerter_edit_form', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
        // return json_encode($this->data);
    }

    public function edit_customer_update() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $id = $_GET["id"];
        
        $customer_info = $this->Customer_model->get_customersbyid($id);
        $this->data['model'] = $customer_info;

        $this->data['content'] = $this->load->view('user/add_customer', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
        // return json_encode($this->data);
    }

    public function edit_article() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        $id = $_GET["id"];
        
        $article_info = $this->Article_model->get_articlesById($id);
        $this->data['model'] = $article_info;

        $this->data['content'] = $this->load->view('user/add_article', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
        // return json_encode($this->data);
    }
    
    public function add_new_customer() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        
        $data_msg = array();
      

        $submit = $this->input->post('submit');
//            if ($submit == "submit") {
        // $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[list_master.name]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[customers.email]');
        if ($this->form_validation->run() == TRUE) {

            $update->user_id = $this->session->userdata("user_id");
            $update->first_name = $this->input->post('first_name');
            $update->last_name = $this->input->post('last_name');
            $update->email = $this->input->post('email');
            $update->company = $this->input->post('company');
            $update->phone_number = $this->input->post('phone_number');
            $update->web_address = $this->input->post('web_address');
            $update->post_code = $this->input->post('post_code');
            $update->status = 1;
            $update->created_at = date('Y-m-d');
            $result = $this->Customer_model->insert($update);
            $session_message['type'] = 1;
            $session_message['title'] = 'Framgång!';
            $session_message['content'] = 'Listan har sparats.';
            $this->session->set_flashdata('message', $session_message);
        } else {
            // return;
            $this->session->set_flashdata('error', $this->form_validation->error_array());
        }
//            }
       

        $all_list = $this->Customer_model->get_customers($this->session->userdata("user_id"));
        $this->data['customers'] = $all_list;

        $this->data['content'] = $this->load->view('user/customer', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);
    }
    
    public function edit_customer() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('logga-in');
            exit;
        }
        
        $data_msg = array();
        $id = $_GET['id'];
        // $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[customers.email]');
        // if ($this->form_validation->run() == TRUE) {

            $update->user_id = $this->session->userdata("user_id");
            $update->first_name = $this->input->post('first_name');
            $update->last_name = $this->input->post('last_name');
            $update->email = $this->input->post('email');
            $update->company = $this->input->post('company');
            $update->phone_number = $this->input->post('phone_number');
            $update->web_address = $this->input->post('web_address');
            $update->post_code = $this->input->post('post_code');
            $update->status = 1;
            $update->created_at = date('Y-m-d');
            $result = $this->Customer_model->update($update, $id);
            $session_message['type'] = 1;
            $session_message['title'] = 'Framgång!';
            $session_message['content'] = 'Listan har sparats.';
            $this->session->set_flashdata('message', $session_message);
       

        $all_list = $this->Customer_model->get_customers($this->session->userdata("user_id"));
        $this->data['customers'] = $all_list;

        $this->data['content'] = $this->load->view('user/customer', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
    }
    
    
    public function delete_customer($id) {
        if (empty($id)) {
            redirect('kund');
        }
        $groupInfo = $this->Customer_model->delete($id);
        $session_message['type'] = 1;
        $session_message['title'] = 'Framgång!';
        $session_message['content'] = 'List has been successfully deleted.';
        $this->session->set_flashdata('message', $session_message);
        redirect('kund');
    }

    public function delete_article() {
        $id = $_GET["id"];
        if (empty($id)) {
            redirect('newarticle');
        }
        
        $groupInfo = $this->Article_model->delete($id);
        $session_message['type'] = 1;
        $session_message['title'] = 'Framgång!';
        $session_message['content'] = 'List has been successfully deleted.';
        $this->session->set_flashdata('message', $session_message);
        redirect('newarticle');
    }
    
    public function get_product_by_rsk(){
        
        
        $rsk_no = $_POST['rsk_no'];
        $result = $this->Products_model->search_by_rsk($rsk_no);
        $productId = $result[0]->id;
        $stores = [];
        $estoreProducts = [];
        $getAllStores = $this->Estore_model->all_store();

        
        if ($productId) {
            
            $selectedproductListRaw = $this->ListMaster_model->getSelectedListProduct($productId);
            //$this->data['selectedproductlist'] = $selectedproductList;
        }
        $selectedproductList = [];
        $selectedproductIds = [];

       foreach ($selectedproductListRaw as $prodKey => $prodVal) {
            if (!in_array($prodVal->product_id, $selectedproductIds) && $prodVal->rsk_no != '') {
                array_push($selectedproductIds, $prodVal->product_id);
                array_push($selectedproductList, $prodVal);
            } elseif ($prodVal->rsk_no != '') {
                foreach ($selectedproductList as $ke => $val) {
                    if ($val->product_id == $prodVal->product_id && $prodVal->quantity > $val->quantity) {
                        $selectedproductList[$ke]->quantity = $prodVal->quantity;
                    }
                }
            }
        }
        $proRsk = [];
        foreach ($selectedproductList as $v) {
            array_push($proRsk, $v->rsk_no);
        }
        $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);

        $highlitedColumn = [];

        if (count($selectedproductList) > 0) {
            foreach ($selectedproductList as $k => $v) {
                $itemMinPrrice = [];
                $itemColumn = 'D';
                $itemRow = $k + 1;
                $tmp=[];
                $vArr = (object) $v;
                $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
                $estoreProducts[$k]["PRO_NAME"] = "$vArr->pro_name";
                $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                $estoreProducts[$k]["PRO_ID"] = $selectedproductIds[$k];
                    // print_r($k);
                foreach ($getAllStores as $key => $estore) {
                    $amount = 0;
                    foreach ($estore_Pro as $kV => $value) {
                        if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
                            $amount += $value->discountprice * $vArr->quantity;
                        }
                    }
                    foreach ($selectedproductListRaw as $prodKey => $prodVal) {
                        if ($prodVal->rsk_no == $vArr->rsk_no && $prodVal->user_id == $this->session->userdata("user_id")) {
                            $unserializedArr = unserialize($prodVal->price);
                            foreach ($unserializedArr as $storeId => $storeprice) {
                                if ($estore->id == $storeId) {
                                    $amount = $storeprice * $vArr->quantity;
                                    break;
                                }
                            }
                        }
                    }
                    // print_r($amount);
                    $amount = number_format($amount, 2);
                    $tmp[$key]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                        
                    // print_r($amount);
                    $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                    // all store product amount into array
                    if ($amount == 0) {
                        $amountValue = "";
                    } else {
                        $amountValue = $amount;
                    }
                    array_push($itemMinPrrice, $amountValue);
                }
                // removing blank value from array
                $removeNullValues = array_filter($itemMinPrrice, function($value) {
                    return $value !== '';
                });
                // calculating excel cell Id
                if (count($removeNullValues) > 0) {
                    $lowAmtKey = array_search(min($removeNullValues), $removeNullValues);
                    for ($i = 1; $i <= $lowAmtKey; $i++) {
                        $itemColumn++;
                    }
                    $actualBlock = $itemColumn . ($k + 2);
                    array_push($highlitedColumn, $actualBlock);
                }
                
                $json=json_encode($tmp);
                $estoreProducts[$k]['PRICE'] = $json;
            }
        }
        $this->data['productlist'] = $estoreProducts[0];
        print_r(json_encode($this->data));
    }

    public function get_product_by_rsk_new(){
        
        
        $rsk_no = $_POST['rsk_no'];
        $result = $this->Products_model->search_by_rsk($rsk_no);
        if($result){
            $productId = $result[0]->id;
            $stores = [];
            $estoreProducts = [];
            $getAllStores = $this->Estore_model->all_store();

            
            if ($productId) {
                
                $selectedproductListRaw = $this->ListMaster_model->getSelectedListProduct($productId);
                //$this->data['selectedproductlist'] = $selectedproductList;
            }
            $selectedproductList = [];
            $selectedproductIds = [];

        foreach ($selectedproductListRaw as $prodKey => $prodVal) {
                if (!in_array($prodVal->product_id, $selectedproductIds) && $prodVal->rsk_no != '') {
                    array_push($selectedproductIds, $prodVal->product_id);
                    array_push($selectedproductList, $prodVal);
                } elseif ($prodVal->rsk_no != '') {
                    foreach ($selectedproductList as $ke => $val) {
                        if ($val->product_id == $prodVal->product_id && $prodVal->quantity > $val->quantity) {
                            $selectedproductList[$ke]->quantity = $prodVal->quantity;
                        }
                    }
                }
            }
            $proRsk = [];
            foreach ($selectedproductList as $v) {
                array_push($proRsk, $v->rsk_no);
            }
            $estore_Pro = $this->ListMaster_model->getEstoreProduct($proRsk);

            $highlitedColumn = [];

            if (count($selectedproductList) > 0) {
                foreach ($selectedproductList as $k => $v) {
                    $itemMinPrrice = [];
                    $itemColumn = 'D';
                    $itemRow = $k + 1;
                    $tmp=[];
                    $vArr = (object) $v;
                    $estoreProducts[$k]["RSK_NO"] = $vArr->rsk_no;
                    $estoreProducts[$k]["PRO_NAME"] = "$vArr->pro_name";
                    $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                    $estoreProducts[$k]["PRO_ID"] = $selectedproductIds[$k];
                        // print_r($k);
                    foreach ($getAllStores as $key => $estore) {
                        $amount = 0;
                        foreach ($estore_Pro as $kV => $value) {
                            if ($estore->id == $value->store_id && $vArr->rsk_no == $value->rsk_no) {
                                $amount += $value->discountprice * $vArr->quantity;
                            }
                        }
                        foreach ($selectedproductListRaw as $prodKey => $prodVal) {
                            if ($prodVal->rsk_no == $vArr->rsk_no && $prodVal->user_id == $this->session->userdata("user_id")) {
                                $unserializedArr = unserialize($prodVal->price);
                                foreach ($unserializedArr as $storeId => $storeprice) {
                                    if ($estore->id == $storeId) {
                                        $amount = $storeprice * $vArr->quantity;
                                        break;
                                    }
                                }
                            }
                        }
                        // print_r($amount);
                        $amount = number_format($amount, 2);
                        $tmp[$key]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                            
                        // print_r($amount);
                        $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
                        // all store product amount into array
                        if ($amount == 0) {
                            $amountValue = "";
                        } else {
                            $amountValue = $amount;
                        }
                        array_push($itemMinPrrice, $amountValue);
                    }
                    // removing blank value from array
                    $removeNullValues = array_filter($itemMinPrrice, function($value) {
                        return $value !== '';
                    });
                    // calculating excel cell Id
                    if (count($removeNullValues) > 0) {
                        $lowAmtKey = array_search(min($removeNullValues), $removeNullValues);
                        for ($i = 1; $i <= $lowAmtKey; $i++) {
                            $itemColumn++;
                        }
                        $actualBlock = $itemColumn . ($k + 2);
                        array_push($highlitedColumn, $actualBlock);
                    }
                    
                    $json=json_encode($tmp);
                    $estoreProducts[$k]['PRICE'] = $json;
                }
            }
            $this->data['productlist'] = $estoreProducts[0];
            $this->data['status']="exist";
            print_r(json_encode($this->data));
        }else{
            $this->data['status'] = "noproduct";
            print_r(json_encode($this->data));
        }
    }

    public function get_article_price(){
        //
        $art_num = $_POST['rsk_no'];
        //echo $art_num;exit;
        $this->data['status']="failed";
        $all_lists = $this->Article_model->get_articles($this->session->userdata("user_id"));
        //var_dump($all_lists);exit;
        foreach($all_lists as $all_list){
            if($all_list->art_num == $art_num){
                $this->data['price_list'] = $all_list->price_list;
                $this->data['status']="success";
            }
        }
        print_r(json_encode($this->data));
    }

    public function get_article_by_rsk_new(){
        //
        $art_num = $_POST['rsk_no'];
        $flag=0;
        $all_lists = $this->Article_model->get_articles($this->session->userdata("user_id"));
        foreach($all_lists as $all_list){
            if($all_list->art_num == $art_num){
                $this->data['article_list'] = $all_list;
                $this->data['status']="success";
                $flag = 1;
            }
        }
        if(!$flag){
                $this->data['status']="faild";
        }
        print_r(json_encode($this->data));
    }
    
    
}