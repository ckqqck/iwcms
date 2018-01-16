<?php
$config['wechat'] = array (
	'token' => 'newweixin', //填写你设定的key
	'encodingaeskey' => 'bgo3FhGIgYrzULLq5pexJ84QDYnD2fAT0GLNCQAGoGQ',
	'appid' => 'wxea5ced3ba4b9ceee', //填写高级调用功能的app id
	'appsecret' => '11451074b43da89fa0e0287ceb851459', //
	'urlcallback' => 'http://www.iwcms.cn/oauth/index', //
	'partnerid' => '88888888', //财付通商户身份标识
	'partnerkey' => '', //财付通商户权限密钥Key
	'paysignkey' => '', //商户签名密钥Key
	'debug' => true
);
$config['wechat_menu'] = array (
		 	    'button' => array (
				 	      0 => array (
						 	        'type' => 'view',
						 	        'name' => '代理平台',
						 	        'url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx69c834c96823d83e&redirect_uri=http://www.ty185.cn/shop/index&response_type=code&scope=snsapi_base&state=1#wechat_redirect'
						 	      ),
				 	      1 => array (
						 	        "type"=>"click",
          							"name"=>"生成海报",
         							"key"=>"V1001"
				 	      ),
				 	      2 => array (
						 	        'type' => 'view',
						 	        'name' => '个人中心',
						 	        'url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx69c834c96823d83e&redirect_uri=http://www.ty185.cn/user/index&response_type=code&scope=snsapi_base&state=1#wechat_redirect'
						 	      ),
				 	    ),
		 	);