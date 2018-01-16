<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Vote_model extends CI_model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function select_where ($id) {
		$this->db->where ( 'id', $id );
		$this->db->from ( 'vote' );
		$query = $this->db->get ();
		if ($query->num_rows() > 0) {
			$result = $query->result_array ();
			return $result[0];
		}
		return false;
	}
	function find_by_id ($id) {
		$this->db->where ( 'vid', $id );
		$this->db->from ( 'vote_item' );
		$query = $this->db->get ();
		if ($query->num_rows() > 0) {
			$result = $query->result_array ();
			return $result;
		}
		return false;
	}

	function item_select_all_num($where = array()) {
		$this->db->where($where);
		$this->db->from('vote_item');
		$total = $this->db->count_all_results();
		return $total;
	}
	function item_select($p = 0,$where=array(),$order = 'vcount',$num = 5) {
		$this->db->where($where);
		$this->db->select ('vote_item.*'); // 关联的文章标题和作者
		$this->db->from ( 'vote_item' );
		$this->db->order_by("vote_item.".$order, "desc");
		$this->db->limit($num,$p);
		$query = $this->db->get ();
		return $query->result_array ();
	}
	function item_select_where ($where) {
		$this->db->where ( $where );
		$this->db->from ( 'vote_item' );
		$query = $this->db->get ();
		if ($query->num_rows() > 0) {
			$result = $query->result_array ();
			return $result[0];
		}
		return false;
	}
	
	function item_update($id) {
		$this->db->where(array('id'=>$id));
		$this->db->set('vcount','vcount + 1',FALSE);
		return $this->db->update ( 'vote_item' );
	}
	function item_record_insert($data) {
		$this->db->insert ( 'vote_record', $data );
		return $this->db->insert_id() ? $this->db->insert_id () : FALSE;
	}
}