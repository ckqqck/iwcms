<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cj_model extends CI_model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	/**
	 * 添加一个内容
	 *
	 * @return mixed {post_id | FALSE}
	 */
	public function insert($data) {
		$this->db->insert ( 'article_cj', $data );
		
		return $this->db->insert_id () ? $this->db->insert_id () : FALSE;
	}
	/**
	 * 添加一个内容
	 *
	 * @return mixed {post_id | FALSE}
	 */
	public function update($where = array(), $data) {
		$this->db->where ( $where );
		return $this->db->update ( 'article_cj', $data );
	}
	/**
	 * 获取内容 article_cj
	 *
	 * @return mixed {post_id | FALSE}
	 */
	function select($where = array()) {
		if (! empty ( $where )) {
			$this->db->where ( $where );
		}
		$query = $this->db->get ( 'article_cj' );
		return $query->result ();
	}
	
	// 删除文章及内空,没有删除评论
	function delete($id) {
		$query = $this->db->where ( 'id', $id )->delete ( 'article_cj' );
		$this->db->where ( 'uid', $id )->delete ( 'article_cj_comment' );
		$this->db->where ( 'uid', $id )->delete ( 'article_cj_urllist' );
		return $query;
	}
	
	// 清空数据
	function del_db($id) {
		$query = $this->db->where ( 'uid', $id )->delete ( 'article_cj_comment' );
		$query = $this->db->where ( 'uid', $id )->delete ( 'article_cj_img' );
		$this->db->where ( 'uid', $id )->delete ( 'article_cj_urllist' );
		return $query;
	}
	/**
	 * 添加 article_cj_urllist
	 */
	public function insert_urllist($data) {
		$this->db->insert ( 'article_cj_urllist', $data );
		
		return $this->db->insert_id () ? $this->db->insert_id () : FALSE;
	}
	/**
	 * 获取数量 article_cj_urllist
	 */
	function select_urllist($where = array()) {
		if (! empty ( $where )) {
			$this->db->where ( $where );
		}
		
		$query = $this->db->from ( 'article_cj_urllist' );
		return $query->count_all_results ();
	}
	/**
	 * 获取 article_cj_urllist
	 */
	function select_urllist_db($where = array(), $num = "") {
		if (! empty ( $where )) {
			$this->db->where ( $where );
		}
		if (! empty ( $num )) {
			$this->db->limit ( $num );
		}
		$this->db->order_by ( "article_cj_urllist.id", "desc" );
		$query = $this->db->get ( 'article_cj_urllist' );
		return $query->result ();
	}
	/**
	 * 更新 article_cj_urllist
	 */
	function sort($id, $data, $dbname) {
		$this->db->where ( 'id', $id );
		return $this->db->update ( $dbname, $data );
	}
	/**
	 * 添加 article_cj_comment
	 */
	public function insert_comment($data) {
		$this->db->insert ( 'article_cj_comment', $data );
		
		return $this->db->insert_id () ? $this->db->insert_id () : FALSE;
	}
	/**
	 * 获取数量 article_cj_comment_count
	 */
	function select_comment_count($where = array()) {
		if (! empty ( $where )) {
			$this->db->where ( $where );
		}
		$query = $this->db->from ( 'article_cj_comment' );
		return $query->count_all_results ();
	}
	/**
	 * 获取数量 article_cj_comment_count
	 */
	function select_comment($where = array(), $num = 10) {
		if (! empty ( $where )) {
			$this->db->where ( $where );
		}
		if (! empty ( $num )) {
			$this->db->limit ( $num );
		}
		$this->db->order_by ( "article_cj_comment.id", "desc" );
		$query = $this->db->get ( 'article_cj_comment' );
		return $query->result ();
	}
	function select_comment_in($where = array(), $num = "") {
		if (! empty ( $where )) {
			$this->db->where ( $where );
		}
		if (! empty ( $num )) {
			$this->db->limit ( $num );
		}
		$query = $this->db->get ( 'article_cj_comment' );
		return $query->result_array ();
	}
	/**
	 * 添加一个内容
	 *
	 * @return mixed {post_id | FALSE}
	 */
	public function update_comment($where = array(), $data) {
		$this->db->where ( $where );
		return $this->db->update ( 'article_cj_comment', $data );
	}
	/**
	 * 添加一个内容
	 *
	 * @return mixed {post_id | FALSE}
	 */
	public function del_comment($id) {
		$query = $this->db->where ( 'id', $id )->delete ( 'article_cj_comment' );
		return $query;
	}
	/**
	 * 文章发布过滤类
	 */
	function select_article_title_count($cjurl) {
		$this->db->where ( 'cj_url', $cjurl );
		$query = $this->db->get ( 'weixin_blog' );
		return $query->num_rows();
	}
	/**
	 * 添加采集栏目图片到
	 *
	 * @return mixed {post_id | FALSE}
	 */
	public function insert_img($data) {
		$this->db->insert ( 'article_cj_img', $data );
		
		return $this->db->insert_id () ? $this->db->insert_id () : FALSE;
	}
	/**
	 * 图片过滤类
	 */
	function select_article_img_count($where = array()) {
		if (! empty ( $where )) {
			$this->db->where ( $where );
		}
		$query = $this->db->from ( 'article_cj_img' );
		return $query->count_all_results ();
	}
	/**
	 * 图片 update
	 */
	function update_img($where = array(), $data) {
		$this->db->where ( $where );
		return $this->db->update ( 'article_cj_img', $data );
	}
	/**
	 * 图片 select
	 */
	function select_img($where = array(), $num = "") {
		if (! empty ( $where )) {
			$this->db->where ( $where );
		}
		if (! empty ( $num )) {
			$this->db->limit ( $num );
		}
		$query = $this->db->get ( 'article_cj_img' );
		return $query->result ();
	}
}