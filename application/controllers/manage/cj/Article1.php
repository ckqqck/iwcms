<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Article1 extends BaseController {
	public $data = array ();
	function __construct() {
		parent::__construct ();
		$this->isLoggedIn();
	}

	function index() {
		$this->load->model ( 'cj/Cj_model' );
		if (isset($_POST['submit']) && isset($_POST['del']) && $_POST['del'] == 'dels' && isset($_POST['cj_id']) && $_POST['cj_id'])
		{
			$where = $_POST['cj_id'];
			foreach ($where as $k => $v)
			{
				$this->Cj_model->delete($v);
			}
			redirect ( base_url ()."admin/cj/article/index" );
		}elseif (isset($_POST['submit']) && isset($_POST['del']) && $_POST['del'] == 'update' && isset($_POST['cat_id']) && $_POST['cat_id'])
		{
			$where = $_POST['cat_id'];
			foreach ($where as $k => $v)
			{
				$this->Cj_model->update(array('id' => $k), array("cat_id" => $v));
			}
			redirect ( base_url ()."admin/cj/article/index" );
		}else{
			$this->data['result'] = $this->Cj_model->select();
			
			foreach ( $this->data ['result'] as $k => $v ) {
				$this->data ['result'][$k]->url_num_new = $this->Cj_model->select_urllist ( array (
						"uid" => $v->id
				) );
				$this->data ['result'][$k]->comment_num_new = $this->Cj_model->select_comment_count ( array (
						"uid" => $v->id
				) );
				$this->data ['result'][$k]->comment_num_in = $this->Cj_model->select_comment_count ( array (
						"uid" => $v->id,"is_in_comment" => 1
				) );
				$this->data ['result'][$k]->img_num_new = $this->Cj_model->select_article_img_count ( array (
						"uid" => $v->id
				) );
				$this->data ['result'][$k]->caiimg_num_new = $this->Cj_model->select_article_img_count ( array (
						"uid" => $v->id,"isimage" => 1
				) );
				$this->data ['result'][$k]->shicaiimg_num_new = $this->Cj_model->select_article_img_count ( array (
						"uid" => $v->id,"isimage" => 0
				) );
			}
			
			$this->global['pageTitle'] = '采集列表';
			$this->loadViews("admin/cj/vote", $this->global, $this->data , NULL);
		}
		
	}
	function url_list()
	{
		if (isset ( $_GET ['id'] ) && $_GET ['id'] && is_numeric ( $_GET ['id'] )) {
			$this->load->model ( 'cj/Cj_model' );
			$this->data['result'] = $this->Cj_model->select_urllist_db ( array("uid" => $_GET ['id']),20 );
			$this->data ['a_main_content'] = "cj_article_url_list";
			$this->load->view ( 'admin/cj/a_template', $this->data );
		}
	}
	function cat_list()
	{
		if (isset ( $_GET ['id'] ) && $_GET ['id'] && is_numeric ( $_GET ['id'] )) {
			$this->load->model ( 'cj/Cj_model' );
			$this->data['result'] = $this->Cj_model->select_comment ( array("uid" => $_GET ['id']),20 );
			$this->data ['a_main_content'] = "cj_article_cat_list";
			$this->load->view ( 'admin/cj/a_template', $this->data );
		}
	}
	function img_list()
	{
		if (isset ( $_GET ['id'] ) && $_GET ['id'] && is_numeric ( $_GET ['id'] )) {
			$this->load->model ( 'cj/Cj_model' );
			$this->data['result'] = $this->Cj_model->select_img ( array("uid" => $_GET ['id']),20 );
			$this->data ['a_main_content'] = "cj_article_img_list";
			$this->load->view ( 'admin/cj/a_template', $this->data );
		}
	}
	function cat_del()
	{
		if (isset ( $_GET ['id'] ) && $_GET ['id'] && is_numeric ( $_GET ['id'] )) {
			$this->load->model ( 'cj/Cj_model' );
			$re = $this->Cj_model->del_comment ( $_GET ['id'] );
			if ($re)
			{
				$this->_cjjs_show("删除成功！");
			}else{
				$this->_cjjs_show("删除失败！");
			}
		}
	}

	// 清空数据
	function del_db ()
	{
		if (! (isset ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) && strtolower ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest')) {
			die ( "Call not allowed" );
		}
		$this->load->model ( 'cj/Cj_model' );
		$re = $this->Cj_model->del_db ( $_POST ['id'] );
		if ($re)
		{
			$this->_cjjs_show("删除成功！");
		}else{
			$this->_cjjs_show("删除失败！");
		}
	}
	function cat()
	{
		if (isset ( $_GET ['id'] ) && $_GET ['id'] && is_numeric ( $_GET ['id'] )) {
			$this->load->model ( 'cj/Cj_model' );
			$this->data['result'] = $this->Cj_model->select_comment ( array("id" => $_GET ['id']));
			$re = $this->load->view ( 'admin/cj/cj_article_cat', $this->data ,true);
			$this->_cjjs_show($re);
		}
	}
	private function _cjjs_show($str = "提示错误") {
		$smiliestype = '<h3 class="flb" id="e_image_ctrl" style="margin-top: 0px; margin-bottom: 0px; cursor: move;">';
		$smiliestype .= '<em id="return_showblock" fwin="showblock">采集内容测试</em>';
		$smiliestype .= '<span class="flbc" onclick="hideWindow(\'testcj\')">关闭</span></h3><div class="caiji">';
		if ($str) {
			$smiliestype .= "<li>" . $str . "</li>";
		}	
		$smiliestype .= '</div><p class="o pns">';
		$smiliestype .= '<button id="report_submit" type="submit" class="pn pnc" fwin="testcj"  onclick="hideWindow(\'testcj\')"><strong>确定</strong></button></p>';
	
		out_xml ( $smiliestype );
	}
	function sort()
	{
		$sort = array("urllist_url","url","title","comment","form","author");
		if (isset($_POST['uid']) && isset($_POST['sort_start']) && isset($_POST['sort_end']) && isset($_POST['submit']) && isset($_POST['sort']) && in_array($_POST['sort'],$sort))
		{	
			$this->load->model ( 'cj/Cj_model' );
			$where ['uid'] = $_POST['uid'];
			$start = $_POST['sort_start'];
			$end = $_POST['sort_end'];
			if ($_POST['sort'] == "urllist_url")
			{
				$re = $this->Cj_model->select_urllist_db ( $where );
				$dbname = "article_cj_urllist";
				foreach ($re as $v)
				{
					$id = $v->id;
					$data['url'] = str_replace ( $start, $end, $v->url );
					$this->Cj_model->sort($id,$data,$dbname);
				}
			}else{
				$re = $this->Cj_model->select_comment ( $where );
				$dbname = "article_cj_comment";
				foreach ($re as $v)
				{
					$id = $v->id;
					$data[$_POST['sort']] = str_replace ( $start, $end, $v->$_POST['sort'] );
					$this->Cj_model->sort($id,$data,$dbname);
				}
			}
			$this->index();
		}else{
			$this->load->helper ( array (
					'form'
			) );
			if (isset ( $_GET ['id'] ) && $_GET ['id'] && is_numeric ( $_GET ['id'] )) {
				$this->data['id'] = $_GET ['id'];
				$this->data ['a_main_content'] = "cj_article_sort";
				$this->load->view ( 'admin/cj/a_template', $this->data );
			}
		}		
	}

	function insert_title() {
		$this->load->helper ( array (
				'form',
				'url'
		) );
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'title', '标题', 'required' );
		if ($this->form_validation->run () == FALSE) {
			$this->data ['update'] = false;
			$this->data ['a_main_content'] = "cj_article_add_title";
			$this->load->view ( 'admin/cj/a_template', $this->data );
		} else {
			$db = array (	
				'title' => $this->input->post ( 'title', TRUE ),
				'charset' => $this->input->post ( 'charset'),
					'last_date' => time()
			);
			$this->load->model ( 'cj/Cj_model' );
			$id = $this->Cj_model->insert($db);
			if ($id){
				redirect('admin/cj/article/insert?id='.$id, 'refresh');
			}
		}
	}
	function update() {
		$this->load->helper ( array (
				'form',
				'url'
		) );
		$this->load->library ( 'form_validation' );

		$this->load->model ( 'cj/Cj_model' );
		//print_r($_POST);
		$this->_load_validation_rules();
		if ($this->form_validation->run () == FALSE) {
			$this->data['id'] = $_GET['id'];
			$this->data['result'] = $this->Cj_model->select(array('id' => $_GET['id']));			
			//print_r($this->data['result']);
			$this->global['pageTitle'] = '更新规则';
			$this->loadViews("admin/cj/vote_update", $this->global, $this->data , NULL);
		} else {
			$where = array('id' => $_POST['id']);
			$db = $this->_get_form_data();
			$db['title'] = $this->input->post ( 'title', true);
			$db['url_num'] = $this->Cj_model->select_urllist(array("uid" => $_POST['id']));
			$db['comment_num'] = $this->Cj_model->select_comment_count(array("uid" => $_POST['id']));
			$id = $this->Cj_model->update($where,$db);
			if ($id){
				$this->index();
			}
		}
	}
	function insert() {
		$this->load->helper ( array (
				'form',
				'url' 
		) );		
		$this->load->library ( 'form_validation' );		
		//print_r($_POST);		
		$this->_load_validation_rules();
		if ($this->form_validation->run () == FALSE) {			
			$this->data ['update'] = false;
			$this->data['id'] = $_GET['id'];
			$this->data ['a_main_content'] = "cj_article_add";
			$this->load->view ( 'admin/cj/a_template', $this->data );
		} else {
			$where = array('id' => $_POST['id']);
			$db = $this->_get_form_data();
			$this->load->model ( 'cj/Cj_model' );
			$db['url_num'] = $this->Cj_model->select_urllist(array("uid" => $_POST['id']));
			$db['comment_num'] = $this->Cj_model->select_comment_count(array("uid" => $_POST['id']));
			$id = $this->Cj_model->update($where,$db);
			if ($id){
				$this->index();
			}
		}
	}
	function insert_comment() {
		$this->load->helper ( array (
				'form',
				'url'
		) );
		$this->load->library ( 'form_validation' );
		//print_r($_POST);
		$this->_load_validation_comment();
		if ($this->form_validation->run () != FALSE) {			
			$where = array('id' => $_POST['id']);
			$db = $this->_get_form_comment();
			$this->load->model ( 'cj/Cj_model' );
			$id = $this->Cj_model->update($where,$db);
			if ($id){
				$this->index();
			}
		}else{
			redirect('admin/cj/article/update?id='.$_POST['id'], 'refresh');
		}
	}
	private function _caiji_url($id = false)
	{
		$this->load->model ( 'cj/Cj_model' );
		if ($id)
		{
			$cj = $this->Cj_model->select(array('id' => $id));
			if ($cj->uid == 1){
				
			}elseif ($cj->uid == 3){
				
			}
		}else{
			$cj = $this->Cj_model->select();
		}
	}
	private function _get_form_comment() {
	
		return array (
				'db_title_str' => $this->input->post ( 'db_title_str'),
				'db_title_dom' => $this->input->post ( 'db_title_dom' ),
				'db_title_dom_on' => $this->input->post ( 'db_title_dom_on' ),
				'db_comment_str' => $this->input->post ( 'db_comment_str' ),
				'db_comment_end' => $this->input->post ( 'db_comment_end'),
				'db_comment_dom' => $this->input->post ( 'db_comment_dom'),
				'db_comment_dom_on' => $this->input->post ( 'db_comment_dom_on'),
				'db_page' => $this->input->post ( 'db_page'),
				'db_page_type' => $this->input->post ( 'db_page_type'),
				'db_page_str' => $this->input->post ( 'db_page_str'),
				'db_page_dom' => $this->input->post ( 'db_page_dom'),
				'db_page_bh' => $this->input->post ( 'db_page_bh'),
				'db_page_nobh' => $this->input->post ( 'db_page_nobh'),
				'db_page_host' => $this->input->post ( 'db_page_host'),
				'db_time_str' => $this->input->post ( 'db_time_str'),
				'db_time_end' => $this->input->post ( 'db_time_end'),
				'db_time_dom' => $this->input->post ( 'db_time_dom'),
				'db_time_dom_on' => $this->input->post ( 'db_time_dom_on'),
				'db_form_str' => $this->input->post ( 'db_form_str'),
				'db_form_end' => $this->input->post ( 'db_form_end'),
				'db_form_var' => $this->input->post ( 'db_form_var'),
				'db_author_str' => $this->input->post ( 'db_author_str'),
				'db_author_end' => $this->input->post ( 'db_author_end'),
				'db_author_var' => $this->input->post ( 'db_author_var'),
				'last_date' => time()
		);
	}
	private function _load_validation_comment() {
		$this->form_validation->set_rules ( 'db_title_str', '标题开始字符串', 'required' );
		$this->form_validation->set_rules ( 'db_comment_str', '内容开始字符串', 'required' );
	}
	private function _get_form_data() {
	
		return array (	
				'uid' => $this->input->post ( 'uid'),
				'is_img' => $this->input->post ( 'is_img'),
				'dom' => $this->input->post ( 'dom'),
				'click_str' => $this->input->post ( 'click_str' ),	
				'click_dom' => $this->input->post ( 'click_dom' ),	
				'click_bh' => $this->input->post ( 'click_bh'),	
				'click_nobh' => $this->input->post ( 'click_nobh'),	
				'click_host' => $this->input->post ( 'click_host'),	
				'b_listconment' => $this->input->post ( 'b_listconment'),	
				'c_wwwsss' => $this->input->post ( 'c_wwwsss'),	
				'a_www' => $this->input->post ( 'a_www'),	
				'a_bi' => $this->input->post ( 'a_bi'),	
				'a_chaone' => $this->input->post ( 'a_chaone'),	
				'a_chanum' => $this->input->post ( 'a_chanum'),	
				'a_chacommon' => $this->input->post ( 'a_chacommon'),	
				'a_bione' => $this->input->post ( 'a_bione'),	
				'a_binum' => $this->input->post ( 'a_binum'),	
				'a_bicommon' => $this->input->post ( 'a_bicommon'),	
				'last_date' => time()	
		);	
	}
	private function _load_validation_rules() {
		$this->form_validation->set_rules ( 'uid', '采集类型', '' );
		$this->form_validation->set_rules ( 'click_str', '开始区域', '' );
		$this->form_validation->set_rules ( 'click_bh', '必须包含', '' );
		$this->form_validation->set_rules ( 'click_nobh', '不得包含', '' );
		$this->form_validation->set_rules ( 'click_host', '主机名', '' );
		$this->form_validation->set_rules ( 'b_listconment', '单条列表', '' );
		$this->form_validation->set_rules ( 'c_wwwsss', '导入列表', '' );
		$this->form_validation->set_rules ( 'a_www', '多条网址', '' );
		$this->form_validation->set_rules ( 'a_bi', '等比or等差', 'required' );
		$this->form_validation->set_rules ( 'a_chaone', '等差首项', 'required' );
		$this->form_validation->set_rules ( 'a_chanum', '等差项数', 'required' );
		$this->form_validation->set_rules ( 'a_chacommon', '等差公差', 'required' );
		$this->form_validation->set_rules ( 'a_bione', '等比首项', 'required' );
		$this->form_validation->set_rules ( 'a_binum', '等比项数', 'required' );
		$this->form_validation->set_rules ( 'a_bicommon', '等比公差', 'required' );
	}
}
?>