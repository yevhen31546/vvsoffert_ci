<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('site_helper');
        $this->load->library('session');
        $this->load->library('form_validation');

        $this->load->model('Login_model');


        allow_if_logged_in();

        $this->data['pageDesc'] = '';
    }

    public function index() {
        set_page_title('User Management');

        // Total Groups
        $_s_key = "";
        $_s_sort_by = "t.status, t.name";
        $_s_order_by = "ASC";

        $resp['crntPage'] = $_page_no = 1;

        $resp['limit'] = $limit = self::LIMIT_PER_PAGE;

        $resp['total_users'] = $total_user = $this->Login_model->total_user_search_res($_s_key);
        $resp['userData'] = $users = $this->Login_model->get_search_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $_page_no);

        if (($total_user % $limit) == 0) {
            $totalPages = $total_user / $limit;
        } else {
            $totalPages = floor($total_user / $limit) + 1;
        }
        $resp['totalPages'] = $totalPages;

        $data['content'] = $this->load->view('admin/user/users', $resp, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    public function ajax_search_field_autocomplete() {
        if ($this->input->is_ajax_request()) {
            $_s_key = $_POST['_s_key'];

            $search_groups = $this->Login_model->ajax_search_field_autocomplete($_s_key);
            $autocompletteArr = array();
            if (count($search_groups) > 0) {
                foreach ($search_groups as $v) {
                    array_push($autocompletteArr, $v["name"] . " " . $v["last_name"]);
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

            $resp['total_users'] = $total_users = $this->Login_model->total_user_search_res($_s_key);
            $resp['userData'] = $users = $this->Login_model->get_search_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $_page_no);

            if (($total_users % $limit) == 0) {
                $totalPages = $total_users / $limit;
            } else {
                $totalPages = floor($total_users / $limit) + 1;
            }
            $resp['totalPages'] = $totalPages;

            // Get Groups Products

            $resp["respHtml"] = $this->load->view('admin/_partial/_user_search_result', $resp, TRUE);
            echo json_encode($resp);
            exit;
        }
    }

    public function create() {
        if ($this->input->is_ajax_request()) {
            $resp['flag'] = false;

            if (empty($_FILES['group_image']['name'])) {
                $this->form_validation->set_rules('group_image', 'group_image', 'required');
            }
            $this->form_validation->set_rules('group_name', 'name', 'trim|required|max_length[250]');
//                $this->form_validation->set_message('required', 'Required.');
            $this->form_validation->set_message('matches', 'The %s does not match the %s.');
            $this->form_validation->set_message('min_length', 'The %s must be at least %s characters in length..');
            $this->form_validation->set_message('max_length', 'The %s cannot exceed %s characters in length.');

            $fileName = time() . '_' . $_FILES['group_image']['name'];

            $uploadTempPath = isset($_FILES['group_image']) ? $_FILES['group_image']['tmp_name'] : "";

            $uploadPath = FCPATH . '/uploads/group-images/';
            if ($this->form_validation->run() === TRUE) {
                if (move_uploaded_file($uploadTempPath, $uploadPath . $fileName)) {
                    $newGroup["name"] = set_value("group_name");
                    $newGroup["slug"] = $this->geturlencodetext($this->input->post('group_name'));
                    $newGroup["group_image"] = "uploads/group-images/$fileName";
                    $newGroup["status"] = true;
                    $newGroup["created"] = date("Y-m-d H:i:s");
                    $newGroup["updated"] = date("Y-m-d H:i:s");

                    $result = $this->Groups_model->insert($newGroup);
                    $session_message['type'] = 1;
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = 'Group has been successfully added.';
                    $this->session->set_flashdata('message', $session_message);
                    $resp['flag'] = true;
                    $resp['redirectUrl'] = site_url('admin/groups/index');
                } else {
                    $resp['respMessage'] = "Something Error. Please try again";
                }
            } else {
                $errors = $this->form_validation->error_array();
                $resp['errors'] = $errors;
            }
            echo json_encode($resp);
            exit;
        }
        set_page_title('Create Group');

        $this->data['content'] = $this->load->view('admin/groups/group-add', $this->data, true);
        $this->load->view('layouts/admin', $this->data);
    }

    public function ajaxupdate() {

        if ($this->input->is_ajax_request()) {
            $user_id = $this->input->post('user_id');
            $error = [];

            $checkemail = $this->db->query("SELECT email FROM user_master WHERE user_id = " . $user_id)->row()->email;

            if ($this->input->post('email') != $checkemail) {

                $is_unique = '|is_unique[user_master.email]';
            } else {
                $is_unique = '';
            }

            $this->form_validation->set_rules('email', 'Email', 'trim|required' . $is_unique);
            $this->form_validation->set_rules('name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            if (set_value('password') != '') {
                $this->form_validation->set_rules('password', 'Password', 'min_length[6]|max_length[12]');
            }
            $this->form_validation->set_rules('contact', 'Contact Number', 'required|regex_match[/^[0-9]|S$/]');
            $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('org_no', 'Organization Number', 'trim|required');
            $this->form_validation->set_message('is_unique', 'The %s is already taken');


            if ($this->form_validation->run() == TRUE) {

                $update['name'] = set_value('name');
                $update['last_name'] = set_value('last_name');
                $update['contact'] = set_value('contact');
                $update['email'] = set_value('email');
                $update['company_name'] = set_value('company_name');
                if (set_value('password') != '') {

                    $update['password'] = md5(set_value('password'));
                }
                $update['org_no'] = set_value('org_no');
                $update['status'] = set_value('status');
                
                $this->Login_model->update($user_id, $update);
                if ($update['status'] == 1) {
                    $this->load->library('email');
                    $htmlContent = $this->load->view('email/user_activated_by_admin', $update, TRUE);
                    $this->email->to($update['email']);
                    $this->email->from('info@vvsoffert.se', 'vvsoffert');
                    $this->email->subject('Du är framgångsrik registrerad');
                    $this->email->message($htmlContent);
                    try {
                        $this->email->send();
                    } catch (Exception $e) {
                        
                    }
                }
                $this->ajax_response['type'] = 'success';
                $this->ajax_response['message'] = "User has been successfully updated.";
            } else {

                $this->ajax_response['type'] = 'warning';
                foreach ($this->form_validation->error_array() as $key => $val) {
                    $error[$key] = $val;
                }

                $this->ajax_response['message'] = $error;
            }
        }
        echo json_encode($this->ajax_response);
        exit;
    }

    // Edit Groups
    public function edit($slug = 0) {
        if (empty($slug)) {
            redirect('admin/users');
        }

        $userid = $slug;
        $userInfo = $this->Login_model->get_by_id($userid);
        if (empty($userInfo))
            redirect('admin/users');

        $this->data['userInfo'] = $userInfo;

        set_page_title('User Edit');

        $data['content'] = $this->load->view('admin/user/user-edit', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    public function ajaxuserdelete() {

        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('id');
            $sql_del = $this->Login_model->delete($id);
            if ($sql_del) {
                $this->ajax_response['type'] = 'success';
                $this->ajax_response['message'] = "User has been deleted Successfully!!";
            } else {
                $this->ajax_response['type'] = 'warning';
                $this->ajax_response['message'] = "User not deleted!!";
            }
        }
        echo json_encode($this->ajax_response);
    }

    // Delete Groups
    public function delete($slug = 0) {
        if (empty($slug)) {
            redirect('admin/groups');
        }

        $search['slug'] = $slug;

        $groupInfo = $this->Groups_model->search($search);
        if (empty($groupInfo)) {
            redirect('admin/groups');
        } else {
            $checkProduct = $this->Groups_model->check_group_product($groupInfo->id);
            if ($checkProduct > 0) {
                $session_message['type'] = 2;
                $session_message['title'] = 'Warning!';
                $session_message['content'] = 'Some produnct are added in this group. So you are unable to delete this group.';
                $this->session->set_flashdata('message', $session_message);
            } else {
                $groupInfo = $this->Groups_model->delete_group($groupInfo->id);
                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = 'Group has been deleted.';
                $this->session->set_flashdata('message', $session_message);
            }
            redirect('admin/groups');
        }
    }

    public function import_groups() {
        set_page_title(ucwords("Import Groups"));
        if ($this->input->method(TRUE) == "POST") {
            $error = false;

            if (isset($_FILES['import_group_file'])) {
                if ($_FILES['import_group_file']['error'] == 0) {
                    $imgExt = array("xls", 'xlsx', 'csv');

                    $imgArr = explode('.', $_FILES['import_group_file']['name']);
                    $uploadedFileExt = end($imgArr);

                    if (in_array(strtolower($uploadedFileExt), $imgExt)) {

                        $filePathArr = explode("controllers", __FILE__);
                        require_once($filePathArr[0] . '/libraries/excel-reader/php-excel-reader/excel_reader2.php');
                        require_once($filePathArr[0] . '/libraries/excel-reader/SpreadsheetReader.php');
                        $fileName = time() . "_" . $_FILES['import_group_file']['name'];
                        $uploadPath = FCPATH . '/uploads/import_file/';

                        if (move_uploaded_file($_FILES['import_group_file']['tmp_name'], $uploadPath . $fileName)) {

                            try {
                                $Spreadsheet = new SpreadsheetReader($uploadPath . $fileName);

                                $Sheets = $Spreadsheet->Sheets();

                                $Spreadsheet->ChangeSheet($Sheets[0]);

                                foreach ($Spreadsheet as $Key => $Row) {
                                    if (trim($Row[0]) != "") {
                                        if ($Key == 0) {
                                            if (strcasecmp(strtolower(str_replace(" ", "", trim($Row[0]))), strtolower("GROUPNAME")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[1]))), strtolower("GROUPIMAGELINK")) == 0) {
                                                
                                            } else {
                                                $error = true;
                                                break;
                                            }
                                        } else {
                                            $imgPath = "";
                                            if (trim($Row[1]) != "") {
                                                $imgurl = trim($Row[1]);
                                                if ($this->check_image_url($imgurl)) {
                                                    $imagename = time() . "_" . basename($imgurl);

                                                    $imgUploadPath = FCPATH . "/uploads/group-images/$imagename";
                                                    $imgPath = "/uploads/group-images/$imagename";
                                                    $image = $this->getimg($imgurl);
                                                    file_put_contents($imgUploadPath, $image);
                                                }
                                            }
                                            $checkGroup = $this->Groups_model->find_group(trim($Row[0]));
                                            if (count($checkGroup) == 0) {
                                                $insertGroup = array();
                                                $insertGroup["name"] = trim($Row[0]);
                                                $insertGroup["slug"] = $this->geturlencodetext(trim($Row[0]));
                                                $insertGroup["group_image"] = $imgPath;
                                                $insertGroup["created"] = date("Y-m-d H:i:s");
                                                $insertGroup["updated"] = date("Y-m-d H:i:s");

                                                $result = $this->Groups_model->insert($insertGroup);
                                            } else {
                                                $updateGroup = array();
                                                $updateGroup["name"] = trim($Row[0]);

                                                $updateGroup["group_image"] = $imgPath;
                                                $updateGroup["updated"] = date("Y-m-d H:i:s");
                                                $result = $this->Groups_model->update($updateGroup, $checkGroup->id);
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
                                    redirect('admin/groups/import_groups');
                                } else {
                                    $session_message['type'] = 1;
                                    $session_message['title'] = 'Success!';
                                    $session_message['content'] = 'Your Groups have been uploaded successfully.';
                                    $this->session->set_flashdata('message', $session_message);
                                    unlink($uploadPath . $fileName);
                                    redirect("admin/groups/index");
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
                        redirect('admin/groups/import_groups');
                    }
                } else {
                    $session_message['type'] = 2;
                    $session_message['title'] = 'Warning!';
                    $session_message['content'] = "Uploaded File Error. Please try again.";
                    $this->session->set_flashdata('message', $session_message);
                    redirect('admin/groups/import_groups');
                }
            } else {
                $session_message['type'] = 2;
                $session_message['title'] = 'Warning!';
                $session_message['content'] = "Sorry! Your request can't proced";
                $this->session->set_flashdata('message', $session_message);
                redirect('admin/groups/import_groups');
            }
        }
        $data['content'] = $this->load->view('admin/groups/import-groups', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
    }

}
