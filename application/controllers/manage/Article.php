<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Article extends BaseController
{
	private $_new_form = array(
			'title' => array('name' => 'title', 'label' => 'Title', 'rules' => 'required|max_length[255]'),
			'created_at' => array('name' => 'created_at', 'label' => 'created_at', 'rules' => 'required|max_length[255]'),
			'imgurl' => array('name' => 'imgurl', 'label' => 'imgurl', 'rules' => ''),
			'summary' => array('name' => 'summary', 'label' => 'summary', 'rules' => ''),
			'body' => array('name' => 'body', 'label' => 'Body', 'rules' => 'required|prep_for_form')
	);
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();   
        $this->load->model ( 'admin/Blog_model' );
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
	
		$link = "/manage/article/index?";
		
		//文章总数
		if (isset($where['pagenum']) && $where['pagenum'])
		{
			$pagenum = $where['pagenum'];
			unset($where['pagenum']);
		}else{
			$pagenum = 10;
		}
		$count = $this->Blog_model->select_all_num ($where);
		
		$data ['pageurl'] = $this->paginationCompress($link, $count, $where,$p,$pagenum);
		$to = ($p - 1) * $pagenum;
		$data ['article'] = $this->Blog_model->select ($to,$where,$order,$pagenum); // 关联数组
		//print_r($data);
		$this->global['pageTitle'] = '文章列表';
		$this->loadViews("admin/article", $this->global, $data , NULL);
	}
	public function add()
	{
		$this->global['pageTitle'] = '增加文章';
		$this->load->library('form_validation');
		
		$this->global['form'] = $this->_new_form;
		if ($_POST) {
			foreach ($this->_new_form as $field_name => $field) {
				$this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
			}
			if ($this->form_validation->run() === true) {
				if (self::insert()) {
					redirect(base_url().'manage/article/index', 'refresh');
					return;
				} else {
					echo 'Unable to save new blog';
				}
			}
		}
		$this->loadViews("admin/articleadd", $this->global, NULL , NULL);
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
					redirect(base_url().'manage/article/index', 'refresh');
					return;
				}
			}
		}
		$aid = $this->input->get ( 'aid', TRUE );
		if (! $aid  && ! is_numeric ( $aid )) {
			echo "传递aid错误！！";
			return;
		}
		$article = $this->get_db($aid);
		if (!$article){
			echo "获取文章错误";
			return;
		}
		$this->global['article'] = $article;
		$this->global['pageTitle'] = '编辑文章';
		$this->loadViews("admin/articleupdate", $this->global, NULL , NULL);
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
			$this->Blog_model->update_title(array('id' => $aid) , array('del' => $val));
		}else if($type == 'click') {
			$html['message'] = '推荐成功!';
			$this->Blog_model->update_title(array('id' => $aid) , array('click' => $val));
		}
		$html['state'] = 'sess';
		echo json_encode($html);
		return;
	}

	private function update_db($aid) {
		$data = $this->get_form_data();
	
		$data['title']['created_at'] = strtotime($this->input->post ( 'created_at', TRUE ));
		$data['title']['created_at'] = isset ( $data['title']['created_at'] ) && $data['title']['created_at'] ? $data['title']['created_at'] : time();
	
		$data['title']['updated_at'] = time();
	
		$re = $this->Blog_model->update_title(array('id' => $aid) , $data['title']);
		if ($re) {
			$this->Blog_model->update_body(array('aid' => $aid) , $data['body']);
			return $re;
		}else{
			return false;
		}
	}
	private function insert() {
		
		$data = $this->get_form_data();
	
		$data['title']['created_at'] = strtotime($this->input->post ( 'created_at', TRUE ));
		$data['title']['created_at'] = isset ( $data['title']['created_at'] ) && $data['title']['created_at'] ? $data['title']['created_at'] : time();
	
		$data['title']['readnum'] = 1;
		$data['title']['updated_at'] = time();
	
		$aid = $this->Blog_model->insert_title($data['title']);
		if ($aid) {
			$data['body']['aid'] = $aid;
			$this->Blog_model->insert_body($data['body']);
			redirect('index');
		}else{
			return false;
		}
	}
	private function get_db($aid) {
		$this->load->model ( 'admin/Blog_model' );
		$article = $this->Blog_model->find_by_id ($aid);
		if (!$article){
			return false;
		}
		$db['title'] = isset ( $_POST ['title'] ) && $_POST ['title']  ? $_POST ['title'] : $article[0]['title'];
	
		$db['summary'] = isset ( $_POST ['summary'] ) && $_POST ['summary']  ? $_POST ['summary'] : $article[0]['summary'];
	
		$db['body'] = isset ( $_POST ['body'] ) && $_POST ['body']  ? $_POST ['body'] : $article[0]['body'];
	
		$imgurl = $this->input->post ( 'imgurl', TRUE );
		$db['imgurl'] = isset ( $imgurl ) && $imgurl  ? $imgurl : $article[0]['imgurl'];
	
		$created_at = $this->input->post ( 'created_at', TRUE );
		$db['created_at'] = isset ( $created_at ) && $created_at  ? $created_at : $article[0]['created_at'];
	
		$click = $this->input->post ( 'click', TRUE );
		$db['click'] = isset ( $click ) && $click  ? $click : $article[0]['click'];
	
		$db['id'] = $article[0]['id'];
	
		return $db;
	}
	private function get_form_data() {
		$this->load->library ( 'admin/Str' );
		$summary = $_POST ['summary'];
		$summary = isset ( $summary ) && $summary  ? $summary : $this->str->portalcp_get_summary ( $_POST ['body'] );
	
		$imgurl = $this->input->post ( 'imgurl', TRUE );
	
		$imgurl = isset ( $imgurl ) && $imgurl ? $imgurl : "uploads/article.jpg";
	
		$click = $this->input->post ( 'click', TRUE );
		$click = isset ( $click ) && $click ? $click : 0;
		return array ('title' => array(
				'title' => $_POST ['title'],
				'summary' => $summary,
				'imgurl' => $imgurl,
				'click' => $click
		),
				'body'=> array('body' => $_POST ['body'])
		);
	}
	
}
