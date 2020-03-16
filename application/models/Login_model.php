<?php

class Login_model extends CI_Model{

	function __construct(){

		parent::__construct();

	}



	function validate($email, $password)

	{

		$this->db->where('email', $email);

		$this->db->where('password', $password);

		$this->db->where('status', '1');

		$query = $this->db->get('user_master'); 

		//echo $this->db->last_query();echo "<br/>";exit;

		//echo $query->num_rows();exit;

		if($query->num_rows() > 0)

		{

			$user =  $query->result();

			$this->session->set_userdata(array(

				'user_id'       => $user[0]->user_id,

				'username'      => $user[0]->name,

				'profilepic'      => $user[0]->profilepic,

				'email'      => $user[0]->email

            ));

            //echo $this->session->userdata('email');exit;

            return 1;

        } else {

            return 0;

        }

    }



    function get_by_id($id) {

        $this->db->where('user_id', $id);

        return $this->db->get('user_master')->row();

    }



    function passwordvalidate($oldpassword, $newpassword) {

        $email = $this->session->userdata('email');

        $this->db->where('password', $oldpassword);

        $this->db->where('email', $this->session->userdata('email'));

        $query = $this->db->get('user_master');

        //echo $this->db->last_query();echo "<br/>";exit;

        //echo $query->num_rows();exit;



        $data = array(

            'password' => $newpassword

        );



        if ($query->num_rows() > 0) {

            $query = $this->db->update("user_master", $data, array('email' => $email));

            return 1;

        } else {

            return 0;

        }

    }



    function emailvalidate($email) {



        $this->db->where('email', $email);

        $query1 = $this->db->get('user_master');



        if ($query1->num_rows() > 0) {

            $res = $query1->row();

            if ("normal" == $res->login_type) {

                $newpassword = create_new_password();

                #echo $newpassword;exit;

                $data = array(

                    'password' => md5($newpassword)

                );



                $query = $this->db->update("user_master", $data, array('email' => $email));

                $user = $query1->result();



                $template = getListdata(array("template_id" => '3'), 'email_template');

                $subject = $template[0]->subject;

                $html = $template[0]->message;



                $html = str_replace("{{name}}", $user[0]->name, $html);

                $html = str_replace("{{password}}", $newpassword, $html);

                $html = str_replace("{{Link}}", ' <a target="_blank" href="' . $this->config->item('base_url') . '">' . $this->config->item('base_url') . '</a><br/><br/>', $html);



                $sendmail = sendmail($email, $subject, $html);



                return 1;

            }

            return 2;

        } else {

            return 0;

        }

    }



    function updateGymUserStatus($user_id, $userArray) {

        $this->db->where("user_id", $user_id);

        $this->db->update("user_master", $userArray);

    }



    function removeUser($email) {

        $this->db->where("email", $email);

        $this->db->delete("users");

    }

    



    /* function searchGymdata_OLD_ANKITA($seartext){



      $gym_qry = "select user_id,gym_id,city,state,country,address,lattitude,longitude,zipcode,service_id from gym_master where (city Like '%".$seartext."%' OR zipcode LIKE '%".$seartext."%' OR meta_services Like '%".$seartext."%')";		$query = $this->db->query($gym_qry);

      $gym_result = $query->result();





      $location_qry = "Select lm.user_id,lm.city,lm.state,lm.country,lm.address,lm.lattitude,lm.longitude,lm.zipcode,gm.service_id,gm.gym_id from location_master as lm,gym_master as gm where gm.user_id = lm.user_id AND (lm.city Like '%".$seartext."%' OR lm.zipcode = '%".$seartext."%')";

      $query = $this->db->query($location_qry);

      $location_result = $query->result();



      $result = array_merge($gym_result,$location_result);

      return $result;

      } */



    function searchGymdata($seartext) {

        $srctext = "%$seartext%";

        $fields = "gm.user_id,gm.city,gm.state,gm.country,gm.address,gm.lattitude,gm.longitude,gm.zipcode,gm.service_id,gm.gym_id,gm.name as gym_name,qcm.class_point as point,gs.image as gym_image,gs.name as service_name,ctm.name as class_type";

        $sql = 'SELECT ' . $fields . ' FROM gym_master gm ' .

                'LEFT JOIN qr_code_master qcm ON gm.user_id = qcm.user_id AND qcm.qr_code_status="1" ' .

                'JOIN gym_service gs ON qcm.service_id = gs.service_id ' .

                'JOIN class_type_master ctm ON gm.class_type_id = ctm.class_type_id ' .

                'JOIN user_master um ON um.user_id = gm.user_id ' .

                //'LEFT JOIN location_master lm ON gm.user_id = lm.user_id '.

                'WHERE um.status = "1" AND qr_image != "" AND qr_code_status = "1" AND (gm.name LIKE "' . $srctext . '" OR ' .

                'gm.zipcode LIKE "' . $srctext . '" OR ' .

                'gm.address LIKE "' . $srctext . '" OR ' .

                'gs.name LIKE "' . $srctext . '" OR ' .

                'ctm.name LIKE "' . $srctext . '" OR ' .

                'gm.city LIKE "' . $srctext . '" OR ' .

                'gm.meta_services LIKE "' . $srctext . '")';

        //echo "qry==>".$sql."<br>";

        $gym_result = $this->db->query($sql)->result();



        /* gymname zipcode address service type class type city meta_services */



        $fields = "lm.user_id,lm.city,lm.state,lm.country,lm.address,lm.lattitude,lm.longitude,lm.zipcode,gm.service_id,gm.gym_id,gm.name as gym_name,qcm.class_point as point,gs.image as gym_image,gs.name as service_name,ctm.name as class_type";

        $sql = 'SELECT ' . $fields . ' FROM location_master lm ' .

                'LEFT JOIN gym_master gm ON gm.user_id = lm.user_id ' .

                'LEFT JOIN qr_code_master qcm ON gm.user_id = qcm.user_id AND qcm.qr_code_status="1" ' .

                'JOIN gym_service gs ON qcm.service_id = gs.service_id ' .

                'JOIN class_type_master ctm ON gm.class_type_id = ctm.class_type_id ' .

                'JOIN user_master um ON um.user_id = gm.user_id ' .

                'WHERE lm.user_id>0 AND um.status = "1" AND qr_image != "" AND qr_code_status = "1" AND (lm.zipcode LIKE "' . $srctext . '" OR ' .

                'lm.address LIKE "' . $srctext . '" OR ' .

                'gs.name LIKE "' . $srctext . '" OR ' .

                'ctm.name LIKE "' . $srctext . '" OR ' .

                'lm.city LIKE "' . $srctext . '" OR ' .

                'gm.meta_services LIKE "' . $srctext . '")';

        #echo "qry2==>".$sql."<br>";

        $location_result = $this->db->query($sql)->result();

        $result = array_merge($gym_result, $location_result);

        return $result;

    }

    

     function update($id, $data)

    {

        $this->db->where("user_id", $id);

        $this->db->update("user_master", $data);

    }

    

    public function ajax_search_field_autocomplete($_s_key) {

        $searchKey = "%$_s_key%";

        return $this->db->select('t.user_id,t.name , t.last_name')

                        ->from("user_master as t")

                        ->where("t.name LIKE '$searchKey'")

                        ->get()

                        ->result_array();

    }

    

       public function get_search_result($_s_key, $_s_sort_by, $_s_order_by, $limit, $pageNumber) {

        $offset = ($pageNumber - 1) * $limit;

        $searchKey = "%$_s_key%";



        return $this->db->select('t.*')

                        ->from("user_master as t")

                        ->where("concat(t.name, ' ', t.last_name)  LIKE '$searchKey'")

                        ->order_by("$_s_sort_by", "$_s_order_by")

                        ->limit($limit)

                        ->offset($offset)

                        ->get()

                        ->result_array();

    }

    

      public function total_user_search_res($_s_key) {

        $searchKey = "%$_s_key%";

        return $this->db->select('t.*')

                        ->from("user_master as t")

                        ->where("concat(t.name, ' ', t.last_name) LIKE '$searchKey'")

                        ->count_all_results();

    }

    

      public function delete($id) {

        return $this->db->delete("user_master", array('user_id' => $id));

    }







}



?>