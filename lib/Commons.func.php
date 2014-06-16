<?php

/**
  @class Commons ver 1.0
  @brief PHP Commons

  * registered date 2014-01-23
  * programmed by Seok Kyun. Choi. 최석균
  * http://syaku.tistory.com
  */

  function _log($val,$text = 'LOG') {
    global $F;
    $F->log($val, $text);
  }

  function _strval($mixed) {
    if (is_bool($mixed)) return ($mixed) ? 'true' : 'false';
    if (is_null($mixed)) return 'null';
    if (is_array($mixed)) return json_encode($mixed);
    if (is_object($mixed)) return json_encode( get_object_vars($mixed) );
    return strval($mixed);
  }

  // 임의의 키명이 포함된 배열만 추출
  function _array_strpos($array, $key, $string = FALSE, $encode = FALSE) {
    $return = array();
    foreach($array as $k => $v) {
      if ($encode && !empty($v) ) $v = urlencode($v);

      if (strpos($k,$key) > -1) {

        if ($string) {
          $return[$k] = _strval($v);
        } else {
          $return[$k] = $v;
        }

      }

    }

    return $return;
  }

  /**
  * 배열을 원하는 인덱스에 추가
  *
  * @param array 원래 배열
  * @param array 추가 배열
  * @param string|integer 위치
  * @param boolean#TRUE index 앞 혹은 뒤 추가 설정
  * @return array
  */
  function _array_push(&$array, $array2, $index, $after = TRUE) {
    $return = array();

    if( is_int($index) ) {
      if ($after) $index + 1;
      $return = array_merge( array_slice($array, 0, $index), $array2, array_slice($array, $index) );

    } else {

      foreach($array as $k => $v) {
        if ($after) $return[$k] = $v;
        if($k == $index) $return = array_merge($return, $array2);
        if (!$after) $return[$k] = $v;
      }
    }

    return $return;
  }

  // 랜덤 문자
  function _rand_string($len = 10, $str= 'azAZ09@', $array = NULL) {
    $alphabet = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    $ALPHABET = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $numeric = array('0','1','2','3','4','5','6','7','8','9');
    //$special = array('`','~','!','@','#','$','%','^','&','*','(',')','-','_','=','+','\\','|','[','{',']','}',';',':','\'','"',',','<','.','>','/','?');
    $special = array('~','!','@','#','$','%','^','&','*','(',')','_','+','=','{','}','-','<','>','?','[',']');

    $s = array();
    if ( strpos($str,'az') > -1 ) $s = array_merge($s,$alphabet);
    if ( strpos($str,'AZ') > -1 ) $s = array_merge($s,$ALPHABET);
    if ( strpos($str,'09') > -1 ) $s = array_merge($s,$numeric);
    if ( strpos($str,'@') > -1 ) $s = array_merge($s,$special);
    if ( !is_null($array) && is_array($array) ) $s = array_merge($s,$array);

    $count = count($s) - 1;
    $result = '';
    for($i = 0; $i < $len; $i++) {
      $num = rand(0,$count);
      $result .= $s[$num];
    }
    return $result;
  }

  // 두개의 배열을 마이그함. empty 가 true 인 경우 빈값 제거
  function _extend_empty($val) {
    return !_is_empty($val);
  }
  function _extend($array,$array2,$empty = TRUE) {
    if ( !is_array($array2) ) return $array;
    if ( !is_array($array) ) return $array2;

    // 빈 값 제거 (0은 값을 인정함)
    if ($empty) $array2 = array_filter($array2, '_extend_empty');

    return array_merge($array,$array2);
  }

  // 봇 체크
  function _is_bot($bots) {
    if ( !is_array($bots) ) return true;

    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    foreach ( $bots as $bot ) {
      if ( ereg($bot, $user_agent)) return true;
    }
    
    return false;
  }

  // 모바일 여부 체크
  function _is_mobile($mobiles) {
    if ( !is_array($mobiles) ) return true;

    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    foreach ( $mobiles as $mobile ) {
      if ( eregi($mobile, $user_agent)) return true;
    }
    
    return false;
  }

  // 페이지 인덱스
  function _page_index($total_count = 0, $page = NULL, $page_row = NULL, $page_link = NULL) {
    global $GV;

    if ( is_null($page) ) $page = $GV['PAGE'];
    if ( is_null($page_row) ) $page_row = $GV['PAGE_ROW'];
    if ( is_null($page_link) ) $page_link = $GV['PAGE_LINK'];

  	if( empty($page) || $page == '0') $page = 1;
  	if( empty($page_row) ) $page_row = 10;
  	if( empty($page_link) ) $page_link = 10;

  	// 총 페이지수
  	$total_page = floor(($total_count - 1) / $page_row) + 1;
  	// 시작 페이지 번호
  	$start_page = floor(($page - 1) / $page_link) * $page_link + 1;
  	// 현재 페이지 번호
  	$now_page = floor($start_page / $page_link) + 1;
  	// 마지막 페이지 번호
  	$end_page = $start_page + ($page_link - 1);
  	// 시작 페이지 인덱스 번호
  	$start_idx = ($page - 1) * $page_row;
  	// 페이지 가상번호
  	$virtual_idx = $total_count - ($page_row * ($page - 1));

    $result = array();
    $result['page'] = $page;
    $result['page_row'] = $page_row;
    $result['page_link'] = $page_link;
    $result['total_count'] = $total_count;
    $result['total_page'] = $total_page;
    $result['start_page'] = $start_page;
    $result['now_page'] = $now_page;
    $result['end_page'] = $end_page;
    $result['start_idx'] = $start_idx;
    $result['virtual_idx'] = $virtual_idx;
    return $result;
  }

  /**
  * 빈값여부를 체크함.
  *
  * @param string 값
  * @param string 빈값인 경우 지정할 값
  * @return string
  */
  function _empty($val,$def = NULL) {
		if ( empty($val) && $def != NULL ) $val = $def;
		return $val;
  }
  function _is_empty($val, $zero = TRUE) {
    if ($val == 0 && $zero) return FALSE;
    return empty($val);
  }


  /**
  * 값이 HTML 인 경우 텍스트만 남기고 모두 지움
  *
  * @param string 값
  * @return string
  */
  function _nude_html($str) {
    if ( empty($str) ) return $str;
    $str = preg_replace('/\&nbsp;/i',' ',$str);
    $str = preg_replace('/(<{1}\/{0,1})[^<>]*(\/{0,1}>{1})/i','',$str);
    return $str;
  }

  /**
  * GET,POST 조합하여 파라메터 값 읽어오기
  *
  * @param string 파라메터 이름
  * @param string 빈 값인 경우 지정한 값
  * @param boolean 정해진 문자값이 아닌 경우 제거함
  * @return string
  */
  function _req_param($name,$def = NULL,$fixed = false) {
    $p = _param($name,$def, NULL);
    if ($fixed) $p = preg_replace('/[^a-zA-Z0-9-_.]+/','',$p);
    return $p;
  }

  /**
  * 파라메터 값 읽어오기
  *
  * @param string 파라메터 이름
  * @param string 빈값인 경우 지정한 값
  * @param string 메소드 지정
  * @return string || NULL
  */
  function _post($name,$def = NULL) {
    return _param($name,$def,'POST');
  }
  function _param($name,$def = NULL, $method = 'GET') {
    if ($method == NULL) {
      $param = _extend($_GET,$_POST);
      $param = $param[$name];
    } else {
      $param = ($method == 'GET') ? $_GET[$name] : $_POST[$name];
    }
		if ( empty($param) && !is_null($def) ) $param = strval($def);

		return $param;
  }

  /**
  * Request QueryString 을 이용하여 임의의 문자열을 변형함
  *
  * @param string 조합할 QueryString
  * @param string 시작 문자열 지정 (? or &)
  * @param string 메소드 지정
  * @return string
  */
  function _param_get($query,$char = NULL,$method = 'GET') {
    $parameter = ($method == 'GET') ? $_GET: $_POST;
    $ret = array();
    $output = array();

    if ( !empty($query) ) {
      parse_str($query,$output);
      foreach(array_keys($output) as $key){
        if ( !empty($output[$key]) ) {
          $ret[$key] = $output[$key];
        } else {
          unset($parameter[$key]);
        }
      }

    }

    $param = http_build_query(array_merge($parameter, $ret));
    if ( $char != NULL && !empty($param) ) { $param = $char . $param; }
    return $param;
  }

  /**
  * Request QueryString 에서 필요한 문자열만 추출
  *
  * @param string 조합할 QueryString
  * @param string 시작 문자열 지정 (? or &)
  * @param string 메소드 지정
  * @return string
  */
  function _param_pick($query,$char = NULL,$method = 'GET') {
    if ( empty($query) ) return NULL;
    $parameter = ($method == 'GET') ? $_GET: $_POST;

    $ret = array();
    $output = array();

    parse_str($query,$output);
    foreach(array_keys($output) as $key){

      if ( !empty($output[$key]) ) {
        $ret[$key] = $output[$key];
      } else {
        $is = array_key_exists ($key, $parameter);
        
        if ($is) {
          $ret[$key] = $parameter[$key];
        }
      }
    }

    $param = http_build_query($ret);
    if ( $char != NULL && !empty($param) ) { $param = $char . $param; }
    return $param;
  }

/*
  // 필수 공용 파라메터값 치환
  function _pix_param($val) {
//    $val = strtolower($val);
    $val = preg_replace('/[^a-zA-Z0-9_.]+/','',$val);
    return $val;
  }
*/

  /**
  * 24시간 기준 최신 여부 체크
  *
  * @param string datetime 20140101220101
  * @param string 시작 문자열 지정 (? or &)
  * @param string 메소드 지정
  * @return string
  */
  function _new_display($datetime,$time = null) {
    if ($time == null) $time = 24 * (60*60); //하루
    $now_datetime = _date();
    return ( strtotime($datetime) + $time > strtotime($now_datetime) );
  }

  function _module($cls,$fn) {
    if(class_exists($cls)) {
      $tmp_fn = create_function('', "return new {$cls}();");
      $oModule = $tmp_fn();
      if(is_object($oModule)) {
        if(@method_exists($oModule, $fn)) $oModule->{$fn}();
      }
    }
  }

  function _get_url_xml($url) {
    $xml = file_get_contents($url);
    $result = simplexml_load_string($xml);
    $count = count($result);

    $list = array();

    for($i = 0; $i < $count; $i++) {
      $data = null;
      foreach($result->item[$i] as $key => $val) {
        $val = empty($val) ? "" : $val;
        $data[$key] = $val;
      }
      array_push($list,$data);
    }

    return $list;
  }

  function _get_url_json($url,$is = true) {
    $json = file_get_contents($url);
    return json_decode($json , $is);
  }

  /**
  * 날짜를 원하는 포맷으로 치환하면 반환함.
  *
  * @param string PHP date 포맷
  * @param string datetime 모든 문자를 제외한 숫자만 6 혹은 12자리여야 함.
  * @return string
  */
  function _date($format = NULL,$date = 1) {
    if ( empty($date) ) return NULL;
    if ( $date == 1 ) $date = date("YmdHis");
    if ( is_null($format) ) return $date;

    $date = preg_replace('/[^0-9]+/','',$date);

    if ( strlen($date) == 8) $date = str_pad($date,14,'0');
    if ( strlen($date) != 14 ) return $date;


    if ( preg_match('/\$/',$format) ) {
      $patten = "/(^[0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/i";
      return preg_replace($patten,$format,$date);
    } else {
      return date($format , strtotime($date) );
    }

  }


function _file_format($size,$unit = 0) {

  $unit_string = "";
  $ret_size = "";

  $size_kb = 1024;
  $size_mb = $size_kb * 1024;
  $size_gb = $size_mb * 1024;
  $size_tb = $size_gb * 1024;

  switch ($unit) {
  
    case 0 :

      if ($size_tb <= $size) {
        $size = $size / 1024 / 1024 / 1024 / 1024;
        $unit_string = " TB";
      } else if ($size_gb <= $size && $size_tb > $size) {
        $size = $size / 1024 / 1024 / 1024;
        $unit_string = " GB";
      } else if ($size_mb <= $size && $size_gb > $size) {
        $size = $size / 1024 / 1024;
        $unit_string = " MB";
      } else if ($size_kb <= $size && $size_mb > $size) {
        $size = $size / 1024;
        $unit_string = " KB";
      } else {
        $unit_string = " B";
      }

    break;

    case 1 :
      $unit_string = " B";
    break;

    case 2 :
      $size = $size / 1024;
      $unit_string = " KB";
    break;
    case 3 :
      $size = $size / 1024 / 1024;
      $unit_string = " MB";
    break;
    case 4 :
      $size = $size / 1024 / 1024 / 1024;
      $unit_string = " GB";
    break;
    case 5 :
      $size = $size / 1024 / 1024 / 1024 / 1024;
      $unit_string = " TB";
    break;
  
  }

  $ret_size = round($size) . $unit_string;
  return $ret_size;
}

function _resize_width($file,$w) {
  /*
  Array ( [0] => 574 [1] => 404 [2] => 1 [3] => width="574" height="404" [bits] => 8 [channels] => 3 [mime] => image/gif )
  1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(orden de bytes intel), 8 = TIFF(orden de bytes motorola), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF, 15 = WBMP, 16 = XBM. 
  */

  $img = getimagesize($file);
  $width = $img[0];

  if ($w > $width) { return $width; } else { return $w; }
}

function _cutstring($string, $cut_size = 0, $tail = '...')
{
	if($cut_size < 1 || !$string)
	{
		return $string;
	}

	$chars = array(12, 4, 3, 5, 7, 7, 11, 8, 4, 5, 5, 6, 6, 4, 6, 4, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 4, 4, 8, 6, 8, 6, 10, 8, 8, 9, 8, 8, 7, 9, 8, 3, 6, 7, 7, 11, 8, 9, 8, 9, 8, 8, 7, 8, 8, 10, 8, 8, 8, 6, 11, 6, 6, 6, 4, 7, 7, 7, 7, 7, 3, 7, 7, 3, 3, 6, 3, 9, 7, 7, 7, 7, 4, 7, 3, 7, 6, 10, 6, 6, 7, 6, 6, 6, 9);
	$max_width = $cut_size * $chars[0] / 2;
	$char_width = 0;

	$string_length = strlen($string);
	$char_count = 0;

	$idx = 0;
	while($idx < $string_length && $char_count < $cut_size && $char_width <= $max_width)
	{
		$c = ord(substr($string, $idx, 1));
		$char_count++;
		if($c < 128)
		{
			$char_width += (int) $chars[$c - 32];
			$idx++;
		}
		else if(191 < $c && $c < 224)
		{
			$char_width += $chars[4];
			$idx += 2;
		}
		else
		{
			$char_width += $chars[0];
			$idx += 3;
		}
	}

	$output = substr($string, 0, $idx);
	if(strlen($output) < $string_length)
	{
		$output .= $tail;
	}

	return $output;
}

function getmicrotime() {
  list($usec, $sec) = explode(" ", microtime()); 
  return ((float)$usec + (float)$sec); 
}
?>