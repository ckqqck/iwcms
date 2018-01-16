<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Blog_model extends CI_model {
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
		$this->db->select ('blog_title.*'); // 关联的文章标题和作者
		$this->db->from ( 'blog_title' );
		$this->db->order_by("blog_title.".$order, "desc");
		$this->db->limit($num,$p);
		$query = $this->db->get ();
		return $query->result_array ();
	}
	function find_by_id ($id) {
		$this->db->where ( 'blog_title.id', $id );
		$this->db->select ( 'blog_title.* , blog_conment.body' );
		$this->db->from ( 'blog_title' );
		$this->db->join ( 'blog_conment', "blog_conment.aid = blog_title.id" ); // a表与b表关联的id
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
		$this->db->from('blog_title');
		$total = $this->db->count_all_results();
		return $total;
	}

	function update($where,$data) {
		$this->db->where ( $where );
		return $this->db->update ( 'blog_title', $data );
	}
	function insert_title($data) {
		$this->db->insert('blog_title', $data);

		return $this->db->insert_id() ? $this->db->insert_id () : FALSE;
	}
	function insert_body($data) {
		$this->db->insert('blog_conment', $data);
	
		return $this->db->insert_id() ? $this->db->insert_id () : FALSE;
	}
	
	function update_title($where,$data) {
		$this->db->where ( $where );
		return $this->db->update ( 'blog_title', $data );
	}
	function update_body($where,$data) {
		$this->db->where ( $where );
		return $this->db->update ( 'blog_conment', $data );
	}
	
	function select_tousu($p = 0,$where=array(),$order = 'date',$num = 10) {
		$this->db->where($where);
		$this->db->select ('blog_tousu.*'); // 关联的文章标题和作者
		$this->db->from ( 'blog_tousu' );
		$this->db->order_by("blog_tousu.".$order, "desc");
		$this->db->limit($num);
		$query = $this->db->get ();
		return $query->result_array ();
	}
	function select_tousu_by_id ($id) {
		$this->db->where ( 'id', $id );
		$query = $this->db->get ("blog_tousu");
		if ($query->num_rows() > 0) {
			$result = $query->result_array ();
			return $result;
		}
		return false;
	}
	function update_tousu($where,$data) {
		$this->db->where ( $where );
		return $this->db->update ( 'blog_tousu', $data );
	}
}