<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Ajaxcalls extends MX_Controller {
		private $data = array();
		private $appsettings;

		function __construct() {
				modules :: load('admin');
				$this->load->model('admin/extras_model');
				$defaultlang = pt_get_default_language();
				if (empty ($this->data['lang_set'])) {
						$this->data['lang_set'] = $defaultlang;
				}
                $this->appsettings = $this->settings_model->get_settings_data();
				$this->lang->load("front", $this->data['lang_set']);
		}
// Remove Profile Image

		public function remove_profile_image() {
				$userid = $this->input->post('userid');
				$oldphoto = $this->input->post('oldphoto');
				if (!empty ($userid)) {
						$this->accounts_model->remove_profile_image($userid, $oldphoto);
						$this->session->set_flashdata('flashmsgs', 'Profile Updated Successfully');
						redirect('admin/accounts/profile');
				}
		}
// update menu order

		public function update_menu_order() {
				$update = $this->input->post('updateorder');
				$listorder = $this->input->post('listorder');
				if (!empty ($update)) {
						$this->menus_model->change_menu_header_order($listorder);
						echo " <i class='fa fa-check-square-o'></i>  Changes Saved";
				}
		}
// update footer menu order

		public function update_footer_menu_order() {
				$update = $this->input->post('updateorder');
				$listorder = $this->input->post('listorder');
				if (!empty ($update)) {
						$this->menus_model->change_menu_footer_order($listorder);
						echo " <i class='fa fa-check-square-o'></i> Changes Saved";
				}
		}
// update footer cols labels

		public function update_footer_cols_label() {
				$labeltext = $this->input->post('labeltext');
				$id = $this->input->post('id');
				if (!empty ($id)) {
						$this->menus_model->update_footer_cols_label($id, $labeltext);
						echo "Changes Saved";
				}
		}
// Delete menu

		public function delmenu() {
				$id = $this->input->post('id');
				$this->menus_model->del_menu($id);
		}
// delete multiple cms pages

		public function delete_multiple_pages() {
				$pageslist = $this->input->post('pagelist');
				foreach ($pageslist as $pageid) {
						$this->cms_model->delete_page($pageid);
				}
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}
// Disable multiple cms pages

		public function disable_multiple_pages() {
				$pageslist = $this->input->post('pagelist');
				foreach ($pageslist as $pageid) {
						$this->cms_model->disable_page($pageid);
				}
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// Disable multiple cms pages

		public function enable_multiple_pages() {
				$pageslist = $this->input->post('pagelist');
				foreach ($pageslist as $pageid) {
						$this->cms_model->enable_page($pageid);
				}
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// delete single cms page

		public function delete_single_page() {
				$pageid = $this->input->post('pageid');
				$this->cms_model->delete_page($pageid);
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}
// delete multiple languages

		public function delete_multiple_languages() {
				$langlist = $this->input->post('langlist');
				foreach ($langlist as $langid) {
						$this->translation_model->delete_language($langid);
				}
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}
// disable mulitple languages

		public function disable_multiple_languages() {
				$langlist = $this->input->post('langlist');
				foreach ($langlist as $langid) {
						$this->translation_model->disable_language($langid);
				}
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// enable mulitple languages

		public function enable_multiple_languages() {
				$langlist = $this->input->post('langlist');
				foreach ($langlist as $langid) {
						$this->translation_model->enable_language($langid);
				}
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// Delete single language

		public function delete_single_language() {
				$langid = $this->input->post('langid');
				$this->translation_model->delete_language($langid);
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}
// Delete Multiple Socials

		public function delMultipleSocials() {
				$items = $this->input->post('items');
          foreach($items as $item){
          		$this->misc_model->delete_social($item);
          }
        

		}
// disable mulitple socials

		public function disable_multiple_socials() {
				$sociallist = $this->input->post('sociallist');
				foreach ($sociallist as $socialid) {
						$this->misc_model->disable_social($socialid);
				}
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// enable mulitple socials

		public function enable_multiple_socials() {
				$sociallist = $this->input->post('sociallist');
				foreach ($sociallist as $socialid) {
						$this->misc_model->enable_social($socialid);
				}
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// Delete single Social

		public function delete_single_social() {
				$socialid = $this->input->post('socialid');
				$this->misc_model->delete_social($socialid);
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}
// Update Social Order

		public function update_social_order() {
	      $socialid = $this->input->post('id');
		  $order = $this->input->post('order');

		  $this->db->select('social_id');
          $total = $this->db->get('pt_socials')->num_rows();

          if($order > $total){
            echo '0';
          }else{
          	$this->misc_model->update_social_order($socialid, $order);
            echo '1';
          }
		}
// Update language Order

		public function update_language_order() {
				$langid = $this->input->post('id');
				$order = $this->input->post('order');
				$this->translation_model->update_language_order($langid, $order);
		}
// Update Slide Order

		public function update_slide_order() {
          $slideid = $this->input->post('id');
		  $order = $this->input->post('order');

		  $this->db->select('slide_id');
          $total = $this->db->get('pt_sliders')->num_rows();

          if($order > $total){
            echo '0';
          }else{
          	$this->misc_model->update_slide_order($slideid, $order);
            echo '1';
          }
		}

// delete multiple Slides

		public function delMultipleSlides() {

			$items = $this->input->post('items');
          foreach($items as $item){
          		$this->misc_model->delete_slide($item);
          }
        

		}
// Disable multiple Slides

		public function disable_multiple_slides() {
				$slidelist = $this->input->post('slidelist');
				foreach ($slidelist as $slideid) {
						$this->misc_model->disable_slide($slideid);
				}
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// Enable multiple Slides

		public function enable_multiple_slides() {
				$slidelist = $this->input->post('slidelist');
				foreach ($slidelist as $slideid) {
						$this->misc_model->enable_slide($slideid);
				}
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// delete Single Slide

		public function delete_single_slide() {
				$slideid = $this->input->post('slideid');
				$this->misc_model->delete_slide($slideid);
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}
// disable mulitple modules

		public function disable_multiple_modules() {
				$modulelist = $this->input->post('modulelist');
				foreach ($modulelist as $modid) {
						$this->modules_model->disable_module($modid);
				}
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// enable mulitple modules

		public function enable_multiple_modules() {
				$modulelist = $this->input->post('modulelist');
				foreach ($modulelist as $modid) {
						$this->modules_model->enable_module($modid);
				}
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// disable single module

		public function disable_single_module() {
				$modid = $this->input->post('moduleid');
				$this->modules_model->disable_module($modid);
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// enable single module

		public function enable_single_module() {
				$modid = $this->input->post('moduleid');
				$this->modules_model->enable_module($modid);
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// enable main module

		public function enable_main_module() {
				$modid = $this->input->post('modulename');
				$this->modules_model->enable_main_module($modid);
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// disable main module

		public function disable_main_module() {
				$modid = $this->input->post('modulename');
				$this->modules_model->disable_main_module($modid);
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// disable mulitple gateways

		public function disable_multiple_gateways() {
				$this->load->model('payments_model');
				$gatewaylist = $this->input->post('gatewaylist');
				foreach ($gatewaylist as $id) {
						$this->payments_model->disable_gateway($id);
				}
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// enable mulitple gateways

		public function enable_multiple_gateways() {
				$this->load->model('payments_model');
				$gatewaylist = $this->input->post('gatewaylist');
				foreach ($gatewaylist as $id) {
						$this->payments_model->enable_gateway($id);
				}
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// disable single gateway

		public function disable_single_gateway() {
				$this->load->model('payments_model');
				$id = $this->input->post('gatewayid');
				$this->payments_model->disable_gateway($id);
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// enable single gateway

		public function enable_single_gateway() {
				$this->load->model('payments_model');
				$id = $this->input->post('gatewayid');
				$this->payments_model->enable_gateway($id);
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// disable mulitple subscribers

		public function disable_multiple_subscribers() {
				$newslist = $this->input->post('newslist');
				foreach ($newslist as $newsid) {
						$this->newsletter_model->disable_subscriber($newsid);
				}
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// enable mulitple subscribers

		public function enable_multiple_subscribers() {
				$newslist = $this->input->post('newslist');
				foreach ($newslist as $newsid) {
						$this->newsletter_model->enable_subscriber($newsid);
				}
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// disable single subscriber

		public function disable_single_subscriber() {
				$newsid = $this->input->post('newsid');
				$this->newsletter_model->disable_subscriber($newsid);
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// enable single subscriber

		public function enable_single_subscriber() {
				$newsid = $this->input->post('newsid');
				$this->newsletter_model->enable_subscriber($newsid);
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// delete single subscriber

		public function delete_single_subscriber() {
				$newsid = $this->input->post('newsid');
				$this->newsletter_model->delete_subscriber($newsid);
				$this->session->set_flashdata('flashmsgs', "Removed Successfully");
		}
// delete single subscriber

		public function delete_multiple_subscribers() {
				$newslist = $this->input->post('newslist');
				foreach ($newslist as $newsid) {
						$this->newsletter_model->delete_subscriber($newsid);
				}
				$this->session->set_flashdata('flashmsgs', "Removed Successfully");
		}
// delete multiple Accounts

		public function delete_multiple_accounts() {
				$accountlist = $this->input->post('accountlist');
				foreach ($accountlist as $accid) {
						$this->accounts_model->delete_account($accid);
				}
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}
// delete Single Account

		public function delete_single_account() {
				$accountid = $this->input->post('accountid');
				$this->accounts_model->delete_account($accountid);
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}
// disable multiple Accounts

		public function disable_multiple_accounts() {
				$accountlist = $this->input->post('accountlist');
				foreach ($accountlist as $accid) {
						$this->accounts_model->disable_account($accid);
				}
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// enable multiple Accounts

		public function enable_multiple_accounts() {
				$accountlist = $this->input->post('accountlist');
				foreach ($accountlist as $accid) {
						$this->accounts_model->enable_account($accid);
				}
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// disable single Accounts

		public function disable_single_account() {
				$accid = $this->input->post('id');
				$this->accounts_model->disable_account($accid);
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// enable single Accounts

		public function enable_single_account() {
				$accid = $this->input->post('id');
				$this->accounts_model->enable_account($accid);
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}


//change language front-end

		public function change_language_front() {
				$langid = $this->input->post('languageid');
				$langname = $this->input->post('langname');

			  //	$this->session->set_userdata('set_lang', $langid);
			//	$this->session->set_userdata('lang_name', $langname);
		}

//change currency front-end
		function changeCurrency() {
				$id = $this->input->post('id');
                $this->settings_model->changeCurrency($id);
		}

// Remove theme
		function remove_theme() {
				$this->settings_model->remove_theme();
		}

// Select theme
		function select_theme() {
				$this->settings_model->select_theme();
		}
// load state and city of a country selected

		public function get_city() {
				$type = $this->input->post('loadtype');
				$id = $this->input->post('loadid');
				$HTML = "";
				if ($type == 'state') {
						$data = $this->countries_model->get_country_state($id);
						if (!empty ($data)) {
								$HTML .= "

<option value=''>Select State</option>

";
								foreach ($data as $d) {
										$HTML .= "

<option value='" . $d->state_id . "'>" . $d->state_name . "</option>

";
								}
						}
				}
				elseif ($type == 'city') {
						$data2 = $this->countries_model->get_state_city($id);
						if (!empty ($data2)) {
								foreach ($data2 as $d2) {
										$HTML .= "

<option value='" . $d2->city_id . "'>" . $d2->city_name . "</option>

";
								}
						}
				}
				echo $HTML;
		}
// load users first name by user type

		public function get_users_name() {
				$type = $this->input->post('usertype');
				$HTML = "";
				$data = $this->accounts_model->get_accounts_data($type);
				if (!empty ($data)) {
						foreach ($data['all'] as $d2) {
								$HTML .= "

<option value='" . $d2->accounts_id . "'>" . $d2->ai_first_name . " " . $d2->ai_last_name . "</option>

";
						}
				}
				echo $HTML;
		}
// load items of the selected module

		public function get_module_items() {
				$modtype = $this->input->post('modtype');
				$user = $this->input->post('user');
				$issupplier = $this->input->post('segment');
				if ($issupplier == "supplier") {
						echo $this->modules_model->get_supplier_module_items($modtype, $user);
				}
				else {
						echo $this->modules_model->get_module_items($modtype);
				}
		}
// Delete Single Supplement

		public function delete_single_supp() {
				$suppid = $this->input->post('suppid');
				$this->extras_model->delete_supp($suppid);
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}
// Disable extras

		public function disable_multiple_supps() {
				$supplist = $this->input->post('supplist');
				foreach ($supplist as $id) {
						$this->extras_model->disable_supp($id);
				}
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// Enable extras

		public function enable_multiple_supps() {
				$supplist = $this->input->post('supplist');
				foreach ($supplist as $id) {
						$this->extras_model->enable_supp($id);
				}
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// Delete multiple extras

		public function delMultipleEXtras() {
			$items = $this->input->post('items');
          foreach($items as $item){
          		$this->extras_model->deleteExtra($item);
          }
		}
// get submenu item types

		public function get_submenu_types() {
				$type = $this->input->post('types');
				$HTML = "";
				$data = $this->menus_model->populate_submenu($type);
				if (!empty ($data)) {
						foreach ($data as $d2) {
								$HTML .= "

<option value='" . $d2->id . "' data-label='" . $d2->label . "'>" . $d2->label . "</option>

";
						}
				}
				echo $HTML;
		}

		public function add_hotels_submenu() {
				$this->menus_model->add_hotels_submenu();
		}

		public function delete_submenu_item() {
				$this->menus_model->del_submenu_item();
		}

//process booking
		function processBookingguest() {
				$this->load->model('admin/bookings_model');
				$this->form_validation->set_message('matches', trans("0310"));
				$this->form_validation->set_message('valid_email', trans("0311"));
				$this->form_validation->set_message('required', "%s " . trans("0312"));
				$this->form_validation->set_rules('email', trans("094"), 'required|valid_email|matches[confirmemail]');
				$this->form_validation->set_rules('firstname', trans("0171"), 'trim|required');
				$this->form_validation->set_rules('lastname', trans("0172"), 'trim|required');
				if ($this->form_validation->run() == FALSE) {
					
					$bookingResult = array("error" => "yes", 'msg' => validation_errors());
				}
				else {

					$bookingResult = $this->bookings_model->doGuestBooking();	
				}
				
				//$bookingResult = array("error" => "yes", 'msg' => $this->input->post('passport'));
				echo json_encode($bookingResult);
				
		}

		function processBookinglogged() {
				$this->load->model('admin/bookings_model');
				$user = $this->session->userdata('pt_logged_customer');
				echo json_encode($this->bookings_model->do_booking($user));
		}

		function processBookinglogin() {
				$this->load->model('bookings_model');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				if ($this->input->is_ajax_request()) {
				  $bookingtype = $this->input->post('btype');

						$bookingResult = $this->bookings_model->do_login_booking($username, $password);
						echo json_encode($bookingResult);
				}
		}

		function processBookingsignup() {
				$this->load->model('bookings_model');
				$this->form_validation->set_message('matches', trans("0310"));
				$this->form_validation->set_message('valid_email', trans("0311"));
				$this->form_validation->set_message('required', "%s " . trans("0312"));
				$this->form_validation->set_rules('email', trans("094"), 'required|valid_email');
				$this->form_validation->set_rules('password', trans("095"), 'required|min_length[6]');
				$this->form_validation->set_rules('firstname', trans("0171"), 'trim|required');
				$this->form_validation->set_rules('lastname', trans("0172"), 'trim|required');
				if ($this->form_validation->run() == FALSE) {
						echo "

<div class='alert alert-danger'>" . validation_errors() . "</div>

";
				}
				else {
						$this->db->select('accounts_email');
						$this->db->where('accounts_email', $this->input->post('email'));
						$this->db->where('accounts_type', 'customers');
						$nums = $this->db->get('pt_accounts')->num_rows();
						if ($nums > 0) {
								echo "

<div class='alert alert-danger'>" . trans("0313") . "</div>";
						}
						else {
								$this->bookings_model->do_customer_booking();
								echo "";
						}
				}
		}

		public function verifyAccount() {
				$id = $this->input->post('id');
				$accType = $this->input->post('accType');
				$this->accounts_model->verify_account($id, $accType);
				$this->session->set_flashdata('flashmsgs', "Account Verified Successfully");
		}

		public function remove_from_menu() {
				$pageid = $this->input->post('pageid');
				$menutype = $this->input->post('menutype');
				if ($menutype == "header") {
						$this->menus_model->remove_from_header($pageid);
				}
				else {
						$this->menus_model->remove_from_footer($pageid);
				}
				$this->session->set_flashdata('flashmsgs', "Menu updated Successfully");
		}

		public function updateitemsorder() {
				$items = $this->input->post('menuitems');
				$id = $this->input->post('menuid');
			  $this->menus_model->update_menu($items, $id);
		}

		public function togglediv() {
				$id = $this->input->post('id');
				if (empty ($id)) {
						$this->session->set_userdata('divclass', "active");
				}
				else {
						$this->session->set_userdata('divclass', "");
				}
		}

		function update_room_adv() {
				$date = $this->input->post('date');
				$roomid = $this->input->post('roomid');
				$rate = $this->input->post('rate');
				$this->load->model('rooms_model');
				$this->rooms_model->update_room_adv($date, $roomid, $rate);
		}

		function sendtotest() {
				$template = $this->input->post('template');
				$this->load->model('admin/emails_model');
				echo $this->emails_model->sendtotest($template);
		}

		function testingEmail() {
				$email = $this->input->post('email');
				$this->load->model('admin/emails_model');
				echo $this->emails_model->sendtestemail($email);
		}	


		function smstest() {
				$template = $this->input->post('template');
				$this->load->model('admin/smsaddon_model');
				$response = $this->smsaddon_model->smstest($template);
				echo $response[2];
		}

		function quicksms() {
				$selecttype = $this->input->post('selecttype');
				$multinum = $this->input->post('numbers');
				$singlenum = $this->input->post('mobilenumber');
				$msg = $this->input->post('message');
				if ($selecttype == "new" && $singlenum == "") {
						echo "kindly Enter Mobile Number";
				}
				elseif ($selecttype == "customer" && $multinum == "") {
						echo "kindly Select Customer";
				}
				elseif ($msg == "") {
						echo "kindly Enter Message";
				}
		}

		function quickemail() {
				$msgto = $this->input->post('msgto');
				$subject = $this->input->post('subject');
				$body = $this->input->post('message');
				$msgfrom = $this->input->post('msgfrom');
				if (empty ($msgto)) {
						echo "Enter Email address of recepient";
				}
				elseif (empty ($subject)) {
						echo "Enter Subject of the Email";
				}
				elseif (empty ($body)) {
						echo "Enter Message of the Email";
				}
				elseif (empty ($msgfrom)) {
						echo "Enter the From field";
				}
				else {
						$this->load->model('admin/emails_model');
						$this->emails_model->quickemail($msgfrom, $body, $msgto, $subject);
						echo "1";
				}
		}

        public function update_offers_order() {
          $this->load->model('special_offers_model');
				$offerid = $this->input->post('id');
				$order = $this->input->post('order');

		  $this->db->select('offer_id');
          $total = $this->db->get('pt_special_offers')->num_rows();

          if($order > $total){
            echo '0';
          }else{
           $this->special_offers_model->update_offer_order($offerid, $order);
            echo '1';
          }
		}

        public function postreview(){
          $response = array();
            $this->load->model('admin/reviews_model');
        	$this->form_validation->set_rules('reviews_comments', 'Comment', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('fullname', 'Name', 'trim|required');
            	if ($this->form_validation->run() == FALSE) {
				$response = array(
                'result' => false,
                'divclass' => 'alert-danger',
                'msg' => validation_errors()
                );
				}
				else {
				  $check = $this->reviews_model->check_already_review_posted($this->input->post('email'),$this->input->post('reviewfor'),$this->input->post('reviewmodule'));
					if($check){
                $response = array(
                'result' => false,
                'divclass' => 'alert-danger',
                'msg' => trans('0485')
                );
					}else{
                $this->reviews_model->add_review_public($this->appsettings[0]->reviews);
                $response = array(
                'result' => true,
                'divclass' => 'alert-success',
                'msg' =>  trans('0486')
                );
					}
				}

        echo json_encode($response);
        }


        public function updatereview(){
          $response = array();
          $id = $this->input->post('reviewid');
            $this->load->model('admin/reviews_model');
        	$this->form_validation->set_rules('reviews_comments', 'Comment', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('fullname', 'Name', 'trim|required');
            	if ($this->form_validation->run() == FALSE) {
				$response = array(
                'result' => false,
                'divclass' => 'alert-danger',
                'msg' => validation_errors()
                );
				}
				else {

                $this->reviews_model->update_review_admin($id);
                $response = array(
                'result' => true,
                'divclass' => 'alert-success',
                'msg' => 'Review Updated Successfully'
                );

				}

        echo json_encode($response);
        }

        public function ThemeInfo(){
          $response = array();
          $theme = $this->input->post('theme');

          $themeinfo = pt_getThemeInfo( "themes/$theme/style.css" );
          if(!file_exists("themes/$theme/screenshot.png")){
           $themeinfo['screenshot'] = PT_BLANK;
          }else{
          $themeinfo['screenshot'] = base_url()."themes/".$theme."/screenshot.png";
			   }
          echo json_encode($themeinfo);

        }

        public function delReview() {
                 $this->load->model('admin/reviews_model');
				$id = $this->input->post('id');
				$this->reviews_model->delete_review($id);
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}

		// Delete multiple reviews

		public function delMultipleReviews() {
			  $this->load->model('admin/reviews_model');
			$items = $this->input->post('items');
          foreach($items as $item){
          		$this->reviews_model->delete_review($item);
          }
		}

		function approveReview(){
       	$this->load->model('admin/reviews_model');
       	$this->reviews_model->approveReview();
       }

        public function delAcc() {
				$accountid = $this->input->post('id');
				$this->accounts_model->delete_account($accountid);
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}

		function multiDelAcc(){
              
          $items = $this->input->post('items');
          foreach($items as $item){
          	$this->accounts_model->delete_account($item);
          }
       
        }

		public function approveAccount(){
				$accountid = $this->input->post('id');
				$this->accounts_model->approveAccount($accountid);
		}

		public function hideBooking(){
			
			$data = array(
					'booking_show' => '0'
				);
			$this->db->where('booking_id',$this->input->post('id'));
			$this->db->update('pt_bookings',$data);
		}

        public function createCMSPermalink(){
            $title = $this->input->post('pagetitle');
            $pageid = $this->input->post('pageid');
            $this->db->select("page_id");

				$this->db->order_by("page_id", "desc");
				$query = $this->db->get('pt_cms');
				$lastid = $query->result();
				if (empty ($lastid)) {
						$pagelastid = 1;
				}
				else {
						$pagelastid = $lastid[0]->page_id + 1;
				}
                        $slug = create_url_slug($title);
                        $this->db->select("page_id");
						$this->db->where("page_slug", $slug);
                         if($pageid > 0){
              $this->db->where('page_id !=',$pageid);
            }
						$queryc = $this->db->get('pt_cms')->num_rows();
						if ($queryc > 0) {
								$slug = $slug."-". $pagelastid;
						}
                        echo $slug;
        }

        function delPage(){
             $id = $this->input->post('id');
             $this->cms_model->delete_page($id);
        }

        function multiDelPage(){
              
          $items = $this->input->post('items');
          foreach($items as $item){
          	$this->cms_model->delete_page($item);
          }
       
        }

         public function createBlogPermalink(){
            $title = $this->input->post('title');
            $postid = $this->input->post('postid');
            $this->db->select("post_id");

				$this->db->order_by("post_id", "desc");
				$query = $this->db->get('pt_blog');
				$lastid = $query->result();
				if (empty ($lastid)) {
						$postlastid = 1;
				}
				else {
						$postlastid = $lastid[0]->post_id + 1;
				}
                        $slug = create_url_slug($title);
                        $this->db->select("post_id");
						$this->db->where("post_slug", $slug);

                        if($postid > 0){
              $this->db->where('post_id !=',$postid);
                         }

						$queryc = $this->db->get('pt_blog')->num_rows();
						if ($queryc > 0) {
								$slug = $slug."-". $postlastid;
						}
                        echo $slug;
        }

        // update post order

		public function update_post_order() {
		  $postid = $this->input->post('id');
		  $order = $this->input->post('order');
           $this->load->model('blog/blog_model');
		  $this->db->select('post_id');
          $total = $this->db->get('pt_blog')->num_rows();

          if($order > $total){
            echo '0';
          }else{
          $this->blog_model->update_post_order($postid, $order);
            echo '1';
          }

		}

        function delBlog(){
            $this->load->model('blog/blog_model');
             $id = $this->input->post('id');
             $this->blog_model->delete_post($id);
        }

        function delBlogCat(){
            $this->load->model('blog/blog_model');
             $id = $this->input->post('id');
             $this->blog_model->delete_cat($id);
        }

        function delLocation(){

            $this->load->model('admin/locations_model');
            $id = $this->input->post('id');
            $this->locations_model->delete_loc($id);
        }

        function delMultipleLocation(){
        	
          $this->load->model('admin/locations_model');
          $items = $this->input->post('items');

          foreach($items as $item){
           $this->locations_model->delete_loc($item);

          }
        }

        // Delete Offer
        function delOffer(){
          $this->load->model('admin/special_offers_model');
          $id = $this->input->post('id');
          $this->special_offers_model->deleteOffer($id);
        }

         // Delete Multiple Offers
        function delMultipleOffer(){
          $this->load->model('admin/special_offers_model');
          $items = $this->input->post('items');

          foreach($items as $item){
           $this->special_offers_model->deleteOffer($item);	
          }
         
        }

        // update Offer Images order

		public function update_offer_image_order() {
		  $this->load->model('admin/special_offers_model');
				$imgid = $this->input->post('id');
				$order = $this->input->post('order');
				$this->special_offers_model->update_offer_image_order($imgid, $order);
                echo "1";
		}

       // Delete Offer image
        function delete_offer_image() {
          $this->load->model('admin/special_offers_model');
		        $imgname = $this->input->post('imgname');
	  			$offerid = $this->input->post('itemid');
				$imgid = $this->input->post('imgid');
				$this->special_offers_model->delete_image($imgname,$imgid,$offerid);
		}
       //make thumb of offer
       function offer_makethumb() {
         $this->load->model('admin/special_offers_model');
			    $newthumb = $this->input->post('imgname');
				$offerid = $this->input->post('itemid');
				$this->special_offers_model->updateOfferThumb($offerid, $newthumb,"update");
		}
       //Delete multiple images of offer
       function deleteMultipleOfferImages(){
         $this->load->model('admin/special_offers_model');
          $data = $this->input->post('imgids');
          foreach($data as $d){
                $this->special_offers_model->delete_image($d['imgname'],$d['imgid'],$d['itemid']);
          }


        }

       function makeCurrDefault(){
         $id = $this->input->post('id');
         $this->settings_model->makeCurrencyDefault($id);
       }

       function delMultipleCurrencies(){
        $items = $this->input->post('items');
          foreach($items as $item){
          		$this->settings_model->deleteCurrency($item);
          }
       }

       function updateGatewayOrder(){

       	$order = $this->input->post('order');
       	$action = $this->input->post('action');

       	$this->load->model('payments_model');
       	$this->payments_model->updateOrder($order,$action);

       }

       function reduceSidebar(){
       	$sidebar = $this->input->post('sidebar');
       	$this->session->set_userdata('sideBar', $sidebar);
  
       }



       function notifications(){
       	//start review notifications
       	$this->db->where('review_status !=','Yes');
       	$this->db->order_by('review_id','desc');
       	$reviews = $this->db->get('pt_reviews');
       	$revdata = $reviews->result();
       	$revcount = $reviews->num_rows();
       	$revhtml = "";
       	$revDelUrl = base_url().'admin/ajaxcalls/delReview';
       	$revApproveUrl = base_url().'admin/ajaxcalls/approveReview';
       	foreach($revdata as $d){
       		$revhtml .= "<li class='nav-notifications-body notificationReviews'>
                <a href='javascript: void();' class='text-info'>".$d->review_name."
                <small onclick=delfunc('".$d->review_id."','".$revDelUrl."') class='pull-right btn-xs btn btn-danger del'>delete</small>
                <small onclick=approvefunc('".$d->review_id."','".$revApproveUrl."') class='pull-right btn-xs btn btn-success'>approve</small>
                </a>
                 <div class='clearfix'></div>
              </li>";
       	}
       	//end reviews notifications

       	//start accounts notifications
       	$this->db->where('accounts_status !=','yes');
       	$this->db->order_by('accounts_id','desc');
       	$this->db->where('accounts_type','supplier');
       	$accounts = $this->db->get('pt_accounts');
       	$accdata = $accounts->result();
       	$acccount = $accounts->num_rows();
       	$accountshtml = "";
       	$accApproveUrl = base_url().'admin/ajaxcalls/approveAccount';
       	$accurl = base_url().'admin/accounts/suppliers/edit/';
       	foreach($accdata as $accd){
       		$accountshtml .= "<li class='nav-messages-body notificationAccounts'>
       		<a href=".$accurl.$accd->accounts_id.">
       		 <img src=".base_url()."assets/img/user_blank.jpg alt='User' class='avatar'>
       		  <div class='title'>
                    <small onclick=approvefunc('".$accd->accounts_id."','".$accApproveUrl."') class='pull-right btn-xs btn btn-success'>Approve</small><strong>".$accd->ai_first_name." ".$accd->ai_last_name."</strong>
                  </div>              
                <div class='message'>".$accd->accounts_created_at."</div>
                  </a>
              </li>";
       	}
       	//end accounts notifications

       	//start bookings notifications
       	$this->db->where('booking_status','unpaid');
       	$this->db->where('booking_show','1');
       	$this->db->order_by('booking_id','desc');
        $this->db->join('pt_accounts','pt_bookings.booking_user = pt_accounts.accounts_id','left');
       	$bookings = $this->db->get('pt_bookings');
       	$bookdata = $bookings->result();
       	$bookcount = $bookings->num_rows();
       	$bookingshtml = "";
       	$hideurl = base_url().'admin/ajaxcalls/hideBooking';
       	$invoiceurl = base_url().'admin/bookings/edit/';
       	foreach($bookdata as $bookd){
       		$bookingshtml .= "<li class='nav-messages-body notificationBookings' id=".$bookd->booking_id.">
       		<a href=".$invoiceurl.$bookd->booking_type.'/'.$bookd->booking_id.">      		
       		  <div class='title'>
                    <small onclick=hideBooking('".$bookd->booking_id."','".$hideurl."') class='pull-right btn-xs btn btn-warning'>Hide</small><strong>".$bookd->ai_first_name." ".$bookd->ai_last_name."</strong>
                  </div>              
                <div class='message'>".pt_show_date_php($bookd->booking_date)."</div>
                  </a>
              </li>";
       	}
       	//end bookings notifications

       	$result = array("totalReviews" => $revcount,'revhtml' => $revhtml,
       		"totalAccounts" => $acccount,'accountshtml' => $accountshtml,
       		"totalBookings" => $bookcount,'bookingshtml' => $bookingshtml
       		);

       	echo json_encode($result);
       }

       function checkCoupon(){
       	$couponcode = $this->input->post('coupon');
       	$module = $this->input->post('module');
       	$itemid = $this->input->post('itemid');

       	echo pt_couponVerify($couponcode, $module, $itemid);

       }

       function delMultipleWidgets(){

       	$this->load->model('admin/widgets_model');

       	$items = $this->input->post('items');
        foreach($items as $item){
       
       	$this->widgets_model->deleteWidget($item);
       
       }

       }



}