<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Ssc {
	public $CI;
	function __construct() {
		$this->CI = &get_instance();
		$this->CI->load->model ( 'Ssc_model' );
	}

	public function test1($win_1 = "10000005",$cart_id = "10000644") {
		
		$cart = $this->CI->Ssc_model->select_cart(array("cart_id" => $cart_id));

		if(!$cart){
			return "";
		}
		$re = array();
		//取得最后50名时间和
		$result = $this->CI->Ssc_model->select_pay50($cart[0]["goods_time"]);
		
		$a5 = 0;
		foreach($result as $k => $v) {
			$a5 += date("His",$v['pay_time']) . $v['pay_time3'];
		}
		// 加最近的时时彩 25847
		$ssc = $this->_json_standard($cart[0]["ssc_expect"]);
		if(!$ssc){
			return false;
		}
		// 需要的基本人次 60
		$c = $cart[0]['goods_total'];

		$winnum = abs(($a5 + $ssc['s']) % $c) + 10000001;
		
		if($winnum != $win_1){	
			//注意顺序不能错 $winnum - $win_1 ;
			$b =  $winnum - $win_1 ;
			$res = $this->_testa($result[1]['pay_time3'], $b, $c,999);
			$pay_time3 = str_pad($res, 3, '0', STR_PAD_LEFT);
			$this->CI->Ssc_model->update_pay($result[1]['pay_id'], array('pay_time3' => $pay_time3,'pay_time2' => 2));
			return $winnum;
		}else{
			return $winnum;
		}
	}
	public function test2($cart_id = "10000644") {
		$cart = $this->CI->Ssc_model->select_cart(array("cart_id" => $cart_id));

		if(!$cart){
			return;
		}
		$re = array();
		//取得最后50名时间和
		$result = $this->CI->Ssc_model->select_pay50($cart[0]["goods_time"]);
		
		$a5 = 0;
		foreach($result as $k => $v) {
			$a5 += date("His",$v['pay_time']) . $v['pay_time3'];
		}
		// 加最近的时时彩 25847
		$ssc = $this->_json_standard($cart[0]["ssc_expect"]);
		if(!$ssc){
			return false;
		}
		// 需要的基本人次 60
		$c = $cart[0]['goods_total'];

		$winnum = abs(($a5 + $ssc['s']) % $c) + 10000001;
		return $winnum;
	}
	private function _testa($a, $b, $c = 60,$z = 999) {
		if(($a + $b) > $z){
			$a = $a - $c;
			return ($a + $b);
		}else if(($a + $b) < 1){
			$a = $a + $c;
			return ($a + $b);
		}else{
			return ($a + $b);
		}
	}
	/***
	 * 1.获取全部能开奖的数据
	 * 2.获取开奖时间
	 * 3.根据开奖时间获取 开奖用的时时彩期号
	 * 4.获取最后50名购买的时间   时分秒毫米
	 * 5.计算奖号
	 * 6.根据奖号获取用户user_id
	 */
	
	public function win_json($cart_id = "10000625") {
		
		$cart = $this->CI->Ssc_model->select_cart(array("cart_id" => $cart_id));
		if(!$cart){
			return;
		}
		//取得最后50名时间和
		$result = $this->CI->Ssc_model->select_pay50($cart[0]["goods_time"]);
		$a5 = 0;
		foreach($result as $k => $v) {
			$a5 += date("His",$v['pay_time']) . $v['pay_time3'];
		}
		//echo "--取得最后50名之和--------".$a5."---------<br>";
		// 加最近的时时彩 25847
		$ssc = $this->_json_standard($cart[0]["ssc_expect"]);
		if($ssc){
			$c = $cart[0]['goods_total'];
			$winnum = abs(($a5 + $ssc['s']) % $c) + 10000001;
			
			$this->_winnum_user($cart_id, $winnum,$ssc);
		}
	}
	
	//根据xx期  xx奖号  推断出用户user_id和 支付的 pay_id
	private function _winnum_user($cart_id,$winnum,$ssc) {
		$data = array();
		$this->CI->load->model ( 'Pay_model' );
		$cart = $this->CI->Pay_model->select_winnum_user($cart_id);
		$win = array();
		foreach ($cart as $v){
			if ( in_array($winnum, explode(",",$v->pay_num))){
				$win[] = $v;
			}
		}
		if($win){
			//echo "----中奖者是----".$win[0]->user_id."---------<br>";
			if (count($win) == 1){
				$data['goods_win'] = $winnum;
				$data['user_id'] = $win[0]->user_id;
				$data['pay_id'] = $win[0]->pay_id;
				$data['ssc_opencode'] = $ssc['opencode'];
				$data['goods_state'] = 2;
				$this->CI->Pay_model->update_cart($cart_id,$data);
			}
		}
	}
	private function _json_standard($expect) {
		$s = 0;
		$re = array();
		//echo "----旗号----".$time."---------<br>";
		$ssc = $this->CI->Ssc_model->select_ssc1($expect);
		
		if(!$ssc){
			if(strtotime("+1 week",$ssc[0]['opentime']) < time()){
				//一周后:未采集到奖号 则以0计算
				$s = 0;
			}else{
				//return "未开奖或没采集到";
				return FALSE;
			}
		}else{
			$s = str_replace(",", "", $ssc[0]['opencode']);
		}
		$re['opencode'] = $ssc[0]['opencode'];
		$re['s'] = $s;
		return $re;
	}
}

?>