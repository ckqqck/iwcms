<?php
class CI_Msg
{
    function __construct($params = null)
    {
    	if($params){
                     $message = $params['message'];
                     $is = $params['is'];
                     $time = $params['time'];
                     $url = $params['url'];
                     $this->show_msg($message, $is, $time, $url);
    	}
    }
    
   
    private function show_msg($message,$is = null,$time=null,$url=null){
        $CI =& get_instance();
        $CI->load->helper('url');
        $data['message'] = $message;
        $data["is"] = $is;
        $data["time"] = $time ? $time : 5;
        $data["url"] = $url;
        //print_r($data);
        $CI->load->view('admin/success',$data);
    }
    
    public function show_error(){
    	$msg = "";
    	$msg .= '<script type="text/javascript">';
    	$msg .= 'showError("ddddd");alert("ontest");';
    	$msg .= '</script>';
    	echo $msg;
    }
  
}