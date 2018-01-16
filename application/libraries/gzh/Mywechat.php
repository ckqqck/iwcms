<?php
include APPPATH . 'libraries/gzh/Wechatex.php';
class Mywechat extends Wechatex {
	private $_ci;
	function __construct($options) {
		parent::__construct ( $options );
		if (function_exists ( "get_instance" ) && defined ( "APPPATH" )) {
			$this->_ci = & get_instance ();
		}
	}
	private function _indb_openid($openid) {
		$this->_ci->load->model ( 'Token_model' );		
		//1.根据openid 判断是否用户在本地数据库中存在
		$is_openid = $this->_ci->Token_model->user_exist($openid);			
		
		if(!$is_openid){
			$user_info = $this->getUserInfo ( $openid );
			//$string = var_export ( $user_info, true );
			//file_put_contents ( FCPATH . "application/libraries/gzh/test_openid123.php", $string );
			
			$upid = $this->getRevEvent ();
			
			if ($upid && isset ( $upid ['key'] )) {
				$arr = explode ( "_", $upid ['key'] );
				if ($arr && isset ( $arr [1] )){
					$upid = $arr [1];
				}else{
					$upid = $upid ['key'];
				}
			} else {
				$upid = 1;
			}
			
			$this->_ci->Token_model->user_insert ( $this->get_db_openid ( $user_info, $upid ) );
		}
	}
	// 扫描 关注时的动作
	function onSubscribe() {
		$openid = $this->getRevFrom ();
		$this->_indb_openid($openid);
		$text = '关注成功，马上开启夺宝
			--------------------------
			>> <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxea5ced3ba4b9ceee&redirect_uri=http://www.ty185.cn/oauth/openid&response_type=code&scope=snsapi_base&state=1#wechat_redirect">点击进入【开启夺宝】</a>';
		$this->text ( $text )->reply ();
	}
	
	function onText() {
		$this->text ( '悄悄地我走了，正如我悄悄地来。' )->reply ();
	}
	function onUnsubscribe() {
		$this->text ( '悄悄地我走了，正如我悄悄地来。' )->reply ();
	}
	// 重新整合数据，优化数据
	private function get_db_openid($userinfo, $upid = 1) {
		$tel = $this->_creat_tel();
		$db_openid = array (
				'wx_openid' => $userinfo ['openid'],
				'wx_upid' => $upid,
				'wx_fopenid' => "",
				'wx_unionid' => $userinfo ['unionid'],
				'user_name' => $userinfo ['nickname'],
				'user_pass' => md5("iwcms".$tel),
				'user_tel' => "w".$tel,
				'user_img' => $userinfo ['headimgurl'],
				'user_regtime' => time (),
				'ip' => clientIP()
		);
		return $db_openid;
	}
	private function _creat_tel() {
		$arr = array(
				130,131,132,133,134,135,136,137,138,139,
				144,147,
				150,151,152,153,155,156,157,158,159,
				176,177,178,
				180,181,182,183,184,185,186,187,188,189,
		);
		$tmp = $arr[array_rand($arr)].mt_rand(1000,9999).mt_rand(1000,9999);
		return $tmp;
	}
	public function onClick() {
		$openid = $this->getRevFrom ();
		$this->_indb_openid($openid);
		$text = '马上开启夺宝
			--------------------------
			>> <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxea5ced3ba4b9ceee&redirect_uri=http://www.ty185.cn/oauth/openid&response_type=code&scope=snsapi_base&state=1#wechat_redirect">点击进入【开启夺宝】</a>';
		$this->text ( $text )->reply ();
	}

	// 以下是cache的保存，按照具体情形保存你的token，因为微信服务器规定token的获取次数是有限制的，不要请求太多次数。
	function setCache($cachename, $value, $expired) {
		$this->_ci->load->model ( 'Token_model' );
		$this->_ci->Token_model->set ( $cachename, array (
				'value' => $value,
				'expire_time' => time () + $expired
		) );
	}
	function getCache($cachename) {
		$this->_ci->load->model ( 'Token_model' );
		$data = $this->_ci->Token_model->get ( $cachename );
		if (empty ( $data ) || time () > $data [0] ['expire_time']) {
			return false;
		} else {
			return $data [0] ['value'];
		}
	}
	function removeCache($cachename) {
		$this->_ci->load->model ( 'Token_model' );
		$this->_ci->Token_model->remove ( $cachename );
	}
}