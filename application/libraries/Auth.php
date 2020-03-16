<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Auth {

    const INACTIVE = '0';
    const ACTIVE = '1';
    const DELETE = '3';
    const YES = '4';
    const NO = '5';

    private $_error_message;
    private $_message;
    private $_user_area_type; //it is depend from which my_controller use it it may be admin/provider/front
    private $_type;
    private $_module_permission = array();
    private $_all_modules = array();

    function __construct($config = array()) {
        //'Customer'=> 3 | 'Admin'=>1 | 'Provider' => 2 
        $temp = array('1' => 'Admin', '2' => 'Provider', '3' => 'Customer');
        $this->_type = isset($config['user_type']) ? $config['user_type'] : '';
        $this->_user_area_type = isset($config['user_type']) ? $temp[$config['user_type']] : '';
        $this->load->model('auth_model');
        if ($config['user_type'] == 3) {
            //   $this->_set_guest_id();
        }
        $this->load->vars(array('dfdf' => 'ffffff'));
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->auth_model, $method)) {
            throw new Exception('Undefined method auth::' . $method . '() called');
        }

        return call_user_func_array(array($this->auth_model, $method), $arguments);
    }

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @access	public
     * @param	$var
     * @return	mixed
     */
    public function __get($var) {
        return get_instance()->$var;
    }

    public function login($identity, $password, $remember = FALSE) {
        $encript_password = md5($password);
        switch ($this->_user_area_type) {
            case 'Customer' :
        }
        $user = $this->auth_model->get_user_by_email($identity);
//                _lastsql();exit;
//                print_r($user);exit;
        if (empty($user) || ($encript_password != $user->Password)) {
            $this->set_error("Oops! You've entered an invalid email or password.");
            return FALSE;
        } else if (!in_array($user->UserTypeId, [2, 3])) {
            $this->set_error("Oops! You've entered an invalid email or password.");
            return FALSE;
        } else {
            if ($user->Status == self::INACTIVE) {
                $this->set_error("Hmmm. Looks like that user is inactive. Please try again or reach out to us.");
                return FALSE;
            } elseif ($user->Status == self::DELETE) {
                $this->set_error("Oh dear. That account has been deleted.");
                return FALSE;
            }
//                        elseif ($user->UserTypeId != $this->_type) {
//                                $this->set_error("Oops! You've entered an invalid email or password..");
//                                return FALSE;
//                        }
            //set session
            $this->set_message("Success! You're in!");

            //create user saession
            $this->_create_user_session($user);

            //insert user track data
            $track_data = array(
                'LoginId' => pk(),
                'UserId' => $user->UserId,
                'LoginTime' => $this->all_function->add_sydney_date_time_format(date('Y-m-d H:i:s')),
                'UserAgent' => $this->agent->browser() . " | " . $this->agent->platform(),
                'IpAddress' => getenv('REMOTE_ADDR')
            );
            $this->auth_model->insert_into_user_login_track($track_data);
            return TRUE;
        }
    }

    public function login_by_admin($identity, $encript_password, $remember = FALSE) {
          $encript_password = md5($encript_password);
        $type = "Admin";
        $this->_user_area_type = $type;



//                switch ($this->_user_area_type) {
//                        case 'Customer' :
//                }
        $user = $this->auth_model->get_user_by_email($identity);
//                _lastsql();exit;

//print_r($user);exit;
        if (empty($user) || ($encript_password != $user->Password)) {

            $this->set_error("Oops! You've entered an invalid email or password.");
            return FALSE;
        } else if (!in_array($user->UserTypeId, [1])) {
            $this->set_error("Oops! You've entered an invalid email or password.");
            return FALSE;
        } else {

            if ($user->Status == self::INACTIVE) {

                $this->set_error("Hmmm. Looks like that user is inactive. Please try again or reach out to us.");
                return FALSE;
            } elseif ($user->Status == self::DELETE) {

                $this->set_error("Oh dear. That account has been deleted.");
                return FALSE;
            } elseif ($user->GroupStatus == self::INACTIVE) {

                $this->set_error(strtoupper($user->GroupName) . "'s login is suspended by administrator");
                return FALSE;
            } elseif ($this->_type == '1' && $user->UserTypeId == '5') {

                //break this special case
            }
            //set session
            $this->set_message("Success! You're in!");

            //create user saession
            $this->_create_user_session($user);

            //insert user track data
            $track_data = array(
                'LoginId' => pk(),
                'UserId' => $user->UserId,
                'LoginTime' => $this->all_function->add_sydney_date_time_format(date('Y-m-d H:i:s')),
                'UserAgent' => $this->agent->browser() . " | " . $this->agent->platform(),
                'IpAddress' => getenv('REMOTE_ADDR')
            );
            $this->auth_model->insert_into_user_login_track($track_data);
            return TRUE;
        }
    }

    public function blocked($identity) {
        switch ($this->_user_area_type) {
            case 'Customer' :
        }
        $user = $this->auth_model->get_user_by_email($identity);
        if (empty($user)) {
            $this->set_error("Oops! You've entered an invalid email or password.");
            return FALSE;
        } else {
            if ($user->LoginFncBlocked == '4') {
                $this->set_error("Sorry but we've blocked your email ID. It's not you, we did this for your security. Please try again in 24 hours or reach out to us.");
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    public function oauth_login($user, $provider) {
        if ($user->Status == self::INACTIVE) {
            $this->set_error("Hmmm. Looks like that user is inactive. Please try again or reach out to us.");
            return FALSE;
        } elseif ($user->Status == self::DELETE) {
            $this->set_error("This account is deleted.");
            return FALSE;
        } elseif ($user->GroupStatus == self::INACTIVE) {
            $this->set_error(strtoupper($user->GroupName) . "'s login is suspended by administrator");
            return FALSE;
        } elseif ($this->_type == '1' && $user->UserTypeId == '5') {
            //break this special case
        } elseif ($user->UserTypeId != $this->_type) {
            $this->set_error("Oops! You've entered an invalid email or password..");
            return FALSE;
        }
        //set session
        $this->set_message('User login successfully by ' . $provider);

        //create user saession
        $this->_create_user_session($user);

        //insert user track data
        $track_data = array(
            'LoginId' => pk(),
            'UserId' => $user->UserId,
            'LoginTime' => $this->all_function->add_sydney_date_time_format(date('Y-m-d H:i:s')),
            'UserAgent' => $this->agent->browser() . " | " . $this->agent->platform(),
            'IpAddress' => getenv('REMOTE_ADDR')
        );
        $this->auth_model->insert_into_user_login_track($track_data);
        return TRUE;
    }

    public function login_after_signup($user, $provider) {
        //set session
        $this->set_message('User login successfully by ' . $provider);

        //create user saession
        if (!is_object($user)) {
            $user = (object) $user;
            //$user->GroupName = '2';
        }
        $this->_create_user_session($user);

        //insert user track data
        $track_data = array(
            'LoginId' => pk(),
            'UserId' => $user->UserId,
            'LoginTime' => $this->all_function->add_sydney_date_time_format(date('Y-m-d H:i:s')),
            'UserAgent' => $this->agent->browser() . " | " . $this->agent->platform(),
            'IpAddress' => getenv('REMOTE_ADDR')
        );
        $this->auth_model->insert_into_user_login_track($track_data);
        return TRUE;
    }

    public function reset_assign_session() {
        $user = $this->auth_model->get_user_by_userid($this->auth->get_user_session('UserId'));
        //if found user records
        if (!empty($user)) {
            $this->_create_user_session($user);
        }
    }

    private function _create_user_session($user) {


        $this->session->set_userdata("{$this->_user_area_type}AuthUserData", array(
            "UserId" => $user->UserId,
            "EmailId" => $user->EmailId,
            "UserTypeId" => $user->UserTypeId,
            "FName" => $user->FName,
            "SName" => $user->SName,
            "Sex" => $user->Sex,
            "ProfileImage" => $user->ProfileImage,
            "GroupName" => $user->GroupName,
                )
        );
    }

    public function _create_guest_session($user) {
        $this->_create_user_session($user);
    }

    public function get_user_session($property_name = NULL) {


        $user_session = $this->session->userdata("{$this->_user_area_type}AuthUserData");
        if (is_null($property_name)) {
            return $user_session; // return array
        } elseif (isset($user_session[$property_name])) {
            return $user_session[$property_name]; //string return
        }
        return ''; //return string
    }

    public function is_login() {
        return (bool) $this->get_user_session('UserId');
    }

    public function get_user_details($email = NULL) {
        if (is_null($email)) {
            $email = $this->get_user_session('EmailId');
        }
        return $this->auth_model->get_user_by_email($email);
    }

    public function logout() {
        //$this->session->unset_userdata("{$this->_user_area_type}AuthUserData");
        $this->session->sess_destroy();
    }

    function set_error($msg) {
        $this->_error_message = $msg;
    }

    function get_error() {
        return $this->_error_message;
    }

    function set_message($msg) {
        $this->_message = $msg;
    }

    function get_message() {
        return $this->_message;
    }

    public function update_user($data, $user_id = NULL) {
        if (is_null($user_id)) {
            $user_id = $this->get_user_session('UserId');
        }
        $this->auth_model->update_user_master_by_UserId($data, $user_id);
    }

    private function _set_guest_id() {
        $browser_cookies = $this->input->cookie('__guest_id');
        if ($browser_cookies == '') {
            $this->_guest_id = $this->all_function->rand_string(16);
            $cookie = array(
                'name' => '__guest_id',
                'value' => $this->encrypt->encode($this->_guest_id),
                'expire' => '157680000', // cookie set for 5 years
                'domain' => '',
                'path' => '/',
                'prefix' => '',
                'secure' => FALSE
            );
            $this->input->set_cookie($cookie);
        } else {
            $this->_guest_id = $this->encrypt->decode($browser_cookies);
        }
    }

    public function guest_id() {
        return $this->_guest_id;
    }

    public function current_user_id() {
        return $this->get_user_session('UserId');
    }

    public function reset_assign_guestid($__guest_id) {
        $this->_guest_id = $__guest_id;
        $cookie = array(
            'name' => '__guest_id',
            'value' => $this->encrypt->encode($this->_guest_id),
            'expire' => '157680000', // cookie set for 5 years
            'domain' => '',
            'path' => '/',
            'prefix' => '',
            'secure' => FALSE
        );
        $this->input->set_cookie($cookie);
    }

    public function get_visitor_lat_lang() {
        return $this->load->get_var('__visitor_lat_lang');
    }

    public function set_user_location($zip) {
        $zip = $this->db->select('Latitude,Longitude')
                        ->from(TBL_PINCODE_MASTER)
                        ->where('PCode', $zip)->get()->row();
        if (empty($zip)) {
            $zip = new stdClass();
            $zip->Latitude = '';
            $zip->Longitude = '';
        }
        $this->load->vars(array('__visitor_lat_lang' => $zip));
    }

    public function is_guest($email) {
        if ($this->db->where('UserTypeId', '4')->where('EmailId', $email)->count_all_results(TBL_USER_MASTER)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function set_user_module_permission_data() {
        $modules = $this->auth_model->fetch_module_master();
        foreach ($modules as $module) {
            $this->_all_modules[] = $module->AreaCode;
        }
        $access_area_data = $this->auth_model->get_ModulePermission_from_user_master(array('UserId' => $this->current_user_id()));
        if ($access_area_data != '') {
            $this->_module_permission = @unserialize($access_area_data);
        } else {
            $this->_module_permission = array();
        }
    }

    public function get_user_module_permission_data() {
        return $this->_module_permission;
    }

    public function get_all_module() {
        return $this->_all_modules;
    }

}

?>