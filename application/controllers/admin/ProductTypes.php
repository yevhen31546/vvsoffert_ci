<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductTypes extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('site_helper');
        $this->load->library('session');
        $this->load->library('form_validation');

        $this->load->model('User_model');
        $this->load->model('ProductTypes_model');
        $this->load->model('Products_model');


        allow_if_logged_in();

        $this->data['pageDesc'] = '';
    }

//    public function index() {
//        set_page_title('Product Types');
//
//        $per_page = 50;
//
//        // Total Groups
//        $total_rows = $this->ProductTypes_model->nor();
//        $this->data['total_rows'] = $total_rows;
//
//        // Get Groups Products
//        if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
//            $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
//            $ProductTypes = $this->ProductTypes_model->get_all_with_count($start);
//            $this->data['ProductTypes'] = $ProductTypes;
//            $this->data['slno'] = $start + 1;
//        } else {
//            $ProductTypes = $this->ProductTypes_model->get_all_with_count();
//            $this->data['ProductTypes'] = $ProductTypes;
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
//        $config['base_url'] = site_url('admin/ProductTypes');
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
//
//        $data['content'] = $this->load->view('admin/ProductTypes', $this->data, TRUE);
//        $this->load->view('layouts/admin', $data);
//    }

    public function index() {
        set_page_title('Product Types');
        $_s_key = "";
        $_s_sort_by = "total_product";
        $_s_order_by = "DESC";
        $resp['crntPage'] = $_page_no = 1;

        $resp['limit'] = $limit = self::LIMIT_PER_PAGE;
        $resp['total_proType'] = $total_proType = $this->ProductTypes_model->total_protype_search_res($_s_key);
        
        $resp['proTypeData'] = $proTypeData = $this->ProductTypes_model->get_protype_search_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $_page_no);

        if (($total_proType % $limit) == 0) {
            $totalPages = $total_proType / $limit;
        } else {
            $totalPages = floor($total_proType / $limit) + 1;
        }
        $resp['totalPages'] = $totalPages;

        $data['content'] = $this->load->view('admin/productTypes/ProductTypes', $resp, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    // Edit Product Types
    public function edit($slug = 0) {
        if (empty($slug)) {
            redirect('admin/ProductTypes');
        }

        $search['slug'] = $slug;
        $productTypeInfo = $this->ProductTypes_model->search($search);
        if (empty($productTypeInfo))
            redirect('admin/ProductTypes');

        $this->data['productTypeInfo'] = $productTypeInfo;

        set_page_title('Product Types');

        $submit = set_value('submit');
        if ($submit == "save") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Group name', 'trim|required|max_length[250]');

            $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
            $this->form_validation->set_message('required', 'Required.');
            $this->form_validation->set_message('matches', 'The %s does not match the %s.');
            $this->form_validation->set_message('min_length', 'The %s must be at least %s characters in length..');
            $this->form_validation->set_message('max_length', 'The %s cannot exceed %s characters in length.');

            if ($this->form_validation->run() == TRUE) {
                $update['name'] = set_value('name');

                $config = array(
                    'field' => 'slug',
                    'title' => 'name',
                    'table' => 'ProductTypes',
                    'id' => 'id',
                );
                $this->load->library('Slug', $config);
                $slug = $this->slug->create_uri($update['name'], $productTypeInfo->id);
                $update['slug'] = $slug;

                $this->ProductTypes_model->update($update, $productTypeInfo->id);
                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = 'Product Type has been successfully saved.';
                $this->session->set_flashdata('message', $session_message);

                redirect('admin/ProductTypes');
            }
        }

        $data['content'] = $this->load->view('admin/productTypes/ProductTypes-edit', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    public function ajax_search_field_autocomplete() {
        if ($this->input->is_ajax_request()) {
            $_s_key = $_POST['_s_key'];

            $search_proTypes = $this->ProductTypes_model->ajax_search_field_autocomplete($_s_key);
            $autocompletteArr = array();
            if (count($search_proTypes) > 0) {
                foreach ($search_proTypes as $v) {
                    array_push($autocompletteArr, $v["name"]);
                }
            } else {
                array_push($autocompletteArr, ucwords("no result found"));
            }
            echo json_encode($autocompletteArr);
            exit;
        }
    }

    public function ajax_search() {
        if ($this->input->is_ajax_request()) {

            $_s_key = isset($_POST['_s_key']) ? trim($_POST['_s_key']) : "";
            $_s_sort_by = isset($_POST['_s_sort_by']) ? trim($_POST['_s_sort_by']) : "t.name";
            $_s_order_by = isset($_POST['_s_order_by']) ? trim($_POST['_s_order_by']) : "ASC";

            $resp['crntPage'] = $_page_no = isset($_POST['_page_no']) ? trim($_POST['_page_no']) : "1";

            $resp['limit'] = $limit = self::LIMIT_PER_PAGE;

            $resp['total_proType'] = $total_proType = $this->ProductTypes_model->total_protype_search_res($_s_key);
            $resp['proTypeData'] = $proTypeData = $this->ProductTypes_model->get_protype_search_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $_page_no);

            if (($total_proType % $limit) == 0) {
                $totalPages = $total_proType / $limit;
            } else {
                $totalPages = floor($total_proType / $limit) + 1;
            }
            $resp['totalPages'] = $totalPages;

            // Get Groups Products

            $resp["respHtml"] = $this->load->view('admin/_partial/_product_type_search_result', $resp, TRUE);
            echo json_encode($resp);
            exit;
        }
    }

    public function import_product_types() {
        set_page_title(ucwords("Import product types"));
        if ($this->input->method(TRUE) == "POST") {
            $error = false;

            if (isset($_FILES['import_products_types_file'])) {
                if ($_FILES['import_products_types_file']['error'] == 0) {
                    $imgExt = array("xls", 'xlsx', 'csv');

                    $imgArr = explode('.', $_FILES['import_products_types_file']['name']);
                    $uploadedFileExt = end($imgArr);

                    if (in_array(strtolower($uploadedFileExt), $imgExt)) {

                        $filePathArr = explode("controllers", __FILE__);
                        require_once($filePathArr[0] . '/libraries/excel-reader/php-excel-reader/excel_reader2.php');
                        require_once($filePathArr[0] . '/libraries/excel-reader/SpreadsheetReader.php');
                        $fileName = time() . "_" . $_FILES['import_products_types_file']['name'];
                        $uploadPath = FCPATH . '/uploads/import_file/';

                        if (move_uploaded_file($_FILES['import_products_types_file']['tmp_name'], $uploadPath . $fileName)) {

                            try {
                                $Spreadsheet = new SpreadsheetReader($uploadPath . $fileName);

                                $Sheets = $Spreadsheet->Sheets();

                                $Spreadsheet->ChangeSheet($Sheets[0]);

                                foreach ($Spreadsheet as $Key => $Row) {

                                    if (trim($Row[0]) != "") {
                                        if ($Key == 0) {
                                            if (strcasecmp(strtolower(str_replace(" ", "", trim($Row[0]))), strtolower("ProductType")) == 0) {
                                                
                                            } else {
                                                $error = true;
                                                break;
                                            }
                                        } else {
                                            $checkProductType = $this->ProductTypes_model->find_product_types(trim($Row[0]));
                                            if (count($checkProductType) == 0) {
                                                $insertManufacture = array();
                                                $insertManufacture["name"] = trim($Row[0]);
                                                $insertManufacture["slug"] = $this->geturlencodetext(trim($Row[0]));
                                                $insertManufacture["status"] = 'true';
                                                $insertManufacture["created"] = date("Y-m-d H:i:s");
                                                $insertManufacture["updated"] = date("Y-m-d H:i:s");

                                                $result = $this->ProductTypes_model->insert($insertManufacture);
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
                                    unlink($uploadPath . $fileName);
                                    redirect('admin/manufacturers/import_manufacturers');
                                } else {
                                    $session_message['type'] = 1;
                                    $session_message['title'] = 'Success!';
                                    $session_message['content'] = 'Your Product Types have been uploaded successfully.';
                                    $this->session->set_flashdata('message', $session_message);
                                    unlink($uploadPath . $fileName);
                                    redirect("admin/ProductTypes/index");
                                }
                            } catch (Exception $E) {
                                echo $E->getMessage();
                            }
                            unlink($uploadPath . $fileName);
                        }
                    } else {
                        $session_message['type'] = 2;
                        $session_message['title'] = 'Warning!';
                        $session_message['content'] = "Only files with the following extensions are accepted: xls, xlsx, csv";
                        $this->session->set_flashdata('message', $session_message);
                        redirect('admin/ProductTypes/import_product_types');
                    }
                } else {
                    $session_message['type'] = 2;
                    $session_message['title'] = 'Warning!';
                    $session_message['content'] = "Uploaded File Error. Please try again.";
                    $this->session->set_flashdata('message', $session_message);
                    redirect('admin/ProductTypes/import_product_types');
                }
            } else {
                $session_message['type'] = 2;
                $session_message['title'] = 'Warning!';
                $session_message['content'] = "Sorry! Your request can't proced";
                $this->session->set_flashdata('message', $session_message);
                redirect('admin/ProductTypes/import_product_types');
            }
        }
        $data['content'] = $this->load->view('admin/productTypes/import-product-types', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
    }

}
