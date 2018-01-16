<?php
class Upload extends CI_Controller {
	public $data = array();
	public function __construct() {
		parent::__construct ();
		$this->load->helper ( array (
				'form',
				'url' 
		) );
		$this->load->model ( 'Editor_model' );
	}
	public function img_list() {
		$this->data['result'] = $this->Editor_model->article_file_select();
		$this->load->view ( 'moreupload_list',$this->data );
	}
	public function more_upload() {
		$this->data['result'] = $this->Editor_model->article_file_select();
		//print_r($this->data['result']);
		$this->load->view ( 'moreupload_form',$this->data);
	}
	
	//多图片上传 layui 类
	//专用 ckedtor 编辑器
	// 返回值json
	public function layui_moreupload() {
		$filename = $this->_refilename ( 5 );
		$ymd = "uploads/" . date ( "Ym" ) . "/" . date ( "d" ) . "/";
		$path = FCPATH .  $ymd;
		$this->_createFolder ( $path );
		$config ['upload_path'] = $path;
		$config ['file_name'] = $filename;
		$config ['allowed_types'] = 'gif|jpg|png';
		$config ['max_size'] = '10000';
		$config ['max_width'] = '4000';
		$config ['max_height'] = '4000';
		$this->load->library ( 'upload', $config );
		$this->upload->initialize($config);
		
		//与网页 name 标签名要一致
		$field = "userfile";
		$count = count ( $_FILES ["$field"] ["name"] ); // 页面取的默认名称	
		
		$file_arr = array ();
		for($i = 0; $i < $count; $i ++) {
			// Give it a name not likely to already exist!
			$pseudo_field_name = $field . '_' . $i;
			$_FILES [$pseudo_field_name] = array (
					'name' => $_FILES [$field] ['name'] [$i],
					'size' => $_FILES [$field] ['size'] [$i],
					'type' => $_FILES [$field] ['type'] [$i],
					'tmp_name' => $_FILES [$field] ['tmp_name'] [$i],
					'error' => $_FILES [$field] ['error'] [$i]
			);
			
			
			//$string = var_export ( $_FILES, true );
			//file_put_contents ( FCPATH . "testpost_array.php", $string );
				
			if ($this->upload->do_upload ( $pseudo_field_name )) { // 默认名是:userfile
				$data = array (
					'upload_data' => $this->upload->data () 
				);
				if (isset ( $_GET ['aid'] )) {
					$data ['upload_data'] ['aid'] = $_GET ['aid'];
				}
				$get_img_info = $this->_getImageInfos ( $data ['upload_data'] ['full_path'] );
				$file_arr [$i]["code"] = 0;
				$file_arr [$i]["msg"] = "";
				$file_arr [$i]["data"]["id"] = $this->_pic_db($data, $ymd, $get_img_info);
				$file_arr [$i]["data"]["url"] = base_url(). $ymd . $data['upload_data']['file_name'];
			}else{
				$file_arr [$i]["code"] = 1;
				$file_arr [$i]["msg"] = $this->upload->display_errors ();
			}
		}
		echo json_encode($file_arr);
	}
	// echo json_encode ( _td_iconv($item2,'gb2312') );
	private function _td_iconv($data, $charset_from, $charset_to = 'UTF-8') {
		if (strtolower ( $charset_from ) == "gb2312") {
			$charset_from = "gbk";
		}
		if (strtolower ( $charset_from ) == strtolower ( $charset_to )) {
			return $data;
		}
		
		if (is_array ( $data )) {
			foreach ( $data as $k => $v ) {
				if (is_array ( $v )) {
					$data [$k] = $this->_td_iconv ( $v, $charset_from, $charset_to );
				} else {
					$data [$k] = is_string ( $v ) ? mb_convert_encoding ( $v, $charset_to, $charset_from ) : $v;
				}
			}
		} else {
			if (is_string ( $data ))
				$data = mb_convert_encoding ( $data, $charset_to, $charset_from );
		}
		return $data;
	}
	private function _pic_db($data,$path, $get_img_info) {
		if ($get_img_info ['type'] == "jpeg") {
			$get_img_info ['type'] = "jpg";
		}
		
		$user = $this->session->userdata ( 's_id' );
		
		$image_size ['aid'] = isset ( $data ['upload_data'] ['aid'] ) ? $data ['upload_data'] ['aid'] : 0;
		$image_size ['uid'] = isset ( $user->id ) ? $user->id : 0;
		$image_size ['dateline'] = time ();
		$image_size ['filename'] = $data ['upload_data'] ['client_name'];
		$image_size ['filetype'] = $data ['upload_data'] ['image_type'];
		$image_size ['filesize'] = $get_img_info ['size'];
		$image_size ['imgpath'] = $path . $data ['upload_data'] ['file_name'];
		$image_size ['remote'] = $data ['upload_data'] ['orig_name'];
		$image_size ['ext'] = $data ['upload_data'] ['file_ext'];
		$image_size ['path'] = $path;
		$image_size ['magicframe'] = $data ['upload_data'] ['raw_name'];
		
		return $this->Editor_model->qeditor_insert_file ( $image_size );
	}
	private function _getImageInfos($image) {
		/**
		 * $upimage = getimagesize ( $newpath .
		 *
		 *
		 * $data ['upload_data'] ['file_name'] );
		 *
		 * $string = var_export ( $upimage, true );
		 *
		 * file_put_contents ( FCPATH . "test1_array.php", $string );
		 */
		$imageInfo = getimagesize ( $image );
		switch ($imageInfo ['2']) {
			case 1 :
				$imtype = "gif";
				break;
			case 2 :
				$imtype = "jpeg";
				break;
			case 3 :
				$imtype = "png";
				break;
		}
		$img_size = ceil ( filesize ( $image ) / 1000 );
		$new_img_info = array (
				"width" => $imageInfo ['0'],
				"height" => $imageInfo ['1'],
				"type" => $imtype,
				"size" => $img_size 
		);
		return $new_img_info;
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
	/**
	 * 重命名文件
	 */
	private function _getName() {
		return time () . rand ( 1, 10000 ) . $this->_getFileExt ();
	}

	private function _createFolder($path) {
		if (! file_exists ( $path )) {
			$this->_createFolder ( dirname ( $path ) );
			if (! mkdir ( $path, 0777, true )) {
				return false;
			}
		}
	}
}
?>