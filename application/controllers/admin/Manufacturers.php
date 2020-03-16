<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturers extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('site_helper');
        $this->load->library('session');
        $this->load->library('form_validation');

        $this->load->model('User_model');
        $this->load->model('Manufacturer_model');
        $this->load->model('Products_model');


        allow_if_logged_in();

        $this->data['pageDesc'] = '';
    }

//    public function index() {
//        set_page_title('Manufacturers');
//
//        $per_page = 50;
//
//        // Total Groups
//        $total_rows = $this->Manufacturer_model->nor();
//        $this->data['total_rows'] = $total_rows;
//
//        // Get Groups Products
//        if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
//            $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
//            $Manufacturers = $this->Manufacturer_model->get_all_with_count($start);
//            $this->data['Manufacturers'] = $Manufacturers;
//            $this->data['slno'] = $start + 1;
//        } else {
//            $Manufacturers = $this->Manufacturer_model->get_all_with_count();
//            $this->data['Manufacturers'] = $Manufacturers;
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
//        $config['base_url'] = site_url('admin/manufacturers');
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
//        $data['content'] = $this->load->view('admin/manufacturers', $this->data, TRUE);
//        $this->load->view('layouts/admin', $data);
//    }

    public function index() {
        set_page_title('Manufacturers');

        $_s_key = "";
        $_s_sort_by = "t.name";
        $_s_order_by = "ASC";

        $resp['crntPage'] = $_page_no = 1;

        $resp['limit'] = $limit = self::LIMIT_PER_PAGE;
        $resp['total_menufacture'] = $total_menufacture = $this->Manufacturer_model->total_menufacture_search_res($_s_key);
        $resp['menufactureData'] = $menufactureData = $this->Manufacturer_model->get_menufacture_search_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $_page_no);


        if (($total_menufacture % $limit) == 0) {
            $totalPages = $total_menufacture / $limit;
        } else {
            $totalPages = floor($total_menufacture / $limit) + 1;
        }
        $resp['totalPages'] = $totalPages;

        $data['content'] = $this->load->view('admin/manufacturers/manufacturers', $resp, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    // Edit Manufacturer
    public function edit($slug = 0) {
        if (empty($slug)) {
            redirect('admin/manufacturers');
        }

        $search['slug'] = $slug;
        $ManufacturerInfo = $this->Manufacturer_model->search($search);
        if (empty($ManufacturerInfo))
            redirect('admin/manufacturers');

        $this->data['ManufacturerInfo'] = $ManufacturerInfo;

        set_page_title('Manufacturers');

        $this->load->library('form_validation');
        $submit = set_value('submit');
        if ($submit == "save") {
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
                    'table' => 'manufacturer',
                    'id' => 'id',
                );
                $this->load->library('Slug', $config);
                $slug = $this->slug->create_uri($update['name'], $ManufacturerInfo->id);
                $update['slug'] = $slug;

                $this->Manufacturer_model->update($update, $ManufacturerInfo->id);
                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = 'Manufacturers Name has been successfully saved.';
                $this->session->set_flashdata('message', $session_message);

                redirect('admin/manufacturers');
            }
        }

        $data['content'] = $this->load->view('admin/manufacturers/manufacturers-edit', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    public function ajax_search_field_autocomplete() {
        if ($this->input->is_ajax_request()) {
            $_s_key = $_POST['_s_key'];

            $search_manufactures = $this->Manufacturer_model->ajax_search_field_autocomplete($_s_key);
            $autocompletteArr = array();
            if (count($search_manufactures) > 0) {
                foreach ($search_manufactures as $v) {
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

            $resp['total_menufacture'] = $total_menufacture = $this->Manufacturer_model->total_menufacture_search_res($_s_key);
            $resp['menufactureData'] = $menufactureData = $this->Manufacturer_model->get_menufacture_search_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $_page_no);

            if (($total_menufacture % $limit) == 0) {
                $totalPages = $total_menufacture / $limit;
            } else {
                $totalPages = floor($total_menufacture / $limit) + 1;
            }
            $resp['totalPages'] = $totalPages;

            // Get Groups Products

            $resp["respHtml"] = $this->load->view('admin/_partial/_menufacture_search_result', $resp, TRUE);
            echo json_encode($resp);
            exit;
        }
    }

    public function import_manufacturers() {
        set_page_title(ucwords("Import Manufactures"));
        if ($this->input->method(TRUE) == "POST") {
            $error = false;

            if (isset($_FILES['import_manufacturers_file'])) {
                if ($_FILES['import_manufacturers_file']['error'] == 0) {
                    $imgExt = array("xls", 'xlsx', 'csv');

                    $imgArr = explode('.', $_FILES['import_manufacturers_file']['name']);
                    $uploadedFileExt = end($imgArr);

                    if (in_array(strtolower($uploadedFileExt), $imgExt)) {

                        $filePathArr = explode("controllers", __FILE__);
                        require_once($filePathArr[0] . '/libraries/excel-reader/php-excel-reader/excel_reader2.php');
                        require_once($filePathArr[0] . '/libraries/excel-reader/SpreadsheetReader.php');
                        $fileName = time() . "_" . $_FILES['import_manufacturers_file']['name'];
                        $uploadPath = FCPATH . '/uploads/import_file/';

                        if (move_uploaded_file($_FILES['import_manufacturers_file']['tmp_name'], $uploadPath . $fileName)) {

                            try {
                                $Spreadsheet = new SpreadsheetReader($uploadPath . $fileName);

                                $Sheets = $Spreadsheet->Sheets();

                                $Spreadsheet->ChangeSheet($Sheets[0]);

                                foreach ($Spreadsheet as $Key => $Row) {
                                    
                                    if (trim($Row[0]) != "") {
                                        if ($Key == 0) {
                                            if (strcasecmp(strtolower(str_replace(" ", "", trim($Row[0]))), strtolower("NAME")) == 0) {
                                                
                                            } else {
                                                $error = true;
                                                break;
                                            }
                                        } else {
                                            $checkManufacture = $this->Manufacturer_model->find_manufactures(trim($Row[0]));
                                            if (count($checkManufacture) == 0) {
                                                $insertManufacture = array();
                                                $insertManufacture["name"] = trim($Row[0]);
                                                $insertManufacture["slug"] = $this->geturlencodetext(trim($Row[0]));
                                                $insertManufacture["created"] = date("Y-m-d H:i:s");
                                                $insertManufacture["updated"] = date("Y-m-d H:i:s");

                                                $result = $this->Manufacturer_model->insert($insertManufacture);
                                            } else {
                                                $updateManufacture = array();
                                                $updateManufacture["name"] = trim($Row[0]);
                                                $updateManufacture["slug"] = $this->geturlencodetext(trim($Row[0]));
                                                $updateManufacture["updated"] = date("Y-m-d H:i:s");
                                                $result = $this->Manufacturer_model->update($updateManufacture, $checkManufacture->id);
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
                                    $session_message['content'] = 'Your Manufactures have been uploaded successfully.';
                                    $this->session->set_flashdata('message', $session_message);
                                    unlink($uploadPath . $fileName);
                                    redirect("admin/manufacturers/index");
                                }

//                foreach ($Sheets as $Index => $Name) {
//                    $Spreadsheet->ChangeSheet($Index);
//
//                    foreach ($Spreadsheet as $Key => $Row) {
//                        echo $Key . "<br/>";
//                        echo "<pre>";
//                        print_r($Row);
//                        echo "</pre>";
//                    }
//                }
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
                        redirect('admin/manufacturers/import_manufacturers');
                    }
                } else {
                    $session_message['type'] = 2;
                    $session_message['title'] = 'Warning!';
                    $session_message['content'] = "Uploaded File Error. Please try again.";
                    $this->session->set_flashdata('message', $session_message);
                    redirect('admin/manufacturers/import_manufacturers');
                }
            } else {
                $session_message['type'] = 2;
                $session_message['title'] = 'Warning!';
                $session_message['content'] = "Sorry! Your request can't proced";
                $this->session->set_flashdata('message', $session_message);
                redirect('admin/groups/import_groupsmanufacturers/import_manufacturers');
            }
        }
        $data['content'] = $this->load->view('admin/manufacturers/import-manufacturers', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
    }

}
