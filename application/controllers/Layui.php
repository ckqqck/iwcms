<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Layui extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->helper ( 'url' );
	}
	private function _loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){
	
		$this->load->view('demo/header.html', $headerInfo);
		$this->load->view($viewName, $pageInfo);
		$this->load->view('demo/footer.html', $footerInfo);
	}
	public function index()
	{
		$data = array();
		$this->global['pageTitle'] = '文章列表';
		$this->_loadViews("layui/index.html", $this->global, $data , NULL);
	}
}
