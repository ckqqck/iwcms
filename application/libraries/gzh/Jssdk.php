<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Jssdk {
  private $appId;
  private $appSecret;
  private $key;
  private $mch_id;
  protected $CI;
  public function __construct() {
  	$this->CI =& get_instance();
  	$this->CI->config->load ( 'jssdk' );
  	$app = $this->CI->config->item ( 'jssdk' );
  	
    $this->appId = $app['appId'];
    $this->appSecret = $app['appSecret'];
    $this->mch_id = $app['mch_id'];
    $this->key = $app['key'];
  }
  
  public function createJsBizPackage($totalFee, $outTradeNo, $orderName, $notifyUrl, $timestamp)
  {
  	$config = array(
  			'mch_id' => $this->mch_id,
  			'appid' => $this->appId,
  			'key' => $this->key,
  	);
  	$unified = array(
  			'appid' => $config['appid'],
  			'body' => $orderName,
  			'mch_id' => $config['mch_id'],
  			'nonce_str' => $this->createNonceStr(),
  			'notify_url' => $notifyUrl,
  			//'openid' => $openid,            //rade_type=JSAPI，此参数必传
  			'out_trade_no' => $outTradeNo,
  			'spbill_create_ip' => '127.0.0.1',
  			'total_fee' => intval($totalFee * 100),       //单位 转为分
  			'trade_type' => 'NATIVE',
  	);
  	$unified['sign'] = $this->getSign($unified, $config['key']);
  	
  	$responseXml = $this->curlPost('https://api.mch.weixin.qq.com/pay/unifiedorder', $this->arrayToXml($unified));

  	$unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
  	
  	if ($unifiedOrder === false) {
  		die('parse xml error');
  	}
  	if ($unifiedOrder->return_code != 'SUCCESS') {
  		die($unifiedOrder->return_msg);
  	}
  	if ($unifiedOrder->result_code != 'SUCCESS') {
  		die($unifiedOrder->err_code);
  		
  	}
  	//$unifiedOrder->trade_type 交易类型 调用接口提交的交易类型，取值如下：JSAPI，NATIVE，APP
  	//$unifiedOrder->prepay_id 预支付交易会话标识 微信生成的预支付回话标识，用于后续接口调用中使用，该值有效期为2小时
  	//$unifiedOrder->code_url 二维码链接 trade_type为NATIVE是有返回，可将该参数值生成二维码展示出来进行扫码支付
  	$code_list = (array)$unifiedOrder->code_url;
  	$arr = array(
  			"appId" => $config['appid'],
  			"timeStamp" => $timestamp,
  			"nonceStr" => $this->createNonceStr(),
  			"package" => "prepay_id=" . $unifiedOrder->prepay_id,
  			"signType" => 'MD5',
  			"code_url" => $code_list[0]
  	);
  	$arr['paySign'] = $this->getSign($arr, $config['key']);
  	return $arr;
  }
  
  
  /**
   * @param string $openid 调用【网页授权获取用户信息】接口获取到用户在该公众号下的Openid
   * @param float $totalFee 收款总费用 单位元
   * @param string $outTradeNo 唯一的订单号
   * @param string $orderName 订单名称
   * @param string $notifyUrl 支付结果通知url 不要有问号
   *   https://mp.weixin.qq.com/ 微信支付-开发配置-测试目录
   *   测试目录 http://mp.izhanlue.com/paytest/  最后需要斜线，(需要精确到二级或三级目录)
   * @return string
   */
  public function createJsBizPackages($openid, $totalFee, $outTradeNo, $orderName, $notifyUrl, $timestamp,$attach = "自定义数据")
  {
  	$config = array(
  			'mch_id' => $this->mch_id,
  			'appid' => $this->appId,
  			'key' => $this->key,
  	);
  	$unified = array(
  			'appid' => $config['appid'],
  			'attach' => $attach,             //商家数据包，原样返回
  			'body' => $orderName,
  			'mch_id' => $config['mch_id'],
  			'nonce_str' => $this->createNonceStr(),
  			'notify_url' => $notifyUrl,
  			'openid' => $openid,            //rade_type=JSAPI，此参数必传
  			'out_trade_no' => $outTradeNo,
  			'spbill_create_ip' => clientIP(),
  			'total_fee' => intval($totalFee * 100),       //单位 转为分
  			'trade_type' => 'JSAPI',
  	);
  	$unified['sign'] = $this->getSign($unified, $config['key']);
  	$responseXml = $this->curlPost('https://api.mch.weixin.qq.com/pay/unifiedorder', $this->arrayToXml($unified));
  
  	$unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
  	
  	if ($unifiedOrder === false) {
  		die('parse xml error');
  	}
  	if ($unifiedOrder->return_code != 'SUCCESS') {
  		die($unifiedOrder->return_msg);
  	}
  	if ($unifiedOrder->result_code != 'SUCCESS') {
  		die($unifiedOrder->err_code);
  		/*
  		 NOAUTH 商户无此接口权限
  		 NOTENOUGH 余额不足
  		 ORDERPAID 商户订单已支付
  		 ORDERCLOSED 订单已关闭
  		 SYSTEMERROR 系统错误
  		 APPID_NOT_EXIST   APPID不存在
  		 MCHID_NOT_EXIST MCHID不存在
  		 APPID_MCHID_NOT_MATCH appid和mch_id不匹配
  		 LACK_PARAMS 缺少参数
  		 OUT_TRADE_NO_USED 商户订单号重复
  		 SIGNERROR 签名错误
  		 XML_FORMAT_ERROR XML格式错误
  		 REQUIRE_POST_METHOD 请使用post方法
  		 POST_DATA_EMPTY post数据为空
  		 NOT_UTF8 编码格式错误
  		 */
  	}
  	//$unifiedOrder->trade_type 交易类型 调用接口提交的交易类型，取值如下：JSAPI，NATIVE，APP
  	//$unifiedOrder->prepay_id 预支付交易会话标识 微信生成的预支付回话标识，用于后续接口调用中使用，该值有效期为2小时
  	//$unifiedOrder->code_url 二维码链接 trade_type为NATIVE是有返回，可将该参数值生成二维码展示出来进行扫码支付
  	$arr = array(
  			"appId" => $config['appid'],
  			"timeStamp" => $timestamp,
  			"nonceStr" => $this->createNonceStr(),
  			"package" => "prepay_id=" . $unifiedOrder->prepay_id,
  			"signType" => 'MD5',
  	);
  	$arr['paySign'] = $this->getSign($arr, $config['key']);
  	return $arr;
  }
  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
    $signature = sha1($string);
    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents(FCPATH ."jsapi_ticket.json"));
    if (!isset($data)) {
      $accessToken = $this->getAccessToken();
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->curlGet($url));
      $ticket = $res->ticket;
      if ($ticket) {
        $data->expire_time = time() + 7000;
        $data->jsapi_ticket = $ticket;
        $fp = fopen(FCPATH ."jsapi_ticket.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    } else {
      $ticket = $data->jsapi_ticket;
    }

    return $ticket;
  }

  private function getAccessToken() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents(FCPATH ."access_token.json"));
    if (!isset($data)) {
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      
      $res = json_decode($this->curlGet($url));
      $access_token = $res->access_token;
      if ($access_token) {
        $data->expire_time = time() + 7000;
        $data->access_token = $access_token;
        $fp = fopen(FCPATH ."access_token.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    } else {
      $access_token = $data->access_token;
    }
    return $access_token;
  }

  
  	public function notify()
  	{
  		$config = array(
  				'mch_id' => $this->mch_id,
  				'appid' => $this->appId,
  				'key' => $this->key,
  		);
  		if(!isset($GLOBALS["HTTP_RAW_POST_DATA"])){
  			die('parse json error');
  		}
  		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
  		
  		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
  		if ($postObj === false) {
  			die('parse xml error');
  		}
  		if ($postObj->return_code != 'SUCCESS') {
  			die($postObj->return_msg);
  		}
  		if ($postObj->result_code != 'SUCCESS') {
  			die($postObj->err_code);
  		}
  		$arr = (array)$postObj;
  		unset($arr['sign']);
  		if ($this->getSign($arr, $config['key']) == $postObj->sign) {
  			// $mch_id = $postObj->mch_id; //微信支付分配的商户号
  			// $appid = $postObj->appid; //微信分配的公众账号ID
  			// $openid = $postObj->openid; //用户在商户appid下的唯一标识
  			// $transaction_id = $postObj->transaction_id;//微信支付订单号
  			// $out_trade_no = $postObj->out_trade_no;//商户订单号
  			// $total_fee = $postObj->total_fee; //订单总金额，单位为分
  			// $is_subscribe = $postObj->is_subscribe; //用户是否关注公众账号，Y-关注，N-未关注，仅在公众账号类型支付有效
  			// $attach = $postObj->attach;//商家数据包，原样返回
  			// $time_end = $postObj->time_end;//支付完成时间
  			echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
  			return $postObj;
  		}
  	}
  	/**
  	 * curl get
  	 *
  	 * @param string $url
  	 * @param array $options
  	 * @return mixed
  	 */
  	public static function curlGet($url = '', $options = array())
  	{
  		$ch = curl_init($url);
  		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  		if (!empty($options)) {
  			curl_setopt_array($ch, $options);
  		}
  		//https请求 不验证证书和host
  		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  		$data = curl_exec($ch);
  		curl_close($ch);
  		return $data;
  	}
  	public static function curlPost($url = '', $postData = '', $options = array())
  	{
  		if (is_array($postData)) {
  			$postData = http_build_query($postData);
  		}
  		$ch = curl_init();
  		curl_setopt($ch, CURLOPT_URL, $url);
  		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  		curl_setopt($ch, CURLOPT_POST, 1);
  		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
  		curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
  		if (!empty($options)) {
  			curl_setopt_array($ch, $options);
  		}
  		//https请求 不验证证书和host
  		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  		$data = curl_exec($ch);
  		curl_close($ch);
  		return $data;
  	}

  	public function arrayToXml($arr)
  	{
  		$xml = "<xml>";
  		foreach ($arr as $key => $val) {
  			if (is_numeric($val)) {
  				$xml .= "<" . $key . ">" . $val . "</" . $key . ">";
  			} else
  				$xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
  		}
  		$xml .= "</xml>";
  		return $xml;
  	}
  	/**
  	 * 例如：
  	 * appid：  wxd930ea5d5a258f4f
  	 * mch_id：  10000100
  	 * device_info： 1000
  	 * Body：  test
  	 * nonce_str： ibuaiVcKdpRxkhJA
  	 * 第一步：对参数按照 key=value 的格式，并按照参数名 ASCII 字典序排序如下：
  	 * stringA="appid=wxd930ea5d5a258f4f&body=test&device_info=1000&mch_i
  	 * d=10000100&nonce_str=ibuaiVcKdpRxkhJA";
  	 * 第二步：拼接支付密钥：
  	 * stringSignTemp="stringA&key=192006250b4c09247ec02edce69f6a2d"
  	 * sign=MD5(stringSignTemp).toUpperCase()="9A0A8659F005D6984697E2CA0A9CF3B7"
  	 */
  	public function getSign($params, $key)
  	{  		
  		ksort($params, SORT_STRING);
  		$unSignParaString = $this->formatQueryParaMap($params, false);
  		$signStr = strtoupper(md5($unSignParaString . "&key=" . $key));
  		return $signStr;
  	}
  	protected function formatQueryParaMap($paraMap, $urlEncode = false)
  	{
  		$buff = "";
  		ksort($paraMap);
  		foreach ($paraMap as $k => $v) {
  			if (null != $v && "null" != $v) {
  				if ($urlEncode) {
  					$v = urlencode($v);
  				}
  				$buff .= $k . "=" . $v . "&";
  			}  			
  		}
  		if (strlen($buff) > 0) {
  			$reqPar = substr($buff, 0, strlen($buff) - 1);
  		}
  		return $reqPar;
  	}
}