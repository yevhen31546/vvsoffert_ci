<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('ListMaster_model');
        $this->load->model('Estore_model');
    }

    public function index() {
        setlocale(LC_ALL, 'hu_HU.UTF8');

        if (!$this->input->get('no'))
            redirect(site_url());

        // Load Model
        $this->load->model('Groups_model');
        $this->load->model('Products_model');

        // Find Product	
        $productId = $this->input->get('no');
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

        $this->data['content'] = $this->load->view('pages/product-info', $this->data, true);
        $this->load->view('layout', $this->data);
    }

    public function pp() {

        
        $this->load->model('Category_model');

        $cs = $this->Category_model->get_all();

        foreach ($cs as $c) {
            //echo $c->slug . ' ';

            $cp = array('slug' => $this->_format($c->slug));

            $this->Category_model->update($cp, $c->id);
            echo $c->id . ' ';
        }

    }

    public function _format($slug) {

        if($slug != 'aerotemper') {

            $half_format_slug = str_replace('ae', 'a', $slug);

            $full_format_slug = str_replace('oe', 'o', $half_format_slug);

            return $full_format_slug;

        } else {

            return 'aerotemper';
        }

    }

}
