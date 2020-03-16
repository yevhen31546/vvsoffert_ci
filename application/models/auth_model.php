<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Auth_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function get_user_by_email($email) {
        return $this->db->select('um.*')
                        ->select('ut.TypeName as GroupName,ut.Status GroupStatus')
                        ->from(TBL_USER_MASTER . " as um")
                        ->join(TBL_USER_TYPE . " as ut", "ut.UserTypeId=um.UserTypeId")
                        ->where('um.EmailId', $email)
                        ->where('um.Status <>', '3')
                        ->get()->row();
    }

    function get_user_by_userid($user_id) {
        return $this->db->select('um.*')
                        ->select('ut.TypeName as GroupName,ut.Status GroupStatus')
                        ->from(TBL_USER_MASTER . " as um")
                        ->join(TBL_USER_TYPE . " as ut", "ut.UserTypeId=um.UserTypeId")
                        ->where('um.UserId', $user_id)
                        ->where('um.Status <>', '3')
                        ->get()->row();
    }

    public function login_details($UserId) {
        $oUserList = $this->db->select('*')
                ->from(TBL_USER_LOGIN_TRACK)
                ->where('UserId', $UserId)
                ->order_by('LoginTime', 'DESC');
        return $this->create_pagination($oUserList);
    }

    public function get_subscription_request($id) {
        return $this->db->select('*')
                        ->from(TBL_NEWS_LETTER)
                        ->where('SubscriptionId', $id)
                        ->where('Status', '0')->get();
    }

    public function is_enquired($email) {
        $this->db->where('EmailId', $email);
        if ($this->db->count_all_results(TBL_PROVIDER_ENQUIRY)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_provider_biz_details($ProviderId) {
        return $this->db->select('pba.id,adm.*,pin.PCode,pin.Locality,pin.State')
                        ->from(TBL_PROVIDER_BUSINESS_ADDRESS . ' as pba')
                        ->join(TBL_ADDRESS_MASTER . ' as adm', 'pba.BusinessAddressId=adm.AddressId')
                        ->join(TBL_PINCODE_MASTER . ' as pin', 'pin.Id=adm.PostalCodeId', 'left')
                        ->where('pba.UserId', $ProviderId)
                        ->order_by('Locality', 'ASC')
                        ->get()
                        ->result_object();
    }

    public function get_provider_mobile_biz_details($ProviderId) {
        return $this->db->select('pba.id,adm.*,pin.PCode,pin.Locality,pin.State')
                        ->from(TBL_PROVIDER_BUSINESS_ADDRESS . ' as pba')
                        ->join(TBL_ADDRESS_MASTER . ' as adm', 'pba.BusinessAddressId=adm.AddressId')
                        ->join(TBL_PINCODE_MASTER . ' as pin', 'pin.Id=adm.PostalCodeId', 'left')
                        ->where('pba.UserId', $ProviderId)
                        ->where('adm.MobileStatus', '4')
                        ->order_by('Locality', 'ASC')
                        ->get()
                        ->result_array();
    }
    
    function get_provider_mobile_address_by_locality($ProviderId, $postal_code_id) {
        return $this->db->select('pba.id,adm.*,pin.PCode,pin.Locality,pin.State')
                        ->from(TBL_PROVIDER_BUSINESS_ADDRESS . ' as pba')
                        ->join(TBL_ADDRESS_MASTER . ' as adm', 'pba.BusinessAddressId=adm.AddressId')
                        ->join(TBL_PINCODE_MASTER . ' as pin', 'pin.Id=adm.PostalCodeId', 'left')
                        ->where('pba.UserId', $ProviderId)
                        ->where('adm.MobileStatus', '4')
                        ->where('adm.PostalCodeId', $postal_code_id)
                        ->order_by('Locality', 'ASC')
                        ->get()
                        ->result_array();
    }

    function get_voucher_details($voucher_id, $user_id) {
        return $this->db->select('vm.VoucherTitle as `VoucherTitle`, vm.VoucherCode as `VoucherCode`, vm.OriginalPrice as `OriginalPrice`,
                                  vm.SalePrice as `SalePrice`, vm.VoucherDescription as `VoucherDescription`, vm.ImageName as `ImageName`, 
                                  odt.DeliveryFName as `DeliveryFName`, odt.DeliverEmail as `DeliverEmail`, odt.IsCashVoucher as `IsCashVoucher`, 
                                  odt.IsGift as `IsGift`, odt.GiftMsgReceiverName as `GiftMsgReceiverName`, odt.GiftMsgSenderName as `GiftMsgSenderName`, 
                                  odt.GiftMessage as `GiftMessage`,cv.VoucherCreaterId as `VoucherCreaterId`,cv.RedeemedDate as `RedeemedDate`, cv.ExpiredOn as `ExpiredOn`, cv.UserVoucherCode as `UserVoucherCode`,vm.CircleImageName as `CircleImageName`,
                                  pm.TradingName as `TradingName`,pm.ContactNumber as `ContactNumber`,pm.ContactEmailId as `ContactEmailId`,pm.Website as `Website`,
                                  am.AddressLine1 as `AddressLine1`,am.CityName as `CityName`,am.StreetName as `StreetName`,am.StreetNumber as `StreetNumber`,pinm.Locality as `Locality`')
                        ->from(TBL_CUSTOMER_VOUCHER . ' as cv')
                        ->join(TBL_ORDER_DETAIL . ' as odt', 'odt.CustomerVoucherId=cv.CustomerVoucherId')
                        ->join(TBL_VOUCHER_MASTER . ' as vm', 'vm.VoucherId = cv.VoucherId')
                        ->join(TBL_USER_MASTER . ' as um', 'cv.UserId = um.UserId')
                        ->join(TBL_PROVIDER_MASTER . ' as pm', 'pm.UserId=cv.VoucherCreaterId', 'left')
                        ->join(TBL_ADDRESS_MASTER . ' as am', 'am.AddressId=pm.BusinessAddressId', 'left')
                        ->join(TBL_PINCODE_MASTER . ' as pinm', 'pinm.Id=am.PostalCodeId', 'left')
                        ->where('cv.CustomerVoucherId', $voucher_id)
                        ->where('cv.UserId', $user_id)->get();
    }

}
