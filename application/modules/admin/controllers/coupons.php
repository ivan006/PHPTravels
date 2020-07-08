<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Coupons extends MX_Controller { 
		private $data = array();
		public $role;

//private $userid = 1; //$this->session->userdata('userid');
		function __construct() {
	
				parent :: __construct();
				modules :: load('admin');
				$chkadmin = modules :: run('admin/validadmin');
				if (!$chkadmin) {
					$this->session->set_userdata('prevURL', current_url());
						redirect('admin');
				}
				$chk = modules :: run('home/is_module_enabled', 'coupons');
				if (!$chk) {
						redirect('admin');
				}
				$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
				$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
    			$this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
    			$this->role = $this->session->userdata('pt_role');
				$this->data['role'] = $this->role;
    
				if (!pt_permissions('coupons', $this->data['userloggedin'])) {
						redirect('admin');
				}
				$this->load->model('coupons_model');
// $this->data['modModel'] = $this->modules_model;
		}

		public function index() {
				$this->disableExpired();
				$this->load->helper('xcrud');
				$xcrud = xcrud_get_instance();
				$xcrud->table('pt_coupons');
				$xcrud->order_by('id','desc');
				$xcrud->columns('id,code,value,maxuses,uses,startdate,expirationdate,status');
                $xcrud->label('code','Coupon Code');
                $xcrud->label('value','Rate %');
                $xcrud->label('status','Enabled');
                $xcrud->label('maxuses','Max Uses');
                $xcrud->label('uses','Used so far');
                $xcrud->label('startdate','Start Date');
                $xcrud->label('expirationdate','Expiration Date');
                $xcrud->column_callback('startdate','fmtDate');
                $xcrud->column_callback('expirationdate','fmtDate');
                $xcrud->column_callback('status', 'create_status_icon');
                $xcrud->search_columns('code,status,value');
                $xcrud->button('#editCop{id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('data-toggle' => 'modal'));
                $xcrud->unset_add();
                $xcrud->unset_edit();

                $xcrud->multiDelUrl = base_url().'admin/coupons/deleteMultipleCoupons';

				// creating action
				$xcrud->after_remove('deleteCouponData');

				$this->data['content'] = $xcrud->render();

				$modules = array(); 
				$hotelsMod = pt_main_module_available('hotels');
				$toursMod = pt_main_module_available('tours');
				$carsMod = pt_main_module_available('cars');
				if($hotelsMod){
					$this->load->model('hotels/hotels_model');
					$hotels = $this->hotels_model->shortInfo();
					$modules['hotels'] = $hotels;
				}

				if($toursMod){
					$this->load->model('tours/tours_model');
					$tours = $this->tours_model->shortInfo();
					$modules['tours'] = $tours;
				
				}

				if($carsMod){
					$this->load->model('cars/cars_model');
					$cars = $this->cars_model->shortInfo();
					$modules['cars'] = $cars;
				}

				$this->data['modules'] = $modules;
		/*		echo "<pre>";
				print_r($this->data['modules']);
				echo "</pre>";
				exit;*/


                
                $this->data['coupons'] = $this->coupons_model->getAllCoupons();
				$this->data['page_title'] = 'Coupon Codes Management';
				$this->data['main_content'] = 'coupons_view';
				$this->data['header_title'] = 'Coupon Codes Management';
				$this->load->view('template', $this->data);
		}
// Disable coupons

		public function disable_multiple_codes() {
				$codelist = $this->input->post('codelist');
				foreach ($codelist as $id) {
						$this->coupons_model->disable_coupon($id);
				}
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// Enable coupons

		public function enable_multiple_codes() {
				$codelist = $this->input->post('codelist');
				foreach ($codelist as $id) {
						$this->coupons_model->enable_coupon($id);
				}
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}
// Delete Single Coupon

		public function delete_single_coupon() {
				$id = $this->input->post('codeid');
				$this->coupons_model->delete_coupon($id);
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}
// Delete Multiple coupons

		public function deleteMultipleCoupons() {
				$items = $this->input->post('items');
				foreach ($items as $item) {
				$this->coupons_model->delete_coupon($item);
				}
		
		}
// add coupon

		public function addcoupon() {
				
				$this->form_validation->set_message('is_unique', 'Code Already Exists.');
				$this->form_validation->set_rules('rate', 'Percentage', 'trim|required|is_numeric|greater_than[0]');
				$this->form_validation->set_rules('code', 'Coupon Code', 'trim|required|is_unique[pt_coupons.code]');
				if ($this->form_validation->run() == FALSE) {
				$response = array('status' => 'fail', 'msg' => '<div class="alert alert-danger">'.validation_errors().'</div>');
				
				}
				else {
					    $allmods =$this->input->post('allmodules');
					    $items = $this->input->post('items');

						
						$couponid = $this->coupons_model->addCoupon();
						if(!empty($allmods)){

							$this->coupons_model->assignCouponToAllModules($couponid,$allmods,$items);

						}else{

						

							$this->coupons_model->assignCoupon($couponid,$items);

						}

						

	    				$response = array('status' => 'success', 'msg' => 'Coupon Added Successfully');						
						
				}

				echo json_encode($response);
		}
// update coupon

		public function updatecoupon() {
				$this->form_validation->set_rules('rate', 'Percentage', 'trim|required|is_numeric|greater_than[0]');
				if ($this->form_validation->run() == FALSE) {
				$response = array('status' => 'fail', 'msg' => '<div class="alert alert-danger">'.validation_errors().'</div>');
				
				}
				else {

					$couponid = $this->input->post('couponid');

					$this->coupons_model->updateCoupon($couponid);
					$allmods =$this->input->post('allmodules');
					$items = $this->input->post('items');
					
					
					if(!empty($allmods)){

					$this->coupons_model->assignCouponToAllModules($couponid,$allmods,$items);

					}else{

					

					$this->coupons_model->assignCoupon($couponid,$items);

					}


				$response = array('status' => 'success', 'msg' => 'Coupon Updated Successfully');						
						
				}

				echo json_encode($response);
		}
// generate coupon

		public function generate_coupon() {
				$settings = $this->settings_model->get_settings_data();
				$len = $settings[0]->coupon_code_length;
				$type = $settings[0]->coupon_code_type;
				echo random_string($type, $len);
		}

		public function disableExpired(){
			$data = array(
				'status' => 'No'
				);
			$this->db->where('expirationdate <', time());
			$this->db->where('forever', 'No');
			$this->db->update('pt_coupons',$data);
		}

}