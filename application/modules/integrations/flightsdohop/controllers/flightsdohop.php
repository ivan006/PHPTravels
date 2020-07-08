<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flightsdohop extends MX_Controller {

       private $data = array();

  function __construct(){
   // $this->session->sess_destroy();
    parent::__construct();

   modules::load('home');



   $this->load->library("dohop_lib");
   $this->load->model("dohop_model");
   $this->load->helper("dohop_front");
  $this->data['app_settings'] = $this->settings_model->get_settings_data();

  $this->data['lang_set'] = $this->session->userdata('set_lang');
 $chk = modules::run('home/is_main_module_enabled','flightsdohop');
   if(!$chk){
       Error_404();

   }
     $this->data['phone'] = $this->load->get_var('phone');
         $this->data['contactemail'] = $this->load->get_var('contactemail');
   $this->data['geo'] = $this->load->get_var('geolib');

      $defaultlang = pt_get_default_language();
   if(empty($this->data['lang_set'])){

      $this->data['lang_set'] = $defaultlang;
   }
   $this->lang->load("front",$this->data['lang_set']);
 }

	public function index()
	{
    
       $settings =  $this->settings_model->get_front_settings("flightsdohop");

  $this->data['username'] = $settings[0]->cid;
  $this->data['page_title'] = $settings[0]->header_title;
 $loadheaderfooter = $settings[0]->load_headerfooter;
  if(empty($loadheaderfooter)){

  $this->theme->partial('integrations/flights/dohop/list',$this->data);
  }else{
  $this->theme->view('integrations/flights/dohop/list',$this->data);
  }

}

function getLocationsList(){
  $term = $this->input->post('term');
  $id = $this->input->post('inputid');
  $cc = curlCall("http://picker.dohop.com/search/?lang=en&sid=completer&input=$term");
  $result = json_decode($cc);
  $response = new stdClass;

/*  echo "<pre>";
  print_r($result->standard);
  echo "<pre>";*/
 
   $response->data .= "<ul>";
  foreach($result->standard as $r){
    //$val1 = $r->p." (".$r->ac.")";
    $val = $r->p." (".$r->ac.")"; 

   // $response->data .= "<li onclick=selectValue('".$val."','".$id."') >".$val."</li>";
    $response->data .= "<li onclick=\"selectValue('$val','$id')\">$val</li>";

  }

  $response->data .= "</ul>";

  echo $response->data;

}


   }
