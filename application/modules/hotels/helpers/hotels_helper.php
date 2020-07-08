<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');
        if (!function_exists('getBackHotelTranslation')) {

		function getBackHotelTranslation($lang, $id) {
		  if(!empty($id)){
          $CI = get_instance();
          $CI->load->model('hotels/hotels_model');
          $res = $CI->hotels_model->getBackTranslation($lang,$id);
          return $res;
		  }else{
            return '';
		  }

		}

} if (!function_exists('getBackRoomTranslation')) {

		function getBackRoomTranslation($lang, $id) {
		  if(!empty($id)){
          $CI = get_instance();
          $CI->load->model('hotels/rooms_model');
          $res = $CI->rooms_model->getBackTranslation($lang,$id);
          return $res;
		  }else{
            return '';
		  }

		}

}if (!function_exists('GetRoomQuantity')) {

		function GetRoomQuantity($id) {
		  if(!empty($id)){
          $CI = get_instance();
          $CI->load->model('hotels/rooms_model');
          $res = $CI->rooms_model->getRoomQuantity($id);
          return $res;
		  }else{
            return '0';
		  }

		}

}if (!function_exists('getTypesTranslation')) {

		function getTypesTranslation($lang, $id) {
		  if(!empty($id)){
          $CI = get_instance();
          $CI->load->model('hotels/hotels_model');
          $res = $CI->hotels_model->getTypesTranslation($lang,$id);
          return $res;
		  }else{
            return '';
		  }

		}

}