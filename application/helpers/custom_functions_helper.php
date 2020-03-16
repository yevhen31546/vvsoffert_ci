<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PHPImageWorkshop\ImageWorkshop as ImageWorkshop;

//use Carbon\Carbon;

/*
 * Print Recursive
 *
 * Simply wraps a print_r() in pre tags for debugging.
 *
 * @param mixed
 * @return string
 */

if (!function_exists('_lastsql')) {

    function _lastsql($echo = TRUE) {
        $ci = &get_instance();
        if ($echo) {
            echo $ci->db->last_query();
        } else {
            return $ci->db->last_query();
        }
    }

}

/*
 * Print Recursive
 *
 * Simply wraps a print_r() in pre tags for debugging.
 *
 * @param mixed
 * @return string
 */
if (!function_exists('_pr')) {

    function _pr($a) {
        echo "<pre>";
        print_r($a);
        echo "</pre>";
    }

}

// ------------------------------------------------------------------------

/*
 * Variable Dump
 *
 * Simply wraps a var_dump() in pre tags for debugging.
 *
 * @param mixed
 * @return string
 */
if (!function_exists('_vd')) {

    function _vd($a) {
        echo "<pre>";
        var_dump($a);
        echo "</pre>";
    }

}

// ------------------------------------------------------------------------

/*
 * Array to Object
 * 
 * Converts an array to an object
 *
 * @param array
 * @return object
 */
if (!function_exists('array_to_object')) {

    function array_to_object($array) {
        $Object = new stdClass();
        foreach ($array as $key => $value) {
            $Object->$key = $value;
        }

        return $Object;
    }

}

// ------------------------------------------------------------------------

/*
 * Object to Array
 * 
 * Converts an object to an array
 * 
 * @param object
 * @return array
 */
if (!function_exists('object_to_array')) {

    function object_to_array($Object) {
        $array = get_object_vars($Object);

        return $array;
    }

}

// ------------------------------------------------------------------------

/*
 * Is Ajax
 *
 * Returns true if request is ajax protocol
 *
 * @return bool
 */
if (!function_exists('is_ajax')) {

    function is_ajax() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }

}

// ------------------------------------------------------------------------

/*
 * Image Thumb
 *
 * Creates an image thumbnail and caches the image
 *
 * @param string
 * @param int
 * @param int
 * @param bool
 * @param array
 * @return string
 */
if (!function_exists('image_thumb')) {

    function image_thumb($source_image, $width = 0, $height = 0, $crop = FALSE, $props = array()) {
        $CI = & get_instance();
        $CI->load->library('image_cache');

        $props['source_image'] = '/' . str_replace(base_url(), '', $source_image);
        $props['width'] = $width;
        $props['height'] = $height;
        $props['crop'] = $crop;

        $CI->image_cache->initialize($props);
        $image = $CI->image_cache->image_cache();
        $CI->image_cache->clear();

        return $image;
    }

}

// ------------------------------------------------------------------------

/*
 * BR 2 NL
 *
 * Converts html <br /> to new line \n
 *
 * @param string
 * @return string
 */
if (!function_exists('br2nl')) {

    function br2nl($text) {
        return preg_replace('/<br\\s*?\/??>/i', '', $text);
    }

}

// ------------------------------------------------------------------------

/*
 * Option Array Value
 *
 * Returns single dimension array from an Array of objects with the key and value defined
 *
 * @param array
 * @param string
 * @param string
 * @param array
 * @return array
 */
if (!function_exists('option_array_value')) {

    function option_array_value($object_array, $key, $value, $default = array()) {
        $option_array = array();

        if (!empty($default)) {
            $option_array = $default;
        }

        foreach ($object_array as $Object) {
            $option_array[$Object->$key] = $Object->$value;
        }

        return $option_array;
    }

}

// ------------------------------------------------------------------------

/*
 * In URI
 *
 * Checks if current uri segments exist in array of uri strings
 *
 * @param string or array
 * @param string
 * @param bool
 * @return bool
 */
if (!function_exists('in_uri')) {

    function in_uri($uri_array, $uri = null, $array_keys = FALSE) {
        if (!is_array($uri_array)) {
            $uri_array = array($segments);
        }

        $CI = & get_instance();

        if (!empty($uri)) {
            $uri_string = '/' . trim($uri, '/');
        } else {
            $uri_string = '/' . trim($CI->uri->uri_string(), '/');
        }

        $uri_array = ($array_keys) ? array_keys($uri_array) : $uri_array;

        foreach ($uri_array as $string) {
            if (strpos($uri_string, ($string != '') ? '/' . trim($string, '/') : ' ') === 0) {
                return true;
            }
        }

        return false;
    }

}

// ------------------------------------------------------------------------

/*
 * Theme Partial
 *
 * Load a theme partial
 *
 * @param string
 * @param array
 * @param bool
 * @return string
 */
if (!function_exists('theme_partial')) {

    function theme_partial($view, $vars = array(), $return = TRUE) {
        $CI = & get_instance();
        $CI->load->library('parser');
        return $CI->parser->parse_string($CI->load->theme($CI->template->theme . '/views/partials/' . trim($view, '/'), $vars, $return, $CI->template->theme_path), $vars, $return);
    }

}

// ------------------------------------------------------------------------

/*
 * Theme Url
 *
 * Create a url to the current theme
 *
 * @param string
 * @return string
 */
if (!function_exists('theme_url')) {

    function theme_url($uri = '') {
        $CI = & get_instance();
        return base_url($CI->template->theme_path . '/' . $CI->template->theme . '/' . trim($uri, '/'));
    }

}


// ------------------------------------------------------------------------

/*
 * Domain Name
 *
 * Returns the site domain name and tld
 *
 * @return string
 */
if (!function_exists('domain_name')) {

    function domain_name() {
        $CI = & get_instance();

        $info = parse_url($CI->config->item('base_url'));
        $host = $info['host'];
        $host_names = explode(".", $host);
        return $host_names[count($host_names) - 2] . "." . $host_names[count($host_names) - 1];
    }

}

// ------------------------------------------------------------------------

/*
 * Glob Recursive
 *
 * Run glob function recursivley on a directory
 *
 * @param string
 * @return array
 */
if (!function_exists('glob_recursive')) {

    // Does not support flag GLOB_BRACE

    function glob_recursive($pattern, $flags = 0) {
        $files = glob($pattern, $flags);

        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, glob_recursive($dir . '/' . basename($pattern), $flags));
        }

        return $files;
    }

}

// ------------------------------------------------------------------------

/*
 * URL Base64 Encode
 * 
 * Encodes a string as base64, and sanitizes it for use in a CI URI.
 * 
 * @param string
 * @return string
 */
if (!function_exists('url_base64_encode')) {

    function url_base64_encode(&$str = "") {
        return strtr(
                base64_encode($str), array(
            '+' => '.',
            '=' => '-',
            '/' => '~'
                )
        );
    }

}

// ------------------------------------------------------------------------

/*
 * URL Base64 Decode
 *
 * Decodes a base64 string that was encoded by ci_base64_encode.
 * 
 * @param string
 * @return string
 */
if (!function_exists('url_base64_decode')) {

    function url_base64_decode(&$str = "") {
        return base64_decode(strtr(
                        $str, array(
            '.' => '+',
            '-' => '=',
            '~' => '/'
                        )
        ));
    }

}

// ------------------------------------------------------------------------

/*
 * Output XML
 *
 * Sets the header content type to XML and
 * outputs the <?php xml tag
 * 
 * @param string
 * @return string
 */
if (!function_exists('xml_output')) {

    function xml_output() {
        $CI = & get_instance();
        $CI->output->set_content_type('text/xml');
        $CI->output->set_output("<?xml version=\"1.0\"?>\r\n");
    }

}

// ------------------------------------------------------------------------

/*
 * JS Head Start
 *
 * Starts output buffering to place javascript in the <head> of the template
 * 
 * @return void
 */
if (!function_exists('js_start')) {

    function js_start() {
        ob_start();
    }

}

// ------------------------------------------------------------------------

/*
 * JS Head End
 *
 * Ends output buffering to place javascript in the <head> of the template
 * 
 * @return void
 */
if (!function_exists('js_end')) {

    function js_end($location = "_footer_js_script") {
        $CI = & get_instance();
        $js = ob_get_contents();
        $CI->template->set($location, $js);
        ob_end_clean();
    }

}
// ------------------------------------------------------------------------
/*
 * Digest password
 *
 * This function return the encrypted val of supplied value
 * 
 * @param string
 * @return string
 */
if (!function_exists('decode_id')) {

    function decode_id($id) {
        return $id == '' ? '' : base64_decode($id);
    }

}
// ------------------------------------------------------------------------
/*
 * Digest password
 *
 * This function return the encrypted val of supplied value
 * 
 * @param string
 * @return string
 */
if (!function_exists('encode_id')) {

    function encode_id($id) {
        return base64_encode($id);
    }

}
// ------------------------------------------------------------------------
/*
 * Digest password
 *
 * This function return the encrypted val of supplied value
 * 
 * @param string
 * @return string
 */
if (!function_exists('digest_password')) {

    function digest_password($password) {
        return md5($password);
    }

}
// ------------------------------------------------------------------------

/*
 * String to Boolean
 *
 * This function analyzes a string and returns false if the string is empty, false, or 0
 * and true for everything else
 * 
 * @param string
 * @return bool
 */
if (!function_exists('str_to_bool')) {

    function str_to_bool($str) {
        if (is_bool($str)) {
            return $str;
        }

        $str = (string) $str;

        if (in_array(strtolower($str), array('false', '0', ''))) {
            return false;
        } else {
            return true;
        }
    }

}

// ------------------------------------------------------------------------

/*
 * Is Inline Editable
 *
 * Returns true if inline editing is enabled, admin toolbar is enabled, and user is an administrator
 *
 * @return bool
 */
if (!function_exists('is_inline_editable')) {

    function is_inline_editable($content_type_id = null) {
        $CI = & get_instance();
        $CI->load->model('content_types_model');

        if ($CI->settings->enable_inline_editing && $CI->settings->enable_admin_toolbar && $CI->secure->group_types(array(ADMINISTRATOR))->is_auth()) {
            if (empty($content_type_id)) {
                return TRUE;
            }

            if ($CI->Group_session->type != SUPER_ADMIN) {
                // Check if we have already cached permissions for this content type
                if (!isset($CI->content_types_model->has_permission_cache[$content_type_id])) {
                    $Content_types_model = new Content_types_model();

                    // No permission for this content type has been cached yet.
                    // Query to see if current user has permission to this content type
                    $Content_type = $Content_types_model->group_start()
                            ->where('restrict_admin_access', 0)
                            ->or_where_related('admin_groups', 'group_id', $CI->Group_session->id)
                            ->group_end()
                            ->get_by_id($content_type_id);

                    $CI->content_types_model->has_permission_cache[$content_type_id] = ($Content_type->exists()) ? TRUE : FALSE;
                }

                return $CI->content_types_model->has_permission_cache[$content_type_id];
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

}

function user_avatar_image($type, $UserId = NULL) {
    
    $img_size = array(
        'preview' => '249x243/EFEFEF/AAAAAA&amp;text=no+image',
        'thumb' => '249x243/EFEFEF/AAAAAA&amp;text=no+image',
        'small' => '29x29/EFEFEF/AAAAAA&amp;text=29x29'
    );
    $CI = &get_instance();
    if (!is_null($UserId)) {
        $ProfileImage = $CI->auth_model->get_ProfileImage_from_user_master(array('UserId' => $UserId));
    } else {
        $ProfileImage = $CI->auth->get_user_session('ProfileImage');
    }
    if ($ProfileImage == '') {
        if ($type == 'small') {
            return '<img src = "' . base_url("assets/images/{$type}_user.png") . '" alt = "">';
        } else {
            return '<img src = "' . base_url("assets/images/{$type}_user.png") . '" alt = "">';
        }
    }
    if ($type == '') {
        $img = $ProfileImage;
    } else {
        $img = "{$type}_{$ProfileImage}";
    }
    if (getimagesize(base_url("assets/upload/user_avatar/$img")) !== false){
       return '<img src="' . base_url("assets/upload/user_avatar/$img") . '">';
    }else{
       return '<img src="' . base_url("themes/backend/img/avatar3_small.jpg") . '">';
    }
//    return '<img src="' . base_url("assets/upload/user_avatar/$img") . '">';
}

function user_avatar_image_src($type, $UserId = NULL) {
    $img_size = array(
        'preview' => '249x243/EFEFEF/AAAAAA&amp;text=no+image',
        'thumb' => '249x243/EFEFEF/AAAAAA&amp;text=no+image',
        'small' => '29x29/EFEFEF/AAAAAA&amp;text=29x29'
    );
    $CI = &get_instance();
    if (!is_null($UserId)) {
        $ProfileImage = $CI->auth_model->get_ProfileImage_from_user_master(array('UserId' => $UserId));
    } else {
        $ProfileImage = $CI->auth->get_user_session('ProfileImage');
    }
    if ($ProfileImage == '') {
        if ($type == 'small') {
            return theme_url('images') . '/account_black.png';
        } else {
            return base_url("assets/images/{$type}_user.png"); //"http://www.placehold.it/" . $img_size[$type];
        }
    }

    if ($type == '') {
        $img = $ProfileImage;
    } else {
        $img = "{$type}_{$ProfileImage}";
    }
    return base_url("assets/upload/user_avatar/$img");
}

function user_avatar_image_src_ticket($type, $UserId = NULL) {
    $img_size = array(
        'preview' => '249x243/EFEFEF/AAAAAA&amp;text=no+image',
        'thumb' => '249x243/EFEFEF/AAAAAA&amp;text=no+image',
        'small' => '29x29/EFEFEF/AAAAAA&amp;text=29x29'
    );
    $CI = &get_instance();
    if (!is_null($UserId)) {
        $ProfileImage = $CI->auth_model->get_ProfileImage_from_user_master(array('UserId' => $UserId));
    } else {
        $ProfileImage = $CI->auth->get_user_session('ProfileImage');
    }
    if ($ProfileImage == '') {
        return theme_url('images') . '/ticket_acnt_blnk.png';
    }

    if ($type == '') {
        $img = $ProfileImage;
    } else {
        $img = "{$type}_{$ProfileImage}";
    }
    return base_url("assets/upload/user_avatar/$img");
}

function get_provider_information($user_id) {
    $CI = &get_instance();
    return $CI->db->select('*')
                    ->from(TBL_PROVIDER_MASTER)
                    ->where('UserId', $user_id)->get()->row_array();
}

function voucher_image($type, $ImageName = NULL) {
    return '<img src="' . voucher_image_src($type, $ImageName) . '" alt="">';
}

function voucher_image_src($type, $ImageName = NULL) {
    $ImageName = trim($ImageName);
    if ($type != '' && $ImageName !== '' && is_file(UOLOAD_PATH . "voucher/$ImageName") && !is_file(UOLOAD_PATH . "voucher/{$type}_{$ImageName}")) {
        $layer = ImageWorkshop::initFromPath(UOLOAD_PATH . "voucher/{$ImageName}");
        $preview = clone $layer;
        $preview->resizeInPixel(600, 600, TRUE);
        $preview->save(UOLOAD_PATH . "voucher/", "preview_{$ImageName}", true, null, 100);
        $thumb = clone $layer;
        $thumb->resizeInPixel(200, 192, TRUE);
        $thumb->save(UOLOAD_PATH . "voucher/", "thumb_{$ImageName}", true, null, 100);
    }
    $img_size = array(
        'preview' => '470x340/EFEFEF/AAAAAA&amp;text=no+image',
        'thumb' => '200x192/EFEFEF/AAAAAA&amp;text=no+image',
        'default' => '375x300/EFEFEF/AAAAAA&amp;text=no+image',
    );

    if ($ImageName == '' && $type != '') {
        $src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    } else if ($type == '' && $ImageName != '') {
        $src = base_url("assets/upload/voucher/{$ImageName}");
    } else if ($type != '' && $ImageName != '') {
        if(is_file(UOLOAD_PATH . "voucher/$ImageName")){
          $src = base_url("assets/upload/voucher/{$type}_{$ImageName}");  
        }else{
        $src = base_url("assets/upload/certificate_voucher/{$ImageName}");
        }
    } else {
        $type = 'default';
        $src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    }
    return $src;
}

function reviewer_image_src($type, $ImageName = NULL) {
    $ImageName = trim($ImageName);


    if ($ImageName == '' && $type != '') {
        $src = base_url("assets/images/{$type}_user.png");
        //$src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    } else if ($type == '' && $ImageName != '') {
        $src = base_url("assets/upload/featured_review/{$ImageName}");
    } else if ($type != '' && $ImageName != '') {
        $src = base_url("assets/upload/featured_review/{$type}_{$ImageName}");
    } else {
        $type = 'preview';
        $src = base_url("assets/images/{$type}_user.png");
    }
    return $src;
}

function certificate_image($type, $ImageName = NULL) {
    return '<img src="' . certificate_image_src($type, $ImageName) . '" alt="">';
}

function certificate_image_src($type, $ImageName = NULL) {
    $ImageName = trim($ImageName);
    if ($type != '' && $ImageName !== '' && is_file(UOLOAD_PATH . "certificate_voucher/$ImageName") && !is_file(UOLOAD_PATH . "certificate_voucher/{$type}_{$ImageName}")) {
        $layer = ImageWorkshop::initFromPath(UOLOAD_PATH . "certificate_voucher/{$ImageName}");
        $preview = clone $layer;
        $preview->resizeInPixel(470, 340, TRUE);
        $preview->save(UOLOAD_PATH . "certificate_voucher/", "preview_{$ImageName}", true, null, 100);
        $thumb = clone $layer;
        $thumb->resizeInPixel(200, 192, TRUE);
        $thumb->save(UOLOAD_PATH . "certificate_voucher/", "thumb_{$ImageName}", true, null, 100);
    }
    if ($ImageName == '' && $type != '') {
        $src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    } else if ($type == '' && $ImageName != '') {
        $src = base_url("assets/upload/certificate_voucher/{$ImageName}");
    } else if ($type != '' && $ImageName != '') {
        $src = base_url("assets/upload/certificate_voucher/{$type}_{$ImageName}");
    } else {
        $type = 'default';
        $src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    }
    return $src;
}

function gift_category_image($type, $ImageName = NULL) {
    return '<img src="' . certificate_image_src($type, $ImageName) . '" alt="">';
}

function gift_category_image_src($type, $ImageName = NULL) {
    $ImageName = trim($ImageName);
    if ($type != '' && $ImageName !== '' && is_file(UOLOAD_PATH . "certificate_voucher/$ImageName") && !is_file(UOLOAD_PATH . "certificate_voucher/{$type}_{$ImageName}")) {
        $layer = ImageWorkshop::initFromPath(UOLOAD_PATH . "certificate_voucher/{$ImageName}");
        $preview = clone $layer;
        $preview->resizeInPixel(470, 340, TRUE);
        $preview->save(UOLOAD_PATH . "certificate_voucher/", "preview_{$ImageName}", true, null, 100);
        $thumb = clone $layer;
        $thumb->resizeInPixel(200, 192, TRUE);
        $thumb->save(UOLOAD_PATH . "certificate_voucher/", "thumb_{$ImageName}", true, null, 100);
    }
    if ($ImageName == '' && $type != '') {
        $src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    } else if ($type == '' && $ImageName != '') {
        $src = base_url("assets/upload/gift_cate/{$ImageName}");
    } else if ($type != '' && $ImageName != '') {
        $src = base_url("assets/upload/certificate_voucher/{$type}_{$ImageName}");
    } else {
        $type = 'default';
        $src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    }
    return $src;
}

function voucher_image_abs($type, $ImageName = NULL) {
    $ImageName = trim($ImageName);
    if ($ImageName !== '' && is_file(UOLOAD_PATH . "voucher/$ImageName") && !is_file(UOLOAD_PATH . "voucher/{$type}_{$ImageName}")) {
        $layer = ImageWorkshop::initFromPath(UOLOAD_PATH . "voucher/{$ImageName}");
        $preview = clone $layer;
        $preview->resizeInPixel(470, 340, TRUE);
        $preview->save(UOLOAD_PATH . "voucher/", "preview_{$ImageName}", true, null, 100);
        $thumb = clone $layer;
        $thumb->resizeInPixel(200, 192, TRUE);
        $thumb->save(UOLOAD_PATH . "voucher/", "thumb_{$ImageName}", true, null, 100);
    }
    $img_size = array(
        'preview' => '470x340/EFEFEF/AAAAAA&amp;text=no+image',
        'thumb' => '200x192/EFEFEF/AAAAAA&amp;text=no+image',
    );
    return UOLOAD_PATH . "voucher/{$type}_{$ImageName}";
}

function service_image($type, $ImageName = NULL) {
    return '<img src="' . service_image_src($type, $ImageName) . '" alt="" class="lazy">';
}

function service_image_src($type, $ImageName = NULL) {
    $ImageName = trim($ImageName);
    /*if ($ImageName !== '' && is_file(UOLOAD_PATH . "service/$ImageName") && !is_file(UOLOAD_PATH . "service/{$type}_{$ImageName}")) {
        $layer = ImageWorkshop::initFromPath(UOLOAD_PATH . "service/{$ImageName}");
        $preview = clone $layer;
        $preview->resizeInPixel(600, 600, TRUE);
        $preview->save(UOLOAD_PATH . "service/", "preview_{$ImageName}", true, null, 100);
        $thumb = clone $layer;
        $thumb->resizeInPixel(200, 192, TRUE);
        $thumb->save(UOLOAD_PATH . "service/", "thumb_{$ImageName}", true, null, 100);
    }
    $img_size = array(
        'preview' => '234x228/EFEFEF/AAAAAA&amp;text=no+image',
        'thumb' => '200x192/EFEFEF/AAAAAA&amp;text=no+image'
    );*/
    if ($ImageName == '') {
        $src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    } else {
        if ($type == '') {
            $src = base_url("assets/upload/service/{$ImageName}");
        } else {
            $src = base_url("assets/upload/service/{$type}_{$ImageName}");
        }
    }
    return $src;
}

function loader_image_src() {
    return theme_url("images/loder.GIF");
}

function status_tag($code, $label = array()) {
    $tag = '';
    switch ($code) {
        case '0': $tag .= '<span class="label label-sm label-warning">';
            $tag .=isset($label[$code]) ? $label[$code] : 'Inactive'; //pending
            $tag .='</span>';
            break; //inactive replace cancelled and delete
        case '1': $tag .= '<span class="label label-sm label-success">';
            $tag .=isset($label[$code]) ? $label[$code] : 'Active';
            $tag .='</span>';
            break; //active

        case '2': $tag .= '<span class="label label-sm label-success">';
            $tag .=isset($label[$code]) ? $label[$code] : 'Active';
            $tag .='</span>';
            break; //active

        case '3': $tag .= '<span class="label label-sm label-danger">';
            $tag .=isset($label[$code]) ? $label[$code] : 'Removed';
            $tag .='</span>';
            break; //active
        case '4': $tag .= '<span class="label label-sm label-success">'; //Registration Complete
            $tag .=isset($label[$code]) ? $label[$code] : 'Yes';
            $tag .='</span>';
            break; //Yes
        case '5': $tag .= '<span class="label label-sm label-default">';
            $tag .=isset($label[$code]) ? $label[$code] : 'No';
            $tag .='</span>';
            break; //No
        case '12': $tag .= '<span class="label label-sm label-success">'; //Registration Complete
            $tag .=isset($label[$code]) ? $label[$code] : 'Complete';
            $tag .='</span>';
            break; //inactive
        case '19': $tag .= '<span class="label label-sm label-danger">'; //Registration Complete
            $tag .=isset($label[$code]) ? $label[$code] : 'Expired';
            $tag .='</span>';
            break; //inactive
        case '27': $tag .= '<span class="label label-sm label-success">';
            $tag .=isset($label[$code]) ? $label[$code] : 'Published';
            $tag .='</span>';
            break; //approved is replace with published
        case '28': $tag .= '<span class="label label-sm label-default">';
            $tag .=isset($label[$code]) ? $label[$code] : 'Pending';
            $tag .='</span>';
            break; //approved

        case '29': $tag .= '<span class="label label-sm label-danger">';
            $tag .=isset($label[$code]) ? $label[$code] : 'Declined';
            $tag .='</span>';
            break; //active
        //ticket 
        case '55': $tag .= '<span class="label label-sm label-warning">';
            $tag .=isset($label[$code]) ? $label[$code] : 'New';
            $tag .='</span>';
            break; //inactive
        case '56': $tag .= '<span class="label label-sm label-success">';
            $tag .=isset($label[$code]) ? $label[$code] : 'Open';
            $tag .='</span>';
            break; //active

        case '57': $tag .= '<span class="label label-sm label-danger">';
            $tag .=isset($label[$code]) ? $label[$code] : 'Closed';
            $tag .='</span>';
            break; //Closed
        case '39': $tag .= '<span class="label label-sm label-success">';
            $tag .=isset($label[$code]) ? $label[$code] : 'Viewed';
            $tag .='</span>';
            break; //Closed
        case '40': $tag .= '<span class="label label-sm label-danger">';
            $tag .=isset($label[$code]) ? $label[$code] : 'New';
            $tag .='</span>';
            break; //Closed
    }
    return $tag;
}

// ------------------------------------------------------------------------

/*
 * String to Boolean
 *
 * generate primary key for database
 * 
 * @param int
 * @return string
 */
if (!function_exists('gen_pk')) {

    function pk($length = 6) {
        $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        // generate the random string
        $rand = substr(str_shuffle($alphanum), 0, $length);
        $time = time();
        $val = $time . $rand;
        return $val;
    }

}
// ------------------------------------------------------------------------

/*
 * String to Boolean
 *
 * generate primary key for database
 * 
 * @param int
 * @return string
 */
if (!function_exists('generate_activation_code')) {

    function generate_activation_code($email) {
        return sha1(mt_rand(10000, 99999) . time() . $email);
    }

}

// ------------------------------------------------------------------------
/*
 * String to url
 * email_theme_url 
 * @param String
 * @return url
 */
function email_theme_url($img = '') {
    $CI = get_instance();
    return base_url("themes/email-template/$img"); //email_template
}

if (!function_exists('provider_site_url')) {

    function provider_site_url($str) {
        return site_url('provider-portal/' . $str);
    }

}
if (!function_exists('get_controller_methods')) {

    function get_controller_methods($class_name) {
        //print_r(get_class_methods($class_name));exit;
        foreach (get_class_methods($class_name) as $key => $value) {
            if (!isset($method_arr)) {
                $method_arr = "'" . $value . "'";
            } else {
                $method_arr .= ",'" . $value . "'";
            }
        }

        return $method_arr;
    }

}

if (!function_exists('add_seo')) {
    /*
     * $arg['id']= mandatory
     * $arg['title']= optional
     * $arg['key']= optional
     * $arg['desc']= optional
     * $arg['type']= mandatory
     */

    function add_seo($arg = array()) {
        $CI = &get_instance();
        if (!isset($arg['id']) || !isset($arg['type'])) {
            throw new Exception("Item's Primary and item type is mandatory field..");
        } else if ($CI->db->where('LinkId', $arg['id'])->count_all_results(TBL_SITE_SEO)) {
            $site_seo_data = array(
                'MetaTitle' => isset($arg['title']) ? html2txt($arg['title']) : '',
                'MetaKeyWords' => isset($arg['key']) ? html2txt($arg['key']) : '',
                'MetaDescription' => isset($arg['desc']) ? html2txt($arg['desc']) : '',
                'LinkType' => $arg['type'],
            );
            $CI->db->where('LinkId', $arg['id']);
            $CI->db->update(TBL_SITE_SEO, $site_seo_data);
            return $arg['id'];
        } else {
            $site_seo_data = array(
                'LinkId' => $arg['id'],
                'MetaTitle' => isset($arg['title']) ? html2txt($arg['title']) : '',
                'MetaKeyWords' => isset($arg['key']) ? html2txt($arg['key']) : '',
                'MetaDescription' => isset($arg['desc']) ? html2txt($arg['desc']) : '',
                'LinkType' => $arg['type'],
            );
            $CI->db->insert(TBL_SITE_SEO, $site_seo_data);
            return $CI->db->insert_id();
        }
    }

}

if (!function_exists('add_route')) {
    /*
     * $arg = array('id' => '', 'slug' => '', 'controller' => '', 'method' => '', 'type' => '');
     */

    function add_route($arg = array()) {
        $CI = &get_instance();
        if (!isset($arg['id']) || !isset($arg['slug']) || !isset($arg['type']) || !isset($arg['controller']) || !isset($arg['method'])) {
            throw new Exception("Item's Primary and item type is mandatory field..");
        } else {
            $routes_to = "{$arg['controller']}/{$arg['method']}/{$arg['id']}";
            $arg['slug'] = substr(strtolower($arg['slug']), 0, 255);
            $slug = url_title($arg['slug'], "-", TRUE);
            if ($CI->db->where('LinkId', $arg['id'])->count_all_results(TBL_ROUTES)) {
                $arg['slug'] = substr(strtolower($arg['slug']), 0, 255);
                $slug = url_title($arg['slug'], "-", TRUE);
                if ($CI->db->where('slug', $slug)->where('LinkId <>', $arg['id'])->count_all_results(TBL_ROUTES)) {
                    throw new Exception("This is not unique slug");
                } else {
                    $routes_data = array(
                        'slug' => $slug,
                        'routes_to' => trim($routes_to),
                        'LinkType' => $arg['type'],
                    );
                    $CI->db->where('LinkId', $arg['id'])->update(TBL_ROUTES, $routes_data);
                    $routes_data['RouteId'] = $CI->db->insert_id();
                    return $routes_data;
                }
            } else {
                $routes = $CI->db->select("SUBSTRING_INDEX(`slug`,'-',-1) as slug_no", FALSE)
                                ->from(TBL_ROUTES)
                                ->where("`slug` REGEXP '^({$slug}|{$slug}-[0-9])$'")
                                ->get()->result_array();
                $order = array();
                if (count($routes)) {
                    foreach ($routes as $k => $val) {
                        $order[] = (int) $val['slug_no'];
                    }
                    asort($order);
                    $range = range(1, count($order) + 1);

                    $end_digit = min(array_diff($range, $order));
                    if ($end_digit) {
                        $slug = "{$slug}-{$end_digit}";
                    }
                }
                if (in_array($slug, array('admin', 'provider-portal'))) {
                    $slug = increment_string($slug, "-");
                }

                $routes_data = array(
                    'LinkId' => $arg['id'],
                    'slug' => $slug,
                    'routes_to' => trim($routes_to),
                    'LinkType' => $arg['type'],
                );
                $CI->db->insert(TBL_ROUTES, $routes_data);
                $routes_data['RouteId'] = $CI->db->insert_id();
                return $routes_data;
            }
        }
    }

}

if (!function_exists('add_user_hitory')) {
    /*
     * $arg['id']= mandatory
     * $arg['title']= optional
     * $arg['key']= optional
     * $arg['desc']= optional
     * $arg['type']= mandatory
     */

    function add_user_hitory($data = array()) {
        $CI = &get_instance();
        if (isset($data['UserId']) && $data['UserId'] != '') {
            $UserId = $data['UserId'];
        } else {
            $UserId = $CI->auth->get_user_session('UserId');
        }
        $user_history_data = array(
            'HistoryId' => $CI->all_function->rand_string('12'),
            'UserId' => $UserId,
            'TrackId' => $data['TrackId'],
            'Comment' => $data['Comment'],
            //'AddedDate' => date('Y-m-d H:i:s'),
            'AddedDate' => $CI->all_function->add_sydney_date_time_format(date('Y-m-d H:i:s')),
            'Status' => '1',
        );
        $CI->db->insert(TBL_USER_HISTORY, $user_history_data);
    }

}

function add_voucher_route($id, $title) {
    $arg = array(
        'id' => $id,
        'slug' => $title,
        'controller' => 'services',
        'method' => 'voucher_details',
        'type' => 'voucher'
    );
    return add_route($arg);
}

/**
 * Generate Float Random Number
 *
 * @param float $Min Minimal value
 * @param float $Max Maximal value
 * @param int $round The optional number of decimal digits to round to. default 0 means not round
 * @return float Random float value
 */
function float_rand($Min, $Max, $round = 2) {
    //validate input
    if ($Min > $Max) {
        $min = $Max;
        $max = $Min;
    } else {
        $min = $Min;
        $max = $Max;
    }
    $randomfloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
    if ($round > 0)
        $randomfloat = round($randomfloat, $round);

    return $randomfloat;
}

function html2txt($document) {
    $search = array('@<script[^>]*?>.*?</script>@si', // Strip out javascript 
        '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags 
        '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly 
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA 
    );
    $text = preg_replace($search, '', $document);
    return $text;
}

function clean_texteditor($document) {
    $search = array('@<script[^>]*?>.*?</script>@si', // Strip out javascript 
        '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly 
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA 
    );
    $text = preg_replace($search, '', $document);
    return $text;
}

function add_static_page($data) {
    $CI = &get_instance();
    $cms_page_data = array(
        'Title' => $data['Title'],
        'Content' => $data['Content'],
        'SSL' => '0',
        'PageType' => 'static',
        //'AddedDate' => date('Y-m-d H:i:s'),
        'AddedDate' => $CI->all_function->add_sydney_date_time_format(date('Y-m-d H:i:s')),
        'UpdatedDate' => '0000-00-00 00:00:00',
        'Status' => '1',
    );
    $CI->db->insert(TBL_CMS_PAGE, $cms_page_data);
    return $CI->db->insert_id();
}

function generate_password($length = 8) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr(str_shuffle($chars), 0, $length);
    return $password;
}

/**
 * Returns top category names and their corresponding CategoryId.
 * Only the category with the top category will be returned.
 * @param array 
 * @param string the dropdown's option value attribute
 * @param string the dropdown's option name attribute
 * @return array category indexed by category id.
 */
function ci_drop_down($data, $val, $name, $initails = array()) {
    $drop_down = array();
    if (!empty($initails)) {
        $drop_down = $initails;
    }
    foreach ($data as $row) {
        if (!is_object($row)) {
            $row = (object) $row;
        }
        $drop_down[$row->{$val}] = $row->{$name};
    }
    return $drop_down;
}

/*
 * Check user permission in particuler module
 */

function has_permission($area_code) {
    $ci = &get_instance();
    $user_type_id = $ci->auth->get_user_session('UserTypeId');
    if ($user_type_id == 1) {
        return TRUE;
    } else {
        $permited_module = $ci->auth->get_user_module_permission_data();
        if (is_array($area_code)) {
            //$all_modules = $ci->auth->get_all_module();
            return count(array_intersect($area_code, $permited_module)) ? TRUE : FALSE;
        } else {
            return in_array($area_code, $permited_module);
        }
    }
}

function show_unauthorize_access() {
    $msg = "You do not have permission to access this area.";

    if (IS_AJAX) {
        $ci = & get_instance();
        $ci->ajax_response['ok'] = 0;
        $ci->ajax_response['message'] = $msg;
        $ci->render_ajax_response();
    } else {
        show_error($msg, 403, "Error::access");
    }
}

function get_value($index) {
    $ci = & get_instance();
    if ($ci->input->get($index)) {
        return $ci->input->get($index);
    } else {
        return '';
    }
}

///////////////////////////Coded by Arnab Roy for Voucher Image Second///////////////////////////////

function voucher_image_second($type, $CircleImageName = NULL) {
    return '<img src="' . voucher_image_src_sec($type, $CircleImageName) . '" alt="">';
}

function voucher_image_src_sec($type, $CircleImageName = NULL) {
    $CircleImageName = trim($CircleImageName);
    if ($type != '' && $CircleImageName !== '' && is_file(UOLOAD_PATH . "voucher_circle/$CircleImageName") && !is_file(UOLOAD_PATH . "voucher_circle/{$type}_{$CircleImageName}")) {
        $layer = ImageWorkshop::initFromPath(UOLOAD_PATH . "voucher_circle/{$CircleImageName}");
    }
    if ($CircleImageName == '' && $type != '') {
        $src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    } else if ($type == '' && $CircleImageName != '') {
        $src = base_url("assets/upload/voucher_circle/{$CircleImageName}");
    } else if ($type != '' && $CircleImageName != '') {
        $src = base_url("assets/upload/voucher_circle/{$type}_{$CircleImageName}");
    } else {
        $type = 'default';
        $src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    }
    return $src;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////Coded By Arnab Roy For Service Image Second////////////////////////////////

function service_image_sec($type, $CircleImageName = NULL) {
    return '<img src="' . service_image_src_sec($type, $CircleImageName) . '" alt="" class="lazy">';
}

function service_image_src_sec($type, $CircleImageName = NULL) {
    $CircleImageName = trim($CircleImageName);
    if ($CircleImageName !== '' && is_file(UOLOAD_PATH . "service_circle/$CircleImageName") && !is_file(UOLOAD_PATH . "service_circle/{$type}_{$CircleImageName}")) {
        $layer = ImageWorkshop::initFromPath(UOLOAD_PATH . "service_circle/{$CircleImageName}");
    }
    if ($CircleImageName == '') {
        $src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    } else {
        if ($type == '') {
            $src = base_url("assets/upload/service_circle/{$CircleImageName}");
        } else {
            $src = base_url("assets/upload/service_circle/{$type}_{$CircleImageName}");
        }
    }
    return $src;
}

//////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////Coded by Arnab Roy for Voucher Image PDF Path///////////////////////////////

function voucher_image_circle_path($type, $CircleImageName = NULL) {
    return '<img src="' . voucher_image_src_path($type, $CircleImageName) . '" alt="">';
}

function voucher_image_src_path($type, $CircleImageName = NULL) {
    $CircleImageName = trim($CircleImageName);
    if ($type != '' && $CircleImageName !== '' && is_file(UOLOAD_PATH . "voucher_circle/$CircleImageName") && !is_file(UOLOAD_PATH . "voucher_circle/{$type}_{$CircleImageName}")) {
        $layer = ImageWorkshop::initFromPath(UOLOAD_PATH ."voucher_circle/{$CircleImageName}");
    }
    if ($CircleImageName == '' && $type != '') {
        $src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    } else if ($type == '' && $CircleImageName != '') {
        $src = base_url("assets/upload/voucher_circle/{$CircleImageName}");
    } else if ($type != '' && $CircleImageName != '') {
        $src = base_url("assets/upload/voucher_circle/{$type}_{$CircleImageName}");
    } else {
        $type = 'default';
        $src = theme_url('images/default.png'); //"http://www.placehold.it/{$img_size[$type]}";
    }
    return $src;
}

function page_cms_image($image_name) {
    return '<img src="' . base_url("assets/upload/page_cms/$image_name") . '">';
}

function page_cms_image_src($image_name) {
    
    list($width, $height, $type, $attr) = getimagesize($_SERVER['DOCUMENT_ROOT']."/assets/upload/page_cms/$image_name");
    
    return array('img_src'=>base_url("assets/upload/page_cms/$image_name"),'img_height'=>$height.'px');
    //return base_url("assets/upload/page_cms/$image_name");
}
///////////////////////////////////////////////////////////////////////////////////////////////////




