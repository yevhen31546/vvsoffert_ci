<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Auth extends CI_Controller {



    private $rotations = 0;



    function __construct() {

        parent::__construct();

        $this->load->library('session');

        $this->load->library('form_validation');

        $this->load->helper('site_helper');

        $this->load->model('User_model');

        $this->lang->load('auth_lang');



        $current_page = $this->router->fetch_method();

        if ($current_page != "logout")

            allow_not_logged_in();

    }



    // Show Messages

    public function index() {

        set_meta_title('Admin');

        set_page_title('Admin');



        if ($message = $this->session->flashdata('message')) {

            $data['content'] = $this->load->view('auth/message', array('message' => $message), TRUE);

            $this->load->view('layouts/auth', $data);

        } else {

            redirect('admin');

        }

    }



    // User Login

    public function login() {

        set_meta_title('Login');

        set_page_title('Login');



        $is_admin = $this->User_model->admin_avail();

        if (!$is_admin) {

            redirect('admin/auth/create');

        }



        $this->data['username'] = $this->input->post('username');

        if ($this->input->post('login')) {

            $this->form_validation->set_rules('username', 'Username', 'trim|required');

            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');



            if ($this->form_validation->run() == TRUE) {

                $search['username'] = $this->input->post('username');

                $user = $this->User_model->get_by_where($search, true);

                if ($user) {

                    $this->load->library('password');

                    $pwd = $this->input->post('password');



                   if ($this->password->validate_password($pwd, $user->password)) {

                        if ($user->active == 2) {

                            $confirm_code = md5(uniqid(rand()));

                            $update['activate_key'] = $confirm_code;

                            $this->User_model->update($user->id, $update);



                            $user = $this->User_model->get_by_id($user->id);



                            $session_message['type'] = 2;

                            $session_message['title'] = 'Login Blocked';

                            $session_message['content'] = 'You have not yet verified your email. We\'ve sent email to verify your account.';

                            $this->session->set_flashdata('message', $session_message);



                            $this->load->library('email');

                            $data['emailData'] = $user;



                            $address = $user->email;

                            $subject = "Welcome to " . $this->config->item('site_name') . "!";

                            $message = $this->load->view('email/admin-email-activation', $data, TRUE);



                            $this->email->from('developer@wsfreelanzer.com', $this->config->item('site_name'));

                            $this->email->to($address);

                            $this->email->subject($subject);

                            $this->email->message($message);

                            $this->email->send();



                            redirect('admin');

                        } else {

                            $userdata['id'] = $user->id;

                            $userdata['sitename'] = $user->sitename;

                            $userdata['copyrights'] = $user->copyrights;

                            $userdata['username'] = $user->username;

                            $this->session->set_userdata('user', $userdata);

                            redirect('admin/dashboard');

                        }

                    } else {



                        $session_message['type'] = 2;

                        $session_message['title'] = 'Login Failed';

                        $session_message['content'] = 'Invalid Password.';

                        $this->session->set_flashdata('message', $session_message);



                        redirect(site_url('admin'));

                    }

                } else {

                    $session_message['type'] = 2;

                    $session_message['title'] = 'Login Failed';

                    $session_message['content'] = 'Username is not registered with us.';

                    $this->session->set_flashdata('message', $session_message);



                    redirect(site_url('admin'));

                }

            }

        }



        $data['content'] = $this->load->view('auth/login', $this->data, TRUE);

        $this->load->view('layouts/auth', $data);

    }



    // User Logout   

    public function logout() {

        $this->session->sess_destroy();

        redirect('admin');

    }



    // Create admin user

    public function create() {



        set_meta_title('Create Your Account');

        set_page_title('Create Your Account');



        $is_admin = $this->User_model->admin_avail();

        if ($is_admin) {

            redirect('admin');

        }



        $data = array(

            'button' => 'Create',

            'action' => site_url('admin/auth/create_action'),

            'username' => set_value('username'),

            'password' => set_value('password'),

            'sitename' => set_value('sitename'),

            'email' => set_value('email')

        );



        $data['content'] = $this->load->view('auth/register', $data, TRUE);

        $this->load->view('layouts/auth', $data);

    }



    // Post Action for admin user

    public function create_action() {

        $this->_rules();



        if ($this->form_validation->run() == FALSE) {

            $this->create();

        } else {



            $confirm_code = md5(uniqid(rand()));

            $data = array(

                'username' => $this->input->post('username', TRUE),

                'password' => $this->_encrypt_password($this->input->post('password', TRUE)),

                'sitename' => $this->input->post('sitename', TRUE),

                'email' => $this->input->post('email', TRUE),

                'roles' => 1,

                'activate_key' => $confirm_code,

                'created' => date('Y-m-d H:i:s')

            );



            $this->User_model->insert($data);

            $insert_id = $this->db->insert_id();



            $this->load->library('email');

            $this->email->from('developer@wsfreelanzer.com', $this->config->item('site_name'));



            $row = $this->User_model->get_by_id($insert_id);

            $data['emailData'] = $row;



            $address = $row->email;

            $subject = "Welcome to " . $this->config->item('site_name') . "!";

            $message = $this->load->view('email/admin-email-activation', $data, TRUE);



            $this->email->to($address);

            $this->email->subject($subject);

            $this->email->message($message);

            $this->email->send();



            $session_message['title'] = $this->lang->line('reg_title');

            $session_message['content'] = $this->lang->line('reg_content');

            $this->session->set_flashdata('message', $session_message);



            redirect(site_url('admin'));

        }

    }



    // User Activation

    public function activation() {

        $is_admin = $this->User_model->admin_avail();

        if (!$is_admin) {

            redirect('admin/auth/create');

        }



        if (!$this->uri->segment(3))

            redirect('admin');



        $key = $this->uri->segment(3);

        $search['activate_key'] = $key;

        $user = $this->User_model->get_by_where($search, true);

        if ($user) {

            $update['activate_key'] = "NULL";

            $update['active'] = 1;



            $this->User_model->update($user->id, $update);



            $row = $user;

            $data['emailData'] = $row;



            $address = $row->email;

            $subject = "Your Account Activated";

            $message = $this->load->view('email/admin-email-activatated', $data, TRUE);



            $this->load->library('email');

            $this->email->from('developer@wsfreelanzer.com', $this->config->item('site_name'));

            $this->email->to($address);

            $this->email->subject($subject);

            $this->email->message($message);

            $this->email->send();



            $session_message['title'] = $this->lang->line('reg_title');

            $session_message['content'] = $this->lang->line('reg_content');

            $this->session->set_flashdata('message', $session_message);



            $session_message['title'] = $this->lang->line('acc_active_title');

            $session_message['content'] = $this->lang->line('acc_active_content');

            $this->session->set_flashdata('message', $session_message);



            redirect('admin');

        } else {

            $session_message['type'] = 2;

            $session_message['title'] = $this->lang->line('acc_expired_title');

            $session_message['content'] = $this->lang->line('acc_expired_content');

            $this->session->set_flashdata('message', $session_message);



            redirect('admin');

        }

    }



    // Forgot Password

    public function forgot_password() {

        $is_admin = $this->User_model->admin_avail();

        if (!$is_admin) {

            redirect('admin/auth/create');

        }



        set_meta_title('Forgot Password');

        set_page_title('Forgot Password');



        if ($this->input->post('reset')) {

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_avail[users.email]');

            $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');



            if ($this->form_validation->run() == TRUE) {

                $confirm_code = md5(uniqid(rand()));

                $update['new_password_key'] = $confirm_code;

                $update['new_password_requested'] = date('Y-m-d- H:i:s');



                $search['email'] = $this->input->post('email');

                $user = $this->User_model->get_by_where($search, true);

                $this->User_model->update($user->id, $update);



                $search['email'] = $this->input->post('email');

                $user = $this->User_model->get_by_where($search, true);



                $session_message['title'] = $this->lang->line('fp_title');

                $session_message['content'] = sprintf($this->lang->line('fp_content'), $user->email);

                $this->session->set_flashdata('message', $session_message);



                $data['emailData'] = $user;



                $address = $user->email;

                $subject = "Reset Your Password";

                $message = $this->load->view('email/admin-forgot-password-email', $data, TRUE);



                $this->load->library('email');

                $this->email->from('developer@wsfreelanzer.com', $this->config->item('site_name'));

                $this->email->to($address);

                $this->email->cc('wsfreelanzer@gmail.com');

                $this->email->subject($subject);

                $this->email->message($message);

                $this->email->send();

                redirect('admin');

            }

        }



        $data['email'] = $this->input->post('email');

        $data['content'] = $this->load->view('auth/forgot-password', $data, TRUE);

        $this->load->view('layouts/auth', $data);

    }



    // Set New Password

    public function reset_password() {

        $is_admin = $this->User_model->admin_avail();

        if (!$is_admin) {

            redirect('admin/auth/create');

        }



        if (!$this->uri->segment(3))

            redirect('admin');



        $key = $this->uri->segment(3);

        $search['new_password_key'] = $key;

        $user = $this->User_model->get_by_where($search, true);

        if ($user) {

            set_meta_title('Reset Your Password');

            set_page_title('Reset Your Password');



            if ($this->input->post('reset')) {

                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[15]|callback__valid_password');

                $this->form_validation->set_rules('cpassword', 'Confirm New Password', 'trim|required|matches[password]');

                $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

                $this->form_validation->set_message('matches', '%s is not match with %s.');

                if ($this->form_validation->run() == TRUE) {

                    $update['new_password_key'] = "NULL";

                    $update['new_password_requested'] = "NULL";

                    $update['active'] = 1;

                    $update['password'] = $this->_encrypt_password($this->input->post('password', TRUE));

                    $this->User_model->update($user->id, $update);



                    $session_message['title'] = $this->lang->line('rp_title');

                    $session_message['content'] = sprintf($this->lang->line('rp_content'), $user->email);

                    $this->session->set_flashdata('message', $session_message);



                    $data['emailData'] = $user;



                    $address = $user->email;

                    $subject = "Password Changed";

                    $message = $this->load->view('email/admin-password-changed', $data, TRUE);



                    $this->load->library('email');

                    $this->email->from('developer@wsfreelanzer.com', $this->config->item('site_name'));

                    $this->email->to($address);

                    $this->email->cc('wsfreelanzer@gmail.com');

                    $this->email->subject($subject);

                    $this->email->message($message);

                    $this->email->send();

                    redirect('admin');

                }

            }



            $data['password'] = $this->input->post('password');

            $data['content'] = $this->load->view('auth/reset-password', $data, TRUE);

            $this->load->view('layouts/auth', $data);

        } else {

            $session_message['type'] = 2;

            $session_message['title'] = $this->lang->line('acc_expired_title');

            $session_message['content'] = $this->lang->line('acc_expired_content');

            $this->session->set_flashdata('message', $session_message);



            redirect('admin');

        }

    }



    /* --- */



    // Create User Validation Rules

    public function _rules() {

        $this->form_validation->set_rules('sitename', 'First Name', 'trim|required|min_length[2]|max_length[30]|alpha_numeric_spaces');

        $this->form_validation->set_rules('copyrights', 'Last Name', 'trim|required|min_length[2]|max_length[30]|alpha_numeric_spaces');

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[15]|alpha_dash|is_unique[users.username]');

        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[8]|max_length[11]|callback__valid_phoneno');

        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[15]|callback__valid_password');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');



        $this->form_validation->set_message('is_unique', '%s is already registered.');

    }



    // Encrypt user password

    public function _encrypt_password($password) {

        $this->load->library('Password');

        $hash = $this->password->create_hash($password);

        return $hash;

    }



    /*

     * Custom Validations 

     */



    // Valid password

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

    public function password(){

        echo $this->_encrypt_password(123456);

    }



}



/* End of file User.php */

/* Location: ./application/controllers/User.php */