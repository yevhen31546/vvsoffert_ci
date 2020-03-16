<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('site_helper');

        $this->load->library('session');

        $this->load->model('User_model');
        $this->load->model('Category_model');
        $this->load->model('Groups_model');
        $this->load->model('Products_model');


        allow_if_logged_in();

        $this->data['pageDesc'] = '';
    }

//    public function index() {
//        set_page_title('Categories');
//
//        $pid = $this->input->get('pid');
//        $pid = intval($pid);
//        $this->data['pid'] = $pid;
//
//        $pid2 = $this->input->get('pid2');
//        $pid2 = intval($pid2);
//        $this->data['pid2'] = $pid2;
//
//        // Total Categories
//        $total_rows = $this->Category_model->get_main_category_nor();
//        $this->data['total_rows'] = $total_rows->totalRows;
//
//        // Main Categories
//        if ($pid == 0 and $pid2 == 0) {
//            $main_categories = $this->Products_model->category1();
//            $this->data['main_categories'] = $main_categories;
//
//            $subcategories_count = $this->Category_model->get_sub_category1_nor();
//            foreach ($subcategories_count as $scount) {
//                $subcategory[$scount->pid] = $scount->subcategory;
//            }
//            $this->data['subcategory'] = $subcategory;
//        } else if ($pid > 0 and $pid2 == 0) {
//            $parent_category = $this->Category_model->get($pid);
//            if (empty($parent_category))
//                redirect('admin/categories');
//            $this->data['parent_category'] = $parent_category;
//            set_page_title('Categories : ' . $parent_category->name);
//
//            $main_categories = $this->Products_model->category2($pid);
//            $this->data['main_categories'] = $main_categories;
//
//            $subcategories_count = $this->Category_model->get_sub_category2_nor($pid);
//            foreach ($subcategories_count as $scount) {
//                $subcategory[$scount->pid2] = $scount->subcategory;
//            }
//            $this->data['subcategory'] = $subcategory;
//        } else if ($pid2 > 0) {
//            $parent_category = $this->Category_model->get($pid);
//            if (empty($parent_category))
//                redirect('admin/categories');
//            $this->data['parent_category'] = $parent_category;
//
//            $sub_category = $this->Category_model->get($pid2);
//            if (empty($sub_category))
//                redirect('admin/categories');
//            $this->data['sub_category'] = $sub_category;
//
//            set_page_title('Categories : ' . anchor('admin/categories?pid=' . $pid, $parent_category->name) . " : " . $sub_category->name);
//
//            $main_categories = $this->Products_model->category3($pid, $pid2);
//            $this->data['main_categories'] = $main_categories;
//        }
//
//
//        $data['content'] = $this->load->view('admin/categories', $this->data, TRUE);
//        $this->load->view('layouts/admin', $data);
//    }

    public function index() {
        set_page_title('Categories');

        $pid = $this->input->get('pid');
        $pid = intval($pid);
        $resp['pid'] = $pid;

        $pid2 = $this->input->get('pid2');
        $pid2 = intval($pid2);
        $resp['pid2'] = $pid2;

        $_s_key = "";
        $_s_sort_by = "t.name";
        $_s_order_by = "ASC";

        $resp['crntPage'] = $_page_no = 1;

        $resp['limit'] = $limit = self::LIMIT_PER_PAGE;

        if ($pid == 0 && $pid2 == 0) {
            $resp["totalCategory"] = $totalCategory = $this->Category_model->count_main_category($_s_key);
            $resp["allCategory"] = $allCategory = $this->Category_model->search_main_category($_s_key, $_s_sort_by, $_s_order_by, $limit, $_page_no);
        } elseif ($pid > 0 && $pid2 == 0) {
            $resp["totalCategory"] = $totalCategory = $this->Category_model->count_sub_main_category($_s_key, $pid);
            $resp["allCategory"] = $allCategory = $this->Category_model->search_sub_main_category($_s_key, $pid, $_s_sort_by, $_s_order_by, $limit, $_page_no);

            $resp["parent_category"] = $parent_category = $this->Category_model->get($pid);
        } elseif ($pid > 0 && $pid2 > 0) {
            $resp["totalCategory"] = $totalCategory = $this->Category_model->count_sub_category($_s_key, $pid, $pid2);
            $resp["allCategory"] = $allCategory = $this->Category_model->search_sub_category($_s_key, $pid, $pid2, $_s_sort_by, $_s_order_by, $limit, $_page_no);

            $resp["parent_category"] = $parent_category = $this->Category_model->get($pid);
            $resp["sub_category"] = $sub_category = $this->Category_model->get($pid2);
        }

        $totalPages = 0;
        if (($totalCategory % $limit) == 0) {
            $totalPages = $totalCategory / $limit;
        } else {
            $totalPages = floor($totalCategory / $limit) + 1;
        }
        $resp['totalPages'] = $totalPages;
        $resp['offset'] = 0;
//
        $data['content'] = $this->load->view('admin/categories/categories', $resp, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    public function ajax_search_field_autocomplete() {
        if ($this->input->is_ajax_request()) {
            $_s_key = $_POST['_s_key'];
            $_pid = (isset($_POST['_pid']) && $_POST['_pid'] != "" && $_POST['_pid'] != NULL) ? $_POST['_pid'] : NULL;
            $_pid2 = (isset($_POST['_pid2']) && $_POST['_pid2'] != "" && $_POST['_pid2'] != NULL) ? $_POST['_pid2'] : NULL;

            $search_category = $this->Category_model->ajax_search_field_autocomplete($_s_key, $_pid, $_pid2);
            $autocompletteArr = array();
            if (count($search_category) > 0) {
                foreach ($search_category as $v) {
                    array_push($autocompletteArr, $v->name);
                }
            } else {
                array_push($autocompletteArr, ucwords("no result found"));
            }
            echo json_encode($autocompletteArr);
            exit;
        }
    }

    public function ajax_search_category() {
        if ($this->input->is_ajax_request()) {

            $resp['pid'] = $pid = intval((isset($_POST['_pid']) && $_POST['_pid'] > 0 && $_POST['_pid'] != "" && $_POST['_pid'] != NULL) ? $_POST["_pid"] : 0);
            $resp['pid2'] = $pid2 = intval((isset($_POST['_pid2']) && $_POST['_pid2'] > 0 && $_POST['_pid2'] != "" && $_POST['_pid2'] != NULL) ? $_POST["_pid2"] : 0);

            $_s_key = isset($_POST['s_key']) ? trim($_POST['s_key']) : "";
            $_s_sort_by = isset($_POST['s_sort_by']) ? trim($_POST['s_sort_by']) : "t.name";
            $_s_order_by = isset($_POST['s_order_by']) ? trim($_POST['s_order_by']) : "ASC";

            $resp['crntPage'] = $_page_no = isset($_POST['_page_no']) ? trim($_POST['_page_no']) : 1;

            $resp['limit'] = $limit = self::LIMIT_PER_PAGE;

            if ($pid == 0 && $pid2 == 0) {
                $resp["totalCategory"] = $totalCategory = $this->Category_model->count_main_category($_s_key);
                $resp["allCategory"] = $allCategory = $this->Category_model->search_main_category($_s_key, $_s_sort_by, $_s_order_by, $limit, $_page_no);
            } elseif ($pid > 0 && $pid2 == 0) {
                $resp["totalCategory"] = $totalCategory = $this->Category_model->count_sub_main_category($_s_key, $pid);
                $resp["allCategory"] = $allCategory = $this->Category_model->search_sub_main_category($_s_key, $pid, $_s_sort_by, $_s_order_by, $limit, $_page_no);
            } elseif ($pid > 0 && $pid2 > 0) {
                $resp["totalCategory"] = $totalCategory = $this->Category_model->count_sub_category($_s_key, $pid, $pid2);
                $resp["allCategory"] = $allCategory = $this->Category_model->search_sub_category($_s_key, $pid, $pid2, $_s_sort_by, $_s_order_by, $limit, $_page_no);
            }

            $totalPages = 0;
            if (($totalCategory % $limit) == 0) {
                $totalPages = $totalCategory / $limit;
            } else {
                $totalPages = floor($totalCategory / $limit) + 1;
            }
            $resp['totalPages'] = $totalPages;
            $resp['offset'] = ($_page_no - 1) * $limit;
//
            $data['respHtml'] = $this->load->view('admin/_partial/_category_search_result', $resp, TRUE);
            echo json_encode($data);
            exit;
        }
    }

    public function getCategory2() {
        $category1 = $this->input->post('category1');
        $category1 = intval($category1);
        if ($category1 > 0) {
            $categories2 = $this->Category_model->get_sub_category1($category1);
            if (!empty($categories2)) {
                foreach ($categories2 as $category) {
                    $subCategory[$category->id] = $category->name;
                }
                $output['result'] = true;
                $output['categories'] = $subCategory;
            }
        } else {
            $output['result'] = false;
        }

        echo json_encode($output);
    }

    public function getCategory3() {
        $category2 = $this->input->post('category2');
        $category2 = intval($category2);
        if ($category2 > 0) {
            $categories3 = $this->Category_model->get_sub_category2($category2);
            if (!empty($categories3)) {
                foreach ($categories3 as $category) {
                    $subCategory[$category->id] = $category->name;
                }
                $output['result'] = true;
                $output['categories'] = $subCategory;
            }
        } else {
            $output['result'] = false;
        }

        echo json_encode($output);
    }

    // Edit Manufacturer
    public function edit($slug = 0) {
        if (empty($slug)) {
            redirect('admin/categories');
        }

        $search['id'] = $slug;
        $CategoryInfo = $this->Category_model->search($search);
        if (empty($CategoryInfo))
            redirect('admin/categories');

        $this->data['CategoryInfo'] = $CategoryInfo;

        set_page_title('Categories');

        $this->load->library('form_validation');
        $submit = set_value('submit');
        if ($submit == "save") {
            $this->form_validation->set_rules('name', 'Category name', 'trim|required|max_length[250]');

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
                    'table' => 'categories',
                    'id' => 'id',
                );
                $this->load->library('Slug', $config);
                $slug = $this->slug->create_uri($update['name'], $CategoryInfo->id);
                $update['slug'] = $slug;

                $this->Category_model->update($update, $CategoryInfo->id);
                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = 'Categories has been successfully saved.';
                $this->session->set_flashdata('message', $session_message);

                redirect(current_url());
            }
        }

        $data['content'] = $this->load->view('admin/categories/category-edit', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    public function import_category() {
        set_page_title(ucwords("Import Categories"));
        if ($this->input->method(TRUE) == "POST") {

            if (isset($_FILES['import_categories_file'])) {
                if ($_FILES['import_categories_file']['error'] == 0) {
                    $imgExt = array("xls", 'xlsx', 'csv');

                    $imgArr = explode('.', $_FILES['import_categories_file']['name']);
                    $uploadedFileExt = end($imgArr);

                    if (in_array(strtolower($uploadedFileExt), $imgExt)) {

                        $filePathArr = explode("controllers", __FILE__);
                        require_once($filePathArr[0] . '/libraries/excel-reader/php-excel-reader/excel_reader2.php');
                        require_once($filePathArr[0] . '/libraries/excel-reader/SpreadsheetReader.php');
                        $fileName = time() . "_" . $_FILES['import_categories_file']['name'];
                        $uploadPath = FCPATH . '/uploads/import_file/';

                        if (move_uploaded_file($_FILES['import_categories_file']['tmp_name'], $uploadPath . $fileName)) {

                            try {
                                $error = false;
                                $Spreadsheet = new SpreadsheetReader($uploadPath . $fileName);

                                $Sheets = $Spreadsheet->Sheets();

                                $Spreadsheet->ChangeSheet($Sheets[0]);

                                foreach ($Spreadsheet as $Key => $Row) {
                                    if (trim($Row[0]) != "") {
                                        if ($Key == 0) {
                                            if (strcasecmp(strtolower(str_replace(" ", "", trim($Row[0]))), strtolower("CategoryName")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[1]))), strtolower("SubMainCategory")) == 0 && strcasecmp(strtolower(str_replace(" ", "", trim($Row[2]))), strtolower("SubCategory")) == 0) {
                                                
                                            } else {
                                                $error = true;
                                                break;
                                            }
                                        } else {
                                            $mainCategoryId = $mainSubCategoryId = $subCategoryId = 0;
                                            $mainCategory = $this->Category_model->main_category(trim($Row[0]));
                                            if (count($mainCategory) <= 0) {
                                                $insertcategory = array();
                                                $insertcategory["name"] = trim($Row[0]);
                                                $insertcategory["slug"] = $this->geturlencodetext(trim($Row[0]));
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

                                            if (trim($Row[1]) != "" && $mainCategoryId > 0) {
                                                $mainSubCategory = $this->Category_model->sub_main_category(trim($Row[1]), $mainCategoryId);
                                                if (count($mainSubCategory) <= 0) {
                                                    $insertcategory = array();
                                                    $insertcategory["name"] = trim($Row[1]);
                                                    $insertcategory["slug"] = $this->geturlencodetext(trim($Row[1]));
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

                                            if (trim($Row[2]) != "" && $mainCategoryId > 0 && $mainSubCategoryId > 0) {
                                                $subCategory = $this->Category_model->sub_category(trim($Row[2]), $mainCategoryId, $mainSubCategoryId);
                                                if (count($subCategory) <= 0) {
                                                    $insertcategory = array();
                                                    $insertcategory["name"] = trim($Row[2]);
                                                    $insertcategory["slug"] = $this->geturlencodetext(trim($Row[2]));
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
                                        }
                                        if ($error == true) {
                                            break;
                                        }
                                    }
                                }
                                if ($error == true) {
                                    $session_message['type'] = 2;
                                    $session_message['title'] = 'Warning!';
                                    $session_message['content'] = 'Excel/CSV file columns are not match.';
                                    $this->session->set_flashdata('message', $session_message);
                                    unlink($uploadPath . $fileName);
                                    redirect('admin/categories/import_category');
                                } else {
                                    $session_message['type'] = 1;
                                    $session_message['title'] = 'Success!';
                                    $session_message['content'] = 'Your categories have been uploaded successfully.';
                                    $this->session->set_flashdata('message', $session_message);
                                    unlink($uploadPath . $fileName);
                                    redirect("admin/categories/index");
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
                        redirect('admin/categories/import_category');
                    }
                } else {
                    $session_message['type'] = 2;
                    $session_message['title'] = 'Warning!';
                    $session_message['content'] = "Uploaded File Error. Please try again.";
                    $this->session->set_flashdata('message', $session_message);
                    redirect('admin/categories/import_category');
                }
            } else {
                $session_message['type'] = 2;
                $session_message['title'] = 'Warning!';
                $session_message['content'] = "Sorry! Your request can't proced";
                $this->session->set_flashdata('message', $session_message);
                redirect('admin/categories/import_category');
            }
        }
        $data['content'] = $this->load->view('admin/categories/import-categories', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
    }

    public function checktotalproduct() {
        if ($this->input->is_ajax_request()) {
            $resp['flag'] = false;
            $targetId = $this->input->post("targetId");

            $totalPro = $this->Category_model->get_cat_total_product($targetId);
            
            if ($totalPro == 0) {
                $resp['flag'] = true;
            }
            echo json_encode($resp);
            exit;
        }
    }
    
    public function delete_category() {
        if ($this->input->is_ajax_request()) {
            $resp['flag'] = false;
            $targetId = $this->input->post("targetId");

            $result = $this->Category_model->delete_categories($targetId);
            if ($result == 1) {
                $resp['flag'] = true;
            }
            echo json_encode($resp);
            exit;
        }
    }

}
