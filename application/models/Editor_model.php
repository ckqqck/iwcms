<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Editor_model extends CI_model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function article_fileimg_select($where = array()) {
		
		$this->db->select ( 'attachid,attachment' );
		$this->db->from ( 'article_fileimg' );
		
		$query = $this->db->get ();
		return $query->result_array ();
	}
	function article_file_select($where = array()) {	
		$time = time () - 3600 * 24 * 2;
		$this->db->where ( 'dateline >', $time );
		if ($where != array ()) {
			$this->db->where ( $where );
		}
		$this->db->or_where ( 'aid', 0 );
		$this->db->select ( 'id,imgpath' );
		$this->db->from ( 'article_fileimg' );		
		$query = $this->db->get ();
		return $query->result_array ();
	}
	public function qeditor_insert_file_attach($data) {
		$this->db->insert ( 'article_file', $data );
		return $this->db->insert_id ();
	}
	// qeditor insert
	public function qeditor_insert_file($data) {
		$this->db->insert ( 'article_fileimg', $data );
		return $this->db->insert_id ();
	}
	function article_attch_id_del($id) {
		$this->db->where ( 'attachid', $id );
		
		$this->db->select ( 'attachment' );
		$this->db->from ( 'article_file' );
		
		$query = $this->db->get ();
		$results = $query->result_array ();
		if ($results) {
			$file_path = FCPATH . "/" . $results [0] ['attachment'];
			
			@unlink ( $file_path );
			
			return $this->_article_attch_del ( $id );
		} else {
			return false;
		}
	}
	private function _article_attch_del($id) {
		$this->db->where ( 'attachid', $id );
		return $this->db->delete ( 'article_file' );
	}
	function article_fileimg_id_delfile($id) {
		$this->db->where ( 'attachid', $id );
		
		$this->db->select ( 'attachid,filename,filetype,attachment' );
		$this->db->from ( 'article_fileimg' );
		
		$query = $this->db->get ();
		$results = $query->result_array ();
		if ($results) {
			$file_path = FCPATH . "/upload/allimg/" . $results [0] ['attachment'];
			$file_path_thumb = FCPATH . "/upload/allimg/" . $results [0] ['filetype'] . $results [0] ['filename'];
			
			@unlink ( $file_path );
			@unlink ( $file_path_thumb );
			$this->_article_fileimg_del ( $id );
		} else {
			return false;
		}
	}
	private function _article_fileimg_del($id) {
		$this->db->where ( 'attachid', $id );
		return $this->db->delete ( 'article_fileimg' );
	}
}