<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
//require APPPATH . 'modules/api/libraries/REST_Controller.php';

class Api extends MX_Controller {
     public $data = array();
     private $validlang;
        function __construct() {
// Construct our parent class
                parent :: __construct();
               /* if(!$this->isValidApiKey){
                $this->response($this->invalidResponse, 400);
               }*/

               modules :: load('home');

                $defaultlang = pt_get_default_language();

                 $languageid = $this->uri->segment(2);
                 $this->validlang = pt_isValid_language($languageid);

                if($this->validlang){
                  $this->data['lang_set'] =  $languageid;
                }else{
                  $this->data['lang_set'] = $this->session->userdata('set_lang');
                }

                if (empty ($this->data['lang_set'])){
                        $this->data['lang_set'] = $defaultlang;
                }

               $this->data['phone'] = $this->load->get_var('phone');
               $this->data['contactemail'] = $this->load->get_var('contactemail');
               $this->data['app_settings'] = $this->settings_model->get_settings_data();
              
        }

        function index(){
           
           $this->lang->load("front", $this->data['lang_set']);
           $this->data['page_title'] = "API Docs";
           $this->data['langurl'] = base_url()."api/{langid}";
           $this->theme->view('api', $this->data);
        }

}