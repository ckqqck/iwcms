<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Qqoauth {
	public function __construct() {
		$access_token = '';
		$this -> openid = '';
		$CI = &get_instance();
		$CI -> config -> load('login_qq');
		$this -> qq_set = $CI -> config -> item('inc_info');
	}
	public function wget_openid($code) {
		$url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id={$this->qq_set['appid']}&client_secret={$this->qq_set['appkey']}&code={$code}&redirect_uri={$this->qq_set['callback']}";
		
		$content = file_get_contents($url);
		if (stristr($content, 'access_token=')) {
			$params = explode('&', $content);
			$tokens = explode('=', $params[0]);
			$this -> access_token = $tokens[1];
			if ($this -> access_token) {
				$url = "https://graph.qq.com/oauth2.0/me?access_token=$this->access_token";
				$content = file_get_contents($url);
				
				$content = str_replace('callback( ', '', $content);

				$content = str_replace(' );', '', $content);

				$returns = json_decode($content);

				$openid = $returns -> openid;

				$this -> openid = $openid;

				$_SESSION["token2"] = $openid;

			} else {

				$openid = '';

			}

		} elseif (stristr($content, 'error')) {

			$openid = '';

		}
		return $openid;

	}
	public function redirect_to_login() {
		$redirect = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id={$this->qq_set['appid']}&scope=&redirect_uri={$this->qq_set['callback']}";
		header("Location:$redirect");
	}

	public function get_user_info() {
		$url = "https://graph.qq.com/user/get_user_info?access_token={$this->access_token}&oauth_consumer_key={$this->qq_set['appid']}&openid=$this->openid";
	
		$content = file_get_contents($url);
		
		$result = json_decode($content);
		
		return $result;
	}

}
?>