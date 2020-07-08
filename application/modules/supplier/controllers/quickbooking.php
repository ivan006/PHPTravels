<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Quickbooking extends MX_Controller {
    private $data = array();
    public $role;

    function __construct() {
        modules :: load('supplier');
        $chksupplier = modules :: run('supplier/validsupplier');
        if (!$chksupplier) {
            $this->session->set_userdata('prevURL', current_url());
            redirect('supplier');
        }
        $this->load->model('admin/bookings_model');
        $this->load->model('admin/payments_model');
        $this->load->helper('check');
        $this->data['userloggedin'] = $this->session->userdata('pt_logged_supplier');
        $this->role = $this->session->userdata('pt_role');
        $this->data['role'] = $this->role;
        $this->data['app_settings'] = $this->settings_model->get_settings_data();
       // $this->data['applytax'] = $this->session->userdata('applytax');
        $this->data['applytax'] = $this->input->get('applytax');
        $this->lang->load("back", "en");  
    }

    function index() {
        $userid = $this->session->userdata('pt_logged_supplier');
        $booknow = $this->input->post('booknow');
        $usertype = $this->input->post('usertype');
        $customer = $this->input->post('customer');
         $service = $this->input->get('service');
        if (!empty ($booknow)) {
            if ($usertype == "registered") {
                        $this->bookings_model->doQuickBooking($customer); 
                        }
                        else {
                        $this->bookings_model->doGuestBooking('quick'); 
                        }
            redirect(base_url() . "supplier/bookings");
        }

        if(empty($booknow) && empty($service)){
                    redirect("supplier");
                }

        $this->data['modules'] = $this->modules_model->get_module_names();
        $this->data['chklib'] = $this->ptmodules;
        $this->data['service'] = $this->input->get('service');
        $this->data['customers'] = $this->accounts_model->get_active_customers();
//hotels module
        if ($this->data['service'] == "hotels") {
            $this->data['checkinlabel'] = "Check-In";
            $this->data['checkoutlabel'] = "Check-Out";
            $this->data['hotels'] = $this->hotels_model->all_hotels_names($userid);
        }
//end hotels module
//cars module
        if ($this->data['service'] == "cars") {
            $this->data['checkinlabel'] = "Date";
            /*$this->data['checkinlabel'] = "Pick Up";
            $this->data['checkoutlabel'] = "Drop Off";*/
            $this->load->model('cars/cars_model');
            $this->data['cars'] = $this->cars_model->all_cars_names($userid);
        }
//tours module
        if ($this->data['service'] == "tours") {
            $this->data['checkinlabel'] = "Start Date";
            $this->data['checkoutlabel'] = "End Date";
            $this->load->model('tours/tours_model');
            $this->data['tours'] = $this->tours_model->all_tours_names($userid);
        }
//end tours module
//end cars module
       $this->data['paygateways'] = $this->payments_model->getAllPaymentsBack();
        $this->data['main_content'] = 'admin/quickbooking/index';
        $this->data['page_title'] = 'Quick booking';
        $this->load->view('admin/template', $this->data);
    }

    function populateRooms() {
                $this->load->library('hotels/hotels_lib');
                $hotelid = $this->input->post('hotelid');
                $this->db->select('room_id,room_hotel,room_title,room_type');
                $this->db->where('room_hotel', $hotelid);
                $rooms = $this->db->get('pt_rooms')->result();
                $html = "
<option value=''>Select Room</option>
";
                foreach ($rooms as $room) {
                        $id = $room->room_id;
                        $title = $this->hotels_lib->getRoomType($room->room_type);
                        $html .= "
<option value=$id>" . $title . "</option>
";
                }
                echo $html;

    }

    function hoteldetails() {
        $hotelid = $this->input->post('item');
        $this->db->select('hotel_title,hotel_comm_fixed,hotel_comm_percentage,hotel_tax_fixed,hotel_tax_percentage');
        $this->db->where('hotel_id', $hotelid);
        $hotel = $this->db->get('pt_hotels')->result();
        if ($hotel[0]->hotel_comm_fixed > 0) {
            $comtype = "fixed";
            $comval = $hotel[0]->hotel_comm_fixed;
        }
        elseif ($hotel[0]->hotel_comm_percentage > 0) {
            $comtype = "percentage";
            $comval = $hotel[0]->hotel_comm_percentage;
        }
        if ($hotel[0]->hotel_tax_fixed > 0) {
            $taxtype = "fixed";
            $taxval = $hotel[0]->hotel_tax_fixed;
        }
        elseif ($hotel[0]->hotel_tax_percentage > 0) {
            $taxtype = "percentage";
            $taxval = $hotel[0]->hotel_tax_percentage;
        }
        $result = json_encode(array('title' => $hotel[0]->hotel_title, 'comm_type' => $comtype, 'comm_val' => $comval, 'tax_type' => $taxtype, 'tax_val' => $taxval, 'id' => $hotelid, 'btype' => 'hotels'));
        echo $result;
    }

    function hroomdetails() {
         $roomid = $this->input->post('roomid');
                $checkin = $this->input->post('checkin');
                $checkout = $this->input->post('checkout');
                $this->load->library('hotels/hotels_lib');                
                $title = $this->hotels_lib->getRoomTitleOnly($roomid);
                $info = $this->rooms_model->getRoomPrice($roomid,$checkin,$checkout);
                $bookedrooms = pt_is_room_booked($roomid, $checkin, $checkout);
                $quantity = $info['quantity'];
                $availablerooms = $quantity - $bookedrooms;
                $nights = $info['stay'];
          
                 $optionstxt = "";
                if ($availablerooms > 0) {
                        for ($i = 1; $i <= $availablerooms; $i++) {
                                $optionstxt .= "<option value=$i>$i</option>";
                        }
                }

                $currency = $this->data['app_settings'][0]->currency_sign;
                if(empty($currency)){
                    $currency = " ";
                }

                        $result = json_encode(array(
                    'roomtitle' => $title, 
                    'info' => $info,
                    'price' => $info['perNight'],
                    'avail_rooms' => $availablerooms,
                    'quantity' => $optionstxt,
                    'stay' => $nights,
                    'currency' => $currency
                    ));



                echo $result;
    }

    function totalnights() {
        $checkin = $this->input->post('checkin');
        $checkout = $this->input->post('checkout');
        $nights = pt_count_days($checkin, $checkout);
        $result = json_encode(array('stay' => $nights));
        echo $result;
    }

    function hotelsupps() {
        $hotelid = $this->input->post('hotelid');
                $this->load->library('hotels/hotels_lib');
                $this->hotels_lib->set_id($hotelid);
                $sups = $this->hotels_lib->hotelExtras();

                if (!empty ($sups)) {
                        $has_sups = 1;
                }
                else {
                        $has_sups = 0;
                }
                $suphtml = "
<table class='table table-srtiped'>
  <thead>
    <tr>
      <td><b>Name</b></td>
      <td><b>Price</b></td>
      <td><b>Order</b></td>
    </tr>
  </thead>
  <tbody>
    ";
                $currencysign = $this->data['app_settings'][0]->currency_sign;
                foreach ($sups as $sup) {
                        $id = "extras_" . $sup->id;
                        $js = "select_sup($(this).data('price'),$(this).data('title'),$sup->id,'$currencysign');";
                        $suptitle = "data-title=" . str_replace(" ", "&nbsp;", $sup->extraTitle);
                        $supmainprice = $sup->extraPrice;
                        
                        $suphtml .= "
    <tr>
      <td>" . $sup->extraTitle . "</td>
      <td>$currencysign$supmainprice </td>
      " . "
      <td> <input type='checkbox' class='extras' id=$id $suptitle data-price=$supmainprice onclick=$js    name='extras[]'  value=$sup->id  ></td>
    </tr>
    ";
                }
                $suphtml .= "
  </tbody>
</table>
";
                $result = json_encode(array('hassups' => $has_sups, 'extras' => $suphtml));
                echo $result;
    }

    function applytax() {
        $resp = $this->input->post('apply');
        if ($resp == "yes") {
            $this->session->set_userdata('applytax', 'yes');
        }
        else {
            $this->session->set_userdata('applytax', 'no');
        }
    }

    

    function carprice() {
       
    $carid = $this->input->post('carid');
    $this->load->library('cars/cars_lib');
    $carDetails = $this->cars_lib->car_details($carid);

    $mainprice = $carDetails->carPrice;

    $comtype =  $carDetails->comType;
    $comval =  $carDetails->comValue;
    $taxtype =  $carDetails->taxType;
    $taxval =  $carDetails->taxValue;



    $result = json_encode(array('title' => $carDetails->title, 'comm_type' => $comtype, 'comm_val' => $comval, 'tax_type' => $taxtype, 'tax_val' => $taxval, 'id' => $carid, 'btype' => 'cars','mainprice' => $mainprice, 'subitem' => $subitem));
    echo $result;
        
    }


    function carsupps() {
                $carid = $this->input->post('carid');
                $this->load->library('cars/cars_lib');
                $this->cars_lib->set_id($carid);
                $sups = $this->cars_lib->carExtras();

                if (!empty ($sups)) {
                        $has_sups = 1;
                }
                else {
                        $has_sups = 0;
                }
                $suphtml = "
<table class='table table-srtiped'>
  <thead>
    <tr>
      <td><b>Name</b></td>
      <td><b>Price</b></td>
      <td><b>Order</b></td>
    </tr>
  </thead>
  <tbody>
    ";
                $currencysign = $this->data['app_settings'][0]->currency_sign;
                foreach ($sups as $sup) {
                        $id = "extras_" . $sup->id;
                        $js = "select_CarExtra($(this).data('price'),$(this).data('title'),$sup->id,'$currencysign');";
                        $suptitle = "data-title=" . str_replace(" ", "&nbsp;", $sup->extraTitle);
                        $supmainprice = $sup->extraPrice;
                        
                        $suphtml .= "
    <tr>
      <td>" . $sup->extraTitle . "</td>
      <td>$currencysign$supmainprice </td>
      " . "
      <td> <input type='checkbox' class='extras' id=$id $suptitle data-price=$supmainprice onclick=$js    name='extras[]'  value=$sup->id  ></td>
    </tr>
    ";
                }
                $suphtml .= "
  </tbody>
</table>
";
                $result = json_encode(array('hassups' => $has_sups, 'extras' => $suphtml));
                echo $result;
        }

     function carUpdatedPrice() {
            $carid = $this->input->post('itemid');
            $extras =  $this->input->post('extras');
            $this->load->library('cars/cars_lib');
            echo $this->cars_lib->getUpdatedDataBookResultObject($carid,$extras);
        }

    function tourprice() {
             $tourid = $this->input->post('tourid');
            $this->load->library('tours/tours_lib');
            $tourDetails = $this->tours_lib->tour_details($tourid);

                $adultmax = $tourDetails->maxAdults;
                $maxchild = $tourDetails->maxChild;
                $maxinfant = $tourDetails->maxInfant;
                $adultselect = "";
                $childselect = "";
                $infantselect = "";

                for($a = 1;$a <= $adultmax;$a++){
                $adultselect .= "<option value=$a>$a</option>";
                }

                for($c = 0;$c <= $maxchild;$c++){
                $childselect .= "<option value=$c>$c</option>";
                }

                for($i = 0;$i <= $maxinfant;$i++){
                $infantselect .= "<option value=$i>$i</option>";
                }


                $mainprice = 1 *  $tourDetails->adultPrice;

                $comtype =  $tourDetails->comType;
                $comval =  $tourDetails->comValue;
                $taxtype =  $tourDetails->taxType;
                $taxval =  $tourDetails->taxValue;
             
               
               
                $result = json_encode(array('title' => $tourDetails->title, 'comm_type' => $comtype, 'comm_val' => $comval, 'tax_type' => $taxtype, 'tax_val' => $taxval, 'id' => $tourid, 'btype' => 'tours', 'tour_amount' => $touramount, 'adultselect' => $adultselect, 'childselect' => $childselect, 'infantselect' => $infantselect, 'maxadult' => $adultmax, 'maxchild' => $maxchild, 'maxinfant' => $maxinfant, 'mainprice' => $mainprice, 'subitem' => $subitem, 'priceadult' => $priceadult, 'pricechild' => $pricechild, 'priceinfant' => $priceinfant, 'startdate' => $startdate, 'enddate' => $enddate));
                echo $result;
    }


            function tourUpdatedPrice() {
            $tourid = $this->input->post('itemid');
            $adults = $this->input->post('adults');
            $child = $this->input->post('children');
            $infant = $this->input->post('infants');
            $extras =  $this->input->post('extras');
            $this->load->library('tours/tours_lib');
            echo $this->tours_lib->getUpdatedDataBookResultObject($tourid,$adults,$child,$infant,$extras);
        }

}