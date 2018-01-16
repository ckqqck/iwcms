<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Vote extends BaseController
{
	private $_new_form = array(
			'title' => array('name' => 'title', 'label' => 'Title', 'rules' => 'required|max_length[255]'),
			'statdate' => array('name' => 'statdate', 'label' => 'statdate', 'rules' => 'required|max_length[255]'),
			'enddate' => array('name' => 'enddate', 'label' => 'enddate', 'rules' => 'required|max_length[255]'),
			'imgurl' => array('name' => 'imgurl', 'label' => 'imgurl', 'rules' => ''),
			'info' => array('name' => 'info', 'label' => 'info', 'rules' => 'required')
	);
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
    	
        parent::__construct();
        $this->load->model ( 'admin/Vote_model' );
        $this->isLoggedIn();   
    }
	public function index()
	{
		if($this->isAdmin() == TRUE)
		{
			$this->loadThis();
		}
		else
		{
			//页数
			$p = 1;
			$array = array();
			if (isset($_GET['per_page']))
			{
				$p = $_GET['per_page'];
			}
			if (! is_numeric ( $p )) {
				$p = 1;
			}
			
			// 每页个数
			if(isset($_GET['pagenum']) && $_GET['pagenum']){
				$array['pagenum'] = $_GET['pagenum'];
			}else{
				$array['pagenum'] = 6;
			}
			$this->_select ( $p ,$array);
		}
		 
	}
	private function _select($p,$where = array(),$order='id') {
	
		$link = "/manage/vote/index?";
		
		//文章总数
		if (isset($where['pagenum']) && $where['pagenum'])
		{
			$pagenum = $where['pagenum'];
			unset($where['pagenum']);
		}else{
			$pagenum = 10;
		}
		$count = $this->Vote_model->select_all_num ($where);
		
		$data ['pageurl'] = $this->paginationCompress($link, $count, $where,$p,$pagenum);
		$to = ($p - 1) * $pagenum;
		$data ['article'] = $this->Vote_model->select ($to,$where,$order,$pagenum); // 关联数组
		//print_r($data);
		$this->global['pageTitle'] = '文章列表';
		$this->loadViews("admin/vote", $this->global, $data , NULL);
	}
	public function user() {//页数
		$p = 1;
		$where = array();


		$aid = $this->input->get ( 'vid', TRUE );
		if (! $aid  && ! is_numeric ( $aid )) {
			echo "传递aid错误！！";
			return;
		}
		
		if (isset($_GET['per_page']))
		{
			$p = $_GET['per_page'];
		}
		if (! is_numeric ( $p )) {
			$p = 1;
		}
		
		// 每页个数
		if(isset($_GET['pagenum']) && $_GET['pagenum']){
			$where['pagenum'] = $_GET['pagenum'];
		}else{
			$where['pagenum'] = 50;
		}
		
		$link = "/manage/vote/user?";
		
		//文章总数
		if (isset($where['pagenum']) && $where['pagenum'])
		{
			$pagenum = $where['pagenum'];
			unset($where['pagenum']);
		}else{
			$pagenum = 50;
		}
		$where['vid'] = $aid;
		$count = $this->Vote_model->item_select_all_num ($where);
		
		$data ['pageurl'] = $this->paginationCompress($link, $count, $where,$p,$pagenum);
		$to = ($p - 1) * $pagenum;
		$order='vcount';
		$data ['article'] = $this->Vote_model->item_select ($to,$where,$order,$pagenum); // 关联数组
		
		$this->global['pageTitle'] = '投票结果';
		$this->loadViews("admin/voteuser", $this->global, $data , NULL);
	}
	public function add()
	{
		$this->global['pageTitle'] = '增加投票';
		$this->load->library('form_validation');
		
		$this->global['form'] = $this->_new_form;
		if ($_POST) {
			foreach ($this->_new_form as $field_name => $field) {
				$this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
			}
			if ($this->form_validation->run() === true) {
				if (self::insert()) {
					redirect(base_url().'manage/vote/index', 'refresh');
					return;
				} else {
					echo 'Unable to save new blog';
				}
			}
		}
		$this->loadViews("admin/voteadd", $this->global, NULL , NULL);
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->global['form'] = $this->_new_form;
		if ($_POST) {
			foreach ($this->_new_form as $field_name => $field) {
				$this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
			}
			if ($this->form_validation->run() === true) {
				$aid = $this->input->post ( 'id', TRUE );
				if (self::update_db($aid)) {
					redirect(base_url().'manage/vote/index', 'refresh');
					return;
				}
			}
		}
		$aid = $this->input->get ( 'aid', TRUE );
		if (! $aid  && ! is_numeric ( $aid )) {
			echo "传递aid错误！！";
			return;
		}
		$article = $this->Vote_model->select_where($aid);
		if (!$article){
			echo "获取文章错误";
			return;
		}
		$data['article'] = $article;
		$this->global['pageTitle'] = '编辑文章';
		$this->loadViews("admin/voteupdate", $this->global, $data , NULL);
	}
	public function del_bak () {
		$aid = $this->input->post ( 'aid', TRUE );
		$type = $this->input->post ( 'type', TRUE );
		$val = $this->input->post ( 'val', TRUE );
		$html['state'] = 'error';
		$html['message'] = '操作失败!';
		if (! $aid  && ! is_numeric ( $aid ) && ! is_numeric ( $val ) && $type) {
			$html['message'] = '传递数据错误';
			echo json_encode($html);
			return;
		}
		if($type == 'del') {
			$html['message'] = '删除成功!';
			$this->Vote_model->update_title(array('id' => $aid) , array('status' => $val));
		}
		$html['state'] = 'sess';
		echo json_encode($html);
		return;
	}

	private function update_db($aid) {
		$data = $this->get_form_data();
	
	
		$re = $this->Vote_model->update(array('id' => $aid) , $data);
		if ($re) {
			return $re;
		}else{
			return false;
		}
	}
	private function insert() {
		
		$data = $this->get_form_data();
		
		if ($this->Vote_model->insert_title($data)) {
			return true;
		}else{
			return false;
		}
	}
	
	private function get_form_data() {

		$title = $this->input->post('title');
		$imgurl = $this->input->post ( 'imgurl');
		$catid = $this->input->post ( 'catid');
    	$statdate = strtotime($this->input->post('statdate'));
    	$enddate = strtotime($this->input->post('enddate'));
    	$info = $this->input->post('info');
    	$infosm = $this->input->post('infosm');
    	$infojp = $this->input->post('infojp');
    	$cknums = $this->input->post('cknums');
    	$votelimit = $this->input->post('votelimit');
    	
    	$imgurl = isset ( $imgurl ) && $imgurl ? $imgurl : "uploads/article.jpg";
    	
		return array (
				'title' => $title,
				'imgurl' => $imgurl,
				'catid' => $catid,
				'statdate'=> $statdate,
				'enddate'=> $enddate,
				'info'=> $info,
				'infosm'=> $infosm,
				'infojp'=> $infojp,
				'cknums'=> $cknums,
				'status'=> 0,
				'votelimit'=> $votelimit
		);
	}
	
}
