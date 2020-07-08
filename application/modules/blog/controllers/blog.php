<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Blog extends MX_Controller {
    private $data = array();
    private $validlang;

    function __construct() {
        parent :: __construct();
        modules :: load('home');
        $this->load->library("blog_lib");
        $this->load->model("blog/blog_model");
        $this->load->helper("blog_front");
        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');
        $this->data['app_settings'] = $this->settings_model->get_settings_data();
        $this->data['lang_set'] = $this->session->userdata('set_lang');
        $this->data['usersession'] = $this->session->userdata('pt_logged_customer');
        $this->data['bloglib'] = $this->blog_lib;
        $chk = modules :: run('home/is_main_module_enabled', 'blog');
        if (!$chk) {
            Error_404();
        }

        

        $settings = $this->settings_model->get_front_settings('blog');
       
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
        $this->blog_lib->set_lang($this->data['lang_set']);
        $this->data['popular_posts'] = $this->blog_model->get_popular_posts($settings[0]->front_popular);
        $this->data['categories'] = $this->blog_lib->getCategories();
    }

    public function index() {
        $settings = $this->settings_model->get_front_settings('blog');
        $this->data['ptype'] = "index";
        $this->data['categoryname'] = "";
        
        if($this->validlang){

                    $slug = $this->uri->segment(3);

                }else{

                    $slug = $this->uri->segment(2);
                }
        if (!empty ($slug)) {
            $this->blog_lib->set_blogid($slug);
            $this->data['details'] = $this->blog_lib->post_details();
            $this->data['title'] = $this->blog_lib->title;
            $this->data['desc'] = $this->blog_lib->desc;
            $this->data['thumbnail'] = $this->blog_lib->thumbnail;
            $this->data['date'] = $this->blog_lib->date;
            $hits = $this->blog_lib->hits + 1;
            $this->blog_model->update_visits($this->data['details'][0]->post_id, $hits);
            $relatedstatus = $settings[0]->testing_mode;
            if ($relatedstatus == "1") {
                $this->data['related_posts'] = $this->blog_model->get_related_posts($this->data['details'][0]->post_related, $settings[0]->front_related);
            }
            else {
                $this->data['related_posts'] = "";
            }
            $res = $this->settings_model->get_contact_page_details();
            $this->data['fbcomments'] = $settings[0]->front_fb_comments;
            $this->data['sharing'] = $settings[0]->front_sharing;
            $this->data['phone'] = $res[0]->contact_phone;
            $this->data['page_title'] = $this->blog_lib->title;
            $this->data['metakey'] = $this->data['details'][0]->post_meta_keywords;
            $this->data['metadesc'] = $this->data['details'][0]->post_meta_desc;
            $this->data['langurl'] = base_url()."blog/{langid}/".$this->blog_lib->slug;
            $this->theme->view('blog/blog', $this->data);
        }
        else {
            $this->listing();
        }
    }

    function listing($offset = null) {
        $settings = $this->settings_model->get_front_settings('blog');
        $this->data['ptype'] = "index";
        $this->data['categoryname'] = "";
        $allposts = $this->blog_lib->show_posts($offset);
        $this->data['allposts'] = $allposts['all_posts'];
        $this->data['info'] = $allposts['paginationinfo'];
        $this->data['page_title'] = $settings[0]->header_title;
        $this->data['langurl'] = base_url()."blog/{langid}/";
        $this->theme->view('blog/index', $this->data);
    }

    function search($offset = null) {
        $this->data['ptype'] = "search";
        $this->data['categoryname'] = "";
        $settings = $this->settings_model->get_front_settings('blog');
        $allposts = $this->blog_lib->search_posts($offset);
        $this->data['allposts'] = $allposts['all_posts'];
        $this->data['info'] = $allposts['paginationinfo'];
        $this->data['page_title'] = $settings[0]->header_title;
        $this->data['langurl'] = base_url()."blog/{langid}/";
        $this->theme->view('blog/index', $this->data);
    }

    function category($offset = null) {
        $settings = $this->settings_model->get_front_settings('blog');
        $id = $this->input->get('cat');
        $this->data['ptype'] = "category";
        $this->data['categoryname'] = pt_blog_category_name($id);
        $allposts = $this->blog_lib->category_posts($offset);
        $this->data['allposts'] = $allposts['all_posts'];
        $this->data['info'] = $allposts['paginationinfo'];
        $this->data['page_title'] = $settings[0]->header_title;
        $this->theme->view('blog/index', $this->data);
    }

}