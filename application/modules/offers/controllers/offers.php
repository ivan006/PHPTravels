<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Offers extends MX_Controller {
		private $data = array();
		private $validlang;

		function __construct(){
				parent :: __construct();

				$chk = modules :: run('home/is_module_enabled', 'offers');
				if (!$chk) {
						Module_404();
				}

				modules :: load('home');
				$this->load->library('offers_lib');
				$this->data['app_settings'] = $this->settings_model->get_settings_data();
				$this->data['lang_set'] = $this->session->userdata('set_lang');
				$this->data['usersession'] = $this->session->userdata('pt_logged_customer');
				$this->load->model('admin/special_offers_model');
				$this->data['phone'] = $this->load->get_var('phone');
				$this->data['contactemail'] = $this->load->get_var('contactemail');
				$this->data['appModule'] = "offers";
				
				

				$languageid = $this->uri->segment(2);
                $this->validlang = pt_isValid_language($languageid);

                if($this->validlang){
                  $this->data['lang_set'] =  $languageid;
                }else{
                  $this->data['lang_set'] = $this->session->userdata('set_lang');
                }

                $defaultlang = pt_get_default_language();
				if (empty ($this->data['lang_set'])){
						$this->data['lang_set'] = $defaultlang;
				}

              	$this->lang->load("front", $this->data['lang_set']);
                $this->offers_lib->set_lang($this->data['lang_set']);
                


		}

		public function index() {
				
                if($this->validlang){

                    $offername = $this->uri->segment(3);

                }else{

                    $offername = $this->uri->segment(2);
                }

				$check = $this->special_offers_model->offerExists($offername);
  				if ($check && !empty($offername)) {
  					$sendmsg = $this->input->post('sendmsg');
  					$this->offers_lib->set_offerid($offername);
  					$this->data['module'] = $this->offers_lib->offer_details();
  					$this->data['currencySign'] = $this->data['module']->currSymbol;
  					$this->data['lowestPrice'] = $this->data['module']->price;
                    
                      $this->data['page_title'] =  $this->data['module']->title;
                      if(!empty($sendmsg)){
                      	$this->load->model('admin/emails_model');
                      	$this->emails_model->offerContactEmail();
                      	$this->session->set_flashdata('flashmsgs', "Email Sent"); 
                      	redirect(base_url()."offers/".$this->data['module']->slug); 

                      }
                      /*$this->data['metakey'] = $this->data['hotel']->keywords;
					  $this->data['metadesc'] = $this->data['hotel']->metadesc;*/
					  $this->data['success'] = $this->session->flashdata('flashmsgs'); 
					  $this->data['langurl'] = base_url()."offers/{langid}/".$this->data['offer']->slug;
					  $this->theme->view('details', $this->data);
				}
                else {
						$this->listing();
				}
		}

		function listing($offset = null){
				$this->data['sorturl'] = base_url() . 'offers/listings?';
				$settings = $this->settings_model->get_front_settings('offers');
				
				$alloffers = $this->offers_lib->showOffers($offset);
               
                $this->data['module'] = $alloffers['allOffers']['offers'];
				$this->data['info'] = $alloffers['paginationinfo'];
				$this->data['plinks2'] = $alloffers['plinks2'];
				$this->data['page_title'] = $settings[0]->header_title;
                $this->data['langurl'] = base_url()."offers/{langid}";
				$this->theme->view('listing', $this->data);
		}

		function search($offset = null) {
				$surl = http_build_query($_GET);
				//$this->data['sorturl'] = base_url() . 'offers/search?' . $surl . '&';
				$dfrom = $this->input->get('dfrom');
				$dto = $this->input->get('dto');
				
                $type = $this->input->get('type');
				$txtsearch = $this->input->get('searching');
      
   				if (array_filter($_GET)) {
						$alloffers = $this->offers_lib->searchOffers($offset,$dfrom,$dto);
						$this->data['module'] = $alloffers['allOffers']['offers'];
                     	$this->data['info'] = $alloffers['paginationinfo'];

				}
				else {
						$this->listing();
				}
                $this->data['dfrom'] = @$_GET['dfrom'];
                $this->data['dto'] = @$_GET['dto'];
  
  				$this->data['page_title'] = 'Search Results';
				$this->data['metakey'] = $txtsearch;
				$this->data['metadesc'] = $txtsearch;
                $this->data['langurl'] = base_url()."offers/{langid}";
				$this->theme->view('listing', $this->data);
		}

		
}