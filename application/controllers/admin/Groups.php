<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('site_helper');
        $this->load->library('session');
        $this->load->library('form_validation');

        $this->load->model('User_model');
        $this->load->model('Groups_model');
        $this->load->model('Products_model');


        allow_if_logged_in();

        $this->data['pageDesc'] = '';
    }

//    public function index() {
//        set_page_title('Groups');
//
//        // Total Groups
//        $total_groups = $this->Groups_model->nor();
//        $this->data['total_groups'] = $total_groups;
//
//        // Get Groups Products
//        $groups = $this->Groups_model->get_all_with_count();
//        $this->data['groupsData'] = $groups;
//
//        $data['content'] = $this->load->view('admin/groups', $this->data, TRUE);
//        $this->load->view('layouts/admin', $data);
//    }

    public function index() {
        set_page_title('Groups');

        // Total Groups
        $_s_key = "";
        $_s_sort_by = "t.name";
        $_s_order_by = "ASC";

        $resp['crntPage'] = $_page_no = 1;

        $resp['limit'] = $limit = self::LIMIT_PER_PAGE;

        $resp['total_groups'] = $total_groups = $this->Groups_model->total_group_search_res($_s_key);
        $resp['groupsData'] = $groups = $this->Groups_model->get_search_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $_page_no);

        if (($total_groups % $limit) == 0) {
            $totalPages = $total_groups / $limit;
        } else {
            $totalPages = floor($total_groups / $limit) + 1;
        }
        $resp['totalPages'] = $totalPages;

        $data['content'] = $this->load->view('admin/groups/groups', $resp, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    public function ajax_search_field_autocomplete() {
        if ($this->input->is_ajax_request()) {
            $_s_key = $_POST['_s_key'];

            $search_groups = $this->Groups_model->ajax_search_field_autocomplete($_s_key);
            $autocompletteArr = array();
            if (count($search_groups) > 0) {
                foreach ($search_groups as $v) {
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

            $resp['total_groups'] = $total_groups = $this->Groups_model->total_group_search_res($_s_key);
            $resp['groupsData'] = $groups = $this->Groups_model->get_search_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $_page_no);

            if (($total_groups % $limit) == 0) {
                $totalPages = $total_groups / $limit;
            } else {
                $totalPages = floor($total_groups / $limit) + 1;
            }
            $resp['totalPages'] = $totalPages;

            // Get Groups Products

            $resp["respHtml"] = $this->load->view('admin/_partial/_group_search_result', $resp, TRUE);
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

    public function update() {
        if ($this->input->is_ajax_request()) {
            $resp['flag'] = false;
            $resp['imageError'] = false;
            $imgExt = array("png", 'jpeg', 'jpg');
            if (isset($_FILES['group_image']['name']) && $_FILES['group_image']['name'] != "" && $_FILES['group_image']['name'] != null) {
                if ($_FILES['group_image']['error'] != 0) {
                    $resp['imageError'] = true;
                    $resp['imgErrMsg'] = "Image Error. Please try again.";
                } else {
                    $imgArr = explode('.', $_FILES['group_image']['name']);
                    if (!in_array(strtolower(end($imgArr)), $imgExt)) {
                        $resp['imageError'] = true;
                        $resp['imgErrMsg'] = "Only files with the following extensions are accepted: png, jpg, jpeg";
                    }
                }
            }
            $this->form_validation->set_rules('group_name', 'name', 'trim|required|max_length[250]');
            $this->form_validation->set_message('matches', 'The %s does not match the %s.');
            $this->form_validation->set_message('min_length', 'The %s must be at least %s characters in length..');
            $this->form_validation->set_message('max_length', 'The %s cannot exceed %s characters in length.');

            if ($resp['imageError'] == false && $this->form_validation->run() === TRUE) {
                if ($resp['imageError'] == false) {
                    $fileName = time() . '_' . $_FILES['group_image']['name'];

                    $uploadTempPath = isset($_FILES['group_image']) ? $_FILES['group_image']['tmp_name'] : "";

                    $uploadPath = FCPATH . '/uploads/group-images/';

                    if (move_uploaded_file($uploadTempPath, $uploadPath . $fileName)) {
                        $update["group_image"] = "uploads/group-images/$fileName";
                    }
                }

                $update["name"] = set_value("group_name");

                $config = array(
                    'field' => 'slug',
                    'title' => 'name',
                    'table' => 'groups',
                    'id' => 'id',
                );
                $this->load->library('Slug', $config);
                $slug = $this->slug->create_uri($update['name'], $this->input->post("group_id"));
                $update['slug'] = $slug;

                $update["updated"] = date("Y-m-d H:i:s");

                $result = $this->Groups_model->update($update, $this->input->post("group_id"));
                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = 'Group has been successfully updated.';
                $this->session->set_flashdata('message', $session_message);
                $resp['flag'] = true;
                $resp['redirectUrl'] = site_url('admin/groups/index');
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

    // Edit Groups
    public function edit($slug = 0) {
        if (empty($slug)) {
            redirect('admin/groups');
        }

        $search['slug'] = $slug;
        $groupInfo = $this->Groups_model->search($search);
        if (empty($groupInfo))
            redirect('admin/groups');

        $this->data['groupInfo'] = $groupInfo;

        set_page_title('Groups');

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
                    'table' => 'groups',
                    'id' => 'id',
                );
                $this->load->library('Slug', $config);
                $slug = $this->slug->create_uri($update['name'], $groupInfo->id);
                $update['slug'] = $slug;

                $this->Groups_model->update($update, $groupInfo->id);
                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = 'Group Name has been successfully saved.';
                $this->session->set_flashdata('message', $session_message);

                redirect('admin/groups');
            }
        }

        $data['content'] = $this->load->view('admin/groups/group-edit', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
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
