<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Caiji extends CI_Controller {
	public $data = array ();
	function __construct() {
		parent::__construct ();
		$this->load->helper ( 'url' );
	}

	function snoopy($url, $args = array()) {
		$this->load->library ( 'cj/Cj1' );
		$time_out = 15;
		$max_redirs = 3;
		$cache = 20 * 60;
		$content = "";
		if ($cache > 0 && $content = $this->cj1->load_cache ( $url )) {
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
				$content = $this->cj1->str_iconv ( $content );
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
					$snoopy->results = @gzdecode ( $snoopy->results ); // gzip
				
				$content = $this->cj1->str_iconv ( $snoopy->results );
			}
			
			if ($content)
				$this->cj1->cache_data ( $url, array (
						'content' => $content 
				), $cache );
			return $content;
		}
	}
	function download_img() {
		if (isset ( $_GET ['id'] ) && $_GET ['id'] && is_numeric ( $_GET ['id'] )) {
			$a = 0;
			// 从文章comment 获取 图片地址 并写入数据到img
			$this->_get_img_url ( $_GET ['id'] );
			
			$this->load->model ( 'cj/Cj_model' );
			$where = array (
					"uid" => $_GET ['id'],
					"isimage" => 0 
			);
			// 从文章img 获取 图片地址
			$re_img = $this->Cj_model->select_img ( $where );
			if (! $re_img) {
				$massage = "没有采集的图片!<br>";
				$this->_cjjs_show ( $massage );
				return;
			}
			foreach ( $re_img as $v ) {
				$newimgurl = $this->ueditor_down ( $v->url, $v->img_url, $v->tid );
				if (! $newimgurl || $newimgurl == "") {
					$datas ['isimage'] = 2;
					$this->Cj_model->update_img ( array (
							"img_url" => $v->img_url 
					), $datas );
				}else{
					$datas ['isimage'] = 1;
					$datas ['img_path'] = $newimgurl;
					$this->Cj_model->update_img ( array (
							"img_url" => $v->img_url
					), $datas );
				}
				$a += 1;
			}
			$massage = "采集成功" . $a . "条!<br>";
			$this->_cjjs_show ( $massage );
		}
	}
	function ueditor_down($url, $imgUrl, $tid) {
		$imgUrl = htmlspecialchars ( $imgUrl );
		$imgUrl = str_replace ( "&amp;", "&", $imgUrl );
		
		// http开头验证
		if (strpos ( $imgUrl, "http" ) !== 0) {
			$this->stateInfo = "ERROR_HTTP_LINK";
			return;
		}
		
		preg_match ( '/(^https*:\/\/[^:\/]+)/', $imgUrl, $matches );
		$host_with_protocol = count ( $matches ) > 1 ? $matches [1] : '';
		
		// 判断是否是合法 url
		if (! filter_var ( $host_with_protocol, FILTER_VALIDATE_URL )) {
			$this->stateInfo = "INVALID_URL";
			return;
		}
		
		preg_match ( '/^https*:\/\/(.+)/', $host_with_protocol, $matches );
		$host_without_protocol = count ( $matches ) > 1 ? $matches [1] : '';
		
		// 此时提取出来的可能是 ip 也有可能是域名，先获取 ip
		$ip = gethostbyname ( $host_without_protocol );
		// 判断是否是私有 ip
		if (! filter_var ( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE )) {
			$this->stateInfo = "INVALID_IP";
			return;
		}
		
		// 获取请求头并检测死链
		$heads = get_headers ( $imgUrl, 1 );
		if (! (stristr ( $heads [0], "200" ) && stristr ( $heads [0], "OK" ))) {
			$this->stateInfo = "ERROR_DEAD_LINK";
			return;
		}
		// 格式验证(扩展名验证和Content-Type验证)
		$fileType = strtolower ( strrchr ( $imgUrl, '.' ) );
		
		if (! in_array ( $fileType, array (
				".png",
				".jpg",
				".jpeg",
				".gif",
				".bmp" 
		) ) || ! isset ( $heads ['Content-Type'] ) || ! stristr ( $heads ['Content-Type'], "image" )) {
			$this->stateInfo = "ERROR_HTTP_CONTENTTYPE";
			return;
		}
		// 打开输出缓冲区并获取远程图片
		ob_start ();
		$context = stream_context_create ( array (
				'http' => array (
						'follow_location' => false 
				) // don't follow redirects
 
		) );
		readfile ( $imgUrl, false, $context );
		$img = ob_get_contents ();
		ob_end_clean ();
		preg_match ( "/[\/]([^\/]*)[\.]?[^\.\/]*$/", $imgUrl, $m );
		
		// 检查文件大小是否超出限制
		
		// 创建目录失败
		
		$ymd = date ( "Ymd" ) . "/" . $tid . "/";
		$attach_dir = FCPATH . "upload/cj/" . $ymd;
		$this->createFolder ( $attach_dir );
		
		$save_name = $this->_refilename ( 5 ) . $fileType;
		
		// 移动文件
		if (! (file_put_contents ( $attach_dir . $save_name, $img ) && file_exists ( $attach_dir . $save_name ))) { // 移动失败
			$this->stateInfo = "ERROR_WRITE_CONTENT";
		} else { // 移动成功
			return "upload/cj/" . $ymd . $save_name;
		}
	}
	// 图片最好的命名文件
	private function _refilename($length = 24) {
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$password = '';
		for($i = 0; $i < $length; $i ++) {
			$password .= $chars [mt_rand ( 0, strlen ( $chars ) - 1 )];
		}
		return $password;
	}
	function createFolder($path) {
		if (! file_exists ( $path )) {
			$this->createFolder ( dirname ( $path ) );
			if (! mkdir ( $path, 0777, true )) {
				return false;
			}
		}
	}
	function macth_img() {
		$id = $this->input->get ( 'id' );
		if (is_numeric ( $id )) {
			
			$a = 0;
			$b = 0;
			$this->load->model ( 'cj/Cj_model' );
			
			$where = array (
					"uid" => $id,
					"is_in_comment" => 0,
					"is_exist_pic" => 1,
					"is_match_pic" => 1 
			);
			$comment = $this->Cj_model->select_comment_in ( $where );
			if (! $comment) {
				$massage = "没有替换的内容!<br>";
				$this->_cjjs_show ( $massage );
				return;
			}
			foreach ( $comment as $v ) {
				// 从img 获取 图片地址
				$re_img = $this->Cj_model->select_img ( array (
						"tid" => $v ['id'],
						"isimage" => 1 
				) );
				
				if ($re_img) {
					foreach ( $re_img as $vs ) {
						$imgold [] = trim ( $vs->img_url1 );
						$saveimgfile [] = base_url().trim ( $vs->img_path );
					}
					$newcomment = str_replace ( $imgold, $saveimgfile, $v ['comment'] );
					$data ['comment'] = $newcomment;
					$data ['pic'] = trim ( $vs->img_path );
					$this->Cj_model->update_comment ( array (
							"id" => $v ['id'] 
					), $data );
					
					$datas ['is_in_comment'] = 1;
					$this->Cj_model->update_img ( array (
							"tid" => $v ['id'] 
					), $datas );
					$a += 1;
				} else {
					$b += 1;
				}
			}
			
			$massage = "采集成功" . $a . "条!<br>";
			$massage .= "采集失败" . $b . "条!<br>";
			$this->_cjjs_show ( $massage );
		}
	}
	private function _down($url, $img_url, $tid) {
		$this->load->library ( 'cj/Cj_img' );
		
		$attach_info = $this->cj_img->get_img_content ( $img_url, 1, array (
				'referer' => $url,
				'is_set_referer' => 1 
		) );
		if ($attach_info ['file_size'] && strlen ( $attach_info ['content'] )) {
			
			$ymd = date ( "Ymd" ) . "/" . $tid . "/";
			$attach_dir = FCPATH . "upload/cj/" . $ymd;
			$this->cj_img->createFolder ( $attach_dir );
			
			$hash = substr ( md5 ( $attach_info ['content'] ), 3, 10 );
			
			$save_name = $hash . '.' . $attach_info ['file_ext'];
			// echo $save_name."<br>";
			file_put_contents ( $attach_dir . '/' . $save_name, $attach_info ['content'] );
			$isimage = $this->cj_img->pis_image_ext ( $attach_info ['file_ext'] ) ? 1 : 0;
			
			$setarr = array (
					'img_path' => "/upload/cj/" . $ymd,
					'hash_name' => $hash,
					'file_ext' => $attach_info ['file_ext'],
					'save_name' => $save_name,
					'file_name' => $attach_info ['file_name'],
					'filesize' => $attach_info ['file_size'],
					'description' => "",
					'isimage' => $isimage 
			);
			
			return $setarr;
		} else {
			
			return false;
		}
	}
	private function _get_img_url($uid) {
		$this->load->library ( 'cj/Cj_img' );
		$this->load->model ( 'cj/Cj_model' );
		$result = $this->Cj_model->select_comment_in ( array (
				"uid" => $uid,
				"is_in_comment" => 0,
				"is_match_pic" => 0,
				"is_exist_pic" => 0 
		) );
		$data = array ();
		foreach ( $result as $v ) {
			$data ['tid'] = $v ['id'];
			$data ['uid'] = $v ['uid'];
			$data ['url'] = $v ['url'];
			$data ['description'] = $v ['title'];
			$img_url = $this->cj_img->get_article_attach ( $v ['comment'], 1, $v ['url'] );
			$data ['last_date'] = time ();
			if ($img_url) {
				foreach ( $img_url as $vs ) {
					$data ['img_url'] = $vs [1];
					$data ['img_url1'] = $vs [2];
					
					$where ['img_url'] = $vs [1];
					if (! $this->Cj_model->select_article_img_count ( $where )) {
						$this->Cj_model->insert_img ( $data );
					}
				}
				$where = array (
						'id' => $v ['id'] 
				);
				$match_pic = array (
						"is_match_pic" => 1,
						"is_exist_pic" => 1 
				);
				$this->Cj_model->update_comment ( $where, $match_pic );
			} else {
				$where = array (
						'id' => $v ['id'] 
				);
				$match_pic = array (
						"is_exist_pic" => 2 
				);
				$this->Cj_model->update_comment ( $where, $match_pic );
			}
		}
	}
	
	// $db_title_start $db_title_end
	// $db_comment_start $db_comment_end
	// $db_time_start $db_time_end
	// $db_form_start $db_form_end
	// $db_author_start $db_author_end
	private function _comment_CJ($url, $re) {
		$cj = true;
		$massage = "采集成功！";
		$t = true;
		$c = true;
		$this->load->library ( 'cj/Cj' );
		$result = $this->snoopy ( $url );
		if (! $result) {
			return false;
		}
		$comment = array ();
		// 获取title return array $db_title_start $db_title_end
		$title = "";
		if ($re->db_title_dom_on) {
			$title = $this->_dom_url_cj ( $result, $re->db_title_dom, "replys", 2 );
		}
		if ($re->db_title_str && ! $title) {
			$title = $this->cj->pregmessage ( $result, trim ( $re->db_title_str ), "title", 0 );
		}
		if (! $title) {
			return false;
		}
		$comment ['title'] = $this->cj->_striptext ( $title [0] );
		
		// 获取comment return array $db_title_start $db_title_end
		$comments = "";
		// 是否获取分页
		if ($re->db_page) {
			$this->load->library ( "cj/page_caiji" );
			$comments = $this->page_caiji->get_content ( $result, $re, $url );
		} else {
			if ($re->db_comment_dom_on) {
				$comments = $this->_dom_url_cj ( $result, trim ( $re->db_comment_dom ), "", 2 );
			}
			if ($re->db_comment_str && ! $comments) {
				$comments = $this->cj->pregmessage ( $result, trim ( $re->db_comment_str ), "comment", - 1 );
			}
		}
		
		if (! $comments) {
			return false;
		}
		//过滤 <a <script
		$comment ['comment'] = $this->cj->del_href ( $comments [0] );
		
		return $comment;
	}
	
	// $b_listconment
	// $uid
	// $click_start $click_end
	// $click_bh
	// $click_nobh
	// $a_bi $a_chaone $a_chanum $a_chacommon
	// $a_bi $a_bione $a_binum $a_bicommon
	private function _listurl_CJ($url, $re) {
		$result = $this->snoopy ( $url );
		
		if (! $result) {
			return false;
		}
		$this->load->library ( 'cj/Cj' );
		$results = "";
		// 两标签之间的值 return array $click_start $click_end
		if ($re->dom == 0) {
			$results = $this->_dom_url_cj ( $result, $re->click_dom, 1, 2 );
		} else if ($re->click_str) {
			if ($re->click_str) {
				$results = $this->cj->pregmessage ( $result, trim ( $re->click_str ), "click", - 1 );
			}
		}
		
		$result_url = array ();
		// 获取链接 return array
		if ($results) {
			foreach ( $results as $v ) {
				$result_url [] = $this->cj->striplinks ( $v );
			}
			// 二维数组转一维数组
			$result_url = $this->cj->_arr_foreach ( $result_url );
			
			// 过滤数组里边的重复
			$result_url = $this->cj->_arrayUnique ( $result_url );
			
			// 链接中必须包含 $click_bh
			if ($re->click_bh) {
				$result_url = $this->cj->_str_Yes ( $result_url, trim ( $re->click_bh ) );
			}
			
			// 链接中不得出现 $click_nobh
			if ($re->click_nobh) {
				$result_url = $this->cj->_str_No ( $result_url, trim ( $re->click_nobh ) );
			}
			// 删除键值 重新排列数组
			$result_url = array_values ( $result_url );
			// 自定义主机名
			if ($re->click_host) {
				$result_url = $this->cj->_add_host ( $result_url, trim ( $re->click_host ) );
			}
		}
		// $text = $this->snoopy->_striptext($result);
		return $result_url;
	}
	// dom获取多个内容段
	private function _dom_url_cj($str, $dom_rules, $filter_type = 'replys', $count = 0) {
		$dom = get_htmldom_obj ( $str );
		
		$count = intval ( $count );
		
		if (! $count)
			return false;
		$text_arr = array ();
		if (! $dom)
			return false;
		foreach ( $dom->find ( $dom_rules ) as $k => $v ) {			
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
	function www_comment() {
		$this->load->model ( 'cj/Cj_model' );
		$a = 0;
		$b = 0;
		$c = 0;
		if (isset ( $_GET ['id'] ) && $_GET ['id'] && is_numeric ( $_GET ['id'] )) {
			$this->load->library ( 'cj/Cj' );
			$result_url = $this->Cj_model->select_urllist_db ( array (
					'uid' => $_GET ['id'] 
			) );
			$result = $this->Cj_model->select ( array (
					'id' => $_GET ['id'] 
			) );
			if ($result_url) {
				if ($result) {
					if (isset ( $_GET ['test'] ) && $_GET ['test'] == true) {
						foreach ( $result_url as $k => $v ) {
							if ($k == 1) {
								break;
							}
							$where = array (
									"url" => $v->url 
							);
							$re = $this->_comment_CJ ( $v->url, $result [0] );
							if ($re) {
								$this->_te_comment ( $v->url, $re );
							} else {
								$this->_cjjs_show ( "内容采集失败！！！" );
							}
						}
					} else {
						foreach ( $result_url as $v ) {
							$where = array (
									"url" => $v->url 
							);
							$is = $this->Cj_model->select_comment_count ( $where );
							if (! $is) {
								$re = $this->_comment_CJ ( $v->url, $result [0] );
								if ($re) {
									if ($this->_insert_comment ( $result [0], $v->url, $re )) {
										$a += 1;
									}
								} else {
									$c += 1;
								}
							} else {
								$b += 1;
							}
						}
						$massage = "采集成功" . $a . "条!<br>";
						$massage .= "采集失败" . $c . "条!<br>";
						$massage .= "过滤重复" . $b . "条!<br>";
						$this->_cjjs_show ( $massage );
					}
				} else {
					$this->_cjjs_show ( "没有采集数据！！！" );
				}
			} else {
				$this->_cjjs_show ( "网址末采集！！！" );
			}
		}
	}
	private function _insert_comment($re, $url, $result) {
		$this->load->model ( 'admin/Cj_model' );
		$data ['uid'] = isset ( $re->id ) ? $re->id : '0';
		$data ['cat_id'] = isset ( $re->cat_id ) ? $re->cat_id : '1';
		$data ['url'] = isset ( $url ) ? $url : '';
		$data ['title'] = isset ( $result ['title'] ) ? $result ['title'] : '';
		$data ['comment'] = isset ( $result ['comment'] ) ? $result ['comment'] : '';
		$data ['form'] = isset ( $result ['form'] ) ? $result ['form'] : '0';
		$data ['author'] = isset ( $result ['author'] ) ? $result ['author'] : '0';
		$data ['late_date'] = time ();
		return $this->Cj_model->insert_comment ( $data );
	}
	function www() {
		$this->load->library ( 'cj/Cj' );
		if (isset ( $_GET ['id'] ) && $_GET ['id'] && is_numeric ( $_GET ['id'] )) {
			$this->load->model ( 'cj/Cj_model' );
			$result = $this->Cj_model->select ( array (
					'id' => $_GET ['id'] 
			) );
			// uid=1 单条网址 ; uid=2 导入网址 ; uid=3 多条规则网址 ;
			if ($result [0]->uid == 1) {
				if ($this->cj->IsURL ( $result [0]->b_listconment )) {
					$ex = $this->cj->IsEx ( "\n", $result [0]->b_listconment );
					// 过滤重复及不合法url;
					$url = $this->cj->forurl ( $this->cj->arrayUnique ( $ex ) );
					if ($url) {
						// 现在可以采集网址列表了
						foreach ( $url as $k => $v ) {
							$url = $this->_listurl_CJ ( $v, $result [0] );
						}
						if (isset ( $_GET ['test'] ) && $_GET ['test'] == true) {
							
							$this->_te_list ( $url );
						} else {
							$this->_insert_urllist ( $url, $result [0]->id );
						}
					}
				} else {
					$this->_cjjs_show ( "单条网址格式出错" );
				}
			} elseif ($result [0]->uid == 2) {
				$this->_cjjs_show ( "正在开发中" );
			} elseif ($result [0]->uid == 3) {
				if ($this->cj->IsCJ ( $result [0]->a_www )) {
					if ($result [0]->a_bi == 1) {
						$url = $result [0]->a_www;
						$s = $result [0]->a_chaone;
						$n = $result [0]->a_chanum;
						$c = $result [0]->a_chacommon;
						$url = $this->cj->dengCha_url ( $url, $s, $n, $c );
						
						if ($url) {
							foreach ( $url as $v ) {
								$urls = $this->_listurl_CJ ( $v, $result [0] );
							}
							// 有病备份
							$urls = $this->cj->_arr_foreachs ( $urls );
							
							if (isset ( $_GET ['test'] ) && $_GET ['test'] == true) {
								$this->_te_list ( $urls );
							} else {
								$this->_insert_urllist ( $urls, $result [0]->id );
							}
						}
					} elseif ($result [0]->a_bi == 2) {
						$url = $result [0]->a_www;
						$s = $result [0]->a_bione;
						$n = $result [0]->a_binum;
						$c = $result [0]->a_bicommon;
						$url = $this->cj->dengBi_url ( $url, $s, $n, $c );
						if ($url) {
							foreach ( $url as $v ) {
								$url = $this->_listurl_CJ ( $v, $result [0] );
							}
							if (isset ( $_GET ['test'] ) && $_GET ['test'] == true) {
								$this->_te_list ( $url );
							} else {
								$this->_insert_urllist ( $url, $result [0]->id );
							}
						}
					}
				} else {
					$this->_cjjs_show ( "地址格式规则出错！！！" );
				}
			}
		}
	}
	private function _cjjs_show($str = "提示错误") {
		$smiliestype = '<h3 class="flb" id="e_image_ctrl" style="margin-top: 0px; margin-bottom: 0px; cursor: move;">';
		$smiliestype .= '<em id="return_showblock" fwin="showblock">采集测试</em>';
		$smiliestype .= '<span class="flbc" onclick="hideWindow(\'testcj\')">关闭</span></h3><div class="caiji">';
		if ($str) {
			$smiliestype .= "<li>" . $str . "</li>";
		}
		$smiliestype .= '</div>';
		out_xml ( $smiliestype );
	}
	private function _te_list($array = array()) {
		$smiliestype .= '<ul class="list-group">';
		if ($array) {
			foreach ( $array as $k => $v ) {
				$smiliestype .= '<li class="list-group-item">' . $v . '</li>';
				if ($k == 15) {
					$smiliestype .= '<li class="list-group-item">后面的省略</li>';
					break;
				}
			}
		} else {
			$smiliestype .= "<li>采集的数据为空……</li>";
		}
		$smiliestype .= '</ul>';
		out_xml ( $smiliestype );
	}
	private function _te_comment($url, $array = array()) {
		$smiliestype = '<h3 class="flb" id="e_image_ctrl" style="margin-top: 0px; margin-bottom: 0px; cursor: move;">';
		$smiliestype .= '<em id="return_showblock" fwin="showblock">测试采集</em>';
		$smiliestype .= '<span class="flbc" onclick="hideWindow(\'testcj\')">关闭</span></h3><div class="caiji">';
		if ($array) {
			$smiliestype .= '<h2><strong>测试地址：</strong>' . $url . '</h2>';
			$smiliestype .= '<h3><strong>标题：</strong>' . $array ['title'] . '</h3>';
			$smiliestype .= '<div><strong>内容：</strong>' . $array ['comment'] . '</div>';
		} else {
			$smiliestype .= "<div>采集的数据为空……</div>";
		}
		
		$smiliestype .= '</div><p class="o pns">';
		$smiliestype .= '<button id="report_submit" type="submit" class="pn pnc" fwin="testcj"  onclick="hideWindow(\'testcj\')"><strong>确定</strong></button></p>';
		
		out_xml ( $smiliestype );
	}
	private function _insert_urllist($url, $id) {
		$this->load->model ( 'admin/Cj_model' );
		$a = 0;
		$b = 0;
		if ($url && $id) {
			$data ['uid'] = $id;
			$data ['late_date'] = time ();
			foreach ( $url as $v ) {
				$data ['url'] = $v;
				$where ['url'] = $v;
				$is = $this->Cj_model->select_urllist ( $where );
				if (! $is) {
					$this->Cj_model->insert_urllist ( $data );
					$a += 1;
				} else {
					$b += 1;
				}
			}
		}
		$smiliestype = '<h3 class="flb" id="e_image_ctrl" style="margin-top: 0px; margin-bottom: 0px; cursor: move;">';
		$smiliestype .= '<em id="return_showblock" fwin="showblock">采集测试</em>';
		$smiliestype .= '<span class="flbc" onclick="hideWindow(\'testcj\')">关闭</span></h3><div class="caiji">';
		$smiliestype .= "<p>写入成功<span>" . $a . "</span>条！</p><p>过滤重复<span>" . $b . "</span>条！</p>";
		$smiliestype .= '</div><p class="o pns">';
		$smiliestype .= '<button id="report_submit" type="submit" class="pn pnc" fwin="testcj"  onclick="hideWindow(\'testcj\')"><strong>确定</strong></button></p>';
		
		out_xml ( $smiliestype );
	}
	function post() {
		if (isset ( $_GET ['id'] ) && $_GET ['id'] && is_numeric ( $_GET ['id'] )) {
			$this->load->model ( 'cj/Cj_model' );
			$result = $this->Cj_model->select_comment_in ( array (
					"uid" => $_GET ['id'],
					"is_in_comment" => 0
			) );
			$a = 0;
			$b = 0;
			$c = 0;
			foreach ( $result as $k => $v ) {
				$re = $this->Cj_model->select_article_title_count ( $v ['url'] );
				if (! $re) {
					if ($this->_instart ( $v )) {
						$a += 1;
					} else {
						$c += 1;
					}
				} else {
					$b += 1;
				}
			}
			$massage = "发布成功" . $a . "条!<br>";
			$massage .= "发布失败" . $c . "条!<br>";
			$massage .= "过滤重复" . $b . "条!<br>";
			$this->_cjjs_show ( $massage );
		}
	}
	private function _instart($content) {
		$this->load->library ( 'admin/Str' );
		$content ['summary'] = $this->str->portalcp_get_summary ( $content ['comment'] );
		$insert_struct = array (
				'user_id' => $content ['uid'],
				'catid' => 1,
				'title' => empty ( $content ['title'] ) ? NULL : $content ['title'],
				'summary' => isset ( $content ['summary'] ) ? $content ['summary'] : 'www.fffhh.com www.hhuuu.com',
				'imgurl' => empty ( $content ['pic'] ) ? "" : $content ['pic'],
				'click' => 0,
				'hotnum' => 1,
				'del' => 0,
				'created_at' => time(),
				'updated_at' => time(),
				'cj_url' => $content ['url']
		);
		
		/**
		 * 核心数据进主库
		 */

		$this->load->model ( 'admin/Blog_model' );
		$aid = $this->Blog_model->insert_title($insert_struct);
		if (!$aid){
			return false;
		}
		
		//标记 采集文章已发布
		$this->load->model ( 'cj/Cj_model' );
		$data ['is_in_comment'] = 1;
		$this->Cj_model->update_comment ( array (
			"url" => $content ['url'] 
		), $data );
		
		$conment = array();
		$conment['aid'] = $aid;
		$conment['body'] = $content ['comment'];
		return $this->Blog_model->insert_body($conment);
	}

	private function _convertrule($rule) {
		$rule = preg_quote ( $rule, "/" );
		$rule = str_replace ( '\*', '.*?', $rule );
		$rule = str_replace ( "\(.*?\)", '(.*?)', $rule );
		
		return $rule;
	}
}