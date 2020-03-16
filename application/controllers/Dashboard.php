<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->model('Login_model');
        $this->load->model('Estore_model');
        $this->load->helper('custom_helper');

        if (!$this->session->userdata("user_id") || $this->session->userdata("role_id") == '1') {
            redirect('logga-out');
        }
    }

    public function test_mail() {
        $template = getListdata(array("template_id" => '17'), 'email_template');
        $email = 'sdsd@sds.com';
        $subject = $template[0]->subject;
        $html = $template[0]->message;
        $html = str_replace("{{Link}}", ' <a target="_blank" href="' . $this->config->item('base_url') . '">' . $this->config->item('base_url') . '</a><br/><br/>', $html);
        echo "<pre>";
        print_r($html);
        exit;
    }

    public function index() {

        $this->data['title'] = 'Dashboard';
        $this->data['content'] = 'dashboard';
        $this->data['headerdata'] = getuserdata();

        //pr($this->data['promocode']);
//        render_page('template', $this->data);
        $this->data['content'] = $this->load->view('user/dashboard', '', true);
//		$this->load->view('layout',$this->data);
        $this->load->view('layout_sidebar', $this->data);
    }

    public function getLocations() {

        $gymlocation = getListdata(array("user_id" => $this->session->userdata("user_id")), 'gym_master');
        $latlong[] = $gymlocation[0]->lattitude . ',' . $gymlocation[0]->longitude;
        //pr($gymlocation);
        $location = getListdata(array("user_id" => $this->session->userdata("user_id")), 'location_master');
        $ary = array();
        foreach ($location as $location1) {
            $i = 0;
            $ary[][$i] = $location1->lattitude . ',' . $location1->longitude;
            $i++;
        }
        array_push($ary, $latlong);
        echo str_replace('"', "", json_encode($ary, JSON_HEX_APOS));
    }

    public function saveLocationdata() {
        $cnt = getListdata(array("user_id" => $this->session->userdata("user_id")), 'location_master');

        if (count($cnt) >= 1) {
            echo "5";
        } else {
            $city = trim($this->input->post('city'));
            $state = trim($this->input->post('state'));
            $country = trim($this->input->post('country'));
            $address = trim($this->input->post('address'));
            $zipcode = trim($this->input->post('zipcode'));
            $hdn_location_type = trim($this->input->post('hdn_location_type'));
            $lattitude = trim($this->input->post('cityLat'));
            $longitude = trim($this->input->post('cityLng'));
            $hdn_location_id = trim($this->input->post('hdn_location_id'));

            $this->form_validation->set_rules("country", "Country", "required");
            $this->form_validation->set_rules("address", "Address", "required");
            $this->form_validation->set_rules("zipcode", "Zipcode ", "required");

            if ($this->form_validation->run() == false) {
                $this->data['title'] = 'Dashboard';
                $this->data['content'] = 'dashboard';
                $this->data['headerdata'] = getuserdata();
                $this->data['gymdata'] = getGymdata();
                $this->data['qrcodelist'] = getListdata(array("user_id" => $this->session->userdata("user_id")), 'qr_code_master', 'qr_code_id', 'ASC');
                //echo $this->db->last_query();exit;
                $this->data['trainer_list_data'] = getListdata(array("user_id" => $this->session->userdata("user_id")), 'trainer_master', 'name', 'ASC');
                $this->data['services'] = getListdata(array(), 'gym_service', 'name', 'ASC');
                $this->data['classtype'] = getListdata(array('status' => '1'), 'class_type_master', 'name', 'ASC');
                $this->data['promocode'] = getListdata(array('estatus' => '1'), 'promotion_master');

                //pr($this->data['promocode']);

                $default_location = getListdata(array("user_id" => $this->session->userdata("user_id"), "default_location" => "1"), 'location_master');

                if (!empty($default_location)) {
                    $this->data['default_latitude'] = $default_location[0]->lattitude;
                    $this->data['default_longitude'] = $default_location[0]->longitude;
                } elseif ($this->data['gymdata'][0]->lattitude != "" && $this->data['gymdata'][0]->longitude != "") {
                    $this->data['default_latitude'] = $this->data['gymdata'][0]->lattitude;
                    $this->data['default_longitude'] = $this->data['gymdata'][0]->longitude;
                } else {
                    $this->data['default_latitude'] = '36.778259';
                    $this->data['default_longitude'] = '-119.417931';
                }
                $this->data['rating'] = getClassRating($this->data['gymdata'][0]->gym_id);
                render_page('template', $this->data);
            } else {
                $validate = $this->Dashboard_model->validate($address);
                if ($validate == 1) {
                    echo "0";
                } else {
                    if ($zipcode == "") {
                        $zipcode = getZipcode($address);
                        $zipcode = $zipcode ? $zipcode : '0';
                    }

                    $gymLocationArray = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'city' => $city,
                        'state' => $state,
                        'country' => $country,
                        'address' => $address,
                        'lattitude' => $lattitude,
                        'longitude' => $longitude,
                        'zipcode' => $zipcode
                            //'default_location' => $default_location
                    );

                    if ($hdn_location_type == 'Add') {
                        $query = savedata('location_master', $gymLocationArray);
                    }
                    if ($hdn_location_type == 'Edit' && $hdn_location_id != "") {
                        $query = updatedata("location_master", $gymLocationArray, array('location_id' => $hdn_location_id));
                    }
                    echo "1";
                }
            }
        }
    }

    public function saveTrainerData() {

        $tname = trim($this->input->post('tname'));
        $temail = trim($this->input->post('temail'));
        $tcontact = trim($this->input->post('tcontact'));
        $hdn_trainer_type = trim($this->input->post('hdn_trainer_type'));
        $hdn_trainer_id = trim($this->input->post('hdn_trainer_id'));

        $this->form_validation->set_rules("tname", "Name", "required");
        $this->form_validation->set_rules("temail", "Email", "required");
        $this->form_validation->set_rules("tcontact", "Contact", "required");

        if ($this->form_validation->run() == false) {
            $this->data['title'] = 'Dashboard';
            $this->data['content'] = 'dashboard';
            $this->data['headerdata'] = getuserdata();
            $this->data['gymdata'] = getGymdata();
            $this->data['qrcodelist'] = getListdata(array("user_id" => $this->session->userdata("user_id")), 'qr_code_master', 'qr_code_id', 'ASC');
            //echo $this->db->last_query();exit;
            $this->data['trainer_list_data'] = getListdata(array("user_id" => $this->session->userdata("user_id")), 'trainer_master', 'name', 'ASC');
            $this->data['services'] = getListdata(array(), 'gym_service', 'name', 'ASC');
            $this->data['classtype'] = getListdata(array('status' => '1'), 'class_type_master', 'name', 'ASC');
            $this->data['promocode'] = getListdata(array('estatus' => '1'), 'promotion_master');

            //pr($this->data['promocode']);

            $default_location = getListdata(array("user_id" => $this->session->userdata("user_id"), "default_location" => "1"), 'location_master');

            if (!empty($default_location)) {
                $this->data['default_latitude'] = $default_location[0]->lattitude;
                $this->data['default_longitude'] = $default_location[0]->longitude;
            } elseif ($this->data['gymdata'][0]->lattitude != "" && $this->data['gymdata'][0]->longitude != "") {
                $this->data['default_latitude'] = $this->data['gymdata'][0]->lattitude;
                $this->data['default_longitude'] = $this->data['gymdata'][0]->longitude;
            } else {
                $this->data['default_latitude'] = '36.778259';
                $this->data['default_longitude'] = '-119.417931';
            }
            $this->data['rating'] = getClassRating($this->data['gymdata'][0]->gym_id);
            render_page('template', $this->data);
        } else {
            $TrainerArray = array(
                'user_id' => $this->session->userdata('user_id'),
                'name' => $tname,
                'email' => $temail,
                'contact' => $tcontact
            );

            $validate = getListdata(array("email" => $temail), 'trainer_master');

            if ($hdn_trainer_type == 'Add') {

                if (count($validate) > 0) {
                    echo "0";
                } else {
                    $query = savedata('trainer_master', $TrainerArray);
                    echo "1";
                }
            }
            if ($hdn_trainer_type == 'Edit' && $hdn_trainer_id != "") {
                $query = updatedata("trainer_master", $TrainerArray, array('trainer_id' => $hdn_trainer_id));
                echo "1";
            }
        }
    }

    public function saveClassData() {
        if ($_POST['single_or_weekly_class'] == 0) {
            $class_name = trim($this->input->post('class_name'));
            $trainer_id = trim($this->input->post('trainer_id'));
            $multidates = trim($this->input->post('multidates'));
            $timepicker1 = trim($this->input->post('timepicker1'));
            $timepicker2 = trim($this->input->post('timepicker2'));
            $description = trim($this->input->post('description'));
            $user_limit = trim($this->input->post('user_limit'));
            $servicetype = trim($this->input->post('servicetype'));
            $hdn_class_type = trim($this->input->post('hdn_class_type'));
            $hdn_class_id = trim($this->input->post('hdn_class_id'));
            $hdn_gym_user_id = trim($this->input->post('hdn_gym_user_id'));
            if ($hdn_class_type == 'Edit') {
                $dates = $this->input->post('multidates');
                if ($dates == '') {
                    $dates = $this->input->post('singledates');
                }
                $date = date("Y-m-d", strtotime($dates));

                if ($hdn_class_type == 'Edit' && $hdn_class_id != "") {
                    $checkdata = getListdata(array("status!=" => "canceled", "class_date" => $date, "timer1" => $timepicker1, "timer2" => $timepicker2, "user_id" => $hdn_gym_user_id, "trainer_id" => $trainer_id, "class_id!=" => $hdn_class_id), 'class_master');

                    if (empty($checkdata)) {
                        $ClassArray = array(
                            'user_id' => $this->session->userdata('user_id'),
                            'name' => $class_name,
                            'trainer_id' => $trainer_id,
                            'class_date' => $date,
                            'timer1' => $timepicker1,
                            'timer2' => $timepicker2,
                            'description' => $description,
                            'user_limit' => $user_limit,
                            'service_id' => $servicetype,
                            'status' => 'created'
                        );
                        $query = updatedata("class_master", $ClassArray, array('class_id' => $hdn_class_id));
                    }
                }
            } else {
                $dates = explode(",", $this->input->post('multidates'));
                if ($this->input->post('multidates') == '') {
                    $dates = explode(",", $this->input->post('singledates'));
                }
                if (!empty($dates)) {
                    foreach ($dates as $date) {
                        $date = date("Y-m-d", strtotime($date));
                        $checkdata = getListdata(array("status!=" => "canceled", "class_date" => $date, "timer1" => $timepicker1, "timer2" => $timepicker2, "user_id" => $hdn_gym_user_id, "trainer_id" => $trainer_id), 'class_master');

                        if (empty($checkdata)) {
                            $ClassArray = array(
                                'user_id' => $this->session->userdata('user_id'),
                                'name' => $class_name,
                                'trainer_id' => $trainer_id,
                                'class_date' => $date,
                                'timer1' => $timepicker1,
                                'timer2' => $timepicker2,
                                'description' => $description,
                                'user_limit' => $user_limit,
                                'service_id' => $servicetype,
                                'status' => 'created'
                            );
                            $query = savedata('class_master', $ClassArray);
                        }
                    }
                }
            }
        } else {
            $class_or_openfloor = trim($this->input->post('class_or_openfloor'));
            $appointment = trim($this->input->post('appointment'));
            $week_days = trim($this->input->post('week_days'));

            $class_name = trim($this->input->post('class_name'));
            $trainer_id = trim($this->input->post('trainer_id'));
            $timepicker1 = trim($this->input->post('timepicker1'));
            $timepicker2 = trim($this->input->post('timepicker2'));
            $description = trim($this->input->post('description'));
            $user_limit = trim($this->input->post('user_limit'));
            $servicetype = trim($this->input->post('servicetype'));
            $hdn_class_type = trim($this->input->post('hdn_class_type'));
            $hdn_class_id = trim($this->input->post('hdn_class_id'));
            $hdn_gym_user_id = trim($this->input->post('hdn_gym_user_id'));

            if ($hdn_class_type == 'Edit') {

                if ($hdn_class_type == 'Edit' && $hdn_class_id != "") {
                    $weeks = explode(',', $week_days);
                    foreach ($weeks as $key => $value) {
                        if ($key == 0) {
                            $ClassArray = array(
                                'user_id' => $this->session->userdata('user_id'),
                                'name' => $class_name,
                                'trainer_id' => $trainer_id,
                                'weekly' => 1,
                                'week_days' => $value,
                                'open_floor' => $class_or_openfloor,
                                'appointment' => $appointment,
                                'timer1' => $timepicker1,
                                'timer2' => $timepicker2,
                                'description' => $description,
                                'user_limit' => $user_limit,
                                'service_id' => $servicetype,
                                'status' => 'created'
                            );
                            $query = updatedata("class_master", $ClassArray, array('class_id' => $hdn_class_id));
                        } else {
                            $ClassArray = array(
                                'user_id' => $this->session->userdata('user_id'),
                                'name' => $class_name,
                                'trainer_id' => $trainer_id,
                                'weekly' => 1,
                                'week_days' => $value,
                                'open_floor' => $class_or_openfloor,
                                'appointment' => $appointment,
                                'timer1' => $timepicker1,
                                'timer2' => $timepicker2,
                                'description' => $description,
                                'user_limit' => $user_limit,
                                'service_id' => $servicetype,
                                'status' => 'created'
                            );
                            $query = savedata('class_master', $ClassArray);
                        }
                    }
                }
            } else {
                $weeks = explode(',', $week_days);
                foreach ($weeks as $key => $value) {
                    $ClassArray = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'name' => $class_name,
                        'trainer_id' => $trainer_id,
                        'weekly' => 1,
                        'week_days' => $value,
                        'open_floor' => $class_or_openfloor,
                        'appointment' => $appointment,
                        'timer1' => $timepicker1,
                        'timer2' => $timepicker2,
                        'description' => $description,
                        'user_limit' => $user_limit,
                        'service_id' => $servicetype,
                        'status' => 'created'
                    );
                    $query = savedata('class_master', $ClassArray);
                }
            }
        }
    }

    public function getEditLocationData() {
        $location_id = trim($this->input->post('location_id'));
        $locationdata = getListdata(array("location_id" => $location_id), 'location_master');
        $city = $locationdata[0]->city;
        $state = $locationdata[0]->state;
        $country = $locationdata[0]->country;
        $address = $locationdata[0]->address;
        $zipcode = $locationdata[0]->zipcode;
        echo $city . "#" . $state . "#" . $country . "#" . $address . "#" . $zipcode;
    }

    public function getEditTrainerData() {
        $trainer_id = trim($this->input->post('trainer_id'));
        $trainerdata = getListdata(array("trainer_id" => $trainer_id), 'trainer_master');
        $tname = $trainerdata[0]->name;
        $temail = $trainerdata[0]->email;
        $tcontact = $trainerdata[0]->contact;
        echo $tname . "#" . $temail . "#" . $tcontact;
    }

    public function getEditClassData() {
        $data_msg = [];
        $data_msg['class_id'] = $class_id = trim($this->input->post('class_id'));
        $classdata = getListdata(array("class_id" => $class_id), 'class_master');
        $data_msg['name'] = $name = $classdata[0]->name;
//        infoway
        $data_msg['weekly'] = $weekly = $classdata[0]->weekly;
        $data_msg['week_days'] = $week_days = $classdata[0]->week_days;
        $data_msg['open_floor'] = $open_floor = $classdata[0]->open_floor;
        $data_msg['appointment'] = $appointment = $classdata[0]->appointment;
//        infoway
        $data_msg['trainer_id'] = $trainer_id = $classdata[0]->trainer_id;
        $data_msg['class_date'] = $class_date = date("m/d/Y", strtotime($classdata[0]->class_date));
        $data_msg['timer1'] = $timer1 = $classdata[0]->timer1;
        $data_msg['timer2'] = $timer2 = $classdata[0]->timer2;
        $data_msg['description'] = $description = $classdata[0]->description;
        $data_msg['user_limit'] = $user_limit = $classdata[0]->user_limit;
        $data_msg['service_id'] = $service_id = $classdata[0]->service_id;
//        echo $name . "#" . $trainer_id . "#" . $class_date . "#" . $timer1 . "#" . $timer2 . "#" . $description . "#" . $user_limit . "#" . $service_id . "#" . $service_id . "#" . $service_id . "#" . $service_id;
//        echo "<pre>";
//        print_r($data_msg);
//        exit;
        echo json_encode($data_msg);
        exit;
    }

    public function getlocationListData() {
        $locationdata = getListdata(array("user_id" => $this->session->userdata('user_id')), 'location_master');
        $result_data = array();
        $allLocation = array();
        $response = array();
        $status1 = "";
        if (count($locationdata) > 0) {
            foreach ($locationdata as $location) {
                $status = $location->status;
                if ($status == '0') {
                    $status1 = '<i class="fa fa-lock"></i>';
                }
                if ($status == '1') {
                    $status1 = '<i class="fa fa-unlock"></i>';
                }

                //echo $status1;exit;

                $result_data['address'] = "--";
                $result_data['city'] = "--";
                $result_data['state'] = "--";
                if ($location->address != "") {
                    $result_data['address'] = $location->address;
                }
                if ($location->city != "") {
                    $result_data['city'] = $location->city;
                }
                if ($location->state != "") {
                    $result_data['state'] = $location->state;
                }
                $result_data['country'] = $location->country;
                $result_data['zipcode'] = $location->zipcode;

                if ($location->default_location != '1') {
                    $default = "<a href='javascript:;' onclick='setdefaultlocation(" . $location->location_id . ");'  title='Default Location'>Set as Default</a>";
                } else {
                    $default = "Default";
                }
                #$result_data['default_location'] = $default;
                $result_data['action'] = "<a href='javascript:;' onclick='editlocation(" . $location->location_id . ");' class='btn btn-blue' title='Edit Location'><i class='fa fa-pencil'></i></a>
				<a id='status" . $location->location_id . "' href='javascript:;' onclick='changestatus(" . $location->location_id . ");' class='btn btn-default'>" . $status1 . "</a>";

                $allLocation[] = $result_data;
            }
        }

        $response['data'] = $allLocation;
        //echo "<pre>";print_r(json_encode($response)); echo "</pre>";exit;
        echo json_encode($response);
    }

    public function getTrainerListData() {

        $trainerdata = getListdata(array("user_id" => $this->session->userdata('user_id')), 'trainer_master');

        //pr($trainerdata);

        $result_data = array();
        $allTrainer = array();
        $response = array();
        $status1 = "";
        if (count($trainerdata) > 0) {
            foreach ($trainerdata as $trainer) {
                $status = $trainer->status;
                if ($status == '0') {
                    $status1 = '<i class="fa fa-lock"></i>';
                }
                if ($status == '1') {
                    $status1 = '<i class="fa fa-unlock"></i>';
                }

                $result_data['tname'] = $trainer->name;
                $result_data['temail'] = $trainer->email;
                $result_data['tcontact'] = $trainer->contact;
                $result_data['taction'] = "<a href='javascript:;' onclick='edittrainer(" . $trainer->trainer_id . ");' class='btn btn-blue' title='Edit Trainer'><i class='fa fa-pencil'></i></a>
<a id='trainerstatus" . $trainer->trainer_id . "' href='javascript:;' onclick='changeTrainerStatus(" . $trainer->trainer_id . ");' class='btn btn-default'>" . $status1 . "</a>";
//pr($result_data);
                $allTrainer[] = $result_data;
            }
        }

        $response['data'] = $allTrainer;
        //echo "<pre>";print_r(json_encode($response)); echo "</pre>";exit;
        echo json_encode($response);
    }

    public function getClassListData() {
        $classdt = date("Y-m-d");
        $classdata = getListdata(array("user_id" => $this->session->userdata('user_id'), "status!=" => 'canceled', "class_date >= " => $classdt), 'class_master', 'class_id', 'DESC');

        $result_data = array();
        $allClass = array();
        $response = array();
        $action = "";
        if (count($classdata) > 0) {
            foreach ($classdata as $class) {
                $class_id = $class->class_id;
                $cntres = $this->Dashboard_model->getViewBookingData($class_id);

                #$bookedusercnt = count($cntres);
                $bookedusercnt = 0;
                if (count($cntres) > 0) {
                    foreach ($cntres as $cr) {
                        if ($cr->status != 'canceled') {
                            $bookedusercnt = $bookedusercnt + 1;
                        }
                    }
                }

                $service = getListdata(array("service_id" => $class->service_id), 'gym_service');
                $result_data['service'] = $service[0]->name;
                $result_data['class_date'] = date("m/d/Y", strtotime($class->class_date));
                $result_data['time'] = $class->timer1 . ' to ' . $class->timer2;
                $result_data['trainer_name'] = "--";
                if ($class->trainer_id != "0") {
                    $trainerData = getListdata(array("trainer_id" => $class->trainer_id), 'trainer_master');
                    $result_data['trainer_name'] = $trainerData[0]->name;
                }
                $result_data['user_limit'] = $class->user_limit;
                $result_data['bookedusercnt'] = $bookedusercnt;
                $result_data['status'] = $class->status;
                //$action = '<a href="javascript:;" onclick="getBookingData('.$class->class_id.');" class="btn btn-grey" data-toggle="modal" data-target="#user_details" title="View Booked User detail"><i class="fa fa-eye"></i></a>
                //<a href="javascript:;" class="btn btn-info" id="copy" onclick="copyclass('.$class->class_id.');"><i class="fa fa-clone" title="Copy Class"></i></a>';

                $action = '<a href="' . $this->config->item('base_url') . 'userBookingdetail/' . $class->class_id . '" class="btn btn-grey"><i class="fa fa-eye"></i></a>
				<a href="javascript:;" class="btn btn-info" id="copy" onclick="copyclass(' . $class->class_id . ');"><i class="fa fa-clone" title="Copy Class"></i></a>';

                /////////////////////////////////////////////////
                // Change By Ramon 8-3-17,  spell correction "Cancle Class to Cancel Class" 
                /////////////////////////////////////////////////
                if ($result_data['status'] != 'canceled') {
                    $action .= ' <a href="javascript:;" class="btn btn-danger" onclick="cancleclass(' . $class->class_id . ');"><i class="fa fa-times-circle" title="Cancel Class"></i></a>';
                } else {
                    $action .= ' <a href="javascript:;" class="btn btn-danger"><i class="fa fa-times-circle" title="Cancle Class"></i></a>';
                }
                $action .= ' <a href="javascript:;" class="btn btn-blue" id="edit" onclick="editclass(' . $class->class_id . ');multicalender();"><i class="fa fa-pencil" title="Edit Class"></i></a>';

                $result_data['caction'] = $action;
                //pr($result_data);
                $allClass[] = $result_data;
            }
        }
        $response['data'] = $allClass;
        echo json_encode($response);
    }

    public function getSingleClassListData() {
        $classdt = date("Y-m-d");
        $classdata = getListdata(array("user_id" => $this->session->userdata('user_id'), "status!=" => 'canceled', "class_date >= " => $classdt, "weekly" => 0), 'class_master', 'class_id', 'DESC');

        $result_data = array();
        $allClass = array();
        $response = array();
        $action = "";
        if (count($classdata) > 0) {
            foreach ($classdata as $class) {
                $class_id = $class->class_id;
                $cntres = $this->Dashboard_model->getViewBookingData($class_id);

                #$bookedusercnt = count($cntres);
                $bookedusercnt = 0;
                if (count($cntres) > 0) {
                    foreach ($cntres as $cr) {
                        if ($cr->status != 'canceled') {
                            $bookedusercnt = $bookedusercnt + 1;
                        }
                    }
                }

                $service = getListdata(array("service_id" => $class->service_id), 'gym_service');
                $result_data['service'] = $service[0]->name;
                $result_data['class_date'] = date("m/d/Y", strtotime($class->class_date));
                $result_data['time'] = $class->timer1 . ' to ' . $class->timer2;
                $result_data['trainer_name'] = "--";
                if ($class->trainer_id != "0") {
                    $trainerData = getListdata(array("trainer_id" => $class->trainer_id), 'trainer_master');
                    $result_data['trainer_name'] = $trainerData[0]->name;
                }
                $result_data['user_limit'] = $class->user_limit;
                $result_data['bookedusercnt'] = $bookedusercnt;
                $result_data['status'] = $class->status;
                //$action = '<a href="javascript:;" onclick="getBookingData('.$class->class_id.');" class="btn btn-grey" data-toggle="modal" data-target="#user_details" title="View Booked User detail"><i class="fa fa-eye"></i></a>
                //<a href="javascript:;" class="btn btn-info" id="copy" onclick="copyclass('.$class->class_id.');"><i class="fa fa-clone" title="Copy Class"></i></a>';

                $action = '<a href="' . $this->config->item('base_url') . 'userBookingdetail/' . $class->class_id . '" class="btn btn-grey"><i class="fa fa-eye"></i></a>
				<a href="javascript:;" class="btn btn-info" id="copy" onclick="copyclass(' . $class->class_id . ');"><i class="fa fa-clone" title="Copy Class"></i></a>';

                /////////////////////////////////////////////////
                // Change By Ramon 8-3-17,  spell correction "Cancle Class to Cancel Class" 
                /////////////////////////////////////////////////
                if ($result_data['status'] != 'canceled') {
                    $action .= ' <a href="javascript:;" class="btn btn-danger" onclick="cancleclass(' . $class->class_id . ');"><i class="fa fa-times-circle" title="Cancel Class"></i></a>';
                } else {
                    $action .= ' <a href="javascript:;" class="btn btn-danger"><i class="fa fa-times-circle" title="Cancle Class"></i></a>';
                }
                $action .= ' <a href="javascript:;" class="btn btn-blue" id="edit" onclick="editclass(' . $class->class_id . ');multicalender();"><i class="fa fa-pencil" title="Edit Class"></i></a>';

                $result_data['caction'] = $action;
                //pr($result_data);
                $allClass[] = $result_data;
            }
        }
        $response['data'] = $allClass;
        echo json_encode($response);
    }

    public function getClassListArchiveData() {
        $classdt = date("Y-m-d");
        $classdata = getListdata(array("user_id" => $this->session->userdata('user_id'), "class_date < " => $classdt, "weekly" => 0), 'class_master', 'class_id', 'DESC');
        $result_data = array();
        $allClass = array();
        $response = array();
        $action = "";

        if (count($classdata) > 0) {
            foreach ($classdata as $class) {
                $class_id = $class->class_id;
                $cntres = $this->Dashboard_model->getViewBookingData($class_id);

                #$bookedusercnt = count($cntres);
                $bookedusercnt = 0;
                if (count($cntres) > 0) {
                    foreach ($cntres as $cr) {
                        if ($cr->status != 'canceled') {
                            $bookedusercnt = $bookedusercnt + 1;
                        }
                    }
                }

                $service = getListdata(array("service_id" => $class->service_id), 'gym_service');
                $result_data['service'] = $service[0]->name;
                $result_data['class_date'] = date("m/d/Y", strtotime($class->class_date));
                $result_data['time'] = $class->timer1 . ' to ' . $class->timer2;
                $result_data['trainer_name'] = "--";
                if ($class->trainer_id != "0") {
                    $trainerData = getListdata(array("trainer_id" => $class->trainer_id), 'trainer_master');
                    $result_data['trainer_name'] = $trainerData[0]->name;
                }
                $result_data['user_limit'] = $class->user_limit;
                $result_data['bookedusercnt'] = $bookedusercnt;
                $result_data['status'] = $class->status;

                $action = '<a href="' . $this->config->item('base_url') . 'userBookingdetail/' . $class->class_id . '" class="btn btn-grey"><i class="fa fa-eye"></i></a>
				<a href="javascript:;" class="btn btn-info" id="copy" onclick="copyclass(' . $class->class_id . ');"><i class="fa fa-clone" title="Copy Class"></i></a>';

                $result_data['caction'] = $action;
                //pr($result_data);
                $allClass[] = $result_data;
            }
        }
        $response['data'] = $allClass;
        echo json_encode($response);
    }

    public function getBookingListArchiveData() {
        $classdt = date("Y-m-d");
        $user_id = $this->session->userdata('user_id');
        $sql = 'Select bm.booking_user_id,bm.booking_id,bm.status as bm_status,bm.class_date as bm_class_date,cm.* from booking_master as bm join class_master as cm ON bm.class_id=cm.class_id where '
                . 'bm.class_date < "' . $classdt . '" AND '
                . 'bm.user_id="' . $user_id . '" ';
        $classdata = $this->db->query($sql)->result();

//        $classdata = getListdata(array("user_id" => $this->session->userdata('user_id'), "class_date < " => $classdt,"weekly"=>0), 'class_master', 'class_id', 'DESC');
        $result_data = array();
        $allClass = array();
        $response = array();
        $action = "";

        if (count($classdata) > 0) {
            foreach ($classdata as $class) {
                $class_id = $class->class_id;
                $cntres = $this->Dashboard_model->getViewBookingData($class_id);

                #$bookedusercnt = count($cntres);
                $bookedusercnt = 0;
                if (count($cntres) > 0) {
                    foreach ($cntres as $cr) {
                        if ($cr->status != 'canceled') {
                            $bookedusercnt = $bookedusercnt + 1;
                        }
                    }
                }

                $service = getListdata(array("service_id" => $class->service_id), 'gym_service');
                $result_data['service'] = $service[0]->name;
                $result_data['class_date'] = date("m/d/Y", strtotime($class->bm_class_date));
                $result_data['time'] = $class->timer1 . ' to ' . $class->timer2;
                $result_data['trainer_name'] = "--";
                if ($class->trainer_id != "0") {
                    $trainerData = getListdata(array("trainer_id" => $class->trainer_id), 'trainer_master');
                    $result_data['trainer_name'] = $trainerData[0]->name;
                }
                $result_data['user_limit'] = $class->user_limit;
                $result_data['bookedusercnt'] = $bookedusercnt;
                $result_data['status'] = $class->status;

                $action = '<a href="' . $this->config->item('base_url') . 'userBookingdetail/' . $class->class_id . '" class="btn btn-grey"><i class="fa fa-eye"></i></a>
				<a href="javascript:;" class="btn btn-info" id="copy" onclick="copyclass(' . $class->class_id . ');"><i class="fa fa-clone" title="Copy Class"></i></a>';

                $result_data['caction'] = $action;
                //pr($result_data);
                $allClass[] = $result_data;
            }
        }
        $response['data'] = $allClass;
        echo json_encode($response);
    }

    public function updateLocationstatus() {
        $location_id = trim($this->input->post('locationId'));
        $locationData = getListdata(array("location_id" => $location_id), 'location_master');

        $newstatus = "";
        $statustext = "";
        if ($locationData[0]->status == 0) {
            $newstatus = '1';
            $statustext = '<i class="fa fa-unlock"></i>';
        }
        if ($locationData[0]->status == 1) {
            $newstatus = '0';
            $statustext = '<i class="fa fa-lock"></i>';
        }

        $locationdata = updatedata("location_master", array('status' => $newstatus), array('location_id' => $location_id));
        echo $statustext;
    }

    public function updateTrainerstatus() {
        $trainer_id = trim($this->input->post('trainer_id'));
        $trainerData = getListdata(array("trainer_id" => $trainer_id), 'trainer_master');

        $newstatus = "";
        $statustext = "";
        if ($trainerData[0]->status == 0) {
            $newstatus = '1';
            $statustext = '<i class="fa fa-unlock"></i>';
        }
        if ($trainerData[0]->status == 1) {
            $newstatus = '0';
            $statustext = '<i class="fa fa-lock"></i>';
        }

        $locationdata = updatedata("trainer_master", array('status' => $newstatus), array('trainer_id' => $trainer_id));
        echo $statustext;
    }

    public function getBookingUserDetail() {

        $class_id = trim($this->input->post('class_id'));
        $classData = getListdata(array("class_id" => $class_id), 'class_master');
        $classData = $classData[0];

        $BookingData = getListdata(array("class_id" => $class_id, "user_id" => $this->session->userdata("user_id")), 'booking_master');

        $class_update = updatedata("class_master", array('status' => 'canceled'), array('class_id' => $class_id));
        if (count($BookingData) > 0) {
            foreach ($BookingData as $booking) {
                if ($booking->status == 'booked') {
                    $booking_id = $booking->booking_id;
                    $userData = getListdata(array("user_id" => $booking->booking_user_id), 'user_master');
                    $balanced_point = $userData[0]->balanced_point;
                    $usedpoint = $booking->points_used;
                    $totalPoint = $balanced_point + $usedpoint;
                    $booking_user_id = $booking->booking_user_id;
                    $user_update = updatedata("user_master", array('balanced_point' => $totalPoint), array('user_id' => $booking_user_id));
                    $booking_update = updatedata("booking_master", array('status' => 'canceled'), array('booking_id' => $booking_id));
                    // send mail
                    $template = getListdata(array("template_id" => '7'), 'email_template');
                    $subject = $template[0]->subject;
                    $html = $template[0]->message;
                    $html = str_replace("{{name}}", $userData[0]->name, $html);
                    $html = str_replace("{{classdate}}", date('m/d/Y', strtotime($classData->class_date)), $html);
                    $html = str_replace("{{classtime}}", $classData->timer1 . ' to ' . $classData->timer2, $html);
                    $html = str_replace("{{classpoint}}", $usedpoint, $html);
                    $html = str_replace("{{Link}}", ' <a target="_blank" href="' . $this->config->item('base_url') . '">' . $this->config->item('base_url') . '</a><br/><br/>', $html);
                    $sendmail = sendmail($userData[0]->email, $subject, $html);
                }
            }
        }
    }

    public function getCancleClassData() {
        $class_id = trim($this->input->post('class_id'));
        $BookingData = getListdata(array("class_id" => $class_id), 'booking_master');
    }

    public function getCashoutCreditData() {
        $html = "";
        $html1 = "";
        $sum = 0;
        $gym_point = 0;
        $gym_value = 0;

        $userBankData = getListdata(array("user_id" => $this->session->userdata('user_id')), 'user_master');
        $account_num = $userBankData[0]->account_num;
        $bank_name = $userBankData[0]->bank_name;
        $ifsc_code = $userBankData[0]->ifsc_code;

        $gym_point_Data = getListdata(array("user_id" => $this->session->userdata('user_id')), 'gym_point_master');

        $payout_Data = $this->Dashboard_model->getPayoutData($this->session->userdata('user_id'));
// Ramon[09/28/17]:: Show visits instead of points for cashout details		
        $gym_visits = count($this->Dashboard_model->getBookingsNumber($this->session->userdata('user_id')));

        if (count($gym_point_Data) > 0) {
            $gym_value = $gym_point_Data[0]->value;
            $gym_point = $gym_point_Data[0]->point;
// Ramon[09/28/17]:: Show visits instead of points for cashout details
            //$html .= '<tr><td>'.$gym_point.'</td>';
            $html .= '<tr><td>' . $gym_visits . '</td>';
            $html .= '<td>$' . number_format($gym_value, 2) . '</td>';
            $html .= '<td>' . date("m/d/Y", strtotime($gym_point_Data[0]->datetime));
            '</td>';
            $html .= '<td><a href="#" data-toggle="modal" data-target="#request_popup" class="btn orange_btn-sm">Send Request</a></td></tr>';
        } else {
            $html = '<tr><td colspan="4">No record found.</td></tr>';
        }

        if (count($payout_Data) > 0) {
            $remain_points = 0;

            foreach ($payout_Data as $payout) {
                $status = ('0' == $payout->status) ? 'Pending' : (('2' == $payout->status) ? 'Hold' : 'Paid');
                $payoutdate = ('' != $payout->payoutdate) ? date("m/d/Y", strtotime($payout->payoutdate)) : '';

                $html1 .= '<tr><td>$' . number_format($payout->cash_value, 2) . '</td>';
                $html1 .= '<td>' . $payout->trasaction_id . '</td>';
                #$html1 .= '<td>$'.number_format($remain_points, 2).'</td>';
                $html1 .= '<td>' . $payoutdate . '</td>';
                $html1 .= '<td>' . date("m/d/Y", strtotime($payout->date)) . '</td>';
                $html1 .= '<td>' . $status . '</td></tr>';
            }
        } else {
            $html1 = '<tr><td colspan="6">No record found.</td></tr>';
        }

        echo $html . "#####" . $html1 . "#####" . $gym_point . "#####" . $gym_value . "#####" . $account_num . "#####" . $bank_name . "#####" . $ifsc_code;
    }

    public function printmecodelist() {
        $user_id = $this->session->userdata('user_id');
        $html = "";
        $html1 = "";
        $sum = 0;
        $remain_points = 0;
        $gym_qrcode_Data = $this->Dashboard_model->getqrcodelisting();
        #pr($gym_qrcode_Data);
        $response = array("qrdetails" => "", "qrimages" => "");
        if (count($gym_qrcode_Data) > 0) {
            foreach ($gym_qrcode_Data as $qrcodedata) {
                $service_name = $qrcodedata->servicetype;
                $class_name = $qrcodedata->classtype;
                $user_id = $qrcodedata->user_id;
                $qr_code_id = $qrcodedata->qr_code_id;

                if ($qrcodedata->qr_code_status == 1 && $qrcodedata->qr_image != "") {
                    $statusval = 'Accepted';
                } else if ($qrcodedata->qr_code_status == 1) {
                    $statusval = '<a class="btn add_btn" href="javascript:void(0);" data-userid="' . $user_id . '" data-qr_code_id="' . $qr_code_id . '" onclick="return generteqrcode(this);">Generate QR code</a>';
                } else if ($qrcodedata->qr_code_status == 2) {
                    $statusval = 'Rejected';
                } else if ($qrcodedata->qr_code_status == 3) {
                    $statusval = 'Expired';
                } else {
                    $statusval = 'Request';
                }
                $html .= '<tr><td>' . date("m/d/Y H:i:s", strtotime($qrcodedata->qr_created_date)) . '</td>';
                $html .= '<td>' . $qrcodedata->name . '</td>';
                $html .= '<td>' . $class_name . '</td>';
                $html .= '<td>' . $service_name . '</td>';
                $html .= '<td>' . $qrcodedata->monthly_price . '</td>';
                $html .= '<td>' . $qrcodedata->class_point . '</td>';
                $html .= '<td>' . $qrcodedata->message . '</td>';
                $html .= '<td>' . $qrcodedata->estatus . '</td>';
                $html .= '<td>' . $statusval . '</td></tr>';
            }
        } else {
            $html = '<tr><td colspan="7">No record found.</td></tr>';
        }
        $response["qrdetails"] = $html;

        //Start: Display QR Code for loggedin user
        $fields = "gm.name as gym_name,qcm.class_point as point,ctm.name as class_type,gs.name as service_type,qcm.qr_image,qcm.qr_created_date,qcm.qr_code_number,qcm.qr_code_id,qcm.user_id";
        $sql = "SELECT $fields FROM gym_master gm " .
                "JOIN gym_service gs ON gm.service_id = gs.service_id " .
                "JOIN class_type_master ctm ON gm.class_type_id = ctm.class_type_id " .
                "LEFT JOIN qr_code_master qcm ON gm.user_id = qcm.user_id AND qcm.qr_code_status='1' " .
                "WHERE gm.user_id=$user_id AND qcm.qr_image<>''";

        //echo $sql;exit;
        $result = $this->db->query($sql)->result();
        $front_image_path = $this->config->item('upload_path') . "qrcode/";
        $qrimghtml = '';

        if (count($result) > 0) {
            foreach ($result as $qrcodedata1) {

                $qrimghtml .= '<div class="col-sm-6 text-center">
								<h4><strong>Gym Class : </strong>' . $qrcodedata1->class_type . '</h4>
								<h5><strong>QR Created On : </strong>' . date("m/d/Y H:i:s", strtotime($qrcodedata1->qr_created_date)) . '</h5>
								<h5><strong>Points : </strong> ' . $qrcodedata1->point . '</h5>
								<img src="' . $front_image_path . $qrcodedata1->qr_image . '" class="img-responsive" style="margin:0px auto;">
								<h4>' . $qrcodedata1->qr_code_number . '</h4>
								 <div class="text-center">
                                    <a href="' . base_url() . 'printQrcode/' . $qrcodedata1->qr_code_id . '/' . $qrcodedata1->user_id . '" class="btn buy_now_btn" target="_blank">Print me</a>
                                </div>
							   </div>';
            }
        }
        $response['qrimages'] = $qrimghtml;
        //End: Display QR Code for loggedin user
        echo json_encode($response);
        //echo $html;
    }

    public function generteqrcode() {
        $user_id = $this->input->post('user_id');
        $qr_code_id = $this->input->post("qr_code_id");
        #Start: Code for deactive all other generated QRcode
        $qrcodelist = getListdata(array('qr_code_status' => '1', 'qr_code_id !=' => $qr_code_id, 'user_id' => $user_id), 'qr_code_master');
        if ($qrcodelist) {
            foreach ($qrcodelist as $key => $value) {
                $ids = $value->qr_code_id;
                $userArray = array(
                    'estatus' => 'deactive',
                    'qr_code_status' => '3'
                );
                $update = $this->Dashboard_model->updateqrcode($userArray, $ids);
            }
        }
        #End: Code for deactive all other generated QRcode

        $fields = "gm.name as gym_name,qcm.class_point as point,qcm.qr_code_number,ctm.name as class_type,gs.name as service_type";
        $sql = "SELECT $fields FROM gym_master gm " .
                "JOIN gym_service gs ON gm.service_id = gs.service_id " .
                "JOIN class_type_master ctm ON gm.class_type_id = ctm.class_type_id " .
                "LEFT JOIN qr_code_master qcm ON gm.user_id = qcm.user_id AND qcm.qr_code_status='1' " .
                "WHERE gm.user_id=$user_id";
        $result = $this->db->query($sql)->row();
        $link = $this->config->item('base_url') . "checkin/" . $result->qr_code_number;
        $message = "Name: " . $result->gym_name . ", Points : " . $result->point . ", Class Type : " .
                $result->class_type . ", Service Type : " . $result->service_type . ", Link : " . $link;
        $this->load->library('ciqrcode');
        //Update QR Code image in QR Code Master table
        $filename = uniqid() . ".png";
        $this->db->update("qr_code_master", array("qr_image" => "$filename", "created_date" => date("Y-m-d H:i:s")), array("user_id" => $user_id, "qr_code_status" => "1"));

        //header("Content-Type: image/png");
        //$config['size']         = 2048; //interger, the default is 1024
        $params['savename'] = 'uploads/qrcode/' . $filename;
        $params['level'] = 'H';
        $params['size'] = 5;
        $params['data'] = $message;
        $this->ciqrcode->initialize($config);
        $this->ciqrcode->generate($params);
        //$flag = QRcode::png($message, 'uploads/qrcode/'.$filename); // creates file 
    }

    public function saveGymPointChatdata() {
        $point = trim($this->input->post('point'));
        $cash_value = trim($this->input->post('cash_value'));
        $message = trim($this->input->post('message'));
        $date = trim($this->input->post('date'));
        $user_id = $this->session->userdata('user_id');

        $classData = getListdata(array("user_id" => $user_id, "status!=" => '1'), 'gym_point_chat');

        if (count($classData) > 0) {
            echo "exits";
        } else {
            $ChatArray = array(
                'user_id' => $user_id,
                'cash_value' => $cash_value,
                'point' => $point,
                'message' => $message,
                'status' => '0',
                'date' => $date
            );
            $query = savedata('gym_point_chat', $ChatArray);

            /* $PayoutArray = array(
              'point_chat_id' => $query,
              'user_id' => $user_id,
              'points' => $cash_value,
              'date' => date('Y-m-d', $date),
              'trasaction_id' => ''
              );
              $query1 = savedata('payout',$PayoutArray); */
            return $query;
        }
    }

    public function calendarData() {

        $classData = getListdata(array("user_id" => $this->session->userdata('user_id'), "status!=" => 'canceled'), 'class_master');
        $arr = array();
        if (count($classData) > 0) {
            $i = 0;
            $startdate = "";
            $enddate = "";
            foreach ($classData as $class) {

                $start_time_in_24_hour_format = date("H:i", strtotime($class->timer1));
                $end_time_in_24_hour_format = date("H:i", strtotime($class->timer2));

                $services = getListdata(array("service_id" => $class->service_id), 'gym_service');

                $startdate = $class->class_date . "T" . $start_time_in_24_hour_format;
                $enddate = $class->class_date . "T" . $end_time_in_24_hour_format;

                $arr[$i]['id'] = $class->class_id;
                $arr[$i]['title'] = $services[0]->name;
                $arr[$i]['start'] = $startdate;
                $arr[$i]['end'] = $enddate;
                $i++;
            }
        }
        //pr(json_encode($arr));exit;
        echo json_encode($arr);
    }

    public function saveGymPointdata() {
        $monthly_price = trim($this->input->post('monthly_price'));
        $servicetype = trim($this->input->post('printservicetype'));
        $typeofclass = trim($this->input->post('typeofclass'));

        //////////////////////////////////////
        //Start Change by Ramon 8-3-17
        ///////////////////////////////////////

        if ($monthly_price < 50) {
            $class_point = 70;
        } else {
            $class_point = 10 * ceil((1.389 * ($monthly_price)) / 10);
        }

        //////////////////////////////////////
        //End Change by Ramon 
        ///////////////////////////////////////

        $gymArray = array(
            'service_id' => $servicetype,
            'class_type_id' => $typeofclass
        );
        $query = updatedata("gym_master", $gymArray, array('user_id' => $this->session->userdata('user_id')));
        $userArray = array(
            'user_id' => $this->session->userdata('user_id'),
            'class_id' => $typeofclass,
            'service_id' => $servicetype,
            'monthly_price' => $monthly_price,
            'class_point' => $class_point,
            'qr_code_status' => '0',
            'created_date' => date('Y-m-d h:i:s'),
            'qr_created_date' => date('Y-m-d h:i:s'),
            'estatus' => 'deactive'
        );
        $this->db->insert("qr_code_master", $userArray);
        $qrid = $this->db->insert_id();
        return $qrid;
    }

    public function updateDefaultLocation() {
        $locationId = trim($this->input->post('locationId'));
        updatedata("location_master", array('default_location' => '0'), array());
        updatedata("location_master", array('default_location' => '1'), array('location_id' => $locationId));
        //$locationData = getListdata(array("location_id"=>$locationId),'location_master');
        //echo $locationData[0]->lattitude."#".$locationData[0]->longitude;
        //return "1";
    }

    public function checkClassExists() {
        $error = "";
        $single_or_weekly_class = $_POST['single_or_weekly_class'];
        if ($single_or_weekly_class == 1) {
            $nowDate = date('Y-m-d');
            $timer1 = trim($this->input->post('timepicker1')); #12:00am
            $timer2 = trim($this->input->post('timepicker2')); #1:00am
            $hdn_class_id = trim($this->input->post('hdn_class_id')); #
            $hdn_gym_user_id = trim($this->input->post('hdn_gym_user_id')); #2
            $trainer_id = trim($this->input->post('trainer_id')); #2
            $weekdays = $_POST['week_days'];
            $days = explode(",", $weekdays);
            foreach ($days as $day) {
                if ($hdn_class_id != "") {
                    $sql = 'Select class_id,DATE_FORMAT(`class_date`, "%a") from class_master where '
                            . '(FIND_IN_SET(DATE_FORMAT(`class_date`, "%a"), "' . $day . '")!=0 OR FIND_IN_SET("' . $day . '",`week_days`)!=0) AND '
                            . '(`class_date`>="' . $nowDate . '" OR `class_date`="0000-00-00") AND '
                            . '`status`!="canceled" AND '
                            . '`timer1`="' . $timer1 . '" AND `timer2`="' . $timer2 . '" '
                            . 'AND `user_id`="' . $hdn_gym_user_id . '" AND `trainer_id`="' . $trainer_id . '" '
                            . 'AND `class_id`!="' . $hdn_class_id . '"';
                } else {
                    $sql = 'Select class_id,DATE_FORMAT(`class_date`, "%a") from class_master where '
                            . '(FIND_IN_SET(DATE_FORMAT(`class_date`, "%a"), "' . $day . '")!=0 OR FIND_IN_SET("' . $day . '",`week_days`)!=0) AND '
                            . '(`class_date`>="' . $nowDate . '" OR `class_date`="0000-00-00") AND '
                            . '`status`!="canceled" AND '
                            . '`timer1`="' . $timer1 . '" AND `timer2`="' . $timer2 . '" '
                            . 'AND `user_id`="' . $hdn_gym_user_id . '" AND `trainer_id`="' . $trainer_id . '" ';
                }
                $result = $this->db->query($sql)->result();
                if (count($result) > 0) {
                    $error .= $day . ", ";
                }
            }
            if ($error != "") {
                echo $error . " class already exists";
            } else {
                echo "";
            }
        } else {
            $timer1 = trim($this->input->post('timer1')); #12:00am
            $timer2 = trim($this->input->post('timer2')); #1:00am
            $hdn_class_id = trim($this->input->post('hdn_class_id')); #
            $hdn_gym_user_id = trim($this->input->post('hdn_gym_user_id')); #2
            $trainer_id = trim($this->input->post('trainer_id')); #2
//            $classDates = $this->input->post('class_date'); #04/25/2017
            $classDates = $this->input->post('multidates'); #04/25/2017
            $dates = explode(",", $classDates);

            $error = "";
            $error1 = "";


            foreach ($dates as $date) {
                $class_date = date("Y-m-d", strtotime($date));

                if ($hdn_class_id != "") {
                    $classData = getListdata(array("status!=" => "canceled", "class_date" => $class_date, "timer1" => $timer1, "timer2" => $timer2, "user_id" => $hdn_gym_user_id, "trainer_id" => $trainer_id, "class_id!=" => $hdn_class_id), 'class_master');
                } else {
                    $classData = getListdata(array("status!=" => "canceled", "class_date" => $class_date, "timer1" => $timer1, "timer2" => $timer2, "user_id" => $hdn_gym_user_id, "trainer_id" => $trainer_id), 'class_master');
                }

                if (!empty($classData)) {
                    $error .= $date . ", ";
                }
            }

            if ($error != "") {
                echo $error . " class already exists";
            } else {
                echo "";
            }
        }
    }

    public function checkClassExists111() {

        $timer1 = trim($this->input->post('timer1')); #12:00am
        $timer2 = trim($this->input->post('timer2')); #1:00am
        $hdn_class_id = trim($this->input->post('hdn_class_id')); #
        $hdn_gym_user_id = trim($this->input->post('hdn_gym_user_id')); #2
        $trainer_id = trim($this->input->post('trainer_id')); #2
        $classDates = $this->input->post('class_date'); #04/25/2017
        $dates = explode(",", $classDates);

        $error = "";
        $error1 = "";

        foreach ($dates as $date) {
            $class_date = date("Y-m-d", strtotime($date));

            if ($hdn_class_id != "") {
                $classData = getListdata(array("status!=" => "canceled", "class_date" => $class_date, "timer1" => $timer1, "timer2" => $timer2, "user_id" => $hdn_gym_user_id, "trainer_id" => $trainer_id, "class_id!=" => $hdn_class_id), 'class_master');
            } else {
                $classData = getListdata(array("status!=" => "canceled", "class_date" => $class_date, "timer1" => $timer1, "timer2" => $timer2, "user_id" => $hdn_gym_user_id, "trainer_id" => $trainer_id), 'class_master');
            }

            if (!empty($classData)) {
                $error .= $date . ", ";
            }
        }

        if ($error != "") {
            echo $error . " class already exists";
        } else {
            echo "";
        }
    }

    public function userBookingdetail() {
        $class_id = $this->uri->segment(2);
        $this->data['title'] = 'userBookingdetail';
        $this->data['content'] = 'userBookingdetail';
        $this->data['headerdata'] = getuserdata();
        $this->data['gymdata'] = getGymdata();
        $this->data['class_id'] = $class_id;
        render_page('template', $this->data);
    }

    public function getBookingData() {
        $loop_count = $this->input->post("loop_count");
        $val = $this->input->post("val");
        $data = [];
        $data['loop_count'] = $loop_count;
        $data['val'] = $val;
        $this->load->view('get_all_booking_data', $data);
    }

    public function updateBookingStatusDeny() {
        $booking_id = $this->input->post("booking_id");
        $chkValue = $this->input->post("chkValue");

        $BookingData = getListdata(array("booking_id" => $booking_id), 'booking_master');
        if ($chkValue == '2') {
            $value = 'canceled';
        }

        $update = updatedata("booking_master", array("status" => $value), array("booking_id" => $booking_id));

        $userdata = getListdata(array("user_id" => $BookingData[0]->booking_user_id), 'user_master');
        $balancedPoint = $userdata[0]->balanced_point + $BookingData[0]->points_used;
        $pointArray = array(
            "balanced_point" => $balancedPoint
        );
        $update_user_master = updatedata("user_master", $pointArray, array('user_id' => $BookingData[0]->booking_user_id));



//            for email shoot
        $checkIsRefer = getListdata(array('user_id' => $BookingData[0]->booking_user_id), 'user_master');
        #Start: Email Code 
        $template = getListdata(array("template_id" => '17'), 'email_template');
        $email = $checkIsRefer[0]->email;
        $subject = $template[0]->subject;
        $html = $template[0]->message;
//						$html = str_replace("{{name}}", $checkIsRefer[0]->name." ".$checkIsRefer[0]->last_name, $html);
        $html = str_replace("{{Link}}", ' <a target="_blank" href="' . $this->config->item('base_url') . '">' . $this->config->item('base_url') . '</a><br/><br/>', $html);
        $sendmail = sendmail($email, $subject, $html);
        #End: Email Code 
    }

    public function updateBookingStatusNormal() {
        $booking_id = $this->input->post("booking_id");
        $chkValue = $this->input->post("chkValue");

        if ($chkValue == '1') {
            $value = 'confirmed';
        }
        if ($chkValue == '0') {
            $value = 'booked';
        }

        $update = updatedata("booking_master", array("status" => $value), array("booking_id" => $booking_id));

        #START: Code for adding Points in Gym Users Account
        $BookingData = getListdata(array("booking_id" => $booking_id), 'booking_master');


        if (count($BookingData) > 0) {
            foreach ($BookingData as $booking) {
                $usedpoint = $booking->points_used;
                $user_id = $booking->user_id;
                $percentage = $booking->percentage;

                $gymUserData = getListdata(array("user_id" => $user_id), 'gym_point_master');

                //	Ramon[9/28/17]:: Add Total visits to gym_point_master database				
                $hops = count($this->Dashboard_model->getBookingsNumber($user_id));

                #Start: Code for Adding/Deducting points from Gym User Account
                if (count($gymUserData) > 0) {
                    $gymTotalPoint = $gymUserData[0]->point + $usedpoint;
                    //$gymTotalPoint 		= $gymUserDataPoint;
                    //Ramon[9/28/17]:: Correct Value calculation
                    $value = $percentage * ($gymTotalPoint / 10);
                    $adminValue = (1 - $percentage) * ($gymTotalPoint / 10);

                    $gym_user_array = array(
                        'point' => $gymTotalPoint,
                        'value' => $value,
                        'admin_value' => $adminValue,
                        'datetime' => date('Y-m-d'),
                        'user_id' => $user_id,
                        //	Ramon[9/28/17]:: Add visits to database						
                        'visits' => $hops
                    );
                    $update = updatedata("gym_point_master", $gym_user_array, array('user_id' => $user_id));
                } else {
                    $gymTotalPoint = $usedpoint;
                    //Ramon[9/28/17]:: Correct Value calculation
                    $value = $percentage * ($gymTotalPoint / 10);
                    $adminValue = (1 - $percentage) * ($gymTotalPoint / 10);

                    $gym_user_array = array(
                        'point' => $gymTotalPoint,
                        'value' => $value,
                        'admin_value' => $adminValue,
                        'datetime' => date('Y-m-d'),
                        'user_id' => $user_id,
//	Ramon[9/28/17]:: Add visits to database							
                        'visits' => $hops
                    );
                    $insert = $this->db->insert("gym_point_master", $gym_user_array);
                }
                #End: Code for Adding/Deducting points from Gym User Account
            }
        }
        #END: Code for adding Points in Gym Users Account
    }

    public function updateBookingStatusAppointment() {
        $booking_id = $this->input->post("booking_id");
        $chkValue = $this->input->post("chkValue");

        if ($chkValue == '1') {
            $value = 'confirmed';
        }
        if ($chkValue == '0') {
            $value = 'booked';
        }

        $update = updatedata("booking_master", array("status" => $value), array("booking_id" => $booking_id));

        #START: Code for adding Points in Gym Users Account
        $BookingData = getListdata(array("booking_id" => $booking_id), 'booking_master');


        if (count($BookingData) > 0) {
            foreach ($BookingData as $booking) {
                $usedpoint = $booking->points_used;
                $user_id = $booking->user_id;
                $percentage = $booking->percentage;

                $gymUserData = getListdata(array("user_id" => $user_id), 'gym_point_master');

                //	Ramon[9/28/17]:: Add Total visits to gym_point_master database				
                $hops = count($this->Dashboard_model->getBookingsNumber($user_id));

                #Start: Code for Adding/Deducting points from Gym User Account
                if (count($gymUserData) > 0) {
                    $gymTotalPoint = $gymUserData[0]->point + $usedpoint;
                    //$gymTotalPoint 		= $gymUserDataPoint;
                    //Ramon[9/28/17]:: Correct Value calculation
                    $value = $percentage * ($gymTotalPoint / 10);
                    $adminValue = (1 - $percentage) * ($gymTotalPoint / 10);

                    $gym_user_array = array(
                        'point' => $gymTotalPoint,
                        'value' => $value,
                        'admin_value' => $adminValue,
                        'datetime' => date('Y-m-d'),
                        'user_id' => $user_id,
                        //	Ramon[9/28/17]:: Add visits to database						
                        'visits' => $hops
                    );
                    $update = updatedata("gym_point_master", $gym_user_array, array('user_id' => $user_id));
                } else {
                    $gymTotalPoint = $usedpoint;
                    //Ramon[9/28/17]:: Correct Value calculation
                    $value = $percentage * ($gymTotalPoint / 10);
                    $adminValue = (1 - $percentage) * ($gymTotalPoint / 10);

                    $gym_user_array = array(
                        'point' => $gymTotalPoint,
                        'value' => $value,
                        'admin_value' => $adminValue,
                        'datetime' => date('Y-m-d'),
                        'user_id' => $user_id,
//	Ramon[9/28/17]:: Add visits to database							
                        'visits' => $hops
                    );
                    $insert = $this->db->insert("gym_point_master", $gym_user_array);
                }
                #End: Code for Adding/Deducting points from Gym User Account
            }
//            for email shoot
            $checkIsRefer = getListdata(array('user_id' => $BookingData[0]->booking_user_id), 'user_master');
            #Start: Email Code 
            $template = getListdata(array("template_id" => '16'), 'email_template');
            $email = $checkIsRefer[0]->email;
            $subject = $template[0]->subject;
            $html = $template[0]->message;
//						$html = str_replace("{{name}}", $checkIsRefer[0]->name." ".$checkIsRefer[0]->last_name, $html);
            $html = str_replace("{{Link}}", ' <a target="_blank" href="' . $this->config->item('base_url') . '">' . $this->config->item('base_url') . '</a><br/><br/>', $html);
            $sendmail = sendmail($email, $subject, $html);
            #End: Email Code 
        }
        #END: Code for adding Points in Gym Users Account
    }

    public function QrCodeScanDetail() {
        $booking_id = $this->uri->segment('2');
        $user_id = $this->uri->segment('3');
        $this->data['title'] = 'QrCodeScanDetail';
        $this->data['content'] = 'QrCodeScanDetail';
        $this->data['headerdata'] = getuserdata();
        $this->data['gymdata'] = getGymdata();
        $this->data['totalViews'] = $this->Dashboard_model->getTotalViews($user_id);
        $this->data['bookingClassDetails'] = $this->Dashboard_model->getQrCodeDetail($booking_id);
        $this->data['booking_id'] = $booking_id;
        //pr($this->data['bookingClassDetails']);
        render_page('template', $this->data);
    }

    public function printQrcode() {
        $qr_code_id = $this->uri->segment('2');
        $user_id = $this->uri->segment('3');
        $this->data['title'] = 'printQrcode';
        $this->data['content'] = 'printQrcode';
        $this->data['totalViews'] = $this->Dashboard_model->getTotalViews($user_id);
        $this->data['bookingClassDetails'] = $this->Dashboard_model->getPrintQrCodeDetail($qr_code_id);
        $this->data['headerdata'] = getuserdata();
        $this->data['address'] = $this->input->post('searchtxt');
        #$this->load->view('common/header');
        $this->load->view($this->data['content'], $this->data);
        #$this->load->view('common/footer');
    }

}

?>