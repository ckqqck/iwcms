<?php
class Str {
	function getstr($string, $length, $html = 0) {
		$string = trim ( $string );
		$sppos = strpos ( $string, chr ( 0 ) . chr ( 0 ) . chr ( 0 ) );
		if ($sppos !== false) {
			$string = substr ( $string, 0, $sppos );
		}
		
		if ($html < 0) {
			$string = preg_replace ( "/(\<[^\<]*\>|\r|\n|\s|\[.+?\])/is", ' ', $string );
		} elseif ($html == 0) {
			$string = $this->dhtmlspecialchars ( $string );
		}
		
		if ($length) {
			$string = $this->cutstr ( $string, $length );
		}
		return trim ( $string );
	}
	function dhtmlspecialchars($string) {
		if (is_array ( $string )) {
			foreach ( $string as $key => $val ) {
				$string [$key] = $this->dhtmlspecialchars ( $val );
			}
		} else {
			$string = str_replace ( array (
					'&',
					'"',
					'<',
					'>' 
			), array (
					'&amp;',
					'&quot;',
					'&lt;',
					'&gt;' 
			), $string );
			if (strpos ( $string, '&amp;#' ) !== false) {
				$string = preg_replace ( '/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string );
			}
		}
		return $string;
	}
	function cutstr($string, $length, $dot = ' ...') { // 字符串分割
		if (strlen ( $string ) <= $length) {
			return $string;
		}
		
		$pre = chr ( 1 );
		$end = chr ( 1 );
		$string = str_replace ( array (
				'&amp;',
				'&quot;',
				'&lt;',
				'&gt;' 
		), array (
				$pre . '&' . $end,
				$pre . '"' . $end,
				$pre . '<' . $end,
				$pre . '>' . $end 
		), $string );
		
		$strcut = '';
		if (strtolower ( CHARSET ) == 'utf-8') {
			
			$n = $tn = $noc = 0;
			while ( $n < strlen ( $string ) ) {
				
				$t = ord ( $string [$n] );
				if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1;
					$n ++;
					$noc ++;
				} elseif (194 <= $t && $t <= 223) {
					$tn = 2;
					$n += 2;
					$noc += 2;
				} elseif (224 <= $t && $t <= 239) {
					$tn = 3;
					$n += 3;
					$noc += 2;
				} elseif (240 <= $t && $t <= 247) {
					$tn = 4;
					$n += 4;
					$noc += 2;
				} elseif (248 <= $t && $t <= 251) {
					$tn = 5;
					$n += 5;
					$noc += 2;
				} elseif ($t == 252 || $t == 253) {
					$tn = 6;
					$n += 6;
					$noc += 2;
				} else {
					$n ++;
				}
				
				if ($noc >= $length) {
					break;
				}
			}
			if ($noc > $length) {
				$n -= $tn;
			}
			
			$strcut = substr ( $string, 0, $n );
		} else {
			$_length = $length - 1;
			for($i = 0; $i < $length; $i ++) {
				if (ord ( $string [$i] ) <= 127) {
					$strcut .= $string [$i];
				} else if ($i < $_length) {
					$strcut .= $string [$i] . $string [++ $i];
				}
			}
		}
		
		$strcut = str_replace ( array (
				$pre . '&' . $end,
				$pre . '"' . $end,
				$pre . '<' . $end,
				$pre . '>' . $end 
		), array (
				'&amp;',
				'&quot;',
				'&lt;',
				'&gt;' 
		), $strcut );
		
		$pos = strrpos ( $strcut, chr ( 1 ) );
		if ($pos !== false) {
			$strcut = substr ( $strcut, 0, $pos );
		}
		return $strcut . $dot;
	}
	function portalcp_get_summary($message) { //
		$message = preg_replace ( array (
				"/\[attach\].*?\[\/attach\]/",
				"/\&[a-z]+\;/i",
				"/\<script.*?\<\/script\>/" 
		), '', $message );
		$message = preg_replace ( "/\[.*?\]/", '', $message );
		$message = $this->getstr ( strip_tags ( $message ), 200 );
		return $message;
	}
}