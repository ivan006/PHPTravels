<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Supplier extends MX_Controller {
		private $data = array();
		private $abc;
		private $def;
		public $userid;
        public $role;

		function __construct() {
				$this->data['app_settings'] = $this->settings_model->get_settings_data();
				$this->userid = $this->session->userdata('pt_logged_id');
				$this->role = $this->session->userdata('pt_role');
				$this->data['accType'] = $this->session->userdata('pt_accountType');
		/*		$allowreg = $this->data['app_settings'][0]->allow_supplier_registration;
				if ($allowreg == "0") {
					 Error_404();
						exit;
				}*/
				$this->load->helper('date');
				$this->load->helper('pt_includes');
				$this->load->model('helpers_models/translation_model');
				$this->load->model('helpers_models/misc_model');
				$this->load->model('helpers_models/menus_model');
				$this->load->model('admin/countries_model');
				$this->load->model('admin/accounts_model');
				$this->load->model('admin/cms_model');
				$this->load->model('admin/modules_model');
				$this->load->model('admin/newsletter_model');
				$this->load->model('hotels/hotels_model');
				$this->load->model('hotels/rooms_model');
				$this->load->model('supplier/supplier_accounts_model');
				$this->load->model('supplier/supplier_hotel_model');
				$this->load->model('supplier/supplier_room_model');
				$this->load->library('ptmodules');
				$this->data['issupplier'] = $this->session->userdata('pt_logged_supplier');
				$this->data['role'] = $this->role;
				$this->data['fullName'] = $this->session->userdata('fullName');
				$this->data['userloggedin'] = $this->session->userdata('pt_logged_supplier');

				$this->lang->load("back", "en"); 
				
//$this->system();
		}

		public function index() {
//$this->system_resp();
				if ($this->validsupplier()) {
						$addnotes = $this->input->post('addnotes');
						$this->data['canQuickBook'] = pt_permissions("addbooking", $this->data['userloggedin']);
						$updatenotes = $this->input->post('updatenotes');
						if (!empty ($updatenotes)) {
								$this->accounts_model->update_admin_notes($this->data['issupplier']);
						}
						elseif (!empty ($addnotes)) {
								$this->accounts_model->add_admin_notes($this->data['issupplier']);
						}

						$this->data['quickmodules'] = $this->modules_model->get_module_names();
						$this->data['chklib'] = $this->ptmodules;
						
						// $this->data['thismonth'] = modules :: run('supplier/reports/this_month_report');
						// $this->data['thisyear'] = modules :: run('supplier/reports/this_year_report');
						// $this->data['thisday'] = modules :: run('supplier/reports/this_day_report');
						$this->data['notes'] = $this->accounts_model->admin_notes_image($this->data['issupplier']);
						$this->data['mainmodules'] = $this->modules_model->get_module_names();
						$this->data['modules'] = $this->modules_model->get_all_enabled_modules();
						$this->data['stats'] = "";//$this->supplier_accounts_model->supplier_dashboard_stats($this->data['issupplier']);
						$this->data['main_content'] = 'admin/dashboard/dashboard';
						$this->data['page_title'] = 'Dashboard';
						$this->load->view('admin/template', $this->data);
				}
				else {
//secure login check
						$slogin = $this->secure_url();
						$skey = $this->secure_key();
						if ($slogin) {
								$key = $this->input->get('s');
								if (!empty ($key)) {
										if ($skey) {
												$this->data['pagetitle'] = 'Supplier Login';
												$this->load->view('admin/login', $this->data);
										}
										else {
												Error_404();
										}
								}
								else {
										Error_404();
								}
						}
						else {
								$this->data['pagetitle'] = 'Supplier Login';
								$this->load->view('admin/login', $this->data);
						}
				}
		}

		function login() { 
				$username = $this->input->post('email');
				$password = $this->input->post('password');
				if ($this->input->is_ajax_request()) {

					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
						$this->form_validation->set_rules('password', 'Password', 'required');

						if ($this->form_validation->run() == FALSE) {
							
							$result = array("status" => false, "msg" => validation_errors(), "url" => "");
						}else{

							$login = $this->accounts_model->login_supplier($username, $password);
						if ($login) {
							$prevurl = $this->session->userdata('prevURL');
							if(!empty($prevurl)){
								$url = $prevurl;
							}else{
								$url = base_url().'supplier';
							}

							$result = array("status" => true, "msg" => "", "url" => $url);
						}
						else {
							$result = array("status" => false, "msg" => "Invalid Login Credentials", "url" => "");
								
						}

						}
						echo json_encode($result);


				}
		}

	function resetpass(){

				$email = $this->input->post('email');
				$this->db->where('accounts_email', $email);
				$this->db->where('accounts_type', 'supplier');
				$check = $this->db->get('pt_accounts')->num_rows();
				
				if ($check > 0) {
						$newpass = random_string('alnum', 8);
						$updata = array('accounts_password' => sha1($newpass));
						$this->db->where('accounts_email', $email);
						$this->db->where('accounts_type', 'supplier');
						$this->db->update('pt_accounts', $updata);
						$this->load->model('admin/emails_model');
						$this->emails_model->reset_password($email, $newpass);
				}
				echo $check;
		}

		function profile() {
			
          $update = $this->input->post('update');
          $subs = $this->input->post('newssub');
          $email = $this->input->post('email');
          if(!empty($update)){

             $updateResult = $this->__updateProfile($this->userid);
            if($updateResult->noError){         	

            if(!empty($subs)){
               $this->newsletter_model->add_subscriber($email, $this->input->post('type'));
            }else{
               $this->newsletter_model->remove_subscriber($email);
            }
             $this->session->set_flashdata('flashmsgs', 'Profile Updated');
           
             $this->data['msg'] = "";
             redirect('supplier/profile','refresh');
          
          }else{
          	

          	 $this->data['msg'] = "<div class='alert alert-danger'>".$updateResult->msg."</div>";

          	
          }         


          }

          $this->data['profile'] = $this->accounts_model->get_profile_details($this->userid);
          $this->data['isSubscribed'] = $this->newsletter_model->is_subscribed($this->data['profile'][0]->accounts_email);
          $this->data['countries'] = $this->countries_model->get_all_countries();
          $this->data['main_content'] = 'accounts/profile';
          $this->data['page_title'] = 'My Profile';
          $this->load->view('admin/template', $this->data);
		}

//secure login check
		function secure_url() {
				$this->db->where('secure_supplier_status', '1');
				$this->db->where('user', 'webadmin');
				$res = $this->db->get('pt_app_settings')->num_rows();
				if ($res > 0) {
						return true;
				}
				else {
						return false;
				}
		}

//secure login url key
		function secure_key() {
				$this->db->where('secure_supplier_key', $this->input->get('s'));
				$this->db->where('user', 'webadmin');
				$res = $this->db->get('pt_app_settings')->num_rows();
				if ($res > 0) {
						return true;
				}
				else {
						return false;
				}
		}

// is valid supplier
		function validsupplier() {
				if (!empty ($this->data['issupplier'])) {
						return true;
				}
				else {
						return false;
				}
		}

//supplier items
		function myitems() {
				$supplier = $this->data['issupplier'];
				$myitems = array();
				$this->db->select('hotel_id');
				$this->db->where('hotel_owned_by', $supplier);
				$rs = $this->db->get('pt_hotels')->result();
				foreach ($rs as $r) {
						array_push($myitems, $r->hotel_id);
				}
				$this->db->select('tour_id');
				$this->db->where('tour_owned_by', $supplier);
				$trs = $this->db->get('pt_tours')->result();
				foreach ($trs as $tr) {
						array_push($myitems, $tr->tour_id);
				}
				$this->db->select('car_id');
				$this->db->where('car_owned_by', $supplier);
				$crs = $this->db->get('pt_cars')->result();
				foreach ($crs as $cr) {
						array_push($myitems, $cr->car_id);
				}

				return $myitems;
		}

//logout
		function logout() {
				$lastlogin = $this->session->userdata('pt_logged_time');
				$updatelogin = array('accounts_last_login' => $lastlogin);
				$this->db->where('accounts_id', $this->data['issupplier']);
				$this->db->update('pt_accounts', $updatelogin);
				$this->session->sess_destroy();
				redirect('supplier');
		}

		function system() {
				$ch = curl_init();
				$url = "http://qasimhussain.com/panel/req.php";
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, 2);
				curl_setopt($ch, CURLOPT_POSTFIELDS, array('posting1' => $_SERVER['HTTP_HOST']));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
				curl_setopt($ch, CURLOPT_TIMEOUT, 20);
				$chreq = curl_exec($ch);
				if ($chreq == '1') {
				}
				else {
						die($chreq);
				}
				curl_close($ch);
		}

		function system_resp() {
				$ch = curl_init();
				$url = "http://qasimhussain.com/panel/resp.php";
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, 2);
				curl_setopt($ch, CURLOPT_POSTFIELDS, array('posting1' => $_SERVER['HTTP_HOST']));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
				curl_setopt($ch, CURLOPT_TIMEOUT, 20);
				$chrsp = curl_exec($ch);
				@ $json = json_decode($chrsp);
				$this->__set_abc($json[0]->lic_key);
				$this->__set_def($json[0]->lic_expires_at);
				curl_close($ch);
		}

		function __set_abc($a) {
				$this->abc = $a;
		}

		function __set_def($d) {
				$this->def = $d;
		}

// hotels module controller
		function hotels($args = null, $id = null, $roomid = null) {
				$hotelsmod = modules :: load('hotels/hotelsback/');
				if (!method_exists($hotelsmod, 'index')) {
						redirect('supplier');
				}
				if ($args == "") {
						$hotelsmod->index();
				}
				elseif ($args == "add") {
						$hotelsmod->add();
				}
				elseif ($args == "manage") {
						$hotelsmod->manage($id);
				}
				elseif ($args == "extras") {
						$hotelsmod->extras($id);
				}
                elseif ($args == "gallery") {
						$hotelsmod->gallery($id);
				}
                elseif ($args == "roomgallery") {
						$hotelsmod->roomgallery($id);
				}
				elseif ($args == "translate") {
						$hotelsmod->translate($id, $roomid);
				}
				elseif ($args == "rooms") {
						$hotelsmod->rooms($id, $roomid);
				}
		}

// Cruises module controller
		function cruises($args = null, $id = null, $roomid = null) {
				$cruisesmod = modules :: load('cruises/cruisesback/');
				if (!method_exists($cruisesmod, 'index')) {
						redirect('supplier');
				}
				if ($args == "") {
						$cruisesmod->index();
				}
				elseif ($args == "add") {
//$cruisesmod->add();
				}
				elseif ($args == "settings") {
//$cruisesmod->settings();
				}
				elseif ($args == "manage") {
						$cruisesmod->manage($id);
				}
				elseif ($args == "rooms") {
						$cruisesmod->rooms($id, $roomid);
				}
		}

// cars module controller
		function cars($args = null, $id = null) {
				$carsmod = modules :: load('cars/carsback/');
				if (!method_exists($carsmod, 'index')) {
						redirect('supplier');
				}
				if ($args == "") {
						$carsmod->index();
				}
				elseif ($args == "add") {
						$carsmod->add();
				}
				elseif ($args == "settings") {
						$carsmod->settings();
				}
				elseif ($args == "manage") {
						$carsmod->manage($id);
				}
				elseif ($args == "extras") {
						$carsmod->extras($id);
				}
                elseif ($args == "gallery") {
						$carsmod->gallery($id);
				}
				elseif ($args == "translate") {
						$carsmod->translate($id, $lang);
				}
		}

// Tours module controller
		function tours($args = null, $id = null) {
				$toursmod = modules :: load('tours/toursback/');
				if (!method_exists($toursmod, 'index')) {
						redirect('supplier');
				}
				if ($args == "") {
						$toursmod->index();
				}
				elseif ($args == "add") {
						$toursmod->add();
				}
				elseif ($args == "settings") {
						$toursmod->settings();
				}
				elseif ($args == "manage") {
						$toursmod->manage($id);
				}
				elseif ($args == "extras") {
						$toursmod->extras($id);
				}
                elseif ($args == "gallery") {
						$toursmod->gallery($id);
				}
				elseif ($args == "translate") {
						$toursmod->translate($id, $lang);
				}
		}

		public function __updateProfile($id){

		$profileResult = new stdClass;
        $profileResult->noError = TRUE;

        $now = date("Y-m-d H:i:s");


        $oldphoto = $this->input->post('oldphoto');
        if ($filename != null) {
            $filename = $filename;
            if (!empty ($oldphoto)) {
                unlink(PT_USERS_IMAGES_UPLOAD . $oldphoto);
            }
        }
        else {
            $filename = "";
        }
        $data = array('ai_title' => $this->input->post('title'), 
        'ai_first_name' => $this->input->post('fname'),
        'ai_last_name' => $this->input->post('lname'),
        'ai_city' => $this->input->post('city'), 
        'ai_state' => $this->input->post('state'), 
        'ai_country' => $this->input->post('country'), 
        'ai_address_1' => $this->input->post('address1'), 
        'ai_address_2' => $this->input->post('address2'), 
        'ai_mobile' => $this->input->post('mobile'),
        'ai_image' => $filename, 
        'accounts_updated_at' => $now);
        $this->db->where('accounts_id', $id);
        $this->db->update('pt_accounts', $data);

        $oldemail = $this->input->post('oldemail');
        $newemail = $this->input->post('email');
        $password = $this->input->post('password');
        if ($oldemail != $newemail) {
            $this->db->select('accounts_email');
            $this->db->where('accounts_email', $newemail);
            $this->db->where('accounts_type', 'supplier');
            $nums = $this->db->get('pt_accounts')->num_rows();
            if ($nums > 0) {
              $profileResult->msg = "Email Already Exists";
              $profileResult->noError = FALSE;
            }
            else {
                $this->accounts_model->change_email($id);
                 $profileResult->noError = TRUE;
            }
        }

        if (!empty ($password)) {
            $this->accounts_model->change_password($id);
        }


        return $profileResult;
		}


		function locations($args = null, $id = null){


			$loc =  modules :: load('admin/locations');
			if(empty($args)){
				echo $loc->index();

			}elseif($args == "add"){

				echo $loc->add();
			}elseif($args == "edit"){

				echo $loc->edit($id);
			}
      		
         
        }

}