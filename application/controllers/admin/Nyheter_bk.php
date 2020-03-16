<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nyheter extends CI_Controller {

	function __construct()
    {
        parent::__construct();       
			
		$this->load->helper('site_helper');	
		$this->load->library('session');
		$this->load->library('form_validation');	
		
		$this->load->model('User_model');	
		$this->load->model('Cms_model');
		
		
		$this->lang->load('auth_lang');
		
		allow_if_logged_in();		
				
		$this->data['pageDesc'] = '';
                
                $this->load->helper('Ckeditor');
 
                //Ckeditor's configuration
                $this->data['ckeditor'] = array(
 
                        //ID of the textarea that will be replaced
                        'id'    =>      'content',
                        'path'  =>      'js/ckeditor',
                        'extraPlugins' => 'imageuploader',
                        //Optionnal values
                        'config' => array(
                                'toolbar'       =>      "Full",         //Using the Full toolbar
                                'width'         =>      "550px",        //Setting a custom width
                                'height'        =>      '100px',        //Setting a custom height
                                'filebrowserBrowseUrl' => '/ckfinder/ckfinder.html?type=Images',
    'filebrowserImageBrowseUrl' => '/ckfinder/ckfinder.html?type=Images',
    'filebrowserUploadUrl' => '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    'filebrowserImageUploadUrl' => '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    'removeDialogTabs'=> 'image:advanced;link:advanced',
    'format_tags'=> 'p;h1;h2;h3;pre',
    //'removeDialogFields'=> 'image:info:htmlPreview'
 
                        ),
 
                        //Replacing styles from the "Styles tool"
                        'styles' => array(
 
                                //Creating a new style named "style 1"
                                'style 1' => array (
                                        'name'          =>      'Blue Title',
                                        'element'       =>      'h2',
                                        'styles' => array(
                                                'color'         =>      'Blue',
                                                'font-weight'   =>      'bold'
                                        )
                                ),
 
                                //Creating a new style named "style 2"
                                'style 2' => array (
                                        'name'  =>      'Red Title',
                                        'element'       =>      'h2',
                                        'styles' => array(
                                                'color'                 =>      'Red',
                                                'font-weight'           =>      'bold',
                                                'text-decoration'       =>      'underline'
                                        )
                                )                              
                        )
                );
 
                $this->data['ckeditor_2'] = array(
 
                        //ID of the textarea that will be replaced
                        'id'    =>      'content_2',
                        'path'  =>      'js/ckeditor',
 
                        //Optionnal values
                        'config' => array(
                                'width'         =>      "550px",        //Setting a custom width
                                'height'        =>      '100px',        //Setting a custom height
                                'toolbar'       =>      array(  //Setting a custom toolbar
                                        array('Bold', 'Italic'),
                                        array('Underline', 'Strike', 'FontSize'),
                                        array('Smiley'),
                                        '/'
                                )
                        ),
 
                        //Replacing styles from the "Styles tool"
                        'styles' => array(
 
                                //Creating a new style named "style 1"
                                'style 3' => array (
                                        'name'          =>      'Green Title',
                                        'element'       =>      'h3',
                                        'styles' => array(
                                                'color'         =>      'Green',
                                                'font-weight'   =>      'bold'
                                        )
                                )
 
                        )
                );             
                
                
                
    }
	
	public function index()
	{	
            
            
$this->load->library('ckeditor');
        $this->load->library('ckfinder');


$this->ckeditor->basePath = base_url().'assets/ckeditor_bk/';
$this->ckeditor->config['toolbar'] = array(
                array( 'Source', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList','JustifyLeft','JustifyCenter','JustifyRight','JustifyFull' )
                                                    );
//$this->ckeditor->config['toolbar'] = "Full";

$this->ckeditor->config['extraPlugins'] = 'imageuploader';
$this->ckeditor->config['removeDialogTabs'] = 'image:advanced;link:advanced';
$this->ckeditor->config['format_tags'] = 'p;h1;h2;h3;pre';
$this->ckeditor->config['image_previewText'] = ' ';
//$this->ckeditor->config['removeDialogFields'] = 'image:info:htmlPreview';
//$this->ckeditor->config['removePlugins'] = 'image';
$this->ckeditor->config['language'] = 'en';
$this->ckeditor->config['width'] = '730px';
$this->ckeditor->config['height'] = '300px';      

//Add Ckfinder to Ckeditor
$this->ckfinder->SetupCKEditor($this->ckeditor,'../../assets/ckfinder/'); 
            
            
		set_page_title('Nyheter');	
		$this->data['pageDesc'] = 'Your Website News';
		
		$cmsInfo = $this->Cms_model->find('nyheter');
		$this->data['cmsInfo'] = $cmsInfo;
		
		if($this->input->post('submit'))
		{
			$submit = $this->input->post('submit');
			if($submit=="save")
			{
				$this->form_validation->set_rules('content', 'Content', 'trim|required');
                                $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
				if ($this->form_validation->run() == TRUE)
				{
						$update['content'] = $this->input->post('content');					
						$this->Cms_model->update($cmsInfo->id,$update);										
							
						$session_message['type'] = 1;
						$session_message['title'] = 'Success!';
						$session_message['content'] = 'Content has been successfully saved.';
						$this->session->set_flashdata('message', $session_message);
						redirect('admin/nyheter');					
				}
				else
				{
					
				}
				
			}
		}
		
		$data['content'] =  $this->load->view('admin/nyheter', $this->data, TRUE);
        $this->load->view('layouts/admin', $data);
	}

    public function insert() {

        $params = array(
            'slug' => 'nyheter',
            'page_name' => 'Nyheter',
            'content' => '<p><strong>Nyheter: Vvsoffert.se</strong></p>

<p>Testa programmet gratis i en vecka ,om ni v&auml;ljer att&nbsp;fors&auml;tta s&aring; kontakta oss s&aring; skickas en program licens med inloggningsuppgifter som kan anv&auml;ndas i 1 &aring;r.</p>

<p>F&ouml;ljande licensvillkor g&auml;ller f&ouml;r anv&auml;ndningen av produkter p&aring; Vvsoffert.se(webbtj&auml;nst) fr&aring;n</p>

<p>VVS Group ab AB (556804-9802), nedan kallad Vvsoffert.se. Produkterna som tillhandah&aring;lls p&aring; Vvsoffert.</p>

<p>&nbsp;</p>

<p>1. Nyttjander&auml;tt</p>

<p>Mot erl&auml;ggande av licensavgift uppl&aring;ter Vvsoffert.se till kunden en r&auml;tt att i enlighet med vad som anges nedan nyttja sin k&ouml;pta produktlicens p&aring; Vvsoffert.se f&ouml;r eget bruk. Licensen f&aring;r ej spridas eller s&auml;ljas till annan person.</p>

<p>&nbsp;</p>

<p>2. Kundkonto och produktlicens</p>

<p>I samband med k&ouml;p av licens skapas ett unikt kundkonto p&aring; Vvsoffert.se. Har kunden redan ett kundkonto uppdateras detta med kundens senaste produktk&ouml;p. Kundkontot &auml;r kopplat till kundens angivna e-postadress och till kontot knyts kundens k&ouml;pta produktlicens/er. Vid eventuellt byte av e-postadress ska Vvsoffert.se kontaktas.</p>

<p>Antalet produktlicenser ger r&auml;tten till samma antal samtidiga anv&auml;ndare av produkten.</p>

<p>&nbsp;</p>

<p>3. Priser och avtalstid</p>

<p>Licens k&ouml;ps p&aring; 1 &aring;r &nbsp;6900 kr ex moms, vi har ingen bindningstid. Faktureras efter p&aring;b&ouml;rjad anv&auml;ndning.</p>

<p>&nbsp;</p>

<p>4. Utel&aring;sning och v&auml;ntetid</p>

<p>F&ouml;rs&ouml;ker fler anv&auml;ndare &auml;n antalet k&ouml;pta produktlicenser samtidigt anv&auml;nda produkten blir dessa utel&aring;sta och f&aring;r en varning om att det &auml;r f&ouml;r m&aring;nga samtidiga anv&auml;ndare av produkten. Kunden kan endast anv&auml;nda sin produktlicens p&aring; en dator &aring;t g&aring;ngen. Vid byte av dator f&aring;r kunden v&auml;nta ca 10 min innan produktlicensen &rdquo;sl&auml;pper&rdquo; och fungerar p&aring; n&auml;sta dator. Likas&aring; uppst&aring;r v&auml;ntetid om kunden anv&auml;nder sin produkt p&aring; Vvsoffert.se p&aring; flera olika webb-l&auml;sare samtidigt och vill v&auml;xla mellan dessa. F&ouml;r att undg&aring; v&auml;ntetid kan kunden logga ut/ logga in p&aring; sitt konto.</p>

<p>&nbsp;</p>

<p>5. Tillg&auml;nglighet</p>

<p>Vvsoffert.se &auml;r normalt tillg&auml;ngligt 24 timmar om dygnet alla dagar i veckan. Vvsoffert.se har r&auml;tt att st&auml;nga Vvsoffert.se tillf&auml;lligt f&ouml;r underh&aring;ll och uppdateringar. Meddelande om eventuellt driftstopp visas p&aring; sk&auml;rmen.</p>

<p>7. Avst&auml;ngning</p>

<p>Underl&aring;ter kunden att betala i tid, &auml;ger Vvsoffert.se r&auml;tt att s&aring; l&auml;nge underl&aring;tenheten best&aring;r avst&aring; fr&aring;n att utf&ouml;ra sina tj&auml;nster, med bibeh&aring;llen ers&auml;ttning. Vvsoffert.se &auml;ger r&auml;tt att st&auml;nga ner kundens konto p&aring; Vvsoffert.se med omedelbar verkan vid kundens obest&aring;nd eller om kunden bryter mot dessa licensvillkor.</p>

<p>&nbsp;</p>

<p>6. Teknisk plattform</p>

<p>Vvsoffert.se ansvarar ej f&ouml;r eventuella brister och begr&auml;nsningar i kundens operativsystem och datormilj&ouml;. F&ouml;r erh&aring;llande av optimal funktionalitet av Vvsoffert.se produkter f&ouml;ruts&auml;tts att kunden har den standard och tekniska plattform som st&ouml;ds av Vvsoffert.se. Programmet p&aring; Vvsoffert.se &auml;r alltid de senaste priserna fr&aring;n grossisterna. uppdateras online 2-3 g&aring;nger om dagen .</p>

<p>&nbsp;</p>

<p>7. R&auml;ttigheter Vvsoffert.se &auml;ger samtliga immateriella r&auml;ttigheter i av Vvsoffert.se framtagna och utgivna produkter och tj&auml;nster. Digitala verk exponerade p&aring; Vvsoffert.se webbplats skyddas av upphovsr&auml;ttslagen, URL.</p>

<p>&nbsp;</p>

<p>8. Ansvarsbegr&auml;nsning</p>

<p>Vvsoffert.se friskriver sig fr&aring;n allt ansvar f&ouml;r varje sakskada eller f&ouml;rm&ouml;genhetsskada som kan f&ouml;lja direkt eller indirekt av Vvsoffert.se &aring;tagande enligt detta avtal. Eventuell ers&auml;ttning kan aldrig bli st&ouml;rre &auml;n erlagd licensavgift f&ouml;r produkten.</p>

<p>&nbsp;</p>

<p>9. Force Majeure</p>

<p>Omst&auml;ndigheter utanf&ouml;r Vvsoffert.se kontroll s&aring;som f&ouml;ljder efter eldsv&aring;da, strejk eller liknande ers&auml;tts ej.</p>'
        );

    $id = $this->Cms_model->insert($params);

    var_dump($id);die();

    }
	
		
}
