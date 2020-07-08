<?php

/**

 * @author  Rabotyahoff

 * @version 0.2

 * @license BSD

 *

 * This class can parce link to page with video to uniq ID.

 * It can get preview images and embed-code by ID.

 * Now it supports youtube.com, vimeo.com and rutube.ru.

 *

 * site:  http://ra-project.net/my_classes/c_video_providers

 * email: rabotyahoff@gmail.com

 *

 * date:  2012.02.05

 * first release

 *

 * date:  2013.01.03

 * * fix rutube

 * + title, descrition, duration

 *

 */



/*

 * base class of video provider

 */

abstract class a_video_provider{

	protected $video_id=false;

	protected $cache_xml=array();



	function __construct($video_id=false){

		if ($video_id!==false) $this->set_video_id($video_id);

	}



	/**

	 *

	 * @param string $video_id

	 * @return a_video_provider

	 */

	function set_video_id($video_id){

		$this->video_id=$video_id;

		return $this;

	}



	/**

	 *

	 * @param string $url

	 * @return SimpleXMLElement

	 */

	protected function read_remote_xml($url){

		if (empty($this->cache_xml[$url])){

			$this->cache_xml[$url]=simplexml_load_file($url);

		}

		return $this->cache_xml[$url];

	}



    	/**

	 * @return string

	 */

	abstract function get_embed_url();

    /**

	 * @return string

	 */

	abstract function get_url_watch();

	/**

	 * @return string

	 */

	abstract function get_embed();

	/**

	 * @return array

	 */

	abstract function get_url_img_preview();

	/**

	 * @return array

	 */

	abstract function get_info();

	/**

	 * @return array

	 */

	abstract function get_regexps();

}



/*Begin video providers*/

class c_video_provider_youtube extends a_video_provider {



	function get_url_watch(){

		return 'https://www.youtube.com/watch?v='.$this->video_id;

	}

    function get_embed_url(){



    return  'https://www.youtube.com/embed/'.$this->video_id;

    }



	function get_embed(){

		return '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$this->video_id.'" frameborder="0" webkitAllowFullScreen="webkitAllowFullScreen" mozallowfullscreen="mozallowfullscreen" allowfullscreen="allowfullscreen"></iframe>';

	}



	function get_url_img_preview(){

		$result=array();

		$result['small'] = 'https://img.youtube.com/vi/'.$this->video_id.'/default.jpg';

		$result['medium'] = 'https://img.youtube.com/vi/'.$this->video_id.'/hqdefault.jpg';

		$result['large'] = 'https://img.youtube.com/vi/'.$this->video_id.'/hqdefault.jpg';



		return $result;

	}



	function get_info(){

	  $result=false;



	  @$content = file_get_contents("https://youtube.com/get_video_info?video_id=".$this->video_id);

	  if (!empty($content)){

	    parse_str($content, $arr);

	    if (!empty($arr)){

	      $result=array();

	      @$result['title']= $arr['title'];

	      @$result['description'] = '';

	      @$result['duration']= $arr['length_seconds'];

	    }

	  }



	  return $result;

	}



	function get_regexps(){

		$start="(?:\/|\s|^)(?:www\.)?";

		$result=array();

		$result[]=$start."youtube\.com\/watch\/?\?v=([A-Za-z0-9_-]+)";

		$result[]=$start."youtu.be\/([A-Za-z0-9_-]+)";

		return $result;

	}

}

class c_video_provider_vimeo extends a_video_provider {



	function get_url_watch(){

		return 'https://vimeo.com/'.$this->video_id;

	}



    function get_embed_url(){



    return  'https://player.vimeo.com/video/'.$this->video_id;

    }



	function get_embed(){

		return '<iframe width="400" height="225" src="https://player.vimeo.com/video/'.$this->video_id.'?title=0&amp;byline=0&amp;portrait=0" webkitAllowFullScreen="webkitAllowFullScreen" mozallowfullscreen="mozallowfullscreen" allowfullscreen="allowfullscreen"></iframe>';

	}



	protected function _url_xml(){

	  return 'https://vimeo.com/api/v2/video/'.$this->video_id.'.xml';

	}



	function get_url_img_preview(){

		$result=false;

		$xml = $this->read_remote_xml($this->_url_xml());

		if ($xml) {

			$result = array();

			$result['small'] = (string) $xml->video->thumbnail_small;

			$result['medium'] = (string) $xml->video->thumbnail_medium;

			$result['large'] = (string) $xml->video->thumbnail_large;

		}

		return $result;

	}



	function get_info(){

	  $result=false;

	  $xml = $this->read_remote_xml($this->_url_xml());

		if ($xml) {

		  $result = array();

			$result['title'] = (string) $xml->video->title;

			$result['description'] = strip_tags((string) $xml->video->description);

			$result['duration']=(int) $xml->video->duration;

		}

		return $result;

	}



	function get_regexps(){

		$start="(?:\/|\s|^)(?:www\.)?";

		$result=array();

		$result[]=$start."vimeo.com\/(\d+)";

		return $result;

	}

}

class c_video_provider_rutube extends a_video_provider {



	function get_url_watch(){

		return 'https://rutube.ru/video/'.$this->video_id.'.html';

	}



     function get_embed_url(){



   return "https://rutube.ru/cgi-bin/xmlapi.cgi?rt_mode=movie&rt_movie_id=".$this->video_id."&utf=1";

    }



	protected function _url_xml(){

	  return "https://rutube.ru/cgi-bin/xmlapi.cgi?rt_mode=movie&rt_movie_id=".$this->video_id."&utf=1";

	}



	function get_embed(){

		$result=false;

		$xml = $this->read_remote_xml($this->_url_xml());

		if ($xml) {

			$result = (string) $xml->html;

		}

		return $result;

	}



	function get_url_img_preview(){

		$result=false;

		$xml = $this->read_remote_xml($this->_url_xml());

		if ($xml) {

			$result=array();

			$result['small'] = (string) $xml->thumbnail_url;

			$result['medium'] = (string) $xml->thumbnail_url;

			$result['large'] = (string) $xml->thumbnail_url;

		}

		return $result;

	}



	function get_info(){

	  $result=false;

	  $xml = $this->read_remote_xml($this->_url_xml());

		if ($xml) {

		  $result = array();

			$result['title'] = (string) $xml->title;

			$result['description'] = strip_tags((string) $xml->description);

			$result['duration']=(int) $xml->duration;

		}

		return $result;

	}



	function get_regexps(){

		$start="(?:\/|\s|^)(?:www\.)?";

		$result=array();

		$result[]=$start."rutube.ru\/video\/([A-Za-z0-9_-]+)\/";

		$result[]=$start."rutube.ru\/video\/([A-Za-z0-9_-]+)";

		return $result;

	}

}

class c_video_provider_dailymotion extends a_video_provider {



  function get_url_watch(){

    return 'https://www.dailymotion.com/video/'.$this->video_id;

  }



  function get_embed_url(){



  // return "https://www.dailymotion.com/services/oembed?format=xml&url=".$this->get_url_watch();

   return "https://www.dailymotion.com/embed/video/".$this->video_id;

  }



  protected function _url_xml(){

    return "https://www.dailymotion.com/services/oembed?format=xml&url=".$this->get_url_watch();

  }



  function get_embed(){

    return '<iframe frameborder="0" width="480" height="270" src="https://www.dailymotion.com/embed/video/'.$this->video_id.'" webkitAllowFullScreen="webkitAllowFullScreen" mozallowfullscreen="mozallowfullscreen" allowfullscreen="allowfullscreen"></iframe>';

    $result=false;



    $xml = $this->read_remote_xml($this->_url_xml());

    if ($xml) {

      $result = (string) $xml->html;

    }

    return $result;

  }



  function get_url_img_preview(){

    $result=false;

    $xml = $this->read_remote_xml($this->_url_xml());

    if ($xml) {

      $result = array();

      $result['small'] = (string) $xml->thumbnail_url;

      $result['medium'] = (string) $xml->thumbnail_url;

      $result['large'] = (string) $xml->thumbnail_url;

    }

    return $result;

  }



  function get_info(){

    $result=false;

    $xml = $this->read_remote_xml($this->_url_xml());

    if ($xml) {

      $result = array();

			$result['title'] = (string) $xml->title;

			$result['description'] = '';

			$result['duration']='';

    }

    return $result;

  }



  function get_regexps(){

    $start="(?:\/|\s|^)(?:www\.)?";

    $result=array();

    $result[]=$start."dailymotion.com\/([\/A-Za-z0-9_-]*)video\/([A-Za-z0-9_-]+)";

    return $result;

  }

}

/*End video providers*/



class c_video_providers {

  public static $provider_youtube='YOUTUBE';

  public static $provider_vimeo='VIMEO';

  public static $provider_rutube='RUTUBE';

  public static $provider_dailymotion='DAILYMOTION';

  public $provider_ids=array();



  function __construct(){

  	$this->provider_ids[]=c_video_providers::$provider_youtube;

  	$this->provider_ids[]=c_video_providers::$provider_vimeo;

  	$this->provider_ids[]=c_video_providers::$provider_rutube;

  	$this->provider_ids[]=c_video_providers::$provider_dailymotion;

  }



  /**

   * @param string $provider_id

   * @return boolean|a_video_provider

   */

  protected function get_provider($provider_id){

  	$o_video_provider=false;

  	switch ($provider_id){

  		case c_video_providers::$provider_youtube:

  			$o_video_provider=new c_video_provider_youtube();

  		break;

  		case c_video_providers::$provider_vimeo:

  			$o_video_provider=new c_video_provider_vimeo();

  		break;

  		case c_video_providers::$provider_rutube:

  			$o_video_provider=new c_video_provider_rutube();

  		break;

  		case c_video_providers::$provider_dailymotion:

  			$o_video_provider=new c_video_provider_dailymotion();

  		break;

  	}

  	return $o_video_provider;

  }



  /**

   *

   * @param string $video_code 'YOUTUBE:zlOYV3vMy8o'

   * @return boolean|array

   */

  function get_video_info($video_code) {

    $tmp=explode(':', $video_code);

    $provider_id=strtoupper($tmp[0]);

    $video_id=$tmp[1];



    $o_video_provider=$this->get_provider($provider_id);

    if ($o_video_provider===false) return false;



    $o_video_provider->set_video_id($video_id);



    $res=array();

    $res['url_watch']=$o_video_provider->get_url_watch();

    $res['url_embed']=$o_video_provider->get_embed_url();

    $res['embed']=$o_video_provider->get_embed();

    $res['url_img_preview']=$o_video_provider->get_url_img_preview();

    $res['info']=$o_video_provider->get_info();



    return $res;

  }



  /**

   *

   * @param string provider_idr

   * @param string provider_idd

   * @return string

   */

  protected function make_video_code($provider_id, $video_id){

    return $provider_id.':'.$video_id;

  }



  /**

   *

   * @param string provider_id * @return string|boolean

   */

  function get_video_code($link){

    $prov_regexps=array();

    foreach ($this->provider_ids as $provider_id){

    	$o_video_provider=$this->get_provider($provider_id);

    	if ($o_video_provider===false) continue;

    	$prov_regexps[$provider_id]=$o_video_provider->get_regexps();

    }



    foreach ($prov_regexps as $provider_id=>$regexps){

      if (!empty($regexps)){

        foreach ($regexps as $regexp){

          $matches=array();

          preg_match('/'.$regexp.'/i', $link, $matches);

          if (!empty($matches)){

            return  $this->make_video_code($provider_id, $matches[count($matches)-1]);

          }

        }

      }

    }



    return false;

  }



}



