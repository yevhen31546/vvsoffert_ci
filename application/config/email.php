<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/

$config['protocol'] = "smtp";
$config['smtp_host'] = "send.one.com";
//$config['smtp_port'] = "587";
//$config['smtp_port'] = "465";
$config['smtp_port'] = "25";
$config['smtp_user'] = "info@vvsoffert.se";
$config['smtp_pass'] = 'Vv$offert@123';
//$config['smtp_crypto'] = 'ssl';
//$config['smtp_pass'] = 'V64pacitygross';
$config['charset'] = "utf-8";
//$config['charset'] = "iso-8859-1";
$config['mailtype'] = "html";
$config['crlf'] = "\n";
$config['newline'] = "\r\n";
$config['wordwrap'] = TRUE;
$config['smtp_timeout'] = 5;

/* End of file email.php */
/* Location: ./application/config/email.php */