<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Home extends MX_Controller {
		public $data = array();
		private $validlang;

		function __construct() {
	  		  	modules :: load('front');
				$this->data['app_settings'] = $this->settings_model->get_settings_data();
			   	$this->data['geo'] = $this->load->get_var('geolib');
				$this->data['phone'] = $this->load->get_var('phone');
				$this->data['contactemail'] = $this->load->get_var('contactemail');
				$this->data['usersession'] = $this->session->userdata('pt_logged_customer');


                $pageslugg = $this->uri->segment(1);
                $this->validlang = pt_isValid_language($pageslugg);
                if($this->validlang){
                  $this->data['lang_set'] =  $pageslugg;
                }else{
                 $this->data['lang_set'] = $this->session->userdata('set_lang');
                }


                $defaultlang = pt_get_default_language();

				if (empty ($this->data['lang_set'])) {
						$this->data['lang_set'] = $defaultlang;
				}

				$this->data['eancheckin'] = date("m/d/Y", strtotime("+1 days"));
				$this->data['eancheckout'] = date("m/d/Y", strtotime("+2 days"));

				$this->data['ctcheckin'] = date("m/d/Y", strtotime("+1 days"));
				$this->data['ctcheckout'] = date("m/d/Y", strtotime("+2 days"));




		}

		public function index() {

		        $this->lang->load("front", $this->data['lang_set']);
				$pageslug = $this->uri->segment(1);
				$secondslug = $this->uri->segment(2);
				$this->load->library('sliders_lib');
				$this->data['sliderlib'] = $this->sliders_lib;

				$langid = $this->session->userdata('set_lang');
				$defaultlang = pt_get_default_language();
				if (empty ($langid)) {
						$langid = $defaultlang;
				}
                if($this->validlang){
                 $pageslug = $this->uri->segment(2);
                }
                $check = $this->cms_model->check($pageslug);

				if ($pageslug == null || $this->validlang && empty($secondslug)) {
						$this->load->model('admin/special_offers_model');
						$activeModules = array();
						//$this->data['featuredSection']['modules'] = array();
						
                        if (pt_main_module_available('hotels')) {
                        	    $activeModules[] = "hotels";
								$this->load->library('hotels/hotels_lib');
								$this->data['hotelslib'] = $this->hotels_lib;
								$this->load->helper("hotels/hotels");
								$this->load->model('hotels/hotels_model');

								$this->data['totalStay'] = $this->hotels_lib->stay;
								$this->data['adults'] = $this->hotels_lib->adults;
								$this->data['child'] = (int) $this->hotels_lib->children;

					        //	$this->data['latest_hotels'] = $this->hotels_model->latest_hotels_front();
								$this->data['hotelslocationsList'] = $this->hotels_lib->getLocationsList();
                                $this->data['featuredHotels'] = $this->hotels_lib->getFeaturedHotels();
                                $this->data['popularHotels'] = $this->hotels_lib->getTopRatedHotels();
					        //	$this->data['hero_hotels'] = $this->hotels_lib->hero_hotels_list();
					        //	$this->data['mini_hero_hotels'] = $this->hotels_lib->mini_hero_hotels_list();
                            	$this->data['featuredSection']['modules']["hotels"] = (object)array("featured" => $this->hotels_lib->getFeaturedHotels(),'moduleTitle' => trans('Hotels'), 'bgImg' => 'featured-hotels.jpg', 'booknowClass' => 'primary','featuredText' => trans('056'), 'featuredPrice' => 75,'currCode' => 'USD');
						}

						if (pt_main_module_available('tours')) {
								$activeModules[] = "tours";
								$this->load->library('tours/tours_lib');
								$this->data['tourslib'] = $this->tours_lib;
								$this->data['locationsList'] = $this->tours_lib->getLocationsList();
								$this->data['featuredTours'] = $this->tours_lib->getFeaturedTours();
								$this->data['popularTours'] = $this->tours_lib->getTopRatedTours();
								$this->data['moduleTypes'] = $this->tours_lib->tourTypes();

								$this->data['checkin'] = $this->tours_lib->date;
								$this->data['adults'] = $this->tours_lib->adults;
								$this->data['child'] = (int) $this->tours_lib->child;
								
								$this->data['featuredSection']['modules']["tours"] = (object)array("featured" => $this->tours_lib->getFeaturedTours(),'moduleTitle' => trans('Tours'), 'bgImg' => 'featured-tours.jpg', 'booknowClass' => 'warning','featuredText' => trans('0451'), 'featuredPrice' => 200,'currCode' => 'USD');
								$this->data['tourLocations'] = $this->tours_lib->toursByLocations();	

								$this->load->helper("tours/tours_front");
								$this->load->model('tours/tours_model');
						}
						if (pt_main_module_available('cars')) {
								$activeModules[] = "cars";
								$this->load->library('cars/cars_lib');
								$this->data['carslib'] = $this->cars_lib;
								$this->data['carslocationsList'] = $this->cars_lib->getLocationsList();
								$this->data['carspickuplocationsList'] = $this->cars_lib->getPickupLocationsList();
								$this->data['carsdropofflocationsList'] = $this->cars_lib->getDropLocationsList();
								$this->data['featuredCars'] = $this->cars_lib->getFeaturedCars();
								$this->data['popularCars'] = $this->cars_lib->getTopRatedCars();

								$this->data['cartypes'] = $this->cars_lib->carTypes();

								$this->data['carModTiming'] = $this->cars_lib->timingList();
								$this->data['featuredSection']['modules']["cars"] = (object)array("featured" => $this->cars_lib->getFeaturedCars(),'moduleTitle' => trans('Cars'), 'bgImg' => 'featured-cars.jpg', 'booknowClass' => 'success','featuredText' => trans('0142'), 'featuredPrice' => 125,'currCode' => 'USD');
						

								$this->load->helper("cars/cars_front");
								$this->load->model('cars/cars_model');

						}
						$totalFeatured = count($this->data['featuredSection']['modules']);
						if($totalFeatured == 1){
						$this->data['featuredSection']['divClass'] = "col-lg-12";	
						}else if($totalFeatured == 2){
						$this->data['featuredSection']['divClass'] = "col-md-6";
						}else{
						$this->data['featuredSection']['divClass'] = "";	
						}

					/*	$this->data['featuredSection']['modules'] = array(
							"tours" => (object)array("featured" => $this->tours_lib->getFeaturedTours(),'moduleTitle' => trans('Tours'), 'bgImg' => 'featured-tours.jpg', 'booknowClass' => 'warning','featuredText' => trans('0451'), 'featuredPrice' => 200,'currCode' => 'USD'),
							"cars" => (object)array("featured" => $this->cars_lib->getFeaturedCars(),'moduleTitle' => trans('Cars'), 'bgImg' => 'featured-cars.jpg', 'booknowClass' => 'success','featuredText' => trans('0142'), 'featuredPrice' => 125,'currCode' => 'USD'),
							);*/

						

						if (pt_main_module_available('ean')) {
								$activeModules[] = "ean";
								$this->load->library('ean/ean_lib');
								$this->data['eanib'] = $this->ean_lib;
								$this->data['adults'] = 2;


                                $this->data['popularHotelsEan'] = $this->ean_lib->getHomePagePopularHotels();
                                $this->data['featuredHotelsEan'] = $this->ean_lib->getHomePageFeaturedHotels();

						}

						if (pt_main_module_available('cruises')) {
								$this->load->helper("cruises/cruises_front");
								$this->load->model('cruises/cruises_model');
								$this->data['latest_cruises'] = $this->cruises_model->latest_cruises_front();
						}
                        if (pt_main_module_available('blog')) {
								$this->load->library('blog/blog_lib');
								$this->data['bloglib'] = $this->blog_lib;
								$this->load->helper("blog/blog_front");
								$this->data['posts'] = $this->blog_lib->latest_posts_homepage();
						}


						if (pt_main_module_available('cartrawler')) {
								$this->load->library('cartrawler/cartrawler_lib');
								$this->data['timing'] = $this->cartrawler_lib->timingList();

						}
						$dohopsettings = $this->settings_model->get_front_settings("flightsdohop");
						$cartrawlersettings = $this->settings_model->get_front_settings("cartrawler");
						$hotelsettings = $this->settings_model->get_front_settings("hotels");
						$bookingsettings = $this->settings_model->get_front_settings("booking");

						$this->data['topcities'] = explode(",", $hotelsettings[0]->front_top_cities);
						$this->data['offersenabled'] = $this->is_module_enabled('offers');
						if ($this->data['offersenabled']) {
								$this->load->library('offers_lib');
								$sOffers = $this->offers_lib->getHomePageOffers();
								$this->data['specialoffers'] = $sOffers['offers'];
								$this->data['offersCount'] = $sOffers['count'];
						}
						$activeModulesCount = count($activeModules);
						$divCol = 4;
						if($activeModulesCount == 1){
							$divCol = 12;
						}elseif($activeModulesCount == 2){
							$divCol = 6;
						}else{
							$divCol = 4;
						}

						$this->data['divCol'] = $divCol;

						$this->data['checkin'] = date($this->data['app_settings'][0]->date_f,strtotime('+'.CHECKIN_SPAN.' day', time()));
						$this->data['checkinMonth'] = strtoupper(date("F",strtotime('+'.CHECKIN_SPAN.' day', time())));
						$this->data['checkinDay'] = date("d",strtotime('+'.CHECKIN_SPAN.' day', time()));
                        $this->data['checkout'] = date($this->data['app_settings'][0]->date_f, strtotime('+'.CHECKOUT_SPAN.' day', time()));
                       
                        $this->data['checkoutMonth'] = strtoupper(date("F",strtotime('+'.CHECKOUT_SPAN.' day', time())));
                        $this->data['checkoutDay'] = date("d",strtotime('+'.CHECKOUT_SPAN.' day', time()));
						$this->data['dohopusername'] = $dohopsettings[0]->cid;
						$this->data['cartrawlerid'] = $cartrawlersettings[0]->cid;
						$this->data['affiliate'] = $bookingsettings[0]->cid;
						$this->data['ishome'] = "1";
						$this->data['main_content'] = 'index';
                        $this->data['langurl'] = base_url()."{langid}";
						$this->data['page_title'] = $this->data['app_settings'][0]->home_title;
						$this->theme->view('home/index', $this->data);
				}
				elseif ($check) {

						$content = $this->cms_model->get_page_content($pageslug, $langid);
						if (empty ($content)) {
								$content = $this->cms_model->get_page_content($pageslug, '1');
						}
						$submitcontactform = $this->input->post('submit_contact');
						$this->data['res2'] = $this->settings_model->get_contact_page_details();
						if (!empty ($submitcontactform)) {
								$this->form_validation->set_rules('contact_email', 'Email', 'trim|required|valid_email');
								$this->form_validation->set_rules('contact_message', 'Message', 'trim|required');
								if ($this->form_validation->run() == FALSE) {
										$this->data['validationerrors'] = validation_errors();
								}
								else {
										$this->load->model("admin/emails_model");
										$senddata = array('contact_email' => $this->input->post('contact_email'), 'contact_name' => $this->input->post('contact_name'), 'contact_subject' => $this->input->post('contact_subject'), 'contact_message' => $this->input->post('contact_message'));
										$this->emails_model->send_contact_email($this->data['res2'][0]->contact_email, $senddata);
										$this->data['successmsg'] = "Message Sent Successfully";
								}
						}
						$this->data['page_contents'] = $content;
						$this->data['main_content'] = 'cms/page-data';
						$this->data['metakey'] = @$content[0]->content_meta_keywords;
						$this->data['metadesc'] = @$content[0]->content_meta_desc;
						$this->data['page_title'] = @$content[0]->content_page_title;
						$this->data['langurl'] = base_url()."{langid}/".$pageslug;

						if (strpos(@ $content[0]->content_body, '{optional}') !== false) {
								$this->theme->view('optional', $this->data);
						}
						else {
							if(strtolower($pageslug) == "contact-us"){

								$this->theme->view('contact', $this->data);

							}else{
									$this->theme->view('cms/page-data', $this->data);
							}
						}
				}
				elseif($this->validlang && $pageslug == "supplier-register"){
					$this->supplier_register();

				}else{

						Error_404($this->data);
				}
		}

		function supplier_register() {

                $allowsupplierreg = $this->data['app_settings'][0]->allow_supplier_registration;
                if($allowsupplierreg == "0"){
                Error_404();
                exit;
                }
				$this->load->model('admin/countries_model');
				$this->load->model('admin/accounts_model');
				$this->data['error'] = "";
				$this->data['success'] = $this->session->flashdata('success');
				$addaccount = $this->input->post('addaccount');
				$url = http_build_query($_GET);
				if (!empty ($addaccount)) {
						$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pt_accounts.accounts_email]');
						$this->form_validation->set_message('valid_email', 'Kindly Enter a Valid Email Address.');
						$this->form_validation->set_message('is_unique', 'Email Address is Already in Use.');
						$this->form_validation->set_rules('country', 'Country', 'trim|required');
						$this->form_validation->set_rules('city', 'City', 'trim');
						$this->form_validation->set_rules('state', 'State', 'trim');
						$this->form_validation->set_rules('fname', 'First Name', 'trim');
						$this->form_validation->set_rules('lname', 'Last Name', 'trim');
						$this->form_validation->set_rules('address1', 'address 1', 'trim');
						$this->form_validation->set_rules('address2', 'address 2', 'trim');
						$this->form_validation->set_rules('mobile', 'mobile', 'trim');
						$this->form_validation->set_rules('itemname', 'Name', 'trim|required');
						if ($this->form_validation->run() == FALSE) {
								$this->data['error'] = validation_errors();
						}
						else {
/* if(isset($_FILES['photo']) && !empty($_FILES['photo']['name'])){



$result = $this->uploads_model->__profileimg();

if($result == '1'){

$this->data['errormsg'] = "Invalid file type kindly select only jpg/jpeg, png, gif file types";



}elseif($result == '2'){



$this->data['errormsg'] = "Only upto 2MB size photos allowed";



}elseif($result == '3'){





$this->session->set_flashdata('flashmsgs', "Customer Account Added Successfully");



redirect('admin/accounts/customers/');



}

}else{*/
								
								$this->accounts_model->register_supplier();
								//$this->session->set_flashdata('success', trans('0244'));
								$this->data['success'] = "1";
								//redirect(base_url() . 'supplier-register');
//   }
						}
				}
				$this->lang->load("front", $this->data['lang_set']);
				$restricted = $this->data['app_settings'][0]->restrict_website;
				if($restricted == "Yes"){
				$this->data['hidden'] = "hidden-sm hidden-lg";
				}
				$this->data['allcountries'] = $this->countries_model->get_all_countries();
				$this->data['modules'] = $this->available_modules();
				$this->data['langurl'] = base_url()."{langid}/supplier-register";
				$this->data['page_title'] = "supplier Registration";
				$this->theme->view('supplier-register', $this->data);
		}

// get all available modules for front - without integration modules
		function available_modules() {
				$modules = array();
				$modlib = $this->ptmodules;
				$mainmodules = $modlib->moduleslist;
				$notallowed = array("blog");
				foreach ($mainmodules as $mainmod) {
						$istrue = $modlib->is_mod_available_enabled($mainmod);
						$isintegration = $modlib->is_integration($mainmod);
						if ($istrue && !$isintegration && !in_array($mainmod, $notallowed)) {
								$modules[] = $mainmod;
						}
				}
				return $modules;
		}

// check module availability
		function is_module_enabled($module) {
				$result = $this->modules_model->check_module($module);
				return $result;
		}

// check main module availability
		function is_main_module_enabled($module) {
				$result = $this->modules_model->check_main_module($module);

				return $result;
		}

//subscribe to newsletter
		function subscribe() {
				if (!$this->input->is_ajax_request()) {
						redirect(base_url());
				}
				else {
						$this->load->model('admin/newsletter_model');
						$email = $this->input->post('email');
						$this->form_validation->set_message('valid_email', 'Kindly Enter a Valid Email Address.');
						$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
						if ($this->form_validation->run() == FALSE) {
								echo validation_errors();
						}
						else {
								$res = $this->newsletter_model->add_subscriber($email);
								if ($res) {
										echo "Subscribed Successfully";
								}
								else {
										echo "Already Subscribed";
								}
						}
				}
		}

		function txtsearch() {
				
		}

		function trackorder() {
				if ($this->input->is_ajax_request()) {
						$this->db->select('booking_status,booking_expiry,booking_deposit,booking_total');
						$this->db->where('booking_id', $this->input->post('code'));
						$rs = $this->db->get('pt_bookings')->result();
						if (!empty ($rs)) {
								$html = "<p>Invoice Status : " . $rs[0]->booking_status . "</p>";
								$html .= "<p>Total : " . $this->data['app_settings'][0]->currency_code . " " . $this->data['app_settings'][0]->currency_sign . $rs[0]->booking_total . "</p>";
								if ($rs[0]->booking_status == "unpaid") {
										$html .= " <p>Due Date : " . pt_translate_it($rs[0]->booking_expiry) . "</p>";
								}
								echo $html;
						}
						else {
								echo "<div class='alert alert-danger'>Invalid Code</div>";
						}
				}
				else {
						redirect(base_url());
				}
		}

		function maps($lat = null, $long = null, $type, $id) {
				if (empty ($lat) || empty ($long)) {
						Error_404();
				}
				else {
						if ($type == "hotels") {
						  $this->load->model("hotels/hotels_model");
								$hoteldata = $this->hotels_model->hotel_data_for_map($id);
								$img = pt_default_hotel_image($id);
                               	$img = PT_HOTELS_SLIDER_THUMBS . $img;
							   if (!empty ($hoteldata)) {
										$title = character_limiter($hoteldata[0]->hotel_title,15);
										$slug = $hoteldata[0]->hotel_slug;
								}
								else {
										$title = '';
								}
								$link = site_url('hotels/' . $slug);
								pt_show_map($lat, $long, '100%', '100%', $title, $img, 150, 80, $link);
						}
						elseif ($type == "tours") {
								$this->load->library('tours/tours_lib');
								$this->tours_lib->set_id($id);
								$this->tours_lib->tour_short_details();
                               	$title = character_limiter($this->tours_lib->title,15);
                               	$img = $this->tours_lib->thumbnail;

								$link = $this->tours_lib->slug;
								pt_show_map($lat, $long, '100%', '100%', $title, $img, 80, 80, $link);
						}
						elseif ($type == "cars") {
								$this->load->library('cars/cars_lib');
								$this->cars_lib->set_id($id);
								$this->cars_lib->car_short_details();
                               	$title = character_limiter($this->cars_lib->title,15);
                               	$img = $this->cars_lib->thumbnail;

								$link = $this->cars_lib->slug;
								pt_show_map($lat, $long, '100%', '100%', $title, $img, 80, 80, $link);
						}
						elseif($type == "ean"){
								$link = "#";
								$img = $this->session->userdata('hotelThumb');

								pt_show_map($lat, $long, '100%', '100%', $title, $img, 80, 80, $link);
						}
				}
		}

		function error(){


        $this->data['page_title'] = trans("0268");
        $this->theme->view('404',$this->data);

		}

		function cmsupload(){

			$url = 'uploads/cms/images/'.time().'_'.$_FILES['upload']['name'];
			$functionNum = $_GET['CKEditorFuncNum'] ;


			if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) )
			{
			$message = "No file uploaded.";
			}
			else if ($_FILES['upload']["size"] == 0)
			{
			$message = "The file is of zero length.";
			}
			else if (($_FILES['upload']["type"] != "image/pjpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png"))
			{
			$message = "Invalid Image.";
			}
			else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
			{
			$message = "Hacking attempt Denied, don't try this here.";
			}
			else if (strpos($_FILES['upload']['name'],'php') !== false) {
			$message = "Hacking attempt Denied, don't try to upload shells.";
			}
			else {
			$message = "";
			$move = @ move_uploaded_file($_FILES['upload']['tmp_name'], $url);
			if(!$move)
			{
			$message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
			}
			$url = base_url() . $url;
			}

			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($functionNum, '$url', '$message');</script>";


		}


		function suggestions($module){

				$query = $this->input->get('q');
				if(!empty($query)){
					
				$result = array();
				if($module == "hotels"){
					$this->load->library("hotels/hotels_lib");
					$result = $this->hotels_lib->suggestionResults($query);

				}elseif($module == "tours"){
					$this->load->library("tours/tours_lib");
					$result = $this->tours_lib->suggestionResults($query);
				}
			    
				//echo "<p>This is html</p>";
				echo json_encode($result);
				
					
				}
				

			
		}




 }
