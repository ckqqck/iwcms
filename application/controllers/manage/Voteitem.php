<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Voteitem extends BaseController
{
	private $_aid = "";
	private $_new_form = array(
			'item' => array('name' => 'item', 'label' => 'item', 'rules' => 'required|max_length[255]'),
			'rank' => array('name' => 'rank', 'label' => 'rank', 'rules' => 'required|numeric|max_length[3]'),
			'tourl' => array('name' => 'tourl', 'label' => 'tourl', 'rules' => 'required|numeric|max_length[255]'),
			'intro' => array('name' => 'intro', 'label' => 'intro', 'rules' => 'required'),
			'vcount' => array('name' => 'vcount', 'label' => 'vcount', 'rules' => 'required|numeric|max_length[3]'),
			'startpicurl' => array('name' => 'startpicurl', 'label' => 'startpicurl', 'rules' => ''),
			'vid' => array('name' => 'vid', 'label' => 'info', 'rules' => 'required')
	);

    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
    	
        parent::__construct();
        $this->load->model ( 'admin/Vote_model' );
        $this->isLoggedIn();
        $this->_aid = $_GET['aid'];
        if (! is_numeric ( $this->_aid )){
        	echo "获取文章错误";
        	return;
        }
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
	
		$link = "/manage/voteitem/index?";
		
		//文章总数
		if (isset($where['pagenum']) && $where['pagenum'])
		{
			$pagenum = $where['pagenum'];
			unset($where['pagenum']);
		}else{
			$pagenum = 10;
		}
		$where['vid'] = $this->_aid;
		$count = $this->Vote_model->item_select_all_num ($where);
		
		$data ['pageurl'] = $this->paginationCompress($link, $count, $where,$p,$pagenum);
		$to = ($p - 1) * $pagenum;
		$data ['article'] = $this->Vote_model->item_select ($to,$where,$order,$pagenum); // 关联数组
		$data ['aid'] = $this->_aid;
		$this->global['pageTitle'] = '选手列表';
		$this->loadViews("admin/vitem_index", $this->global, $data , NULL);
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
					redirect(base_url().'manage/voteitem/index?aid='.$this->_aid, 'refresh');
					return;
				} else {
					echo 'Unable to save new blog';
				}
			}
		}
		$data ['aid'] = $this->_aid;
		$this->loadViews("admin/vitemadd", $this->global, $data , NULL);
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
				$id = $this->input->post ( 'id', TRUE );
				if (self::update_db($id)) {
					redirect(base_url().'manage/voteitem/index?aid='.$this->_aid, 'refresh');
					return;
				}
			}
		}
		$id = $this->input->get ( 'id', TRUE );
		if (! $id  && ! is_numeric ( $id )) {
			echo "传递id错误！！";
			return;
		}
		$article = $this->Vote_model->item_select_where (array("id" => $id));
		if (!$article){
			echo "获取文章错误";
			return;
		}
		$data['article'] = $article;
		$data ['aid'] = $this->_aid;
		$this->global['pageTitle'] = '编辑选手';
		$this->loadViews("admin/vitemupdate", $this->global, $data , NULL);
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
		$re = $this->Vote_model->item_update(array('id' => $aid) , $data);
		if ($re) {
			return $re;
		}else{
			return false;
		}
	}
	private function insert() {
		
		$data = $this->get_form_data();
		$data['addtime'] = time();
		if ($this->Vote_model->item_insert($data)) {
			return true;
		}else{
			return false;
		}
	}

	private function get_form_data() {
		$startpicurl = $this->input->post('startpicurl');
		return array (
				"item" => $this->input->post('item'),
				"rank" => $this->input->post ( 'rank'),
				"tourl" => $this->input->post ( 'tourl'),
				"intro" => $this->input->post('intro'),
				"vcount" => $this->input->post('vcount'),
				"vid" => $this->input->post('vid'),
				"startpicurl" => isset ( $startpicurl ) && $startpicurl ? $startpicurl : "uploads/article.jpg"
		);
	}
	
}
