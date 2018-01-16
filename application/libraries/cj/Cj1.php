<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cj1 {
	public $_CI;
	public $unicode = "utf-8";
	public function __construct() {
		$this->_CI = & get_instance ();
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
			// return $str;
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
	function is_utf8($string) {
		if (preg_match ( "/^([" . chr ( 228 ) . "-" . chr ( 233 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}){1}/", $string ) == true || preg_match ( "/([" . chr ( 228 ) . "-" . chr ( 233 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}){1}$/", $string ) == true || preg_match ( "/([" . chr ( 228 ) . "-" . chr ( 233 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}){2,}/", $string ) == true) {
			return true;
		} else {
			return false;
		}
	}
	function get_charset($web_str) {
		preg_match ( "/<meta[^>]+charset=\"?'?([^'\"\>]+)\"?[^>]+\>/is", $web_str, $arr );
		if (isset ( $arr [1] ))
			return $arr [1];
		$arr [1] = strtoupper ( isset ( $arr [1] ) );
		if ($arr [1] == 'GBK' || $arr [1] == 'BIG5')
			return $arr [1];
		$charset = $this->is_utf8 ( $web_str ) ? 'UTF-8' : 'GB2312';
		if ($arr [1] && $arr [1] == $charset)
			return $arr [1];
		return $charset;
	}
	function delete_cache($key) {
		$this->_CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$cache_name = md5($key);
				
		return $this->cache->delete($cache_name);
	}
	function load_cache($key) {
		$this->_CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$cache_name = md5($key);
		if ( ! $foo = $this->_CI->cache->get($cache_name))
		{	
			$foo = false;	
		}
		
		return $foo;
	}
	function cache_data($key, $value, $ttl = 7200) {
		$this->_CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$cache_name = md5($key);
		if ( ! $foo = $this->_CI->cache->get($cache_name))
		{	
			$foo = $value;	
			// Save into the cache for 120 minutes
			$this->_CI->cache->save($cache_name, $value, $ttl);
		}
		
		return $foo;
	}
}