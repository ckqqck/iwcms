<?php
class Weixins
{
	const API_URL_PREFIX = 'https://api.weixin.qq.com';//以下API接口URL需要使用此前缀
	const OAUTH_TOKEN_URL = '/sns/oauth2/access_token?';
	const OAUTH_REFRESH_URL = '/sns/oauth2/refresh_token?';
	const OAUTH_USERINFO_URL = '/sns/userinfo?';
	const OAUTH_AUTH_URL = '/sns/auth?';
	
	private $appid;
	private $appsecret;
	private $urlcallback;
	private $access_token;
	private $cachename;
	private $_ci;
	
	public function __construct($options)
	{
		$this->appid = isset($options['appid'])?$options['appid']:'';
		$this->appsecret = isset($options['appsecret'])?$options['appsecret']:'';
		$this->access_token = isset($options['access_token'])?$options['access_token']:'';
		$this->urlcallback = isset($options['urlcallback'])?$options['urlcallback']:false;
		$this->cachename = 'weixins_access_token_'.$this->appid;
		if (function_exists("get_instance") && defined("APPPATH")) {
			$this->_ci = & get_instance();
		}
	}
	public function getOauthAccessToken() {
		$code = isset ($_GET['code']) ? $_GET['code'] : '';
		if (!$code)
			return false;
			$result = $this->http_get(self :: API_URL_PREFIX . self :: OAUTH_TOKEN_URL . 'appid=' . $this->appid . '&secret=' . $this->appsecret . '&code=' . $code . '&grant_type=authorization_code');
			if ($result) {
				$json = json_decode($result, true);
				if (!$json || !empty ($json['errcode'])) {
					$this->errCode = $json['errcode'];
					$this->errMsg = $json['errmsg'];
					return false;
				}
				$this->access_token = $json['access_token'];
				return $json;
			}
			return false;
	}
	public function getUserInfo($openid){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::OAUTH_USERINFO_URL.'access_token='.$this->access_token.'&openid='.$openid);
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}
	
	/**
	 * 获取access_token
	 * @param string $appid 如在类初始化时已提供，则可为空
	 * @param string $appsecret 如在类初始化时已提供，则可为空
	 * @param string $token 手动指定access_token，非必要情况不建议用
	 */
	public function checkAuth($appid='',$appsecret='',$token=''){
		if (!$appid || !$appsecret) {
			$appid = $this->appid;
			$appsecret = $this->appsecret;
		}
		if ($token) { //手动指定token，优先使用
			$this->access_token=$token;
			return $this->access_token;
		}
	
		$rs = $this->getCache($this->cachename);
		if ($rs)  {
			$this->access_token = $rs;
			return $rs;
		}
		
		$code = isset ($_GET['code']) ? $_GET['code'] : '';
		
		if (!$code)
			return false;
		$result = $this->http_get(self :: API_URL_PREFIX . self :: OAUTH_TOKEN_URL . 'appid=' . $this->appid . '&secret=' . $this->appsecret . '&code=' . $code . '&grant_type=authorization_code');
		if ($result) {
			$json = json_decode($result, true);
			if (!$json || !empty ($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			$this->access_token = $json['access_token'];
			$this->setCache($this->access_token);
			return $this->access_token;
		}
		return false;
	}
	//以下是cache的保存，按照具体情形保存你的token，因为微信服务器规定token的获取次数是有限制的，不要请求太多次数。
	protected function setCache( $value, $expired = 7200) {
		$this->_ci->load->model('Token_model');
		$this->_ci->token_model->set($this->cachename, array (
				'value' => $value,
				'expire_time' => time() + $expired
		));
	}
	
	protected function getCache() {
		$this->_ci->load->model('token_model');
		$data = $this->_ci->token_model->get($this->cachename);
		if (empty ($data) || time() > $data[0]['expire_time'])
			return false;
		return $data[0]['value'];
	}
	
	protected function removeCache() {
		$this->_ci->load->model('Token_model');
		$this->_ci->token_model->remove($this->cachename);
	}
	/**
	 * GET 请求
	 * @param string $url
	 */
	private function http_get($url){
		$oCurl = curl_init();
		if(stripos($url,"https://")!==FALSE){
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
		}
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if(intval($aStatus["http_code"])==200){
			return $sContent;
		}else{
			return false;
		}
	}
	
	/**
	 * POST 请求
	 * @param string $url
	 * @param array $param
	 * @param boolean $post_file 是否文件上传
	 * @return string content
	 */
	private function http_post($url,$param,$post_file=false){
		$oCurl = curl_init();
		if(stripos($url,"https://")!==FALSE){
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
		}
		if (is_string($param) || $post_file) {
			$strPOST = $param;
		} else {
			$aPOST = array();
			foreach($param as $key=>$val){
				$aPOST[] = $key."=".urlencode($val);
			}
			$strPOST =  join("&", $aPOST);
		}
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($oCurl, CURLOPT_POST,true);
		curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if(intval($aStatus["http_code"])==200){
			return $sContent;
		}else{
			return false;
		}
	}
	
}