<?php

$base_name = basename(__DIR__);
if($base_name == "public_html"){

define('CK_BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/');

}else{

define('CK_BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/'.basename(__DIR__).'/');

}
