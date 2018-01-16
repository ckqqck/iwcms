<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class CI_Parser {
	var $_options = array ();
	var $replacecode = array (
			'search' => array (),
			'replace' => array () 
	);
	function __construct() {
		$this->_CI = & get_instance ();
		$this->_options = array (
				'template_dir' => FCPATH . 'template/' . DEFAULTS, // 模板文件所在目录
				'cache_dir' => FCPATH . TPLCACHEPATH, // 缓存文件存放目录
				'auto_update' => true, // 当模板文件改动时是否重新生成缓存
				'cache_lifetime' => 0 
		); // 缓存生命周期(分钟)，为 0 表示永久
	}
	function template($file, $templateid = 0, $tpldir = '', $gettplfile = 0, $primaltpl = '') {
		static $_init_style = false;
		
		$tplfile = $file;
		
		$arr = explode ( ".", str_replace ( '/', '_', $file ), - 1 );
		$ck_filename = "";
		foreach ( $arr as $v ) {
			$ck_filename .= $v . ".";
		}
		$cachefile = $ck_filename . 'cache.php';		
		
		if (file_exists ( $this->_options ['template_dir'] . $tplfile )) {
			if (file_exists ( $this->_options ['cache_dir'] . $cachefile ) && @ filemtime ( $this->_options ['cache_dir'] . $cachefile ) > @ filemtime ( $this->_options ['template_dir'] . $tplfile )) {
				return $cachefile;
			} else {
				$this->checktplrefresh ( $tplfile, $tplfile, @ filemtime ( $this->_options ['cache_dir'] . $cachefile ), $templateid, $cachefile, $tpldir, $file );
			}
			return $cachefile;
		}
	}
	function getglobal($key, $group = null) {
		$k = explode ( '/', $group === null ? $key : $group . '/' . $key );
		
		switch (count ( $k )) {
			case 1 :
				return isset ( $k [0] ) ? $k [0] : null;
				break;
			case 2 :
				return isset ( $k [0] [$k [1]] ) ? $k [0] [$k [1]] : null;
				break;
			case 3 :
				return isset ( $k [0] [$k [1]] [$k [2]] ) ? $k [0] [$k [1]] [$k [2]] : null;
				break;
			case 4 :
				return isset ( $k [0] [$k [1]] [$k [2]] [$k [3]] ) ? $k [0] [$k [1]] [$k [2]] [$k [3]] : null;
				break;
			case 5 :
				return isset ( $k [0] [$k [1]] [$k [2]] [$k [3]] [$k [4]] ) ? $k [0] [$k [1]] [$k [2]] [$k [3]] [$k [4]] : null;
				break;
		}
		return null;
	}
	function checktplrefresh($maintpl, $subtpl, $timecompare, $templateid, $cachefile, $tpldir, $file) {
		if (empty ( $timecompare ) || @ filemtime ( $this->_options ['template_dir'] . $subtpl ) > $timecompare) {
			
			$filebak = $cachefile . ".bak";
			if (@ filemtime ( $this->_options ['cache_dir'] . $cachefile ) > @ filemtime ( $this->_options ['cache_dir'] . $filebak )) {
				
				if (@ $fp = fopen ( $this->_options ['cache_dir'] . $cachefile, 'r' )) {
					$template = @ fread ( $fp, filesize ( $this->_options ['cache_dir'] . $cachefile ) );
					fclose ( $fp );
				}
				if (@ $fps = fopen ( $this->_options ['cache_dir'] . $filebak, 'w' )) {
					flock ( $fps, 2 );
					fwrite ( $fps, $template );
					fclose ( $fps );
				}
			}
			$this->parse_template ( $maintpl, $templateid, $tpldir, $file, $cachefile );
		}
	}
	function parse_template($tplfile, $templateid, $tpldir, $file, $cachefile) {
		$basefile = basename ( $this->_options ['template_dir'] . $tplfile, '.htm' );
		$file == '';
		$this->file = $file;
		
		if (! @ $fp = fopen ( $this->_options ['template_dir'] . $tplfile, 'r' )) {
			$tpl = $tpldir . '/' . $file . '.htm';
			$tplfile = $tplfile != $tpl ? $tpl . '", "' . $tplfile : $tplfile;
			$this->error ( 'template_notfound', $tplfile );
		}
		
		$template = @ fread ( $fp, filesize ( $this->_options ['template_dir'] . $tplfile ) );
		fclose ( $fp );
		
		$var_regexp = "((\\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*(\-\>)?[a-zA-Z0-9_\x7f-\xff]*)(\[[a-zA-Z0-9_\-\.\"\'\[\]\$\x7f-\xff]+\])*)";
		$const_regexp = "([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)";
		
		$headerexists = preg_match ( "/{(sub)?template\s+[\w\/]+?header\}/", $template );
		$this->subtemplates = array ();
		for($i = 1; $i <= 3; $i ++) {
			if ($this->strexists ( $template, '{subtemplate' )) {
				$template = preg_replace ( "/[\n\r\t]*(\<\!\-\-)?\{subtemplate\s+([a-z0-9_:\/]+)\}(\-\-\>)?[\n\r\t]*/ies", "\$this->loadsubtemplate('\\2')", $template );
			}
		}
		
		$template = preg_replace ( "/([\n\r]+)\t+/s", "\\1", $template );
		$template = preg_replace ( "/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template );
		$template = preg_replace ( "/\{lang\s+(.+?)\}/ies", "\$this->languagevar('\\1')", $template );
		$template = preg_replace ( "/[\n\r\t]*\{block\/(\d+?)\}[\n\r\t]*/ie", "\$this->blocktags('\\1')", $template );
		$template = preg_replace ( "/[\n\r\t]*\{blockdata\/(\d+?)\}[\n\r\t]*/ie", "\$this->blockdatatags('\\1')", $template );
		$template = preg_replace ( "/[\n\r\t]*\{ad\/(.+?)\}[\n\r\t]*/ie", "\$this->adtags('\\1')", $template );
		$template = preg_replace ( "/[\n\r\t]*\{ad\s+([a-zA-Z0-9_\[\]]+)\/(.+?)\}[\n\r\t]*/ie", "\$this->adtags('\\2', '\\1')", $template );
		$template = preg_replace ( "/[\n\r\t]*\{date\((.+?)\)\}[\n\r\t]*/ie", "\$this->datetags('\\1')", $template );
		$template = preg_replace ( "/[\n\r\t]*\{avatar\((.+?)\)\}[\n\r\t]*/ie", "\$this->avatartags('\\1')", $template );
		$template = preg_replace ( "/[\n\r\t]*\{eval\s+(.+?)\s*\}[\n\r\t]*/ies", "\$this->evaltags('\\1')", $template );
		$template = preg_replace ( "/[\n\r\t]*\{csstemplate\}[\n\r\t]*/ies", "\$this->loadcsstemplate('\\1')", $template );
		$template = str_replace ( "{LF}", "<?=\"\\n\"?>", $template );
		$template = preg_replace ( "/\{(\\\$[a-zA-Z0-9_\-\>\[\]\'\"\$\.\x7f-\xff]+)\}/s", "<?=\\1?>", $template );
		$template = preg_replace ( "/\{hook\/(\w+?)(\s+(.+?))?\}/ie", "\$this->hooktags('\\1', '\\3')", $template );
		$template = preg_replace ( "/$var_regexp/es", "\$this->addquote('<?=\\1?>')", $template );
		$template = preg_replace ( "/\<\?\=\<\?\=$var_regexp\?\>\?\>/es", "\$this->addquote('<?=\\1?>')", $template );
		
		$headeradd = $headerexists ? "hookscriptoutput('$basefile');" : '';
		if (! empty ( $this->subtemplates )) {
			$headeradd .= "\n0\n";
			foreach ( $this->subtemplates as $fname ) {
				$headeradd .= "|| checktplrefresh('$tplfile', '$fname', " . time () . ", '$templateid', '$cachefile', '$tpldir', '$file')\n";
			}
			$headeradd .= ';';
		}
		
		if (! empty ( $this->blocks )) {
			$bkqqbid = implode ( ',', $this->blocks );
			$headeradd .= "\n";
			$headeradd .= "\$block_data_frombid = " . "\$this->block->block_get('" . $bkqqbid . "');";
			$headeradd .= "\n";
		}
		
		$template = "<? if(!defined('BASEPATH')) exit('Access Denied'); {$headeradd}?>\n$template";
		
		$template = preg_replace ( "/[\n\r\t]*\{template\s+([a-z0-9_:\/]+)\}[\n\r\t]*/ies", "\$this->stripvtags('<? include template(\'\\1\'); ?>')", $template );
		$template = preg_replace ( "/[\n\r\t]*\{template\s+(.+?)\}[\n\r\t]*/ies", "\$this->stripvtags('<? include template(\'\\1\'); ?>')", $template );
		$template = preg_replace ( "/[\n\r\t]*\{echo\s+(.+?)\}[\n\r\t]*/ies", "\$this->stripvtags('<? echo \\1; ?>')", $template );
		
		$template = preg_replace ( "/([\n\r\t]*)\{if\s+(.+?)\}([\n\r\t]*)/ies", "\$this->stripvtags('\\1<? if(\\2) { ?>\\3')", $template );
		$template = preg_replace ( "/([\n\r\t]*)\{elseif\s+(.+?)\}([\n\r\t]*)/ies", "\$this->stripvtags('\\1<? } elseif(\\2) { ?>\\3')", $template );
		$template = preg_replace ( "/\{else\}/i", "<? } else { ?>", $template );
		$template = preg_replace ( "/\{\/if\}/i", "<? } ?>", $template );
		
		$template = preg_replace ( "/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\}[\n\r\t]*/ies", "\$this->stripvtags('<? if(is_array(\\1)) foreach(\\1 as \\2) { ?>')", $template );
		$template = preg_replace ( "/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}[\n\r\t]*/ies", "\$this->stripvtags('<? if(is_array(\\1)) foreach(\\1 as \\2 => \\3) { ?>')", $template );
		$template = preg_replace ( "/\{\/loop\}/i", "<? } ?>", $template );
		
		$template = preg_replace ( "/\<\!\-\-\#\[(.+?)\]\#\-\-\>/s", "<!--#$\\1#-->", $template );
		$template = preg_replace ( "/\<\!\-\-\#(.+?)\#\-\-\>/s", "<?php \$this->load->m_cache_view(\"\\1\"); ?>", $template );
		
		$template = preg_replace ( "/\{$const_regexp\}/s", "<?=\\1?>", $template );
		if (! empty ( $this->replacecode )) {
			$template = str_replace ( $this->replacecode ['search'], $this->replacecode ['replace'], $template );
		}
		$template = preg_replace ( "/ \?\>[\n\r]*\<\? /s", " ", $template );
		
		if (! @ $fp = fopen ( $this->_options ['cache_dir'] . $cachefile, 'w' )) {
			$this->error ( 'directory_notfound', dirname ( $this->_options ['template_dir'] . $cachefile ) );
		}
		
		$template = preg_replace ( "/\"(http)?[\w\.\/:]+\?[^\"]+?&[^\"]+?\"/e", "\$this->transamp('\\0')", $template );
		$template = preg_replace ( "/\<script[^\>]*?src=\"(.+?)\"(.*?)\>\s*\<\/script\>/ies", "\$this->stripscriptamp('\\1', '\\2')", $template );
		$template = preg_replace ( "/[\n\r\t]*\{block\s+([a-zA-Z0-9_\[\]]+)\}(.+?)\{\/block\}/ies", "\$this->stripblock('\\1', '\\2')", $template );
		$template = preg_replace ( "/\<\?(\s{1})/is", "<?php\\1", $template );
		$template = preg_replace ( "/\<\?\=(.+?)\?\>/is", "<?php echo \\1;?>", $template );
		
		flock ( $fp, 2 );
		fwrite ( $fp, $template );
		fclose ( $fp );
	}
	function blocktags($parameter) {
		$bid = intval ( trim ( $parameter ) );
		$this->blocks [] = $bid;
		$i = count ( $this->replacecode ['search'] );
		$this->replacecode ['search'] [$i] = $search = "<!--BLOCK_TAG_$i-->";
		$this->replacecode ['replace'] [$i] = "<?php \$this->block->block_display('$bid');?>\n";
		return $search;
	}
	function blockdatatags($parameter) {
		$bid = intval ( trim ( $parameter ) );
		$this->blocks [] = $bid;
		$i = count ( $this->replacecode ['search'] );
		$this->replacecode ['search'] [$i] = $search = "<!--BLOCKDATA_TAG_$i-->";
		$this->replacecode ['replace'] [$i] = "";
		return $search;
	}
	function adtags($parameter, $varname = '') {
		$parameter = stripslashes ( $parameter );
		$i = count ( $this->replacecode ['search'] );
		$this->replacecode ['search'] [$i] = $search = "<!--AD_TAG_$i-->";
		$this->replacecode ['replace'] [$i] = "<?php " . (! $varname ? 'echo ' : '$' . $varname . '=') . "adshow(\"$parameter\");?>";
		return $search;
	}
	function datetags($parameter) {
		$parameter = stripslashes ( $parameter );
		$i = count ( $this->replacecode ['search'] );
		$this->replacecode ['search'] [$i] = $search = "<!--DATE_TAG_$i-->";
		$this->replacecode ['replace'] [$i] = "<?php echo date($parameter);?>";
		return $search;
	}
	function avatartags($parameter) {
		$parameter = stripslashes ( $parameter );
		$i = count ( $this->replacecode ['search'] );
		$this->replacecode ['search'] [$i] = $search = "<!--AVATAR_TAG_$i-->";
		$this->replacecode ['replace'] [$i] = "<?php echo avatar($parameter);?>";
		return $search;
	}
	function evaltags($php) {
		$php = str_replace ( '\"', '"', $php );
		$i = count ( $this->replacecode ['search'] );
		$this->replacecode ['search'] [$i] = $search = "<!--EVAL_TAG_$i-->";
		$this->replacecode ['replace'] [$i] = "<? $php?>";
		return $search;
	}
	function hooktags($hookid, $key = '') {
		$i = count ( $this->replacecode ['search'] );
		$this->replacecode ['search'] [$i] = $search = "<!--HOOK_TAG_$i-->";
		$dev = '';
		if (isset ( $_G ['config'] ['plugindeveloper'] ) && $_G ['config'] ['plugindeveloper'] == 2) {
			$dev = "echo '<hook>[" . ($key ? 'array' : 'string') . " $hookid" . ($key ? '/\'.' . $key . '.\'' : '') . "]</hook>';";
		}
		$key = $key !== '' ? "[$key]" : '';
		$this->replacecode ['replace'] [$i] = "<?php {$dev}if(!empty(\$_G['setting']['pluginhooks']['$hookid']$key)) echo \$_G['setting']['pluginhooks']['$hookid']$key;?>";
		return $search;
	}
	function stripphpcode($type, $code) {
		$this->phpcode [$type] [] = $code;
		return '{phpcode:' . $type . '/' . (count ( $this->phpcode [$type] ) - 1) . '}';
	}
	function loadsubtemplate($file) {
		$tplfile = template ( $file, 0, '', 1 );
		$filename = $this->_options ['template_dir'] . $tplfile;
		if (($content = @ implode ( '', file ( $filename ) )) || ($content = $this->getphptemplate ( @ implode ( '', file ( substr ( $filename, 0, - 4 ) . '.php' ) ) ))) {
			$this->subtemplates [] = $tplfile;
			return $content;
		} else {
			return '<!-- ' . $file . ' -->';
		}
	}
	function getphptemplate($content) {
		$pos = strpos ( $content, "\n" );
		return $pos !== false ? substr ( $content, $pos + 1 ) : $content;
	}
	function loadcsstemplate() {
		$scriptcss = '<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_common.css?{VERHASH}" />';
		$content = $this->csscurmodules = '';
		$content = @ implode ( '', file ( $this->_options ['template_dir'] . './data/cache/style_' . STYLEID . '_module.css' ) );
		$content = preg_replace ( "/\[(.+?)\](.*?)\[end\]/ies", "\$this->cssvtags('\\1','\\2')", $content );
		if ($this->csscurmodules) {
			$this->csscurmodules = preg_replace ( array (
					'/\s*([,;:\{\}])\s*/',
					'/[\t\n\r]/',
					'/\/\*.+?\*\//' 
			), array (
					'\\1',
					'',
					'' 
			), $this->csscurmodules );
			if (@ $fp = fopen ( $this->_options ['template_dir'] . './data/cache/style_' . STYLEID . '_' . $_G ['basescript'] . '_' . CURMODULE . '.css', 'w' )) {
				fwrite ( $fp, $this->csscurmodules );
				fclose ( $fp );
			} else {
				exit ( 'Can not write to cache files, please check directory ./data/ and ./data/cache/ .' );
			}
			$scriptcss .= '<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_' . $_G ['basescript'] . '_' . CURMODULE . '.css?{VERHASH}" />';
		}
		$scriptcss .= '{if $_G[uid] && isset($_G[cookie][extstyle]) && strpos($_G[cookie][extstyle], TPLDIR) !== false}<link rel="stylesheet" id="css_extstyle" type="text/css" href="$_G[cookie][extstyle]/style.css" />{elseif $_G[style][defaultextstyle]}<link rel="stylesheet" id="css_extstyle" type="text/css" href="$_G[style][defaultextstyle]/style.css" />{/if}';
		return $scriptcss;
	}
	function cssvtags($param, $content) {
		$modules = explode ( ',', $param );
		foreach ( $modules as $module ) {
			$module .= '::'; // fix notice
			list ( $b, $m ) = explode ( '::', $module );
			if ($b && $b == $_G ['basescript'] && (! $m || $m == CURMODULE)) {
				$this->csscurmodules .= $content;
				return;
			}
		}
		return;
	}
	function transamp($str) {
		$str = str_replace ( '&', '&amp;', $str );
		$str = str_replace ( '&amp;amp;', '&amp;', $str );
		$str = str_replace ( '\"', '"', $str );
		return $str;
	}
	function addquote($var) {
		return str_replace ( "\\\"", "\"", preg_replace ( "/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var ) );
	}
	function stripvtags($expr, $statement = '') {
		$expr = str_replace ( "\\\"", "\"", preg_replace ( "/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr ) );
		$statement = str_replace ( "\\\"", "\"", $statement );
		return $expr . $statement;
	}
	function stripscriptamp($s, $extra) {
		$extra = str_replace ( '\\"', '"', $extra );
		$s = str_replace ( '&amp;', '&', $s );
		return "<script src=\"$s\" type=\"text/javascript\"$extra></script>";
	}
	function stripblock($var, $s) {
		$s = str_replace ( '\\"', '"', $s );
		$s = preg_replace ( "/<\?=\\\$(.+?)\?>/", "{\$\\1}", $s );
		preg_match_all ( "/<\?=(.+?)\?>/e", $s, $constary );
		$constadd = '';
		$constary [1] = array_unique ( $constary [1] );
		foreach ( $constary [1] as $const ) {
			$constadd .= '$__' . $const . ' = ' . $const . ';';
		}
		$s = preg_replace ( "/<\?=(.+?)\?>/", "{\$__\\1}", $s );
		$s = str_replace ( '?>', "\n\$$var .= <<<EOF\n", $s );
		$s = str_replace ( '<?', "\nEOF;\n", $s );
		return "<?\n$constadd\$$var = <<<EOF\n" . $s . "\nEOF;\n?>";
	}
	function languagevar($var) {
		$vars = explode ( ':', $var );
		$isplugin = count ( $vars ) == 2;
		if (! $isplugin) {
			! isset ( $this->language ['inner'] ) && $this->language ['inner'] = array ();
			$langvar = & $this->language ['inner'];
		} else {
			! isset ( $this->language ['plugin'] [$vars [0]] ) && $this->language ['plugin'] [$vars [0]] = array ();
			$langvar = & $this->language ['plugin'] [$vars [0]];
			$var = & $vars [1];
		}
		
		if (isset ( $langvar [$var] )) {
			return $langvar [$var];
		} else {
			return '!' . $var . '!';
		}
	}
	function strexists($haystack, $needle) {
		return ! (strpos ( $haystack, $needle ) === FALSE);
	}
	function error($message, $tplname = null) {
		echo $message;
	}
}