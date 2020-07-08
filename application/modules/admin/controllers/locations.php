<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Locations extends MX_Controller {
		private $data = array();
		public  $role;
		public  $accType;
		public  $isSuperAdmin;
		public  $segmentUrl;
		private $langdef;
		public  $editpermission = true;
        public  $deletepermission = true;

		function __construct() {

				modules::load('admin');
				$this->load->model('admin/locations_model');
				
				$this->data['userloggedin'] = $this->session->userdata('pt_logged_id');
	        	//$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
	        	$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
   				$this->isSuperAdmin = $this->session->userdata('pt_logged_super_admin');
   				$this->data['isSuperAdmin'] = $this->isSuperAdmin;
   				$this->role = $this->session->userdata('pt_role');
				$this->data['role'] = $this->role;
				$this->accType = $this->session->userdata('pt_accountType');

				$this->data['appSettings'] = modules :: run('admin/appSettings');
				
				if($this->data['role'] == "supplier"){
					$this->segmentUrl = "supplier";
					$this->data['adminsegment'] = "supplier";
				}else{
					$this->segmentUrl = "admin";
					$this->data['adminsegment'] = "admin";
				}

				if(!pt_permissions('locations',$this->data['userloggedin'])){

					redirect($this->segmentUrl);

				}

				$this->data['addpermission'] = TRUE;



				if($this->role == "supplier" || $this->role == "admin"){
                $this->editpermission = pt_permissions("editlocations", $this->data['userloggedin']);
                $this->deletepermission = pt_permissions("deletelocations", $this->data['userloggedin']);
                $this->data['addpermission'] = pt_permissions("addlocations", $this->data['userloggedin']);
                }

    $this->load->helper('xcrud');
   	 			
		}

		public function index() {
       	$this->load->model("admin/locations_model");
       	$this->data['locationsModel'] = $this->locations_model;
       	$this->data['add_link'] = base_url().$this->segmentUrl.'/locations/add';


		$xcrud = xcrud_get_instance();

		$xcrud->table('pt_locations');
		if(!$this->isSuperAdmin){
		$xcrud->where('user',$this->data['userloggedin']);	
		}
		$xcrud->order_by('id','desc');
		$xcrud->columns('location,country,latitude, longitude, status');
		$xcrud->label('location','City')->label('country','Country')->label('latitude','Latitude')->label('longitude','Longitude')->label('status','Status');
		$xcrud->column_callback('status', 'create_status_icon');
		if($this->editpermission){
		$xcrud->button(base_url() .$this->segmentUrl.'/locations/edit/{id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('target' => '_self'));
		}

		if($this->deletepermission){
		$delurl = base_url().'admin/ajaxcalls/delLocation';
		$xcrud->multiDelUrl = base_url().'admin/ajaxcalls/delMultipleLocation';
        $xcrud->button("javascript: delfunc('{id}','$delurl')",'DELETE','fa fa-times', 'btn-danger',array('target'=>'_self'));
        }
       
        $xcrud->limit(50);
		$xcrud->unset_add();
		$xcrud->unset_edit();
		$xcrud->unset_remove();
		$xcrud->unset_view();
		//$this->data['locations'] = $this->blog_model->get_all_categories_back();
		$this->data['content'] = $xcrud->render();
		$this->data['page_title'] = 'Locations Settings';
		$this->data['main_content'] = 'locations_view';
		$this->data['header_title'] = 'Locations';
		$this->load->view('admin/template', $this->data);


	}

	public function add(){
		$this->data['locationsModel'] = $this->locations_model;
		$submit = $this->input->post('submittype');
		$this->data['msg'] =  "";
		if(!empty($submit)){
       		$alreadyExists = $this->locations_model->alreadyExists();
       		if($alreadyExists){
       			$this->data['msg'] = "<div class='alert alert-danger'>Location already Exists</div>";

       		}else{

       			$this->locations_model->addLocation();
       			redirect($this->segmentUrl.'/locations');
       		}
       		


       		
       	}

		$this->data['submittype'] = "add";
		$this->data['headingText'] = "Add";
		$this->data['countries'] = $this->countries_model->get_all_countries();	
       	$this->data['languages'] = pt_get_languages();

		$this->data['main_content'] = 'settings/locations';
		$this->data['page_title'] = $this->data['headingText'].' Location';
		$this->load->view('admin/template', $this->data);	


	}

	public function edit($id){
		$this->data['id'] = $id;
		$this->data['location'] = $this->locations_model->getLocationDetails($id);
		
		if(empty($id) || !$this->data['location']->isValid){
       			redirect($this->segmentUrl.'/locations');
       		}
		
		$submit = $this->input->post('submittype');
		if(!empty($submit)){
			$locid = $this->input->post('locationid');
			$this->locations_model->updateLocation($locid);
			redirect($this->segmentUrl.'/locations');
		}

		$this->data['locationsModel'] = $this->locations_model;

		$this->data['submittype'] = "edit";
		$this->data['headingText'] = "Edit";
		$this->data['countries'] = $this->countries_model->get_all_countries();	
       	$this->data['languages'] = pt_get_languages();

		$this->data['main_content'] = 'settings/locations';
		$this->data['page_title'] = $this->data['headingText'].' Location';
		$this->load->view('admin/template', $this->data);	


	}

		

}