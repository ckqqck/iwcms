<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Oauth extends CI_Controller {
	private $reg_money = 2;
	private $sign_money = 0.1;
	function __construct() {
		parent::__construct ();
		$this->load->helper ( "url" );
		$this->load->library ( 'doosession', 'wYU9F2qtuXo6WK2x' );
	}
	function test() {
		if(!$this->doosession->openid){
			redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxea5ced3ba4b9ceee&redirect_uri=http://www.iwcms.cn/oauth/index&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', 'refresh');
		}else{
			echo $this->doosession->openid;
		}
	}
	function toupiao() {
		$aid = 2;
		$this->load->model ( 'Vote_model' );
		$data['xs'] = $this->Vote_model->item_select_where (array('id' => $aid));
		//print_r($data['xs']);
		$this->load->view("toupiao.html",$data);
	}
	function ajax_tp() {
		$re = array();
		$re['error'] = FALSE;
		$re['message'] = "投票成功";
		//传递 openid item_id 生成投票记录
		if (!$this->input->post('openid') && !$this->input->post('item_id')) {
			$re['error'] = TRUE;
			$re['message'] = "没有登录";
		}else{
			//判断是否今天投票了，一天一票，一天一人一票
			$openid = $this->input->post('openid');
			$item_id = $this->input->post('item_id');
			$this->_item_record_in($openid, $item_id);
			//数据递增1票
			$this->_item_up($item_id);
		}
		
		//返回json数据
		$this->load->helper('Json');
		throwJson($re);
		
	}
	private function _item_record_in($openid,$item_id) {
		$data = array(
				'item_id' => $item_id,
				'wecha_id' => $openid,
				'vid' => 0,
				'touched' => 1,
				'touch_time' => time(),
				'token' => 'Arraytoken',
		);
		$this->load->model ( 'Vote_model' );
		$this->Vote_model->item_record_insert($data);
	}
	private function _item_up($id) {
		$this->load->model ( 'Vote_model' );
		$this->Vote_model->item_update($id);
	}
	//网页授权方式  获取用户信息
	function index() {
		$this->config->load ( 'wechat' );
			
		$options = $this->config->item ( 'wechat' );
					
		$this->load->library ( 'gzh/weixins', $options );
		//获取openid
		$result = $this->weixins->getOauthAccessToken();
		if(!$result){
			return;
		}
		$openid = $result['openid'];
		//判断数据库是否存在该用户 如果不存在就 获取用户 并写入数据库  首次网页授权
		$this->load->model ( 'token_model' );
		if (!$this->token_model->openid_exist ( $openid )) {
			$userinfo = $this->weixins->getUserInfo($openid);
			if(!$userinfo){
				return;
			}
			$user = array (
					'headimgurl' => $userinfo ['headimgurl'],
					'openid' => $userinfo ['openid'],
					'name' => $userinfo ['nickname'],
					'roleId' => 4,
					'createdBy' => 1,
					'updatedBy' => 1,
					'createdDtm' => date("Y-m-d H:i:s")
			);
			// 写入用户信息
			$this->token_model->openid_insert ( $user );
			
		}
		$this->doosession->openid = $result['openid'];
	}

	public function ackk() {
		echo $this->session->userdata ( "access_token" );
	}
	public function menu() {
		$menus = $this->config->item ( 'wechat_menu' );

		$flag = $this->mywechat->createMenu ( $menus );
		echo ! $flag ? 'FALSE' : json_encode ( $menus );
	}
	function logdebug($text) {
		file_put_contents ( './upload/log.txt', $text . "\n", FILE_APPEND );
	}
	public function valid() {
		$echoStr = $_GET ["echostr"];
		// valid signature , option
		if ($this->checkSignature ()) {
			echo $echoStr;
			exit ();
		}
	}
	private function checkSignature() {
		$signature = $_GET ["signature"];
		$timestamp = $_GET ["timestamp"];
		$nonce = $_GET ["nonce"];
		$echoStr = $_GET ["echostr"];
		$token = "newweixin";
		$tmpArr = array (
				$token,
				$timestamp,
				$nonce
		);
		sort ( $tmpArr );
		$tmpStr = implode ( $tmpArr );
		$tmpStr = sha1 ( $tmpStr );

		if ($tmpStr == $signature) {
			return true;
		} else {
			return false;
		}
	}
}