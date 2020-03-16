<?php
class MY_Form_validation extends CI_Form_validation {

    public function __construct()
    {
        parent::__construct();		
    }
	
	// Check value is exist in database.
    public function is_avail($str, $field)
    {
		$CI =& get_instance();
        $CI->form_validation->set_message('is_avail', '%s not exists.');
		
		list($table, $column) = explode('.', $field, 2);
		
		$query = $CI->db->query("SELECT COUNT(*) AS dupe FROM $table WHERE $column = '$str'");
		$row = $query->row();
		return ($row->dupe == 1) ? TRUE : FALSE;
    }
	
	// Valid Phone No.
	public function valid_phoneno($str, $field)
	{
		$CI =& get_instance();
        $CI->form_validation->set_message('valid_phoneno', '%s has to be a number between 8 - 10 digit.');	
		if(!preg_match('/^[0-9]{8,10}$/', $str)) {
			return false;
		}
		else
		{
			return true;
		}
	}
	
	// Valid Password
	public function valid_password($str, $field)
	{
		$CI =& get_instance();
        $CI->form_validation->set_message('valid_password', '%s has to be a number, a letter or one of the following: !@#$%');	
		if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]+$/', $str)) {
			return false;
		}
		else
		{
			return true;
		}
	}
	
	// Valid URL
	public function valid_website($str, $field)
	{
		$CI =& get_instance();
        $CI->form_validation->set_message('valid_website', '%s is not valid URL');	
		
		$str = parse_url($str);		
		if(isset($str['host']))
			$url = "http://".$str['host'];
		else
			$url = "http://".$str['path'];
		
		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			echo 'true';
		} else {
			return false;
		}	
	}
	
	// Edit Unique 
	public function edit_unique($value, $params)  {
		$CI =& get_instance();
		$CI->load->database();
	
		$CI->form_validation->set_message('edit_unique', "Sorry, that %s is already being used.");
	
		list($table, $field, $current_id) = explode(".", $params);
	
		$query = $CI->db->select()->from($table)->where($field, $value)->limit(1)->get();
	
		if ($query->row() && $query->row()->id != $current_id)
		{
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	// Valid password
	public function _valid_password($str)
	{
		
		$ci->form_validation->set_message('_valid_password', '%s has to be a number, a letter or one of the following: !@#$%');
		if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]+$/', $str)) {
			return false;
		}
		else
		{
			return true;
		}
	}

}
?>