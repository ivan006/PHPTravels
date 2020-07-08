<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/api/libraries/REST_Controller.php';

class Invoice extends REST_Controller {

    function __construct() {
// Construct our parent class
        parent :: __construct();
        
        if(!$this->isValidApiKey){
        $this->response($this->invalidResponse, 400);
        }
    }

    function info_get() {
        $this->load->helper('invoice');
        $this->load->helper('api/apihelp');
        $id = $this->get('invoiceno');
        $code = $this->get('invoicecode');
        $info = api_valid_invoice($id, $code);
        $url = base_url() . "invoice?id=" . $id . "&sessid=" . $code;
        if ($info) {
            $this->response(array('response' => array('url' => $url)), 200); // 200 being the HTTP response code
        }
        else {
            $this->response(array('response' => array('error' => 'Not Found')), 200);
        }
    }

    function verifyCoupon_post(){
        $code = $this->post('code');
        $module = $this->post('module');
        $itemid = $this->post('itemId');
        $resp = json_decode(pt_couponVerify($code, $module, $itemid));
        $this->response(array('response' => $resp), 200); // 200 being the HTTP response code


    }

    function show_get() {
        $url = base_url() . "api/blog/list";
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
        $url = base_url() . "api/contact/send";
        $fields = array('contact_name' => 'irshad ali jan', 'contact_email' => 'irshad@yahoo.com', 'contact_subject' => "this is subject", 'contact_message' => "This is the message", 'sendto' => "sendto@email.com");
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