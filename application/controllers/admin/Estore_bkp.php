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
        $error = false;
        if (isset($_FILES['product_file']) && isset($_POST['store_id'])) {
            $storeId = $_POST['store_id'];
            $storeInfo = $this->Estore_model->find($storeId);
            if ($_FILES['product_file']['error'] == 0) {
                $imgExt = array("xls", 'xlsx', 'csv');

                $imgArr = explode('.', $_FILES['product_file']['name']);
                $uploadedFileExt = end($imgArr);

                if (in_array(strtolower($uploadedFileExt), $imgExt)) {

                    $filePathArr = explode("controllers", __FILE__);
                    require_once($filePathArr[0] . '/libraries/excel-reader/php-excel-reader/excel_reader2.php');
                    require_once($filePathArr[0] . '/libraries/excel-reader/SpreadsheetReader.php');
                    $fileName = time() . "_" . $_FILES['product_file']['name'];
                    $uploadPath = FCPATH . '/uploads/import_file/';

                    if (move_uploaded_file($_FILES['product_file']['tmp_name'], $uploadPath . $fileName)) {

                        try {
                            $Spreadsheet = new SpreadsheetReader($uploadPath . $fileName);

                            $Sheets = $Spreadsheet->Sheets();

                            $Spreadsheet->ChangeSheet($Sheets[0]);

                            foreach ($Spreadsheet as $Key => $Row) {
                                if (trim($Row[0]) != "" && trim($Row[1]) != "" && trim($Row[3]) != "" && trim($Row[4]) != "" && trim($Row[5]) != "" && trim($Row[5]) != "") {
                                    if ($Key == 0) {
                                        if (strcasecmp(strtolower(str_replace(" ", "", trim($Row[0]))), strtolower("RSKnumber")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[1]))), strtolower("Price")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[2]))), strtolower("DiscountPrice")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[3]))), strtolower("Discountgroup")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[4]))), strtolower("Unit")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[5]))), strtolower("INstock")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[6]))), strtolower("Productname")) == 0) {
                                            
                                        } else {
                                            $error = true;
                                            break;
                                        }
                                    } else {
                                        $rsk = str_replace(" ", "", trim($Row[0]));
                                        //$checkPro = $this->Estore_model->find_store_pro($storeInfo->id, $rsk);
                                            $store_id = $storeInfo->id;
                                            $trackId = $this->Estore_model->productTrackId();
                                            $price = trim($Row[1]);
                                            $rsk_no = $rsk;
                                            $discount_price = trim($Row[2]);
                                            $discount_group = trim($Row[3]);
                                            $unit = trim($Row[4]);
                                            $in_stock = trim($Row[5]);
                                            $currentDate = date("Y-m-d H:i:s");
                                            $product_name = trim($Row[6]);
//                                        try {
                                            $insertSql = "INSERT INTO estore_products (id, track_id, store_id, rsk_no, price,discountprice,discount_group, unit,in_stock,product_name,created_at,updated_at) VALUES (NULL, '$trackId', '$store_id', '$rsk_no', '$price', '$discount_price','$discount_group','$unit','$in_stock','$product_name','$currentDate','$currentDate') ON DUPLICATE KEY UPDATE price = '$price', discountprice = '$discount_price',discount_group = '$discount_group', unit='$unit',in_stock='$in_stock',product_name='$product_name',updated_at='$currentDate'";
                                            $this->db->query($insertSql);
//                                        } catch (Exception $e) {
//                                            $store_id = $storeInfo->id;
//                                            $price = trim($Row[1]);
//                                            $rsk_no = $rsk;
//                                            $discount_group = trim($Row[2]);
//                                            $unit = trim($Row[3]);
//                                            $in_stock = trim($Row[4]);
//                                            $currentDate = date("Y-m-d H:i:s");
//                                            $product_name = trim($Row[5]);
//                                            $updateSql = "UPDATE estore_products SET price = '$price',discount_group = '$discount_group', unit='$unit',in_stock='$in_stock',product_name='$product_name',updated_at='$currentDate' WHERE store_id = '$store_id' AND rsk_no = '$rsk_no'";
//                                            $this->db->query($updateSql);
//                                        }
//                                            $this->Estore_model->update_store_product($updateProduct, $checkPro->id);
//                                        $checkPro = $this->Estore_model->find_store_pro($storeInfo->id, $rsk);
//                                        if (count($checkPro) == 0) {
//                                            $insertProduct = array();
//                                            $insertProduct["track_id"] = $this->Estore_model->productTrackId();
//                                            $insertProduct["store_id"] = $storeInfo->id;
//                                            $insertProduct["rsk_no"] = $rsk;
//                                            $insertProduct["price"] = trim($Row[1]);
//                                            $insertProduct["discountprice"] = trim($Row[2]);
//                                            $insertProduct["discount_group"] = trim($Row[3]);
//                                            $insertProduct["unit"] = trim($Row[4]);
//                                            $insertProduct["in_stock"] = trim($Row[5]);
//                                            $insertProduct["product_name"] = trim($Row[6]);
//                                            $result = $this->Estore_model->insert_store_product($insertProduct);
//                                        } else {
//                                            $updateProduct = array();
//                                            $updateProduct["price"] = trim($Row[1]);
//                                            $updateProduct["discountprice"] = trim($Row[2]);
//                                            $updateProduct["discount_group"] = trim($Row[3]);
//
//                                            $updateProduct["unit"] = trim($Row[4]);
//                                            $updateProduct["in_stock"] = trim($Row[5]);
//                                            $updateProduct["product_name"] = trim($Row[6]);
//                                            $updateProduct["updated_at"] = date("Y-m-d H:i:s");
//                                            $result = $this->Estore_model->update_store_product($updateProduct, $checkPro->id);
//                                        }
                                    }
                                    if ($error == true) {
                                        break;
                                    }
                                }
//                                else {
//                                    $error = true;
//                                    break;
//                                }
                            }
                            if ($error == true) {
                                $session_message['type'] = 2;
                                $session_message['title'] = 'Warning!';
                                $session_message['content'] = 'Excel file columns are not match.';
                                $this->session->set_flashdata('message', $session_message);
                                unlink($uploadPath . $fileName);
                                redirect('admin/estore/import_product/' . $storeInfo->id);
                            } else {
                                $session_message['type'] = 1;
                                $session_message['title'] = 'Success!';
                                $session_message['content'] = 'Your Store Products have been uploaded successfully.';
                                $this->session->set_flashdata('message', $session_message);
                                unlink($uploadPath . $fileName);
                                redirect("admin/estore/estore_data/$storeInfo->id/$storeInfo->name");
                            }
                        } catch (Exception $E) {
                            echo $E->getMessage();
                        }
                        unlink($uploadPath . $fileName);
                    }
                } else {
                    $session_message['type'] = 2;
                    $session_message['title'] = 'Warning!';
                    $session_message['content'] = "Only files with the following extensions are accepted: xls, xlsx";
                    $this->session->set_flashdata('message', $session_message);
                    redirect('admin/estore/import_product/' . $storeId);
                }
            } else {
                $session_message['type'] = 2;
                $session_message['title'] = 'Warning!';
                $session_message['content'] = "Uploaded File Error. Please try again.";
                $this->session->set_flashdata('message', $session_message);
                redirect('admin/estore/import_product/' . $storeId);
            }
        } else {
            $session_message['type'] = 2;
            $session_message['title'] = 'Warning!';
            $session_message['content'] = "Sorry! Your request can't proced";
            $this->session->set_flashdata('message', $session_message);
            redirect('admin/estore/index');
        }
    }

}
