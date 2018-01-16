<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class CI_Web {
	public $url;
	private $request;
	private $_CI;
	public $charset_arr = array (
			'gb2312',
			'utf-8',
			'big5',
			'gbk',
			'ascii',
			'cp936',
			'ibm037',
			'ibm437',
			'ibm500',
			'asmo-708',
			'dos-720',
			'ibm737',
			'ibm775',
			'ibm850',
			'ibm852',
			'ibm855',
			'ibm857',
			'ibm00858',
			'ibm861',
			'ibm860',
			'dos-862',
			'ibm863',
			'ibm864',
			'ibm865',
			'cp866',
			'ibm869',
			'ibm870',
			'windows-874',
			'cp875',
			'shift_jis',
			'ks_c_5601-1987',
			'ibm1026',
			'ibm01047',
			'ibm01047',
			'ibm01040',
			'ibm01041',
			'ibm01042',
			'ibm01043',
			'ibm01044',
			'ibm01045',
			'ibm01046',
			'ibm01047',
			'ibm01048',
			'ibm01049',
			'utf-16',
			'unicodefffe',
			'windows-1250',
			'windows-1251',
			'windows-1252',
			'windows-1253',
			'windows-1254',
			'windows-1255',
			'windows-1256',
			'windows-1257',
			'windows-1258',
			'johab',
			'macintosh',
			'x-mac-japanese',
			'x-mac-chinesetrad',
			'x-mac-korean',
			'x-mac-arabic',
			'x-mac-hebrew',
			'x-mac-greek',
			'x-mac-cyrillic',
			'x-mac-chinesesimp',
			'x-mac-romanian',
			'x-mac-ukrainian',
			'x-mac-thai',
			'x-mac-ce',
			'x-mac-icelandic',
			'x-mac-turkish',
			'x-mac-croatian',
			'x-chinese-cns',
			'x-cp20001',
			'x-chinese-eten',
			'x-cp20003',
			'x-cp20004',
			'x-cp20005',
			'x-ia5',
			'x-ia5-german',
			'x-ia5-swedish',
			'x-ia5-norwegian',
			'us-ascii',
			'x-cp20261',
			'x-cp20269',
			'ibm273',
			'ibm277',
			'ibm278',
			'ibm280',
			'ibm284',
			'ibm285',
			'ibm290',
			'ibm420',
			'ibm423',
			'ibm424',
			'x-ebcdic-koreanextended',
			'ibm-thai',
			'koi8-r',
			'ibm871',
			'ibm880',
			'ibm905',
			'ibm00924',
			'x-cp20936',
			'x-cp20949',
			'cp1025',
			'koi8-u',
			'iso-8859-1',
			'iso-8859-2',
			'iso-8859-3',
			'iso-8859-4',
			'iso-8859-5',
			'iso-8859-6',
			'iso-8859-7',
			'iso-8859-8',
			'iso-8859-9',
			'iso-8859-13',
			'iso-8859-15',
			'x-europa',
			'iso-8859-8-i',
			'iso-2022-jp',
			'csiso2022jp',
			'iso-2022-jp',
			'iso-2022-kr',
			'x-cp50227',
			'euc-jp',
			'euc-cn',
			'euc-kr',
			'hz-gb-2312',
			'gb18030',
			'x-iscii-de',
			'x-iscii-be',
			'x-iscii-ta',
			'x-iscii-te',
			'x-iscii-as',
			'x-iscii-or',
			'x-iscii-ka',
			'x-iscii-ma',
			'x-iscii-gu',
			'x-iscii-pa',
			'utf-7',
			'utf-32',
			'utf-32be' 
	);
	// 打开网站
	private function open($url) {
		if ($this->request !== null) {
			if ($this->request->status == 200) {
				return true;
			} else {
				return false;
			}
		} else {
			
			require_once APPPATH . "libraries/cj/Snoopy.class.php";
			$this->request = new Snoopy ();
			$this->request->fetch ( $url );
			if ($this->request->status == 200) {
				$this->request->results = strtolower ( $this->request->results );
				$charset = $this->getCharset ();
				if ($charset != "utf-8") {
					if ($charset == "windows-1252") {
						$this->request->results = $this->uni_decode ( $this->request->results );
					} else {
						$this->request->results = mb_convert_encoding ( $this->request->results, "UTF-8", "UTF-8" );
					}
				}
				return true;
			} else {
				return false;
			}
		}
	}
	public function getWebinfo($url) {
		$this->url = $url;
		$info = array ();
		if (! $this->open ( $this->url )) {
			return $info;
		}
		return $this->request->results;
	}
	public function t($string, $o) {
		for($i = 0; $i < strlen ( $string ); $i ++) {
			if (ord ( $string {$i} ) < 128)
				continue;
			if ((ord ( $string {$i} ) & 224) == 224) {
				// 第一个字节判断通过
				$char = $string {++ $i};
				if ((ord ( $char ) & 128) == 128) {
					// 第二个字节判断通过
					$char = $string {++ $i};
					if ((ord ( $char ) & 128) == 128) {
						$encoding = "UTF-8";
						break;
					}
				}
			}
			if ((ord ( $string {$i} ) & 192) == 192) {
				// 第一个字节判断通过
				$char = $string {++ $i};
				if ((ord ( $char ) & 128) == 128) {
					// 第二个字节判断通过
					$encoding = "GB2312";
					break;
				}
			}
		}
		return strtolower ( $encoding );
	}
	function uni_decode($str, $code = 'utf-8') {
		$str = json_decode ( preg_replace_callback ( '/&#(\d{5});/', create_function ( '$dec', 'return \'\\u\'.dechex($dec[1]);' ), '"' . $str . '"' ) );
		if ($code != 'utf-8') {
			$str = iconv ( 'utf-8', $code, $str );
		}
		return $str;
	}
	// 获取网站编码
	public function getCharset() {
		if (! $this->open ( $this->url )) {
			return false;
			exit ();
		}
		// 首先从html获取编码
		preg_match ( "/<meta.+?charset=[^\w]?([-\w]+)/i", $this->request->results, $temp ) ? strtolower ( $temp [1] ) : "";
		if ($temp [1] != "") {
			if (in_array ( $temp [1], $this->charset_arr )) {
				if ($temp [1] == "gb2312") {
					$tmp_charset = $this->t ( $this->request->results, $temp [1] );
					if ($tmp_charset == $temp [1]) {
						return $temp [1];
					}
				} else {
					return $temp [1];
				}
			}
		}
		if (! empty ( $this->request->headers )) {
			// 从header中获取编码
			$hstr = strtolower ( implode ( "|||", $this->request->headers ) );
			preg_match ( "/charset=[^\w]?([-\w]+)/is", $hstr, $lang ) ? strtolower ( $lang [1] ) : "";
			if ($lang [1] != "") {
				return $lang [1];
			}
		}
		$encode_arr = array (
				"UTF-8",
				"GB2312",
				"GBK",
				"BIG5",
				"ASCII",
				"EUC-JP",
				"Shift_JIS",
				"CP936",
				"ISO-8859-1",
				"JIS",
				"eucjp-win",
				"sjis-win" 
		);
		$encoded = mb_detect_encoding ( $this->request->results, $encode_arr );
		if ($encoded) {
			return strtolower ( $encoded );
		} else {
			return false;
		}
	}
}
?> 