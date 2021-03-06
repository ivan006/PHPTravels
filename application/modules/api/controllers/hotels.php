<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/api/libraries/REST_Controller.php';

class Hotels extends REST_Controller {
	private $settings;
		function __construct() {
// Construct our parent class
				parent :: __construct();

			if(!$this->isValidApiKey){
               	$this->response($this->invalidResponse, 400);
             }
// Configure limits on our controller methods. Ensure
// you have created the 'limits' table and enabled 'limits'
// within application/config/rest.php
				$this->methods['list_get']['limit'] = 500; //500 requests per hour per user/key
				$this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
				$this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
				$this->load->library('hotels/hotels_lib');
				$this->load->model('api/apihotels_model');
				$this->settings = $this->settings_model->get_settings_data();
		}

		function featured_get() {
				$list = $this->apihotels_model->get_featured_hotels();
				if (!empty ($list)) {
						$this->response(array('response' => $list, 'error' => array('status' => FALSE,'msg' => '')), 200);
						
				}
				else {
						$this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Hotels could not be found')), 200);
				}
		}

		function locations_get(){
        $locations = $this->hotels_lib->getLocationsList();
        $locArray = array();
        foreach($locations as $loc){
            $locArray[] = array('id' => $loc->id, 'name' => $loc->name); 
        }
        
         if (!empty ($locArray)) {
            $this->response(array('locations' => $locArray), 200); // 200 being the HTTP response code
        }
        else {
            $this->response(array('response' => array('error' => 'Locations could not be found')), 200);
        }
   	   }

		function list_get() {
			//	$perpage = $this->get('perpage');
				$offset = $this->get('offset');
				// if (empty ($perpage)) {
				// 		$perpage = 10;
				// }
				if (empty ($offset)) {
						$offset = 1;
				}
				$list = $this->hotels_lib->show_hotels($offset);
				$Objresponse = $list['all_hotels'];
				$totalPages = ceil($list['paginationinfo']['totalrows'] / $list['paginationinfo']['perpage']);
				if (!empty ($Objresponse)){
					$this->response(array('response' => $Objresponse, 'error' => array('status' => FALSE,'msg' => ''), 'totalPages' => $totalPages), 200);
					
				}else {

					$this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Hotels Not found')), 200);
				}
		}

		function hoteldetails_get() {
				if (!$this->get('id')) {
						$this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Hotel ID is required')), 200);
				}

				$this->hotels_lib->set_id($this->get('id'));
                $details['hotel'] = $this->hotels_lib->hotel_details();

                $appCheckin= $this->get('checkin'); 
                if(empty($appCheckin)){
                	$checkin = ""; 
                }else{
                $checkin = date($this->settings[0]->date_f, strtotime($appCheckin)); 	
                }

                $appCheckout = $this->get('checkout'); 
                if(empty($appCheckout)){
                	$checkout = ""; 
                }else{
                $checkout = date($this->settings[0]->date_f, strtotime($appCheckout));
                }
				

				
				

				$details['rooms'] = $this->hotels_lib->hotel_rooms($details['hotel']->id,$checkin,$checkout);
                $details['tripadvisorinfo'] = tripAdvisorInfo($this->hotels_lib->tripadvisorid);
                if (pt_is_module_enabled('reviews')) {
								$details['reviews'] = $this->hotels_lib->hotel_reviews_for_api($details['hotel']->id);
								$details['avgReviews'] = $this->hotels_lib->hotelReviewsAvg($details['hotel']->id);
				}

				//$details = $this->apihotels_model->hotel_details($this->get('id'));
				if (!empty ($details)) {
					$this->response(array('response' => $details, 'error' => array('status' => FALSE,'msg' => '')), 200);
				}
				else {
					$this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Hotel Details Could Not be Found')), 200);
				}
		}

		function book_get() {
			
				if (!$this->get('hotelId')) {
						$this->response(array('response' => array('error' => 'Hotel ID is required')), 200);
				}
				if (!$this->get('checkIn')) {
						$this->response(array('response' => array('error' => 'Check In date is required')), 200);
				}
				if (!$this->get('checkOut')) {
						$this->response(array('response' => array('error' => 'Check Out date is required')), 200);
				}
				$appCheckin= $this->get('checkIn'); 
				$checkin = date($this->settings[0]->date_f, strtotime($appCheckin)); 

				$appCheckout = $this->get('checkOut'); 
				$checkout = date($this->settings[0]->date_f, strtotime($appCheckout));

				$details = $this->hotels_lib->getBookResultObject($this->get('hotelId'),$this->get('roomId'),$this->get('roomsCount'),$extrabeds = 0,$checkin,$checkout);
				
				 if (!empty ($details['hotel'])) {
				 		$this->response($details, 200); // 200 being the HTTP response code
				 }
				 else {
				 		$this->response(array('response' => array('error' => 'Hotel Details could not be found')), 200);
				 }
		}

		function search_get() {
			

				if (!$this->get('checkin')) {
						$this->response(array('response' => array('error' => 'Check In date is required')), 200);
				}
				if (!$this->get('checkout')) {
						$this->response(array('response' => array('error' => 'Check Out date is required')), 200);
				}
				$offset = $this->input->get('offset');
				$appCheckin= $this->get('checkin'); 
				$checkin = date($this->settings[0]->date_f, strtotime($appCheckin)); 

				$appCheckout = $this->get('checkout'); 
				$checkout = date($this->settings[0]->date_f, strtotime($appCheckout));
				$cityid = $this->get('searching');

				$details = $this->hotels_lib->search_hotels_by_text($cityid, $offset, $checkin,$checkout);
				
				
				
				if (!empty ($details['all'])) {
						$this->response($details['all'], 200); // 200 being the HTTP response code
					//	$this->response($this->get(), 200); // 200 being the HTTP response code
				}
				else {
						$this->response(array('response' => array('error' => 'Results Not found')), 200);
				}
		}

		function user_post() {
				$message = array('name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
				$this->response($message, 200); // 200 being the HTTP response code
		}

		function invoice_post() {
				$this->load->model('admin/bookings_model');
				$userid = $this->post('userId');
				if(!empty($userid)){
				$data = $this->bookings_model->do_booking($userid);
				}else{
				$data = $this->bookings_model->doGuestBooking();	
				}
				
				$message = array('response' => $data);
				$this->response($message, 200); // 200 being the HTTP response code
		}

        function countries_get() {
          $this->load->model('admin/countries_model');
          $list = $this->countries_model->Api_all_countries();
	    	if (!empty ($list)) {
						$this->response(array('response' => $list, 200)); // 200 being the HTTP response code
				}
				else {
						$this->response(array('response' => array('error' => 'countries could not be found')), 200);
				}
		}

		function show_get($param,$vars = null) {
			$arr = $this->input->get();
			$arrstr = "";
			foreach($arr as $key => $val){
				$arrstr .= $key."=".$val."&"; 
			}

			 $url = base_url()."api/hotels/".$param."?".$arrstr;
			//				$url = base_url() . "api/hotels/hoteldetails?id=40";
			//  $url = base_url()."api/hotels/book?id=40&checkin=20/01/2015&checkout=22/01/2015";
			//  $url = base_url()."api/hotels/user";
			$ch = curl_init();
			$timeout = 3;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$rawdata = curl_exec($ch);
			curl_close($ch);
			@ $json = json_decode($rawdata);
			echo "<pre>";
			print_r($json);
		}

		function chkpost_get() {
// $url = base_url()."api/hotels/list";
// $url = base_url()."api/hotels/hoteldetails?id=40";
//  $url = base_url()."api/hotels/book?id=40&checkin=20/01/2015&checkout=22/01/2015";
				$url = base_url() . "api/hotels/invoice";
				$fields = array('email' => 'irshad@yahoo.com', 'firstname' => 'irshad', 'room' => "25_250_2", 'checkin' => "12/01/2015", 'checkout' => "15/01/2015", 'lastname' => "irshad", 'phone' => "1323", 'address' => "fafdasf", 'payment_type' => 'Paypal_Express', 'id' => "123", 'title' => "hotel name", 'depost' => "123", 'total_amount' => "456", 'tax' => "123456", 'payment_method_tax' => "15", 'nights' => 3);
//url-ify the data for the POST
				foreach ($fields as $key => $value) {
						$fields_string .= $key . '=' . $value . '&';
				}
				rtrim($fields_string, '&');
				$ch = curl_init();
				$timeout = 3;
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_POST, count($fields));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$rawdata = curl_exec($ch);
				curl_close($ch);
				@ $json = json_decode($rawdata);
				echo "<pre>";
				print_r($json);
		}

}