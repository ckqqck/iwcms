<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Vote_model extends CI_model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function new_select() {
		$this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role');
		$this->db->from('tbl_users as BaseTbl');
		$this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
		if(!empty($searchText)) {
			$likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
			$this->db->where($likeCriteria);
		}
		$this->db->where('BaseTbl.isDeleted', 0);
		$this->db->where('BaseTbl.roleId !=', 1);
		$this->db->limit($page, $segment);
		$query = $this->db->get();
		
		$result = $query->result();
		return $result;
	}
	function select($p = 0,$where=array(),$order = 'created_at',$num = 5) {
		$this->db->where($where);
		$this->db->select ('vote.*'); // 关联的文章标题和作者
		$this->db->from ( 'vote' );
		$this->db->order_by("vote.".$order, "desc");
		$this->db->limit($num,$p);
		$query = $this->db->get ();
		return $query->result_array ();
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
	//后台查询全部用户
	function select_all_num($where = array()) {
		$this->db->where($where);
		$this->db->from('vote');
		$total = $this->db->count_all_results();
		return $total;
	}

	function update($where,$data) {
		$this->db->where ( $where );
		return $this->db->update ( 'vote', $data );
	}
	function insert_title($data) {
		$this->db->insert('vote', $data);

		return $this->db->insert_id() ? $this->db->insert_id () : FALSE;
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
	function item_insert($data) {
		$this->db->insert('vote_item', $data);
		return $this->db->insert_id() ? $this->db->insert_id () : FALSE;
	}
	function item_update($where,$data) {
		$this->db->where ( $where );
		return $this->db->update ( 'vote_item', $data );
	}
}