<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('ListMaster_model');
        $this->load->model('Estore_model');
    }

    public function ajaxproductaddtolist() {
        if ($this->input->is_ajax_request()) {
            $error = [];
            $error = false;
            $list_id = $_POST['list_id'];
            $product_id = $_POST['product_id'];
            if (!$this->session->userdata("user_id")) {
                $error = true;
                $this->ajax_response['type'] = 'warning';
                $this->ajax_response['msg'] = 'Please login';
            } else {
                $checkproduct = $this->db->query("SELECT id FROM list_master_product WHERE list_id=" . $list_id . " and product_id=" . $product_id)->row();
                if ($checkproduct == '') {
                    $error = false;
                    $Array = array(
                        'list_id' => $list_id,
                        'product_id' => $product_id,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $query = savedata('list_master_product', $Array);
                    $this->ajax_response['type'] = 'success';
                    $this->ajax_response['msg'] = 'Product is successfully added to your list';
                } else {
                    $error = true;
                    $this->ajax_response['type'] = 'warning';
                    $this->ajax_response['msg'] = 'Product has already added into your list';
                }
            }
        }
        echo json_encode($this->ajax_response);
    }

    public function useraccount_details() {

        if (!$this->session->userdata("user_id")) {
            redirect('login');
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
                    $session_message['title'] = 'Success!';
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
            redirect('login');
            exit;
        }
        $data_msg = array();
        $all_list = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));
        $this->data['model'] = $all_list;

        $this->data['content'] = $this->load->view('user/list_index', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function add_list_form() {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata("user_id")) {
            redirect('login');
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
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = 'List has been successfully saved.';
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
            redirect('login');
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
                    $session_message['title'] = 'Success!';
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
            redirect('login');
            exit;
        }
        $id = base64_decode($_GET['id']);
        $data_msg = array();

        $singlelist = $this->ListMaster_model->get($id);
//        $productlist = getListdata(array("list_id"=>$id,'status'=>1),'list_master_product');
        $productlist = getjoinlist_product($id);
        $this->data['productlist'] = $productlist;
        $this->data['singlelist'] = $singlelist;

        $this->data['content'] = $this->load->view('user/product_listings_by_list', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function pdf_export() {
        if (!$this->session->userdata("user_id")) {
            redirect('login');
            exit;
        }
        $id = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        // load library
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
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

    public function change_password() {
        if (!$this->session->userdata("user_id")) {
            redirect('login');
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
                    $session_message['title'] = 'Success!';
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
        $session_message['title'] = 'Success!';
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
        $session_message['title'] = 'Success!';
        $session_message['content'] = 'Product has been successfully deleted.';
        $this->session->set_flashdata('message', $session_message);
        redirect(site_url('list-details') . '?id=' . $list_id);
    }

    public function import_product_rsk_excel() {
        if (!$this->session->userdata("user_id")) {
            redirect('login');
            exit;
        }

        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;

        $proReqData = $this->Estore_model->get_user_request_pro_list_track($this->session->userdata("user_id"));
        $this->data['proReqData'] = $proReqData;

        if ($this->input->method(TRUE) == "POST") {
            $error = false;
            $productRSK = [];
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
                                $trackId = time() . rand(100000, 99999);
                                $productRSK = [];
                                $rowNo = 0;
                                foreach ($Spreadsheet as $Key => $Row) {
                                    if (trim($Row[0]) != "") {
                                        if ($Key == 0) {
                                            if (strcasecmp(strtolower(str_replace(" ", "", $Row[0])), strtolower("PRODUCTRSKNUMBER")) == 0 && strcasecmp(strtolower(str_replace(" ", "", $Row[1])), strtolower("QUANTITY")) == 0) {
                                                
                                            } else {
                                                $error = true;
                                                break;
                                            }
                                        } else {
                                            $productRSK[$rowNo]["trackId"] = $trackId;
                                            $productRSK[$rowNo]["user_id"] = $this->session->userdata("user_id");
                                            $productRSK[$rowNo]["pro_rsk"] = trim($Row[0]);
                                            $productRSK[$rowNo]["quantity"] = number_format(trim($Row[1]), 0);
                                            $productRSK[$rowNo]["created_at"] = number_format(trim($Row[1]), 0);
                                            $rowNo ++;
//                                            $result = $this->Estore_model->user_imporet_pro_rsk_insert($productRSK);
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
                                    redirect($this->uri->uri_string());
                                } else {
                                    $stores = [];
                                    $estoreProducts = [];
                                    if (count($productRSK) > 0) {
                                        $getAllStores = $this->Estore_model->all_store();
                                        array_push($stores, "PRODUCT RSK NUMBER");
                                        array_push($stores, "PRODUCT NAME");
                                        array_push($stores, "QUANTITY");
                                        foreach ($getAllStores as $key => $estore) {
                                            array_push($stores, mb_convert_encoding($estore->name, 'UTF-16LE', 'UTF-8'));
                                        }
                                        foreach ($productRSK as $k => $v) {
                                            $vArr = (object) $v;
                                            $estorePro = $this->Estore_model->find_store_pro_by_RSK($vArr->pro_rsk);
                                            $estoreProducts[$k]["RSK_NO"] = mb_convert_encoding($vArr->pro_rsk, 'UTF-16LE', 'UTF-8');
                                            $estoreProducts[$k]["PRO_NAME"] = (isset($estorePro) && count($estorePro) > 0) ? mb_convert_encoding($estorePro->product_name, 'UTF-16LE', 'UTF-8') : "";
                                            $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
                                            foreach ($getAllStores as $key => $estore) {
                                                $amount = 0;
                                                $findStorePro = $this->Estore_model->find_store_pro_by_RSK_store($vArr->pro_rsk, $estore->id);
                                                if (isset($findStorePro) && count($findStorePro) > 0) {
                                                    $amount += $findStorePro->price * $vArr->quantity;
                                                }
                                                $newAmount = number_format($amount, 2);
                                                $estoreProducts[$k]["$estore->name-$estore->id"] = ($newAmount > 0) ? $newAmount : "";
                                            }
                                        }
                                    }
                                    $refreshUrl = base_url($this->uri->uri_string());
                                    $crntDate = date("Y-m-d H:i:s");
                                    $fileName = "Prouct  ($crntDate).csv";
                                    header('Content-Encoding: UTF-8');
                                    header("Content-type:text/csv; charset=UTF-8");
                                    header("Content-Disposition:attachment;filename=$fileName");
                                    header("refresh:5;url=$refreshUrl");
                                    header("Cach-Control: no-store, no-catch, must-revalidate");
                                    header("Cach-Control: post-check=0, pre-check=0");
                                    header("Pragma: no-cache");
                                    header("Expires: 0");
                                    $handle = fopen("php://output", "w");
                                    fputcsv($handle, $stores);

//        $this->Estore_model->remove_user_request_pro_list($this->session->userdata("user_id"), trim($token));
                                    foreach ($estoreProducts as $key => $value) {
                                        fputcsv($handle, $value);
                                    }
                                    fclose($handle);
                                    exit;
                                    unlink($uploadPath . $fileName);
                                    $session_message['type'] = 1;
                                    $session_message['title'] = 'Success!';
                                    $session_message['content'] = 'Your List of products download link has been created successfuly.';
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
                        $session_message['title'] = 'Warning!';
                        $session_message['content'] = "Only files with the following extensions are accepted: xls, xlsx, csv";
                        $this->session->set_flashdata('message', $session_message);
                        redirect($this->uri->uri_string());
                    }
                } else {
                    $session_message['type'] = 2;
                    $session_message['title'] = 'Warning!';
                    $session_message['content'] = "Uploaded File Error. Please try again.";
                    $this->session->set_flashdata('message', $session_message);
                    redirect($this->uri->uri_string());
                }
            } else {
                $session_message['type'] = 2;
                $session_message['title'] = 'Warning!';
                $session_message['content'] = "Sorry! Your request can't proced";
                $this->session->set_flashdata('message', $session_message);
                redirect($this->uri->uri_string());
            }
        }

        $this->data['content'] = $this->load->view('user/import-product-rsk', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
    }

//    public function download_product_data($token) {
//        $stores = [];
//        $estoreProducts = [];
//        $productRSK = $this->Estore_model->get_user_request_pro_list($this->session->userdata("user_id"), trim($token));
//        if (count($productRSK) > 0) {
//            $getAllStores = $this->Estore_model->all_store();
//            array_push($stores, "PRODUCT RSK NUMBER");
//            array_push($stores, "PRODUCT NAME");
//            array_push($stores, "QUANTITY");
//            foreach ($getAllStores as $key => $estore) {
//                array_push($stores, $estore->name);
//            }
//            foreach ($productRSK as $k => $v) {
//                $vArr = (object) $v;
//                $estorePro = $this->Estore_model->find_store_pro_by_RSK($vArr->pro_rsk);
//                $estoreProducts[$k]["RSK_NO"] = $vArr->pro_rsk;
//                $estoreProducts[$k]["PRO_NAME"] = (isset($estorePro) && count($estorePro) > 0) ? mb_convert_encoding($estorePro->product_name, 'UTF-16LE', 'UTF-8') : "";
//                $estoreProducts[$k]["QUANTITY"] = $vArr->quantity;
//                foreach ($getAllStores as $key => $estore) {
//                    $amount = 0;
//                    $findStorePro = $this->Estore_model->find_store_pro_by_RSK_store($vArr->pro_rsk, $estore->id);
//                    if (isset($findStorePro) && count($findStorePro) > 0) {
//                        $amount += $findStorePro->price * $vArr->quantity;
//                    }
//                    $amount = number_format($amount, 2);
//                    $estoreProducts[$k]["$estore->name-$estore->id"] = ($amount > 0) ? $amount : "";
//                }
//            }
//        }
//        $crntDate = date("Y-m-d H:i:s");
//        $fileName = "Prouct  ($crntDate).csv";
//        header('Content-Encoding: UTF-8');
//        header("Content-type:text/csv; charset=UTF-8");
//        header("Content-Disposition:attachment;filename=$fileName");
//        header("Cach-Control: no-store, no-catch, must-revalidate");
//        header("Cach-Control: post-check=0, pre-check=0");
//        header("Pragma: no-cache");
//        header("Expires: 0");
//        $handle = fopen("php://output", "w");
//        fputcsv($handle, $stores);
//
//        $this->Estore_model->remove_user_request_pro_list($this->session->userdata("user_id"), trim($token));
//        foreach ($estoreProducts as $key => $value) {
//            fputcsv($handle, $value);
//        }
//        fclose($handle);
//        exit;
//    }

}
