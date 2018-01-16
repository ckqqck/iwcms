<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cj {
	public $_CI;
	public $unicode = "utf-8";
	public function __construct() {
		$this->_CI = & get_instance ();
	}
	// 等差数列生成url
	function dengCha_url($url, $s, $n, $c) {
		$strRegex = "/\(\*\)/";
		$r = $s;
		$urls = array ();
		$urls [] = preg_replace ( $strRegex, $s, $url );
		for($i = 1; $i < $n; $i ++) {
			$r += $c;
			$urls [] = preg_replace ( $strRegex, $r, $url );
		}
		return $urls;
	}
	// 等比数列生成url
	function dengBi_url($url, $s, $n, $c) {
		$strRegex = "/\(\*\)/";
		$r = $s;
		$urls = array ();
		$urls [] = preg_replace ( $strRegex, $s, $url );
		for($i = 1; $i < $n; $i ++) {
			$r = $r * $c;
			$urls [] = preg_replace ( $strRegex, $r, $url );
		}
		return $urls;
	}
	
	// php检查是否是url
	function IsURL($str_url) {
		$strRegex = "/^(https|http|ftp|rtsp|mms)?:\/\/?([^\/]+)/i";
		$re = preg_match ( $strRegex, $str_url );
		if ($re) {
			return true;
		} else {
			return false;
		}
	}
	// php匹配是否存在(*)
	function IsCJ($str_url) {
		$strRegex = "/\(\*\)/";
		$re = preg_match ( $strRegex, $str_url );
		if ($re) {
			return true;
		} else {
			return false;
		}
	}
	// 分割单条网址 ：一行一个网址，返回到一个新数组
	function IsEx($ex, $string) {
		return explode ( $ex, $string );
	}
	// 过滤一维数组中不是url的值 返回给一个新的数组;
	function forurl($array) {
		$new_array = array ();
		foreach ( $array as $v ) {
			if ($this->IsURL ( $v )) {
				$new_array [] = $this->trimall ( $v );
			}
		}
		return $new_array;
	}
	// 删除所有空格
	function trimall($str) {
		$qian = array (
				" ",
				"  ",
				"\t",
				"\n",
				"\r" 
		);
		$hou = array (
				"",
				"",
				"",
				"",
				"" 
		);
		return str_replace ( $qian, $hou, $str );
	}
	
	/**
	 * 判断是否为UTF8编码
	 *
	 * @param unknown_type $string        	
	 * @return unknown
	 */
	function is_utf8($string) {
		return preg_match ( '%^(?:
          [\x09\x0A\x0D\x20-\x7E]             # ASCII
        | [\xC2-\xDF][\x80-\xBF]              # non-overlong 2-byte
        |   \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs
        | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}   # straight 3-byte
        |   \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates
        |   \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
        | [\xF1-\xF3][\x80-\xBF]{3}           # planes 4-15
        |   \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
    )*$%xs', $string );
	}
	
	/**
	 * 采集HTML标签内容
	 * 开发者：大春 blog.dachun.net
	 *
	 * @param unknown_type $html
	 *        	//HTMl数据源
	 * @param unknown_type $tag
	 *        	//HTML标签内容
	 * @return unknown 返回标签范围内位子
	 */
	function getTags($html, $tag) {
		$level = 0;
		$offset = 0;
		$return = "";
		$len = strlen ( $tag );
		$tag = strtolower ( $tag );
		$html2 = strtolower ( $html );
		if (strpos ( $tag, " " )) {
			$temp = explode ( " ", $tag );
		}
		$tag_end = (isset ( $temp [0] )) ? $temp [0] : $tag;
		$i = 0;
		while ( 1 ) {
			$seat1 = strpos ( $html2, "<{$tag}", $offset );
			if (false === $seat1)
				return $return;
			$seat2 = strpos ( $html2, "</{$tag_end}>", $seat1 + strlen ( $tag ) + 1 );
			$seat3 = strpos ( $html2, "<{$tag}", $seat1 + strlen ( $tag ) + 1 );
			while ( $seat3 != false && $seat3 < $seat2 ) {
				$seat2 = strpos ( $html2, "</{$tag_end}>", $seat2 + strlen ( $tag_end ) + 3 );
				$seat3 = strpos ( $html2, "<{$tag}", $seat3 + strlen ( $tag ) + 1 );
			}
			$offset = $seat1 + $len + 1;
			$return [$i] ['s'] = $seat1;
			$return [$i] ['e'] = $seat2 + $len + 3 - $seat1;
			$i ++;
		}
	}
	
	/**
	 * 统计标签数量
	 *
	 * @param unknown_type $html
	 *        	//HTMl数据源
	 * @param unknown_type $tag
	 *        	//HTML标签内容
	 * @return unknown
	 */
	function countTag($html, $tag) {
		$return = 0;
		$offset = 0;
		$tag = "<" . $tag . " ";
		$len = strlen ( $tag );
		while ( 1 ) {
			$star = strpos ( $html, $tag, $offset );
			if (false === $star)
				return $return;
			$return ++;
			$offset = $star + $len;
		}
	}
	function str_iconv($str) {
		if (! $str)
			return false;
		$charset = strtoupper ( get_charset ( $str ) );
		$big5 = TRUE;
		if (GBK) {
			if ($charset == 'UTF-8') {
				if ($is_big) {
					return big5_gbk ( $str );
				}
				$str = piconv ( $str, 'UTF-8', 'GBK' );
				return $str;
			} else if ($charset == 'BIG5') {
				return big52gb ( $str );
			}
		} else {
			if ($charset != 'UTF-8') {
				if ($charset == 'BIG5') {
					if ($_G ['config'] ['output'] ['language'] != 'zh_tw') {
						$str = big52gb ( $str );
						return piconv ( $str, 'GBK', 'UTF-8' );
					}
					if ($big5)
						return $str;
				}
				if ($big5)
					return piconv ( $str, 'GBK', 'BIG5' );
					// if($big5) return gb2big5($str);
				$str = piconv ( $str, $charset, 'UTF-8' );
				
				/*
				 * $str = piconv($str, 'GBK', 'BIG5');
				 * $str = piconv($str, 'BIG5', 'UTF-8');
				 */
				
				return $str;
			} else {
				if ($big5) {
					$str = piconv ( $str, 'UTF-8', 'GBK' );
					$str = gb2big5 ( $str );
				}
			}
		}
		return $str;
	}
	function get_charset($web_str) {
		preg_match ( "/<meta[^>]+charset=\"?'?([^'\"\>]+)\"?[^>]+\>/is", $web_str, $arr );
		// if($arr[1]) return $arr[1];
		$arr [1] = strtoupper ( $arr [1] );
		if ($arr [1] == 'GBK' || $arr [1] == 'BIG5')
			return $arr [1];
		$charset = is_utf8 ( $web_str ) ? 'UTF-8' : 'GB2312';
		if ($arr [1] && $arr [1] == $charset)
			return $arr [1];
		return $charset;
	}
	// 过滤数组里边的重复
	function arrayUnique($array) {
		return array_unique ( $array );
	}
	// 匹配出连接
	function getTextBetweenTags($string, $tagname) {
		$pattern = "/<$tagname.*?href=\"(.*?)\"\s*>[\w\W]*?<\/$tagname>/";
		preg_match_all ( $pattern, $string, $matches );
		return $matches [1];
	}
	function striplinks($document) {
		$match = array ();
		preg_match_all ( "'<\s*a\s.*?href\s*=\s*			# find <a href=
						([\"\'])?					# find single or double quote
						(?(1) (.*?)\\1 | ([^\s\>]+))		# if quote found, match up to next matching
													# quote, otherwise match up to next space
						'isx", $document, $links );
		
		// catenate the non-empty matches from the conditional subpattern
		
		while ( list ( $key, $val ) = each ( $links [2] ) ) {
			if (! empty ( $val ))
				$match [] = $val;
		}
		
		while ( list ( $key, $val ) = each ( $links [3] ) ) {
			if (! empty ( $val ))
				$match [] = $val;
		}
		
		// return the links
		return $match;
	}
	// 清除HTML标签
	function delhtml($str) {
		$st = - 1; // 开始
		$et = - 1; // 结束
		$stmp = array ();
		$stmp [] = "&nbsp;";
		$len = strlen ( $str );
		for($i = 0; $i < $len; $i ++) {
			$ss = substr ( $str, $i, 1 );
			if (ord ( $ss ) == 60) { // ord("<")==60
				$st = $i;
			}
			if (ord ( $ss ) == 62) { // ord(">")==62
				$et = $i;
				if ($st != - 1) {
					$stmp [] = substr ( $str, $st, $et - $st + 1 );
				}
			}
		}
		$str = str_replace ( $stmp, "", $str );
		return $str;
	}
	// 删除tag css
	function delcss($text) {
		return preg_replace ( "/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $text );
	}
	// 删除tag val
	function del_href($string) {
		$string = preg_replace ( "/(<a.*?>)/is", "", $string ); // 替换<a href="http://country.huanqiu.com/jordan">
		$string = preg_replace ( "/(<\/a>)/is", "", $string ); // 替换</a>
		$string = $this->deltable ( $string );
		$search = array (
				"'<script[^>]*?>.*?</script>'si" 
		); // 替换<script>
		$replace = array (
				"" 
		);
		$string = preg_replace ( $search, $replace, $string );
		return $string;
	}
	function deltable($text) {
		$text = preg_replace ( "/(<table.*?>)/is", "", $text );
		$text = preg_replace ( "/(<tbody.*?>)/is", "", $text );
		$text = preg_replace ( "/(<tr.*?>)/is", "", $text );
		$text = preg_replace ( "/(<td.*?>)/is", "", $text );
		$text = preg_replace ( "/(<th.*?>)/is", "", $text );
		$text = preg_replace ( "/(<\/table>)/is", "", $text );
		$text = preg_replace ( "/(<\/tbody>)/is", "", $text );
		$text = preg_replace ( "/(<\/tr>)/is", "", $text );
		$text = preg_replace ( "/(<\/td>)/is", "", $text );
		$text = preg_replace ( "/(<\/th>)/is", "", $text );
		return $text;
	}
	function _striptext($document) {
		
		// I didn't use preg eval (//e) since that is only available in PHP 4.0.
		// so, list your entities one by one here. I included some of the
		// more common ones.
		$search = array (
				"'<script[^>]*?>.*?</script>'si", // strip out javascript
				"'([\r\n])[\s]+'", // strip out white space
				"'&(quot|#34|#034|#x22);'i", // replace html entities
				"'&(amp|#38|#038|#x26);'i", // added hexadecimal values
				"'&(lt|#60|#060|#x3c);'i",
				"'&(gt|#62|#062|#x3e);'i",
				"'&(nbsp|#160|#xa0);'i",
				"'&(iexcl|#161);'i",
				"'&(cent|#162);'i",
				"'&(pound|#163);'i",
				"'&(copy|#169);'i",
				"'&(reg|#174);'i",
				"'&(deg|#176);'i",
				"'&(#39|#039|#x27);'",
				"'&(euro|#8364);'i", // europe
				"'&a(uml|UML);'", // german
				"'&o(uml|UML);'",
				"'&u(uml|UML);'",
				"'&A(uml|UML);'",
				"'&O(uml|UML);'",
				"'&U(uml|UML);'",
				"'&szlig;'i" 
		);
		$replace = array (
				"",
				"\\1",
				"\"",
				"&",
				"<",
				">",
				" ",
				chr ( 161 ),
				chr ( 162 ),
				chr ( 163 ),
				chr ( 169 ),
				chr ( 174 ),
				chr ( 176 ),
				chr ( 39 ),
				chr ( 128 ),
				"ä",
				"ö",
				"ü",
				"Ä",
				"Ö",
				"Ü",
				"ß" 
		);
		
		$text = preg_replace ( $search, $replace, $document );
		
		return $text;
	}
	// 匹配ip,url,name,text,qq
	public function isEmail($str) {
		return is_string ( $str ) && preg_match ( '/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/', $str );
	}
	public function isPhone($str, $type) {
		$preg_array_pho = array (
				'cn' => '/^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/',
				'tw' => '' 
		);
		if (in_array ( 

		$type, array_keys ( $pre_array_pho ) )) {
			return preg_match ( $pre_array_pho [$type], $str );
		} else {
			die ( $type . '-phone number is undefined' );
		}
	}
	public function isText($str, $type, $min_lenth = 1, $max_lenth = '') {
		$preg_array_text = array (
				'ch' => "/^([\x81-\xfe][\x40-\xfe]){" . $min_lenth . "," . $max_lenth . "}$/",
				'num' => "/^[0-9]{" . $min_lenth . "," . $max_lenth . "}$/i" 
		);
		if (

		in_array ( $type, array_keys ( $preg_array_text ) )) {
			return is_string ( $preg_array_text ) && preg_match ( $preg_array_text [$type], $str );
		} else {
			die ( $type . '-text is undefined' );
		}
	}
	
	/*
	 * ======================================================================*\
	 * Function:	获取两标签之间的值
	 * Purpose:	 get_all_string_between($str, '<li>', "</li>")
	 * Output:		string results
	 * \*======================================================================
	 */
	// 获取网址比较好
	function _get_all_string_between($string, $start, $end) {
		$result = array ();
		$string = " " . $string;
		$offset = 0;
		while ( true ) {
			$ini = strpos ( $string, $start, $offset );
			if ($ini == 0)
				break;
			$ini += strlen ( $start );
			$len = strpos ( $string, $end, $ini ) - $ini;
			$result [] = substr ( $string, $ini, $len );
			$offset = $ini + $len;
		}
		return $result;
	}
	// 获取内容好
	function g($string, $start, $end) {
		preg_match_all ( '/' . preg_quote ( $start, '/' ) . '(.*?)' . preg_quote ( $end, '/' ) . '/i', $string, $m );
		$out = array ();
		foreach ( $m [1] as $key => $value ) {
			$type = explode ( '::', $value );
			if (sizeof ( $type ) > 1) {
				if (! is_array ( $out [$type [0]] ))
					$out [$type [0]] = array ();
				$out [$type [0]] [] = $type [1];
			} else {
				$out [] = $value;
			}
		}
		return $out;
	}
	// 获取内容好
	function getStrsBetween($s, $s1, $s2 = false, $offset = 0) {
		if ($s2 === false) {
			$s2 = $s1;
		}
		$result = array ();
		$L1 = strlen ( $s1 );
		$L2 = strlen ( $s2 );
		
		if ($L1 == 0 || $L2 == 0) {
			return false;
		}
		
		do {
			$pos1 = strpos ( $s, $s1, $offset );
			
			if ($pos1 !== false) {
				$pos1 += $L1;
				
				$pos2 = strpos ( $s, $s2, $pos1 );
				
				if ($pos2 !== false) {
					$key_len = $pos2 - $pos1;
					
					$this_key = substr ( $s, $pos1, $key_len );
					
					if (! array_key_exists ( $this_key, $result )) {
						$result [$this_key] = array ();
					}
					
					$result [] = $this_key;
					
					$offset = $pos2 + $L2;
				} else {
					$pos1 = false;
				}
			}
		} while ( $pos1 !== false );
		
		return $result;
	}
	
	/**
	 * 解析内容
	 */
	function pregmessage($message, $rule, $getstr, $limit = 1, $get_type = 'in') {
		if (! $message)
			return array ();
		
		$message = str_replace ( "\r\n", "\r\m", $message );
		$message = str_replace ( "\n", "\r\n", $message );
		$message = str_replace ( "\r\m", "\r\n", $message );
		$rule = $this->convertrule ( $rule ); // 转义正则表达式特殊字符串
		$result = array ();
		$rule = str_replace ( '\[' . $getstr . '\]', '\s*(.+?)\s*', $rule ); // 解析为正则表达式
		if ($limit == 1) {
			$result = array ();
			preg_match ( "/$rule/is", $message, $rarr );
			if (! empty ( $rarr [1] )) {
				$result [] = $get_type == 'in' ? $rarr [1] : $rarr [0];
			}
		} else {
			preg_match_all ( "/$rule/is", $message, $rarr, PREG_SET_ORDER );
			if (! empty ( $rarr [0] )) {
				$key = $get_type == 'in' ? 1 : 0;
				foreach ( $rarr as $k => $v ) {
					if (isset ( $v [$key] )) {
						$result [] = $this->clear ( $v [$key] );
					}
				}
			}
		}
		// $message = $this->clear($message);
		return $result;
	}
	
	/**
	 * 正则规则
	 */
	function getregularstring($rule, $getstr) {
		$rule = $this->convertrule ( $rule ); // 转义正则表达式特殊字符串
		$rule = str_replace ( '\[' . $getstr . '\]', '\s*(.+?)\s*', $rule ); // 解析为正则表达式
		return $rule;
	}
	/**
	 * 转义正则表达式字符串
	 */
	function convertrule($rule) {
		$rule = stripslashes ( $rule );
		$rule = preg_quote ( $rule, "/" ); // 转义正则表达式
		$rule = str_replace ( '\*', '.*?', $rule );
		$rule = str_replace ( "\(.*?\)", '(.*?)', $rule );
		
		// $rule = str_replace('\|', '|', $rule);
		
		return $rule;
	}
	// 去噪
	function clear($str) {
		$str = preg_replace ( "'([\r\n])[\s]+'", "", $str ); // 去掉换行速度更快
		$str = preg_replace ( array (
				"'<head[^>]*?>.*?</head>'si" 
		), array (
				'' 
		), $str );
		$str = preg_replace ( array (
				"'<script[^>]*?>.*?</script>'si" 
		), array (
				'' 
		), $str );
		$filter_html = array (
				14,
				15,
				18,
				19 
		);
		return $this->clear_html_script ( $str, $filter_html );
	}
	function clear_html_script($str, $filter_arr) {
		if (! $filter_arr)
			return FALSE;
		$filter_html = array (
				'0' => array (
						'search' => 'a' 
				),
				'1' => array (
						'search' => 'table' 
				),
				'2' => array (
						'search' => 'tr' 
				),
				'3' => array (
						'search' => 'td' 
				),
				'4' => array (
						'search' => 'p' 
				),
				'5' => array (
						'search' => 'font' 
				),
				'6' => array (
						'search' => 'div' 
				),
				'7' => array (
						'search' => 'span' 
				),
				'8' => array (
						'search' => 'tbody' 
				),
				'9' => array (
						'search' => 'img' 
				),
				
				'10' => array (
						'search' => 'b|strong' 
				),
				
				'11' => array (
						'search' => '<br>' 
				),
				
				'12' => array (
						'search' => '&nbsp;' 
				),
				'13' => array (
						'search' => 'h1|h2|h3|h4|h5|h6|h7' 
				),
				'14' => array (
						'search' => 'hr' 
				),
				'15' => array (
						'search' => 'form' 
				),
				
				'16' => array (
						'search' => 'iframe|frame' 
				),
				'17' => array (
						'search' => 'li|ul|dd|dt' 
				),
				'18' => array (
						'search' => 'sub|sup' 
				),
				'19' => array (
						'search' => 'input|select|textarea|label|option|button' 
				),
				'21' => array (
						'search' => 'object|embed' 
				) 
		);
		$max = count ( $filter_html );
		foreach ( ( array ) $filter_arr as $k => $v ) {
			if ($v < $max)
				$new_arr [] = $filter_html [$v] ['search'];
		}
		
		$rules = implode ( "|", $new_arr );
		$rules = $this->convertrule ( $rules );
		$rules = str_replace ( '\|', '|', $rules );
		$str = preg_replace ( "/<(\/?(" . $rules . ").*?)>/si", "", $str );
		
		return $str;
	}
	/*
	 * ======================================================================*\
	 * Function:	过滤数组里边的重复
	 * Purpose:		 _arrayUnique($array)
	 * Output:		string results
	 * \*======================================================================
	 */
	function _arrayUnique($array) {
		return array_unique ( $array );
	}
	/*
	 * ======================================================================*\
	 * Function:	二维数组转一维数组
	 * Purpose:	 _arr_foreach($arr)
	 * Output:		string results
	 * \*======================================================================
	 */
	function _arr_foreach($arr) {
		static $tmp = array ();
		if (! is_array ( $arr )) {
			return false;
		}
		foreach ( $arr as $val ) {
			if (is_array ( $val )) {
				$this->_arr_foreach ( $val );
			} else {
				$tmp [] = $val;
			}
		}
		return $tmp;
	}
	/*
	 * ======================================================================*\
	 * Function:	多维数组转一维数组
	 * Purpose:	 _arr_foreach($arr)
	 * Output:		string results
	 * \*======================================================================
	 */
	function _arr_foreachs($arr) {
		static $tmp = array ();
		
		for($i = 0; $i < count ( $arr ); $i ++) {
			if (is_array ( $arr [$i] ))
				$this->_arr_foreach ( $arr [$i] );
			else
				$tmp [] = $arr [$i];
		}
		
		return $tmp;
	}
	/*
	 * ======================================================================*\
	 * Function:	匹配特殊字符的处理
	 * Purpose:	 _str_qe("</body>")
	 * Output:		string results
	 * \*======================================================================
	 */
	function _ReplaceSpecialChar($C_char) { // 过滤特殊字符
		$C_char = str_replace ( "/", "\/", $C_char ); // 替换英文逗号,
		$C_char = str_replace ( "$", "\$", $C_char ); // 替换英文小破折号<
		$C_char = str_replace ( '"', '\"', $C_char ); // 替换英文小破折号>
		$C_char = str_replace ( "'", "\'", $C_char ); // 替换英文单引号 '
		$C_char = str_replace ( "{", "\{", $C_char ); // 替换英文大括号{
		$C_char = str_replace ( "}", "\}", $C_char ); // 替换英文大括号}
		$C_char = str_replace ( "(", "\(", $C_char ); // 替换英文小括号(
		$C_char = str_replace ( "）", "\）", $C_char ); // 替换英文小括号）
		return $C_char; // 返回处理结果
	}
	/*
	 * ======================================================================*\
	 * Function:	链接中必须包含
	 * Purpose:	 str_No($array,"abc")
	 * Output:		Array results
	 * \*======================================================================
	 */
	function _str_Yes($array, $strs) {
		$str = $this->_ReplaceSpecialChar ( $strs );
		$pattern = "/.$str./";
		foreach ( $array as $id => $row ) {
			if (! preg_match ( $pattern, $row )) {
				unset ( $array [$id] );
			}
		}
		return $array;
	}
	/*
	 * ======================================================================*\
	 * Function:	链接中不得出现
	 * Purpose:	 str_No($array,"cde")
	 * Output:		string results
	 * \*======================================================================
	 */
	function _str_No($array, $str) {
		$str = $this->_ReplaceSpecialChar ( $str );
		$pattern = "/.$str./";
		foreach ( $array as $id => $row ) {
			if (preg_match ( $pattern, $row )) {
				unset ( $array [$id] );
			}
		}
		return $array;
	}
	/*
	 * ======================================================================*\
	 * Function:	主机名
	 * Purpose:	 _add_host($array,"http://127.0.0.1")
	 * Output:		string results
	 * \*======================================================================
	 */
	function _add_host($array, $str) {
		foreach ( $array as $k => $v ) {
			$array [$k] = $str . $v;
		}
		return $array;
	}
	/*
	 * ======================================================================*\
	 * Function:	主机名
	 * Purpose:	 _validateURL("http://127.0.0.1")
	 * Output:		true false results
	 * \*======================================================================
	 */
	function _validateURL($URL) {
		$pattern_1 = "/^(http|https|ftp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+.(com|org|net|me|cn|cc|co|dk|at|us|tv|info|uk|co.uk|biz|se)$)(:(\d+))?\/?/i";
		$pattern_2 = "/^(www)((\.[A-Z0-9][A-Z0-9_-]*)+.(com|org|net|me|cn|cc|co|dk|at|us|tv|info|uk|co.uk|biz|se)$)(:(\d+))?\/?/i";
		if (preg_match ( $pattern_1, $URL ) || preg_match ( $pattern_2, $URL )) {
			return true;
		} else {
			return false;
		}
	}
	/*
	 * ======================================================================*\
	 * Function:	采集分页类用
	 * Purpose:
	 * Output:		str results
	 * \*======================================================================
	 */
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
}