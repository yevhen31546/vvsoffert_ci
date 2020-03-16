<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//
///**
// * CodeIgniter Array Helpers
// *
// * @package        CodeIgniter
// * @subpackage    Helpers
// * @category    Helpers
// * @author        EllisLab Dev Team
// * @link        http://codeigniter.com/user_guide/helpers/array_helper.html
// */
////current url

//************use in vvsoffer project**********
function lookupProduct($keyword,$limit=10,$start=0){ 
        $ci = & get_instance();
        $ci->db->select('pro.*,cat.name as category1,manu.name as manufacturer_name'); 
        $ci->db->from('products as pro');
        $ci->db->join('categories as cat','pro.category1 = cat.id', 'LEFT JOIN');
        $ci->db->join('manufacturer as manu', 'pro.Manufacturer = manu.id', 'LEFT JOIN');
        $ci->db->like('pro.Name',$keyword); 
        $ci->db->or_like('pro.RSKnummer',$keyword); 
        $ci->db->limit($limit,$start);
        $query = $ci->db->get();     
        return $query->result(); 
    } 
function lookupCategory($keyword,$limit=10,$start=0){ 
        $ci = & get_instance();
        $ci->db->select('*'); 
        $ci->db->from('categories');
        $ci->db->like('name',$keyword);  
        $ci->db->limit($limit,$start);
        $query = $ci->db->get();     
        return $query->result(); 
    } 
function countProductByManufacturer($id){ 
    $ci = & get_instance();
    $sql = "SELECT id From products WHERE Manufacturer=" . $id;
    $query = $ci->db->query($sql);
    return $query->num_rows();
}
function lookupManufacturer($keyword,$limit=10,$start=0){ 
        $ci = & get_instance();
        $ci->db->select('*'); 
        $ci->db->from('manufacturer');
        $ci->db->like('name',$keyword);  
        $ci->db->where('status','true');  
        $ci->db->limit($limit,$start);
        $query = $ci->db->get();     
        return $query->result(); 
    } 
    function get_by_where($search,$single = false)
    {
         $ci = & get_instance();
        $ci->db->where($search);
		if($single)
	        return $ci->db->get('user_master')->first_row();
		else
			return $ci->db->get('user_master')->result();
    }
function getuserdata(){
	$ci = & get_instance();
    $ci->db->select('*');
    $ci->db->from('user_master');
    $ci->db->where('email', $ci->session->userdata('email'));
    $role_data_query = $ci->db->get();
    $role_data = $role_data_query->row();
    return $role_data_query->result();
}
function getjoinlist_product($list_id){
	$ci = & get_instance();
	$ci->db->select('lmp.id as list_master_pro_id,manu.name as manufacturer_name,cat.name as category1_name,pro.*');
	$ci->db->from('list_master_product as lmp');
	$ci->db->join('products as pro', 'lmp.product_id = pro.id', 'LEFT JOIN');
	$ci->db->join('manufacturer as manu', 'pro.Manufacturer = manu.id', 'LEFT JOIN');
	$ci->db->join('categories as cat', 'pro.category1 = cat.id', 'LEFT JOIN');
	$ci->db->where('lmp.list_id', $list_id);
	$query = $ci->db->get();
	//echo $ci->db->last_query();echo "<br/>";
	return $query->result();
}
function delete_product_from_user_list($id) {
    $ci = & get_instance();
        $ci->db->delete('list_master_product', array('id' => $id));
    }
function getListdata($ary,$tablename,$orderbyField="",$order_by="",$limit="",$start=0){
	$ci = & get_instance();
	$ci->db->where($ary);
	$ci->db->order_by($orderbyField,$order_by);
	$ci->db->limit($limit,$start);
	$query = $ci->db->get($tablename);
	#echo $ci->db->last_query();#exit;
	return $query->result();
}

function savedata($tablename,$dataArray){
	$ci = & get_instance();
	$ci->db->insert($tablename, $dataArray);
	//echo $ci->db->last_query();exit;
	$insert_id = $ci->db->insert_id();
	return $insert_id;
}

function updatedata($tablename,$dataArray,$column){
	$ci = & get_instance();
	$query = $ci->db->update($tablename,$dataArray,$column);
	//echo $ci->db->last_query();exit;
	return 1;
}
function update($id, $data, $tablename)
    {
    $ci = & get_instance();
        $ci->db->where($this->id, $id);
        $ci->db->update($tablename, $data);
    }
//function currentUrl() {
//    $CI = & get_instance();
//
//    $url = $CI->config->site_url($CI->uri->uri_string());
//    return $_SERVER['QUERY_STRING'] ? $url . '?' . $_SERVER['QUERY_STRING'] : $url;
//}
//
////Function for encrypt string
//function encrypt_string($thetext) {
//    $uniqid = uniqid();
//    $output = $uniqid . "$#$" . $thetext;
//    $output = base64_encode($output);
//    $output = urlencode($output);
//    return $output;
//}
//
////Function for decrypt string
//function decrypt_string($thetext) {
//    $output = base64_decode(urldecode($thetext));
//    $output = explode("$#$", $output);
//    return $output[1];
//}
//
////Function for use print_r and echo while debuging
//function pr($array = "", $exit = true) {
//    echo "<pre>";
//    print_r($array);
//    if ($exit == true) {
//        exit;
//    }
//}
//
////Function for generate random number
//if (!function_exists('generate_random_number')) {
//
//    function generate_random_number($tablename, $fieldname, $length = 8) {
//        $random = rand(pow(10, $length - 1), pow(10, $length) - 1);
//
//        //get main CodeIgniter object
//        $ci = & get_instance();
//
//        //load databse library
//        $ci->load->database();
//
//        //get data from database
//        $query = $ci->db->get_where($tablename, array($fieldname => $random));
//
//        $result = $query->result_array();
//        if (count($result) > 0) {
//            return generate_random_number($tablename, $fieldname, $length);
//        } else {
//            return $random;
//        }
//    }
//
//}
//
////Function for generate otp token
//function generate_OTP_token($length = 8) {
//    $random = rand(pow(10, $length - 1), pow(10, $length) - 1);
//    return $random;
//}
//
////Function for create new password
//function create_new_password($length = 8) {
//    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
//    $random_password = '';
//    for ($i = 0; $i < $length; $i++) {
//        $random_password .= $characters[rand(0, strlen($characters) - 1)];
//    }
//    return $random_password;
//}
//
////Function for rendering view dynamically
//function render_page($view, $data = null, $render = false) {
//    $ci = & get_instance();
//
//    $ci->viewdata = (empty($data)) ? $ci->data : $data;
//
//    $view_html = $ci->load->view($view, $ci->viewdata, $render);
//
//    if (!$render)
//        return $view_html;
//}
//
////To generate random password
//function randr($j = 8) {
//    $string = "";
//    for ($i = 0; $i < $j; $i++) {
//        srand((double) microtime() * 1234567);
//        $x = mt_rand(0, 2);
//        switch ($x) {
//            case 0:
//                $string .= chr(mt_rand(97, 122));
//                break;
//            case 1:
//                $string .= chr(mt_rand(65, 90));
//                break;
//            case 2:
//                $string .= chr(mt_rand(48, 57));
//                break;
//        }
//    }
//    return strtoupper($string);
//}
//
//function custrandr() {
//  $string = "";
//  $string .= chr(mt_rand(65, 90));
//  $string .= chr(mt_rand(65, 90));
//  $string .= chr(mt_rand(65, 90));
//  $string .= chr(mt_rand(48, 57));
//  return strtoupper($string);
//}
//
///*function getdata($table, $field_value, $id) {
//    //get main CodeIgniter object
//    $ci = & get_instance();
//    return $ci->db->get_where($table, array($field_value => $id))->row();
//}*/
//function getData($table, $array = Array(), $field = ""){
//  //get main CodeIgniter object
//  $ci = & get_instance();
//	$result = $ci->db->get_where($table, $array, $field)->row();
//	#echo $ci->db->last_query()."<br>";
//	return $result;
//}
//
//function get_result($table, $array = Array(), $field = "") {
//    //get main CodeIgniter object
//    $ci = & get_instance();
//    return $ci->db->get_where($table, $array, $field)->result();
//}
//
////Function for get ratio
//function getRatio($item, $totalItem) {
//    if ($item > 0 && $totalItem > 0) {
//        return round((($item / $totalItem) * 100), 2);
//    } else {
//        return 0;
//    }
//}
//
////Function for total items based on parameter
//function getTotalItem($date, $param, $totalItem) {
//    $month = date("m", strtotime($date));
//    $year = date("Y", strtotime($date));
//
//    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
//
//    switch ($param) {
//        case "day":
//            if ($totalItem > 0) {
//                return round($totalItem / $daysInMonth);
//            } else {
//                return 0;
//            }
//            break;
//        case "week":
//            if ($totalItem > 0) {
//                return round($totalItem / 4);
//            } else {
//                return 0;
//            }
//            break;
//    }
//}
//
//function getTotalItems($date, $param, $totalItem) {
//
//    $dateArray = explode("-", $date);
//    $month = $dateArray[1];
//    $year = $dateArray[0];
//
//    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
//
//    switch ($param) {
//        case "day":
//            if ($totalItem > 0) {
//                return round($totalItem / $daysInMonth);
//            } else {
//                return 0;
//            }
//            break;
//        case "week":
//            if ($totalItem > 0) {
//                return round($totalItem / 4);
//            } else {
//                return 0;
//            }
//            break;
//    }
//}
//
//function dateDiffInMinutes($startdate, $enddate) {
//    $start_date = strtotime($startdate);
//    $end_date = strtotime($enddate);
//    $interval = abs($end_date - $start_date);
//    $minutes = round($interval / 60);
//    return $minutes;
//}
//
//function convertToHoursMins($time) {
//    if ($time < 1) {
//        return;
//    }
//    $hours = floor($time / 60);
//    $minutes = ($time % 60);
//    return $hours . ":" . $minutes;
//}
//
//function humanTiming($time) {
//
//    $time = time() - $time; // to get the time since that moment
//    $time = ($time < 1) ? 1 : $time;
//    $tokens = array(
//        31536000 => 'year',
//        2592000 => 'month',
//        604800 => 'week',
//        86400 => 'day',
//        3600 => 'hour',
//        60 => 'minute',
//        1 => 'second'
//    );
//
//    foreach ($tokens as $unit => $text) {
//        if ($time < $unit)
//            continue;
//        $numberOfUnits = floor($time / $unit);
//        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
//    }
//}
//
////Function for set table prefix as selected language
//function set_table_prefix() {
//    $ci = & get_instance();
//    $ci->load->helper('language');
//    $siteLang = $ci->session->userdata('site_lang');
//    $lang = ($ci->session->userdata('site_lang') != "") ? $ci->session->userdata('site_lang') : "US";
//    switch ($lang) {
//        case "US":
//            return "eng_";
//            break;
//        case "SE":
//            return "swe_";
//            break;
//    }
//}
//
//function random_color_part() {
//    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
//}
//
//function random_color() {
//    return random_color_part() . random_color_part() . random_color_part();
////    echo random_color();
//}
//
//function getDaysFromDates($startDate, $endDate) {
//
//
//    $date1 = strtotime($startDate . " 0:00:00");
//    $date2 = strtotime($endDate . " 23:59:59");
//    $res = (int) (($date2 - $date1) / 86400);
//
//    return $res;
//}
//
//function progressBar($from, $total) {
//    $ratio = ($from / $total) * 100;
//    return $ratio . "%";
//}
//
//function foldersize($path) {
//    $total_size = 0;
//    $files = @scandir($path);
//    $cleanPath = rtrim($path, '/') . '/';
//
//    if (count($files) > 2) {
//        foreach ($files as $t) {
//            if ($t <> "." && $t <> "..") {
//                $currentFile = $cleanPath . $t;
//                if (is_dir($currentFile)) {
//                    $size = foldersize($currentFile);
//                    $total_size += $size;
//                } else {
//                    $size = filesize($currentFile);
//                    $total_size += $size;
//                }
//            }
//        }
//    }
//    return $total_size;
//}
//
//function imageToBase64Conversion($path) {
//    $type = pathinfo($path, PATHINFO_EXTENSION);
//    $username = "petarbojkovic521@gmail.com";
//    $password = "@1\$admin";
//    $arrContextOptions = array(
//        "ssl" => array(
//            "verify_peer" => false,
//            "verify_peer_name" => false,
//        ),
//        'http' => array(
//            'header' => "Authorization: Basic " . base64_encode("$usernamepassword")
//        )
//    );
//
//    $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
//    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
//    return $base64;
//}
//
//
//// time zone terms
//function decimalHours($h, $m) {
//    return ($h + ($m / 60) + ('00' / 3600));
//}
//
//function datum($datum = true, $format, $time) {
//    $ci = & get_instance();
//    $tz = $ci->session->userdata('timezonediff');
//    $sign = $tz['a'];
//    $h = decimalHours($tz['b'], $tz['c']);
//    //echo $h." ".$sign;
//    //$sign = $sign; // Whichever direction from GMT to your timezone. + or -
//    //$h = $h; // offset for time (hours)
//    $dst = true; // true - use dst ; false - don't
//    if ($dst == true) {
//        $daylight_saving = date('I');
//        if ($daylight_saving) {
//            if ($sign == "-") {
//                $h = $h - 1;
//            } else {
//                $h = $h + 1;
//            }
//        }
//    }
//    $hm = $h * 60;
//    $ms = $hm * 60;
//    if ($sign == "-") {
//        $timestamp = $time - ($ms);
//    } else {
//        $timestamp = $time + ($ms);
//    }
//    $gmdate = gmdate($format, $timestamp);
//    if ($datum == true) {
//        return $gmdate;
//    } else {
//        return $timestamp;
//    }
//}
//
//function getRoletype($role_id) {
//    $ci = & get_instance();
//    $ci->db->select('type');
//    $ci->db->from('role_master');
//    $ci->db->where('role_id', $role_id);
//    $role_data_query = $ci->db->get();
//    $role_data = $role_data_query->row();
//    return $role_data->type;
//}
//

//
//
//function gettemplate($id){
//	
//	$ci = & get_instance();
//    $ci->db->select('*');
//    $ci->db->from('email_template');
//    $ci->db->where('template_id', $id);
//    $data_query = $ci->db->get();
//    $data = $data_query->row();
//    return $data_query->result();
//}
//
//function getProfileimageById($user_id){
//	
//	$ci = & get_instance();
//    $ci->db->select('profilepic');
//    $ci->db->from('user_master');
//    $ci->db->where('user_id', $user_id);
//    $data_query = $ci->db->get();
//    $data = $data_query->row();
//    return $data_query->result();
//}
//
//function sendmail($email,$subject,$html){
//	
//	$ci = & get_instance();
//	$headers = 'MIME-Version: 1.0' . "\r\n";
//	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//	// Create email headers
//	$from = $ci->config->item('client_email');
//	$headers .= 'From: ' . $from . "\r\n" .
//			'Reply-To: ' . $from . "\r\n" .
//			'X-Mailer: PHP/' . phpversion();
//	$result = mail($email, $subject, $html, $headers);	
//}
//
//function getClassRating($gym_id){
//	$ci = & get_instance();
//	#$qry = "SELECT avg(rating) as rating FROM gym_rating WHERE gym_id = ".$gym_id;
//	$qry = "SELECT avg(rating) as rating FROM (SELECT avg(rating) as rating FROM gym_rating WHERE gym_id = $gym_id GROUP BY user_id) as gymrating";
//	$query = $ci->db->query($qry);
//	$result = $query->result();
//	if(NULL != $result[0]->rating){
//		return $result[0]->rating;
//	}
//	else{
//		return 0;
//	}
//	
//	/*$ci->db->select('rating');
//	$ci->db->from('gym_rating');
//	$ci->db->where('gym_id',$gym_id);
//	//echo $ci->db->last_query();exit;
//	$query = $ci->db->get();
//	$result = $query->result();
//	$num_rows = count($query->result());
//	$rating = 0;
//	if($num_rows > 0){
//		foreach($result as $row) {
//			$rating += $row->rating;
//		}
//		$totalrating = $rating/$num_rows;
//		return $totalrating;
//	}
//	else{
//		return 0;
//	}*/
//}
//
//function getGymdata(){
//	$ci = & get_instance();
//	$ci->db->select('gm.*,sm.name as servicename,sm.image as serviceimage');
//	$ci->db->from('gym_master as gm');
//	$ci->db->join('gym_service as sm', 'sm.service_id = gm.service_id', 'RIGHT JOIN');
//	$ci->db->where('gm.user_id', $ci->session->userdata("user_id"));
//	$query = $ci->db->get();
//	//echo $ci->db->last_query();echo "<br/>";
//	return $query->result();
//}
//
//function getListdata($ary,$tablename,$orderbyField="",$order_by="",$limit="",$start=0){
//	$ci = & get_instance();
//	$ci->db->where($ary);
//	$ci->db->order_by($orderbyField,$order_by);
//	$ci->db->limit($limit,$start);
//	$query = $ci->db->get($tablename);
//	#echo $ci->db->last_query();#exit;
//	return $query->result();
//}
//
//function savedata($tablename,$dataArray){
//	$ci = & get_instance();
//	$ci->db->insert($tablename, $dataArray);
//	//echo $ci->db->last_query();exit;
//	$insert_id = $ci->db->insert_id();
//	return $insert_id;
//}
//
//function updatedata($tablename,$dataArray,$column){
//	$ci = & get_instance();
//	$query = $ci->db->update($tablename,$dataArray,$column);
//	//echo $ci->db->last_query();exit;
//	return 1;
//}
//
//function getRemainPoints(){
//	$ci = & get_instance();
//    $ci->db->select('*');
//    $ci->db->from('user_master');
//    $ci->db->where('user_id', $ci->session->userdata('user_id'));
//    $data_query = $ci->db->get();
//    $data = $data_query->row();
//    return $data_query->result();
//}
//
//function getGymUserPointsnValue(){
//	$ci = & get_instance();
//  $ci->db->select('*');
//  $ci->db->from('gym_point_master');
//  $ci->db->where('user_id', $ci->session->userdata('user_id'));
//  $data_query = $ci->db->get();
//  $data = $data_query->row();
//  return $data_query->result();
//}
//
//function currentCashoutPercent(){
//	$ci = & get_instance();
//    $ci->db->select('amount');
//    $ci->db->from('gym_markup_master');
//    $ci->db->where('markup_id', '1');
//    $data_query = $ci->db->get();
//    $data = $data_query->row();
//	return $data_query->result()[0]->amount;
//	
//}
//
//function getZipcode($address){
//		if(!empty($address)){
//			//Formatted address
//			$formattedAddr = str_replace(' ','+',$address);
//			//Send request and receive json data by address
//			$geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false'); 
//			$output1 = json_decode($geocodeFromAddr);
//			//Get latitude and longitute from json data
//			$latitude  = $output1->results[0]->geometry->location->lat; 
//			$longitude = $output1->results[0]->geometry->location->lng;
//			//Send request and receive json data by latitude longitute
//			$geocodeFromLatlon = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=true_or_false');
//			$output2 = json_decode($geocodeFromLatlon);
//			if(!empty($output2)){
//				$addressComponents = $output2->results[0]->address_components;
//				foreach($addressComponents as $addrComp){
//					if($addrComp->types[0] == 'postal_code'){
//						//Return the zipcode
//						return $addrComp->long_name;
//					}
//				}
//				return false;
//			}else{
//				return false;
//			}
//		}else{
//			return false;   
//		}
//	}
//
//function contactReplyEmail($email,$subject,$html){
//	
//	$ci = & get_instance();
//	$headers = 'MIME-Version: 1.0' . "\r\n";
//	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//	// Create email headers
//	$from = $ci->config->item('client_email');
//	$headers .= 'From: ' . $from . "\r\n" .
//		    'Cc: info@hopperfit.com' . "\r\n" .
//			'Reply-To: ' . $from . "\r\n" .
//			'X-Mailer: PHP/' . phpversion();
//	$result = mail($email, $subject, $html, $headers);	
//}

?>
