<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PHPImageWorkshop\ImageWorkshop as ImageWorkshop;

class Site extends Front_controller {

    function index() {
        $data_msg = array();
// ----- Load View page
        $this->template->set_meta_title('Home')
                ->set_meta_description('Home')
                ->view('site/index', $data_msg);
    }

    function login() {
        if ($this->auth->is_login()) {
            $user_type = $this->auth->get_user_session('UserTypeId');
            if ($user_type == 3) {
                redirect(site_url('customer'));
                exit;
            } else {
                redirect(site_url('provider'));
                exit;
            }
        }

        $data_msg = array();

        $this->template->set_meta_title('Login')
                ->set_meta_description('Login')
                ->view('site/login', $data_msg);
    }

    function signup() {
        if ($this->auth->is_login()) {
            redirect(site_url('provider'));
            exit;
        }

        $data_msg = array();

        $this->template->set_meta_title('Register')
                ->set_meta_description('Register')
                ->view('site/signup', $data_msg);
    }

    public function dosignup() {

        if (IS_AJAX) {
            if (!$this->auth->is_login()) {
                $this->form_validation->set_rules('FName', 'First Name', 'trim|required');
                $this->form_validation->set_rules('SName', 'Last name', 'trim|required');
                $this->form_validation->set_rules('EmailId', 'Email', 'trim|required|valid_email|is_unique_email');
                $this->form_validation->set_rules('Phone', 'Phone', 'trim|regex_match[/^[0-9+.-]*$/]');
                $this->form_validation->set_rules('Password', 'Password', 'required|min_length[6]|max_length[12]|matches[ConfirmPassword]');
                $this->form_validation->set_rules('ConfirmPassword', 'Confirm password', 'trim|required');
                if ($this->form_validation->run() == true) {

                    $email = set_value('EmailId');
                    $password = set_value('password');
                    $FName = set_value('FName');
                    $SName = set_value('SName');
                    $Phone = set_value('Phone');
                    $password = $_POST['Password'];
                    $ActivationCode = generate_activation_code($email);
                    $UserId = pk();

                    $value = $FName . "-" . $SName;
                    $value = $this->all_function->get_value($value);
                    $slug = $this->all_function->get_user_slug($value);

                    $user_master_data = array(
                        'UserTypeId' => '3',
                        'EmailId' => $email,
                        'Slug' => $slug,
                        'Password' => md5($password),
                        'FName' => $FName,
                        'SName' => $SName,
                        'Phone' => $Phone,
                        'Sex' => '6',
                        'AboutMe' => '',
                        'ProfileImage' => '',
                        'CustomerType' => 'customer',
                        'ActivationCode' => $ActivationCode,
                        //'AddedDate' => date('Y-m-d H:i:s'),
                        'AddedDate' => date('Y-m-d H:i:s'),
                        'UpdatedDate' => '0000-00-00 00:00:00',
                        'Status' => '0',
                    );


                    $this->auth_model->insert_into_user_master($user_master_data);


                    Events::trigger('new_user_registration_success', $user_master_data);


                    $this->ajax_response['type'] = 'success';

                    $this->ajax_response['message'] = "We've just sent a confirmation link to <strong>$email</strong>. Just click the link in that email & you're in!";
                } else {
                    $this->ajax_response['type'] = 'warning';
                    $error = [];

                    foreach ($this->form_validation->error_array() as $key => $val) {
                        $error[$key] = $val;
                    }

                    $this->ajax_response['message'] = $error;
                }
            }
        }
        $this->render_ajax_response();
    }

    public function staff_confirm_info_submit() {
        if (IS_AJAX) {
            if (!$this->auth->is_login()) {
                $user_master_id = $_POST['UserId'];
                $this->form_validation->set_rules('FName', 'First Name', 'trim|required');
                $this->form_validation->set_rules('SName', 'Last name', 'trim|required');
                $this->form_validation->set_rules('Phone', 'Phone', 'trim|regex_match[/^[0-9+.-]*$/]');
                if ($this->form_validation->run() == true) {

                    $FName = set_value('FName');
                    $SName = set_value('SName');
                    $Phone = set_value('Phone');

                    $user_master_data = array(
                        'FName' => $FName,
                        'SName' => $SName,
                        'Phone' => $Phone,
                        'UpdatedDate' => date('Y-m-d H:i:s'),
                    );


                    $this->auth_model->update_user_master_by_UserId($user_master_data, $user_master_id);

                    $this->load->model('staff_details_model');
                    $staff_details = $this->staff_details_model->get_staff_details_by_user_master_id($user_master_id);
                    $this->load->model('staff_master_model');
                    $staff_master_block_data = array(
                        'first_name' => $FName,
                        'last_name' => $SName,
                        'phone' => $Phone,
                    );
                    $this->staff_master_model->update_staff_master_by_id($staff_master_block_data, $staff_details->staff_master_id);



                    $this->ajax_response['type'] = 'success';
                    $this->ajax_response['url'] = site_url('login');

                    $this->ajax_response['message'] = "Informations Successfully Updated";
                } else {
                    $this->ajax_response['type'] = 'warning';
                    $error = [];

                    foreach ($this->form_validation->error_array() as $key => $val) {
                        $error[$key] = $val;
                    }

                    $this->ajax_response['message'] = $error;
                }
            }
        }
        $this->render_ajax_response();
    }

    public function activation() {
        if ($this->auth->is_login()) {
            redirect(base_url());
            exit;
        }
        $id = $this->input->get('id');
        if ($id == '') {
            redirect(site_url('invalid-link'));
        } else {
            $oUser = $this->auth_model->fetch_user_master_by_ActivationCode($id);
            if (!empty($oUser) && $oUser->Status == '0') {
                $data['success_msg'] = 'Success! Your account has been activated.';
                $this->auth_model->update_user_master_by_UserId(array('Status' => '1', 'ActivationCode' => Null), $oUser->UserId);

                $this->load->model('staff_master_model');
                $this->load->model('staff_details_model');
                $this->load->model('staff_module_permission_model');
                $this->load->model('business_module_master_model');
                $this->load->model('business_master_model');

                $user_master_id = $oUser->UserId;

                $business = $this->business_master_model->get_business_by_user_master_id($user_master_id);

                if (count($business) > 0) {

//---------Activate Business----------
                    $block_data = array(
                        'status' => '1',
                    );
                    $this->business_master_model->update_business_master_by_id($block_data, $business->id);

                    $business_master_id = $business->id;

                    $data = array(
                        'first_name' => $oUser->FName,
                        'user_master_id' => $user_master_id,
                        'last_name' => $oUser->SName,
                        'email' => $oUser->EmailId,
                        'phone' => $oUser->Phone,
                        'phone_type' => 'cell',
                        'status' => '1',
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $staff_id = $this->staff_master_model->insert_into_staff_master($data);

                    $data = array(
                        'staff_master_id' => $staff_id,
                        'busniness_master_id' => $business_master_id,
                        'user_master_id' => $user_master_id,
                        'appoinment_per_day' => 0,
                        'max_hour_per_day' => 0,
                        'role' => 'owner',
                        'color' => $this->all_function->getColor(),
                        'status' => '1'
                    );
                    $staff_details_id = $this->staff_details_model->insert_into_staff_details($data);


//staff module_permission

                    $business_module = $this->business_module_master_model->get_all_module();


                    foreach ($business_module as $val) {
                        $data = array(
                            'staff_master_id' => $staff_id,
                            'user_master_id' => $user_master_id,
                            'busniness_master_id' => $business_master_id,
                            'module_master_id' => $val['id'],
                            'status' => '1',
                        );
                        $staff_module_permission_id = $this->staff_module_permission_model->insert_into_staff_module_permission($data);
                    }
                }


                redirect(site_url('login'));
            } else {
                redirect(site_url('invalid-link'));
            }
        }
    }

    public function staff_activation() {
        $this->load->model('staff_master_model');
        $this->load->model('staff_details_model');
        $this->load->model('staff_service_assign_model');
        $this->load->model('staff_module_permission_model');
        $this->load->model('business_module_master_model');


        if ($this->auth->is_login()) {
            redirect(base_url());
            exit;
        }
        $id = $this->input->get('staff_id');
        if ($id == '') {
            redirect(site_url('invalid-link'));
        } else {
            $staff_master = $this->staff_master_model->get_inactive_staff_master_by_id_status($id);
            if (count($staff_master) == 0) {
                redirect(site_url('invalid-link'));
            } else {

//                $this->auth_model->update_user_master_by_UserId(array('Status' => '1', 'ActivationCode' => Null), $oUser->UserId);
                redirect(site_url('staff-change-password/' . $id));
            }
            if (!empty($oUser) && $oUser->Status == '0') {
                $data['success_msg'] = 'Success! Your account has been activated.';
                $this->auth_model->update_user_master_by_UserId(array('Status' => '1', 'ActivationCode' => Null), $oUser->UserId);
                redirect(site_url('login'));
            } else {
                redirect(site_url('invalid-link'));
            }
        }
    }

    public function staff_change_password($id) {
        $this->load->model('staff_master_model');
        $staff_master = $this->staff_master_model->get_inactive_staff_master_by_id_status($id);

        $this->template->set_meta_title('Staff: change Password')
                ->set_meta_description('Staff: change Password')
                ->view('site/reset_password_staff', ['staff_master' => $staff_master]);
    }

    public function invalid_link() {
        $data['msg'] = "Hmmm. Either That's an invalid link or You've already activated your account using this link. If you need help, just reach out to us.";
        $this->template->view('site/invalid_reset_password', $data);
    }
   
    public function dologin() {

        if (IS_AJAX) {
            $this->form_validation->set_rules('EmailId', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('Password', 'Password', 'required');

            if ($this->form_validation->run() == true) {
//check to see if the user is logging in
//check for "remember me"
                $remember = (bool) $this->input->post('remember');
                $login = $this->auth->login($this->input->post('EmailId'), trim($this->input->post('Password')), $remember);

//check blocked user identity
                if (!$this->auth->blocked($this->input->post('EmailId'))) {

                    $this->ajax_response['type'] = 'warning';
                    $this->ajax_response['message']['EmailId'] = $this->auth->get_error();
                }
//end checking blocked user identity


                if ($login) {

                    $user_type = $this->auth->get_user_session('UserTypeId');
//if the login is successful
//redirect them back to the home page
                    $this->session->set_flashdata('success_msg', $this->auth->get_message());


                    $this->session->unset_userdata('user_blocked_' . $this->input->post('EmailId'));
                    $this->ajax_response['type'] = 'success';

                    if ($this->input->get('return_url') && $this->input->get('return_url') != '') {


                        $redirect_url = urldecode($this->input->get('return_url'));
                        $this->ajax_response['url'] = $redirect_url;
                    } else {
                        /* ---------- set guest user data ----------- */

                        if ($user_type == 3) {

                            $this->ajax_response['url'] = site_url('customer');
                        } else {
                            $this->ajax_response['url'] = site_url('provider');
                        }
                    }
                } else {
// Block user for 24 hours
                    if ($this->session->userdata('user_blocked_' . $this->input->post('EmailId')) != '' && $this->session->userdata('user_blocked_' . $this->input->post('EmailId')) == '2') {
                        $this->auth_model->update_user_master_by_EmailId(array('LoginFncBlocked' => '4', 'LoginFncBlockedDate' => date('Y-m-d H:i:s')), $this->input->post('EmailId'));
                        $this->session->unset_userdata('user_blocked_' . $this->input->post('EmailId'));
                    } else {
                        self::user_block_count($this->input->post('EmailId'));
                    }
// End blocking user
//if the login was un-successful
//redirect them back to the login page
//    $this->session->set_flashdata('error_msg', $this->auth->get_error());

                    $this->ajax_response['type'] = 'warning';
                    $this->ajax_response['message']['EmailId'] = $this->auth->get_error();
                }
            } else {
                $this->ajax_response['type'] = 'warning';
                $error = [];

                foreach ($this->form_validation->error_array() as $key => $val) {
                    $error[$key] = $val;
                }
                $this->ajax_response['message'] = $error;
            }
        }

        $this->render_ajax_response();
    }

    public function doforgotpassword() {
        if (!$this->auth->is_login()) {
            $this->form_validation->set_rules('forgot_email_id', 'Email', 'required|valid_email');
            if ($this->form_validation->run() == true) {
                $oUser = $this->auth_model->get_user_by_email(set_value('forgot_email_id'));
                if (!empty($oUser) && $oUser->Status == '1') {
                    $key = substr(sha1(microtime() . $oUser->EmailId), 0, 40);
                    $this->auth_model->update_user_master_by_UserId(array('ForgottenPasswordCode' => $key), $oUser->UserId);
//
                    Events::trigger('forgot_password_success', $oUser->UserId);

                    $this->ajax_response['type'] = 'success';
                    $this->ajax_response['message'] = "We've just emailed a password re-set link to <strong>{$oUser->EmailId}</strong>. Please open that email & follow the instructions.";
                } else {
                    $this->ajax_response['type'] = 'warning';
                    $this->ajax_response['message']['forgot_email_id'] = "Oops! That's an invalid email address. Please try again or reach out to us for help.";
                }
            } else {
                $this->ajax_response['type'] = 'warning';
                $this->ajax_response['message']['forgot_email_id'] = array_shift($this->form_validation->error_array());
            }
        }
        $this->render_ajax_response();
    }

    public function reset_password() {
        if ($this->auth->is_login()) {
            redirect(site_url('provider'));
            exit;
        }
        $this->session->set_userdata('reset_pasword_success', '1');
//ForgottenPasswordCode id   
        $id = $this->input->get('id');
        $data['code'] = $id;
        $oUser = $this->auth_model->fetch_user_master_by_ForgottenPasswordCode($id);
        $this->template->set_meta_title('Reset password');
        if ($id != '' && !empty($oUser)) {
            $this->template->view('site/reset_password', $data);
        } else {
//request expired
            $data['msg'] = "Sorry! this is invalid link.";
            $this->template->view('site/invalid_reset_password', $data);
        }
    }

    public function do_reset_password() {
        if (!$this->auth->is_login()) {
            $oUser = $this->auth_model->fetch_user_master_by_ForgottenPasswordCode($_POST['code']);
            $this->form_validation->set_rules('Password', 'Password', 'required|min_length[6]|max_length[12]|matches[PasswordConfirm]');
            $this->form_validation->set_rules('PasswordConfirm', 'Confirm Password', 'required');
            if ($this->form_validation->run() == TRUE) {
                $password = $this->input->post('Password');
                $this->auth_model->update_user_master_by_UserId(array('ForgottenPasswordCode' => '', 'Password' => digest_password($password)), $oUser->UserId);
                $this->ajax_response['type'] = 'success';
                $this->ajax_response['url'] = site_url('login');
                $this->ajax_response['message'] = 'Password reset successfully.';
            } else {
                $this->session->set_userdata('reset_pasword_success', '1');
                $this->ajax_response['type'] = 'warning';
                $error = [];
                foreach ($this->form_validation->error_array() as $key => $val) {
                    $error[$key] = $val;
                }
                $this->ajax_response['message'] = $error;
            }
        }
        $this->render_ajax_response();
    }

    public function reset_password_success() {
        if ($this->auth->is_login()) {
            redirect(site_url('my-account/details'));
            exit;
        }
        if ($this->session->userdata('reset_pasword_success') !== '') {
            $data['msg'] = $this->session->userdata('reset_pasword_success');
            $this->session->set_userdata('reset_pasword_success', '');
            $this->template->set_meta_title('Reset password')
                    ->view('user/reset_pasword_success', $data);
        } else {
            redirect(base_url());
            exit;
        }
    }

    public function logout() {
        $this->auth->logout();
        redirect('login', 'refresh');
    }

    public function user_block_count($EmailId) {
        if ($this->session->userdata('user_blocked_' . $EmailId) != '') {
            $this->session->set_userdata(array('user_blocked_' . $EmailId => ((int) $this->session->userdata('user_blocked_' . $EmailId) + 1)));
        } else {
            $this->session->set_userdata(array('user_blocked_' . $EmailId => 1));
        }
    }

    function ajax_is_login() {

        if ($this->auth->get_user_session('UserId') != '') {
            $is_login = true;
            $ProfileImage = $this->auth->get_user_session('ProfileImage');
            if ($ProfileImage != '') {
                $img = "small_{$ProfileImage}";
                $img = '<img src="' . base_url("assets/upload/user_avatar/$img") . '">';
            } else {
                $img = '<img src = "' . base_url("assets/images/small_user.png") . '" alt = "">';
            }
        } else {
            $is_login = false;
            $img = '';
        }
//return $this->cart_model->tot_cart_items($cartUserId);
        echo json_encode(array("is_login" => $is_login, "img" => $img));
        exit;
    }

    function howitworks() {
        $data_msg = array();



// ----- Load View page
        $this->template->set_meta_title('How it works')
                ->set_meta_description('How it works')
                ->view('site/howitworks', $data_msg);
    }

    function professionalsignup() {
        if ($this->auth->is_login()) {
            redirect(site_url('provider'));
            exit;
        }

        $data_msg = array();

        $this->template->set_meta_title('Professional Register')
                ->set_meta_description('Professional Register')
                ->view('site/professionalsignup', $data_msg);
    }

    public function doprofessionalsignup() {
        if (IS_AJAX) {
            if (!$this->auth->is_login()) {
                $this->form_validation->set_rules('EmailId', 'Email', 'trim|required|valid_email|is_unique_email');
                $this->form_validation->set_rules('Password', 'Password', 'required|min_length[6]|max_length[12]');
                $this->form_validation->set_rules('business_name', 'Business Name', 'trim|required|is_unique_business_name');
                $this->form_validation->set_rules('website_name', 'Website Address', 'trim|required|regex_match[/^[a-zA-Z0-9-]*$/]|is_unique_website_name');
                $this->form_validation->set_rules('address', 'Address', 'required');
                $this->form_validation->set_rules('city', 'City', 'required');
                $this->form_validation->set_rules('state_id', 'State', 'required');
                $this->form_validation->set_rules('pin_code', 'Pin Code', 'trim|required|regex_match[/^[0-9a-zA-Z]*$/]');
                $this->form_validation->set_rules('FName', 'First Name', 'trim|required|alpha');
                $this->form_validation->set_rules('SName', 'Last Name', 'trim|required|alpha');
                $this->form_validation->set_rules('scheduling_part_type', 'Scheduling Type', 'required');
                $this->form_validation->set_rules('termsandcondition', 'Terms and condition', 'required');
                if ($this->form_validation->run()) {
                    $email = set_value('EmailId');
                    $password = set_value('Password');
                    $business_name = set_value('business_name');
                    $website_name = set_value('website_name');
                    $address = set_value('address');
                    $public_listing = set_value('public_listing');
                    if ($public_listing == '') {
                        $public_listing = '5';
                    }
                    $city = set_value('city');
                    $state_id = set_value('state_id');
                    $pin_code = set_value('pin_code');
                    $FName = set_value('FName');
                    $SName = set_value('SName');
                    $scheduling_part_type = set_value('scheduling_part_type');
                    $ActivationCode = generate_activation_code($email);
                    $UserId = pk();

                    $value = $FName . "-" . $SName;
                    $value = $this->all_function->get_value($value);
                    $slug = $this->all_function->get_user_slug($value);

                    $user_master_data = array(
                        'UserTypeId' => '2',
                        'CustomerType' => 'provider',
                        'EmailId' => $email,
                        'Slug' => $slug,
                        'Password' => digest_password($password),
                        'FName' => $FName,
                        'SName' => $SName,
                        'ActivationCode' => $ActivationCode,
                        'AddedDate' => date('Y-m-d H:i:s'),
                        'UpdatedDate' => '0000-00-00 00:00:00',
                        'Status' => '0',
                    );
                    $user_master_id = $this->auth_model->insert_into_user_master($user_master_data);

                    $str1 = str_replace(' ', '-', $business_name);
                    $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str1);

                    $business_master_data = array(
                        'user_master_id' => $user_master_id,
                        'business_name' => $business_name,
                        'slug' => $str,
                        'address' => $address,
                        'public_listing' => $public_listing,
                        'city' => $city,
                        'state_id' => $state_id,
                        'pin_code' => $pin_code,
                        'scheduling_part_type' => $scheduling_part_type,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => '0000-00-00 00:00:00',
                        'status' => '0',
                    );

                    $this->load->model('business_master_model');

                    $business_master_id = $this->business_master_model->insert_into_business_master($business_master_data);



                    Events::trigger('new_user_registration_success', $user_master_data);
                    $this->ajax_response['type'] = 'success';
                    $this->ajax_response['message'] = "We've just sent a confirmation link to <strong>$email</strong>. Just click the link in that email & you're in!";
                } else {
                    $this->ajax_response['type'] = 'warning';
                    $this->ajax_response['message'] = validation_errors();
                }
            }
        }
        $this->render_ajax_response();
    }

    public function doprofessionalsignupvalidation() {
        if (IS_AJAX) {
            if (!$this->auth->is_login()) {
                if ($_POST['Type'] == 'pro_register') {
                    $this->form_validation->set_rules('EmailId', 'Email', 'trim|required|valid_email|is_unique_email');
                    $this->form_validation->set_rules('Password', 'Password', 'required|min_length[6]|max_length[12]');
                    if ($this->form_validation->run()) {
                        $this->ajax_response['type'] = 'success';
                    } else {
                        $this->ajax_response['type'] = 'warning';
                        $error = [];
                        foreach ($this->form_validation->error_array() as $key => $val) {
                            $error[$key] = $val;
                        }
                        $this->ajax_response['message'] = $error;
                    }
                } else if ($_POST['Type'] == 'pro_register_1') {
                    $this->form_validation->set_rules('business_name', 'Business Name', 'trim|required|is_unique_business_name');
                    $this->form_validation->set_rules('website_name', 'Website Address', 'trim|required|regex_match[/^[a-zA-Z0-9-]*$/]|is_unique_website_name');
                    if ($this->form_validation->run()) {
                        $this->ajax_response['type'] = 'success';
                    } else {
                        $this->ajax_response['type'] = 'warning';
                        $error = [];
                        foreach ($this->form_validation->error_array() as $key => $val) {
                            $error[$key] = $val;
                        }
                        $this->ajax_response['message'] = $error;
                    }
                } else if ($_POST['Type'] == 'pro_register_2') {
                    $this->form_validation->set_rules('address', 'Address', 'required');
                    $this->form_validation->set_rules('city', 'City', 'required');
                    $this->form_validation->set_rules('state_id', 'State', 'required');
                    $this->form_validation->set_rules('pin_code', 'Pin Code', 'trim|required|regex_match[/^[0-9a-zA-Z]*$/]');
                    if ($this->form_validation->run()) {
                        $this->ajax_response['type'] = 'success';
                    } else {
                        $this->ajax_response['type'] = 'warning';
                        $error = [];
                        foreach ($this->form_validation->error_array() as $key => $val) {
                            $error[$key] = $val;
                        }
                        $this->ajax_response['message'] = $error;
                    }
                } else if ($_POST['Type'] == 'pro_register_3') {
                    $this->form_validation->set_rules('FName', 'First Name', 'trim|required|alpha');
                    $this->form_validation->set_rules('SName', 'Last Name', 'trim|required|alpha');
                    $this->form_validation->set_rules('scheduling_part_type', 'Scheduling Type', 'required');
                    $this->form_validation->set_rules('termsandcondition', 'Terms and condition', 'required');
                    if ($this->form_validation->run()) {
                        $this->ajax_response['type'] = 'success';
                    } else {
                        $this->ajax_response['type'] = 'warning';
                        $error = [];
                        foreach ($this->form_validation->error_array() as $key => $val) {
                            $error[$key] = $val;
                        }
                        $this->ajax_response['message'] = $error;
                    }
                }
            }
        }
        $this->render_ajax_response();
    }

    public function staff_confirm_info() {
        $id = $_GET['user_id'];
        $this->load->model('user_model');
        $user_master = $this->user_model->get_user_by_id($id);

        $this->template->set_meta_title('Staff: confirm info')
                ->set_meta_description('Staff: confirm info')
                ->view('site/staff_confirm_info', ['user_master' => $user_master]);
    }

    public function do_staff_change_password() {
        $id = $_GET['staff_id'];
        $this->load->model('staff_master_model');
        $this->load->model('staff_details_model');
        $this->load->model('staff_service_assign_model');
        $this->load->model('staff_module_permission_model');
        $this->load->model('business_module_master_model');

        $staff_master = $this->staff_master_model->get_inactive_staff_master_by_id_status($id);

        $this->form_validation->set_rules('Password', 'Password', 'required|min_length[6]|max_length[12]|matches[PasswordConfirm]');
        $this->form_validation->set_rules('PasswordConfirm', 'Confirm Password', 'required');
        if ($this->form_validation->run() == TRUE) {

            $password = $this->input->post('Password');

            $value = $staff_master->first_name . "-" . $staff_master->last_name;
            $value = $this->all_function->get_value($value);
            $slug = $this->all_function->get_user_slug($value);

            $user_master_data = array(
                'UserTypeId' => '2',
                'CustomerType' => 'provider',
                'EmailId' => $staff_master->email,
                'Slug' => $slug,
                'Password' => md5($password),
                'FName' => $staff_master->first_name,
                'SName' => $staff_master->last_name,
                'Phone' => $staff_master->phone,
                'Sex' => '6',
                'AboutMe' => '',
                'ProfileImage' => '',
                'ActivationCode' => '',
                'AddedDate' => date('Y-m-d H:i:s'),
                'Status' => '1',
            );


            $user_id = $this->auth_model->insert_into_user_master($user_master_data);
            $staff_master_block_data = array(
                'user_master_id' => $user_id,
                'status' => '1',
            );
            $this->staff_master_model->update_staff_master_by_id($staff_master_block_data, $id);
            $staff_details_block_data = array(
                'user_master_id' => $user_id,
                'status' => '1',
            );
            $this->staff_master_model->update_staff_details_by_staff_master_id($staff_details_block_data, $id);
            $staff_module_permission_block_data = array(
                'user_master_id' => $user_id,
                'status' => '1',
            );
            $this->staff_master_model->update_staff_module_permission_by_staff_master_id($staff_module_permission_block_data, $id);
            $staff_service_assign_block_data = array(
                'user_master_id' => $user_id,
                'status' => '1',
            );
            $this->staff_master_model->update_staff_service_assign_by_staff_master_id($staff_service_assign_block_data, $id);

//update all tables regarding staff by user master id.and reload to another page where country first name last name gender agree
            $this->ajax_response['type'] = 'success';
            $this->ajax_response['url'] = site_url('staff-confirm-info') . "?user_id=" . $user_id;
            $this->ajax_response['message'] = 'Password reset successfully.';
        } else {
            $this->session->set_userdata('reset_pasword_success', '1');
            $this->ajax_response['type'] = 'warning';
            $error = [];
            foreach ($this->form_validation->error_array() as $key => $val) {
                $error[$key] = $val;
            }
            $this->ajax_response['message'] = $error;
        }

        $this->render_ajax_response();
    }

    public function accept_businees_invitation($id = "") {
        $this->load->model('staff_details_model');
        if ($id == "") {
            redirect(base_url());
            exit;
        }

        $staff = $this->staff_details_model->get_staff_details_by_id($id);

        if (count($staff) > 0) {

            $block_data = array(
                'status' => '1',
            );
            $this->auth_model->update_staff_details_by_id($block_data, $id);

            redirect(site_url('invitation-accept'));
        } else {
            redirect(base_url());
        }
    }

    public function accept_invite() {
        $data['msg'] = "You have successfully accept the invitation. Please login to check the business details.";
        $this->template->view('site/invalid_reset_password', $data);
    }

    public function dashboard() {
        if (!$this->auth->is_login()) {
            redirect(site_url('login'));
            exit;
        }

        $data_msg = array();
        $this->load->model('user_model');
        $this->load->model('booking_master_model');
        $data_msg['model'] = $this->user_model->get_user_by_id($this->auth->current_user_id());
        $data_msg['upcoming_app'] = $this->booking_master_model->get_allupcoming_byclientID($this->auth->current_user_id());

// ----- Load View page
        $this->template->set_meta_title('Dashboard')
                ->set_meta_description('Dashboard')
                ->view('site/dashboard', $data_msg);
    }

    public function customer_appointment_history() {
        if (!$this->auth->is_login()) {
            redirect(site_url('login'));
            exit;
        }
        $data_msg = array();
        $this->load->model('user_model');
        $this->load->model('booking_master_model');
        $data_msg['model'] = $this->user_model->get_user_by_id($this->auth->current_user_id());
        $data_msg['allapp'] = $this->booking_master_model->get_bookinghistory_byclientID($this->auth->current_user_id());

// ----- Load View page
        $this->template->set_meta_title('Account Details')
                ->set_meta_description('Account Details')
                ->view('site/all_appointment', $data_msg);
    }

    public function customer_account_details() {
        if (!$this->auth->is_login()) {
            redirect(site_url('login'));
            exit;
        }
        $data_msg = array();
        $this->load->model('user_model');
        $data_msg['model'] = $this->user_model->get_user_by_id($this->auth->current_user_id());

// ----- Load View page
        $this->template->set_meta_title('Account Details')
                ->set_meta_description('Account Details')
                ->view('site/account_details', $data_msg);
    }

    public function edit_profile() {
        if (IS_AJAX) {
            $this->load->model('user_model');
            $data_msg['model'] = $this->user_model->get_user_by_id($this->auth->current_user_id());
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]|max_length[12]');
            if ($this->input->post('password') != '') {
                $this->form_validation->set_rules('password2', 'Confirm password', 'trim|required|matches[password]');
            }
            $this->form_validation->set_rules('first_name', 'First name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('last_name', 'Last Time', 'trim|required|xss_clean');
            $this->form_validation->set_rules('birthday', 'Date of birth', "trim|xss_clean|required");
            $this->form_validation->set_rules('phone', 'Phone', "trim|xss_clean|required");

            $original_email = $data_msg['model']['EmailId'];

            if ($this->input->post('email') != $original_email) {
                $is_unique = '|is_unique[user_master.EmailId]';
            } else {
                $is_unique = '';
            }
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|regex_match[/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]*$/]' . $is_unique);

            if ($this->form_validation->run() == TRUE) {

                $slot = array(
                    'FName' => $_POST['first_name'],
                    'SName' => $_POST['last_name'],
                    'DOB' => $_POST['birthday'],
                    'EmailId' => $_POST['email'],
                    'Phone' => $_POST['phone'],
                    'Phone' => $_POST['phone'],
                );
                if ($this->input->post('password') != '') {
                    $password = md5($this->input->post('password'));
                    $slot['Password'] = $password;
                }
                if (isset($_POST['phoneType'])) {

                    $slot['is_cell'] = 1;
                } else {
                    $slot['is_cell'] = 0;
                }
                $this->auth_model->update_user_master_by_UserId($slot, $data_msg['model']['UserId']);

                $this->ajax_response['type'] = 'success';
                $this->ajax_response['message'] = 'Profile updated successfully.';
            } else {

                $this->ajax_response['type'] = 'warning';
                $error = [];

                foreach ($this->form_validation->error_array() as $key => $val) {
                    $error[$key] = $val;
                }
                $this->ajax_response['message'] = $error;
            }
        }

        $this->render_ajax_response();
    }

    public function add_new_image_modal() {
        if (IS_AJAX) {
            $data = [];
            $html = $this->load->view('site/add_new_image', $data, TRUE);
        }
        $this->ajax_response['html'] = $html;
        if ($html == "") {
            $this->ajax_response['type'] = 'warning';
        } else {
            $this->ajax_response['type'] = 'success';
        }

        $this->render_ajax_response();
    }

    public function add_new_image_submit() {
        if (IS_AJAX) {
            $data = [];
            $this->load->model('user_model');
            $data_msg['model'] = $this->user_model->get_user_by_id($this->auth->current_user_id());

            if (isset($_FILES['cropped_image'])) {
                $image_name = $this->all_function->rand_string('12') . ".png";

                $upload_path = UOLOAD_PATH . 'user_image/';
                if (move_uploaded_file($_FILES["cropped_image"]["tmp_name"], $upload_path . $image_name)) {

//  $full_path = base_url("assets/upload/user_image/$image_name");
                    $full_path = $upload_path . $image_name;

                    $layer = ImageWorkshop::initFromPath($full_path);

                    $preview = clone $layer;
                    $preview->resizeInPixel(491, 367, TRUE);
                    $preview->save($upload_path, "preview_" . $image_name, true, null, 100);
                    $thumb = clone $layer;
                    $thumb->resizeInPixel(300, 200, TRUE);
                    $thumb->save($upload_path, "thumb_" . $image_name, true, null, 100);
                    $small = clone $layer;
                    $small->resizeInPixel(93, 69, TRUE);
                    $small->save($upload_path, "small_" . $image_name, true, null, 100);
                    $image_data = array(
                        'ProfileImage' => $image_name,
                    );
                    $image_id = $this->auth_model->update_user_master_by_UserId($image_data, $data_msg['model']['UserId']);
                }
            }


            $data_msg = [];

            $image_path = "";
            if ($image_id != "") {

                $preview_image_path = base_url("assets/upload/user_image/preview_" . $image_name);
                $small_image_path = base_url("assets/upload/user_image/small_" . $image_name);
            }

            $this->ajax_response['preview_image_path'] = $preview_image_path;
            $this->ajax_response['small_image_path'] = $small_image_path;
            $this->ajax_response['default_image'] = theme_url() . "/img/default-service.jpg";

            $this->ajax_response['type'] = 'success';

            $this->ajax_response['message'] = 'Image uploaded successfully.';
        } else {
            $this->ajax_response['type'] = 'warning';

            $this->ajax_response['message'] = 'Image cannot be blank';
        }
        $this->render_ajax_response();
    }

    public function search_feature() {
        if (IS_AJAX) {
            $type = $_POST['type'];
            $type_id = $_POST['id'];
            $this->load->model('featured_user_model');
            $data = $this->featured_user_model->get_feature_user_all($type_id);
            $data_set = array();
            $data_array = array();
            $result_array = array();
            if (count($data) > 0) {
                foreach ($data as $k => $v) {
                    array_push($data_array, $v['user_master_id']);
                }
            }
            if (count($data_array) > 6) {
                $new_array = array();
                $new_array = array_rand($data_array, 6);
                foreach ($new_array as $k2 => $v2) {
                    array_push($result_array, $data_array[$v2]);
                }
            } else {
                $result_array = $data_array;
            }
            $data_set['data'] = $result_array;
            if (isset($_POST['type'])) {
                $this->ajax_response['type'] = 'success';
                $this->ajax_response['type'] = 'success';
                $html = $this->load->view('site/_feature_list_data', $data_set, TRUE);
                $this->ajax_response['html'] = $html;
            }
        }
        $this->render_ajax_response();
    }

    public function customer_review($business_slug = '', $book_id = '') {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
        }
        $this->load->model('booking_master_model');
        $this->load->model('user_model');
        $this->load->model('business_master_model');
        $business = $this->business_master_model->get_business_by_slug($business_slug);
        $book_has_review = $this->booking_master_model->check_review($business->id, $book_id);
        $data_msg = array();
        if (!$this->auth->is_login()) {
            redirect(site_url('login') . "?return_url=" . site_url('leave-review/' . $business_slug . '/' . $book_id));
            exit;
        } else {
            $user_id = $this->auth->get_user_session('UserId');
            if (count($book_has_review) > 0 && $book_has_review->review_status == '1' && $user_id == $book_has_review->user_id) {
                $data_msg['model'] = $this->user_model->get_user_by_id($this->auth->current_user_id());
                $data_msg['business_slug'] = $business_slug;
                $data_msg['book_id'] = $book_id;
                $this->template->set_meta_title('Leave Review')
                        ->set_meta_description('Leave Review')
                        ->view('site/leave_review', $data_msg);
            } else {
                $this->session->set_flashdata('success_msg', 'Invalid url!');
                redirect(site_url('customer-appointment-history'));
                exit;
            }
        }
    }

    public function customer_review_submit($business_slug, $book_id) {
        if (IS_AJAX) {
            $this->load->model('user_model');
            $this->load->model('review_master_model');
            $this->load->model('review_details_model');
            $this->load->model('booking_master_model');
            $this->load->model('booking_detail_model');
            $this->load->model('business_master_model');
            if ($this->auth->is_login()) {
                $this->form_validation->set_rules('type1', 'A review', 'trim|required');
                $this->form_validation->set_rules('type2', 'B review', 'trim|required');
                $this->form_validation->set_rules('type3', 'C review', 'trim|required');
                $this->form_validation->set_rules('type4', 'D review', 'trim|required');
                $this->form_validation->set_rules('type5', 'E review', 'trim|required');
                $this->form_validation->set_rules('title', 'Title', 'trim|required');
                $this->form_validation->set_rules('comment', 'comment', 'trim|required');
                if ($this->form_validation->run() == true) {

                    $business = $this->business_master_model->get_business_by_slug($business_slug);
                    $type1 = set_value('type1');
                    $type2 = set_value('type2');
                    $type3 = set_value('type3');
                    $type4 = set_value('type4');
                    $type5 = set_value('type5');
                    $title = set_value('title');
                    $comment = set_value('comment');
                    $review_user_type = $_POST['review_type'];
                    $average = ($type1 + $type2 + $type3 + $type4 + $type5) / 5;

                    $review_master_data = array(
                        'business_id' => $business ? $business->id : '',
                        'book_id' => $book_id,
                        'title' => $title,
                        'description' => $comment,
                        'average' => $average,
                        'user_type' => $review_user_type,
                        'status' => '1',
                        'added_date' => date('Y-m-d H:i:s')
                    );


                    $reviesw_id = $this->auth_model->insert_into_review_master($review_master_data);
                    $rating_array = array();
                    $rating_array[1] = $type1;
                    $rating_array[2] = $type2;
                    $rating_array[3] = $type3;
                    $rating_array[4] = $type4;
                    $rating_array[5] = $type5;

                    foreach ($rating_array as $key => $val) {
                        $review_det_data = array(
                            'review_master_id' => $reviesw_id,
                            'type_master_id' => $key,
                            'rating' => $val,
                        );
                        $this->auth_model->insert_into_review_details($review_det_data);
                    }
                    $book_row_update = array(
                        'review_status' => '2'
                    );
                    $this->booking_detail_model->update_booking_master_by_id($book_row_update, $book_id);
//=========Update business master===========
                    $business_review_avg = $business->review_average;
                    $business_review_count = $business->review_count;
                    $new_business_avg = ($business_review_avg + $average) / ($business_review_count + 1);
                    $business_update_data = array(
                        'review_average' => $new_business_avg,
                        'review_count' => $business_review_count + 1,
                    );
                    $this->business_master_model->update_business_master_by_id($business_update_data, $business->id);

//=========Update all Staff review for booking===========
                    $all_booking_staff = $this->booking_detail_model->get_allstaff_with_bookid($book_id);
                    if (count($all_booking_staff) > 0) {
                        foreach ($all_booking_staff as $key5 => $val5) {
                            $staff_user_master_row = $this->user_model->get_user_by_id($val5['staff_id']);
                            $staff_review_avg = $staff_user_master_row['review_average'];
                            $staff_review_count = $staff_user_master_row['review_count'];
                            $new_staff_review_avg = ($staff_review_avg + $average) / ($staff_review_count + 1);
                            $staff_update_data = array(
                                'review_average' => $new_staff_review_avg,
                                'review_count' => $staff_review_count + 1,
                            );
                            $this->user_model->update_user_master_by_UserId($staff_update_data, $val5['staff_id']);
                        }
                    }

//                    Events::trigger('new_user_registration_success', $user_master_data);


                    $this->ajax_response['type'] = 'success';

                    $this->ajax_response['message'] = "Thank you for your feedback.";
                    $this->ajax_response['url'] = site_url('customer-appointment-history');
                } else {
                    $this->ajax_response['type'] = 'warning';
                    $error = [];

                    foreach ($this->form_validation->error_array() as $key => $val) {
                        $error[$key] = $val;
                    }

                    $this->ajax_response['message'] = $error;
                }
            }
        }
        $this->render_ajax_response();
    }

//==============Inbox========================
    public function my_inbox() {
        $data = array();
        $this->load->model('inbox_master_model');
        $this->load->model('user_model');
        $this->load->model('booking_master_model');
        $this->load->model('inbox_thread_model');
        $data['model'] = $this->user_model->get_user_by_id($this->auth->current_user_id());
        $client_id = $this->auth->current_user_id();
        $data['all_data'] = '';
        $data['client_staff'] = $this->booking_master_model->get_all_client_staff($client_id);
        $data['get_provider_inbox_list'] = $this->inbox_thread_model->get_client_thread($client_id);
        $this->template->set_meta_title('Customer inbox | fysioradar')->view('site/message_box', $data);
    }

    public function send_message() {
        $data = array();
        $this->load->model('inbox_master_model');
        $this->load->model('user_model');
        $this->load->model('booking_master_model');
        $this->load->model('inbox_thread_model');
        $provider_id = $this->auth->current_user_id();
        $html = '';
        if (IS_AJAX) {
            $data = array();
            $this->form_validation->set_rules('user_master_id', 'Select provider', 'trim|required|xss_clean');
            $this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');

            if ($this->form_validation->run() == true) {
                $send_user_det = $this->user_model->get_all_user_by_id($provider_id);
                $receive_user_det = $this->user_model->get_all_user_by_id($_POST['user_master_id']);
                $has_thread = $this->inbox_thread_model->find_thread($provider_id, $_POST['user_master_id']);
                if (count($has_thread) > 0) {
                    $thread_id = $has_thread->id;
                    $this->inbox_thread_model->update_inbox_thread_by_id(['updated_at' => date('Y-m-d H:i:s')], $thread_id);
                } else {
                    $thread_data = array(
                        'sender_id' => $provider_id,
                        'receiver_id' => $_POST['user_master_id'],
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $thread_id = $this->inbox_thread_model->insert_into_inbox_thread($thread_data);
                }
                $inbox_data = array(
                    'thread_id' => $thread_id,
                    'sender_id' => $provider_id,
                    'receiver_id' => $_POST['user_master_id'],
                    'message' => $_POST['message'],
                    'status' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                );
                $inbox_id = $this->inbox_master_model->insert_into_inbox_master($inbox_data);
                $provider_inbox_list = $this->inbox_master_model->get_message_list($provider_id, $_POST['user_master_id']);
                if (count($provider_inbox_list) == 1) {
                    $image_path = base_url("assets/upload/user_avatar/thumb_" . $receive_user_det->ProfileImage);
                    $path = theme_url() . '/images/avatar3_small.jpg';
                    $path = 'this.onerror=null;this.src="' . $path . '"';
                    $html = '<a href="javascript:;" onclick="load_msg(this,' . $receive_user_det->UserId . ')">
                <div class="row sideBar-body">
                                <div class="col-sm-3 col-xs-3 sideBar-avatar">
                                    <div class="avatar-icon">
                                        <img onerror=' . $path . ' src="' . $image_path . '" alt="">
                                    </div>
                                </div>
                                <div class="col-sm-9 col-xs-9 sideBar-main">
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-8 sideBar-name">
                                            <span class="name-meta">' . $receive_user_det->FName . " " . $receive_user_det->SName . '
                                            </span>
                                        </div>
                                        <div class="col-sm-4 col-xs-4 pull-right sideBar-time">

                                        </div>
                                    </div>
                                </div>
                            </div></a>';
                }
                $this->ajax_response['html'] = $html;
                $this->ajax_response['type'] = 'success';
//                 $email_data=array(
//                  'EmailId'=>  $receive_user_det->EmailId,
//                  'FName'=>  $receive_user_det->FName,
//                  'SName'=>  $receive_user_det->SName,
//                  'message'=>  $_POST['reply_comment'],
//                  'site_link'=>  site_url(),
//                );
//                 Events::trigger('new_message', $email_data);
            } else {

                $this->ajax_response['type'] = 'warning';
                $error = [];

                foreach ($this->form_validation->error_array() as $key => $val) {
                    $error[$key] = $val;
                }

                $this->ajax_response['message'] = $error;
            }
            $this->ajax_response['data'] = $data;
        }
        $this->render_ajax_response();
    }

    public function get_message() {
        if (IS_AJAX) {
            $this->load->model('inbox_master_model');
            $this->load->model('user_model');
            $this->load->model('booking_master_model');
            $sender_id = $this->auth->current_user_id();
            $html = '';
            $class = '';
            $receiver_id = $_POST['client_id'];
            $receive_user_det = $this->user_model->get_all_user_by_id($receiver_id);
            $data['provider_invox_list'] = $this->inbox_master_model->get_message_list($sender_id, $receiver_id);
            if (count($data['provider_invox_list']) > 0) {
                foreach ($data['provider_invox_list'] as $key => $val) {
                    $date = new DateTime($val['created_at']);

                    if ($val['sender_id'] == $sender_id) {
                        $class = 'sender';
                    } else {
                        $class = 'receiver';
                    }
                    $html .= '<div class="row message-body">
                            <div class="col-sm-12 message-main-' . $class . '">
                            <div class="' . $class . '">
                                    <div class="message-text">
                                       ' . $val['message'] . '
                                    </div>
                                    <span class="message-time pull-right">
                                         ' . $date->format('M d,  Y H:i a') . '
                                    </span>
                                </div></div></div>';
                }
            }
            $this->ajax_response['html'] = $html;
            $this->ajax_response['receiver_id'] = $receive_user_det->UserId;
            $this->ajax_response['receiver_name'] = $receive_user_det->FName . ' ' . $receive_user_det->SName;
            $this->ajax_response['type'] = 'success';
        }
        $this->render_ajax_response();
    }

    public function direct_send_message() {
        if (IS_AJAX) {
            $this->load->model('inbox_master_model');
            $this->load->model('user_model');
            $this->load->model('booking_master_model');
            $this->load->model('inbox_thread_model');
            $data = array();
            $provider_id = $this->auth->current_user_id();
            $client_id = $_POST['selected_client'];
            $this->form_validation->set_rules('reply_comment', 'Message', 'trim|required|xss_clean');
            if ($this->form_validation->run() == true) {
                $send_user_det = $this->user_model->get_all_user_by_id($provider_id);
                $receive_user_det = $this->user_model->get_all_user_by_id($client_id);
                $has_thread = $this->inbox_thread_model->find_thread($provider_id,$client_id);
                if (count($has_thread) > 0) {
                    $thread_id = $has_thread->id;
                    $this->inbox_thread_model->update_inbox_thread_by_id(['updated_at' => date('Y-m-d H:i:s')], $thread_id);
                }
                $inbox_data = array(
                    'thread_id' => $thread_id,
                    'sender_id' => $provider_id,
                    'receiver_id' => $client_id,
                    'message' => $_POST['reply_comment'],
                    'status' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                );
                $inbox_id = $this->inbox_master_model->insert_into_inbox_master($inbox_data);
                $date = new DateTime(date('Y-m-d H:i:s'));
                $html = '<div class="row message-body">
                            <div class="col-sm-12 message-main-sender">
                            <div class="sender">
                                    <div class="message-text">
                                       ' . $_POST['reply_comment'] . '
                                    </div>
                                    <span class="message-time pull-right">
                                         ' . $date->format('M d,  Y H:i a') . '
                                    </span>
                                </div></div></div>';
                $this->ajax_response['html'] = $html;
                $this->ajax_response['type'] = 'success';
//                $email_data=array(
//                  'EmailId'=>  $receive_user_det->EmailId,
//                  'FName'=>  $receive_user_det->FName,
//                  'SName'=>  $receive_user_det->SName,
//                  'message'=>  $_POST['reply_comment'],
//                  'site_link'=>  site_url(),
//                );
//                 Events::trigger('new_message', $email_data);
            } else {

                $this->ajax_response['type'] = 'warning';
                $error = [];

                foreach ($this->form_validation->error_array() as $key => $val) {
                    $error[$key] = $val;
                }

                $this->ajax_response['message'] = $error;
            }
            $this->ajax_response['data'] = $data;
        }
        $this->render_ajax_response();
    }

    public function delete_all_conversations() {
        if (IS_AJAX) {
            $this->load->model('inbox_master_model');
            $this->load->model('user_model');
            $this->load->model('booking_master_model');
            $this->load->model('inbox_thread_model');
            $sender_id = $this->auth->current_user_id();
            $html = '';
            $class = '';
            $receiver_id = $_POST['client_id'];
            $receive_user_det = $this->user_model->get_all_user_by_id($receiver_id);
            $data['provider_invox_list'] = $this->inbox_master_model->get_message_list($sender_id, $receiver_id);
            $thread_id='';
            if (count($data['provider_invox_list']) > 0) {
                foreach ($data['provider_invox_list'] as $key => $val) {
                    $thread_id=$val['thread_id'];
                    $this->inbox_master_model->deleteRecord($val['inbox_id']);
                }
            }
             $this->inbox_thread_model->deleteRecord($thread_id);
            $this->ajax_response['type'] = 'success';
        }
        $this->render_ajax_response();
    }
    
}

?>