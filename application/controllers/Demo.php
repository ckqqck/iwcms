<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Demo extends CI_Controller {
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
		$this->_loadViews("demo/index.html", $this->global, $data , NULL);
	}
	public function markdown()
	{
		$data = array();
		$this->global['pageTitle'] = '文章列表';
		$this->_loadViews("demo/markdown.html", $this->global, $data , NULL);
	}
	public function bootstraptable()
	{
		$data = array();
		$this->global['pageTitle'] = '文章列表';
		$this->_loadViews("demo/bootstraptable.html", $this->global, $data , NULL);
	}
	public function bootstraptable_json() {
		$this->load->helper('Json');
		//json?order=asc&offset=11&limit=10
		$this->load->model ( 'BootstrapTable_model' );
		if (isset($_GET['limit']))
		{
			$pagenum = $_GET['limit'];
	
		}else{
			$pagenum = 10;
		}
	
		if (! is_numeric ( $pagenum ) || $pagenum <= 0) {
	
			$pagenum = 10;
	
		}
		if (isset($_GET['offset']))
		{
			$to = $_GET['offset'];
	
		}else{
			$to = 0;
		}
	
		if (! is_numeric ( $to ) || $to <= 0) {
	
			$to = 0;
	
		}
	
		//文章总数
	
		$where = array();
		$Searchtext = "";
		if (isset($_GET['search']))
		{
			//$where['user_name'] = $_GET['search'];
			$Searchtext = $_GET['search'];
	
		}
		$num = $this->BootstrapTable_model->select_all_num ($Searchtext,$where);
	
		$order = "user_id";
	
		$table = array();
		$table['total'] = $num;
		$table['rows'] = $this->BootstrapTable_model->select ($to,$where,$order,$pagenum,$Searchtext); // 关联数组
	
	
		throwJson($table);
	}
}
