<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('Login_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('site_helper');
        $this->lang->load('auth_lang');
    }

    public function index() {
        if (!$this->session->userdata("user_id")) {
            //echo "login index";exit;
            // print_r($this->session->userdata('is_valid'));
            // exit;
            $this->session->set_userdata('login_flag', "on");
            $this->session->unset_userdata('errordata');
            $this->data['title'] = 'Login';
//		$this->data['content'] = 'login';

            if (!$this->session->userdata('is_valid')) {
                $this->session->unset_userdata('is_valid');
                $this->session->unset_userdata('token');

                $email = $this->input->post('email');
                $password = md5($this->input->post('password'));

                //$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
                $this->form_validation->set_rules("email", "E-post", "required");
                $this->form_validation->set_rules("password", "Lösenord", "required");
                $this->form_validation->set_message('required', 'Detta %s fält är obligatoriskt!');
                if ($this->form_validation->run() == false) {
                    // $is_valid = $this->Login_model->validate($email, $password);
                    // if ($is_valid == '1') {
                    //     $this->session->userdata('is_valid', true);
                    //     redirect('kontrollpanel');
                    // } else {
                    //     $this->session->set_flashdata('error', "Ogiltig e-post eller lösenord.");
                    //     redirect('logga-in');
                    // }
                   
                    // echo"sdfsdfsdf";
                    // $is_valid = $this->Login_model->validate($email, $password);
                    // exit;
                } else {
                    $is_valid = $this->Login_model->validate($email, $password);
                    if ($is_valid == '1') {
                        $this->session->userdata('is_valid', true);
                        redirect('kontrollpanel');
                    } else {
                        $this->session->set_flashdata('error', "Ogiltig e-post eller lösenord.");
                        redirect('logga-in');
                    }
                }
            }
            $this->data['content'] = $this->load->view('pages/login', $this->data, true);
            $this->load->view('layout', $this->data);
        } else {

            redirect('kontrollpanel');
            exit;
        }
    }

    public function forgot_password() {
//        set_meta_title('Forgot Password');
//        set_page_title('Forgot Password');

        if ($this->input->post('reset')) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_avail[user_master.email]');
            $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

            if ($this->form_validation->run() == TRUE) {
                $confirm_code = md5(uniqid(rand()));
                $update['new_password_key'] = $confirm_code;
                $update['new_password_requested'] = date('Y-m-d H:i:s');

                $search['email'] = $this->input->post('email');
                $user = get_by_where($search, true);
                $query = updatedata("user_master", $update, array('user_id' => $user->user_id));

//                $this->User_model->update($user->id, $update);

                $search['email'] = $this->input->post('email');
                $user = get_by_where($search, true);

                $session_message['title'] = $this->lang->line('fp_title');
                $session_message['content'] = sprintf($this->lang->line('fp_content'), $user->email);
                $this->session->set_flashdata('message', $session_message);

                $data['emailData'] = $user;

                $address = $user->email;
                $subject = "Reset Your Password";
                $message = $this->load->view('email/user-forgot-password-email', $data, TRUE);

//                $this->load->library('email');
//                $this->email->from('developer@wsfreelanzer.com', $this->config->item('site_name'));
//                $this->email->to($address);
//                $this->email->cc('wsfreelanzer@gmail.com');
//                $this->email->subject($subject);
//                $this->email->message($message);
//                $this->email->send();


                $headers = "MIME-Version: 1.0" . "\n";

                $headers .= "Content-type: text/html; charset=iso-8859-1" . "\n";

                $headers .= "Content-transfer-encoding: 8bit" . "\n";

                $headers .= "Date: " . date("r", time()) . "\n";

                $headers .= "X-Priority: 1" . "\n";

                $headers .= "X-MSMail-Priority: High" . "\n";

                $headers .= "X-Mailer: PHP/" . PHP_VERSION . "\n";

                $headers .= "X-MimeOLE: Produced by cardverify.net" . "\n";

                $headers .= "From: " . 'VVSOFFERT' . " <" . 'developer@wsfreelanzer.com' . ">" . "\n";

                $headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER["HTTP_HOST"] . ">" . "\n";

                try {
                    @mail($address, $subject, $message, $headers);
                } catch (Exception $e) {
                    echo "<pre>";
                    print_r($e);
                    exit;
                }

                $session_message['type'] = 1;
                $session_message['title'] = 'Success!';
                $session_message['content'] = "We have sent you a reset password link.Please check your email";
                $this->session->set_flashdata('message', $session_message);

                redirect(site_url('logga-in'));
            }
        }

        $data['email'] = $this->input->post('email');
        $data['content'] = $this->load->view('pages/forgot-password', $data, TRUE);
        $this->load->view('layout', $data);
    }

    // Set New Password
    public function reset_password() {
        if (!$this->uri->segment(2))
            redirect(site_url());

        $key = $this->uri->segment(2);
        $search['new_password_key'] = $key;
        $user = get_by_where($search, true);
        if ($user) {

            if ($this->input->post('reset')) {
                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[15]|callback__valid_password');
                $this->form_validation->set_rules('cpassword', 'Confirm New Password', 'trim|required|matches[password]');
                $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
                $this->form_validation->set_message('matches', '%s is not match with %s.');
                if ($this->form_validation->run() == TRUE) {
                    $update['new_password_key'] = "NULL";
                    $update['new_password_requested'] = "NULL";
                    $update['status'] = '1';
                    $update['password'] = md5($this->input->post('password'));
//                    $this->User_model->update($user->id, $update);
                    $query = updatedata("user_master", $update, array('user_id' => $user->user_id));

                    $session_message['title'] = $this->lang->line('rp_title');
                    $session_message['content'] = sprintf($this->lang->line('rp_content'), $user->email);
                    $this->session->set_flashdata('message', $session_message);

                    $data['emailData'] = $user;

                    $address = $user->email;
                    $subject = "Password Changed";
                    $message = $this->load->view('email/user-password-changed', $data, TRUE);

//                    $this->load->library('email');
//                    $this->email->from('developer@wsfreelanzer.com', $this->config->item('site_name'));
//                    $this->email->to($address);
//                    $this->email->cc('wsfreelanzer@gmail.com');
//                    $this->email->subject($subject);
//                    $this->email->message($message);
//                    $this->email->send();

                    $headers = "MIME-Version: 1.0" . "\n";

                    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\n";

                    $headers .= "Content-transfer-encoding: 8bit" . "\n";

                    $headers .= "Date: " . date("r", time()) . "\n";

                    $headers .= "X-Priority: 1" . "\n";

                    $headers .= "X-MSMail-Priority: High" . "\n";

                    $headers .= "X-Mailer: PHP/" . PHP_VERSION . "\n";

                    $headers .= "X-MimeOLE: Produced by cardverify.net" . "\n";

                    $headers .= "From: " . 'VVSOFFERT' . " <" . 'developer@wsfreelanzer.com' . ">" . "\n";

                    $headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER["HTTP_HOST"] . ">" . "\n";
                    try {
                        @mail($address, $subject, $message, $headers);
                    } catch (Exception $e) {
                        echo "<pre>";
                        print_r($e);
                        exit;
                    }

                    $session_message['type'] = 1;
                    $session_message['title'] = 'Success!';
                    $session_message['content'] = "Your password is changed successfully.You can login now.";
                    $this->session->set_flashdata('message', $session_message);
                    redirect(site_url('logga-in'));
                }
            }

            $data['password'] = $this->input->post('password');
            $data['content'] = $this->load->view('pages/reset-password', $data, TRUE);
            $this->load->view('layout', $data);
        } else {
            $session_message['type'] = 2;
            $session_message['title'] = $this->lang->line('acc_expired_title');
            $session_message['content'] = $this->lang->line('acc_expired_content');
            $this->session->set_flashdata('message', $session_message);

            redirect(site_url());
        }
    }

    public function logout() {
        //$removeuser = $this->Login_model->removeUser($this->session->userdata('email'));
//		$this->session->unset_userdata();
        $this->session->unset_userdata('userData');
        $this->session->sess_destroy();
        redirect('logga-in');
    }

//	public function forgotpassword(){
//		$this->data['title'] = 'Forgotpassword';
//		$this->data['content'] = 'forgotpassword';
//		//if($this->input->post('sbmt') != ''){
//			//echo "<prE>";print_r($this->input->post());exit;
//			$email = $this->input->post("email");
//			
//			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//			$this->form_validation->set_rules("email", "Email", "required");
//			
//			if ($this->form_validation->run() == false){}
//			else
//			{
//				$is_valid = $this->Login_model->emailvalidate($email);
//				if($is_valid == '1'){
//					$this->session->unset_userdata();
//					$this->session->set_flashdata('success', "Your new password is sent to your authorized Email Id.");
//					redirect('logga-in');
//				}
//				elseif($is_valid == '2'){
//					$this->session->set_flashdata('error', "You have register through Social Media you can't use Forgot Password");
//				}
//				else{
//					$this->session->set_flashdata('error', "Email address does not exists.");
//				}
//			}
//		//}
//		render_page('template', $this->data);
//	}
//	
//	public function VerifyLink($user_id){
//		
//		$user_id = decrypt_string($user_id);
//		//echo $user_id;exit;
//		$userArray = array(
//			"status" => "1"
//		);
//		$sendmail = $this->Login_model->updateGymUserStatus($user_id,$userArray);
//		if($sendmail){
//			//echo "Your account is activated.Your account link is <a target='_blank' href='".$this->config->item('base_url')."'>".$this->config->item('base_url')."</a>";
//			$this->load-view('thankyou');	
//		}
//	}

    /* public function getGymlocationdata_OLD(){
      $searchval = $this->input->post('searchtxt');
      $resultdata = $this->Login_model->searchGymdata($searchval);
      $ary = array();
      foreach($resultdata as $location1){
      $i=0;
      $ary[][$i] = $location1->service_id.','.$location1->lattitude.','.$location1->longitude.','.$location1->user_id;
      $i++;
      }
      echo str_replace('"', "", json_encode($ary, JSON_HEX_APOS));
      } */


    public function getServiceImage() {
        $service_id = $this->input->post('service_id');
        $service_data = getListdata(array("service_id" => $service_id), 'gym_service');
        echo $this->config->item('front_image_path') . $service_data[0]->image;
    }

    public function _valid_password($str) {

        $this->form_validation->set_message('_valid_password', '%s has to be a number, a letter or one of the following: !@#$%');
        if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]+$/', $str)) {
            return false;
        } else {
            return true;
        }
    }

    // Valid Phone No.
    public function _valid_phoneno($str) {
        $this->form_validation->set_message('_valid_phoneno', '%s has to be a number between 8 - 10 digit.');
        if (!preg_match('/^[0-9]+$/', $str)) {
            return false;
        } else {
            return true;
        }
    }

}

?>
