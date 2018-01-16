<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
if (! function_exists ( 'random' )) {
	function getgpc($k, $type='GP') {
		$type = strtoupper($type);
		switch($type) {
			case 'G': $var = &$_GET; break;
			case 'P': $var = &$_POST; break;
			case 'C': $var = &$_COOKIE; break;
			default:
				if(isset($_GET[$k])) {
					$var = &$_GET;
				} else {
					$var = &$_POST;
				}
				break;
		}
	
		return isset($var[$k]) ? $var[$k] : NULL;
	
	}
}
if (! function_exists ( 'hidtel' )) {
	function hidtel($phone){
		$IsWhat = preg_match('/(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)/i',$phone); //固定电话
		if($IsWhat == 1){
			return preg_replace('/(0[0-9]{2,3}[\-]?[2-9])[0-9]{3,4}([0-9]{3}[\-]?[0-9]?)/i','$1****$2',$phone);
		}else{
			return  preg_replace('/(1[3578]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2',$phone);
		}
	}
}
if (! function_exists ( 'random' )) {
	function random($length, $numeric = 0) {
		$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
		if($numeric) {
			$hash = '';
		} else {
			$hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
			$length--;
		}
		$max = strlen($seed) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $seed{mt_rand(0, $max)};
		}
		return $hash;
	}
}
if (! function_exists ( 'generate_key' )) {
	function generate_key() {
		$random = random(32);
		$info = md5($_SERVER['SERVER_SOFTWARE'].$_SERVER['SERVER_NAME'].$_SERVER['SERVER_ADDR'].$_SERVER['SERVER_PORT'].$_SERVER['HTTP_USER_AGENT'].time());
		$return = '';
		for($i=0; $i<64; $i++) {
			$p = intval($i/2);
			$return[$i] = $i % 2 ? $random[$p] : $info[$p];
		}
		return implode('', $return);
	}
}
if (! function_exists ( 'formhash' )) {
	function formhash() {
			return substr(md5(substr(time(), 0, -4).generate_key()), 16);
	}
}
/**
 * 发起一个HTTP(S)请求，并返回json格式的响应数据
 * 
 * @param
 *        	array 错误信息 array($errorCode, $errorMessage)
 * @param
 *        	string 请求Url
 * @param
 *        	array 请求参数
 * @param
 *        	string 请求类型(GET|POST)
 * @param
 *        	int 超时时间
 * @param
 *        	array 额外配置
 *        	
 * @return array
 */
if (! function_exists ( 'curl_request_json' )) {
	function curl_request_json(&$error, $url, $param = array(), $method = 'GET', $timeout = 10, $exOptions = null) {
		$error = false;
		$responseText = curl_request_text ( $error, $url, $param, $method, $timeout, $exOptions );
		$response = null;
		if ($error == false && $responseText > 0) {
			$response = json_decode ( $responseText, true );
			
			if ($response == null) {
				$error = array (
						'errorCode' => - 1,
						'errorMessage' => 'json decode fail',
						'responseText' => $responseText 
				);
				// 将错误信息记录日志文件里
				$logText = "json decode fail : $url";
				if (! empty ( $param )) {
					$logText .= ", param=" . json_encode ( $param );
				}
				$logText .= ", responseText=$responseText";
				file_put_contents ( FCPATH . "/data/error.log", $logText );
			}
		}
		return $response;
	}
}
/**
 * 发起一个HTTP(S)请求，并返回响应文本
 * 
 * @param
 *        	array 错误信息 array($errorCode, $errorMessage)
 * @param
 *        	string 请求Url
 * @param
 *        	array 请求参数
 * @param
 *        	string 请求类型(GET|POST)
 * @param
 *        	int 超时时间
 * @param
 *        	array 额外配置
 *        	
 * @return string
 */
if (! function_exists ( 'curl_request_text' )) {
	function curl_request_text(&$error, $url, $param = array(), $method = 'GET', $timeout = 15, $exOptions = NULL) {
		
		// 判断是否开启了curl扩展
		if (! function_exists ( 'curl_init' ))
			exit ( 'please open this curl extension' );
			
			// 将请求方法变大写
		$method = strtoupper ( $method );
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $ch, CURLOPT_HEADER, false );
		if (isset ( $_SERVER ['HTTP_USER_AGENT'] ))
			curl_setopt ( $ch, CURLOPT_USERAGENT, $_SERVER ['HTTP_USER_AGENT'] );
		if (isset ( $_SERVER ['HTTP_REFERER'] ))
			curl_setopt ( $ch, CURLOPT_REFERER, $_SERVER ['HTTP_REFERER'] );
		curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
		switch ($method) {
			case 'POST' :
				curl_setopt ( $ch, CURLOPT_POST, true );
				if (! empty ( $param )) {
					curl_setopt ( $ch, CURLOPT_POSTFIELDS, (is_array ( $param )) ? http_build_query ( $param ) : $param );
				}
				break;
			
			case 'GET' :
			case 'DELETE' :
				if ($method == 'DELETE') {
					curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'DELETE' );
				}
				if (! empty ( $param )) {
					$url = $url . (strpos ( $url, '?' ) ? '&' : '?') . (is_array ( $param ) ? http_build_query ( $param ) : $param);
				}
				break;
		}
		curl_setopt ( $ch, CURLINFO_HEADER_OUT, true );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		// 设置额外配置
		if (! empty ( $exOptions )) {
			foreach ( $exOptions as $k => $v ) {
				curl_setopt ( $ch, $k, $v );
			}
		}
		$response = curl_exec ( $ch );
		
		$error = false;
		// 看是否有报错
		$errorCode = curl_errno ( $ch );
		if ($errorCode) {
			$errorMessage = curl_error ( $ch );
			$error = array (
					'errorCode' => $errorCode,
					'errorMessage' => $errorMessage 
			);
			// 将报错写入日志文件里
			$logText = "$method $url: [$errorCode]$errorMessage";
			if (! empty ( $param ))
				$logText .= ",$param" . json_encode ( $param );
			file_put_contents (FCPATH .  '/data/error.log', $logText );
		}
		
		curl_close ( $ch );
		
		return $response;
	}
}

//php 批量过滤post,get敏感数据

if (! function_exists ( 'lib_replace_end_tag' )) {
 function lib_replace_end_tag($str)
	{
		if (empty($str)) return false;
		$str = htmlspecialchars($str);
		$str = str_replace( '/', "", $str);
		$str = str_replace("\\", "", $str);
		$str = str_replace(">", "", $str);
		$str = str_replace("<", "", $str);
		$str = str_replace("<SCRIPT>", "", $str);
		$str = str_replace("</SCRIPT>", "", $str);
		$str = str_replace("<script>", "", $str);
		$str = str_replace("</script>", "", $str);
		$str=str_replace("select","select",$str);
		$str=str_replace("join","join",$str);
		$str=str_replace("union","union",$str);
		$str=str_replace("where","where",$str);
		$str=str_replace("insert","insert",$str);
		$str=str_replace("delete","delete",$str);
		$str=str_replace("update","update",$str);
		$str=str_replace("like","like",$str);
		$str=str_replace("drop","drop",$str);
		$str=str_replace("create","create",$str);
		$str=str_replace("modify","modify",$str);
		$str=str_replace("rename","rename",$str);
		$str=str_replace("alter","alter",$str);
		$str=str_replace("cas","cast",$str);
		$str=str_replace("&","&",$str);
		$str=str_replace(">",">",$str);
		$str=str_replace("<","<",$str);
		$str=str_replace("    ",chr(9),$str);
		$str=str_replace("&",chr(34),$str);
		$str=str_replace("'",chr(39),$str);
		$str=str_replace("<br />",chr(13),$str);
		$str=str_replace("''","'",$str);
		$str=str_replace("css","'",$str);
		$str=str_replace("CSS","'",$str);
		return $str;
 
	}
}
/**
 * 人性化时间
 *
 * @access public
 * @param string $from
 *        	起始时间
 * @param string $now
 *        	终止时间
 * @return string
 */
// ------------------------------------------------------------------------
if (! function_exists ( 'clientIP' )) {
	function clientIP() {
		$cIP = getenv ( 'REMOTE_ADDR' );
		$cIP1 = getenv ( 'HTTP_X_FORWARDED_FOR' );
		$cIP2 = getenv ( 'HTTP_CLIENT_IP' );
		$cIP1 ? $cIP = $cIP1 : null;
		$cIP2 ? $cIP = $cIP2 : null;
		return $cIP;
	}
}
if (! function_exists ( 'ajaxReturn' )) {
	function ajaxReturn($data, $info = '', $status = 0, $type = 'JSON') {
		$result = array ();
		$result ['status'] = $status;
		$result ['info'] = $info;
		$result ['data'] = $data;
		if (strtoupper ( $type ) == 'JSON') {
			// 返回JSON数据格式到客户端 包含状态信息
			header ( 'Content-Type:text/html; charset=utf-8' );
			exit ( json_encode ( $result ) );
		} elseif (strtoupper ( $type ) == 'XML') {
			// 返回xml格式数据
			header ( 'Content-Type:text/xml; charset=utf-8' );
			exit ( xml_encode ( $result ) );
		} elseif (strtoupper ( $type ) == 'EVAL') {
			// 返回可执行的js脚本
			header ( 'Content-Type:text/html; charset=utf-8' );
			exit ( $data );
		} else {
			// 返回JSON数据格式到客户端 包含状态信息
			header ( 'Content-Type:text/html; charset=utf-8' );
			exit ( json_encode ( $result ) );
		}
	}
}
if (! function_exists ( 'imgurl' )) {
	function imgurl($imgurl) {
		if (! preg_match ( "/^(http|ftp):/", $imgurl )) {
			return base_url () . $imgurl;
		} else {
			return $imgurl;
		}
	}
}
if (! function_exists ( 'get_htmldom_obj' )) {
	function get_htmldom_obj($str) {
		if (! $str)
			return $str;
		require_once APPPATH . "libraries/cj/simple_html_dom.php";
		$html = str_get_html ( $str, true, true, DEFAULT_TARGET_CHARSET, FALSE );
		if (! $html)
			return false;
		return $html;
	}
}
if (! function_exists ( 'out_xml' )) {
	function out_xml($string) {
		@ob_end_clean ();
		@header ( "Expires: -1" );
		@header ( "Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE );
		@header ( "Pragma: no-cache" );
		@header ( "Content-type: text/xml; charset=UTF-8" );
		echo '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";
		echo '<root><![CDATA[' . $string . ']]></root>';
	}
}
if (! function_exists ( 'dateWord' )) {
	function dateWord($from, $now) {
		// fix issue 3#6 by saturn, solution by zycbob
		
		/**
		 * 如果不是同一年
		 */
		if (idate ( 'Y', $now ) != idate ( 'Y', $from )) {
			return date ( 'Y年m月d日', $from );
		}
		
		/**
		 * 以下操作同一年的日期
		 */
		$seconds = $now - $from;
		$days = idate ( 'z', $now ) - idate ( 'z', $from );
		
		/**
		 * 如果是同一天
		 */
		if ($days == 0) {
			/**
			 * 如果是一小时内
			 */
			if ($seconds < 3600) {
				/**
				 * 如果是一分钟内
				 */
				if ($seconds < 60) {
					if (3 > $seconds) {
						return '刚刚';
					} else {
						return sprintf ( '%d秒前', $seconds );
					}
				}
				
				return sprintf ( '%d分钟前', intval ( $seconds / 60 ) );
			}
			
			return sprintf ( '%d小时前', idate ( 'H', $now ) - idate ( 'H', $from ) );
		}
		
		/**
		 * 如果是昨天
		 */
		if ($days == 1) {
			return sprintf ( '昨天 %s', date ( 'H:i', $from ) );
		}
		
		/**
		 * 如果是前天
		 */
		if ($days == 2) {
			return sprintf ( '前天 %s', date ( 'H:i', $from ) );
		}
		
		/**
		 * 如果是7天内
		 */
		if ($days < 7) {
			return sprintf ( '%d天前', $days );
		}
		
		/**
		 * 超过一周
		 */
		return date ( 'n月j日', $from );
	}
}

/**
 * 宽字符串截字函数
 *
 * @access public
 * @param string $str
 *        	需要截取的字符串
 * @param integer $start
 *        	开始截取的位置
 * @param integer $length
 *        	需要截取的长度
 * @param string $trim
 *        	截取后的截断标示符
 * @param string $charset
 *        	字符串编码
 * @return string
 */
if (! function_exists ( 'subStrs' )) {
	function subStrs($string, $strlen = 20, $etc = '...', $keep_first_style = false) {
		$strlen = $strlen * 3;
		$string = trim ( $string );
		if (strlen ( $string ) <= $strlen) {
			return $string;
		}
		$str = strip_tags ( $string );
		$j = 0;
		for($i = 0; $i < $strlen; $i ++) {
			if (ord ( substr ( $str, $i, 1 ) ) > 0xa0) {
				$i += 2;
				$j += 3;
			} else {
				$j ++;
			}
		}
		$rstr = substr ( $str, 0, $j );
		if (strlen ( $str ) > $strlen) {
			$rstr .= $etc;
		}
		if ($keep_first_style == true && ereg ( '^<(.*)>$', $string )) {
			if (strlen ( $str ) <= $strlen) {
				return $string;
			}
			$start_pos = strpos ( $string, substr ( $str, 0, 4 ) );
			$end_pos = strpos ( $string, substr ( $str, - 4 ) );
			$end_pos = $end_pos + 4;
			$rstr = substr ( $string, 0, $start_pos ) . $rstr . substr ( $string, $end_pos, strlen ( $string ) );
		}
		return $rstr;
	}
}
/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */