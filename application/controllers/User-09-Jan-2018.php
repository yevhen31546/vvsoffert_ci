<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('ListMaster_model');
        $this->load->model('Estore_model');
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
                $this->ajax_response['msg'] = 'Please login';
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

    public function list_invoice_form() {
        if (!$this->session->userdata("user_id")) {
            redirect('login');
            exit;
        }
        
        $user = $this->Login_model->get_by_id($this->session->userdata("user_id"));
        $this->data['model'] = $user;
        $this->data['content'] = $this->load->view('user/list_invoice_form', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function list_invoice() {
        if (!$this->session->userdata("user_id")) {
            redirect('login');
            exit;
        }
        $listId = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        $stores = [];
        $estoreProducts = [];
        $getAllStores = $this->Estore_model->all_store();

        $productList = $this->ListMaster_model->getListProduct($listId);

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
        $this->data['content'] = $this->load->view('user/product_listings_invoice_by_list', $this->data, true);
//        $this->load->view('layout', $this->data);
        $this->load->view('layout', $this->data);
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

    public function export_excel() {
        if (!$this->session->userdata("user_id")) {
            redirect('login');
            exit;
        }
        $listId = base64_decode($_GET['id']);
        ini_set('memory_limit', '256M');
        $stores = [];
        $estoreProducts = [];
        $getAllStores = $this->Estore_model->all_store();

        $productList = $this->ListMaster_model->getListProduct($listId);

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

        $exceldata = "";
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
                                                if (strcasecmp(strtolower(str_replace(" ", "", $Row[0])), strtolower("PRODUCTRSKNUMBER")) == 0 && strcasecmp(strtolower(str_replace(" ", "", $Row[1])), strtolower("QUANTITY")) == 0) {
                                                    
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
                                        $session_message['title'] = 'Warning!';
                                        $session_message['content'] = 'Excel / CSV-filkolumner matchar inte.';
                                        $this->session->set_flashdata('error', $session_message);
                                        unlink($uploadPath . $fileName);
                                        redirect($this->uri->uri_string());
                                    } else {
                                        $session_message['type'] = 1;
                                        $session_message['title'] = 'Success!';
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
                            $session_message['title'] = 'Warning!';
                            $session_message['content'] = "Only files with the following extensions are accepted: xls, xlsx, csv";
                            $this->session->set_flashdata('error', $session_message);
                            redirect($this->uri->uri_string());
                        }
                    } else {
                        $session_message['type'] = 2;
                        $session_message['title'] = 'Warning!';
                        $session_message['content'] = "Uppladdat filfel. Var god försök igen.";
                        $this->session->set_flashdata('error', $session_message);
                        redirect($this->uri->uri_string());
                    }
                } else {
                    $session_message['type'] = 2;
                    $session_message['title'] = 'Warning!';
                    $session_message['content'] = "Din förfrågan kan inte proceduren";
                    $this->session->set_flashdata('error', $session_message);
                    redirect($this->uri->uri_string());
                }
            } else {
                $session_message['type'] = 2;
                $session_message['title'] = 'Warning!';
                $session_message['content'] = "Du har inte valt någon lista";
                $this->session->set_flashdata('error', $session_message);
                redirect($this->uri->uri_string());
            }
        }

        $this->data['content'] = $this->load->view('user/import-product-rsk', $this->data, true);
        $this->load->view('layout_sidebar', $this->data);
    }

}
