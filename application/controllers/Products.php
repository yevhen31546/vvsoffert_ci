<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('ListMaster_model');
        $this->load->model('Estore_model');
        $this->load->helper('custom_functions_helper');
        $this->load->model('FrontendUser_model');
        $this->load->model('Groups_model');
        $this->load->model('Category_model');
        $this->load->model('Products_model');
        $this->load->model('Invoice_histories_model');
    }

    public function index() {

        $this->load->model('Groups_model');
        $this->load->model('Category_model');
        $this->load->model('Products_model');
        $this->load->model('Manufacturer_model');
        $this->load->model('ListMaster_model');

        $this->load->helper('form');

        $this->data['currentCategory'] = 0;
        $this->data['currentManu'] = 0;
        $this->data['currentSub2'] = 0;
        $manu[''] = 'Select';

        $per_page = 100;
        $start = 0;
        $pageno = '';
        $cid = $this->input->get('cno');

        //var_dump($cid);die();
        //$pageno = $this->input->get('page');
        $subcat1 = $this->input->get('c2no');
        $subcat2 = $this->input->get('c3no');
    
     $string=$this->input->get('search-key');
        if (!empty($string)) {
            $search['text'] = urldecode($string);
            $this->data['text'] = $string;
        }
        $manuId = $this->input->get('tillverkare');

        //var_dump($manuId); die();
        if (!empty($manuId)) {
            $search['Manufacturer'] = urldecode($manuId);
            $this->data['currentManu'] = urldecode($manuId);
        }

        if (!empty($cid)) {

            $cat = $this->Category_model->get($cid);
            redirect($cat->slug);

            $this->data['currentCategory'] = $cid;
            $search['category1'] = $cid;

            if (!empty($subcat1))
                $search['category2'] = $subcat1;

            $total_rows = $this->Products_model->get_total($search);

            if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
                $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
                
                $products = $this->Products_model->get_products($search, $start);
                $this->data['productsList'] = $products;
            } else {
                $products = $this->Products_model->get_products($search);
                $this->data['productsList'] = $products;
            }
        } else if (!empty($subcat1)) {
        

            $cat = $this->Category_model->get($subcat1);
            redirect($cat->slug);

            $this->data['currentCategory2'] = $subcat1;
            $search['category2'] = $subcat1;
            $total_rows = $this->Products_model->get_total($search);

            if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
                $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
                $products = $this->Products_model->get_products($search, $start);
                $this->data['productsList'] = $products;
            } else {
                $products = $this->Products_model->get_products($search);
                $this->data['productsList'] = $products;
            }
        } else if (!empty($subcat2)) {

            $cat = $this->Category_model->get($subcat2);
            redirect($cat->slug);

            //$this->data['currentCategory3'] = $subcat2;
            $search['category3'] = $subcat2;
            $total_rows = $this->Products_model->get_total($search);

            if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
                $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
                $products = $this->Products_model->get_products($search, $start);
                $this->data['productsList'] = $products;
            } else {
                $products = $this->Products_model->get_products($search);
                $this->data['productsList'] = $products;
            }
        } else if (!empty($string)) {
            $total_rows = $this->Products_model->get_total($search);

            if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
                $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
                $products = $this->Products_model->get_products($search, $start);
                $this->data['productsList'] = $products;
            } else {
                $products = $this->Products_model->get_products($search);
                $this->data['productsList'] = $products;
            }
        } else if (!empty($manuId)) {
            $total_rows = $this->Products_model->get_total($search);

            if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
                $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
                $products = $this->Products_model->get_products($search, $start);
                $this->data['productsList'] = $products;
            } else {
                $products = $this->Products_model->get_products($search);
                $this->data['productsList'] = $products;
            }
        } else {
            $total_rows = $this->Products_model->get_total();

            if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
                $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
                $products = $this->Products_model->get_products('', $start);
                $this->data['productsList'] = $products;
            } else {
                $products = $this->Products_model->get_products();
                $this->data['productsList'] = $products;
            }
        }

        // Get All Manufacturers
        if (!isset($search) || empty($search)) {
            $manufacturers = $this->Manufacturer_model->get_all();
            $manu['']='Välj';
            foreach ($manufacturers as $manufacturer) {
                $manu[$manufacturer->id] = $manufacturer->name;
            }
            $this->data['manufacturerList'] = $manu;
        } else {
            //$manufacturers = $this->Products_model->get_manu($search);

            //var_dump($manufacturers); var_dump($search); die();

            /*if (!empty($manufacturers)) {
                $manu['']='Välj';
                foreach ($manufacturers as $manufacturer) {
                    $manu[$manufacturer->MID] = $manufacturer->Mname;
                }
                $this->data['manufacturerList'] = $manu;*/

            //var_dump($this->data['manufacturerList']);die();

                $manufacturers = $this->Products_model->get_manu($search);

                $manu['']='Välj';

                if (!empty($manufacturers)) {

                    foreach ($manufacturers as $manufacturer) {
                        $manu[$manufacturer->MID] = $manufacturer->Mname;
                    }

                    
                }

                $this->data['manufacturerList'] = $manu;
        }

        // Pagination
        $this->load->library('pagination');

        $get = $_GET;
        unset($get['per_page']);
        $actionParam = http_build_query($get);
        $this->data['end'] = $start + count($products);
        if(count($products) == 0)
        {
            $start = 0;
            
        }else{
            
            $start = ($start == 0)? $start + 1 : $start ;
        }
        $this->data['start'] = $start;
        
        $this->data['actionParam'] = $actionParam;

        $config['base_url'] = site_url('Products');
        $config['base_url'] = $config['base_url'] . '?' . http_build_query($get);
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = 3;
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['attributes'] = array('class' => 'page-link');

        $config['full_tag_open'] = '<ul class="pagination pull-right">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Sista';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'nästa';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a href="" class="page-link">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $this->data['user_id'] = $user_id = ($this->session->userdata('user_id') != '') ? $this->session->userdata('user_id') : 0;
        $this->data['all_list'] = $all_list = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));
        $this->data['total_rows'] = $total_rows;
        $this->data['content'] = $this->load->view('pages/products', $this->data, true);

        $this->load->view('layout', $this->data);
    }

    //======================================================================
    // Products Compare
    //======================================================================

    public function compare() {
        $p1 = $this->input->get('p1');
        $p2 = $this->input->get('p2');
        $p3 = $this->input->get('p3');

        if (empty($p1) or empty($p2))
            redirect('Products');

        $this->load->model('Products_model');

        if (!empty($p1)) {
            $product1 = $this->Products_model->get($p1);
            $this->data['productData1'] = $product1;
        }

        if (!empty($p2)) {
            $product2 = $this->Products_model->get($p2);
            $this->data['productData2'] = $product2;
        }

        if (!empty($p3)) {
            $product3 = $this->Products_model->get($p3);
            $this->data['productData3'] = $product3;
        }

        $this->data['content'] = $this->load->view('pages/products-compare', $this->data, true);

        $this->load->view('layout', $this->data);
    }
    
     public function catpro_new() {
         
         $string=$this->input->get('search');
            
            // if (!empty($string)) {
            //     $fullSearch['text'] = urldecode($string);
            //     $search['text'] = urldecode($string);
            //     $this->data['text'] = $string;
            // }
            // $manuId = $this->input->get('tillverkare');
            // if (!empty($manuId)) {
            //     $search['fullSearch'] = urldecode($manuId);
            //     $search['Manufacturer'] = urldecode($manuId);
            //     $this->data['currentManu'] = urldecode($manuId);
            // }

            // $slug = $this->uri->segment(1);
            
            
         
        //  setlocale(LC_ALL, 'hu_HU.UTF8');
        //  echo $this->uri->segment(2);exit;

        // $param = $this->uri->segment(2);

        // $paramArray = explode('pid-', $param);

        //$productId = (int) $paramArray[1];
        $productId = (int) $string;

        $this->load->model('Category_model');

        if (!$productId) {
            redirect(site_url('products'),'',true);
        }

        // Load Model
        $this->load->model('Groups_model');
        $this->load->model('Products_model');

        // Find Product 
        $productData = $this->Products_model->getbyrsknumber($productId);
        
        if (empty($productData)) {

            // redirect(site_url('errors/error_404'));
            redirect(site_url('products'),'',true);
            // redirect(site_url('default_controller'));

        } else {

            $this->data['productData'] = $productData;

        }
        
        // Group Data
        $groupData = $this->Groups_model->get($productData->groupName);
        if ($this->session->userdata('user_id') != '') {
            $otherStore = $this->Estore_model->get_store_pro_by_rsk_order_by_discount_price($productData->RSKnummer);
        } else {
            $otherStore = $this->Estore_model->get_store_pro_by_rsk($productData->RSKnummer);
        }

        $this->data['groupData'] = $groupData;
        // Related Products
        $storesPricedata = $this->ListMaster_model->getProductByRSK($productData->RSKnummer, $this->session->userdata("user_id"));
        if (isset($storesPricedata[0]->price)) {
            $priceArr = unserialize($storesPricedata[0]->price);
            $index = 0;
            foreach ($otherStore as $otherStoreValue) {
                if (isset($priceArr[$otherStoreValue->store_id])) {
                    $otherStore[$index]->discountprice = number_format($priceArr[$otherStoreValue->store_id], 2);
                }
                $index++;
            }
        }

        if ($this->session->userdata('user_id') != '') {

            usort($otherStore, function ($item1, $item2) {
                if ($item1->discountprice == $item2->discountprice) return 0;
                return $item1->discountprice < $item2->discountprice ? -1 : 1;
            });
            
        }

        if(isset($_POST) && count($_POST) > 0) {


            //echo 'Got In';die();

           /* $this->form_validation->set_rules('message', 'Message', 'trim|required');

            if ($this->form_validation->run() == TRUE) {

            }*/

            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['telefon'] = $this->input->post('telefon');
            $data['subject'] = $this->input->post('subject');
            $data['message'] = $this->input->post('message');
            $data['product_name'] = $this->input->post('product_name');
            $data['product_rsk'] = $this->input->post('product_rsk');
            $data['product_manufacturer'] = $this->input->post('product_manufacturer');


            //$data['productInfo'] = $this->input->post('product_name') . ' [ RSK-NO: ' . $this->input->post('product_rsk') . ' | Tillverkare: ' . $this->input->post('product_manufacturer') . ' ]';
            $data['productInfo'] = $this->input->post('product_name');

            //var_dump($data); die();

            $htmlContent = $this->load->view('email/offer', $data, TRUE);

$this->email->to('pinaler@gmail.com');
//$this->email->to('nfury112@gmail.com');
$this->email->from('info@vvsoffert.se','vvsoffert');
$this->email->subject('Kontrollera Nytt Erbjudande.');
$this->email->message($htmlContent);

//Send email
             try {
                    $this->email->send();
                    $session_message['type'] = 1;
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = 'Tack för din förfrågan, vi återkommer till Er med en offert.';
                    $this->session->set_flashdata('message', $session_message);
                } catch (Exception $e) {
                    $session_message['type'] = 1;
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = $e->getMessage();
                    $this->session->set_flashdata('message', $session_message);
                }


        }
        


        $this->data['otherStore'] = $otherStore;
        $relateProductData = $this->Products_model->related_products($productData->ProductType);
        $this->data['relateProductData'] = $relateProductData;
        $this->data['user_id'] = $user_id = ($this->session->userdata('user_id') != '') ? $this->session->userdata('user_id') : 0;
        $this->data['all_list'] = $all_list = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));
        
        $category1 = $this->Category_model->get($productData->category1);
        $category2 = $this->Category_model->get($productData->category2);
        $category3 = $this->Category_model->get($productData->category3);
        $this->data['categories1']=$category1;
        $this->data['categories2']=$category2;
        $this->data['categories3']=$category3;
        //var_dump($category1);exit;

        $this->data['content'] = $this->load->view('pages/product-info', $this->data, true);
        $this->load->view('layout', $this->data);
     }

    public function catpro() {

        $this->load->model('Groups_model');
        $this->load->model('Category_model');
        $this->load->model('Products_model');
        $this->load->model('Manufacturer_model');
        $this->load->model('Login_model');
        $this->load->model('ListMaster_model');
        $this->load->model('Estore_model');

        $this->load->helper('form');

        /*$productId = $this->session->flashdata('productId');

        if(isset($productId) && $productId > 0) {

            $productData = $this->Products_model->get($productId);

            if (empty($productData)) {

                redirect(site_url());

            } else {

                $this->data['productData'] = $productData;

            }
            // Group Data
            $groupData = $this->Groups_model->get($productData->groupName);

            if ($this->session->userdata('user_id') != '') {

                $otherStore = $this->Estore_model->get_store_pro_by_rsk_order_by_discount_price($productData->RSKnummer);

            } else {

                $otherStore = $this->Estore_model->get_store_pro_by_rsk($productData->RSKnummer);

            }

            $this->data['groupData'] = $groupData;
            // Related Products
            $storesPricedata = $this->ListMaster_model->getProductByRSK($productData->RSKnummer, $this->session->userdata("user_id"));
            if (isset($storesPricedata[0]->price)) {
                $priceArr = unserialize($storesPricedata[0]->price);
                $index = 0;
                foreach ($otherStore as $otherStoreValue) {
                    if (isset($priceArr[$otherStoreValue->store_id])) {
                        $otherStore[$index]->discountprice = number_format($priceArr[$otherStoreValue->store_id], 2);
                    }
                    $index++;
                }
            }
            usort($otherStore, function ($item1, $item2) {
                if ($item1->discountprice == $item2->discountprice) return 0;
                return $item1->discountprice < $item2->discountprice ? -1 : 1;
            });


            $this->data['otherStore'] = $otherStore;
            $relateProductData = $this->Products_model->related_products($productData->ProductType);
            $this->data['relateProductData'] = $relateProductData;
            $this->data['user_id'] = $user_id = ($this->session->userdata('user_id') != '') ? $this->session->userdata('user_id') : 0;
            $this->data['all_list'] = $all_list = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));

            $this->data['content'] = $this->load->view('pages/product-info', $this->data, true);
            $this->load->view('layout', $this->data);

        }
        else {*/
            

            $this->data['currentCategory'] = 0;
            $this->data['currentManu'] = 0;
            $this->data['currentSub2'] = 0;
            $manu[''] = 'Select';

            $per_page = 100;
            $start = 0;
            $pageno = '';
            $search = array();



            $string=$this->input->get('search');
            
            if (!empty($string)) {
                $fullSearch['text'] = urldecode($string);
                $search['text'] = urldecode($string);
                $this->data['text'] = $string;
            }
            $manuId = $this->input->get('tillverkare');
            if (!empty($manuId)) {
                $search['fullSearch'] = urldecode($manuId);
                $search['Manufacturer'] = urldecode($manuId);
                $this->data['currentManu'] = urldecode($manuId);
            }

            $slug = $this->uri->segment(1);
            

            /*$id = $this->uri->segment(2);

            if($id) {
                var_dump($id); die();
            }
    */     

            //var_dump($slug);die();   
            /*if($slug == 'index.html') {
                redirect('/');
            }*/
            /*if($slug == 'product') {
                
                echo 'HI';die();
                //redirect('product/' . $this->uri->segment(2));
            }*/
            
            if($slug == 'Products') {

                $total_rows = $this->Products_model->get_total($search);
                if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
                    $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
                    $products = $this->Products_model->get_products($search, $start);
                    $this->data['productsList'] = $products;
                } else {
                    $products = $this->Products_model->get_products($search);
                    $this->data['productsList'] = $products;
                }

                if (!isset($search) || empty($search)) {
                    $manufacturers = $this->Manufacturer_model->get_all();
                    $manu['']='Välj';
                    foreach ($manufacturers as $manufacturer) {
                        $manu[$manufacturer->id] = $manufacturer->name;
                    }
                    $this->data['manufacturerList'] = $manu;
                } else {
                    $manufacturers = $this->Products_model->get_manu($search);
                    //var_dump($manufacturers); var_dump($search); die();
                    if (!empty($manufacturers)) {
                        $manu['']='Välj';
                        foreach ($manufacturers as $manufacturer) {
                            $manu[$manufacturer->MID] = $manufacturer->Mname;
                        }
                        $this->data['manufacturerList'] = $manu;
                    //var_dump($this->data['manufacturerList']);die();
                    }
                }

                $this->load->library('pagination');

                $get = $_GET;
                unset($get['per_page']);
                $actionParam = http_build_query($get);
                $this->data['end'] = $start + count($products);
                if(count($products) == 0)
                {
                    $start = 0;
                    
                }else{
                    
                    $start = ($start == 0)? $start + 1 : $start ;
                }
                $this->data['start'] = $start;
                
                $this->data['actionParam'] = $actionParam;

                $config['base_url'] = site_url('Products');
                $config['base_url'] = $config['base_url'] . '?' . http_build_query($get);
                $config['total_rows'] = $total_rows;
                $config['per_page'] = $per_page;
                $config['num_links'] = 3;
                $config['page_query_string'] = TRUE;
                $config['use_page_numbers'] = TRUE;
                $config['attributes'] = array('class' => 'page-link');

                $config['full_tag_open'] = '<ul class="pagination pull-right">';
                $config['full_tag_close'] = '</ul>';

                $config['first_link'] = 'First';
                $config['first_tag_open'] = '<li class="page-item">';
                $config['first_tag_close'] = '</li>';

                $config['last_link'] = 'Sista';
                $config['last_tag_open'] = '<li class="page-item">';
                $config['last_tag_close'] = '</li>';

                $config['next_link'] = 'nästa';
                $config['next_tag_open'] = '<li class="page-item">';
                $config['next_tag_close'] = '</li>';

                $config['prev_link'] = 'Prev';
                $config['prev_tag_open'] = '<li class="page-item">';
                $config['prev_tag_close'] = '</li>';

                $config['cur_tag_open'] = '<li class="page-item active"><a href="" class="page-link">';
                $config['cur_tag_close'] = '</a></li>';

                $config['num_tag_open'] = '<li class="page-item">';
                $config['num_tag_close'] = '</li>';
               
                $this->pagination->initialize($config);
                $this->data['user_id'] = $user_id = ($this->session->userdata('user_id') != '') ? $this->session->userdata('user_id') : 0;
                $this->data['all_list'] = $all_list = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));
                $this->data['total_rows'] = $total_rows;
                
                $this->data['content'] = $this->load->view('pages/products', $this->data, true);

                $this->load->view('layout', $this->data);
             //var_dump($this->data);var_dump($total_rows); die();


            } else {
                $name = $this->uri->segment(1);
        
                $id = $this->uri->segment(2);
        
                $this->session->set_flashdata('productId', (int) $id);
                // echo $slug." ----- ";
                // echo $name;exit;
      

                $cat = $this->Category_model->get_by_slug($name);
               //var_dump($cat);exit;
               

                //var_dump($cat); die();

            $this->data['activeCategory'] = $cat;

            //var_dump($cat); die();

            

            if(!empty($cat)) {
                //var_dump($cat); die();

                if ($cat['mp'] == 'true') {

                    $this->data['currentCategory'] = $cat['id'];
                    $search['category1'] = (int) $cat['id'];
                   

                    $total_rows = $this->Products_model->get_total($search);
                     

                    if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
                        $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
                        
                        $products = $this->Products_model->get_products($search, $start);
                        $this->data['productsList'] = $products;
                    } else {
                        $products = $this->Products_model->get_products($search);
                        $this->data['productsList'] = $products;
                    }
                } else if ($cat['pid2']) {
                    $this->data['currentCategory3'] = (int) $cat['id'];
                    $search['category3'] = (int) $cat['id'];
                    $total_rows = $this->Products_model->get_total($search);

                    if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
                        $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
                        $products = $this->Products_model->get_products($search, $start);
                        $this->data['productsList'] = $products;
                    } else {
                        $products = $this->Products_model->get_products($search);
                        $this->data['productsList'] = $products;
                    }
                    
                } else if($cat['pid']) {
                    $this->data['currentCategory2'] = (int) $cat['id'];
                    $search['category2'] = (int) $cat['id'];
                    $total_rows = $this->Products_model->get_total($search);

                    if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
                        $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
                        $products = $this->Products_model->get_products($search, $start);
                        $this->data['productsList'] = $products;
                    } else {
                        $products = $this->Products_model->get_products($search);
                        $this->data['productsList'] = $products;
                    }
                }

            if (!empty($string)) {
                $total_rows = $this->Products_model->get_total($fullSearch);

                if (isset($_GET['per_page']) and intval($_GET['per_page']) > 0) {
                    $start = max(0, ( $_GET['per_page'] - 1 ) * $per_page);
                    $products = $this->Products_model->get_products($fullSearch, $start);
                    $this->data['productsList'] = $products;
                } else {
                    $products = $this->Products_model->get_products($fullSearch);
                    $this->data['productsList'] = $products;
                }
            }
    
            //var_dump($search); die();
            // Get All Manufacturers
            if (!isset($search) || empty($search)) {
                $manufacturers = $this->Manufacturer_model->get_all();
                $manu['']='Välj';
                foreach ($manufacturers as $manufacturer) {
                    $manu[$manufacturer->id] = $manufacturer->name;
                }
                $this->data['manufacturerList'] = $manu;
            } else {

                /*$manufacturers = $this->Products_model->get_manu($search);

                if (!empty($manufacturers)) {
                    $manu['']='Välj';
                    foreach ($manufacturers as $manufacturer) {
                        $manu[$manufacturer->MID] = $manufacturer->Mname;
                    }
                    $this->data['manufacturerList'] = $manu;
                }*/

                $manufacturers = $this->Products_model->get_manu($search);

                $manu['']='Välj';

                if (!empty($manufacturers)) {

                    foreach ($manufacturers as $manufacturer) {
                        $manu[$manufacturer->MID] = $manufacturer->Mname;
                    }

                    
                }

                $this->data['manufacturerList'] = $manu;

            }

            if (!empty($string)) {
                
                $manufacturers = $this->Products_model->get_manu($fullSearch);

                $manu['']='Välj';

                if (!empty($manufacturers)) {

                    foreach ($manufacturers as $manufacturer) {
                        $manu[$manufacturer->MID] = $manufacturer->Mname;
                    }

                    
                }

                $this->data['manufacturerList'] = $manu;
            }
                    //var_dump($this->data['manufacturerList']); die();

                // Pagination
                $this->load->library('pagination');

                $get = $_GET;
                unset($get['per_page']);
                $actionParam = http_build_query($get);
                $this->data['end'] = $start + count($products);
                if(count($products) == 0)
                {
                    $start = 0;
                    
                }else{
                    
                    $start = ($start == 0)? $start + 1 : $start ;
                }
                $this->data['start'] = $start;
                
                $this->data['actionParam'] = $actionParam;

                $config['base_url'] = site_url($slug);
                $config['base_url'] = $config['base_url'] . '?' . http_build_query($get);
                $config['total_rows'] = $total_rows;
                $config['per_page'] = $per_page;
                $config['num_links'] = 3;
                $config['page_query_string'] = TRUE;
                $config['use_page_numbers'] = TRUE;
                $config['attributes'] = array('class' => 'page-link');

                $config['full_tag_open'] = '<ul class="pagination pull-right">';
                $config['full_tag_close'] = '</ul>';

                $config['first_link'] = 'First';
                $config['first_tag_open'] = '<li class="page-item">';
                $config['first_tag_close'] = '</li>';

                $config['last_link'] = 'Sista';
                $config['last_tag_open'] = '<li class="page-item">';
                $config['last_tag_close'] = '</li>';

                $config['next_link'] = 'nästa';
                $config['next_tag_open'] = '<li class="page-item">';
                $config['next_tag_close'] = '</li>';

                $config['prev_link'] = 'Prev';
                $config['prev_tag_open'] = '<li class="page-item">';
                $config['prev_tag_close'] = '</li>';

                $config['cur_tag_open'] = '<li class="page-item active"><a href="" class="page-link">';
                $config['cur_tag_close'] = '</a></li>';

                $config['num_tag_open'] = '<li class="page-item">';
                $config['num_tag_close'] = '</li>';

                $this->pagination->initialize($config);
                $this->data['user_id'] = $user_id = ($this->session->userdata('user_id') != '') ? $this->session->userdata('user_id') : 0;
                $this->data['all_list'] = $all_list = $this->ListMaster_model->get_by_user_id($this->session->userdata("user_id"));
                $this->data['total_rows'] = $total_rows;
                
                $this->data['content'] = $this->load->view('pages/products', $this->data, true);

                $this->load->view('layout', $this->data);

            } else {
                //echo 123;exit;
                // redirect(site_url('errors/error_404'));
                redirect(site_url('products'),'',true);
            }

            }
        
        //}

        

    }

    public function catpro1() {

        $name = $this->uri->segment(1);

        $id = $this->uri->segment(2);

        $this->session->set_flashdata('productId', (int) $id);

        redirect($name);

        //if($id) {
            //var_dump($id); die();
        //}
    }



    public function upt() {

        $this->load->dbforge();

        $fields = array(
            'imageURI' => array(
                'type' => 'TEXT',
                'null' => TRUE
            )
        );

        $this->dbforge->add_column('products', $fields);

    }

    public function titb() {

        ini_set('max_execution_time', 0);

        $this->load->model('Products_model');

        $params = array();

        $params['limit'] = 20000; 
        $params['offset'] = 0;

        $products = $this->Products_model->get_prdcts($params);

        foreach ($products as $p) {

            $imgName = $p['ImageName'];

            $imgArr = explode('.', $imgName);

            $base64String = 'data:image/' . $imgArr[1] . ';base64,' . base64_encode(file_get_contents('http://vvsoffert.se/scraper/' . $imgName));

            $pParams = array(
                'imageURI' => $base64String
            );

            $this->Products_model->update($pParams, (int) $p['id']);

        }

        die(count($products) . ' images are encoded.');

        //var_dump($products[0]);die();

        //var_dump(count($products));die();

        /*$imgName = 'images/3/1011085.png';

        $imgArr = explode('.', $imgName);
        //var_dump($imgName);var_dump($imgArr[1]);die();

        $base64String = 'data:image/' . $imgArr[1] . ';base64,' . base64_encode(file_get_contents('http://vvsoffert.se/scraper/' . $imgName));

        var_dump($base64String);die();*/
        
    }


}
