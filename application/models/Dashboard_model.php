<?php
class Dashboard_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	function validate($address)
	{
		$this->db->where('address', $address);
		//$this->db->where('zipcode', $zipcode);
		$query = $this->db->get('location_master'); 
		//echo $this->db->last_query();echo "<br/>";exit;
		//echo $query->num_rows();exit;
		if($query->num_rows() > 0)
		{
			return 1;
			
		}else{
			return 0;
		}
	}
	
	function updateqrcode($data, $qrcode_id){
		$this->db->where('qr_code_id', $qrcode_id);
		$res = $this->db->update('qr_code_master', $data);
		return $res;
	}
	
	function getBookingData($class_date,$timer1,$timer2){
		$qry = "select cm.*,bm.status as bookingstatus from class_master as cm,booking_master as bm where cm.class_date = '".$class_date."' and cm.timer1 = '".$timer1."' and cm.timer2 = '".$timer2."' and cm.class_id = bm.class_id and bm.status = 'booked'";
		$query = $this->db->query($qry);
        return $query->result();
	}
	
	function getViewBookingData($class_id){
		
		$this->db->select('bm.booking_id,bm.user_id,bm.qrcode_num,bm.status,bm.datetime,bm.points_used,cm.timer1,cm.timer2,cm.class_date,um.name,um.contact');
		$this->db->from('booking_master as bm');
		$this->db->join('user_master um', 'um.user_id = bm.booking_user_id', 'left');
		$this->db->join('class_master cm', 'cm.class_id = bm.class_id', 'left');
		$this->db->where('bm.class_id',$class_id);
		$this->db->order_by('bm.datetime','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result();
	}
	
	function getqrcodelisting(){
		
		$this->db->select('qrcode.*,gm.name,gm.address,gym_service.name as servicetype,ctm.name as classtype,um.email');
		$this->db->from('qr_code_master as qrcode');
		$this->db->join('gym_master gm', 'qrcode.user_id = gm.user_id', 'left');
		$this->db->join('user_master um', 'um.user_id = gm.user_id', 'left');
		$this->db->join('gym_service', 'qrcode.service_id = gym_service.service_id', 'left');
		$this->db->join('class_type_master as ctm', 'qrcode.class_id = ctm.class_type_id', 'left');
		$this->db->where('qrcode.user_id',$this->session->userdata('user_id'));
		$this->db->order_by("qrcode.qr_code_id", "DESC");
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result();
	}
	
	function getQrCodeDetail($booking_id){
		
		$this->db->select('qcm.qr_code_number,ctm.name as classtype,gm.address,qcm.class_point,qcm.qr_image');
		$this->db->from('qr_code_master qcm');
		$this->db->join('booking_master bm', 'bm.qrcode_num = qcm.qr_code_number');
		$this->db->join('gym_master gm', 'gm.user_id = qcm.user_id');
		$this->db->join('class_type_master ctm', 'ctm.class_type_id = gm.class_type_id');
		$this->db->where('bm.booking_id', $booking_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function getPrintQrCodeDetail($qr_code_id){
		
		$this->db->select('qcm.qr_code_number,ctm.name as classtype,gm.address,qcm.class_point,qcm.qr_image,qcm.qr_created_date');
		$this->db->from('qr_code_master qcm');
		$this->db->join('gym_master gm', 'gm.user_id = qcm.user_id');
		$this->db->join('class_type_master ctm', 'ctm.class_type_id = gm.class_type_id');
		$this->db->where('qcm.qr_code_id', $qr_code_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getTotalViews($user_id){
		$this->db->select('DISTINCT(booking_user_id)');
		$this->db->from('booking_master');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		//echo $this->db->last_query();echo "<br/>";
		return count($query->result());
	}
	
	function getQrcodestatus(){
		$this->db->select('*');
		$this->db->from('qr_code_master');
		$this->db->where('user_id', $this->session->userdata("user_id"));
		$this->db->where('qr_code_status', '1');
		$this->db->where('qr_image != ', '');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return count($query->result());
	}
	
	function getPayoutData($user_id){
		$this->db->select('gpc.*, p.id as payoutid, p.date as payoutdate, p.trasaction_id');
		$this->db->from('gym_point_chat as gpc');
		$this->db->join('payout as p', 'p.point_chat_id = gpc.chat_id', 'left');
		$this->db->where('gpc.user_id',$user_id);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		return $query->result();
	}
//Ramon[9/28/17]:: Added getBookingNumber function	
	public function getBookingsNumber($user_id){
		$this->db->from('booking_master');
		$this->db->where('user_id', $user_id);
		$this->db->where('status', 'confirmed');
		$query = $this->db->get();
		return $query->result();
	}
	
}
?>