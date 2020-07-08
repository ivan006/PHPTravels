<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Templates extends MX_Controller {
		private $data = array();
		public $role;

		function __construct() {
				parent :: __construct();
				modules :: load('admin');
				$chkadmin = modules :: run('admin/validadmin');
			 $superAdmin = $this->session->userdata('pt_logged_super_admin');

        if (!$chkadmin || !$superAdmin) {
          $this->session->set_userdata('prevURL', current_url());
        

            redirect('admin');
                    
        }
				$this->load->model('templates_model');
/*  $chk = modules::run('home/is_module_enabled','coupons');
if(!$chk){
redirect('admin');
}*/
				$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
				$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
                $this->data['isSuperAdmin'] = $superAdmin;
               	$this->role = $this->session->userdata('pt_role');
				$this->data['role'] = $this->role;
/*  if(!pt_permissions('coupons',$this->data['userloggedin'])){
redirect('admin');
}*/
// $this->load->model('coupons_model');
				$this->load->library('ckeditor');
				$this->data['ckconfig'] = array();
				$this->data['ckconfig']['toolbar'] = array(array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format', 'Styles'), array('NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'), array('Image', 'Link', 'Unlink', 'Anchor', 'Table', 'HorizontalRule', 'SpecialChar', 'Maximize'), array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),);
				$this->data['ckconfig']['language'] = 'en';
				$this->data['ckconfig']['filebrowserBrowseUrl'] = base_url() . 'assets/include/kcfinder/browse.php?type=files';
				$this->data['ckconfig']['filebrowserImageBrowseUrl'] = base_url() . 'assets/include/kcfinder/browse.php?type=images';
				$this->data['ckconfig']['filebrowserFlashBrowseUrl'] = base_url() . 'assets/include/kcfinder/browse.php?type=flash';
				$this->data['ckconfig']['filebrowserUploadUrl'] = base_url() . 'assets/include/kcfinder/upload.php?type=files';
				$this->data['ckconfig']['filebrowserImageUploadUrl'] = base_url() . 'assets/include/kcfinder/upload.php?type=images';
				$this->data['ckconfig']['filebrowserFlashUploadUrl'] = base_url() . 'assets/include/kcfinder/upload.php?type=flash';
		}

		public function email($template = null) {
				if (!empty ($template)) {
						$update = $this->input->post('update');
						if (!empty ($update)) {
								$this->templates_model->update_details();
								redirect('admin/templates/email');
						}
						$this->load->model("emails_model");
						$this->data['variables'] = $this->emails_model->shortcode_variables($template);
						$this->data['details'] = $this->templates_model->get_template_detail($template);
						$this->data['main_content'] = 'modules/templates/email/update';
						$this->data['page_title'] = 'Email Templates';
						$this->load->view('template', $this->data);
				}
				else {
						$this->data['templates'] = $this->templates_model->get_all_templates();
						$this->data['main_content'] = 'modules/templates/email/index';
						$this->data['page_title'] = 'Email Templates';
						$this->load->view('template', $this->data);
				}
		}

}