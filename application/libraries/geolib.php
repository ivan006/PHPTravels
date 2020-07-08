<?php


class geolib {


   protected $ci = NULL;    //codeigniter instance

	//the default base currency
	protected $from_currency;
    protected $to_currency;
     protected $currency_symbol;
     protected $country;
    // country codes
    protected $code;
    protected $ip;
    protected $rate;
    protected $mulcur;

 function __construct() {
                             /*
     $this->mulcur = pt_default_currencies();
  	$this->ci = &get_instance();
     $this->ip = $this->ci->input->ip_address();
   if(!empty($this->mulcur)){
   $site_currency = $this->ci->session->userdata('currency');
   @$currency_symbol = $this->ci->session->userdata('currency_symbol');
   @$currency_country = $this->ci->session->userdata('currency_country');
   @$from_currency = $this->ci->session->userdata('from_currency');


  if(empty($site_currency)){
    $finalres = $this->get_user_country();
  $this->to_currency = $finalres['to_curr'];
  $this->currency_symbol = $finalres['curr_symbol'];
  $defcurr = $this->default_currency_code();
  $this->from_currency = $defcurr['code'];
  $this->country = $finalres['curr_country'];
  $this->ci->session->set_userdata('currency',$this->to_currency);
  $this->ci->session->set_userdata('currency_country', $this->country);
  $this->ci->session->set_userdata('currency_symbol',$this->currency_symbol);
  $this->ci->session->set_userdata('from_currency',$this->from_currency);

  }else{
  $this->from_currency = $from_currency;
  $this->to_currency = $site_currency;
  $this->currency_symbol =$currency_symbol;
  $this->country =$currency_country;

  }



  }*/

  }


  function get_user_country(){
              /*
 // $url = 'http://api.hostip.info/get_json.php?ip=188.49.14.118';
  $url = 'http://www.telize.com/geoip/'.$this->ip;


    $ch = curl_init();
    $timeout = 3;
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt ($ch, CURLOPT_USERAGENT,
                 "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $rawdata = curl_exec($ch);
    curl_close($ch);
     @$json = json_decode($rawdata);
     @$res = array();
     $res[] = @$json->continent_code;
     $res[] = @$json->country_code;

     return $this->get_user_currency($res);
*/

  }


  function get_user_currency($code){
    /*
    $this->ci->db->select('currency_country,currency_symbol,currency_code');
    $this->ci->db->where_in('currency_country',$code);
    @$res = $this->ci->db->get('pt_currencies')->result();
    $rslt['to_curr'] = $res[0]->currency_code;
    $rslt['curr_symbol'] = $res[0]->currency_symbol;
    $rslt['curr_country'] = $res[0]->currency_country;
    return $rslt;*/
  }

  function pt_convert($amount,$class = null) {

   /* $f_Currency = $this->from_currency;
    $to_Currency = $this->to_currency;

     if(!empty($this->mulcur)){
    $url = "http://rate-exchange.appspot.com/currency?from=$f_Currency&to=$to_Currency";


 $ch = curl_init();
    $timeout = 3;
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt ($ch, CURLOPT_USERAGENT,
                 "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $rawdata = curl_exec($ch);
    curl_close($ch);
     $json = json_decode($rawdata);
    $this->rate = $json->rate;
   $changed =  round($json->rate * $amount,2);

    if($changed < 1){
    $defcurr = $this->default_currency_code();


   return "<small>".$defcurr['code']."</small> <span class='".$class."'>".$defcurr['sign'].number_format($amount,2)."</span>";

    }else{

   return "<small>".$this->country."</small> <span class='".$class."'>".$this->currency_symbol.number_format($changed,2)."</span>";


    }



                         }*/

}

 function convert_price($amount) {    /*

    $f_Currency = $this->from_currency;
    $to_Currency = $this->to_currency;
    $response = array();
     if(!empty($this->mulcur)){
    $url = "http://rate-exchange.appspot.com/currency?from=$f_Currency&to=$to_Currency";


 $ch = curl_init();
    $timeout = 3;
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt ($ch, CURLOPT_USERAGENT,
                 "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $rawdata = curl_exec($ch);
    curl_close($ch);
     $json = json_decode($rawdata);
    $this->rate = $json->rate;
   $changed =  round($json->rate * $amount,2);

    if($changed < 1){
     $defcurr = $this->default_currency_code();
     $response['code'] = $defcurr['code'];
     $response['sign'] = $defcurr['sign'];
     $response['price'] = number_format($amount,2);

    }else{

     $response['code'] = $this->country;
     $response['sign'] = $this->currency_symbol;
     $response['price'] = number_format($changed,2);

    }

 }
 return $response;*/

}



function pt_amount_symbol($amount) { /*


   $result['amount'] = round($this->rate * $amount,2);
   $result['symbol']  = $this->currency_symbol;
    return $result;
*/
       }

function default_currency_code(){     /*
  $resp = array();
  $this->ci->db->select('currency_code,currency_sign');
  $this->ci->db->where('user','webadmin');
  $rest = $this->ci->db->get('pt_app_settings')->result();
  if(empty($rest[0]->currency_code)){
   $resp['code'] = "USD";
   $resp['sign'] = "$";

  }else{
   $resp['code'] = $rest[0]->currency_code;
   $resp['sign'] = $rest[0]->currency_sign;


  }
  return $resp;*/


}



}
