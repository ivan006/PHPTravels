<?php
if (!defined('BASEPATH'))
                exit ('No direct script access allowed');

class Cms extends MX_Controller {
                private $data = array();

                function __construct() {
                                parent :: __construct();
                                modules :: load('home');
                }

                public function index() {
                                $this->data['main_content'] = 'index';
                                $this->data['page_title'] = 'CMS Pages';
                                $this->load->view('home/template', $this->data);
                }

                public function contact() {
/*
$this->data['main_content'] = 'contact';
$this->data['page_title'] = 'CMS Pages';

$this->load->view('home/template',$this->data);*/
                }

}