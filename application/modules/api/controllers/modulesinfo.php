<?php

header('Access-Control-Allow-Origin: *');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions

require APPPATH . 'modules/api/libraries/REST_Controller.php';



class Modulesinfo extends REST_Controller {



		function __construct() {

// Construct our parent class

				parent :: __construct();
				if(!$this->isValidApiKey){
               	$this->response($this->invalidResponse, 200);
               }

// Configure limits on our controller methods. Ensure

// you have created the 'limits' table and enabled 'limits'

// within application/config/rest.php

				$this->methods['list_get']['limit'] = 500; //500 requests per hour per user/key

				$this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key

				$this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key

               $this->load->library('ptmodules');            



               $param = $this->get('param');
               if(!empty($param)){
               	$func = $param."_get";
               $this->$func();	
               }else{

               $this->list_get();

               }

              

    }



		function list_get() {

				$list = $this->ptmodules->listModuleForApi();

				if (!empty ($list)) {

						$this->response(array('response' => $list, 'error' => array('status' => FALSE,'msg' => '')), 200); // 200 being the HTTP response code

				}

				else {

						$this->response(array('response' => "", array('status' => TRUE,'msg' => 'Modules Not Found')), 200);

				}

		}

		function dohop_get(){
			$this->load->library('flightsdohop/dohop_lib');

			$result = $this->dohop_lib->getUserName();


				if ($result->exists) {

						$this->response(array('response' => array('username' => $result->username)), 200);

				}

				else {

						$this->response(array('response' => "",array('status' => TRUE,'msg' => 'Dohop Module Not Found')), 200);

				}

			}



}