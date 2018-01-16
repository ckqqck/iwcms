<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class BootstrapTable_model extends CI_model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function select_all_num($searchText = '' ,$where = array()) {
		$this->db->where($where);
		if(!empty($searchText)) {
            $likeCriteria = "(member.user_name  LIKE '%".$searchText."%'
                            OR  member.user_tel  LIKE '%".$searchText."%'
                            OR  member.user_id  LIKE '%".$searchText."%')";
        	$this->db->where($likeCriteria);
		}
		$this->db->from('bootstrap_table as member');
		$total = $this->db->count_all_results();
		return $total;
	}
	function select($p = 0,$where=array(),$order = 'user_regtime',$num = 10 ,$searchText = ' ') {
		$this->db->select ('member.user_id,member.user_name,member.user_tel,member.user_regtime'); // 关联的文章标题和作者
		$this->db->from ( 'bootstrap_table as member' );
		if(!empty($searchText)) {
			$likeCriteria = "(member.user_name  LIKE '%".$searchText."%'
                            OR  member.user_tel  LIKE '%".$searchText."%'
                            OR  member.user_id  LIKE '%".$searchText."%')";
			$this->db->where($likeCriteria);
		}
		$this->db->order_by("member.".$order, "desc");
		$this->db->limit($num,$p);
		$query = $this->db->get ();
		return $query->result_array ();
	}
}