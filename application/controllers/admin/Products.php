<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('site_helper');
        $this->load->helper('form');
        $this->load->helper('url');

        $this->load->library('session');

        $this->load->model('Groups_model');
        $this->load->model('Category_model');
        $this->load->model('Products_model');
        $this->load->model('Manufacturer_model');
        $this->load->model('ProductTypes_model');

        allow_if_logged_in();

        $this->data['pageDesc'] = '';
    }

    
       
    public function ut() {
        $update = array();
        $update['Name'] = 'Duschdörrar, Skagen Saloon 136';
        $where = array('RSKnummer' => '7383265');
        $this->Products_model->update_where($update, $where);
        echo 'DONE!';
    }
       
    public function seo() {
    
        
        
        $sitemapUrl=('sitemap4.xml');
  $xml=simplexml_load_file($sitemapUrl);
        $sql = 'SELECT id,Name FROM products LIMIT 50000 OFFSET 50000';
            $query = $this->db->query($sql);
            foreach($query->result_object() as $product)
            {
                 
               
              $title=   site_url('product/' . url_title($product->Name) . '-pid-' . $product->id);       
         
  
  $newNode = $xml->addChild('url');
  $newNode->addChild('loc', $title);
  
  $newNode->addChild('changefreq', 'weekly');
  $newNode->addChild('priority', '0.80');  
                
            }
   
  $xml->asXML('sitemap4.xml');
        
        
    }

//    public function index() {
//        set_page_title('Products');
//
//        $this->load->helper('form');
//        $manu[''] = 'Select';
//
//        $per_page = 99;
//        $total_rows = $this->Products_model->get_total();
//
//        if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
//            $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
//            $products = $this->Products_model->get_products('', $start);
//            $this->data['productsList'] = $products;
//            $this->data['slno'] = $start + 1;
//        } else {
//            $products = $this->Products_model->get_products();
//            $this->data['productsList'] = $products;
//            $this->data['slno'] = 1;
//        }
//
//        // Pagination
//        $this->load->library('pagination');
//
//        $get = $_GET;
//        unset($get['per_page']);
//        $actionParam = http_build_query($get);
//        $this->data['actionParam'] = $actionParam;
//
//        $config['base_url'] = site_url('admin/products');
//        $config['base_url'] = $config['base_url'] . '?' . http_build_query($get);
//        $config['total_rows'] = $total_rows;
//        $config['per_page'] = $per_page;
//        $config['num_links'] = 3;
//        $config['page_query_string'] = TRUE;
//        $config['use_page_numbers'] = TRUE;
//        $config['attributes'] = array('class' => 'page-link');
//
//        $config['full_tag_open'] = '<ul class="pagination pull-right">';
//        $config['full_tag_close'] = '</ul>';
//
//        $config['first_link'] = 'First';
//        $config['first_tag_open'] = '<li class="page-item">';
//        $config['first_tag_close'] = '</li>';
//
//        $config['last_link'] = 'Last';
//        $config['last_tag_open'] = '<li class="page-item">';
//        $config['last_tag_close'] = '</li>';
//
//        $config['next_link'] = 'Next';
//        $config['next_tag_open'] = '<li class="page-item">';
//        $config['next_tag_close'] = '</li>';
//
//        $config['prev_link'] = 'Prev';
//        $config['prev_tag_open'] = '<li class="page-item">';
//        $config['prev_tag_close'] = '</li>';
//
//        $config['cur_tag_open'] = '<li class="page-item active"><a href="" class="page-link">';
//        $config['cur_tag_close'] = '</a></li>';
//
//        $config['num_tag_open'] = '<li class="page-item">';
//        $config['num_tag_close'] = '</li>';
//
//        $this->pagination->initialize($config);
//
//        $this->data['total_rows'] = $total_rows;
//        $this->data['content'] = $this->load->view('admin/products', $this->data, true);
//
//        $this->load->view('layouts/admin', $this->data);
//    }

    public function index() {
        set_page_title('Products');

        $_s_key = "";
        $_s_sort_by = "t.name";
        $_s_order_by = "ASC";

        $resp['crntPage'] = $_page_no = 1;

        $resp['limit'] = $limit = self::LIMIT_PER_PAGE;

        $resp['total_products'] = $total_products = $this->Products_model->total_product_search_res($_s_key);
        $resp['productsData'] = $productsData = $this->Products_model->get_product_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $_page_no);

        if (($total_products % $limit) == 0) {
            $totalPages = $total_products / $limit;
        } else {
            $totalPages = floor($total_products / $limit) + 1;
        }
        $resp['totalPages'] = $totalPages;

        $data['content'] = $this->load->view('admin/products/products', $resp, true);

        $this->load->view('layouts/admin', $data);
    }

    public function ajax_search_field_autocomplete() {
        if ($this->input->is_ajax_request()) {
            $_s_key = $_POST['_s_key'];

            $search_products = $this->Products_model->ajax_search_field_autocomplete($_s_key);

            $autocompletteArr = array();
            if (count($search_products) > 0) {
                foreach ($search_products as $v) {
                    if (strpos(strtolower($v->Name), strtolower($_s_key)) !== false) {
                        array_push($autocompletteArr, $v->Name);
                    } elseif (strpos(strtolower($v->RSK), strtolower($_s_key)) !== false) {
                        array_push($autocompletteArr, $v->RSK);
                    } elseif (strpos(strtolower($v->Rsk1), strtolower($_s_key)) !== false) {
                        array_push($autocompletteArr, $v->Rsk1);
                    } elseif (strpos(strtolower($v->CNAME), strtolower($_s_key)) !== false) {
                        array_push($autocompletteArr, $v->CNAME);
                    } elseif (strpos(strtolower($v->MName), strtolower($_s_key)) !== false) {
                        array_push($autocompletteArr, $v->MName);
                    }
                }
            } else {
                array_push($autocompletteArr, ucwords("no result found"));
            }
            echo json_encode($autocompletteArr);
            exit;
        }
    }

    public function ajax_search_product() {
        if ($this->input->is_ajax_request()) {
            $_s_key = isset($_POST['_s_key']) ? trim($_POST['_s_key']) : "";
            $_s_sort_by = isset($_POST['_s_sort_by']) ? trim($_POST['_s_sort_by']) : "t.name";
            $_s_order_by = isset($_POST['_s_order_by']) ? trim($_POST['_s_order_by']) : "ASC";
            
            $resp['crntPage'] = $_page_no = isset($_POST['_page_no']) ? trim($_POST['_page_no']) : "1";

            $resp['limit'] = $limit = self::LIMIT_PER_PAGE;

            $resp['total_products'] = $total_products = $this->Products_model->total_product_search_res($_s_key);
            $resp['productsData'] = $productsData = $this->Products_model->get_product_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $_page_no);

            if (($total_products % $limit) == 0) {
                $totalPages = $total_products / $limit;
            } else {
                $totalPages = floor($total_products / $limit) + 1;
            }
            $resp['totalPages'] = $totalPages;

            $resp["respHtml"] = $this->load->view('admin/_partial/_product_search_result', $resp, TRUE);
            echo json_encode($resp);
            exit;
        }
    }

    // Edit Product Information
    public function edit($id = 0) {
        if ($id == 0)
            redirect('admin/products');

        $productInformation = $this->Products_model->get($id);
        if (empty($productInformation))
            redirect('admin/products');
        $this->data['productInfo'] = $productInformation;

        set_page_title('Product Information');

        // Get All Groups
        $temp[''] = 'Select';
        $groups = $this->Groups_model->get_all();
        foreach ($groups as $group) {
            $temp[$group->id] = $group->name;
        }
        $this->data['groups'] = $temp;

        // Get All Product Types
        $productTypes = $this->ProductTypes_model->get_all(0, false);
        $string = '';
        foreach ($productTypes as $pType) {
            $string .= '"' . addslashes(trim($pType->name)) . '", ';
        }
        $this->data['productTypes'] = $string;
        $productTypeInfo = $this->ProductTypes_model->get($productInformation->ProductType);
        $this->data['productTypeInfo'] = $productTypeInfo;

        // Get all manufacturers
        $Manufacturer = $this->Manufacturer_model->get_all();
        $string = '';
        foreach ($Manufacturer as $manu) {
            $string .= '"' . $manu->name . '", ';
        }
        $this->data['ManuArray'] = $string;

        // Get Current Manufacturer Info
        $this->data['Manufacturer'] = $Manufacturer;
        $ManufacturerInfo = $this->Manufacturer_model->get($productInformation->Manufacturer);
        $this->data['ManufacturerInfo'] = $ManufacturerInfo;

        // Get Parent Categories
        $categories = $this->Category_model->get_main_category();
        $mainCategory[''] = 'Select';
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $mainCategory[$category->id] = $category->name;
            }
            $this->data['mainCategory'] = $mainCategory;
        }

        // Get Category 2
        $subCategory[''] = 'Select';
        $this->data['subCategory'] = $subCategory;
        if ($productInformation->category1 > 0) {
            $categories2 = $this->Category_model->get_sub_category1($productInformation->category1);
            if (!empty($categories2)) {
                foreach ($categories2 as $category) {
                    $subCategory[$category->id] = $category->name;
                }
                $this->data['subCategory'] = $subCategory;
            }
        }

        // Get Category 3
        $subCategory2[''] = 'Select';
        $this->data['subCategory2'] = $subCategory2;
        if ($productInformation->category2 > 0) {
            $categories3 = $this->Category_model->get_sub_category2($productInformation->category2);
            if (!empty($categories3)) {
                foreach ($categories3 as $category) {
                    $subCategory2[$category->id] = $category->name;
                }
                $this->data['subCategory2'] = $subCategory2;
            }
        }

        // Delete Product
        if ($this->input->post('delete')) {
            $delete = set_value('delete');
            if ($delete == "delete") {
                $this->Products_model->delete($productInformation->id);
                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = 'Product has been successfully deleted.';
                $this->session->set_flashdata('message', $session_message);
                redirect('admin/products/');
            }
        }
        // Save Product Details
        if ($this->input->post('submit')) {
            $submit = set_value('submit');
            if ($submit == "save") {
                $this->load->library('form_validation');

                $this->form_validation->set_rules('Name', 'Name', 'trim|required|max_length[250]');
                $this->form_validation->set_rules('groupName', 'Group', 'trim|required|max_length[250]');
                $this->form_validation->set_rules('category1', 'Category1', 'trim|required|max_length[250]');
                $this->form_validation->set_rules('category2', 'Category2', 'trim|max_length[250]');
                $this->form_validation->set_rules('category3', 'Category3', 'trim|max_length[250]');
                $this->form_validation->set_rules('Manufacturer', 'Manufacturer', 'trim|required|max_length[250]');
                $this->form_validation->set_rules('ProductType', 'ProductType', 'trim|required|max_length[250]');
                //$this->form_validation->set_rules('ProductId', 'ProductId', 'trim|required|max_length[11]');
                $this->form_validation->set_rules('Unit', 'Unit', 'trim|max_length[250]');
                $this->form_validation->set_rules('RSKnummer0', 'RSKnummer0', 'trim|required');
                $this->form_validation->set_rules('Tillverkarensartikelnummer0', 'Tillverkarensartikelnummer0', 'trim|max_length[250]');
                $this->form_validation->set_rules('RSKnummer', 'RSKnummer', 'trim|required|max_length[250]|max_length[250]');
                $this->form_validation->set_rules('Tillverkarensartikelnummer', 'Tillverkarensartikelnummer', 'trim|max_length[250]');
                $this->form_validation->set_rules('GTIN', 'GTIN', 'trim');
                $this->form_validation->set_rules('Produkt', 'Produkt', 'trim');
                $this->form_validation->set_rules('Produktnamn', 'Produktnamn', 'trim');
                $this->form_validation->set_rules('Dimension', 'Dimension', 'trim');
                $this->form_validation->set_rules('Storlek', 'Storlek', 'trim');
                $this->form_validation->set_rules('TryckFlodeTemp', 'TryckFlodeTemp', 'trim');
                $this->form_validation->set_rules('EffektEldata', 'EffektEldata', 'trim');
                $this->form_validation->set_rules('Funktion', 'Funktion', 'trim');
                $this->form_validation->set_rules('Utforande', 'Utforande', 'trim');
                $this->form_validation->set_rules('Farg', 'Farg', 'trim');
                $this->form_validation->set_rules('Ytbehandling', 'Ytbehandling', 'trim');
                $this->form_validation->set_rules('Material', 'Material', 'trim');
                $this->form_validation->set_rules('Standard', 'Standard', 'trim');
                $this->form_validation->set_rules('Ovriginfo', 'Ovriginfo', 'trim');
                $this->form_validation->set_rules('EgenbenamningSvensk', 'EgenbenamningSvensk', 'trim');
                $this->form_validation->set_rules('Varumarke', 'Varumarke', 'trim');
                $this->form_validation->set_rules('Tillverkarensproduktsida', 'Tillverkarensproduktsida', 'trim');

                $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
                $this->form_validation->set_message('required', 'Required.');
                $this->form_validation->set_message('matches', 'The %s does not match the %s.');
                $this->form_validation->set_message('min_length', 'The %s must be at least %s characters in length..');
                $this->form_validation->set_message('max_length', 'The %s cannot exceed %s characters in length.');

                if ($this->form_validation->run() == TRUE) {
                    $manuText = set_value('Manufacturer');
                    $search['name'] = $manuText;
                    $Manufacturer = $this->Manufacturer_model->search($search);
                    if (isset($Manufacturer->id)) {
                        $update['Manufacturer'] = $Manufacturer->id;
                    }

                    $ptypeText = set_value('ProductType');
                    $search['name'] = $ptypeText;
                    $ProductType = $this->ProductTypes_model->search($search);
                    if (isset($ProductType->id)) {
                        $update['ProductType'] = $ProductType->id;
                    }

                    $update['Name'] = set_value('Name');
                    $update['groupName'] = set_value('groupName');
                    $update['category1'] = set_value('category1');
                    $update['category2'] = set_value('category2');
                    $update['category3'] = set_value('category3');
                    $update['ProductId'] = '000000';
                    $update['Unit'] = set_value('Unit');
                    $update['RSKnummer0'] = set_value('RSKnummer0');
                    $update['Tillverkarensartikelnummer0'] = set_value('Tillverkarensartikelnummer0');
                    $update['RSKnummer'] = set_value('RSKnummer');
                    $update['Tillverkarensartikelnummer'] = set_value('Tillverkarensartikelnummer');
                    $update['GTIN'] = set_value('GTIN');
                    $update['Produkt'] = set_value('Produkt');
                    $update['Produktnamn'] = set_value('Produktnamn');
                    $update['Dimension'] = set_value('Dimension');
                    $update['Storlek'] = set_value('Storlek');
                    $update['TryckFlodeTemp'] = set_value('TryckFlodeTemp');
                    $update['EffektEldata'] = set_value('EffektEldata');
                    $update['Funktion'] = set_value('Funktion');
                    $update['Utforande'] = set_value('Utforande');
                    $update['Farg'] = set_value('Farg');
                    $update['Ytbehandling'] = set_value('Ytbehandling');
                    $update['Material'] = set_value('Material');
                    $update['Standard'] = set_value('Standard');
                    $update['Ovriginfo'] = set_value('Ovriginfo');
                    $update['EgenbenamningSvensk'] = set_value('EgenbenamningSvensk');
                    $update['Varumarke'] = set_value('Varumarke');
                    $update['Tillverkarensproduktsida'] = set_value('Tillverkarensproduktsida');


                    $this->Products_model->update($update, $productInformation->id);
                    $session_message['type'] = 1;
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = 'Product details has been successfully saved.';
                    $this->session->set_flashdata('message', $session_message);
                    redirect('admin/products/edit/' . $productInformation->id);
                }
            }
        }

        $this->data['content'] = $this->load->view('admin/products/product-edit', $this->data, true);
        $this->load->view('layouts/admin', $this->data);
    }

    public function add() {

        set_page_title('Product Add');

        // Get All Groups
        $temp[''] = 'Select';
        $groups = $this->Groups_model->get_all();
        foreach ($groups as $group) {
            $temp[$group->id] = $group->name;
        }
        $this->data['groups'] = $temp;

        // Get All Product Types
        $productTypes = $this->ProductTypes_model->get_all(0, false);
        $string = '';
        foreach ($productTypes as $pType) {
            $string .= '"' . addslashes(trim($pType->name)) . '", ';
        }
        $this->data['productTypes'] = $string;
        // Get all manufacturers
        $Manufacturer = $this->Manufacturer_model->get_all();
        $string = '';
        foreach ($Manufacturer as $manu) {
            $string .= '"' . $manu->name . '", ';
        }
        $this->data['ManuArray'] = $string;

        // Get Current Manufacturer Info
        $this->data['Manufacturer'] = $Manufacturer;
        // Get Parent Categories
        $categories = $this->Category_model->get_main_category();
        $mainCategory[''] = 'Select';
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $mainCategory[$category->id] = $category->name;
            }
            $this->data['mainCategory'] = $mainCategory;
        }

        // Get Category 2
        $subCategory[''] = 'Select';
        $this->data['subCategory'] = $subCategory;

        // Get Category 3
        $subCategory2[''] = 'Select';
        $this->data['subCategory2'] = $subCategory2;
        // Save Product Details
        if ($this->input->post('submit')) {
            $submit = set_value('submit');
            if ($submit == "save") {
                $this->load->library('form_validation');

                if (empty($_FILES['userfile']['name'])) {
                    $this->form_validation->set_rules('userfile', 'Image', 'required');
                }
                $this->form_validation->set_rules('Name', 'Name', 'trim|required|max_length[250]');
                $this->form_validation->set_rules('groupName', 'Group', 'trim|required|max_length[250]');
                $this->form_validation->set_rules('category_id', 'CategoryId', 'trim|required|max_length[250]');
                $this->form_validation->set_rules('category1', 'Category1', 'trim|required|max_length[250]');
                $this->form_validation->set_rules('category2', 'Category2', 'trim|max_length[250]');
                $this->form_validation->set_rules('category3', 'Category3', 'trim|max_length[250]');
                $this->form_validation->set_rules('Manufacturer', 'Manufacturer', 'trim|required|max_length[250]');
                $this->form_validation->set_rules('ProductType', 'ProductType', 'trim|required|max_length[250]');
                //$this->form_validation->set_rules('ProductId', 'ProductId', 'trim|required|max_length[11]');
                $this->form_validation->set_rules('Unit', 'Unit', 'trim|max_length[250]');
                // $this->form_validation->set_rules('RSKnummer0', 'RSKnummer0', 'trim|required');
                $this->form_validation->set_rules('Tillverkarensartikelnummer0', 'Tillverkarensartikelnummer0', 'trim|max_length[250]');
                $this->form_validation->set_rules('RSKnummer', 'RSKnummer', 'trim|required|max_length[250]|max_length[250]');
                $this->form_validation->set_rules('Tillverkarensartikelnummer', 'Tillverkarensartikelnummer', 'trim|max_length[250]');
                $this->form_validation->set_rules('GTIN', 'GTIN', 'trim');
                $this->form_validation->set_rules('Produkt', 'Produkt', 'trim');
                $this->form_validation->set_rules('Produktnamn', 'Produktnamn', 'trim');
                $this->form_validation->set_rules('Dimension', 'Dimension', 'trim');
                $this->form_validation->set_rules('Storlek', 'Storlek', 'trim');
                $this->form_validation->set_rules('TryckFlodeTemp', 'TryckFlodeTemp', 'trim');
                $this->form_validation->set_rules('EffektEldata', 'EffektEldata', 'trim');
                $this->form_validation->set_rules('Funktion', 'Funktion', 'trim');
                $this->form_validation->set_rules('Utforande', 'Utforande', 'trim');
                $this->form_validation->set_rules('Farg', 'Farg', 'trim');
                $this->form_validation->set_rules('Ytbehandling', 'Ytbehandling', 'trim');
                $this->form_validation->set_rules('Material', 'Material', 'trim');
                $this->form_validation->set_rules('Standard', 'Standard', 'trim');
                $this->form_validation->set_rules('Ovriginfo', 'Ovriginfo', 'trim');
                $this->form_validation->set_rules('EgenbenamningSvensk', 'EgenbenamningSvensk', 'trim');
                $this->form_validation->set_rules('Varumarke', 'Varumarke', 'trim');
                $this->form_validation->set_rules('Tillverkarensproduktsida', 'Tillverkarensproduktsida', 'trim');

                $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
//                $this->form_validation->set_message('required', 'Required.');
                $this->form_validation->set_message('matches', 'The %s does not match the %s.');
                $this->form_validation->set_message('min_length', 'The %s must be at least %s characters in length..');
                $this->form_validation->set_message('max_length', 'The %s cannot exceed %s characters in length.');

                $new_name = $this->input->post('RSKnummer');
                $config = array(
                    'upload_path' => './images/' . $this->input->post('category_id'),
                    'allowed_types' => "jpg|png|jpeg",
//                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => TRUE,
                    'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    'max_height' => "768",
                    'max_width' => "1024",
                    'file_name' => $new_name,
                );
                if (!is_dir($config['upload_path']))
                    mkdir($config['upload_path'], 0777, TRUE);
                $this->load->library('upload');
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('userfile')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->form_validation->set_message('userfile', $this->upload->display_errors());
                } else {
                    $data = array('upload_data' => $this->upload->data());
                }

                if ($this->form_validation->run() === TRUE) {
                    $manuText = set_value('Manufacturer');
                    $search['name'] = $manuText;
                    $Manufacturer = $this->Manufacturer_model->search($search);
                    if (isset($Manufacturer->id)) {
                        $update['Manufacturer'] = $Manufacturer->id;
                    }

                    $ptypeText = set_value('ProductType');
                    $search['name'] = $ptypeText;
                    $ProductType = $this->ProductTypes_model->search($search);
                    if (isset($ProductType->id)) {
                        $update['ProductType'] = $ProductType->id;
                    }

                    $update['Name'] = set_value('Name');
                    $update['ImageName'] = 'images/' . $this->input->post('category_id') . '/' . $data['upload_data']['file_name'];
                    $update['groupName'] = set_value('groupName');
                    $update['category_id'] = set_value('category_id');
                    $update['category1'] = set_value('category1');
                    $update['category2'] = set_value('category2');
                    $update['category3'] = set_value('category3');
                    $update['ProductId'] = '000000';
                    $update['Unit'] = set_value('Unit');
                    $update['RSKnummer0'] = set_value('RSKnummer0');
                    $update['Tillverkarensartikelnummer0'] = set_value('Tillverkarensartikelnummer0');
                    $update['RSKnummer'] = set_value('RSKnummer');
                    $update['Tillverkarensartikelnummer'] = set_value('Tillverkarensartikelnummer');
                    $update['GTIN'] = set_value('GTIN');
                    $update['Produkt'] = set_value('Produkt');
                    $update['Produktnamn'] = set_value('Produktnamn');
                    $update['Dimension'] = set_value('Dimension');
                    $update['Storlek'] = set_value('Storlek');
                    $update['TryckFlodeTemp'] = set_value('TryckFlodeTemp');
                    $update['EffektEldata'] = set_value('EffektEldata');
                    $update['Funktion'] = set_value('Funktion');
                    $update['Utforande'] = set_value('Utforande');
                    $update['Farg'] = set_value('Farg');
                    $update['Ytbehandling'] = set_value('Ytbehandling');
                    $update['Material'] = set_value('Material');
                    $update['Standard'] = set_value('Standard');
                    $update['Ovriginfo'] = set_value('Ovriginfo');
                    $update['EgenbenamningSvensk'] = set_value('EgenbenamningSvensk');
                    $update['Varumarke'] = set_value('Varumarke');
                    $update['Tillverkarensproduktsida'] = set_value('Tillverkarensproduktsida');

                    $update['status'] = 1;



                    $result = $this->Products_model->insert($update);
                    
                      $this->Products_model->addSeo($result, $update['Name']);
                    
                    $session_message['type'] = 1;
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = 'Product has been successfully added.';
                    $this->session->set_flashdata('message', $session_message);
                    redirect('admin/products');
                } else {
//                    $errors = $this->form_validation->error_array();
//                    echo "<pre>";
//                    print_r($errors);
//                    exit;
                }
            }
        }

        $this->data['content'] = $this->load->view('admin/products/product-add', $this->data, true);
        $this->load->view('layouts/admin', $this->data);
    }

    public function ajaxproductadd() {

        if ($this->input->is_ajax_request()) {
            $error = [];

            $this->load->library('form_validation');

            if (empty($_FILES['userfile']['name'])) {
                $this->form_validation->set_rules('userfile', 'Image', 'required');
            }
            $this->form_validation->set_rules('Name', 'Name', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('groupName', 'Group', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('category_id', 'CategoryId', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('category1', 'Category1', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('category2', 'Category2', 'trim|max_length[250]');
            $this->form_validation->set_rules('category3', 'Category3', 'trim|max_length[250]');
            $this->form_validation->set_rules('Manufacturer', 'Manufacturer', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('ProductType', 'ProductType', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('ProductId', 'ProductId', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('Unit', 'Unit', 'trim|max_length[250]');
            $this->form_validation->set_rules('RSKnummer0', 'RSKnummer0', 'trim|required');
            $this->form_validation->set_rules('Tillverkarensartikelnummer0', 'Tillverkarensartikelnummer0', 'trim|max_length[250]');
            $this->form_validation->set_rules('RSKnummer', 'RSKnummer', 'trim|required|max_length[250]|max_length[250]');
            $this->form_validation->set_rules('Tillverkarensartikelnummer', 'Tillverkarensartikelnummer', 'trim|max_length[250]');
            $this->form_validation->set_rules('GTIN', 'GTIN', 'trim');
            $this->form_validation->set_rules('Produkt', 'Produkt', 'trim');
            $this->form_validation->set_rules('Produktnamn', 'Produktnamn', 'trim');
            $this->form_validation->set_rules('Dimension', 'Dimension', 'trim');
            $this->form_validation->set_rules('Storlek', 'Storlek', 'trim');
            $this->form_validation->set_rules('TryckFlodeTemp', 'TryckFlodeTemp', 'trim');
            $this->form_validation->set_rules('EffektEldata', 'EffektEldata', 'trim');
            $this->form_validation->set_rules('Funktion', 'Funktion', 'trim');
            $this->form_validation->set_rules('Utforande', 'Utforande', 'trim');
            $this->form_validation->set_rules('Farg', 'Farg', 'trim');
            $this->form_validation->set_rules('Ytbehandling', 'Ytbehandling', 'trim');
            $this->form_validation->set_rules('Material', 'Material', 'trim');
            $this->form_validation->set_rules('Standard', 'Standard', 'trim');
            $this->form_validation->set_rules('Ovriginfo', 'Ovriginfo', 'trim');
            $this->form_validation->set_rules('EgenbenamningSvensk', 'EgenbenamningSvensk', 'trim');
            $this->form_validation->set_rules('Varumarke', 'Varumarke', 'trim');
            $this->form_validation->set_rules('Tillverkarensproduktsida', 'Tillverkarensproduktsida', 'trim');

            $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
//                $this->form_validation->set_message('required', 'Required.');
            $this->form_validation->set_message('matches', 'The %s does not match the %s.');
            $this->form_validation->set_message('min_length', 'The %s must be at least %s characters in length..');
            $this->form_validation->set_message('max_length', 'The %s cannot exceed %s characters in length.');

            $new_name = $this->input->post('RSKnummer');
            if ($_FILES['userfile']['name'] != '') {
                $config = array(
                    'upload_path' => './images/' . $this->input->post('category_id'),
                    'allowed_types' => "jpg|png|jpeg",
//                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => TRUE,
                    'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    'max_height' => "768",
                    'max_width' => "1024",
                    'file_name' => $new_name,
                );
                if (!is_dir($config['upload_path']))
                    mkdir($config['upload_path'], 0777, TRUE);
                $this->load->library('upload');
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('userfile')) {
                    $this->ajax_response['type'] = 'warning';
                    $error['userfile'] = strip_tags($this->upload->display_errors());
                    $this->ajax_response['message'] = $error;
                }
            }

            if ($this->form_validation->run() == TRUE && empty($error)) {
                if (!$this->upload->do_upload('userfile')) {
                    $this->ajax_response['type'] = 'warning';
                    $error['userfile'] = strip_tags($this->upload->display_errors());
                    $this->ajax_response['message'] = $error;
                } else {
                    $data = array('upload_data' => $this->upload->data());

                    $manuText = set_value('Manufacturer');
                    $search['name'] = $manuText;
                    $Manufacturer = $this->Manufacturer_model->search($search);
                    if (isset($Manufacturer->id)) {
                        $update['Manufacturer'] = $Manufacturer->id;
                    }

                    $ptypeText = set_value('ProductType');
                    $search['name'] = $ptypeText;
                    $ProductType = $this->ProductTypes_model->search($search);
                    if (isset($ProductType->id)) {
                        $update['ProductType'] = $ProductType->id;
                    }

                    $update['Name'] = set_value('Name');
                    $update['ImageName'] = 'images/' . $this->input->post('category_id') . '/' . $data['upload_data']['file_name'];
                    $update['groupName'] = set_value('groupName');
                    $update['category_id'] = set_value('category_id');
                    $update['category1'] = set_value('category1');
                    $update['category2'] = set_value('category2');
                    $update['category3'] = set_value('category3');
                    $update['ProductId'] = set_value('ProductId');
                    $update['Unit'] = set_value('Unit');
                    $update['RSKnummer0'] = set_value('RSKnummer0');
                    $update['Tillverkarensartikelnummer0'] = set_value('Tillverkarensartikelnummer0');
                    $update['RSKnummer'] = set_value('RSKnummer');
                    $update['Tillverkarensartikelnummer'] = set_value('Tillverkarensartikelnummer');
                    $update['GTIN'] = set_value('GTIN');
                    $update['Produkt'] = set_value('Produkt');
                    $update['Produktnamn'] = set_value('Produktnamn');
                    $update['Dimension'] = set_value('Dimension');
                    $update['Storlek'] = set_value('Storlek');
                    $update['TryckFlodeTemp'] = set_value('TryckFlodeTemp');
                    $update['EffektEldata'] = set_value('EffektEldata');
                    $update['Funktion'] = set_value('Funktion');
                    $update['Utforande'] = set_value('Utforande');
                    $update['Farg'] = set_value('Farg');
                    $update['Ytbehandling'] = set_value('Ytbehandling');
                    $update['Material'] = set_value('Material');
                    $update['Standard'] = set_value('Standard');
                    $update['Ovriginfo'] = set_value('Ovriginfo');
                    $update['EgenbenamningSvensk'] = set_value('EgenbenamningSvensk');
                    $update['Varumarke'] = set_value('Varumarke');
                    $update['Tillverkarensproduktsida'] = set_value('Tillverkarensproduktsida');
                    $update['markera_populer'] = (set_value('markera_populer') != NULL) ? 1 : 0;
                    $update['status'] = 1;


                    $result = $this->Products_model->insert($update);

                    //$productTypeId = isset($ProductType->id) ? $ProductType->id : 0;
                    //$this->Products_model->change_protype_counting($productTypeId, 'insert');
//                    $session_message['type'] = 1;
//                    $session_message['title'] = 'Success!';
//                    $session_message['content'] = 'Product has been successfully added.';
                    $this->ajax_response['type'] = 'success';

                    $this->ajax_response['message'] = "Product has been successfully added.";
                }
            } else {
                $this->ajax_response['type'] = 'warning';
                foreach ($this->form_validation->error_array() as $key => $val) {
                    $error[$key] = $val;
                }

                $this->ajax_response['message'] = $error;
            }
        }
        echo json_encode($this->ajax_response);
    }

    public function ajaxproductupdate() {

        if ($this->input->is_ajax_request()) {
            $product_id = $this->input->post('id');
            $error = [];

            $this->load->library('form_validation');
            $this->form_validation->set_rules('Name', 'Name', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('groupName', 'Group', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('category_id', 'CategoryId', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('category1', 'Category1', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('category2', 'Category2', 'trim|max_length[250]');
            $this->form_validation->set_rules('category3', 'Category3', 'trim|max_length[250]');
            $this->form_validation->set_rules('Manufacturer', 'Manufacturer', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('ProductType', 'ProductType', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('ProductId', 'ProductId', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('Unit', 'Unit', 'trim|max_length[250]');
            $this->form_validation->set_rules('RSKnummer0', 'RSKnummer0', 'trim|required');
            $this->form_validation->set_rules('Tillverkarensartikelnummer0', 'Tillverkarensartikelnummer0', 'trim|max_length[250]');
            $this->form_validation->set_rules('RSKnummer', 'RSKnummer', 'trim|required|max_length[250]|max_length[250]');
            $this->form_validation->set_rules('Tillverkarensartikelnummer', 'Tillverkarensartikelnummer', 'trim|max_length[250]');
            $this->form_validation->set_rules('GTIN', 'GTIN', 'trim');
            $this->form_validation->set_rules('Produkt', 'Produkt', 'trim');
            $this->form_validation->set_rules('Produktnamn', 'Produktnamn', 'trim');
            $this->form_validation->set_rules('Dimension', 'Dimension', 'trim');
            $this->form_validation->set_rules('Storlek', 'Storlek', 'trim');
            $this->form_validation->set_rules('TryckFlodeTemp', 'TryckFlodeTemp', 'trim');
            $this->form_validation->set_rules('EffektEldata', 'EffektEldata', 'trim');
            $this->form_validation->set_rules('Funktion', 'Funktion', 'trim');
            $this->form_validation->set_rules('Utforande', 'Utforande', 'trim');
            $this->form_validation->set_rules('Farg', 'Farg', 'trim');
            $this->form_validation->set_rules('Ytbehandling', 'Ytbehandling', 'trim');
            $this->form_validation->set_rules('Material', 'Material', 'trim');
            $this->form_validation->set_rules('Standard', 'Standard', 'trim');
            $this->form_validation->set_rules('Ovriginfo', 'Ovriginfo', 'trim');
            $this->form_validation->set_rules('EgenbenamningSvensk', 'EgenbenamningSvensk', 'trim');
            $this->form_validation->set_rules('Varumarke', 'Varumarke', 'trim');
            $this->form_validation->set_rules('Tillverkarensproduktsida', 'Tillverkarensproduktsida', 'trim');

            $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
//                $this->form_validation->set_message('required', 'Required.');
            $this->form_validation->set_message('matches', 'The %s does not match the %s.');
            $this->form_validation->set_message('min_length', 'The %s must be at least %s characters in length..');
            $this->form_validation->set_message('max_length', 'The %s cannot exceed %s characters in length.');

            $new_name = $this->input->post('RSKnummer');


            if ($this->form_validation->run() == TRUE) {
                $config = array(
                    'upload_path' => './images/' . $this->input->post('category_id'),
                    'allowed_types' => "jpg|png|jpeg",
//                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => TRUE,
                    'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    'max_height' => "768",
                    'max_width' => "1024",
                    'file_name' => $new_name,
                );
                if (!is_dir($config['upload_path']))
                    mkdir($config['upload_path'], 0777, TRUE);
                $this->load->library('upload');
                $this->upload->initialize($config);
                if ($_FILES['userfile']['name'] != '') {
                    if (!$this->upload->do_upload('userfile')) {
                        $this->ajax_response['type'] = 'warning';
                        $error['userfile'] = strip_tags($this->upload->display_errors());
                    } else {
                        $data = array('upload_data' => $this->upload->data());

                        $manuText = set_value('Manufacturer');
                        $search['name'] = $manuText;
                        $Manufacturer = $this->Manufacturer_model->search($search);
                        if (isset($Manufacturer->id)) {
                            $update['Manufacturer'] = $Manufacturer->id;
                        }

                        $ptypeText = set_value('ProductType');
                        $search['name'] = $ptypeText;
                        $ProductType = $this->ProductTypes_model->search($search);
                        if (isset($ProductType->id)) {
                            $update['ProductType'] = $ProductType->id;
                        }

                        $update['Name'] = set_value('Name');
                        $update['ImageName'] = 'images/' . $this->input->post('category_id') . '/' . $data['upload_data']['file_name'];
                        $update['groupName'] = set_value('groupName');
                        $update['category_id'] = set_value('category_id');
                        $update['category1'] = set_value('category1');
                        $update['category2'] = set_value('category2');
                        $update['category3'] = set_value('category3');
                        $update['ProductId'] = set_value('ProductId');
                        $update['Unit'] = set_value('Unit');
                        $update['RSKnummer0'] = set_value('RSKnummer0');
                        $update['Tillverkarensartikelnummer0'] = set_value('Tillverkarensartikelnummer0');
                        $update['RSKnummer'] = set_value('RSKnummer');
                        $update['Tillverkarensartikelnummer'] = set_value('Tillverkarensartikelnummer');
                        $update['GTIN'] = set_value('GTIN');
                        $update['Produkt'] = set_value('Produkt');
                        $update['Produktnamn'] = set_value('Produktnamn');
                        $update['Dimension'] = set_value('Dimension');
                        $update['Storlek'] = set_value('Storlek');
                        $update['TryckFlodeTemp'] = set_value('TryckFlodeTemp');
                        $update['EffektEldata'] = set_value('EffektEldata');
                        $update['Funktion'] = set_value('Funktion');
                        $update['Utforande'] = set_value('Utforande');
                        $update['Farg'] = set_value('Farg');
                        $update['Ytbehandling'] = set_value('Ytbehandling');
                        $update['Material'] = set_value('Material');
                        $update['Standard'] = set_value('Standard');
                        $update['Ovriginfo'] = set_value('Ovriginfo');
                        $update['EgenbenamningSvensk'] = set_value('EgenbenamningSvensk');
                        $update['Varumarke'] = set_value('Varumarke');
                        $update['Tillverkarensproduktsida'] = set_value('Tillverkarensproduktsida');
                        $update['markera_populer'] = (set_value('markera_populer') != NULL) ? 1 : 0;
                        $update['status'] = 1;

                        $this->Products_model->update($update, $product_id);
//                    $session_message['type'] = 1;
//                    $session_message['title'] = 'Success!';
//                    $session_message['content'] = 'Product has been successfully updated.';
                        $this->ajax_response['type'] = 'success';
                        $this->ajax_response['message'] = "Product has been successfully updated.";
                    }
                } else {

                    $data = array('upload_data' => $this->upload->data());

                    $manuText = set_value('Manufacturer');
                    $search['name'] = $manuText;
                    $Manufacturer = $this->Manufacturer_model->search($search);
                    if (isset($Manufacturer->id)) {
                        $update['Manufacturer'] = $Manufacturer->id;
                    }

                    $ptypeText = set_value('ProductType');
                    $search['name'] = $ptypeText;
                    $ProductType = $this->ProductTypes_model->search($search);
                    if (isset($ProductType->id)) {
                        $update['ProductType'] = $ProductType->id;
                    }

                    $update['Name'] = set_value('Name');
                    $update['groupName'] = set_value('groupName');
                    $update['category_id'] = set_value('category_id');
                    $update['category1'] = set_value('category1');
                    $update['category2'] = set_value('category2');
                    $update['category3'] = set_value('category3');
                    $update['ProductId'] = set_value('ProductId');
                    $update['Unit'] = set_value('Unit');
                    $update['RSKnummer0'] = set_value('RSKnummer0');
                    $update['Tillverkarensartikelnummer0'] = set_value('Tillverkarensartikelnummer0');
                    $update['RSKnummer'] = set_value('RSKnummer');
                    $update['Tillverkarensartikelnummer'] = set_value('Tillverkarensartikelnummer');
                    $update['GTIN'] = set_value('GTIN');
                    $update['Produkt'] = set_value('Produkt');
                    $update['Produktnamn'] = set_value('Produktnamn');
                    $update['Dimension'] = set_value('Dimension');
                    $update['Storlek'] = set_value('Storlek');
                    $update['TryckFlodeTemp'] = set_value('TryckFlodeTemp');
                    $update['EffektEldata'] = set_value('EffektEldata');
                    $update['Funktion'] = set_value('Funktion');
                    $update['Utforande'] = set_value('Utforande');
                    $update['Farg'] = set_value('Farg');
                    $update['Ytbehandling'] = set_value('Ytbehandling');
                    $update['Material'] = set_value('Material');
                    $update['Standard'] = set_value('Standard');
                    $update['Ovriginfo'] = set_value('Ovriginfo');
                    $update['EgenbenamningSvensk'] = set_value('EgenbenamningSvensk');
                    $update['Varumarke'] = set_value('Varumarke');
                    $update['Tillverkarensproduktsida'] = set_value('Tillverkarensproduktsida');
                    $update['markera_populer'] = (set_value('markera_populer') != NULL) ? 1 : 0;
                    $update['status'] = 1;


                    $this->Products_model->update($update, $product_id);
//                    $session_message['type'] = 1;
//                    $session_message['title'] = 'Success!';
//                    $session_message['content'] = 'Product has been successfully updated.';
                    $this->ajax_response['type'] = 'success';
                    $this->ajax_response['message'] = "Product has been successfully updated.";
                }
            } else {
                $this->ajax_response['type'] = 'warning';
                foreach ($this->form_validation->error_array() as $key => $val) {
                    $error[$key] = $val;
                }

                $this->ajax_response['message'] = $error;
            }
        }
        echo json_encode($this->ajax_response);
    }

    public function ajaxproductdelete() {

        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('id');
            $product = $this->Products_model->find_product_by_id($id);
            //$productTypeId = isset($product->id) ? $product->id : 0;

            $sql_del = $this->Products_model->delete($id);
            if ($sql_del) {
                //$this->Products_model->change_protype_counting($productTypeId, 'delete');
                $this->ajax_response['type'] = 'success';
                $this->ajax_response['message'] = "Product has been deleted Successfully!!";
            } else {
                $this->ajax_response['type'] = 'warning';
                $this->ajax_response['message'] = "Product not deleted!!";
            }
        }
        echo json_encode($this->ajax_response);
    }

    public function import_products() {
        
        ini_set('max_execution_time', 0);
        //ini_set('max_input_time', 0);
        //set_time_limit(0);
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
        
        set_page_title(ucwords("Import Products"));
        if ($this->input->method(TRUE) == "POST") {
            $error = false;

            if (isset($_FILES['import_products_file'])) {
                if ($_FILES['import_products_file']['error'] == 0) {
                    $imgExt = array("xls", 'xlsx', 'csv');

                    $imgArr = explode('.', $_FILES['import_products_file']['name']);
                    $uploadedFileExt = end($imgArr);

                    if (in_array(strtolower($uploadedFileExt), $imgExt)) {

                        $filePathArr = explode("controllers", __FILE__);
                        require_once($filePathArr[0] . '/libraries/excel-reader/php-excel-reader/excel_reader2.php');
                        require_once($filePathArr[0] . '/libraries/excel-reader/SpreadsheetReader.php');
                        $fileName = time() . "_" . $_FILES['import_products_file']['name'];
                        $uploadPathFile = FCPATH . '/uploads/import_file/';

                        if (move_uploaded_file($_FILES['import_products_file']['tmp_name'], $uploadPathFile . $fileName)) {

                            try {
                                $Spreadsheet = new SpreadsheetReader($uploadPathFile . $fileName);

                                $Sheets = $Spreadsheet->Sheets();

                                $Spreadsheet->ChangeSheet($Sheets[0]);
                                $not_inserted_rows = 0;
                                foreach ($Spreadsheet as $Key => $Row) {
                                    if (trim($Row[0]) != "" && trim($Row[1]) != "") {
                                        if ($Key == 0) {
                                            if (
                                                    strcasecmp(strtolower(str_replace(" ", "", trim($Row[0]))), strtolower("RSKnumber")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[1]))), strtolower("Productname")) == 0
                                            ) {
                                                
                                            } else {
                                                $error = true;
                                                break;
                                            }
                                        } else {

                                                $checkGroup = $this->Products_model->find_rsknumber(trim($Row[0]));
                                                
                                                if($checkGroup != NULL) {
                                                    $updateSql = "UPDATE products SET Name='".str_replace("'", "", trim($Row[1]))."' WHERE id='$checkGroup->id'";
                                                    //echo $updateSql . '<br>';
                                                    $this->db->query($updateSql);
                                                    //echo $checkGroup->id . ' ' . $Row[1] . '<br>';
                                                }
                                                
                                                /*if(!empty($checkGroup)) {
                                                    $where = array('RSKnummer' => trim($Row[0]));
                                                    $update = array();
                                                    $update['Name'] = trim($Row[1]);
                                                    //$this->Products_model->update_where($update, $where);
                                                    //$update['RSKnummer'] = str_replace(" ", "", trim($Row[0]));
                                                    $result = $this->Products_model->update($update, $checkGroup->id);
                                                }*/
                                                    
                                                //}
                                                //echo $checkGroup->id;
                                                //var_dump($checkGroup);
                                                /*if (empty($checkGroup)) {
                                                    echo $Row[0] . ' - ' . $Row[0] . ' does not exist.<br>';
                                                    //$update = array();
                                                    //$update['Name'] = trim($Row[1]);

                                                    
                                                    //$update['RSKnummer'] = str_replace(" ", "", trim($Row[0]));
                                                    

                                                    //$result = $this->Products_model->insert($update);

                                                    
                                                } else {
                                                    $update = array();
                                                    $update['Name'] = trim($Row[1]);
                                                    //$update['RSKnummer'] = str_replace(" ", "", trim($Row[0]));
                                                    $result = $this->Products_model->update($update, $checkGroup->id);
                                                    echo $Row[0] . ' - ' . $Row[0] . ' updated. ' . $checkGroup->id . '<br>';
                                                }*/
                                            }
                                    } else {
                                    }
                                }
                                if ($error == true) {
                                    $session_message['type'] = 2;
                                    $session_message['title'] = 'Warning!';
                                    $session_message['content'] = 'Excel/CSV file columns are not match.';
                                    $this->session->set_flashdata('message', $session_message);
                                    unlink($uploadPathFile . $fileName);
                                    redirect('admin/products/import_products');
                                } else {
                                    echo 'Import is successfully completed...!';
                                    /*$session_message['type'] = 1;
                                    $session_message['title'] = 'Success!';
                                    if ($not_inserted_rows > 0) {
                                        $session_message['content'] = 'Your Products has been uploaded successfully.' . $not_inserted_rows . ' rows not updated due to insufficient data.';
                                    } else {
                                        $session_message['content'] = 'Your Products has been uploaded successfully.';
                                    }
                                    $this->session->set_flashdata('message', $session_message);
                                    unlink($uploadPathFile . $fileName);
                                    redirect("admin/products");*/
                                }
                            } catch (Exception $E) {
                                echo $E->getMessage();
                            }
                            unlink($uploadPathFile . $fileName);
                        }
                    } else {
                        $session_message['type'] = 2;
                        $session_message['title'] = 'Warning!';
                        $session_message['content'] = "Only files with the following extensions are accepted: xls, xlsx, csv";
                        $this->session->set_flashdata('message', $session_message);
                        redirect('admin/products/import_products');
                    }
                } else {
                    $session_message['type'] = 2;
                    $session_message['title'] = 'Warning!';
                    $session_message['content'] = "Uploaded File Error. Please try again.";
                    $this->session->set_flashdata('message', $session_message);
                    redirect('admin/products/import_products');
                }
            } else {
                $session_message['type'] = 2;
                $session_message['title'] = 'Warning!';
                $session_message['content'] = "Sorry! Your request can't proced";
                $this->session->set_flashdata('message', $session_message);
                redirect('admin/products/import_products');
            }
        } else {
            $data['content'] = $this->load->view('admin/products/import', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
        }
        //$data['content'] = $this->load->view('admin/products/import', $this->data, TRUE);
        //$this->load->view('layouts/admin', $data);
    }


    public function import_product() {
        set_page_title(ucwords("Import Products"));
        if ($this->input->method(TRUE) == "POST") {
            $error = false;

            if (isset($_FILES['import_products_file'])) {
                if ($_FILES['import_products_file']['error'] == 0) {
                    $imgExt = array("xls", 'xlsx', 'csv');

                    $imgArr = explode('.', $_FILES['import_products_file']['name']);
                    $uploadedFileExt = end($imgArr);

                    if (in_array(strtolower($uploadedFileExt), $imgExt)) {

                        $filePathArr = explode("controllers", __FILE__);
                        require_once($filePathArr[0] . '/libraries/excel-reader/php-excel-reader/excel_reader2.php');
                        require_once($filePathArr[0] . '/libraries/excel-reader/SpreadsheetReader.php');
                        $fileName = time() . "_" . $_FILES['import_products_file']['name'];
                        $uploadPathFile = FCPATH . '/uploads/import_file/';

                        if (move_uploaded_file($_FILES['import_products_file']['tmp_name'], $uploadPathFile . $fileName)) {

                            try {
                                $Spreadsheet = new SpreadsheetReader($uploadPathFile . $fileName);

                                $Sheets = $Spreadsheet->Sheets();

                                $Spreadsheet->ChangeSheet($Sheets[0]);
                                $not_inserted_rows = 0;
                                foreach ($Spreadsheet as $Key => $Row) {
                                    if (trim($Row[0]) != "") {
                                        if ($Key == 0) {
                                            if (
                                                    strcasecmp(strtolower(str_replace(" ", "", trim($Row[0]))), strtolower("Name")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[1]))), strtolower("Image(link)")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[2]))), strtolower("groupName")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[3]))), strtolower("category_id")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[4]))), strtolower("category1")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[5]))), strtolower("category2")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[6]))), strtolower("category3")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[7]))), strtolower("Manufacturer")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[8]))), strtolower("ProductType")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[9]))), strtolower("ProductId")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[10]))), strtolower("Unit")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[11]))), strtolower("RSKnummer0")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[12]))), strtolower("Tillverkarensartikelnummer0")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[13]))), strtolower("RSKnummer")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[14]))), strtolower("Tillverkarensartikelnummer")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[15]))), strtolower("GTIN")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[16]))), strtolower("Produkt")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[17]))), strtolower("Produktnamn")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[18]))), strtolower("Dimension")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[19]))), strtolower("Storlek")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[20]))), strtolower("TryckFlodeTemp")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[21]))), strtolower("EffektEldata")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[22]))), strtolower("Funktion")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[23]))), strtolower("Utforande")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[24]))), strtolower("Farg")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[25]))), strtolower("Ytbehandling")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[26]))), strtolower("Material")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[27]))), strtolower("Standard")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[28]))), strtolower("Ovriginfo")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[29]))), strtolower("EgenbenamningSvensk")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[30]))), strtolower("Varumarke")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[31]))), strtolower("Tillverkarensproduktsida")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[32]))), strtolower("status")) == 0
                                            ) {
                                                
                                            } else {
                                                $error = true;
                                                break;
                                            }
                                        } else {
                                            if (trim($Row[0]) != "" && trim($Row[2]) != "" && trim($Row[3]) != "" && trim($Row[4]) != "" && trim($Row[5]) != "" && trim($Row[6]) != "" && trim($Row[7]) != "" && trim($Row[8]) != "" && trim($Row[9]) != "" && trim($Row[11]) != "" && trim($Row[13]) != "") {

                                                $checkGroup = $this->Products_model->find_rsknumber(trim($Row[13]));
                                                if (count($checkGroup) == 0) {
                                                    $update = array();
                                                    $update['Name'] = trim($Row[0]);

                                                    $update['groupName'] = $this->get_pro_group(trim($Row[2]));
                                                    $category_id = $this->get_pro_category(trim($Row[3]), trim($Row[5]), trim($Row[6]));
                                                    $category = $this->get_pro_category(trim($Row[4]), trim($Row[5]), trim($Row[6]));
                                                    $update['category_id'] = $category_id[0];
                                                    $update['category1'] = $category[0];
                                                    $update['category2'] = $category[1];
                                                    $update['category3'] = $category[2];

                                                    $imgPath = "";
                                                    $category_id1 = $category_id[0];
                                                    if (trim($Row[1]) != "" && $category_id1 != '') {
                                                        $imgurl = trim($Row[1]);
                                                        if ($this->check_image_url($imgurl)) {
                                                            $imgArr = explode(".", basename($imgurl));
                                                            $imagename = trim($Row[13]) . "." . end($imgArr);

                                                            $imgUploadPath = FCPATH . "/images/$category_id1/$imagename";
                                                            $imgPath = "images/$category_id1/$imagename";
                                                            $uploadPath = FCPATH . "/images/$category_id1";
                                                            if (!is_dir($uploadPath))
                                                                mkdir($uploadPath, 0777, TRUE);

                                                            $image = $this->getimg($imgurl);
                                                            file_put_contents($imgUploadPath, $image);
                                                        }
                                                    }
                                                    $update['ImageName'] = $imgPath;

                                                    $update['Manufacturer'] = $this->get_pro_manufacturer(trim($Row[7]));
                                                    $update['ProductType'] = $this->get_pro_product_type(trim($Row[8]));
                                                    $update['ProductId'] = trim($Row[9]);
                                                    $update['Unit'] = trim($Row[10]);
                                                    $update['RSKnummer0'] = trim($Row[11]);
                                                    $update['Tillverkarensartikelnummer0'] = trim($Row[12]);
                                                    $update['RSKnummer'] = str_replace(" ", "", trim($Row[13]));
                                                    $update['Tillverkarensartikelnummer'] = trim($Row[14]);
                                                    $update['GTIN'] = trim($Row[15]);
                                                    $update['Produkt'] = trim($Row[16]);
                                                    $update['Produktnamn'] = trim($Row[17]);
                                                    $update['Dimension'] = trim($Row[18]);
                                                    $update['Storlek'] = trim($Row[19]);
                                                    $update['TryckFlodeTemp'] = trim($Row[20]);
                                                    $update['EffektEldata'] = trim($Row[21]);
                                                    $update['Funktion'] = trim($Row[22]);
                                                    $update['Utforande'] = trim($Row[23]);
                                                    $update['Farg'] = trim($Row[24]);
                                                    $update['Ytbehandling'] = trim($Row[25]);
                                                    $update['Material'] = trim($Row[26]);
                                                    $update['Standard'] = trim($Row[27]);
                                                    $update['Ovriginfo'] = trim($Row[28]);
                                                    $update['EgenbenamningSvensk'] = trim($Row[29]);
                                                    $update['Varumarke'] = trim($Row[30]);
                                                    $update['Tillverkarensproduktsida'] = trim($Row[31]);
                                                    $update['status'] = trim($Row[32]);

                                                    $result = $this->Products_model->insert($update);

                                                    $productTypeId = (isset($update['ProductType']) && $update['ProductType'] > 0) ? $update['ProductType'] : 0;
                                                    $this->Products_model->change_protype_counting($productTypeId, 'insert');
                                                } else {
                                                    $update = array();
                                                    $update['Name'] = trim($Row[0]);
                                                    $update['groupName'] = $this->get_pro_group(trim($Row[2]));
                                                    $category_id = $this->get_pro_category(trim($Row[3]), trim($Row[5]), trim($Row[6]));
                                                    $category = $this->get_pro_category(trim($Row[4]), trim($Row[5]), trim($Row[6]));
                                                    $update['category_id'] = $category_id[0];
                                                    $update['category1'] = $category[0];
                                                    $update['category2'] = $category[1];
                                                    $update['category3'] = $category[2];
                                                    $imgPath = "";
                                                    $category_id1 = $category_id[0];
                                                    if (trim($Row[1]) != "" && $category_id1 != '') {
                                                        $imgurl = trim($Row[1]);
                                                        if ($this->check_image_url($imgurl)) {
                                                            $imgArr = explode(".", basename($imgurl));
                                                            $imagename = trim($Row[13]) . "." . end($imgArr);

                                                            $imgUploadPath = FCPATH . "/images/$category_id1/$imagename";
                                                            $imgPath = "images/$category_id1/$imagename";
                                                            $uploadPath = FCPATH . "/images/$category_id1";
                                                            if (!is_dir($uploadPath))
                                                                mkdir($uploadPath, 0777, TRUE);

                                                            $image = $this->getimg($imgurl);
                                                            file_put_contents($imgUploadPath, $image);
                                                        }
                                                    }
                                                    $update['ImageName'] = $imgPath;

                                                    $update['Manufacturer'] = $this->get_pro_manufacturer(trim($Row[7]));
                                                    $update['ProductType'] = $this->get_pro_product_type(trim($Row[8]));
                                                    $update['ProductId'] = trim($Row[9]);
                                                    $update['Unit'] = trim($Row[10]);
                                                    $update['RSKnummer0'] = trim($Row[11]);
                                                    $update['Tillverkarensartikelnummer0'] = trim($Row[12]);
                                                    $update['RSKnummer'] = str_replace(" ", "", trim($Row[13]));
                                                    $update['Tillverkarensartikelnummer'] = trim($Row[14]);
                                                    $update['GTIN'] = trim($Row[15]);
                                                    $update['Produkt'] = trim($Row[16]);
                                                    $update['Produktnamn'] = trim($Row[17]);
                                                    $update['Dimension'] = trim($Row[18]);
                                                    $update['Storlek'] = trim($Row[19]);
                                                    $update['TryckFlodeTemp'] = trim($Row[20]);
                                                    $update['EffektEldata'] = trim($Row[21]);
                                                    $update['Funktion'] = trim($Row[22]);
                                                    $update['Utforande'] = trim($Row[23]);
                                                    $update['Farg'] = trim($Row[24]);
                                                    $update['Ytbehandling'] = trim($Row[25]);
                                                    $update['Material'] = trim($Row[26]);
                                                    $update['Standard'] = trim($Row[27]);
                                                    $update['Ovriginfo'] = trim($Row[28]);
                                                    $update['EgenbenamningSvensk'] = trim($Row[29]);
                                                    $update['Varumarke'] = trim($Row[30]);
                                                    $update['Tillverkarensproduktsida'] = trim($Row[31]);
                                                    $update['status'] = trim($Row[32]);
                                                    $result = $this->Products_model->update($update, $checkGroup->id);
                                                }
                                            } else {
                                                $not_inserted_rows++;
                                            }
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
                                    $session_message['title'] = 'Warning!';
                                    $session_message['content'] = 'Excel/CSV file columns are not match.';
                                    $this->session->set_flashdata('message', $session_message);
                                    unlink($uploadPathFile . $fileName);
                                    redirect('admin/products/import_product');
                                } else {
                                    $session_message['type'] = 1;
                                    $session_message['title'] = 'Success!';
                                    if ($not_inserted_rows > 0) {
                                        $session_message['content'] = 'Your Products has been uploaded successfully.' . $not_inserted_rows . ' rows not updated due to insufficient data.';
                                    } else {
                                        $session_message['content'] = 'Your Products has been uploaded successfully.';
                                    }
                                    $this->session->set_flashdata('message', $session_message);
                                    unlink($uploadPathFile . $fileName);
                                    redirect("admin/products");
                                }
                            } catch (Exception $E) {
                                echo $E->getMessage();
                            }
                            unlink($uploadPathFile . $fileName);
                        }
                    } else {
                        $session_message['type'] = 2;
                        $session_message['title'] = 'Warning!';
                        $session_message['content'] = "Only files with the following extensions are accepted: xls, xlsx, csv";
                        $this->session->set_flashdata('message', $session_message);
                        redirect('admin/products/import_product');
                    }
                } else {
                    $session_message['type'] = 2;
                    $session_message['title'] = 'Warning!';
                    $session_message['content'] = "Uploaded File Error. Please try again.";
                    $this->session->set_flashdata('message', $session_message);
                    redirect('admin/products/import_product');
                }
            } else {
                $session_message['type'] = 2;
                $session_message['title'] = 'Warning!';
                $session_message['content'] = "Sorry! Your request can't proced";
                $this->session->set_flashdata('message', $session_message);
                redirect('admin/products/import_product');
            }
        }
        $data['content'] = $this->load->view('admin/products/import-products', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    public function get_pro_group($group_name) {
        $checkGroup = $this->Groups_model->find_group(trim($group_name));
        if (count($checkGroup) == 0) {
            $insertGroup = array();
            $insertGroup["name"] = trim($group_name);
            $insertGroup["slug"] = $this->geturlencodetext(trim($group_name));
            $insertGroup["group_image"] = NULL;
            $insertGroup["created"] = date("Y-m-d H:i:s");
            $insertGroup["updated"] = date("Y-m-d H:i:s");

            return $this->Groups_model->insert($insertGroup);
        } else {
            return $checkGroup->id;
        }
    }

    public function get_pro_category($cat1, $cat2, $cat3) {
        $mainCategoryId = $mainSubCategoryId = $subCategoryId = 0;
        $mainCategory = $this->Category_model->main_category(trim($cat1));
        if (count($mainCategory) <= 0) {
            $insertcategory = array();
            $insertcategory["name"] = trim($cat1);
            $insertcategory["slug"] = $this->geturlencodetext(trim($cat1));
            $insertcategory["mp"] = 'true';
            $insertcategory["pid"] = NULL;
            $insertcategory["pid2"] = NULL;
            $insertcategory["status"] = 'true';
            $insertcategory["created"] = date("Y-m-d H:i:s");
            $insertcategory["updated"] = date("Y-m-d H:i:s");

            $mainCategoryId = $this->Category_model->insert($insertcategory);
        } else {
            $mainCategoryId = $mainCategory->id;
        }

        if (trim($cat2) != "" && $mainCategoryId > 0) {
            $mainSubCategory = $this->Category_model->sub_main_category(trim($cat2), $mainCategoryId);
            if (count($mainSubCategory) <= 0) {
                $insertcategory = array();
                $insertcategory["name"] = trim($cat2);
                $insertcategory["slug"] = $this->geturlencodetext(trim($cat2));
                $insertcategory["mp"] = 'false';
                $insertcategory["pid"] = $mainCategoryId;
                $insertcategory["pid2"] = NULL;
                $insertcategory["status"] = 'true';
                $insertcategory["created"] = date("Y-m-d H:i:s");
                $insertcategory["updated"] = date("Y-m-d H:i:s");

                $mainSubCategoryId = $this->Category_model->insert($insertcategory);
            } else {
                $mainSubCategoryId = $mainSubCategory->id;
            }
        }

        if (trim($cat3) != "" && $mainCategoryId > 0 && $mainSubCategoryId > 0) {
            $subCategory = $this->Category_model->sub_category(trim($cat3), $mainCategoryId, $mainSubCategoryId);
            if (count($subCategory) <= 0) {
                $insertcategory = array();
                $insertcategory["name"] = trim($cat3);
                $insertcategory["slug"] = $this->geturlencodetext(trim($cat3));
                $insertcategory["mp"] = 'false';
                $insertcategory["pid"] = $mainCategoryId;
                $insertcategory["pid2"] = $mainSubCategoryId;
                $insertcategory["status"] = 'true';
                $insertcategory["created"] = date("Y-m-d H:i:s");
                $insertcategory["updated"] = date("Y-m-d H:i:s");

                $subCategoryId = $this->Category_model->insert($insertcategory);
            } else {
                $subCategoryId = $subCategory->id;
            }
        }
        $arr = ["$mainCategoryId", "$mainSubCategoryId", "$subCategoryId"];
        return $arr;
    }

    public function get_pro_manufacturer($group_name) {
        $checkManufacture = $this->Manufacturer_model->find_manufactures($group_name);
        if (count($checkManufacture) == 0) {
            $insertManufacture = array();
            $insertManufacture["name"] = $group_name;
            $insertManufacture["slug"] = $this->geturlencodetext($group_name);
            $insertManufacture["created"] = date("Y-m-d H:i:s");
            $insertManufacture["updated"] = date("Y-m-d H:i:s");

            $result = $this->Manufacturer_model->insert($insertManufacture);
        } else {
            $result = $checkManufacture->id;
        }
        return $result;
    }

    public function get_pro_product_type($group_name) {
        $checkProductType = $this->ProductTypes_model->find_product_types($group_name);
        if (count($checkProductType) == 0) {
            $insertManufacture = array();
            $insertManufacture["name"] = $group_name;
            $insertManufacture["slug"] = $this->geturlencodetext($group_name);
            $insertManufacture["status"] = 'true';
            $insertManufacture["created"] = date("Y-m-d H:i:s");
            $insertManufacture["updated"] = date("Y-m-d H:i:s");

            $result = $this->ProductTypes_model->insert($insertManufacture);
        } else {
            $result = $checkProductType->id;
        }
        return $result;
    }

    public function update_total_product() {
        $getAllProType = $this->ProductTypes_model->find_all_product_types();
        foreach ($getAllProType as $v) {
            $findPro = $this->db->select('t.id')
                    ->from("products as t")
                    ->where("t.ProductType LIKE '$v->id'")
                    ->count_all_results();
            $sql = "UPDATE ProductTypes SET total_pro = $findPro WHERE id = $v->id";
            $this->db->query($sql);
        }
    }
    
    
    
    
    
    
}