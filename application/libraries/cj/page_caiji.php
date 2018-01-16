<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class CI_Page_caiji {
	public $data = array ();
	public $dom;
	public $_CI;
	function __construct() {
		$this->_CI = & get_instance ();
	}
	function get_content($docment, $rules_info, $url = "") {
		$docments = $this->snoopy ( $url );
		$content_page_arr = $this->_page_all_CJ ( $docments, $rules_info, $url );
		// print_r($content_page_arr);
		if ($content_page_arr) {
			$args = array (
					'oldurl' => array (),
					'content_arr' => array (),
					'content_page_arr' => $content_page_arr,
					'page_hash' => array (),
					'url' => $url 
			);
			$datas = $this->page_get_content ( $docments, $args, $rules_info );
			
			foreach ( ( array ) $datas as $k => $v ) {
				$content_arr [] = $v ['content'] . "<strong>##########NextPage##########</strong>";
			}
			$data ['content'] = implode ( '', $content_arr );
			$data ['img'] = $this->_page_img_cj ( $url, $rules_info );
		} else {
			$data ['content'] = $this->_page_content_cj ( $url, $rules_info );
			$data ['img'] = $this->_page_img_cj ( $url, $rules_info );
		}
		return $data;
	}
	function page_get_content($content, $args = array(), $rules_info = "") {
		extract ( $args );
		if (! $content_arr) {
			$page_hash [] = md5 ( $content );
			$re_info ['content'] = $this->_page_content_cj ( $url, $rules_info );
			$re_info ['page_url'] = $url;
			$re_info ['page'] = 1;
			if (! $re_info) {
				unset ( $content_arr );
				return FALSE;
			}
			if (intval ( $re_info ) != - 1)
				$content_arr [md5 ( $url )] = $re_info;
		}
		foreach ( ( array ) $content_page_arr as $k => $v ) {
			if ($v == '#' || ! $v || $v == $url || in_array ( $v, $oldurl ))
				continue;
			
			$url_parse_arr = parse_url ( strtolower ( $v ) );
			$content = $this->_page_content_cj ( $v, $rules_info );
			$hash = md5 ( $content );
			if (in_array ( $hash, $page_hash ))
				continue;
			$oldurl [] = $v;
			$page_hash [] = $hash;
			$num = count ( $content_arr ) + 1;
			$re_info ['content'] = $this->_page_content_cj ( $v, $rules_info );
			$re_info ['page_url'] = $v;
			$re_info ['page'] = $num;
			$content_arr [md5 ( $v )] = $re_info;
			
			if ($rules_info->db_page_type == 1) {
				
				$docment = $this->snoopy ( $v );
				$cc = $this->_page_last_CJ ( $docment, $rules_info, $v );
				
				$args = array (
						'oldurl' => $oldurl,
						'content_arr' => $content_arr,
						'content_page_arr' => $cc,
						'page_hash' => $page_hash,
						'rules' => $rules_info,
						'url' => $url 
				);
				return $this->page_get_content ( $content, $args, $rules_info );
			}
		}
		return $content_arr;
	}
	private function _page_img_cj($url, $re) {
		$result = $this->snoopy ( $url );
		$this->_CI->load->library ( 'cj/cj_img' );
		if ($re->db_img_dom || $re->db_img_dom_on == "on") {
			$results = $this->_dom_url_cj ( $result, trim ( $re->db_img_dom ), "", 1 );
		} elseif ($re->db_img_str) {
			$results = $this->_CI->cj->pregmessage ( $result, trim ( $re->db_img_str ), "img", - 1 );
		}
		
		if (! $results) {
			return false;
		}
		$result_url = array ();
		// 获取图片 return array
		$result_url [] = $this->_CI->cj_img->get_img_attach ( $results [0], "", $url );
		
		// 二维数组转一维数组
		$result_url = $this->_CI->cj->_arr_foreach ( $result_url );
		
		// 过滤数组里边的重复
		$result_url = $this->_CI->cj->_arrayUnique ( $result_url );
		
		// 链接中必须包含 $click_bh
		if ($re->db_img_bh) {
			$result_url = $this->_CI->cj->_str_Yes ( $result_url, trim ( $re->db_img_bh ) );
		}
		
		// 链接中不得出现 $click_nobh
		if ($re->db_img_nobh) {
			$result_url = $this->_CI->cj->_str_No ( $result_url, trim ( $re->db_img_nobh ) );
		}
		// 删除键值 重新排列数组
		$result_url ['img'] = array_values ( $result_url );
		// 获取图片介绍 return array
		$imgmessage = "";
		if ($re->db_imgmessage_dom_on == 0) {
			if ($re->db_imgmessage_str) {
				$imgmessage = $this->cj->pregmessage ( $result, trim ( $re->db_imgmessage_str ), "imgmessage", - 1 );
			}
		} else {
			$imgmessage = $this->_dom_url_cj ( $result, trim ( $re->db_imgmessage_dom ) );
		}
		
		if ($imgmessage) {
			$comment ['imgmessage'] = $this->cj->_striptext ( $imgmessage [0] );
			$result_url ['imgmessage'] = $this->cj->delval ( $comment ['imgmessage'] );
		}
		// $text = $this->snoopy->_striptext($result);
		return $result_url;
	}
	private function _page_content_cj($url, $re) {
		$result = $this->snoopy ( $url );
		
		// 获取comment return array $db_title_start $db_title_end
		$comments = "";
		if ($re->db_comment_dom_on == "on") {
			$comments = $this->_dom_url_cj ( $result, trim ( $re->db_comment_dom ), "", 1 );
		} else {
			if ($re->db_comment_str) {
				$comments = $this->_CI->cj->pregmessage ( $result, trim ( $re->db_comment_str ), "comment", - 1 );
			}
		}
		if ($comments) {
			return $this->_CI->cj->delval ( $comments [0] );
		}
	}
	private function _page_all_CJ($result, $re, $url = "") {
		if (! $result) {
			return false;
		}
		$this->_CI->load->library ( 'cj/cj' );
		$results = "";
		// 两标签之间的值 return array $click_start $click_end
		if ($re->db_page_type == 0) {
			$results = $this->_dom_url_cj ( $result, $re->db_page_dom, "", 1 );
		} else if ($re->db_page) {
			if ($re->db_page_str) {
				$results = $this->_CI->cj->pregmessage ( $result, trim ( $re->db_page_str ), "page", - 1 );
			}
		}
		
		$result_url = array ();
		
		// 获取链接 return array
		if ($results) {
			foreach ( $results as $v ) {
				$result_url [] = $this->_CI->cj->striplinks ( $v );
			}
			// 二维数组转一维数组
			// $result_url = $this->_CI->cj->_arr_foreach ( $result_url );
			$result_url = $result_url [0];
			
			// 过滤数组里边的重复
			$result_url = $this->_CI->cj->_arrayUnique ( $result_url );
			
			// 链接中必须包含 $click_bh
			if ($re->db_page_bh) {
				$result_url = $this->_CI->cj->_str_Yes ( $result_url, trim ( $re->db_page_bh ) );
			}
			
			// 链接中不得出现 $click_nobh
			if ($re->db_page_nobh) {
				$result_url = $this->_CI->cj->_str_No ( $result_url, trim ( $re->db_page_nobh ) );
			}
		}
		
		$result_urls = array ();
		foreach ( $result_url as $v ) {
			$base_url = $this->get_base_url ( $result );
			$base_url = $base_url ? $base_url : $url;
			
			$result_urls [] = $this->_CI->cj->_expandlinks ( $v, $base_url );
		}
		
		return $result_urls;
	}
	private function _page_last_CJ($result, $re, $url = "") {
		if (! $result) {
			return false;
		}
		$this->_CI->load->library ( 'cj/cj' );
		$results = "";
		// 两标签之间的值 return array $click_start $click_end
		if ($re->db_page_type == 0) {
			$results = $this->_dom_url_cj ( $result, "$re->db_page_dom", "", 1 );
		} else if ($re->db_page) {
			if ($re->db_page_str) {
				$results = $this->_CI->cj->pregmessage ( $result, trim ( $re->db_page_str ), "page", - 1 );
			}
		}
		$result_url = array ();
		// 获取链接 return array
		if ($results) {
			foreach ( $results as $v ) {
				$result_url [] = $this->_CI->cj->striplinks ( $v );
			}
			// 二维数组转一维数组
			$result_url = $result_url [0];
			// 链接中必须包含 $click_bh
			if ($re->db_page_bh) {
				$result_url = $this->_CI->cj->_str_Yes ( $result_url, trim ( $re->db_page_bh ) );
			}
			
			// 链接中不得出现 $click_nobh
			if ($re->db_page_nobh) {
				$result_url = $this->_CI->cj->_str_No ( $result_url, trim ( $re->db_page_nobh ) );
			}
		}
		
		$base_url = $this->get_base_url ( $result );
		$base_url = $base_url ? $base_url : $url;
		return $this->_CI->cj->_expandlinks ( end ( $result_url ), $base_url );
	}
	// dom获取多个内容段
	private function _dom_url_cj($str, $dom_rules, $filter_type = 'reply', $count = 0) {
		$dom = get_htmldom_obj ( $str );
		$count = intval ( $count );
		if (! $count)
			return false;
		$text_arr = array ();
		if (! $dom)
			return false;
		foreach ( $dom->find ( $dom_rules ) as $k => $v ) {
			// $text_arr [] = $v->innertext;
			$text_arr [] = $v->innertext;
			if ($count > 0 && ($k == $count - 1))
				break;
		}
		if ($filter_type == 'reply')
			unset ( $text_arr [0] );
		$dom->clear ();
		unset ( $dom );
		return $text_arr;
	}
	function get_base_url($message) {
		preg_match ( "/<base[^>]+href=\"?'?([^'\"\>]+)\"?[^>]+\>/is", $message, $arr );
		if (isset ( $arr [1] ) && $arr [1])
			return $arr [1];
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
		if ($check == 0 && $check !== FALSE) {
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
		$port = $match_part ["port"] ? ':' . $match_part ["port"] : '';
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
	function snoopy($url, $args = array()) {
		$this->_CI->load->library ( 'cj/Cj1' );
		$time_out = 15;
		$max_redirs = 3;
		$cache = 20 * 60;
		$content = "";
		if ($cache > 0 && $content = $this->_CI->cj1->load_cache ( $url )) {
			return $content ['content'];
		} else {
			$time_out = 10;
			if (! function_exists ( 'fsockopen' ) && ! function_exists ( 'pfsockopen' ) && ! function_exists ( 'file_get_contents' )) {
				return FALSE;
			}
			if (! function_exists ( 'fsockopen' ) && ! function_exists ( 'pfsockopen' )) {
				if (! function_exists ( 'file_get_contents' ))
					return - 1;
				$content = file_get_contents ( $url );
				$content = $this->_CI->cj1->str_iconv ( $content );
			} else {
				require_once APPPATH . "libraries/cj/Snoopy.class.php";
				$snoopy = new Snoopy ();
				if (! empty ( $proxy_host )) {
					$snoopy->proxy_host = $proxy_host;
					$snoopy->proxy_port = $proxy_port;
					$snoopy->proxy_user = $proxy_user;
					$snoopy->proxy_pass = $proxy_pass;
				}
				$snoopy->maxredirs = $max_redirs;
				$snoopy->expandlinks = TRUE;
				$snoopy->offsiteok = TRUE; //
				$snoopy->maxframes = 3;
				$snoopy->agent = $_SERVER ['HTTP_USER_AGENT'];
				$snoopy->referer = $url;
				$snoopy->rawheaders ["COOKIE"] = "dsfd";
				$snoopy->read_timeout = $time_out;
				if (! $snoopy->fetch ( $url ))
					return FALSE;
				$header = ( array ) $snoopy->headers;
				$header = array_map ( 'trim', $header );
				$key = array_search ( "Content-Encoding: gzip", $header );
				if ($header [0] == 'HTTP/1.1 404 Not Found' || $header [0] == 'HTTP/1.1 500 Internal Server Error')
					return FALSE;
				if ($key)
					$snoopy->results = gzdecode ( $snoopy->results ); // gzip
				
				$content = $this->_CI->cj1->str_iconv ( $snoopy->results );
			}
			
			if ($content)
				$this->_CI->cj1->cache_data ( $url, array (
						'content' => $content 
				), $cache );
			return $content;
		}
	}
}