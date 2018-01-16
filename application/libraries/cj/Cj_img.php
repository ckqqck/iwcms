<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cj_img {
	public $_CI;
	public $unicode = "utf-8";
	public function __construct() {
		$this->_CI = & get_instance ();
	}
	// 获取文章中的附件
	function get_article_attach($content, $is_download_file, $page_url) {
		if (! $content)
			return;
		$content = str_replace ( array (
				"src=\r\n\"",
				"src=\r\"",
				"src=\n\"",
				"img\r\n",
				"img\r",
				"img\n" 
		), array (
				"src=\"",
				"src=\"",
				"src=\"",
				"img ",
				"img ",
				"img " 
		), $content ); // 有些特殊的
		
		preg_match_all ( "/\<img.*src.*=('|\"|)?(.*)(\\1)(.*)?\>/isU", $content, $image2, PREG_SET_ORDER );
		$temp = $aids = $existentimg = $attach_arr = array ();
		
		if (is_array ( $image2 ) && ! empty ( $image2 )) {
			foreach ( $image2 as $v ) {
				if ($v [0] && ! $v [1] && ! $v [2] && ! $v [3]) { // 匹配这样的<img src=http://3.pic.58control.cn/p1/big/n_s12172353208093464094.jpg />
					preg_match_all ( "/src=(.*)(\/>|\s)/isU", $v [0], $image_temp, PREG_SET_ORDER );
					if ($image_temp [0] [1]) {
						$v [2] = $image_temp [0] [1];
					} else { // 类似<img src=/pu/2014/8/21/3533_37514/1.gif>
						$v [2] = $v [4];
					}
				}
				$no_remote = 0;
				$ck = trim ( strip_tags ( $v [2] ) );
				$v [2] = trim ( strip_tags ( $v [2] ) );
				$v [2] = $this->_expandlinks ( $v [2], $page_url );
				
				if ($no_remote == 0) {
					$temp [] = array (
							'0' => $v [0],
							'1' => $v [2],
							'2' => $ck 
					);
				}
			}
		}
		if ($is_download_file == 1) {
			// $attach_arr = $this->get_attach_data($page_url, $content);
		}
		$attach_arr = $attach_arr ? $attach_arr : array ();
		$temp = $temp ? $temp : array ();
		$temp = array_merge ( $temp, $attach_arr );
		return $temp;
	}
	
	// 获取文章中的附件
	function get_img_attach($content, $is_download_file, $page_url) {
		if (! $content)
			return;
		$content = str_replace ( array (
				"src=\r\n\"",
				"src=\r\"",
				"src=\n\"",
				"img\r\n",
				"img\r",
				"img\n" 
		), array (
				"src=\"",
				"src=\"",
				"src=\"",
				"img ",
				"img ",
				"img " 
		), $content ); // 有些特殊的
		
		preg_match_all ( "/\<img.+src=('|\"|)?(.*)(\\1)(.*)?\>/isU", $content, $image2, PREG_SET_ORDER );
		$temp = $aids = $existentimg = $attach_arr = array ();
		
		if (is_array ( $image2 ) && ! empty ( $image2 )) {
			foreach ( $image2 as $v ) {
				if ($v [0] && ! $v [1] && ! $v [2] && ! $v [3]) { // 匹配这样的<img src=http://3.pic.58control.cn/p1/big/n_s12172353208093464094.jpg />
					preg_match_all ( "/src=(.*)(\/>|\s)/isU", $v [0], $image_temp, PREG_SET_ORDER );
					if ($image_temp [0] [1]) {
						$v [2] = $image_temp [0] [1];
					} else { // 类似<img src=/pu/2014/8/21/3533_37514/1.gif>
						$v [2] = $v [4];
					}
				}
				$no_remote = 0;
				$v [2] = trim ( strip_tags ( $v [2] ) );
				$v [2] = $this->_expandlinks ( $v [2], $page_url );
				// echo $v [2];
				if ($no_remote == 0) {
					$temp [] = array (
							'1' => $v [2] 
					);
				}
			}
		}
		if ($is_download_file == 1) {
			// $attach_arr = $this->get_attach_data($page_url, $content);
		}
		$attach_arr = $attach_arr ? $attach_arr : array ();
		$temp = $temp ? $temp : array ();
		$temp = array_merge ( $temp, $attach_arr );
		return $temp;
	}
	
	// 可以下载防盗链图片
	// 默认只能下载图片，如果想下载zip，args加上no_only_image=1
	function get_img_content($img_url, $snoopy = '', $args = array()) {
		$no_allow_ext = isset ( $args ['no_only_image'] ) == 1 ? array () : array (
				'htm',
				'html',
				'shtml' 
		);
		if (! function_exists ( 'fsockopen' ) && ! function_exists ( 'pfsockopen' ) || ! $snoopy) {
			$content = $this->_dfsockopen ( $img_url );
		} else {
			require_once APPPATH . "libraries/cj/Snoopy.class.php";
			$snoopy = new Snoopy ();
			$snoopy->fetch ( $img_url );
			$content = $snoopy->results;
			$headers = $snoopy->headers;
			$key = array_search ( "Content-Encoding: gzip", $headers );
			if ($key)
				$content = gzdecode ( $content ); // gzip
			if ($snoopy->status == '403') {
				$snoopy->referer = '';
				$snoopy->fetch ( $img_url );
				$content = $snoopy->results;
				$headers = $snoopy->headers;
			}
			if ($snoopy->status == '404' || $snoopy->status == '403' || $snoopy->status == '400') {
				if (isset ( $args ['check'] ) && $args ['check'] != 2) { // 地址含有中文
				                                                         // 检测是否编码不一致
					foreach ( $headers as $k => $v ) {
						$v = strtoupper ( $v );
						if (strexists ( $v, 'CHARSET=' )) {
							$temp_arr = explode ( 'CHARSET=', $v );
							$charset = trim ( $temp_arr [1] );
							if (CHARSET != $charset) { // 编码不一样
								$_G ['cn_charset'] = $charset;
								$img_url = cnurl ( $img_url );
								$args ['check'] = 2;
								return $this->get_img_content ( $img_url, $snoopy, $args );
							}
							break;
						} else { // 如果获取不到编码
							$_G ['cn_charset'] = 'utf-8'; // 有些页面编码是gb2312，但却需要转换成utf-8格式的网址才能下载附件。这种只能靠猜了
							$img_url = $this->cnurl ( $img_url );
							$args ['check'] = 2;
							return $this->get_img_content ( $img_url, $snoopy, $args );
						}
					}
				}
				return FALSE;
			}
			if ($headers [0] == 'HTTP/1.1 400 Bad Request')
				return FALSE;
			foreach ( ( array ) $headers as $v ) {
				$v_arr = explode ( ':', $v );
				if (isset ( $v_arr [1] ) && $v_arr [1])
					$header_arr [strtolower ( $v_arr [0] )] = trim ( $v_arr [1] );
			}
			// pload('F:http');
			$info ['file_size'] = isset ( $header_arr ['content-length'] ) ? $header_arr ['content-length'] : strlen ( $content );
			$url_info = parse_url ( $img_url );
			$query_url = isset ( $url_info ['query'] ) ? $url_info ['query'] : $url_info ['path'];
			$info ['file_ext'] = addslashes ( strtolower ( substr ( strrchr ( $query_url, '.' ), 1, 10 ) ) );
			$info ['content'] = $content;
			
			if (isset ( $header_arr ['content-disposition'] ) && $header_arr ['content-disposition']) {
				$c_d = $header_arr ['content-disposition'];
				$info_arr = explode ( ';', $c_d );
				$file_arr = explode ( '=', $info_arr [1] );
				$arr [2] = preg_replace ( '(\'|\")', '', $file_arr [1] ); // 去掉引号
				$file_name = $info ['file_name'] = $this->str_iconv ( urldecode ( $arr [2] ) );
				if (trim ( $info_arr [0] ) == 'attachment' && trim ( $file_arr [0] ) == 'filename') {
					$info ['file_ext'] = addslashes ( strtolower ( substr ( strrchr ( $file_name, '.' ), 1, 10 ) ) );
				} else {
					$info ['file_ext'] = $info ['file_ext'] ? $info ['file_ext'] : addslashes ( strtolower ( substr ( strrchr ( $file_name, '.' ), 1, 10 ) ) );
				}
				if (empty ( $file_name )) {
					$patharr = explode ( '/', $img_url );
					$info ['file_name'] = trim ( $patharr [count ( $patharr ) - 1] );
				}
				$info ['content'] = $content;
				return $info;
			} else {
				if (in_array ( $info ['file_ext'], $no_allow_ext )) {
					return FALSE;
				}
				if (! $info ['file_ext']) {
					$content_type = array_flip ( $this->_GetContentType () );
					$header_arr ['content-type'] = strtolower ( str_replace ( ';', '', $header_arr ['content-type'] ) );
					$file_content_type = explode ( ' ', $header_arr ['content-type'] );
					$info ['file_ext'] = $content_type [$file_content_type [0]];
					// 基于文件头获取扩展名
					$info ['file_ext'] = $info ['file_ext'] && $header_arr ['content-type'] != 'application/octet-stream' ? $info ['file_ext'] : FileExt::get_fileext ( $content );
					if (! $info ['file_ext']) {
						if (strexists ( $info ['content'], 'torrent' )) { // 对于一些torrent类型的附件，又获取不到任何扩展名，只能这样
							$info ['file_ext'] = 'torrent';
						}
					}
					if (in_array ( $info ['file_ext'], $no_allow_ext )) {
						return FALSE;
					}
				}
			}
			if ($info ['file_ext']) {
				$ext_info = explode ( '/', $info ['file_ext'] );
				$image_ext_arr = array (
						'gif',
						'jpg',
						'jpeg',
						'png' 
				);
				if (count ( $ext_info ) > 1) { // 扩展名是 jpg/0这些
					foreach ( $ext_info as $v ) {
						$ext_key = array_search ( strtolower ( $v ), $image_ext_arr );
						if ($ext_key != FALSE) {
							$info ['file_ext'] = $image_ext_arr [$ext_key];
						}
					}
				}
				$patharr = explode ( '/', $img_url );
				$info ['file_name'] = trim ( $patharr [count ( $patharr ) - 1] );
				if (strlen ( $info ['file_name'] ) > 35) { // 如果文件名太长，而且都是字母，重新命名
					                                           // $info ['file_name'] = time () . '.' . $info ['file_ext'];
				}
			}
			$info ['content'] = $content;
			if (isset ( $ext ) && $ext == 'no_get')
				return $info;
		}
		$info ['content'] = $content;
		$info ['file_size'] = isset ( $info ['file_size'] ) ? $info ['file_size'] : strlen ( $content );
		return $info;
	}
	function cnurl($url) {
		return preg_replace ( array (
				'/\%3A/i',
				'/\%2F/i',
				'/\%3F/i',
				'/\%3D/i',
				'/\%26/i' 
		), array (
				':',
				'/',
				'?',
				'=',
				'&' 
		), rawurlencode ( $url ) ); // 对于有中文的地址来说，有必要这样处理
	}
	function pget_image_title($attributes) {
		$value_arr = array (
				'title' => '',
				'alt' => '' 
		);
		$value_spit_str = implode ( '|', array_keys ( $value_arr ) );
		preg_match_all ( '/(' . $value_spit_str . ')=(["\'])?([^\'" ].*?)(?(2)\2)/i', $attributes, $matches );
		if (is_array ( $matches [1] )) {
			foreach ( $matches [1] as $key => $attribute ) {
				$attribute = strtolower ( $attribute );
				$value_arr [$attribute] = $matches [3] [$key];
			}
		}
		return $value_arr ['title'] ? $value_arr ['title'] : $value_arr ['alt'];
	}
	function _expandlinks($links, $URI) {
		$links = trim ( $links );
		$URI = trim ( $URI );
		$links = html_entity_decode ( $links );
		preg_match ( "/^[^\?]+/", $URI, $match );
		$url_parse_arr = parse_url ( $URI );
		$check = strpos ( $links, "?" );
		if ($check == 0 && $check !== FALSE) {
			return $url_parse_arr ["scheme"] . "://" . $url_parse_arr ["host"] . '/' . $url_parse_arr ['path'] . $links;
		}
		$check = strpos ( $links, "../" );
		if ($check == 0 && $check !== FALSE) { // 相对路径
			$path = dirname ( $url_parse_arr ['path'] );
			$path_arr = explode ( '/', $path );
			array_shift ( $path_arr );
			$i = 0;
			while ( substr ( $links, 0, 3 ) == "../" ) {
				$links = substr ( $links, strlen ( $links ) - (strlen ( $links ) - 3), strlen ( $links ) - 3 );
				$i ++;
			}
			$temp_arr = array_slice ( $path_arr, 0, count ( $path_arr ) - $i );
			return $url_parse_arr ["scheme"] . "://" . $url_parse_arr ["host"] . '/' . ($temp_arr ? implode ( '/', $temp_arr ) . '/' : '') . $links;
		}
		$match = preg_replace ( "|/[^\/\.]+\.[^\/\.]+$|", "", $match [0] );
		$match = preg_replace ( "|/$|", "", $match );
		$match_part = parse_url ( $match );
		$port = isset ( $match_part ["port"] ) ? ':' . $match_part ["port"] : '';
		$match_root = $match_part ["scheme"] . "://" . $match_part ["host"] . $port;
		
		$search = array (
				"|^http://" . preg_quote ( $match_root ) . "|i",
				"|^(\/)|i",
				"|^(?!http://)(?!mailto:)|i",
				"|/\./|",
				"|/[^\/]+/\.\./|" 
		);
		
		$replace = array (
				"",
				$match_root . "/",
				$match . "/",
				"/",
				"/" 
		);
		$expandedLinks = preg_replace ( $search, $replace, $links );
		
		return $expandedLinks;
	}
	function filter_something($str, $find, $type = false) {
		if (! is_array ( $find )) {
			$find_arr = $this->format_wrap ( trim ( $find ) );
		} else {
			$find_arr = $find;
		}
		if (! $find_arr)
			return $type;
		$filterwords = implode ( "|", $find_arr );
		$filterwords = str_replace ( '(*)', '*', $filterwords );
		$filterwords = convertrule ( $filterwords );
		$filterwords = str_replace ( '\|', '|', $filterwords );
		if (preg_match ( "/(" . $filterwords . ")/i", $str, $match ) == 1) {
			return false;
		}
		return true;
	}
	function format_wrap($str, $exp_type = PHP_EOL) {
		if (! $str)
			return false;
		$arr = explode ( $exp_type, trim ( $str ) );
		$arr = array_map ( 'trim', $arr );
		$arr = array_filter ( $arr );
		return $arr;
	}
	function _dfsockopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE, $encodetype = 'URLENCODE', $allowcurl = TRUE, $position = 0, $files = array()) {
		$return = '';
		$matches = parse_url ( $url );
		$scheme = $matches ['scheme'];
		$host = $matches ['host'];
		$path = $matches ['path'] ? $matches ['path'] . (isset ( $matches ['query'] ) ? '?' . $matches ['query'] : '') : '/';
		$port = ! empty ( $matches ['port'] ) ? $matches ['port'] : ($scheme == 'http' ? '80' : '');
		$boundary = $encodetype == 'URLENCODE' ? '' : random ( 40 );
		
		if ($post) {
			if (! is_array ( $post )) {
				parse_str ( $post, $post );
			}
			_format_postkey ( $post, $postnew );
			$post = $postnew;
		}
		if (function_exists ( 'curl_init' ) && function_exists ( 'curl_exec' ) && $allowcurl) {
			$ch = curl_init ();
			$httpheader = array ();
			if ($ip) {
				$httpheader [] = "Host: " . $host;
			}
			if ($httpheader) {
				curl_setopt ( $ch, CURLOPT_HTTPHEADER, $httpheader );
			}
			curl_setopt ( $ch, CURLOPT_URL, $scheme . '://' . ($ip ? $ip : $host) . ($port ? ':' . $port : '') . $path );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
			curl_setopt ( $ch, CURLOPT_HEADER, 1 );
			if ($post) {
				curl_setopt ( $ch, CURLOPT_POST, 1 );
				if ($encodetype == 'URLENCODE') {
					curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
				} else {
					foreach ( $post as $k => $v ) {
						if (isset ( $files [$k] )) {
							$post [$k] = '@' . $files [$k];
						}
					}
					foreach ( $files as $k => $file ) {
						if (! isset ( $post [$k] ) && file_exists ( $file )) {
							$post [$k] = '@' . $file;
						}
					}
					curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
				}
			}
			if ($cookie) {
				curl_setopt ( $ch, CURLOPT_COOKIE, $cookie );
			}
			curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
			curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
			$data = curl_exec ( $ch );
			$status = curl_getinfo ( $ch );
			$errno = curl_errno ( $ch );
			curl_close ( $ch );
			if ($errno || $status ['http_code'] != 200) {
				return;
			} else {
				$GLOBALS ['filesockheader'] = substr ( $data, 0, $status ['header_size'] );
				$data = substr ( $data, $status ['header_size'] );
				return ! $limit ? $data : substr ( $data, 0, $limit );
			}
		}
		
		if ($post) {
			if ($encodetype == 'URLENCODE') {
				$data = http_build_query ( $post );
			} else {
				$data = '';
				foreach ( $post as $k => $v ) {
					$data .= "--$boundary\r\n";
					$data .= 'Content-Disposition: form-data; name="' . $k . '"' . (isset ( $files [$k] ) ? '; filename="' . basename ( $files [$k] ) . '"; Content-Type: application/octet-stream' : '') . "\r\n\r\n";
					$data .= $v . "\r\n";
				}
				foreach ( $files as $k => $file ) {
					if (! isset ( $post [$k] ) && file_exists ( $file )) {
						if ($fp = @fopen ( $file, 'r' )) {
							$v = fread ( $fp, filesize ( $file ) );
							fclose ( $fp );
							$data .= "--$boundary\r\n";
							$data .= 'Content-Disposition: form-data; name="' . $k . '"; filename="' . basename ( $file ) . '"; Content-Type: application/octet-stream' . "\r\n\r\n";
							$data .= $v . "\r\n";
						}
					}
				}
				$data .= "--$boundary\r\n";
			}
			$out = "POST $path HTTP/1.0\r\n";
			$header = "Accept: */*\r\n";
			$header .= "Accept-Language: zh-cn\r\n";
			$header .= $encodetype == 'URLENCODE' ? "Content-Type: application/x-www-form-urlencoded\r\n" : "Content-Type: multipart/form-data; boundary=$boundary\r\n";
			$header .= 'Content-Length: ' . strlen ( $data ) . "\r\n";
			$header .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$header .= "Host: $host:$port\r\n";
			$header .= "Connection: Close\r\n";
			$header .= "Cache-Control: no-cache\r\n";
			$header .= "Cookie: $cookie\r\n\r\n";
			$out .= $header;
			$out .= $data;
		} else {
			$out = "GET $path HTTP/1.0\r\n";
			$header = "Accept: */*\r\n";
			$header .= "Accept-Language: zh-cn\r\n";
			$header .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$header .= "Host: $host:$port\r\n";
			$header .= "Connection: Close\r\n";
			$header .= "Cookie: $cookie\r\n\r\n";
			$out .= $header;
		}
		
		$fpflag = 0;
		if (! $fp = @fsocketopen ( ($ip ? $ip : $host), $port, $errno, $errstr, $timeout )) {
			$context = array (
					'http' => array (
							'method' => $post ? 'POST' : 'GET',
							'header' => $header,
							'content' => $post,
							'timeout' => $timeout 
					) 
			);
			$context = stream_context_create ( $context );
			$fp = @fopen ( $scheme . '://' . ($ip ? $ip : $host) . ':' . $port . $path, 'b', false, $context );
			$fpflag = 1;
		}
		
		if (! $fp) {
			return '';
		} else {
			stream_set_blocking ( $fp, $block );
			stream_set_timeout ( $fp, $timeout );
			@fwrite ( $fp, $out );
			$status = stream_get_meta_data ( $fp );
			if (! $status ['timed_out']) {
				while ( ! feof ( $fp ) && ! $fpflag ) {
					$header = @fgets ( $fp );
					$headers .= $header;
					if ($header && ($header == "\r\n" || $header == "\n")) {
						break;
					}
				}
				$GLOBALS ['filesockheader'] = $headers;
				
				if ($position) {
					for($i = 0; $i < $position; $i ++) {
						$char = fgetc ( $fp );
						if ($char == "\n" && $oldchar != "\r") {
							$i ++;
						}
						$oldchar = $char;
					}
				}
				
				if ($limit) {
					$return = stream_get_contents ( $fp, $limit );
				} else {
					$return = stream_get_contents ( $fp );
				}
			}
			@fclose ( $fp );
			return $return;
		}
	}
	function str_iconv($str) {
		if (! $str)
			return false;
		$charset = strtoupper ( $this->get_charset ( $str ) );
		if ($charset == 'UTF-8') {
			return $str;
		} else if ($charset == 'BIG5') {
			return $this->big52gb ( $str );
		} else if ($charset == 'GBK') {
			$str = $this->piconv ( $str, 'GB2312', 'UTF-8' );
		} else if ($charset == 'GB2312') {
			$str = $this->piconv ( $str, 'GB2312', 'UTF-8' );
		}
		return $str;
	}
	function gb2big5($Text) {
		$fp = fopen ( APPPATH . "libraries/cj/gb-big5.table", "r" );
		$max = strlen ( $Text ) - 1;
		for($i = 0; $i < $max; $i ++) {
			$h = ord ( $Text [$i] );
			if ($h >= 160) {
				$l = ord ( $Text [$i + 1] );
				if ($h == 161 && $l == 64) {
					$gb = " ";
				} else {
					fseek ( $fp, ($h - 160) * 510 + ($l - 1) * 2 );
					$gb = fread ( $fp, 2 );
				}
				$Text [$i] = $gb [0];
				$Text [$i + 1] = $gb [1];
				$i ++;
			}
		}
		fclose ( $fp );
		return $Text;
	}
	function big52gb($Text) {
		$fp = fopen ( APPPATH . "libraries/cj/big5-gb.table", "r" );
		$max = strlen ( $Text ) - 1;
		for($i = 0; $i < $max; $i ++) {
			$h = ord ( $Text [$i] );
			if ($h >= 160) {
				$l = ord ( $Text [$i + 1] );
				if ($h == 161 && $l == 64) {
					$gb = " ";
				} else {
					fseek ( $fp, ($h - 160) * 510 + ($l - 1) * 2 );
					$gb = fread ( $fp, 2 );
				}
				$Text [$i] = $gb [0];
				$Text [$i + 1] = $gb [1];
				$i ++;
			}
		}
		fclose ( $fp );
		return $Text;
	}
	function piconv($str, $in, $out) {
		$is_win = strtoupper ( substr ( PHP_OS, 0, 3 ) ) == 'WIN' ? TRUE : FALSE;
		if ($is_win)
			return $this->diconv ( $str, $in, $out );
		if (function_exists ( 'mb_convert_encoding' )) {
			$str = $in == 'UTF-8' ? str_replace ( "\xC2\xA0", ' ', $str ) : $str;
			$str = mb_convert_encoding ( $str, $out, $in );
		} else {
			$str = $this->diconv ( $str, $in, $out );
		}
		return $str;
	}
	function diconv($str, $in_charset, $out_charset = CHARSET, $ForceTable = FALSE) {
		global $_G;
		
		$in_charset = strtoupper ( $in_charset );
		$out_charset = strtoupper ( $out_charset );
		
		if (empty ( $str ) || $in_charset == $out_charset) {
			return $str;
		}
		
		$out = '';
		
		if (! $ForceTable) {
			if (function_exists ( 'iconv' )) {
				$out = iconv ( $in_charset, $out_charset . '//IGNORE', $str );
			} elseif (function_exists ( 'mb_convert_encoding' )) {
				$out = mb_convert_encoding ( $str, $out_charset, $in_charset );
			}
		}
		/*
		 * if($out == '') {
		 * $chinese = new Chinese($in_charset, $out_charset, true);
		 * $out = $chinese->Convert($str);
		 * }
		 */
		return $out;
	}
	function dstripslashes($string) {
		if (empty ( $string ))
			return $string;
		if (is_array ( $string )) {
			foreach ( $string as $key => $val ) {
				$string [$key] = $this->dstripslashes ( $val );
			}
		} else {
			$string = stripslashes ( $string );
		}
		return $string;
	}
	/**
	 * 转义正则表达式字符串
	 */
	function convertrule($rule) {
		$rule = $this->dstripslashes ( $rule );
		$rule = preg_quote ( $rule, "/" ); // 转义正则表达式
		$rule = str_replace ( '\*', '.*?', $rule );
		$rule = str_replace ( "\(.*?\)", '(.*?)', $rule );
		
		// $rule = str_replace('\|', '|', $rule);
		
		return $rule;
	}
	// 某组东西替换某个东西
	function replace_something($str, $replace_str, $test = 0, $limit = -1) {
		if (! $str || ! $replace_str)
			return false;
		if (! is_array ( $replace_str )) {
			$replace_arr = $this->format_wrap ( trim ( $replace_str ) );
		} else {
			$replace_arr = $replace_str;
		}
		if ($replace_arr) {
			foreach ( $replace_arr as $k => $v ) {
				$rules_arr = explode ( '@@', trim ( $v ) );
				$rules_arr [0] = $this->convertrule ( $rules_arr [0] );
				$rules_arr [0] = str_replace ( "CT_TR", "\*", $rules_arr [0] );
				$rules_arr [0] = str_replace ( "'", "\'", $rules_arr [0] );
				$rules_arr [0] = str_replace ( "\"", "\\\"", $rules_arr [0] );
				// $rules_arr[0] = str_replace("|","|", $rules_arr[0]);
				$rules_arr [1] = str_replace ( "'", "\'", $rules_arr [1] );
				$rules_arr [0] = str_replace ( '\[list\]', '\s*(.+?)\s*', $rules_arr [0] ); // 解析为正则表达式
				$search_arr [$k] = "'" . $rules_arr [0] . "'si";
				if ($test != 1) {
					$replace_arr [$k] = $rules_arr [1];
				} else {
					preg_match_all ( "/$rules_arr[0]/is", $str, $arr );
					if (is_array ( $arr [0] )) {
						foreach ( $arr [0] as $k1 => $v1 ) {
							if ($v1) {
								$test_search_arr [$k1] = $v1;
								if (! $rules_arr [1]) {
									$str = str_replace ( $v1, '<del>' . $v1 . '</del>', $str );
								} else {
									$str = str_replace ( $v1, '<ins>' . $rules_arr [1] . '</ins>', $str );
								}
							}
						}
					}
				}
			}
		}
		if ($test != 1)
			$str = preg_replace ( $search_arr, $replace_arr, $str, $limit );
		return $str;
	}
	function is_utf8($string) {
		if (preg_match ( "/^([" . chr ( 228 ) . "-" . chr ( 233 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}){1}/", $string ) == true || preg_match ( "/([" . chr ( 228 ) . "-" . chr ( 233 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}){1}$/", $string ) == true || preg_match ( "/([" . chr ( 228 ) . "-" . chr ( 233 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}){2,}/", $string ) == true) {
			return true;
		} else {
			return false;
		}
	}
	function get_charset($web_str) {
		preg_match ( "/<meta[^>]+charset=\"?'?([^'\"\>]+)\"?[^>]+\>/is", $web_str, $arr );
		// if($arr[1]) return $arr[1];
		$arr [1] = strtoupper ( $arr [1] );
		if ($arr [1] == 'GBK' || $arr [1] == 'BIG5')
			return $arr [1];
		$charset = $this->is_utf8 ( $web_str ) ? 'UTF-8' : 'GB2312';
		if ($arr [1] && $arr [1] == $charset)
			return $arr [1];
		return $charset;
	}
	function load_cache($key, $clearStaticKey = FALSE) {
		require_once APPPATH . 'libraries/cj/cache.class.php';
		$cache = new serialize_cache ();
		return $cache->get ( $key, $clearStaticKey );
	}
	function cache_data($key, $value, $ttl = 3600) {
		if ($ttl < 0 || $ttl == 0)
			return FALSE;
		require_once APPPATH . 'libraries/cj/cache.class.php';
		$cache = new serialize_cache ();
		$value = is_array ( $value ) ? $value : rawurlencode ( $value );
		$cache->set ( $key, $value, $ttl );
	}
	function pis_image_ext($ext) {
		$imgext = array (
				'jpg',
				'jpeg',
				'gif',
				'png',
				'bmp' 
		);
		return in_array ( $ext, $imgext ) ? 1 : 0;
	}
	function createFolder($path) {
		if (! file_exists ( $path )) {
			$this->createFolder ( dirname ( $path ) );
			if (! mkdir ( $path, 0777, true )) {
				return false;
			}
		}
	}
	function _format_postkey($post, &$result, $key = '') {
		foreach ( $post as $k => $v ) {
			$_k = $key ? $key . '[' . $k . ']' : $k;
			if (is_array ( $v )) {
				_format_postkey ( $v, $result, $_k );
			} else {
				$result [$_k] = $v;
			}
		}
	}
	private function _GetContentType() {
		return array (
				'ai' => 'application/postscript',
				'aif' => 'audio/x-aiff',
				'aifc' => 'audio/x-aiff',
				'aiff' => 'audio/x-aiff',
				'asc' => 'application/pgp', // changed by skwashd - was text/plain
				'asf' => 'video/x-ms-asf',
				'asx' => 'video/x-ms-asf',
				'au' => 'audio/basic',
				'avi' => 'video/x-msvideo',
				'bcpio' => 'application/x-bcpio',
				'bin' => 'application/octet-stream',
				'bmp' => 'image/bmp',
				'c' => 'text/plain', // or 'text/x-csrc', //added by skwashd
				'cc' => 'text/plain', // or 'text/x-c++src', //added by skwashd
				'cs' => 'text/plain', // added by skwashd - for C# src
				'cpp' => 'text/x-c++src', // added by skwashd
				'cxx' => 'text/x-c++src', // added by skwashd
				'cdf' => 'application/x-netcdf',
				'class' => 'application/octet-stream', // secure but application/java-class is correct
				'com' => 'application/octet-stream', // added by skwashd
				'cpio' => 'application/x-cpio',
				'cpt' => 'application/mac-compactpro',
				'csh' => 'application/x-csh',
				'css' => 'text/css',
				'csv' => 'text/comma-separated-values', // added by skwashd
				'dcr' => 'application/x-director',
				'diff' => 'text/diff',
				'dir' => 'application/x-director',
				'dll' => 'application/octet-stream',
				'dms' => 'application/octet-stream',
				'doc' => 'application/msword',
				'dot' => 'application/msword', // added by skwashd
				'dvi' => 'application/x-dvi',
				'dxr' => 'application/x-director',
				'eps' => 'application/postscript',
				'etx' => 'text/x-setext',
				'exe' => 'application/octet-stream',
				'ez' => 'application/andrew-inset',
				'gif' => 'image/gif',
				'gtar' => 'application/x-gtar',
				'gz' => 'application/x-gzip',
				'h' => 'text/plain', // or 'text/x-chdr',//added by skwashd
				'h++' => 'text/plain', // or 'text/x-c++hdr', //added by skwashd
				'hh' => 'text/plain', // or 'text/x-c++hdr', //added by skwashd
				'hpp' => 'text/plain', // or 'text/x-c++hdr', //added by skwashd
				'hxx' => 'text/plain', // or 'text/x-c++hdr', //added by skwashd
				'hdf' => 'application/x-hdf',
				'hqx' => 'application/mac-binhex40',
				'htm' => 'text/html',
				'html' => 'text/html',
				'ice' => 'x-conference/x-cooltalk',
				'ics' => 'text/calendar',
				'ief' => 'image/ief',
				'ifb' => 'text/calendar',
				'iges' => 'model/iges',
				'igs' => 'model/iges',
				'jar' => 'application/x-jar', // added by skwashd - alternative mime type
				'java' => 'text/x-java-source', // added by skwashd
				'jpe' => 'image/jpeg',
				'jpeg' => 'image/jpeg',
				'jpg' => 'image/jpeg',
				'jpg' => 'image/jpg', // ����
				'js' => 'application/x-javascript',
				'kar' => 'audio/midi',
				'latex' => 'application/x-latex',
				'lha' => 'application/octet-stream',
				'log' => 'text/plain',
				'lzh' => 'application/octet-stream',
				'm3u' => 'audio/x-mpegurl',
				'man' => 'application/x-troff-man',
				'me' => 'application/x-troff-me',
				'mesh' => 'model/mesh',
				'mid' => 'audio/midi',
				'midi' => 'audio/midi',
				'mif' => 'application/vnd.mif',
				'mov' => 'video/quicktime',
				'movie' => 'video/x-sgi-movie',
				'mp2' => 'audio/mpeg',
				'mp3' => 'audio/mpeg',
				'mpe' => 'video/mpeg',
				'mpeg' => 'video/mpeg',
				'mpg' => 'video/mpeg',
				'mpga' => 'audio/mpeg',
				'ms' => 'application/x-troff-ms',
				'msh' => 'model/mesh',
				'mxu' => 'video/vnd.mpegurl',
				'nc' => 'application/x-netcdf',
				'oda' => 'application/oda',
				'patch' => 'text/diff',
				'pbm' => 'image/x-portable-bitmap',
				'pdb' => 'chemical/x-pdb',
				'pdf' => 'application/pdf',
				'pgm' => 'image/x-portable-graymap',
				'pgn' => 'application/x-chess-pgn',
				'pgp' => 'application/pgp', // added by skwashd
				'php' => 'application/x-httpd-php',
				'php3' => 'application/x-httpd-php3',
				'pl' => 'application/x-perl',
				'pm' => 'application/x-perl',
				'png' => 'image/png',
				'pnm' => 'image/x-portable-anymap',
				'po' => 'text/plain',
				'ppm' => 'image/x-portable-pixmap',
				'ppt' => 'application/vnd.ms-powerpoint',
				'ps' => 'application/postscript',
				'qt' => 'video/quicktime',
				'ra' => 'audio/x-realaudio',
				'rar' => 'application/octet-stream',
				'ram' => 'audio/x-pn-realaudio',
				'ras' => 'image/x-cmu-raster',
				'rgb' => 'image/x-rgb',
				'rm' => 'audio/x-pn-realaudio',
				'roff' => 'application/x-troff',
				'rpm' => 'audio/x-pn-realaudio-plugin',
				'rtf' => 'text/rtf',
				'rtx' => 'text/richtext',
				'sgm' => 'text/sgml',
				'sgml' => 'text/sgml',
				'sh' => 'application/x-sh',
				'shar' => 'application/x-shar',
				'shtml' => 'text/html',
				'silo' => 'model/mesh',
				'sit' => 'application/x-stuffit',
				'skd' => 'application/x-koan',
				'skm' => 'application/x-koan',
				'skp' => 'application/x-koan',
				'skt' => 'application/x-koan',
				'smi' => 'application/smil',
				'smil' => 'application/smil',
				'snd' => 'audio/basic',
				'so' => 'application/octet-stream',
				'spl' => 'application/x-futuresplash',
				'src' => 'application/x-wais-source',
				'stc' => 'application/vnd.sun.xml.calc.template',
				'std' => 'application/vnd.sun.xml.draw.template',
				'sti' => 'application/vnd.sun.xml.impress.template',
				'stw' => 'application/vnd.sun.xml.writer.template',
				'sv4cpio' => 'application/x-sv4cpio',
				'sv4crc' => 'application/x-sv4crc',
				'swf' => 'application/x-shockwave-flash',
				'sxc' => 'application/vnd.sun.xml.calc',
				'sxd' => 'application/vnd.sun.xml.draw',
				'sxg' => 'application/vnd.sun.xml.writer.global',
				'sxi' => 'application/vnd.sun.xml.impress',
				'sxm' => 'application/vnd.sun.xml.math',
				'sxw' => 'application/vnd.sun.xml.writer',
				't' => 'application/x-troff',
				'tar' => 'application/x-tar',
				'tcl' => 'application/x-tcl',
				'tex' => 'application/x-tex',
				'texi' => 'application/x-texinfo',
				'texinfo' => 'application/x-texinfo',
				'tgz' => 'application/x-gtar',
				'tif' => 'image/tiff',
				'tiff' => 'image/tiff',
				'tr' => 'application/x-troff',
				'tsv' => 'text/tab-separated-values',
				'txt' => 'text/plain',
				'ustar' => 'application/x-ustar',
				'vbs' => 'text/plain', // added by skwashd - for obvious reasons
				'vcd' => 'application/x-cdlink',
				'vcf' => 'text/x-vcard',
				'vcs' => 'text/calendar',
				'vfb' => 'text/calendar',
				'vrml' => 'model/vrml',
				'vsd' => 'application/vnd.visio',
				'wav' => 'audio/x-wav',
				'wax' => 'audio/x-ms-wax',
				'wbmp' => 'image/vnd.wap.wbmp',
				'wbxml' => 'application/vnd.wap.wbxml',
				'wm' => 'video/x-ms-wm',
				'wma' => 'audio/x-ms-wma',
				'wmd' => 'application/x-ms-wmd',
				'wml' => 'text/vnd.wap.wml',
				'wmlc' => 'application/vnd.wap.wmlc',
				'wmls' => 'text/vnd.wap.wmlscript',
				'wmlsc' => 'application/vnd.wap.wmlscriptc',
				'wmv' => 'video/x-ms-wmv',
				'wmx' => 'video/x-ms-wmx',
				'wmz' => 'application/x-ms-wmz',
				'wrl' => 'model/vrml',
				'wvx' => 'video/x-ms-wvx',
				'xbm' => 'image/x-xbitmap',
				'xht' => 'application/xhtml+xml',
				'xhtml' => 'application/xhtml+xml',
				'xls' => 'application/vnd.ms-excel',
				'xlt' => 'application/vnd.ms-excel',
				'xml' => 'application/xml',
				'xpm' => 'image/x-xpixmap',
				'xsl' => 'text/xml',
				'xwd' => 'image/x-xwindowdump',
				'xyz' => 'chemical/x-xyz',
				'z' => 'application/x-compress',
				'zip' => 'application/zip' 
		);
	}
}