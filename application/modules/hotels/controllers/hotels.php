<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Hotels extends MX_Controller {
		private $data = array();
		private $validlang;
		function __construct() {
				parent :: __construct();

				$chk = modules :: run('home/is_main_module_enabled', 'hotels');
				if (!$chk) {
						Module_404();
				}
				
			  	modules :: load('home');
                $this->load->library('hotels/hotels_lib');
                $this->load->model('hotels/hotels_model');
				$this->data['phone'] = $this->load->get_var('phone');
				$this->data['contactemail'] = $this->load->get_var('contactemail');
				$this->data['app_settings'] = $this->settings_model->get_settings_data();
				$this->data['usersession'] = $this->session->userdata('pt_logged_customer');
				$this->data['appModule'] = "hotels";

			
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

              	
                $this->hotels_lib->set_lang($this->data['lang_set']);
                $this->data['locationsList']  = $this->hotels_lib->getLocationsList();
         
                $this->data['modulelib'] = $this->hotels_lib;

		}

		public function index() {
				$this->load->library('hotels/hotels_calendar_lib');
				$this->data['calendar'] = $this->hotels_calendar_lib;
				$settings = $this->settings_model->get_front_settings('hotels');
				$this->data['minprice'] = $settings[0]->front_search_min_price;
				$this->data['maxprice'] = $settings[0]->front_search_max_price;
                if($this->validlang){

					//$countryName = $this->uri->segment(3);
					//$cityName = $this->uri->segment(4);
                    $hotelname = $this->uri->segment(5);

                }else{

                   // $countryName = $this->uri->segment(2);
                   // $cityName = $this->uri->segment(3);
                    $hotelname = $this->uri->segment(4);
                }

				$check = $this->hotels_model->hotel_exists($hotelname);
  				if ($check && !empty($hotelname)) {

                      $this->hotels_lib->set_hotelid($hotelname);
                      $this->data['module'] = $this->hotels_lib->hotel_details();

				      $this->data['hasRooms'] = $this->hotels_lib->totalRooms($this->data['module']->id);
				      $this->data['rooms'] = $this->hotels_lib->hotel_rooms($this->data['module']->id);

				      // Availability Calender settings variables
				      $this->data['from1'] = date("F Y"); 
				      $this->data['to1'] = date("F Y", strtotime('+5 months')); 
				      $this->data['from2'] = date("F Y",strtotime('+6 months')); 
				      $this->data['to2'] = date("F Y",strtotime('+11 months')); 
				      $this->data['from3'] = date("F Y",strtotime('+12 months')); 
				      $this->data['to3'] = date("F Y",strtotime('+17 months')); 
				      $this->data['from4'] = date("F Y",strtotime('+18 months')); 
				      $this->data['to4'] = date("F Y",strtotime('+23 months'));
				      $this->data['first'] = date("m").",".date("Y"); 
				      $this->data['second'] = date("m", strtotime('+6 months')).",".date("Y", strtotime('+6 months')); 
				      $this->data['third'] = date("m", strtotime('+12 months')).",".date("Y", strtotime('+12 months')); 
				      $this->data['fourth'] = date("m", strtotime('+18 months')).",".date("Y", strtotime('+18 months'));  
				       // End Availability Calender settings variables	
                      $this->data['tripadvisorinfo'] = tripAdvisorInfo($this->data['module']->tripadvisorid);

                      	if(!empty($this->data['tripadvisorinfo']->rating)){

					$tripAdvisorReviews =  $this->hotels_lib->tripAdvisorData($this->data['module']->tripadvisorid, $this->data['tripadvisorinfo']);
					$this->data['reviews']  = $tripAdvisorReviews->reviews;

                      	}else{

                      		$this->data['reviews'] = $this->hotels_lib->hotelReviews($this->data['module']->id);
							$this->data['avgReviews'] = $this->hotels_lib->hotelReviewsAvg($this->data['module']->id);
                      	}
						
				$this->data['checkinMonth'] = strtoupper(date("F",convert_to_unix($this->hotels_lib->checkin)));
				$this->data['checkinDay'] = date("d",convert_to_unix($this->hotels_lib->checkin));
				$this->data['checkoutMonth'] = strtoupper(date("F",convert_to_unix($this->hotels_lib->checkout)));
				$this->data['checkoutDay'] = date("d",convert_to_unix($this->hotels_lib->checkout));		

					// Split date for new date desing on hotel single page	
					$checkin = explode("/",$this->hotels_lib->checkin);
					$this->data['d1first'] = $checkin[0];		
					$this->data['d1second'] = $checkin[1];		
					$this->data['d1third'] = $checkin[2];

					$checkout = explode("/",$this->hotels_lib->checkout);
					$this->data['d2first'] = $checkout[0];		
					$this->data['d2second'] = $checkout[1];		
					$this->data['d2third'] = $checkout[2];

					// end Split date for new date desing on hotel single page	
					  $this->lang->load("front", $this->data['lang_set']);

					$this->data['totalStay'] = $this->hotels_lib->stay;
					$this->data['adults'] = $this->hotels_lib->adults;
					$this->data['child'] = (int) $this->hotels_lib->children;
					

					  $this->data['currencySign'] = $this->hotels_lib->currencysign;
					  $this->data['lowestPrice'] = $this->hotels_lib->bestPrice($this->data['module']->id);
					  $this->data['allowreg'] = $this->data['app_settings'][0]->allow_registration;	
                      $this->data['page_title'] =  $this->data['module']->title;
                      $this->data['metakey'] = $this->data['module']->keywords;
					  $this->data['metadesc'] = $this->data['module']->metadesc;
					  $this->data['langurl'] = base_url()."hotels/{langid}/".$this->data['module']->slug;
					  $this->theme->view('details', $this->data);
				}
                else {
						$this->listing();
				}
		}

		function listing($offset = null){
			    $this->lang->load("front", $this->data['lang_set']);
				$this->data['sorturl'] = base_url() . 'hotels/listings?';
				$settings = $this->settings_model->get_front_settings('hotels');
				$this->data['minprice'] = $this->hotels_lib->convertAmount($settings[0]->front_search_min_price);
				$this->data['maxprice'] = $this->hotels_lib->convertAmount($settings[0]->front_search_max_price);
				
				//$this->data['popular_hotels'] = $this->hotels_model->popular_hotels_front();
				$allhotels = $this->hotels_lib->show_hotels($offset);
                $this->data['moduleTypes'] = $this->hotels_lib->getHotelTypes();
                $this->data['amenities'] = $this->hotels_lib->getHotelAmenities();
                $this->data['checkin'] = @$_GET['checkin'];
                $this->data['checkout'] = @$_GET['checkout'];
                if(empty($checkin)){
                  $this->data['checkin'] = $this->hotels_lib->checkin;
                }

                if(empty($checkout)){
                  $this->data['checkout'] = $this->hotels_lib->checkout;
                }

                $chin = $this->hotels_lib->checkin;
                $chout = $this->hotels_lib->checkout;
                if(empty($chin) || empty($chout)){
                $this->data['pricehead'] = trans('0396');
				}else{
                $this->data['pricehead'] = trans('0397')." ".$this->hotels_lib->stay." ".trans('0122');

                }

                $this->data['totalStay'] = $this->hotels_lib->stay;
                $this->data['adults'] = $this->hotels_lib->adults;
                $this->data['child'] = (int) $this->hotels_lib->children;
                
                $this->data['selectedLocation'] = $this->hotels_lib->selectedLocation;
                $this->data['module'] = $allhotels['all_hotels'];
				$this->data['info'] = $allhotels['paginationinfo'];
				$this->data['plinks2'] = $allhotels['plinks2'];
				$this->data['currCode'] = $this->hotels_lib->currencycode;
				$this->data['currSign'] = $this->hotels_lib->currencysign;
				$this->data['page_title'] = $settings[0]->header_title;
				$this->data['metakey'] = $settings[0]->meta_keywords;
				$this->data['metadesc'] = $settings[0]->meta_description;
                $this->data['langurl'] = base_url()."hotels/{langid}";
				$this->theme->view('listing', $this->data);
		}

		function search($country = null, $city = null, $citycode = null, $offset = null) {

				$surl = http_build_query($_GET);
				$this->data['sorturl'] = base_url() . 'hotels/search?' . $surl . '&';
				$checkin = $this->input->get('checkin');
				$checkout = $this->input->get('checkout');

                $type = $this->input->get('type');
				$cityid = $this->input->get('searching');
				$modType = $this->input->get('modType');
				if(empty($country)){
					
					$surl = http_build_query($_GET);
					$locationInfo = pt_LocationsInfo($cityid);
					$country = url_title($locationInfo->country, 'dash', true);
					$city = url_title($locationInfo->city, 'dash', true);
					$cityid = $locationInfo->id;
					if(!empty($cityid) && $modType == "location"){
						redirect('hotels/search/'.$country.'/'.$city.'/'.$cityid.'?'.$surl);
					}else if(!empty($cityid) && $modType == "hotel"){
						$this->hotels_lib->set_id($cityid);
						$this->hotels_lib->hotel_short_details();
						$title = $this->hotels_lib->title;
						$slug = $this->hotels_lib->slug;
						if(!empty($title)){
							redirect('hotels/'.$slug);
						}
						
					}
					

				}else{
					if($modType == "location"){
					$cityid = $citycode;	
					}else{
					$cityid = "";
					}
					
					if(is_numeric($country)){
						$offset = $country;
					}
					
				}
				

      
   				if (array_filter($_GET)) {
   				
						if (!empty ($cityid) && $modType == "location") {
					
								$allhotels = $this->hotels_lib->search_hotels_by_text($cityid, $offset);
						}
						else {
								$allhotels = $this->hotels_lib->search_hotels($offset);
						}
                        $this->data['module'] = $allhotels['all'];
			        	$this->data['info'] = $allhotels['paginationinfo'];

						$this->data['plinks'] = $allhotels['plinks'];
				}
				else {
						$this->data['module'] = array();
				}
                $this->data['checkin'] = @$_GET['checkin'];
                $this->data['checkout'] = @$_GET['checkout'];
                if(empty($checkin)){
                	
                  $this->data['checkin'] = $this->hotels_lib->checkin;
                }

                if(empty($checkout)){
                  $this->data['checkout'] = $this->hotels_lib->checkout;
                }


                $chin = $this->hotels_lib->checkin;
                $chout = $this->hotels_lib->checkout;
                if(empty($chin) || empty($chout)){
                $this->data['pricehead'] = trans('0396');
				}else{
                $this->data['pricehead'] = trans('0397')." ".$this->hotels_lib->stay." ".trans('0122');

                }
                $this->data['city'] = $cityid;

                $this->lang->load("front", $this->data['lang_set']);

                $this->data['selectedLocation'] =  $cityid; //$this->hotels_lib->selectedLocation;
                $this->data['totalStay'] = $this->hotels_lib->stay;
                $this->data['adults'] = $this->hotels_lib->adults;
                $this->data['child'] = (int) $this->hotels_lib->children;
                $this->data['searchText'] = $this->input->get('txtSearch');
				$settings = $this->settings_model->get_front_settings('hotels');
				$this->data['amenities'] = $this->hotels_lib->getHotelAmenities();
				$this->data['moduleTypes'] = $this->hotels_lib->getHotelTypes();
				$this->data['minprice'] = $this->hotels_lib->convertAmount($settings[0]->front_search_min_price);
				$this->data['maxprice'] = $this->hotels_lib->convertAmount($settings[0]->front_search_max_price);
				$this->data['currCode'] = $this->hotels_lib->currencycode;
				$this->data['currSign'] = $this->hotels_lib->currencysign;
				$this->data['page_title'] = 'Search Results';
				$this->data['metakey'] = @$country." ".@$city;
				$this->data['metadesc'] = @$country." ".@$city;
                $this->data['langurl'] = base_url()."hotels/{langid}";
				$this->theme->view('listing', $this->data);
		}

		function book($hotelname) {
				$this->load->model('admin/countries_model');

				$this->data['allcountries'] = $this->countries_model->get_all_countries();
				$check = $this->hotels_model->hotel_exists($hotelname);
				$this->load->library("paymentgateways");
				$this->data['hideHeader'] = "1";
				//echo "<pre>";
				//print_r($this->paymentgateways->getAllGateways());
				//echo "</pre>";
  				if ($check && !empty($hotelname)) {
  				  	$this->load->model('admin/payments_model');
                      $this->data['error'] = "";
                      $this->hotels_lib->set_hotelid($hotelname);
                      $hotelID = $this->hotels_lib->get_id();
                      $roomID = $this->input->get('roomid');
                      $roomsCount = $this->input->get('roomscount');
                      $extrabeds = $this->input->get('extrabeds');
                      $bookInfo = $this->hotels_lib->getBookResultObject($hotelID,$roomID,$roomsCount,$extrabeds);
                      $this->data['module'] = $bookInfo['hotel'];
                      $this->data['extraChkUrl'] = $bookInfo['hotel']->extraChkUrl;
                      $this->data['room'] = $bookInfo['room'];
                      if($this->data['room']->price < 1 ||  $this->data['room']->stay < 1){
                        $this->data['error'] = "error";
                      }
                     // $this->data['paymentTypes'] = $this->payments_model->get_all_payments_front();
                      $this->load->model('admin/accounts_model');
                      $loggedin = $this->loggedin = $this->session->userdata('pt_logged_customer');
                      $this->lang->load("front", $this->data['lang_set']);

                      $this->data['profile'] = $this->accounts_model->get_profile_details($loggedin);
                      $this->data['page_title'] = $this->data['module']->title;
					  $this->data['metakey'] = $this->data['module']->keywords;
					  $this->data['metadesc'] = $this->data['module']->metadesc;
					  $this->theme->view('booking', $this->data);
				}else{
                   redirect("hotels");
				}

			  

		}

		function txtsearch() {
				echo $this->hotels_model->textsearch();
		}

		function roomcalendar() {
			    $this->lang->load("front", $this->data['lang_set']);
				$this->load->library('hotels/hotels_calendar_lib');
				$this->data['calendar'] = $this->hotels_calendar_lib;
				$this->data['roomid'] = $this->input->post('roomid');
				$monthYear = explode(",",$this->input->post('monthyear'));
				$this->data['initialmonth'] = $monthYear[0];
				$this->data['year'] = $monthYear[1];
				
				$this->load->view('calendar', $this->data);
		}

		function _remap($method, $params=array()){
		$funcs = get_class_methods($this);

		if(in_array($method, $funcs)){ 

		return call_user_func_array(array($this, $method), $params);
		
		}else{
		
			$result = checkUrlParams($method, $params,$this->validlang);
			if($result->showIndex){
			$this->index();
			}else{
			
				$this->lang->load("front", $this->data['lang_set']);
				$this->data['sorturl'] = base_url() . 'hotels/listings?';
				$settings = $this->settings_model->get_front_settings('hotels');
				$this->data['minprice'] = $this->hotels_lib->convertAmount($settings[0]->front_search_min_price);
				$this->data['maxprice'] = $this->hotels_lib->convertAmount($settings[0]->front_search_max_price);
				
				$allhotels = $this->hotels_lib->showHotelsByLocation($result, $result->offset);
                $this->data['moduleTypes'] = $this->hotels_lib->getHotelTypes();
                $this->data['amenities'] = $this->hotels_lib->getHotelAmenities();
                $this->data['checkin'] = @$_GET['checkin'];
                $this->data['checkout'] = @$_GET['checkout'];
                if(empty($checkin)){
                  $this->data['checkin'] = $this->hotels_lib->checkin;
                }

                if(empty($checkout)){
                  $this->data['checkout'] = $this->hotels_lib->checkout;
                }

                $chin = $this->hotels_lib->checkin;
                $chout = $this->hotels_lib->checkout;
                if(empty($chin) || empty($chout)){
                $this->data['pricehead'] = trans('0396');
				}else{
                $this->data['pricehead'] = trans('0397')." ".$this->hotels_lib->stay." ".trans('0122');

                }
                
                $this->data['selectedLocation'] = $this->hotels_lib->selectedLocation;
                $this->data['module'] = $allhotels['all_hotels'];
				$this->data['info'] = $allhotels['paginationinfo'];
				$this->data['plinks2'] = $allhotels['plinks2'];
				$this->data['currCode'] = $this->hotels_lib->currencycode;
				$this->data['currSign'] = $this->hotels_lib->currencysign;
				$this->data['page_title'] = $settings[0]->header_title;
				$this->data['metakey'] = $settings[0]->meta_keywords;
				$this->data['metadesc'] = $settings[0]->meta_description;
                $this->data['langurl'] = base_url()."hotels/{langid}";
				$this->theme->view('listing', $this->data);	
			
			}
			
		
		
		}

		}

}