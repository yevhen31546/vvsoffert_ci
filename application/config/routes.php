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
$route['product/(:any)'] = 'home/product';

$route['Products_new?(:any)'] = 'products/catpro_new';


$route['products?(:any)'] = 'products';
$route['registrera'] = 'home/signup';
$route['logga-in'] = 'login';
$route['logga-out'] = 'login/logout';
$route['kontrollpanel'] = 'dashboard';
$route['priser'] = 'price/index';
$route['kontakta-oss'] = 'home/contactus';
// Admin
$route['admin'] = 'admin/auth/login';
//$route['admin/e-store/(:any)'] = 'admin/e_store';
$route['admin/logout'] = 'admin/auth/logout';
$route['admin/nyheter'] = 'admin/nyheter';
$route['admin/forgot-password'] = 'admin/auth/forgot_password';
$route['admin/reset-password'] = 'admin/auth/reset_password';
$route['admin/reset-password/(:any)'] = 'admin/auth/reset_password';


//User
$route['glomt-ditt-losenord'] = 'login/forgot_password';
$route['aterstall-losenord'] = 'login/reset_password';
$route['aterstall-losenord/(:any)'] = 'login/reset_password';
$route['import-product-rsk-quantity'] = 'user/import_product_rsk_excel';
$route['import-product-rsk-estore'] = 'user/import_product_rsk_price_excel';
//$route['import-product-rsk-estore'] = 'user/import_product_rsk_price_excel';
$route['download-product-store-price/(:any)'] = 'user/download_product_data/$1';
$route['import-product-rsk-estore-price/(:any)'] = 'user/import_product_rsk_estore_price_excel/$1';
$route['snabb-kalkyl'] = 'user/cost_caclulator';
$route['company-settings'] = 'user/company_settings';
$route['invoice-settings'] = 'user/invoice_settings';
$route['serviceprices?(:any)'] = 'user/service_prices';
$route['kund'] = 'user/customer';
$route['article'] = 'user/add_list';
$route['newarticle'] = 'user/new_add_list';
$route['export-excel-new'] = 'user/export_excel_new';

$route['add-new-article-form'] = 'user/new_add_article';
$route['add-new-customer'] = 'user/add_customer';
$route['edit-customer'] = 'user/edit_customer_update';
$route['get-product'] = 'user/get_product_by_rsk';

$route['get-product-info'] = 'user/get_product_by_rsk_new';
$route['get-article-info'] = 'user/get_article_by_rsk_new';
$route['get-article-price'] = 'user/get_article_price';

$route['anvandarprofil'] = 'user/useraccount_details';
$route['andra-losenord'] = 'user/change_password';
$route['add-list '] = 'user/add_list';
$route['edit-article'] = 'user/edit_article';
$route['delete-article'] = 'user/delete_article';


$route['add-list-form'] = 'user/add_list_form';
$route['edit-list-form'] = 'user/edit_list_form';
$route['list-details'] = 'user/list_details';
$route['list-invoice'] = 'user/list_invoice_ajax';
$route['list-invoice-edit'] = 'user/list_invoice_edit';
$route['list-invoice-reedit'] = 'user/list_invoice_reedit';
$route['list-invoice-save'] = 'user/list_invoice_save';
$route['list-invoice-form'] = 'user/list_invoice_ajax';
$route['list-only-invoice-form'] = 'user/list_only_invoice_ajax';
$route['list-only-order-form'] = 'user/list_only_order_ajax';
$route['list-only-offerter-form'] = 'user/list_only_offerter_ajax';
$route['list-sale-history'] = 'user/list_sale_history';
$route['edit-invoice'] = 'user/edit_invoice_update';
$route['edit-order'] = 'user/edit_order_update';
$route['edit-offerter'] = 'user/edit_offerter_update';
$route['pdf-export'] = 'user/pdf_export';
$route['pdf-export-invoice'] = 'user/pdf_export_invoice';
$route['pdf-export-invoice-edited'] = 'user/pdf_export_invoice_edited';

$route['pdf-export-invoice-edited-new'] = 'user/pdf_export_invoice_edited_new';
$route['pdf-export-invoice-preview-new'] = 'user/pdf_export_invoice_preview_new';

$route['pdf-export-offerter-edited-new'] = 'user/pdf_export_offerter_edited_new';
$route['pdf-export-offerter-preview-new'] = 'user/pdf_export_offerter_preview_new';

$route['pdf-export-order-edited-new'] = 'user/pdf_export_order_edited_new';
$route['pdf-export-order-preview-new'] = 'user/pdf_export_order_preview_new';

$route['pdf-only-export-invoice-edited'] = 'user/pdf_export_only_invoice_edited';
$route['pdf-only-export-order-edited'] = 'user/pdf_export_only_order_edited';
$route['pdf-only-export-offerter-edited'] = 'user/pdf_export_only_offerter_edited';
$route['export-excel'] = 'user/export_excel';
$route['licensvillkor'] = 'home/terms';
$route['nyheter'] = 'home/nyheter';
$route['sitemap.xml'] = 'seo/index';
$route['(:any)'] = 'products/catpro';

$route['404_override'] = 'errors/error_404';
$route['translate_uri_dashes'] = FALSE;
