<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'home/index';
$route['test-language'] = 'home/language_section';
$route['product?(:any)'] = 'product';
$route['products?(:any)'] = 'products';
$route['login'] = 'login';
$route['dashboard'] = 'dashboard';
// Admin
$route['admin'] = 'admin/auth/login';
$route['admin/logout'] = 'admin/auth/logout';
$route['admin/forgot-password'] = 'admin/auth/forgot_password';
$route['admin/reset-password'] = 'admin/auth/reset_password';
$route['admin/reset-password/(:any)'] = 'admin/auth/reset_password';


//User
$route['forgot-password'] = 'login/forgot_password';
$route['reset-password'] = 'login/reset_password';
$route['reset-password/(:any)'] = 'login/reset_password';
$route['import-product-rsk-quantity'] = 'user/import_product_rsk_excel';
$route['import-product-rsk-estore'] = 'user/import_product_rsk_price_excel';
$route['import-product-rsk-estore'] = 'user/import_product_rsk_price_excel';
$route['download-product-store-price/(:any)'] = 'user/download_product_data/$1';
$route['import-product-rsk-estore-price/(:any)'] = 'user/import_product_rsk_estore_price_excel/$1';
$route['cost-caclulator'] = 'user/cost_caclulator';
$route['serviceprices?(:any)'] = 'user/service_prices';

$route['user-profile'] = 'user/useraccount_details';
$route['change-password'] = 'user/change_password';
$route['add-list'] = 'user/add_list';
$route['add-list-form'] = 'user/add_list_form';
$route['edit-list-form'] = 'user/edit_list_form';
$route['list-details'] = 'user/list_details';
$route['list-invoice'] = 'user/list_invoice';
$route['list-invoice-edit'] = 'user/list_invoice_edit';
$route['list-invoice-reedit'] = 'user/list_invoice_reedit';
$route['list-invoice-save'] = 'user/list_invoice_save';
$route['list-invoice-form'] = 'user/list_invoice_form';
$route['pdf-export'] = 'user/pdf_export';
$route['pdf-export-invoice'] = 'user/pdf_export_invoice';
$route['pdf-export-invoice-edited'] = 'user/pdf_export_invoice_edited';
$route['export-excel'] = 'user/export_excel';
$route['terms-condition'] = 'home/terms';
$route['contact-us'] = 'home/contactus';
$route['sitemap.xml'] = 'seo/index';
$route['(:any)'] = 'products/catpro';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
