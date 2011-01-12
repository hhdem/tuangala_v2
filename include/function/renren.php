<?php

define('RR_API_SERVER', 'http://api.renren.com/restserver.do?');

define('RR_CONNECT_API_KEY', '58f2b48818d446be97a1827dd10d89f2');//这里改成自己的
define('RR_CONNECT_SECRET', '852612554a5745878d89777c1dd1ca0a');//这里改成自己的


//------------下面是API接口调用的客户端----------------
function rr_get_user_info($uids=0) {
	if($uids)
	{
		$params = array("uids"=>$uids,"fields"=> array('name','sex','star','birthday','tinyurl','headurl','mainurl'));
	}
	else
	{
		$params = array("fields"=> array('name','sex','star','birthday','tinyurl','headurl','mainurl'));
	}
	
	$user_info = rr_call_api('xiaonei.users.getInfo', $params);
	$result=$user_info[0];
	$bday=$result->birthday;
	if($bday)
	{
		if(strlen($bday)>=4)
		{
			if(substr($bday,0,2)==='17'){ 
				$result->birthday='0000'.substr($bday,4);
			}
		}
	}
	return $result;
}
function rr_generate_sig($params, $secret=RR_CONNECT_SECRET) {
	ksort($params);
	$sig = '';
	foreach($params as $key=>$value) {
		$sig .= "$key=$value";
	}
	
	$sig .= $secret;
	
	return md5($sig);
}
function rr_get_session() {
	$connect_session = array (
									"user" => $_COOKIE[RR_CONNECT_API_KEY.'_user'],
									"session_key" => $_COOKIE[RR_CONNECT_API_KEY.'_session_key'],
									"ss" => $_COOKIE[RR_CONNECT_API_KEY.'_ss'],
									"expires" => $_COOKIE[RR_CONNECT_API_KEY.'_expires'],
									);

	return $connect_session;
}


function rr_verify() {
	$session = rr_get_session();
	
	if(empty($session) || empty($session['expires']) || time() > intval($session['expires']) ) 
		return false;
	else 
		return rr_generate_sig($session) == $_COOKIE[RR_CONNECT_API_KEY];
}

function rr_get_id() {
	return $_COOKIE[RR_CONNECT_API_KEY.'_user'];
}

function rr_get_session_key() {
	return $_COOKIE[RR_CONNECT_API_KEY.'_session_key'];
}

function rr_call_api($method, $params) {
	$post_body = rr_post_body($method, $params);
	
	if (function_exists('curl_init')) {
		  $request = curl_init();
		  curl_setopt($request, CURLOPT_URL, RR_API_SERVER);
		  curl_setopt($request, CURLOPT_POST, 1);
		  curl_setopt($request, CURLOPT_POSTFIELDS, $post_body);
		  curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
		  
		  $result = curl_exec($request);
		  
		  curl_close($request);
	} else {
		$context =array('http' =>
					  array('method' => 'POST',
							'header' => 'Content-type: application/x-www-form-urlencoded'."\r\n".
										'User-Agent: Facebook API PHP5 Client 1.1 '."\r\n".
										'Content-length: ' . strlen($post_body),
							'content' => $post_body));
			  $contextid=stream_context_create($context);
			  $sock=fopen(RR_API_SERVER, 'r', false, $contextid);
			  if ($sock) {
				$result='';
				while (!feof($sock))
				  $result.=fgets($sock, 4096);

				fclose($sock);
			  }
	}
	
	$result = rr_handle_response($result);
	
	return $result;
}

function rr_post_body($method, $params) {
	$params['format'] = $format;
	$params['method'] = $method;
	$params['session_key'] = rr_get_session_key();
	$params['api_key'] = RR_CONNECT_API_KEY;
	$params['call_id'] = time();
	$params['format'] = 'JSON';
	
	if (!isset($params['v'])) {
		$params['v'] = '1.0';
	}
	
	$post_params = array();
	foreach ($params as $key => &$val) {
	  if (is_array($val)) $val = implode(',', $val);
	  $post_params[] = $key.'='.urlencode($val);
	}
	
	$post_params[] = 'sig='.rr_generate_sig($params);
	return implode('&', $post_params);
}

function rr_handle_response($result) {
	$array = json_decode($result);
	rr_check_response($array);
	
	return $array;
}

function rr_check_response($result) {
		$msg='';
		if($result['error_code'])
		{
			$msg.='<br>访问出错!<br>';
			if($result['error_code'][0])
			{
				$msg.='错误编号:'.$result['error_code'][0].'<br>';
			}
			if($result['error_msg'][0])
			{
				$msg.='错误信息:'.$result['error_msg'][0].'<br>';
			}
		}
		
		if($msg!='' && $result['error_code'][0]!='10702' && $result['error_code'][0]!='10600' ){
			echo $msg;
			exit;
		}
}


?>
