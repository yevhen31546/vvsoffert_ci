<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Estore extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('site_helper');
        $this->load->library('session');
        $this->load->library('form_validation');

        $this->load->model('Estore_model');


        allow_if_logged_in();

        $this->data['pageDesc'] = '';
    }

    public function index() {
        set_page_title('E-Store');

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

        $data['content'] = $this->load->view('admin/estore/e-store', $resp, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    public function ajax_search_field_autocomplete() {
        if ($this->input->is_ajax_request()) {
            $_s_key = $_POST['_s_key'];

            $autocomplete_data = $this->Estore_model->ajax_search_field_autocomplete($_s_key);
            $autocompletteArr = array();
            if (count($autocomplete_data) > 0) {
                foreach ($autocomplete_data as $v) {
                    array_push($autocompletteArr, $v->name);
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
            $_s_key = isset($_POST['s_key']) ? trim($_POST['s_key']) : "";
            $_s_sort_by = isset($_POST['s_sort_by']) ? trim($_POST['s_sort_by']) : "t.name";
            $_s_order_by = isset($_POST['s_order_by']) ? trim($_POST['s_order_by']) : "ASC";
            $resp['crntPage'] = $_page_no = isset($_POST['_page_no']) ? trim($_POST['_page_no']) : "1";

            $resp['_limit'] = $_limit = self::LIMIT_PER_PAGE;
            $resp['total_stores'] = $total_stores = $this->Estore_model->count_total_store($_s_key);
            $resp['storeData'] = $storeData = $this->Estore_model->get_search_store_result($_s_key, $_limit, $_page_no, $_s_sort_by, $_s_order_by);

            if (($total_stores % $_limit) == 0) {
                $totalPages = $total_stores / $_limit;
            } else {
                $totalPages = floor($total_stores / $_limit) + 1;
            }
            $resp['totalPages'] = $totalPages;

            // Get Groups Products

            $resp["respHtml"] = $this->load->view('admin/_partial/_estore_search_result', $resp, TRUE);
            echo json_encode($resp);
            exit;
        }
    }

    public function create() {
        if ($this->input->is_ajax_request()) {
            $resp['flag'] = false;

            $this->form_validation->set_rules('name', 'Store Name', 'trim|required|max_length[250]');
            $this->form_validation->set_message('matches', 'The %s does not match the %s.');
            $this->form_validation->set_message('min_length', 'The %s must be at least %s characters in length..');
            $this->form_validation->set_message('max_length', 'The %s cannot exceed %s characters in length.');

            if ($this->form_validation->run() === TRUE) {
                $newStore["name"] = set_value("name");
                $newStore["status"] = 1;
                $newStore["created_at"] = date("Y-m-d H:i:s");
                $newStore["updated_at"] = date("Y-m-d H:i:s");

                $result = $this->Estore_model->insert($newStore);
                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = 'Store has been created Successfully.';
                $this->session->set_flashdata('message', $session_message);
                $resp['flag'] = true;
                $resp['redirectUrl'] = site_url('admin/estore/index');
            } else {
                $errors = $this->form_validation->error_array();

                $resp['errors'] = $errors;
            }
            echo json_encode($resp);
            exit;
        }
        set_page_title('Create Store');

        $this->data['content'] = $this->load->view('admin/estore/estore-add', $this->data, true);
        $this->load->view('layouts/admin', $this->data);
    }

    // Edit Groups
    public function edit($id = 0) {
        if ($this->input->is_ajax_request()) {
            $resp['flag'] = false;

            $this->form_validation->set_rules('name', 'Store Name', 'trim|required|max_length[250]');
            $this->form_validation->set_message('matches', 'The %s does not match the %s.');
            $this->form_validation->set_message('min_length', 'The %s must be at least %s characters in length..');
            $this->form_validation->set_message('max_length', 'The %s cannot exceed %s characters in length.');

            if ($this->form_validation->run() === TRUE) {

                $storeId = isset($_POST['store_id']) ? trim($_POST['store_id']) : 0;

                $updateStore["name"] = set_value("name");
                $updateStore["status"] = 1;
                $updateStore["updated_at"] = date("Y-m-d H:i:s");

                $result = $this->Estore_model->update($updateStore, $storeId);

                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = 'Store has been updated Successfully.';
                $this->session->set_flashdata('message', $session_message);
                $resp['flag'] = true;
                $resp['redirectUrl'] = site_url('admin/estore/index');
            } else {
                $errors = $this->form_validation->error_array();

                $resp['errors'] = $errors;
            }
            echo json_encode($resp);
            exit;
        }

        if (empty($id)) {
            redirect('admin/estore/index');
        }

        $storeInfo = $this->Estore_model->find($id);
        if (empty($storeInfo))
            redirect('admin/estore/index');
        $this->data['storeInfo'] = $storeInfo;

        set_page_title('Update Store');

        $data['content'] = $this->load->view('admin/estore/estore-edit', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    // Delete Groups
    public function delete($id = 0) {
        if (empty($id)) {
            redirect('admin/estore/index');
        }

        $storeInfo = $this->Estore_model->find($id);

        if (empty($storeInfo)) {
            redirect('admin/estore/index');
        } else {
            $checkE_Product = $this->Estore_model->check_eproduct($id);

            if ($checkE_Product > 0) {
                $session_message['type'] = 2;
                $session_message['title'] = 'Warning!';
                $session_message['content'] = 'Some product are present in this group. So you are unable to delete this Store.';
                $this->session->set_flashdata('message', $session_message);
            } else {
                $deleteEStore = $this->Estore_model->delete($storeInfo->id);
                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = 'Store has been deleted.';
                $this->session->set_flashdata('message', $session_message);
            }
            redirect('admin/estore/index');
        }
    }

    public function estore_data($storeId = 0, $storeName = "") {
        $findStore = $this->Estore_model->find($storeId);

        if (count($findStore) == 0)
            $this->agent->referrer();

        set_page_title(ucwords($findStore->name) . " - Products");

        $_s_key = "";
        $_s_sort_by = "t.product_name";
        $_s_order_by = "ASC";

        $this->data['crntPage'] = $_page_no = 1;

        $this->data['_limit'] = $_limit = self::LIMIT_PER_PAGE;
        $this->data["storeDetails"] = $findStore;
        $this->data["total_store_product"] = $total_store_product = $this->Estore_model->total_store_products($findStore->id, $_s_key);
        $this->data["store_product_data"] = $store_product_data = $this->Estore_model->find_store_products($findStore->id, $_s_key, $_limit, $_page_no, $_s_sort_by, $_s_order_by);

        if (($total_store_product % $_limit) == 0) {
            $totalPages = $total_store_product / $_limit;
        } else {
            $totalPages = floor($total_store_product / $_limit) + 1;
        }
        $this->data['totalPages'] = $totalPages;

        $data['content'] = $this->load->view('admin/estore/e-store-products', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    public function ajax_store_product_search_field_autocomplete() {
        if ($this->input->is_ajax_request()) {
            $_s_key = $_POST['_s_key'];
            $_s_store = $_POST['_s_store'];

            $autocomplete_data = $this->Estore_model->ajax_store_product_search_field_autocomplete($_s_store, $_s_key);
            $autocompletteArr = array();
            if (count($autocomplete_data) > 0) {
                foreach ($autocomplete_data as $v) {
                    if (strpos(strtolower($v->product_name), strtolower($_s_key)) !== false) {
                        array_push($autocompletteArr, $v->product_name);
                    } else {
                        array_push($autocompletteArr, $v->rsk_no);
                    }
                }
            } else {
                array_push($autocompletteArr, ucwords("no result found"));
            }
            echo json_encode($autocompletteArr);
            exit;
        }
    }

    public function ajax_store_product_search() {
        if ($this->input->is_ajax_request()) {
            $_s_key = isset($_POST['s_key']) ? trim($_POST['s_key']) : "";
            $s_store = isset($_POST['s_store']) ? trim($_POST['s_store']) : "";
            $_s_sort_by = isset($_POST['s_sort_by']) ? trim($_POST['s_sort_by']) : "t.product_name";
            $_s_order_by = isset($_POST['s_order_by']) ? trim($_POST['s_order_by']) : "ASC";

            $this->data["storeDetails"] = $findStore = $this->Estore_model->find($s_store);

            $this->data['crntPage'] = $_page_no = isset($_POST['_page_no']) ? trim($_POST['_page_no']) : "1";

            $this->data['_limit'] = $_limit = self::LIMIT_PER_PAGE;
            $this->data["total_store_product"] = $total_store_product = $this->Estore_model->total_store_products($findStore->id, $_s_key);
            $this->data["store_product_data"] = $store_product_data = $this->Estore_model->find_store_products($findStore->id, $_s_key, $_limit, $_page_no, $_s_sort_by, $_s_order_by);

            if (($total_store_product % $_limit) == 0) {
                $totalPages = $total_store_product / $_limit;
            } else {
                $totalPages = floor($total_store_product / $_limit) + 1;
            }
            $this->data['totalPages'] = $totalPages;

            // Get Groups Products

            $resp["respHtml"] = $this->load->view('admin/_partial/_estore_product_search_result', $this->data, TRUE);
            echo json_encode($resp);
            exit;
        }
    }

    public function import_product($storeId = 0) {
        $findStore = $this->Estore_model->find($storeId);
        if (count($findStore) == 0)
            $this->agent->referrer();

        set_page_title(ucwords($findStore->name) . ": Upload Products");

        $this->data["storeInfo"] = $findStore;


        $data['content'] = $this->load->view('admin/estore/e-store-upload-products', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    public function upload_product() {
        ini_set('max_execution_time', 0);
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
        $count1 = 0;
        $productRSKArray = [];
        $productArray = [];

        $error = false;
        $uploadFile = false;
        $importType = $this->input->post("pro_import_type");
        if (isset($_FILES['product_file']) && isset($_POST['store_id'])) {
            $storeId = $_POST['store_id'];
            $storeInfo = $this->Estore_model->find($storeId);
            if ($_FILES['product_file']['error'] == 0) {
                $imgExt = array("xls", 'xlsx');
                $imgArr = explode('.', $_FILES['product_file']['name']);
                $uploadedFileExt = end($imgArr);
                if (in_array(strtolower($uploadedFileExt), $imgExt)) {
                    $filePathArr = explode("controllers", __FILE__);
                    require_once($filePathArr[0] . '/libraries/excel-reader/php-excel-reader/excel_reader2.php');
                    require_once($filePathArr[0] . '/libraries/excel-reader/SpreadsheetReader.php');
                    $fileName = rand(1000, 9999) . "_" . time() . "." . $uploadedFileExt;
                    $uploadPath = FCPATH . '/uploads/import_file/';
                    if (move_uploaded_file($_FILES['product_file']['tmp_name'], $uploadPath . $fileName)) {
                        try {
                            $Spreadsheet = new SpreadsheetReader($uploadPath . $fileName);
                            $Sheets = $Spreadsheet->Sheets();
                            $Spreadsheet->ChangeSheet($Sheets[0]);
                            if ($importType != "" && $importType > 0) {
                                foreach ($Spreadsheet as $Key => $Row) {
                                    if (trim($Row[0]) != "" && trim($Row[1]) != "") {
                                        if ($Key == 0) {
                                            if ($importType == 1 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[0]))), strtolower("RSKnumber")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[1]))), strtolower("Price")) == 0) {
                                                
                                            } elseif ($importType == 2 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[0]))), strtolower("RSKnumber")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[1]))), strtolower("DiscountPrice")) == 0) {
                                                
                                            } elseif ($importType == 3 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[0]))), strtolower("RSKnumber")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[1]))), strtolower("Productname")) == 0) {
                                                
                                            } else {
                                                $error = true;
                                                break;
                                            }
                                        } else {
                                            $rsk = str_replace(" ", "", trim($Row[0]));
                                            $store_id = $storeInfo->id;
                                            $trackId = "";
                                            $currentDate = date("Y-m-d H:i:s");
                                            if ($importType == 1) {
                                                $price = trim($Row[1]);
                                                $insertSql = "INSERT INTO estore_products (id, track_id, store_id, rsk_no, price,created_at,updated_at) VALUES (NULL, '$trackId', '$store_id', '$rsk', '$price','$currentDate','$currentDate') ON DUPLICATE KEY UPDATE price = '$price',updated_at='$currentDate'";
                                            } elseif ($importType == 2) {
                                                $discount_price = trim($Row[1]);
                                                $insertSql = "INSERT INTO estore_products (id, track_id, store_id, rsk_no, discountprice,created_at,updated_at) VALUES (NULL, '$trackId', '$store_id', '$rsk', '$discount_price','$currentDate','$currentDate') ON DUPLICATE KEY UPDATE discountprice = '$discount_price',updated_at='$currentDate'";
                                            } elseif ($importType == 3) {
                                                $product_name = trim($Row[1]);
                                                $insertSql = "INSERT INTO estore_products (id, track_id, store_id, rsk_no,product_name,created_at,updated_at) VALUES (NULL, '$trackId', '$store_id', '$rsk','$product_name','$currentDate','$currentDate') ON DUPLICATE KEY UPDATE product_name='$product_name',updated_at='$currentDate'";
                                            }
                                            $this->db->query($insertSql);
                                        }
                                        if ($error == true) {
                                            break;
                                        }
                                    }
                                }
                            } else {
//                                $fileNamePath = $fileName;
//                                $currentDate = date("Y-m-d H:i:s");
//                                $proQuery = "INSERT IGNORE INTO estore_products_temp (id, store_id, file_name, status,created_at,updated_at) VALUES (NULL, '$storeId', '$fileNamePath', '0','$currentDate','$currentDate')";
//                                $this->db->query($proQuery);
//                                $uploadFile = true;
                                foreach ($Spreadsheet as $Key => $Row) {
                                    if ($Key > 0) {
                                        if (trim($Row[0]) != "") {
                                            $rsk = str_replace(" ", "", trim($Row[0]));
                                            $store_id = $storeInfo->id;
                                            $trackId = '';
                                            $price = isset($Row[1]) ? trim($Row[1]) : "0.00";
                                            $rsk_no = $rsk;
                                            $discount_price = isset($Row[2]) ? trim($Row[2]) : "0.00";
                                            $discount_group = isset($Row[3]) ? addslashes(trim($Row[3])) : "";
                                            $unit = isset($Row[4]) ? addslashes(trim($Row[4])) : "";
                                            $in_stock = isset($Row[5]) ? addslashes(trim($Row[5])) : "";
                                            $currentDate = date("Y-m-d H:i:s");
                                            $product_name = isset($Row[6]) ? addslashes(trim($Row[6])) : "";
                                            $productArray[] = "(NULL, '$trackId', '$store_id', '$rsk_no', '$price', '$discount_price','$discount_group','$unit','$in_stock','$product_name','$currentDate','$currentDate')";
                                            if (count($productArray) == 500) {
                                                $count1 = $count1 + 500;
                                                $proQuery = 'INSERT IGNORE INTO estore_products (id, track_id, store_id, rsk_no, price,discountprice,discount_group, unit,in_stock,product_name,created_at,updated_at) VALUES ';
                                                $proQuery .= implode(',', $productArray);
                                                $this->db->query($proQuery);
                                                $productArray = [];
                                            }
                                        }
                                    }
                                }
                                if ($error == false && count($productArray) > 0) {
                                    $count1 += count($productArray);
                                    $proQuery = 'INSERT IGNORE INTO estore_products (id, track_id, store_id, rsk_no, price,discountprice,discount_group, unit,in_stock,product_name,created_at,updated_at) VALUES ';
                                    $proQuery .= implode(',', $productArray);
                                    $this->db->query($proQuery);
                                    $productArray = [];
                                }
                                unlink($uploadPath . $fileName);
                                $session_message['type'] = 1;
                                $session_message['title'] = 'Success!';
                                $session_message['content'] = "Your $count1 Store Products have been uploaded successfully.";
                                $this->session->set_flashdata('message', $session_message);
                                redirect(site_url("admin/estore/estore_data/" . $storeInfo->id . "/" . $storeInfo->name), 'refresh');
                            }
                            if ($error == true) {
                                $session_message['type'] = 2;
                                $session_message['title'] = 'Warning!';
                                $session_message['content'] = 'Excel file columns are not match.';
                                $this->session->set_flashdata('message', $session_message);
                                redirect(site_url('admin/estore/import_product/' . $storeInfo->id), 'refresh');
                            } elseif ($uploadFile == true && $error != true) {
                                $session_message['type'] = 0;
                                $session_message['title'] = 'Processing!';
                                $session_message['content'] = 'Your uploaded file is under processing... Product will updated within 30 minute.<br/><strong><a href="https://vvsoffert.se/cron/update_estore_product.php" target="_blank">Click</a> here to update your E-Store products.</strong>';
                                $this->session->set_flashdata('message', $session_message);
                                redirect(site_url("admin/estore/estore_data/" . $storeInfo->id . "/" . $storeInfo->name), 'refresh');
                            } else {
                                $session_message['type'] = 1;
                                $session_message['title'] = 'Success!';
                                $session_message['content'] = "Your Store Products have been uploaded successfully.";
                                $this->session->set_flashdata('message', $session_message);
                                redirect(site_url("admin/estore/estore_data/" . $storeInfo->id . "/" . $storeInfo->name), 'refresh');
                            }
                        } catch (Exception $E) {
                            echo "<pre>";
                            print_r($E);
                            echo "</pre>";
                            exit;
                            $session_message['type'] = 2;
                            $session_message['title'] = 'Success!';
                            $session_message['content'] = 'Error: ' . $E->getMessage();
                            $this->session->set_flashdata('message', $session_message);
                            redirect(site_url('admin/estore/import_product/' . $storeInfo->id), 'refresh');
//                            echo $E->getMessage();
                        }
                    } else {
                        $session_message['type'] = 2;
                        $session_message['title'] = 'Warning!';
                        $session_message['content'] = "Only files with the following extensions are accepted: xls, xlsx";
                        $this->session->set_flashdata('message', $session_message);
                        redirect(site_url('admin/estore/import_product/' . $storeId), 'refresh');
                    }
                } else {
                    $session_message['type'] = 2;
                    $session_message['title'] = 'Warning!';
                    $session_message['content'] = "Uploaded File Error. Please try again.";
                    $this->session->set_flashdata('message', $session_message);
                    redirect(site_url('admin/estore/import_product/' . $storeId), 'refresh');
                }
            } else {
                $session_message['type'] = 2;
                $session_message['title'] = 'Warning!';
                $session_message['content'] = "Sorry! Your request can't proced";
                $this->session->set_flashdata('message', $session_message);
                redirect(site_url('admin/estore/index'), 'refresh');
            }
        }
    }

}
